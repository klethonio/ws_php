<?php

/**
 * <b>Descrição de AggregationProduct</b>
 *
 * @author Klethônio Ferreira
 */
class AggregationProduct {

    private $id;
    private $name;
    private $price;

    public function __construct($id, $nome, $price) {
        $this->id = $id;
        $this->name = $nome;
        $this->price = $price;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getPrice() {
        return $this->price;
    }

}
