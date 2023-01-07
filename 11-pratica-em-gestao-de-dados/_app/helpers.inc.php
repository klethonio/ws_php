<?php

function dd(): void
{
    echo '<pre>';

    foreach (func_get_args() as $var) {
        echo '<hr>';
        var_dump($var);
        echo '<hr>';
    }

    echo '</pre>';
    die;
}
