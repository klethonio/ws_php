<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './class/ClassesObjetos.class.php';

        $teste = new ClassesObjetos();
        $teste2 = new ClassesObjetos();
        $teste->classInfo('introdução', 'mostrar uma classe');
        $teste->printClass();
        $teste->classe = 'Classe 2';
        $teste->function = 'ver atributos';
        $teste->printClass();
        $teste2->printClass();
        $teste3 = $teste;
        $teste3->printClass();
        $teste4 = clone $teste;
        $teste4->printClass();
        ?>
    </body>
</html>
