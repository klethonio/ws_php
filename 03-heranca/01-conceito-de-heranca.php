<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        require './inc/config.inc.php';
        
        $person = new Inheritance('Klethonio', 22);
        $person->toForm('Pro PHP');
        $person->toForm('WS PHP');
        $person->getOlder();
        echo $person->personInfo();
                
        var_dump($person);
        echo '<hr/>';
        
        $legalPerson = new LegalInheritance('Klethônio Ferreira', 22, 'EVH Tecnologia');
        $legalPerson->toForm('Pro PHP');
        $legalPerson->toForm('WS PHP');
        $legalPerson->getOlder();
        echo $legalPerson->personInfo();
        
        $legalPerson->toHire('José');
        $legalPerson->toHire('Allane');
        echo $legalPerson->enterpriseInfo();
        
        var_dump($legalPerson);
        ?>
    </body>
</html>
