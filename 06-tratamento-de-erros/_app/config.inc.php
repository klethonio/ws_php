<?php

// CONFIGURAÇÕES DO SITE ####################
// AUTO LOAD DE CLASSES #####################

spl_autoload_register(function ($class) {
    $dirName = 'class';
    
    if(file_exists("{$dirName}/{$class}.class.php")){
        require "{$dirName}/{$class}.class.php";
    }else{
        die("Erro ao incluir {$dirName}/{$class}.class.php<hr/>");
    }
});

// TRATAMENTO DE ERROS ######################
//CSS constantes :: Mensasagens de Erro
define('WS_SUCCESS', 'success');
define('WS_INFOR', 'infor');
define('WS_ALERT', 'alert');
define('WS_ERROR', 'error');

//WSError :: Exibe erros lançados :: Front
function WSError($errMsg, $errNo, $errDie = NULL) {
    $cssClass = ($errNo == E_USER_NOTICE ? WS_INFOR : ($errNo == E_USER_WARNING ? WS_ALERT : ($errNo == E_USER_ERROR ? WS_ERROR : $errNo)));
    echo "<p class=\"trigger {$cssClass}\">{$errMsg}<span class=\"ajax_close\"></span></p>";
    if ($errDie) {
        die;
    }
}

//PHPError :: Personaliza o gatilho do PHP
function PHPError($errNo, $errMsg, $errFile, $errLine) {
    $cssClass = ($errNo == E_USER_NOTICE ? WS_INFOR : ($errNo == E_USER_WARNING ? WS_ALERT : ($errNo == E_USER_ERROR ? WS_ERROR : $errNo)));
    echo "<p class=\"trigger {$cssClass}\">";
    echo "<b>Erro na Linha #{$errLine}::</b> {$errMsg}<br/>";
    echo "<small>{$errFile}</small>";
    echo "<span class=\"ajax_close\"></span></p>";

    if ($errNo == E_USER_ERROR) {
        die;
    }
}

set_error_handler('PHPError');