<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    exit;
endif;
?>

<div class="content form_create">

    <article>

        <header>
            <h1>Criar Post:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
        
        if (!empty($data['sendPostForm'])) {
            $data['post_status'] = $data['sendPostForm'] == 'Cadastrar' ? '0' : '1';
            unset($data['sendPostForm']);
            $data['post_cover'] = ($_FILES['post_cover']['tmp_name'] ? $_FILES['post_cover'] : null);
            
            require '_models/AdminPost.class.php';
            
            $addPost = new AdminPost;
            $post = $addPost->exeCreate($data);

            if (!$addPost->getResult()) {
                WSMessage($addPost->getError()[0], $addPost->getError()[1]);
            } else {
                if (!empty($_FILES['gallery_covers']['tmp_name'][0])) {
                    $addPost->uploadGallery($post['post_id'], $_FILES['gallery_covers']);
                }

                if (!$addPost->getResult()) {
                    $_SESSION[$addPost->getError()[1]] = $addPost->getError()[0];
                }

                $_SESSION['success'] = "O post <b>{$post['post_title']}</b> foi cadastado com sucesso.";
                header('Location: painel.php?view=posts/update&id=' . $post['post_id']);
                exit;
            }
        }
        ?>


        <form name="PostForm" action="" method="post" enctype="multipart/form-data">

            <label class="label">
                <span class="field">Enviar Capa:</span>
                <input type="file" name="post_cover" />
            </label>

            <label class="label">
                <span class="field">Título:</span>
                <input type="text" name="post_title" value="<?= $data['post_title'] ?? null ?>" />
            </label>

            <label class="label">
                <span class="field">Conteúdo:</span>
                <textarea class="js_editor" name="post_content" rows="10"><?= !empty($data['post_content']) ? htmlspecialchars($data['post_content']) : null ?></textarea>
            </label>

            <div class="label_line">

                <label class="label_small">
                    <span class="field">Data:</span>
                    <input type="text" class="formDate center" name="post_date" value="<?= !empty($data['post_date']) ? $data['post_date'] : date('d/m/Y H:i:s') ?>" />
                </label>

                <label class="label_small">
                    <span class="field">Categoria:</span>
                    <select name="post_category">
                        <option value=""> Selecione a categoria:</option>
                        <?php
                        $read = new Read;
                        $read->exeRead('ws_categories', 'WHERE category_parent IS NULL ORDER BY category_title ASC');
                        if ($read->getResult()) {
                            foreach ($read->getResult() as $sec) {
                                echo "<optgroup label=\"{$sec['category_title']}\">";
                                $read->exeRead('ws_categories', "WHERE category_parent = :parent_int ORDER BY category_title ASC", ['parent_int' => $sec['category_id']]);
                                if (!$read->getResult()) {
                                    echo '<option disabled>Seção sem categorias!</option>';
                                } else {
                                    foreach ($read->getResult() as $cat) {
                                        extract($cat);
                                        echo "<option value=\"{$category_id}\"";
                                        if ($cat['category_id'] == ($data['post_category'] ?? null)) {
                                            echo ' selected';
                                        }
                                        echo ">&raquo; {$category_title}</option>";
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
                        $read->exeRead('ws_users', "WHERE user_id != :id_int AND user_level >= 2 ORDER BY user_name ASC", ['id_int' => $userLogin['user_id']]);
                        if ($read->getResult()) {
                            foreach ($read->getResult() as $aut) {
                                echo "<option ";
                                if ($aut['user_id'] == $data['post_author'] ?? null) {
                                    echo 'selected ';
                                }
                                echo "value=\"{$aut['user_id']}\">{$aut['user_name']} {$aut['user_lastname']}</option>";
                            }
                        }
                        ?>
                    </select>
                </label>

            </div><!--/line-->

            <div class="label gbform">

                <label class="label">             
                    <span class="field">Enviar Galeria:</span>
                    <input type="file" multiple name="gallery_covers[]" />
                </label>               
            </div>


            <input type="submit" class="btn blue" value="Cadastrar" name="sendPostForm" />
            <input type="submit" class="btn green" value="Cadastrar & Publicar" name="sendPostForm" />

        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content home -->