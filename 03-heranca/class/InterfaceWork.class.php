<?php

/**
 * <b>Descrição de Interface</b>
 *
 * @author Klethônio Ferreira
 */
class InterfaceWork implements IStudent {
    
    public $student;
    public $course;
    public $background;
    
    public function __construct($student, $course) {
        $this->student = $student;
        $this->course = $course;
        $this->background = array( );
    }

    public function enroll($course) {
        $this->course = $course;
        echo "{$this->student} foi matriculado no curso {$this->course}.<hr/>";
    }

    public function form() {
        $this->background[] = $this->course;
        echo "{$this->student} formou-se no curso {$this->course}.<hr/>";
    }

}
