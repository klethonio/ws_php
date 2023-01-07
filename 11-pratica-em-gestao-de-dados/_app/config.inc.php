<?php

include 'helpers.inc.php';

// APP CONFIG
define('HOME', 'http://localhost/11-pratica-em-gestao-de-dados');
define('HOST', 'localhost');
define('USER', 'root');
define('PASS', '');
define('DBSA', 'wsphp');

// CSS :: ERROR MESSAGES
define('WS_SUCCESS', 'success');
define('WS_INFOR', 'infor');
define('WS_ALERT', 'alert');
define('WS_ERROR', 'error');

// AUTOLOAD CLASS
spl_autoload_register(function ($class)
{
    $dir = dir(__DIR__);
    while ($dirName = $dir->read()) {
        if (is_dir(__DIR__ . '/' . $dirName) && $dirName != '.' && $dirName != '..') {
            if (file_exists(__DIR__ . "\\{$dirName}\\{$class}.class.php")) {
                include_once __DIR__ . "\\{$dirName}\\{$class}.class.php";
                return;
            }
        }
    }

    trigger_error("Could not include {$class}.class.php", E_USER_ERROR);
});

// ERROR TREATMENT

//WSError :: IT SHOWS TRIGGERED ERRORS  :: FRONT
function WSMessage($errMsg, $errNo, $errDie = false)
{
    $cssClass = ($errNo == E_USER_NOTICE ? WS_INFOR : ($errNo == E_USER_WARNING ? WS_ALERT : ($errNo == E_USER_ERROR ? WS_ERROR : $errNo)));
    echo "<p class=\"trigger {$cssClass}\">{$errMsg}<span class=\"ajax_close\"></span></p>";
    if ($errDie) {
        die;
    }
}

//PHPError :: CUSTOMIZE PHP TRIGGER
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