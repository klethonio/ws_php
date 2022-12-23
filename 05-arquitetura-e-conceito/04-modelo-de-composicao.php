<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $klethonio = new CompositionUser('Klethonio Ferreira', 'klethonio@gmail.com');
        $klethonio->addAddress('Coremas', 'PB');
        
        echo "O e-mail de {$klethonio->name} é {$klethonio->email}<br/>";
        echo "{$klethonio->name} mora em {$klethonio->getAddress()->getCity()}-{$klethonio->getAddress()->getState()}<hr/>";
        
        var_dump($klethonio);
        ?>
    </body>
</html>
