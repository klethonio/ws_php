<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <title></title>
        <style>
            .pagination{
                list-style: none;
            }
            .pagination > li{
                display: inline-block;
                border: 1px solid black;
                /* background: #ddd; */
                padding: 1px 5px;
                /* border-radius: 5px; */
                margin: 0 2px;
            }
            .pagination > li:hover{
                background: black;
            }
            .pagination > li > a{
                text-decoration: none;
                color: black;
            }
            .pagination > li:hover > a{
                text-decoration: none;
                color: white !important;
            }
            .hidden-page{
                background: #fff !important;
                position: relative;
                cursor: default;
            }
            .pagination .current-page{
                background: black;
                color: #fff;
                font-weight: bold;
            }
            .ul-hidden-page{
                list-style: none;
                display: none;
                position: absolute;
                max-width: 200px;
                padding: 0;
                border: 1px solid black;
                background: #ddd;
                text-align: center;
                z-index: 9999;
                border-spacing: 4px;
            }
            .ul-hidden-page li a{
                display: table-cell;
                min-width: 30px;
                height: 20px;
                text-align: center;
                border: 1px solid black;
            }
            .hidden-page:hover > .ul-hidden-page{
                display: block;
            }
        </style>
    </head>
    <body>
        <?php
        require './_app/config.inc.php';

        $page = filter_input(INPUT_GET, 'page', FILTER_VALIDATE_INT);

        // $pager = new Pager('http://localhost/08-classes-auxiliares/04-gestao-de-resultados.php?page=', 'Primeira', 'Última', 1);
        $ipp = 30;
        
        $pager = new Pager();
        $pager->range($page);

        $read = new Read();
        $read->exeRead('app_cidades', 'LIMIT :limit_int OFFSET :offset_int', ['limit_int' => $pager->getLimit(), 'offset_int' => $pager->getOffset()]);
        
        $pager->exePagination('app_cidades');

        echo $pager->renderSelectIpp();
        echo $pager->renderPagination();

        echo '<hr/>';

        if (!$read->count()) {
            $pager->returnPage();
            WSMessage('Não existem resultados!', E_NOTICE);
        } else {
            var_dump($read->getResult());
        }

        echo '<hr>';

        var_dump($pager);
        ?>
    </body>
</html>
