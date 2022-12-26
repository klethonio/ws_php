<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <title></title>
    </head>
    <body>
        <?php
        require './_app/config.inc.php';
        
        $delete = new Delete;
        
        $delete->exeDelete('ws_siteviews_agent', 'WHERE agent_id >= :id', ['id' => 1]);
        
        if($delete->getResult()){
            echo "Query executada! {$delete->getRowCount()} arquivo(s) deletado(s).";
        }
        
        var_dump($delete);
        ?>
    </body>
</html>
