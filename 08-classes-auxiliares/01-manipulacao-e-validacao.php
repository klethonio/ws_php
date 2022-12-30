<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <title></title>
    </head>
    <body>
        <?php
        require './_app/config.inc.php';
        
        $email = 'klethonio@';
        
        if ($checkEmail = Check::email($email)) {
            echo  'Email válido!<hr/';
        } else {
            var_dump($checkEmail);
            echo  '<br>Email inválido!<hr>';
        }
        
        $url = 'Estamos   -  aprendendo---- #PHP. Veja você como é! Muito fácil? Sim.';
        echo Prepare::slug($url) . '<hr>';
        
        $date = '16/11/2016 14:06:24';
        
        echo Prepare::dateToTimestap($date) . '<hr>';
        
        $string = "Olá mundo cruél, estamos estudando PHP com curso pirateado!";
        
        echo Prepare::shortenString($string, 40, '<small> <a href="#">continuar lendo...</a></small>') . '<hr>';
        echo Prepare::shortenString($string, 40) . '<hr>';
        
        echo Service::catIdByName('artigos') . '<hr>';
        echo Service::catIdByName('esportes') . '<hr>';
    //    echo Prepare::catIdByName('internet');
        
        echo Service::onlineUsers() . ' usuário(s) online!<hr>';
        
        echo Prepare::getImage('google.jpg', 'Google!');
        echo Prepare::getImage('google.jpg', 'Google!', 300);
        echo Prepare::getImage('google.jpg', 'Google!', null, 200);
        ?>
    </body>
</html>
