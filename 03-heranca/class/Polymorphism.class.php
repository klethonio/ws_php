<?php

/**
 * <b>Descrição de Polymorphism</b>
 *
 * @author Klethônio Ferreira
 */
class Polymorphism {
    
    public $product;
    public $price;
    public $method;
    
    public function __construct($product, $price) {
        $this->product = $product;
        $this->price = $price;
        $this->method = 'Boleto';
    }

    public function toPay() {
        echo "Você pagou R$ {$this->toReal($this->price)} por um {$this->product}.<br/>";
        echo "<small>Pagamento efetuado via {$this->method}.</small><hr/>";
    }
    
    public function toReal($value) {
        return number_format($value, 2, ',', '.');
    }
    
}
