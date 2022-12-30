<?php

/**
 * Description of Update
 * Responsible for generic database updates.
 * @author Klethônio Ferreira
 */
class Update extends Conn
{
    private $table;
    private $data;
    private $condition;
    private $query;
    private $params;
    private $result;
    private $allowNewUpdate = false;

    /** @var PDOStatement */
    private $update;

    /** @var PDO */
    private $conn;

    /**
     * Perform a simplified update with Prepared Statements.
     * Inform table, data array, the conditions and an array with the conditional data.
     * @param string $table
     * @param array $data | [ 'NomeDaColuna' => Valor, 'NomeDaColuna2' => Valor2 ]
     * @param string $condition | WHERE link = :link AND link2 = :link2
     * @param array $params | [link => $link, link2 => {$link2}]
     */
    public function exeUpdate(string $table, array $data, string $condition, array $params): void
    {
        $this->table = $table;
        $this->data = $data;
        $this->condition = $condition;
        $this->params = $params;
        $this->allowNewUpdate = true;
        $this->execute();
    }

    /**
     * Executes update changing only the search parameters via array.
     * @param array $params | [link => $link, link2 => {$link2}]
     */
    public function exeNewUpdate(array $params): void
    {
        if (!$this->allowNewUpdate) {
            WSMessage('This method can only be called after execute exeUpdate() first.', E_USER_ERROR, true);
        }
        $this->params = $params;
        $this->execute();
    }

    /**
     * Returns true if there are no errors in the update, even without changing any record.
     * @return boolean $var
     */
    public function getResult(): bool
    {
        return $this->result;
    }

    /**
     * Returns the number of records changed.
     * @return int
     */
    public function count(): int
    {
        return $this->update->rowCount();
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
        $this->update = $this->conn->prepare($this->query);
    }

    //Create query syntax for Prepared Statements
    private function getSyntax(): void
    {
        foreach (array_keys($this->data) as $key) {
            $fields[] = $key . ' = :' . $key;
        }
        $fields = implode(', ', $fields);
        $this->query = "UPDATE {$this->table} SET {$fields} {$this->condition}";
    }

    //Get the Connection and Syntax and execute the query
    private function execute(): void
    {
        $this->getSyntax();
        $this->connect();
        try {
            $this->update->execute(array_merge($this->data, $this->params));
            $this->result = true;
        } catch (PDOException $e) {
            $this->result = null;
            WSMessage("<b>Update error:</b> {$e->getMessage()}", $e->getCode());
        }
    }

}