<?php

/**
 * Description of Read
 * Responsible for generic reads into the database.
 * @author Klethônio Ferreira
 */
class Read extends Conn
{
    private $params;
    private $query;
    private $result;
    private $allowNewRead = false;

    /** @var PDOStatement */
    private $read;

    /** @var PDO */
    private $conn;

    /**
     * Perform a simplified read with Prepared Statements. Just inform the name of the table,
     * the selection conditions and a parse string (ParseString) to execute.
     * @param string $table
     * @param string $condition | WHERE link = :link LIMIT :link_int (_int for integer)
     * @param array $params | [link => $link, link_int => {$link_int}]
     */
    public function exeRead(string $table, string $condition = null, array $params = null) {
        $this->query = "SELECT * FROM {$table} {$condition}";
        $this->params = $params;
        $this->allowNewRead = true;
        $this->execute();
    }

    /**
     * Performs data reading via query that must be assembled manually to allow selection of multiple tables in a single query.
     * @param string $query
     * @param array $params | [link => $link, link_int => {$link_int}] (_int for integer)
     */
    public function exeQuery(string $query, array $params = null) {
        $this->query = $query;
        $this->params = $params;
        $this->allowNewRead = true;
        $this->execute();
    }

    /**
     * Performs reading by changing only the search parameters via array.
     * The number of parameters must be equal to the one passed when the object was instantiated.
     * @param array $params = [link => $link, link_int => {$link_int}] (_int for integer)
     */
    public function exeNewRead(array $params) {
        if (!$this->allowNewRead) {
            WSMessage('This method can only be called after execute exeRead() or exeQuery() first.', E_USER_ERROR, true);
        }
        $this->params = $params;
        $this->execute();
    }

    /**
     * Returns an array with all the results obtained.
     * @return array
     */
    public function getResult() {
        return $this->result;
    }

    /**
     * Returns the first result of getResult().
     * @return array
     */
    public function first() {
        return $this->result[0] ?? null;
    }

    /**
     * Returns the number of records found.
     * @return int
     */
    public function count() {
        return $this->read->rowCount();
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Get the PDO and prepare the query
    private function connect() {
        $this->conn = parent::getConn();
        $this->read = $this->conn->prepare($this->query);
        $this->read->setFetchMode(PDO::FETCH_ASSOC);
    }

    //Binds the query reading parameters
    private function bindValues() {
        if ($this->params) {
            foreach ($this->params as $key => &$value) {
                if (preg_match('/(_int)$/i', $key) || $key == 'limit' || $key == 'offset') {
                    $value = (int) $value;
                }
                $this->read->bindValue(":{$key}", $value, (is_int($value) ? PDO::PARAM_INT : PDO::PARAM_STR));
            }
        }
    }

    //Get the Connection and Syntax and execute the query
    private function execute() {
        $this->connect();
        try {
            $this->bindValues();
            $this->read->execute();
            $this->result = $this->read->fetchAll();
        } catch (PDOException $e) {
            $this->result = null;
            WSMessage("<b>Read error:</b> {$e->getMessage()}", $e->getCode());
        }
    }

}
