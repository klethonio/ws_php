<?php

/**
 * <b>Descrição de ReplyClonage</b>
 *
 * @author Klethônio Ferreira
 */
class ReplyClonage {
    var $table;
    var $terms;
    var $addQuery;
    var $query;
    
    function __construct($table, $terms, $addQuery) {
        $this->table = $table;
        $this->terms = $terms;
        $this->addQuery = $addQuery;
    }
    
    public function setTable($table) {
        $this->table = $table;
    }
    
    function setTerms($terms) {
        $this->terms = $terms;
    }
    
    function read() {
        echo $this->query = "SELECT * FROM {$this->table} WHERE {$this->terms} {$this->addQuery}<hr/>";
    }

}
