<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $klethonio = new AssociationClient('Klethonio Ferreira', 'klethonio@gmail.com');
        $login = new AssociationLogin($klethonio);
        
        if(!$login->getLogin()){
            echo 'Erro ao logar!';
        }else{
            echo "Gerenciando o cliente id: {$login->getClient()->getId()}<br/>";
            echo "{$login->getClient()->getName()} logou com sucesso usando o e-mail {$login->getClient()->getEmail()}<hr/>";
        }
        
        var_dump($klethonio, $login);
        ?>
    </body>
</html>
