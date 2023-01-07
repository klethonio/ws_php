<?php
if (!class_exists('Login')) :
    header('Location: ../../panel.php');
    exit;
endif;
?>

<div class="content cat_list">

    <section>
        <header>
            <h1>Categorias:</h1>
        </header>
        <?php
        $delCat = filter_input(INPUT_GET, 'delete', FILTER_VALIDATE_INT);

        if ($delCat) {
            require '_models/AdminCategory.class.php';
            $delete = new AdminCategory;
            list($msg, $err) = $delete->exeDelete($delCat);

            $_SESSION[$err] = $msg;
            header('Location: panel.php?view=categories/index');
            exit;
        }

        $read = new Read;
        $read->exeRead('ws_categories', "WHERE category_parent IS NULL ORDER BY category_title ASC");

        if (!$read->getResult()) {
            WSMessage('Não existem categorias cadastradas!', WS_INFOR);
        } else {
            foreach ($read->getResult() as $section) {
                extract($section);

                $read->exeRead('ws_categories', "WHERE category_parent = :parent", ['parent' => $category_id]);
                $cats = $read->getResult();
                $countCats = $read->count();

                $read->exeRead('ws_posts', "WHERE post_cat_parent = :parent", ['parent' => $category_id]);
                $contPosts = $read->count();
                ?>
                <section>

                    <header>
                        <h1><?= $category_title ?>:  <span>( <?= $countCats ?> Categorias ) ( <?= $contPosts ?> posts )</span></h1>
                        <p class="tagline"><?= $category_content ?></p>

                        <ul class="info post_actions">
                            <li><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($category_date)) ?></li>
                            <li><a class="act_view" target="_blank" href="../categoria/<?= $category_name ?>" title="Ver no site">Ver no site</a></li>
                            <li><a class="act_edit" href="panel.php?view=categories/update&id=<?= $category_id ?>" title="Editar">Editar</a></li>
                            <li><a class="act_delete" href="panel.php?view=categories/index&delete=<?= $category_id ?>" title="Excluir">Deletar</a></li>
                        </ul>
                    </header>

                    <h2>Subcategorias de <?= $category_title ?>:</h2>

                    <?php
                    if (!$cats) {
                        WSMessage('Esta seção não possui subcategorias!', WS_INFOR);
                    } else {
                        $a = 1;
                        foreach ($cats as $sub) {
                            $read->exeRead('ws_posts', "WHERE post_category = :category", ['category' => $sub['category_id']]);
                            $contSubPosts = $read->count();
                            ?>
                            <article <?php if ($a % 3 == 0) echo ' class="right"'; ?>>
                                <h1><a target="_blank" href="../categoria/<?= $sub['category_name'] ?>" title="Ver Categoria"><?= $sub['category_title'] ?>:</a>  ( <?= $contSubPosts ?> posts )</h1>

                                <ul class="info post_actions">
                                    <li><strong>Data:</strong> <?= date('d/n/Y H:i', strtotime($sub['category_date'])) ?></li>
                                    <li><a class="act_view" target="_blank" href="../categoria/<?= $sub['category_name'] ?>" title="Ver no site">Ver no site</a></li>
                                    <li><a class="act_edit" href="panel.php?view=categories/update&id=<?= $sub['category_id'] ?>" title="Editar">Editar</a></li>
                                    <li><a class="act_delete" href="panel.php?view=categories/index&delete=<?= $sub['category_id'] ?>" title="Excluir">Deletar</a></li>
                                </ul>
                            </article>
                            <?php
                            $a++;
                        }
                    }
                    ?>

                </section>
                <?php
            }
        }
        ?>

        <div class="clear"></div>
    </section>

    <div class="clear"></div>
</div> <!-- content home -->