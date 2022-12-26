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
        
        $data = ['agent_views' => rand(100, 500)];
        
        $update = new Update;
        
        $update->exeUpdate('ws_siteviews_agent', $data, 'WHERE agent_id = :id', ['id' => 5]);
        
        if($update->count() >= 1){
            echo $update->count() . ' dado(s) Atualizado(s) com sucesso!';
        }
        
        $update->exeNewUpdate(['id' => 6]);
        $update->exeNewUpdate(['id' => 1]);
        $update->exeNewUpdate(['id' => 2]);
        
        echo '<hr/>';
        var_dump($update);
        ?>
    </body>
</html>
