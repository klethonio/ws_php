<?php
require './_app/config.inc.php';
// setcookie('user', null, -1, '/');
// session_start();
// unset($_SESSION['user']);
// Service::debug($_SESSION['user']);

$session = new Session;

Service::debug($session, $_SESSION);
// echo '<hr/>';
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <title></title>
    </head>
    <body>
        <?php
        // put your code here
        ?>
    </body>
</html>
