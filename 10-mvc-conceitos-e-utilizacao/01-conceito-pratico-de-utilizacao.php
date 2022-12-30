<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        //CONTROLLER
        require('./_app/config.inc.php');

        //MODEL
        $read = new Read;
        $read->exeRead('ws_categories');

        //VIEW
        foreach ($read->getResult() as $cat) {
            extract($cat);
            echo '<article>'
            , "<header><h1>{$category_title}<h1/></header>"
            , "<p>{$category_content}</p>"
            , '</article><hr/>';
        }
        //END VIEW
        //END MODEL
        //END CONTROLLER
        ?>
    </body>
</html>
