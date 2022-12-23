<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './class/InicialBehavior.class.php';
        
        $klethonio = new InicialBehavior('Klethonio', 22, 'Programador', 5000);
        $jose = new InicialBehavior('José', 18, 'Programador', 1500);
        $marcos = new InicialBehavior('Marcos', 29, 'Programador', 3600);
        
        $klethonio->write();
        
        unset($jose);
        
        echo '<hr/>br<hr/>';
        ?>
    </body>
</html>
