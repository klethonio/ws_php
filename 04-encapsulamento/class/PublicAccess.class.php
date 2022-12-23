<?php

/**
 * <b>Descrição de PublicAccess</b>
 *
 * @author Klethônio Ferreira
 */
class PublicAccess {

    public $name;
    public $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->email = $this->setEmail($email);
    }

    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Email inválido!');
        } else {
            return $this->email = $email;
        }
    }

}
