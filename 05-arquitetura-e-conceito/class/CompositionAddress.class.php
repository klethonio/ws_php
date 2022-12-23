<?php

/**
 * <b>Descrição de CompositionAddress</b>
 *
 * @author Klethônio Ferreira
 */
class CompositionAddress {

    private $city;
    private $state;

    public function __construct($city, $state) {
        $this->city = $city;
        $this->state = $state;
    }

    public function getCity() {
        return $this->city;
    }

    public function getState() {
        return $this->state;
    }

}
