<?php

namespace Dbfit;

use Dbfit\Statement;

class Connection
{

    private $conn;

    public function __construct(\PDO $connection)
    {
        $this->conn = $connection;
    }

    public function prepareQuery(string $query)
    {
        return new Statement($this->conn->prepare($query));
    }

    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    public function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    public function endTransaction()
    {
        return $this->conn->commit();
    }

    public function cancelTransaction()
    {
        return $this->conn->rollBack();
    }

}

