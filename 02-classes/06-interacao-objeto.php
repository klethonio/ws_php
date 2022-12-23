<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './class/ClassInteraction.class.php';
        require './class/ObjectInteraction.class.php';
        
        $klethonio = new ClassInteraction('Klethonio', 22, 'Programador', 130000);
        
        $evh = new ObjectInteraction('EVH Tecnologia');
        $evh->toHire($klethonio, 'Webmaster', 4500);
        $evh->toPay();
        $evh->toPromote('Programador', 7000);
        $evh->toPay();
        $evh->toFire(5600);
        
        var_dump($klethonio, $evh);
        ?>
    </body>
</html>
