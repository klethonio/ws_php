<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $foo = NULL;

        if (!$foo) {
            $e = new Exception("Variável foo é NULL.", E_USER_NOTICE);
        }

        var_dump($e);

        echo '<hr/>';

        try {

            if (!$foo) {
                throw new Exception("Variável foo, novamente, é NULL.", E_USER_NOTICE);
            }
        } catch (Exception $e) {
            echo "<p>Erro #{$e->getCode()}: {$e->getMessage()}<br/>";
            echo "<small>{$e->getFile()} na linha #{$e->getLine()}</small></p>";
            
            echo '<hr/>';
            
            echo $e->xdebug_message;
            
            var_dump($e);
        }
        ?>
    </body>
</html>
