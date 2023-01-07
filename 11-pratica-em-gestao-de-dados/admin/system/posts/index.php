<?php
if (!class_exists('Login')) :
    header('Location: ../../panel.php');
    exit;
endif;
?>

<div class="content list_content">

    <section>

        <header>
            <h1>Posts:</h1>
        </header>

        <section>
        <?php

        $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
        $postId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        
        if ($action) {
            require '_models/AdminPost.class.php';

            $post = new AdminPost;

            switch ($action) {
                case 'toggle':
                    list($msg, $err) = $post->exeToggleStatus($postId);
                    break;
                
                case 'delete':
                    list($msg, $err) = $post->exeDelete($postId);
                    break;    

                default:
                    list($msg, $err) = ['Operação inválida', WS_ALERT];
                    break;
            }

            $_SESSION[$err] = $msg;
            header('Location: panel.php?view=posts/index');
            exit;
        }
        
        $i = 0;
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $pager = new Pager('view=posts/index');
        $pager->range($page);

        $read = new Read;
        $read->exeRead('ws_posts', 'ORDER BY post_status ASC, post_date DESC LIMIT :limit_int OFFSET :offset_int', ['limit_int' => $pager->getLimit(), 'offset_int' => $pager->getOffset()]); 
        
        if (!$read->getResult()) {
            if ($page && $page != 1) {
                $_SESSION['alert'] = 'Não existem resultados!';
                $pager->returnPage();
            }
            WSMessage('Não existem posts cadastrados!', WS_INFOR);
        } else {
            foreach ($read->getResult() as $post) {
                $i++;
                    extract($post);
        ?>
            <article<?php if ($i % 2 == 0) echo ' class="right" '; ?><?php if (!$post_status) echo ' style="background: #dfdfdf " ';?>>

                <div class="img thumb_small">
                    <?=Prepare::getImage('../_uploads/' . $post_cover, $post_title, 120, 70)?>
                </div>
                <h1><a target="_blank" href="../artigo/<?=$post_name?>" title="Ver Post"><?=Prepare::shortenString($post_title, 40)?></a></h1>
                <ul class="info post_actions">
                    <li><strong>Data:</strong> <?= date('d/m/Y H:i', strtotime($post_date)); ?>Hs</li>
                    <li><a class="act_view" target="_blank" href="../artigo/<?=$post_name?>" title="Ver no site">Ver no site</a></li>
                    <li><a class="act_edit" href="panel.php?view=posts/update&id=<?=$post_id?>" title="Editar">Editar</a></li>
                    <?php if (!$post_status) { ?>
                    <li><a class="act_ative" href="panel.php?view=posts/index&id=<?=$post_id?>&action=toggle" title="Ativar">Ativar</a></li>
                    <?php } else { ?>
                    <li><a class="act_inative" href="panel.php?view=posts/index&id=<?=$post_id?>&action=toggle" title="Inativar">Inativar</a></li>
                    <?php } ?>
                    <li><a class="act_delete" href="panel.php?view=posts/index&id=<?=$post_id?>&action=delete" title="Excluir">Deletar</a></li>
                </ul>

            </article>
        <?php
            }
            echo '<div class="clear"></div>';
            $pager->exePagination('ws_posts');
            echo '<small>Items por página: ' . $pager->renderSelectIpp() . '</small>';
            echo $pager->renderPagination();
        }
        ?>

        </section>
    </section>

    <div class="clear"></div>
</div> <!-- content home -->