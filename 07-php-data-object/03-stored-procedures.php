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
        $conn = new Conn;

        try {
            $qrSelect = "SELECT * FROM ws_siteviews_agent WHERE agent_name = :name";
            $select = $conn->getConn()->prepare($qrSelect);
            
            $select->bindValue(':name', 'Chrome', PDO::PARAM_STR);
            $select->execute();
            
            $chrome = $select->fetchAll(PDO::FETCH_ASSOC);
            
            $select->bindValue(':name', 'Firefox', PDO::PARAM_STR);
            $select->execute();
            
            $firefox = $select->fetch(PDO::FETCH_ASSOC);
            
        } catch (Exception $e) {
            PHPError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
        }
        if($chrome){
            // var_dump($chrome);
            $chrome = $chrome[0];
            echo "{$chrome['agent_name']} tem {$chrome['agent_views']} visita(s).<hr/>";
        }
        if($firefox){
            // var_dump($firefox);
            echo "{$firefox['agent_name']} tem {$firefox['agent_views']} visita(s).<hr/>";
        }
        ?>
    </body>
</html>
