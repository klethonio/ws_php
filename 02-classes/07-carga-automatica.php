<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Carga Automática</title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        $classA = new ClassesObjetos;
        $classB = new AtributesMethods;
        $classC = new InicialBehavior('Klethonio', 22, 'Programador', 3600);
        
        var_dump($classA, $classB, $classC);
        ?>
    </body>
</html>
