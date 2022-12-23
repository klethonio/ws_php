<?php

/**
 * <b>Descrição de Inheritance</b>
 *
 * @author Klethônio Ferreira
 */
class Inheritance {
    
    public $name;
    public $age;
    public $courses;
    
    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
        $this->courses = array();
    }

    public function getOlder() {
        $this->age += 1;
    }
    
    public function toForm($course) {
        $this->courses[] = (string) $course;
    }
    
    public function personInfo() {
        $courses = implode(', ', $this->courses);
        return "{$this->name} tem {$this->age} anos de idade e é formado em: {$courses}.<hr/>";
    }
}
