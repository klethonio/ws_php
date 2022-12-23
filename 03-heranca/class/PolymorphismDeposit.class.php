<?php

/**
 * <b>Descrição de PolymorphismDeposit</b>
 *
 * @author Klethônio Ferreira
 */
class PolymorphismDeposit extends Polymorphism {
    
    public $discount;
    
    public function __construct($product, $price) {
        parent::__construct($product, $price);
        $this->discount = 0.15;
        $this->method = 'Depósito';
    }
    
    public function setDiscount($discount) {
        $this->discount = $discount;
    }
    
    public function toPay() {
        $this->price *= 1-$this->discount;
        parent::toPay();
    }
    
}
