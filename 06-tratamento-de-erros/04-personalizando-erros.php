<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="css/reset.css"/>
        <title>WS PHP - Personalizando Erros</title>
    </head>
    <body>
        <?php
        require './_app/config.inc.php';

        trigger_error("Esse é um NOTICE.", E_USER_NOTICE);
        trigger_error("Esse é um WARNING.", E_USER_WARNING);
//        trigger_error("Esse é um ERROR.", E_USER_ERROR);
        PHPError(WS_ERROR, "Esse é um ERROR personalizado.", __FILE__, __LINE__);

        WSError("Esse é um SUCCESS", WS_SUCCESS);
        
        try {
            throw new Exception("Essa é uma exceção!", E_USER_WARNING);
        } catch (Exception $e) {
            PHPError($e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine());
            WSError($e->getMessage(), $e->getCode());
            WSError($e->getMessage(), WS_SUCCESS);
        }
        ?>
    </body>
</html>
