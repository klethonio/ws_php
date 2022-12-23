<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $klethonio = new ProtectedAccess('Klethonio', 'klethonio@gmail.com');
        
//        $klethonio->email = 'banana';
//        $klethonio->setEmail('banana');
//        $klethonio->setName('kle');
        
        var_dump($klethonio);
        
        echo '<hr/>';
        
        $jose = new ProtectedAccessSub('José', 'jose@gmail.com');
        
        $jose->addCpf('José Ferreira', '111111111-66');
        
        var_dump($jose);
        ?>
    </body>
</html>
