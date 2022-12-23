<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $product = new ScopeResolution('Livro de PHP', 59.9);
        $digital = new DigitalScopeResolution('Livro de PHP', 29.9);
        $product->sell();
        $product->sell();
        $product->sell();
        
        $digital->sell();
        $digital->sell();
        
//        $product->report();
        ScopeResolution::report();
        
        var_dump($product, $digital);
        ?>
    </body>
</html>
