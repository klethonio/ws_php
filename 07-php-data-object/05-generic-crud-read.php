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

        $params = ['name' => 'firefox', 'views_int' => 2, 'limit_int' => 1];

        $read = new Read;
        $read->exeRead('ws_siteviews_agent', 'WHERE agent_name = :name AND agent_views >= :views_int LIMIT :limit_int', $params);
        $params = ['name' => 'chrome', 'views_int' => 2, 'limit_int' => 1];
        $read->exeNewRead($params);

        $params = ['name' => 'IE', 'views_int' => 2, 'limit_int' => 1];
        $read->exeNewRead($params);

        if ($read->count() >= 1) {
            var_dump($read->getResult());
        } else {
            echo 'Pesquisa não retornou resultados!';
        }
        echo '<hr/>';

        $read->exeQuery('SELECT * FROM ws_siteviews_agent LIMIT :limit_int', ['limit_int' => 3]);

        var_dump($read);
        ?>
    </body>
</html>
