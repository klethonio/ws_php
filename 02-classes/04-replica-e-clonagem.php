<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './class/ReplyClonage.class.php';
        
        $readA = new ReplyClonage('posts', 'category = news', 'ORDER BY data DESC');
        $readA->read();
        
        $readA->setTerms('category = internet');
        $readA->read();
        
        $readB = $readA;
        $readB->setTerms('category = sports');
        $readB->read();
        
        $readC = clone $readA;
        $readC->setTable('comments');
        $readC->setTerms('post = 25');
        $readC->read();
        
        var_dump($readA, $readB, $readC);
        ?>
    </body>
</html>
