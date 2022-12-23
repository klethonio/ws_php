<?php

/**
 * <b>Descrição de DinamicObject</b>
 *
 * @author Klethônio Ferreira
 */
class DinamicObject {
    public $name;
    private $email;
    
    public function newClient($client) {
        if(!is_object($client)){
            die('Informe um objeto com nome e email!');
        }else{
            $this->name = $client->name;
            $this->email = $client->email;
        }
    }
}
