<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $client = new DinamicObject;
        
        $klethonio = new stdClass();
        $klethonio->name = 'Klethonio Ferreira';
        $klethonio->email = 'klethonio@gmail.com';
        
        $client->newClient($klethonio);
        
        $jose = clone $klethonio;
        $jose->name = 'José Ferreira';
        $jose->email = 'banana';
        
        var_dump($client, $klethonio, $jose);
        ?>
    </body>
</html>
