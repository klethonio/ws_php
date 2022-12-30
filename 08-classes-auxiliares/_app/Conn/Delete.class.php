<?php

/**
 * Description of Delete
 * Responsible for deleting generically in the database.
 * @author Klethônio Ferreira
 */
class Delete extends Conn
{
    private $query;
    private $params;
    private $result;
    private $allowNewDelete = false;

    /** @var PDOStatement */
    private $delete;

    /** @var PDO */
    private $conn;

    /**
     * Perform simplified removal with Prepared Statements.
     * Inform the table name, the selection conditions and an array with the conditional data to execute.
     * @param string $table
     * @param string $condition | WHERE link = :link AND link2 = :link2
     * @param array $params | [link => $link, link2 => {$link2}]
     */
    public function exeDelete(string $table, string $condition, array $params) {
        $this->query = "DELETE FROM {$table} {$condition}";
        $this->params = $params;
        $this->allowNewDelete = true;
        $this->execute();
    }

    /**
     * Perform removal by changing only search parameters via array.
     * @param array $params = [link => $link, link2 => {$link2}]
     */
    public function exeNewDelete(array $params) {
        if (!$this->allowNewDelete) {
            WSMessage('This method can only be called after execute exeDelete first.', E_USER_ERROR, true);
        }
        $this->params = $params;
        $this->execute();
    }

    /**
     * Returns true if there is no error in removal, even if no records are deleted.
     * @return boolean $var
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * Returns the number of records removed.
     * @return int
     */
    public function count() {
        return $this->delete->rowCount();
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Get the PDO and prepare the query
    private function connect() {
        $this->conn = parent::getConn();
        $this->delete = $this->conn->prepare($this->query);
    }

    //Get the Connection and Syntax and execute the query
    private function execute() {
        $this->connect();
        try {
            $this->delete->execute($this->params);
            $this->result = true;
        } catch (PDOException $e) {
            $this->result = false;
            WSMessage("<b>Delete error:</b> {$e->getMessage()}", $e->getCode());
        }
    }

}
