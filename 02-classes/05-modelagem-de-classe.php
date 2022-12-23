<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './class/MoldingClass.classs.php';
        
        $klethonio = new MoldingClass('Klethonio', 22, 'Programador', 5000);
        $klethonio->setProfession('Engenheiro Civil');
        $klethonio->toWork('Portal', 12000);
        
        
        var_dump($klethonio);
        ?>
    </body>
</html>
