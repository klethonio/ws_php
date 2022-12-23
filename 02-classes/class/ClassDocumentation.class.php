<?php

/**
 * <b>ObjectInteraction</b>
 * Essa classe foi criada para mostrar a interação de objetos.
 * Logo depois replicamos ela para ver sobre a documentação de classes com PHPDoc.
 * @author Klethônio Ferreira
 */
class ClassDocumentation {
    /** @var string Nome da empresa */
    public $enterprise;
    /** 
     * Esse atributo é auto gerido pela classe e incrementa o número de funcionários.
     * @var int Número de funcionários
     */
    public $sectors;
    /** @var ClassInteraction Objecto de ClassInteraction */
    public $employee;
    
    //Connstrói a classe requisitando o nome da empresa.
    public function __construct($enterprise) {
        $this->enterprise = $enterprise;
        $this->sectors = 0;
    }

    /** 
     * <b>Contratar funcionário: </b> Informe um objeto da classe ClassInteraction, o cargo e o salário.
     * @param object $employee = Objeto de ClassInteraction
     * @param string $profession = Profissão ou cargo a ocupar
     * @param type $salary = Salário do funcionário
     */
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
