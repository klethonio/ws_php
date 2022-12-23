<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <h3>Tratamento por existência: </h3>
        <hr/>
        <?php
        $string = 'contato';
        $string = 3;
        $string = '';
        if (!is_string($string)) {
            echo "String não é uma string.";
        } elseif (is_string($string)) {
            echo "String é uma string.";
        }
        echo '<hr/>';
        if (!empty($string)) {
            echo "String existe e tem valor.";
        } else {
            echo "String existe mas está em branco.";
        }
        ?>
        <hr/><hr/>
        <h3>Tomada de decição: </h3>
        <hr/>
        <?php
        $decisao = 'contato';
        $decisao = 'klethonio_@hotmail.com';
        $decisao = 'klethonio@gmail.com';
        if (!filter_var($decisao, FILTER_VALIDATE_EMAIL)) {
            echo "E-mail informado é inválido!";
        } elseif ($decisao == 'klethonio_@hotmail.com') {
            die("Esse é um e-mail restrigo.");
        } else {
            echo "E-mail válido!";
        }
        ?>
        <hr/><hr/>
        <h3>Retorno de flags: </h3>
        <hr/>
        <?php

        function idade($idade = NULL) {
            if (!$idade) {
                return FALSE;
            } elseif (!is_int($idade)) {
                return FALSE;
            } else {
                return 'Você nasceu em: ' . (date('Y') - $idade);
            }
        }

        $idade = 'abs';
        $idade = '23';
        $idade = 23;

        if (idade($idade)) {
            echo idade($idade);
        } else {
            echo "Informe um inteiro.";
        }
        ?>
        <hr/><hr/>
        <h3>Retorno de flags: </h3>
        <hr/>
        <?php
        $um = 10;
        $dois = '10';

        if ($um == $dois) {
            echo "Um tem o mesmo valor de dois";
        } elseif ($um != $dois) {
            echo "Um e dois têm valores diferentes";
        }

        echo '<hr/>';

        $um = 10;
        $dois = 10;

        if ($um === $dois) {
            echo 'Um e dois tem o mesmo valor e são do mesmo tipo';
        } elseif ($um !== $dois) {
            echo 'Um e dois têm valores e/ou tipos diferentes';
        }
        ?>
    </body>
</html>
