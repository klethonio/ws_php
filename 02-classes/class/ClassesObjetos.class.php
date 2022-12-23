<?php

/**
 * <b>Descrição de ClassesObjetos</b>
 *
 * @author Klethônio Ferreira
 */
class ClassesObjetos {
    var $classe;
    var $function;
    
    function classInfo($class, $function) {
        echo "<p>A classe {$class} serve para {$function}.</p>";
    }
    
    function printClass() {
        echo '<pre>';
        var_dump($this);
        echo '</pre>';
    }
}
