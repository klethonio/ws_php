<?php

/**
 * <b>Descrição de ScopeResolution</b>
 *
 * @author Klethônio Ferreira
 */
class ScopeResolution {
    public $product;
    public $price;
    public static $sales;
    public static $profits;
    
    public function __construct($product, $price) {
        $this->product = $product;
        $this->price = $price;
    }

    public function sell() {
        self::$sales += 1;
        self::$profits = $this->price * self::$sales;
        echo "{$this->product} vendido por {$this->toReal($this->price)}.<hr/>";
    }
    
    public static function report() {
        echo '<hr/>';
        echo "Este produto vendeu ".self::$sales." unidade(s). Totalizando ".self::toReal(self::$profits).".";
        echo '<hr/>';
    }


    public static function toReal($value) {
        return "R$ ".number_format($value, '2', ',', '.');
    }
}
