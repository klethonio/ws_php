<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $boleto = new Polymorphism('Pro PHP', 334.9);
        $boleto->toPay();
        
        var_dump($boleto);
        echo '<hr/>';
        
        $deposit = new PolymorphismDeposit('Pro PHP', 334.9);
        $deposit->toPay();
        
        var_dump($deposit);
        echo '<hr/>';
        
        $card = new PolymorphismCard('Pro PHP', 334.9);
        $card->toPay();
        $card->toPay(10);
        
        var_dump($card);
        ?>
    </body>
</html>
