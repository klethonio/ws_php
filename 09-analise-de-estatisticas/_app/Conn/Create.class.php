<?php

/**
 * Description of Create
 * Responsible for general create in the database.
 * @author Klethônio Ferreira
 */
class Create extends Conn
{
    private $table;
    private $data;
    private $query;
    private $result;

    /** @var PDOStatement */
    private $create;

    /** @var PDO */
    private $conn;

    /**
    * Perform a simplified registration in the database using prepared statements.
    * Inform the name of the table and an array of data.
    * 
    * @param string $table
    * @param array $data (name => value)
    */
    public function exeCreate(string $table, array $data): void
    {
        $this->table = $table;
        $this->data = $data;
        $this->getSyntax();
        $this->execute();
    }

    /**
     * Returns the ID of the inserted record or null if no record is inserted.
     * @return int = lastInsertId or null
     */
    public function getResult(): int
    {
        return $this->result;
    }

    /**
     * ****************************************
     * *********** PRIVATE METHODS ************
     * ****************************************
     */
    //Get the PDO and prepare the query
    private function connect(): void
    {
        $this->conn = parent::getConn();
        $this->create = $this->conn->prepare($this->query);
    }

    //Create query syntax for Prepared Statements
    private function getSyntax(): void
    {
        $columns = implode(', ', array_keys($this->data));
        $places = ':' . implode(', :', array_keys($this->data));
        $this->query = "INSERT INTO {$this->table} ({$columns}) VALUES ({$places})";
    }

    //Get the Connection and Syntax and execute the query
    private function execute(): void
    {
        $this->connect();
        try {
            $this->create->execute($this->data);
            $this->result = $this->conn->lastInsertId();
        } catch (PDOException $e) {
            $this->result = null;
            WSMessage("<b>Create error:</b> {$e->getMessage()}", $e->getCode());
        }
    }

}
