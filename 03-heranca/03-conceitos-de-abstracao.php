<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
//        $account = new Abstraction('Klethonio', 7300);
//        $accountTwo = new Abstraction('José', 300);
//        $account->deposit(1000);
//        $account->withdraw(500);
//        $account->transfer(500, $accountTwo);
//        
//        var_dump($account, $accountTwo);
        
        $ca = new AbstractionCA('Klethônio', 0, 3000);
        $sa = new AbstractionSA('Klethônio', 2200);
        
        $ca->deposit(1000);
        $ca->withdraw(300);
        $ca->transfer(500, $sa);
        
        $sa->deposit(1000);
        $sa->withdraw(300);
        $sa->transfer(500, $ca);
        
        $ca->balanceInfo();
        $sa->balanceInfo();
        
        var_dump($ca, $sa);
        ?>
    </body>
</html>
