<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    exit;
endif;
?>

<div class="content form_create">

    <article>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        $postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $del = filter_input(INPUT_GET, 'del', FILTER_VALIDATE_INT);

        if ($del) {
            require '_models/AdminPost.class.php';

            $post = new AdminPost;
            $post->removeImage($del);
            if (!$post->getResult()) {
                WSMessage($post->getError()[0], $post->getError()[1]);
            } else {
                $_SESSION[$post->getResult()[1]] = $post->getResult()[0];
                header('Location: painel.php?view=posts/update&id=' . $postId);
                exit;
            }
        } elseif (!empty($data['sendPostForm'])) {
            $data['post_status'] = ($data['sendPostForm'] == 'Atualizar' ? '0' : '1');
            unset($data['sendPostForm']);
            $data['post_cover'] = (!empty($_FILES['post_cover']['tmp_name']) ? $_FILES['post_cover'] : 'null');

            require '_models/AdminPost.class.php';

            $upPost = new AdminPost;
            $upPost->exeUpdate($postId, $data);

            if (!$upPost->getResult()) {
                WSMessage($upPost->getError()[0], $upPost->getError()[1]);
            } else {
                if (!empty($_FILES['gallery_covers']['tmp_name'][0])) {
                    $upPost->uploadGallery($postId, $_FILES['gallery_covers']);
                }

                if (!$upPost->getResult()) {
                    $_SESSION[$upPost->getError()[1]] = $upPost->getError()[0];
                }

                $_SESSION['success'] = "O post <b>{$data['post_title']}</b> foi atualizado  no sistema.";
                header('Location: painel.php?view=posts/update&id=' . $postId);
                exit;
            }
            
        } else {
            $read = new Read;
            $read->exeRead("ws_posts", "WHERE post_id = :id_int", ['id_int' => $postId]);

            if (!$read->getResult()) {
                $_SESSION['alert'] = 'Você tentou editar um artigo que não existe no sistema.';
                header('Location: painel.php?view=posts/index');
                exit;
            } else {
                $data = $read->first();
                $data['post_date'] = date('d/m/Y H:i:s', strtotime($data['post_date']));
            }
        }
        ?>

        <header>
            <h1>Criar Post:</h1>
        </header>

        <form name="PostForm" action="" method="post" enctype="multipart/form-data">

            <label class="label">
                <span class="field">Enviar Capa:</span>
                <input type="file" name="post_cover" />
            </label>

            <label class="label">
                <span class="field">Título:</span>
                <input type="text" name="post_title" value="<?php if (isset($data['post_title'])) echo $data['post_title']; ?>" />
            </label>

            <label class="label">
                <span class="field">Conteúdo:</span>
                <textarea class="js_editor" name="post_content" rows="10"><?php if (isset($data['post_content'])) echo htmlspecialchars($data['post_content']); ?></textarea>
            </label>

            <div class="label_line">

                <label class="label_small">
                    <span class="field">Data:</span>
                    <input type="text" class="formDate center" name="post_date" value="<?php
                    if (isset($data['post_date'])) {
                        echo $data['post_date'];
                    } else {
                        echo date('d/m/Y H:i:s');
                    }
                    ?>" />
                </label>

                <label class="label_small">
                    <span class="field">Categoria:</span>
                    <select name="post_category">
                        <option value=""> Selecione a categoria:</option>
                        <?php
                        $read->exeRead('ws_categories', 'WHERE category_parent IS NULL ORDER BY category_title ASC');
                        if ($read->getResult()) {
                            foreach ($read->getResult() as $sec) {
                                echo "<optgroup label=\"{$sec['category_title']}\">";
                                $read->exeRead('ws_categories', "WHERE category_parent = :parent ORDER BY category_title ASC", ['parent' => $sec['category_id']]);
                                if (!$read->getResult()) {
                                    echo '<option disabled>Seção sem categorias!</option>';
                                } else {
                                    foreach ($read->getResult() as $cat) {
                                        extract($cat);
                                        echo "<option ";
                                        if ($data['post_category'] == $cat['category_id']) {
                                            echo 'selected ';
                                        }
                                        echo "value=\"{$category_id}\">&raquo; {$category_title}</option>";
                                    }
                                }
                                echo '</optgroup>';
                            }
                        }
                        ?>
                    </select>
                </label>

                <label class="label_small">
                    <span class="field">Author:</span>
                    <select name="post_author">
                        <option value="<?= $userLogin['user_id'] ?>"> <?= "{$userLogin['user_name']} {$userLogin['user_lastname']}"; ?> </option>
                        <?php
                        $read->exeRead('ws_users', "WHERE user_id != :id AND user_level >= 2 ORDER BY user_name ASC", ['id' => $userLogin['user_id']]);
                        if ($read->getResult()) {
                            foreach ($read->getResult() as $aut) {
                                echo "<option ";
                                if ($data['post_author'] == $aut['user_id']) {
                                    echo 'selected ';
                                }
                                echo "value=\"{$aut['user_id']}\">{$aut['user_name']} {$aut['user_lastname']}</option>";
                            }
                        }
                        ?>
                    </select>
                </label>

            </div><!--/line-->

            <div class="label gbform" id="gbform">

                <label class="label">             
                    <span class="field">Enviar Galeria:</span>
                    <input type="file" multiple name="gallery_covers[]" />
                </label>

                <ul class="gallery">
                    <?php
                    $i = 0;
                    $read->exeRead('ws_posts_gallery', 'WHERE post_id = :id_int', ['id_int' => $postId]);
                    if ($read->getResult()) {
                        foreach ($read->getResult() as $image) {
                        $i++
                    ?>
                        <li<?php if ($i % 5 == 0) echo ' class="right"'; ?>>
                            <div class="img thumb_small">
                                <?=Prepare::getImage('../_uploads/' . $image['gallery_image'], $i, 146, 100)?>
                            </div>
                            <a class="del" href="painel.php?view=posts/update&id=<?=$postId?>&del=<?=$image['gallery_id']?>" onclick="return confirm('Tem certeza que deseja realizar essa operação?')">Deletar</a>                    
                        </li>
                    <?php
                        }
                    }
                    ?>
                </ul>                
            </div>


            <input type="submit" class="btn blue" value="Atualizar" name="sendPostForm" />
            <input type="submit" class="btn green" value="Atualizar & Publicar" name="sendPostForm" />

        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content home -->