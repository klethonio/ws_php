<?php

/**
 * <b>Descrição de incialBehavior</b>
 *
 * @author Klethônio Ferreira
 */
class InicialBehavior {
    var $name, $age, $profession, $salary;
    
    public function __construct($name, $age, $profession, $salary) {
        $this->name = (string) $name;
        $this->age = (float) $age;
        $this->profession = (string) $profession;
        $this->salary = (float) $salary;
        echo "O objeto {$this->name} foi iniciado.<hr/>";
    }
    
    public function __destruct() {
        echo "O objeto {$this->name} foi destruído.<hr/>";
    }
    
    function write() {
        var_dump($this);
    }
}
