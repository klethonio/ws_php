<?php

/**
 * <b>Descrição de AtributosMetodos</b>
 *
 * @author Klethônio Ferreira
 */
class AtributesMethods {
    var $name, $age, $profession;
    
    function setUser($name, $age, $profession) {
        $this->name = $name;
        $this->setAge($age);
        $this->profession = $profession;
    }
    function getUser() {
        return "<p>{$this->name} tem {$this->age} anos de idade e trabalha como {$this->profession}</p>";
    }
    function getClass() {
        var_dump($this);
    }
    function setAge($age) {
        if(!preg_match('/^[1-9]{1}[0-9]*$/', $age)){
            die('Idade informada inválida!');
        }else{
            $this->age = intval($age);
        }
    }
    function getOlder() {
        $this->age += 1;
    }
}
