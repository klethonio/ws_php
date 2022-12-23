<?php

/**
 * <b>Descrição de PrivateAcess</b>
 *
 * @author Klethônio Ferreira
 */
class PrivateAccess {

    private $name;
    private $email;
    private $cpf;

    public function __construct($name, $email, $cpf) {
        $this->setName($name);
        $this->setEmail($email);
        $this->setCpf($cpf);
    }

    public function setName($name) {
        if (!$name || !is_string($name)) {
            die('Erro no nome!');
        } else {
            $this->name = $name;
        }
    }

    public function setEmail($email) {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Erro no e-mail!');
        } else {
            $this->email = $email;
        }
    }

    public function setCpf($cpf) {
        if (!preg_match('/^[0-9]{11}$/', $cpf)) {
            die('Erro no CPF!');
        } else {
            $this->cpf = $cpf;
        }
    }

}
