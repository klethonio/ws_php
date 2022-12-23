<?php

/**
 * <b>Descrição de DigitalScopeResolution</b>
 *
 * @author Klethônio Ferreira
 */
class DigitalScopeResolution extends ScopeResolution {
    
    public static $digital;
    
    public function __construct($product, $price) {
        parent::__construct($product, $price);
    }
    
    public function sell() {
        self::$digital += 1;
        parent::sell();
    }
}
