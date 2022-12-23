<?php

/**
 * <b>Descrição de PolymorphismCard</b>
 *
 * @author Klethônio Ferreira
 */
class PolymorphismCard extends Polymorphism {
    
    public $interest;
    public $charges;
    public $installment;
    public $numInstallmentsNum;
    
    public function __construct($product, $price) {
        parent::__construct($product, $price);
        $this->interest = 0.0117;
        $this->method = 'Cartão de crédito';
    }
    
    public function toPay($installments = NULL) {
        $this->setNumInstallmentsNum($installments);
        $this->setCharges();
        $this->price += $this->charges;
        $this->installment = $this->price/$this->numInstallmentsNum;
        
        echo "Você pagou R$ {$this->toReal($this->price)} por um {$this->product}<br>";
        echo "<small>Pagamento efetuado via {$this->method} em {$this->numInstallmentsNum}x iguais de {$this->toReal($this->installment)}.</small><hr/>";
    }
    
    /** Para 5.5% informe 5.5 */
    public function setInterest($interest) {
        $this->interest = $interest/100;
    }

    public function setCharges() {
        $this->charges = $this->price * $this->interest * $this->numInstallmentsNum;
    }

    public function setNumInstallmentsNum($numInstallmentsNum) {
        $this->numInstallmentsNum = ( (int) $numInstallmentsNum >= 1 ? $numInstallmentsNum : 1);
    }


    
}
