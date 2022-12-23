<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        $use = '24125353293';
        $cpf = '';
        $cpf = '500';
        $cpf = $use;
        $cpf = 'abs';
        $cpf = '24125353203';

        if (!$cpf) {
            trigger_error("Informe seu CPF!", E_USER_NOTICE);
        } elseif ($cpf == '500') {
            trigger_error("Formato não é mais utilizado!", E_USER_DEPRECATED);
        } elseif ($cpf == $use) {
            trigger_error("CPF em uso!", E_USER_WARNING);
        } elseif (!preg_match('/^[0-9]{11}$/', $cpf)) {
            trigger_error("CPF inválido!", E_USER_ERROR);
        } else {
            echo 'CPF válido!';
        }
        echo '<br/>:)<hr/>';
        
        function error($error, $message, $file, $line) {
            $colorError = ($error == E_USER_ERROR ? 'red' : ($error == E_USER_WARNING ? 'darkorange' : 'blue'));
            echo "<p style='color: {$colorError}'>Erro na linha #{$line}: {$message}<br/>";
            echo "<small>{$file}</small>";
            echo "</p>";
            
            if($error == E_USER_ERROR){
                die;
            }
        }
        
        set_error_handler('error');
        
        
        $use = '24125353293';
        $cpf = '';
        $cpf = '500';
        $cpf = $use;
        $cpf = 'abs';
//        $cpf = '24125353203';

        if (!$cpf) {
            trigger_error("Informe seu CPF!", E_USER_NOTICE);
        } elseif ($cpf == '500') {
            trigger_error("Formato não é mais utilizado!", E_USER_DEPRECATED);
        } elseif ($cpf == $use) {
            trigger_error("CPF em uso!", E_USER_WARNING);
        } elseif (!preg_match('/^[0-9]{11}$/', $cpf)) {
            trigger_error("CPF inválido!", E_USER_ERROR);
        } else {
            echo 'CPF válido!';
        }
        echo '<br/>:)<hr/>';
        ?>
    </body>
</html>
