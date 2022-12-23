<?php

/**
 * <b>Descrição de ObjectInteraction</b>
 *
 * @author Klethônio Ferreira
 */
class ObjectInteraction {
    
    public $enterprise;
    public $sectors;
    /** @var ClassInteraction */
    public $employee;
    
    public function __construct($enterprise) {
        $this->enterprise = $enterprise;
        $this->sectors = 0;
    }

    public function toHire($employee, $profession, $salary) {
        $this->employee = (object) $employee;
        $this->employee->toWork($this->enterprise, $salary, $profession);
        $this->sectors += 1;
    }
    
    public function toPay() {
        $this->employee->getPaid($this->employee->salary);
    }
    
    public function toPromote($profession, $salary = NULL) {
        $this->employee->profession = $profession;
        if($salary){
            $this->employee->salary = $salary;
        }
    }
    
    public function getEmployee($employee) {
        $this->employee = (object) $employee;
    }
    
    public function toFire($insurance) {
        $this->employee->getPaid($insurance);
        $this->employee->enterprise = NULL;
        $this->employee->salary = NULL;
        $this->employee = NULL;
        $this->sectors += 1;
    }
}
