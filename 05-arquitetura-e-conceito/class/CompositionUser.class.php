<?php

/**
 * <b>Descrição de CompositionUser</b>
 *
 * @author Klethônio Ferreira
 */
class CompositionUser {

    public $name;
    public $email;
    /** @var CompositionAddress */
    private $address;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $email;
    }

    public function addAddress($city, $state) {
        $this->address = new CompositionAddress($city, $state);
    }

    /** @return CompositionAddress */
    public function getAddress() {
        return $this->address;
    }

}
