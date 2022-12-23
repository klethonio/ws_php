<?php

/**
 * <b>Descrição de MoldingClass</b>
 *
 * @author Klethônio Ferreira
 */
class MoldingClass {
    
    public $name;
    public $age;
    public $profession;
    public $account;
    
    public function __construct($name, $age, $profession, $account) {
        $this->name = $name;
        $this->age = $age;
        $this->profession = $profession;
        $this->account = $account;
    }

    public function toWork($work, $value) {
        $this->account += $value;
        $this->write("{$this->name} desenvolveu um {$work} e recebeu {$this->toReal($value)}");
    }
    
    public function setName($name) {
        $this->name = $name;
    }

    public function setAge($age) {
        $this->age = $age;
    }

    public function setProfession($profession) {
        $this->profession = $profession;
    }

    public function setAccount($account) {
        $this->account = $account;
    }

    public function toReal($value) {
        return number_format($value, 2, ',', '.');
    }
    
    public function write($message) {
        echo "<p>{$message}</p>";
    }
}
