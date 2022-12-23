<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $klethonio = new PublicAccess('Klethônio Ferreira', 'klethonio@gmail.com');
        $klethonio->email = 'banana';
        
        var_dump($klethonio);
        ?>
    </body>
</html>
