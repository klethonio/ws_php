<?php
if (!class_exists('Login')) :
    header('Location: ../../panel.php');
    exit;
endif;
?>

<div class="content list_content">

    <section class="list_emp">

        <h1>Empresas:</h1>      

        <?php
        // $empty = filter_input(INPUT_GET, 'empty', FILTER_VALIDATE_BOOLEAN);
        // if ($empty):
        //     WSErro("Oppsss: Você tentou editar uma empresa que não existe no sistema!", WS_INFOR);
        // endif;

        $action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
        $companyId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if ($action){
            require ('_models/AdminCompany.class.php');

            $company = new AdminCompany();

            switch ($action){
                case 'toggle':
                    list($msg, $err) = $company->exeToggleStatus($companyId);
                    break;

                case 'delete':
                    list($msg, $err) = $company->exeDelete($companyId);
                    break;

                default :
                list($msg, $err) = ['Operação inválida', WS_ALERT];
                break;
            }

            $_SESSION[$err] = $msg;
            header('Location: panel.php?view=companies/index');
            exit;
        }

        $i = 0;
        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);
        $pager = new Pager('view=companies/index');
        $pager->range($page);

        $read = new Read;

        $read->exeRead("app_companies", "ORDER BY company_status ASC, company_title ASC LIMIT :limit_int OFFSET :offset_int", ['limit_int' => $pager->getLimit(), 'offset_int' => $pager->getOffset()]);
        if (!$read->getResult()) {
            if ($page && $page != 1) {
                $_SESSION['alert'] = 'Não existem resultados!';
                $pager->returnPage();
            }
            WSMessage('Não existem empresas cadastradas!', WS_INFOR);
        } else {
            foreach ($read->getResult() as $company) {
                $i++;
                extract($company);
                $status = (!$company_status ? 'style="background: #fffed8"' : '');

                $read->exeRead("app_states", "WHERE state_id = :state", ['state' => $company_state]);
                $state = ($read->getResult() ? $read->first()['state_uf'] : 'null');

                $read->exeRead("app_cities", "WHERE city_id = :city", ['city' => $company_city]);
                $city = ($read->getResult() ? $read->first()['city_name'] : 'null');
                ?>
                <article<?php if ($i % 2 == 0) echo ' class="right"'; ?> <?=$status?>>
                    <header>

                        <div class="img thumb_small">
                            <?= Prepare::getImage('../_uploads/' . $company_capa, $company_title, 120, 70); ?>
                        </div>

                        <hgroup>
                            <h1><a target="_blank" href="../empresa/<?=$company_name?>" title="Ver Empresa"><?=$company_title?></a></h1>
                            <h2><?=$city . ' / ' . $state?></h2>
                        </hgroup>
                    </header>
                    <ul class="info post_actions">
                        <li><strong>Data:</strong> <?=date('d/m/Y H:i', strtotime($company_date))?>Hs</li>
                        <li><a class="act_view" target="_blank" href="../empresa/<?=$company_name?>" title="Ver no site">Ver no site</a></li>
                        <li><a class="act_edit" href="panel.php?view=companies/update&id=<?=$company_id?>" title="Editar">Editar</a></li>
                        <?php if (!$company_status){ ?>
                            <li><a class="act_ative" href="panel.php?view=companies/index&id=<?=$company_id?>&action=toggle" title="Ativar">Ativar</a></li>
                        <?php } else { ?>
                            <li><a class="act_inative" href="panel.php?view=companies/index&id=<?=$company_id?>&action=toggle" title="Inativar">Inativar</a></li>
                        <?php } ?>
                        <li><a class="act_delete" href="panel.php?view=companies/index&id=<?=$company_id?>&action=delete" title="Excluir">Deletar</a></li>
                    </ul>
                </article>
                <?php
            }
            echo '<div class="clear"></div>';
            $pager->exePagination('app_companies');
            echo '<small>Items por página: ' . $pager->renderSelectIpp() . '</small>';
            echo $pager->renderPagination();
        }
        ?>

        <div class="clear"></div>
    </section>

    <div class="clear"></div>
</div> <!-- content home -->