<?php

/**
 * <b>Descrição de LegalInheritance</b>
 *
 * @author Klethônio Ferreira
 */
class LegalInheritance extends Inheritance {
    
    public $enterprise;
    public $staff;
    
    public function __construct($name, $age, $enterprise) {
        parent::__construct($name, $age);
        $this->enterprise = $enterprise;
    }
    
    public function toHire($employee) {
        echo "A empresa {$this->enterprise} de {$this->name} contratou {$employee}.<hr/>";
        $this->staff += 1;
    }
    
    public function enterpriseInfo() {
        return "{$this->enterprise} foi fundada por {$this->name} e tem {$this->staff} funcionários.<br><small style=\"color: #09f;\">".$this->personInfo()."}</small>";
    }
    
}
