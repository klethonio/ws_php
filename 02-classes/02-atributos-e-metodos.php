<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './class/AtributesMethods.class.php';
        
        $person = new AtributesMethods();
        $person->setUser('Klethonio', 22, 'Webmaster');
        echo $person->getUser();
        echo '<hr/>';
        $person->getOlder();
        $person->getOlder();
        $person->getOlder();
        $person->getClass();
        ?>
    </body>
</html>
