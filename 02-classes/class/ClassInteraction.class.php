<?php

/**
 * <b>Descrição de MoldingClass</b>
 *
 * @author Klethônio Ferreira
 */
class ClassInteraction {
    
    public $name;
    public $age;
    public $profession;
    public $enterprise;
    public $salary;
    public $account;
    
    public function __construct($name, $age, $profession, $account) {
        $this->name = $name;
        $this->age = $age;
        $this->profession = $profession;
        $this->account = $account;
    }

    public function toWork($enterprise, $salary, $profession) {
        $this->enterprise = $enterprise;
        $this->salary = $salary;
        $this->profession = $profession;
    }
    
    public function getPaid($value) {
        $this->account += $value;
    }
}
