<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './interface/IStudent.php';
        require './inc/config.inc.php';
        
        $student = new InterfaceWork('Klethônio Ferreira', 'Pro PHP');
        $student->form();
        $student->enroll('WS PHP');
        $student->form();
        
        var_dump($student);        
        ?>
    </body>
</html>
