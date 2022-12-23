<?php

/**
 * <b>Descrição de ProtectAccess</b>
 *
 * @author Klethônio Ferreira
 */
class ProtectedAccess {

    public $name;
    protected $email;

    public function __construct($name, $email) {
        $this->name = $name;
        $this->setEmail($email);
    }

    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Email inválido!');
        } else {
            $this->email = $email;
        }
    }

    final protected function setName($name) {
        $this->name = $name;
    }

}

class ProtectedAccessSub extends ProtectedAccess {

    protected $cpf;

    public function addCpf($name, $cpf) {
        $this->setName($name);
        $this->cpf = $cpf;
    }
}
