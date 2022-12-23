<?php

/**
 * <b>Descrição de AggregationCart</b>
 *
 * @author Klethônio Ferreira
 */
class AggregationCart {
    private $client;
    private $products;
    private $total;
    
    public function __construct(AssociationClient $client) {
        $this->client = $client;
        $this->products = array();
    }
    
    public function add(AggregationProduct $product) {
        $this->products[$product->getId()] = $product;
        $this->total += $product->getPrice();
        $this->cartReport($product, 'adicionou');
        
    }
    
    public function remove(AggregationProduct $product) {
        unset($this->products[$product->getId()]);
        $this->total -= $product->getPrice();
        $this->cartReport($product, 'removeu');
        
    }

    public function cartReport(AggregationProduct $product, $action) {
        echo "Você {$action} um {$product->getName()} em seu carrinho. Valor R$ {$product->getPrice()}<hr/>";
    }
}
