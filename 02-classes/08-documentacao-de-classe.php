<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $document = new ClassDocumentation('EVH Tecnologia');
        $klethonio = new ClassInteraction('Klethonio', 22, 'Programador', 2000);
        
        $document->toHire($klethonio, 'Webmaster', 3500);
        ?>
    </body>
</html>
