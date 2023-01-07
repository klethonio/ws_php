<?php
if (!class_exists('Login')) :
    header('Location: ../../panel.php');
    exit;
endif;
?>

<div class="content form_create">

    <article>

        <header>
            <h1>Criar Categoria:</h1>
        </header>

        <?php
        $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);

        if (!empty($data['sendPostForm'])) {
            unset($data['sendPostForm']);

            require '_models/AdminCategory.class.php';
            $ctCat = new AdminCategory;
            $category = $ctCat->exeCreate($data);

            if (!$ctCat->getResult()) {
                WSMessage($ctCat->getError()[0], $ctCat->getError()[1]);
            }else{
                $type = empty($data['category_parent']) ? 'seção' : 'categoria';
                $_SESSION['success'] = "A {$type} <b>{$data['category_title']}</b> foi cadastada com sucesso.";
                header('Location: panel.php?view=categories/index');
            }
        }
        ?>

        <form name="postForm" action="" method="post" enctype="multipart/form-data">


            <label class="label">
                <span class="field">Título:</span>
                <input type="text" name="category_title" value="<?php if (isset($data)) echo $data['category_title']; ?>" />
            </label>

            <label class="label">
                <span class="field">Conteúdo:</span>
                <textarea name="category_content" rows="5"><?php if (isset($data)) echo $data['category_content']; ?></textarea>
            </label>

            <div class="label_line">

                <label class="label_small">
                    <span class="field">Data:</span>
                    <input type="text" class="formDate center" name="category_date" value="<?= date('d/m/Y H:i:s'); ?>" />
                </label>

                <label class="label_small left">
                    <span class="field">Seção:</span>
                    <select name="category_parent">
                        <option value="null"> Selecione a Seção: </option>
                        <?php
                        $read = new Read();
                        $read->exeRead('ws_categories', 'WHERE category_parent IS NULL ORDER BY category_title ASC');
                        if (!$read->getResult()) {
                            echo '<option disabled> Cadastre uma seção</option>';
                        } else {
                            foreach ($read->getResult() as $sec) {
                                echo "<option value=\"{$sec['category_id']}\"";
                                if ($sec['category_id'] == ($data['category_parent'] ?? null)) {
                                    echo ' selected';
                                }
                                echo ">{$sec['category_title']}</option>";
                            }
                        }
                        ?>
                    </select>
                </label>
            </div>

            <div class="gbform"></div>

            <input type="submit" class="btn green" value="Cadastrar Categoria" name="sendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content home -->