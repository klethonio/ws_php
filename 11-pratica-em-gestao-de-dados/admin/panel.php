<?php
session_start();
require('../_app/config.inc.php');

$login = new Login(3);
$action = filter_input(INPUT_GET, 'action', FILTER_DEFAULT);
$view = filter_input(INPUT_GET, 'view', FILTER_DEFAULT);

if(!$login->checkLogin()){
    unset($_SESSION['userLogin']);
    $_SESSION['alert'] = '<b>Ops:</b> Acesso negado! Favor efetuar login para acessar o painel.';
    header('Location: index.php');
    exit;
}else{
    $userLogin = $_SESSION['userLogin'];
}

if($action == 'logout'){
    unset($_SESSION['userLogin']);
    $_SESSION['success'] = '<b>Deslogado:</b> Sua sessão foi finalizada.';
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <title>Site Admin</title>
        <!--[if lt IE 9]>
		   <script src="../_cdn/html5.js"></script> 
		<![endif]-->

		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,800' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" href="css/reset.css" />
		<link rel="stylesheet" href="css/admin.css" />   
    </head>

    <body class="panel">

        <header id="navadmin">
            <div class="content">

                <h1 class="logomarca">Pro Admin</h1>

                <ul class="systema_nav radius">
                    <li class="username">Olá <?= $userLogin['user_name']; ?> <?= $userLogin['user_lastname']; ?></li>
                    <li><a class="icon profile radius" href="panel.php?view=users/profile">Perfíl</a></li>
                    <li><a class="icon users radius" href="panel.php?view=users/index">Usuários</a></li>
                    <li><a class="icon logout radius" href="panel.php?action=logout">Sair</a></li>
                </ul>

                <nav>
                    <h1><a href="panel.php" title="Dasboard">Dashboard</a></h1>

                    <?php
                    //ATIVA MENU
                    if (isset($view)){
                        $linkto = explode('/', $view);
                    } else {
                        $linkto = array();
                    }
                    ?>

                    <ul class="menu">
                        <li class="li<?php if (in_array('posts', $linkto)) echo ' active'; ?>"><a class="opensub" onclick="return false;" href="#">Posts</a>
                            <ul class="sub">
                                <li><a href="panel.php?view=posts/create">Criar Post</a></li>
                                <li><a href="panel.php?view=posts/index">Listar / Editar Posts</a></li>
                            </ul>
                        </li>

                        <li class="li<?php if (in_array('categories', $linkto)) echo ' active'; ?>"><a class="opensub" onclick="return false;" href="#">Categorias</a>
                            <ul class="sub">
                                <li><a href="panel.php?view=categories/create">Criar Categoria</a></li>
                                <li><a href="panel.php?view=categories/index">Listar / Editar Categorias</a></li>
                            </ul>
                        </li> 

                        <li class="li<?php if (in_array('companies', $linkto)) echo ' active'; ?>"><a class="opensub" onclick="return false;" href="#">Empresas</a>
                            <ul class="sub">
                                <li><a href="panel.php?view=companies/create">Cadastrar Empresa</a></li>
                                <li><a href="panel.php?view=companies/index">Listar / Editar Empresas</a></li>
                            </ul>
                        </li>
                        <li class="li"><a href="../" class="opensub">Ver Site</a></li>
                    </ul>
                </nav>

                <div class="clear"></div>
            </div><!--/CONTENT-->
        </header>

        <div id="panel">
            <div class="content">
                <?php require 'system/_partials/_messages.php'; ?>
            </div>
            <?php
            //QUERY STRING
            if (!empty($view)){
                $includePath = __DIR__ . '\\system\\' . strip_tags(trim($view) . '.php');
            } else {
                $includePath = __DIR__ . '\\system\\home.php';
            }

            if (file_exists($includePath)){
                require_once($includePath);
            } else {
                echo "<div class=\"content notfound\">";
                WSMessage("<b>Erro ao incluir tela:</b> Erro ao incluir o controller /{$view}.php!", WS_ERROR);
                echo "</div>";
            }
            ?>
        </div> <!-- painel -->

        <footer class="main_footer">
            <a href="http://www.upinside.com.br/campus" target="_blank" title="Campus UpInside">&copy; Campus UpInside - Todos os Direitos Reservados</a>
        </footer>

    </body>

    <script src="../_cdn/jquery.js"></script>
    <script src="../_cdn/jmask.js"></script>
    <script src="../_cdn/combo.js"></script>
    <script src="__jsc/tiny_mce/tinymce.min.js"></script>
    <script src="__jsc/admin.js"></script>

</html>