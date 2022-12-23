<?php

/**
 * <b>Descrição de AssociationClient</b>
 *
 * @author Klethônio Ferreira
 */
class AssociationClient {

    private $id;
    private $name;
    private $email;

    public function __construct($name, $email) {
        $this->id = md5($name);
        $this->name = $name;
        $this->email = $email;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

}
