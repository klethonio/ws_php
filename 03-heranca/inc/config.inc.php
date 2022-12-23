<?php

spl_autoload_register(function ($class) {
    $dirName = 'class';
    
    if(file_exists("{$dirName}/{$class}.class.php")){
        require "{$dirName}/{$class}.class.php";
    }else{
        die("Erro ao incluir {$dirName}/{$class}.class.php<hr/>");
    }
});
