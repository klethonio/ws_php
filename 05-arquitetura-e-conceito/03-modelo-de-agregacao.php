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
        $prophp = new AggregationProduct(20, 'Pro PHP', 334.9);
        $wsphp = new AggregationProduct(21, 'WS PHP', 289.9);
        $wshtml = new AggregationProduct(22, 'WS HTML5', 289.9);
        
        $outro = new stdClass();
        $outro->id = 23;
        $outro->name = 'jQuery';
        $outro->price = 399.9;
        
        $cart = new AggregationCart($klethonio);
        
        $cart->add($prophp);
        $cart->add($wsphp);
        $cart->add($wshtml);
        
        $cart->remove($wsphp);
        
//        $cart->add($outro);
        
        var_dump($cart);
        echo '<hr/>';
        var_dump($klethonio, $prophp, $outro);
        
        ?>
    </body>
</html>
