<?php
session_start();
require('../_app/Config.inc.php');
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Site Admin</title>

        <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css'>
        <link rel="stylesheet" href="css/reset.css" />
        <link rel="stylesheet" href="css/admin.css" />

    </head>
    <body class="login">

        <div id="login">
            <div class="boxin">
                <h1>Administrar Site</h1>

                <?php
                require 'system/_partials/_messages.php';
                $login = new Login(3);

                if ($login->checkLogin()) {
                    header('Location: panel.php');
                    exit;
                }

                $dataLogin = filter_input_array(INPUT_POST, FILTER_DEFAULT);
                if (!empty($dataLogin['adminLogin'])) {
                    $login->exeLogin($dataLogin);
                    if (!$login->getResult()) {
                        WSMessage($login->getError()[0], $login->getError()[1]);
                    } else {
                        header('Location: panel.php');
                        exit;
                    }
                }
                ?>

                <form name="adminLoginForm" action="" method="post">
                    <label>
                        <span>E-mail:</span>
                        <input name="user" type="email" />
                    </label>

                    <label>
                        <span>Senha:</span>
                        <input name="password" type="password" />
                    </label>  

                    <input name="adminLogin" type="submit" value="Logar" class="btn blue" />

                </form>
            </div>
        </div>

    </body>
</html>