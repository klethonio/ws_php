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
        
        $pdo = new Conn();
        
        $name = 'Chrome';
        $views = 954;
        
        try {
            $qrCreate = "INSERT INTO ws_siteviews_agent (agent_name, agent_views) VALUES (?, ?)";
            
            $create = $pdo->getConn()->prepare($qrCreate);
            
//            $create->bindValue(1, 'IE', PDO::PARAM_STR);
//            $create->bindValue(2, 2, PDO::PARAM_INT);
            
            $create->bindParam(1, $name, PDO::PARAM_STR, 15);
            $create->bindParam(2, $views, PDO::PARAM_INT, 15);
            
        //    $create->execute();
            
            if($create->rowCount()){
                echo "{$pdo->getConn()->lastInsertId()} - Cadastro com sucesso!<hr/>";
            }
            
            $qrSelect = "SELECT * FROM ws_siteviews_agent WHERE agent_views >= :views";
            
            $select = $pdo->getConn()->prepare($qrSelect);
            
            $select->bindValue(':views', 2, pdo::PARAM_INT);
            
            $select->execute();
            if($select->rowCount() >= 1){
                echo "Pesquisa retornou {$select->rowCount()} resultado(s)<hr/>";
                $data = $select->fetchAll(PDO::FETCH_ASSOC);
                var_dump($data);
            }else{
                echo "Nada ainda! <hr/>";
            }
        } catch (PDOException $e) {
            PHPError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
        }
        ?>
    </body>
</html>
