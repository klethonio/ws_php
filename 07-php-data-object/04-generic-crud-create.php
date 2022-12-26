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
        
        $data = ['agent_name' => 'Opera', 'agent_views' => 27];
        
        $create = new Create;
        $create->exeCreate('ws_siteviews_agent', $data);
        
        var_dump($create);
        ?>
    </body>
</html>
