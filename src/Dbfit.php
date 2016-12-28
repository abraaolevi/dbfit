<?php

namespace Dbfit;

use Dbfit\Connection;
use Dbfit\ConnectionManager;

class Dbfit
{

    private $conn;
    private $stmt;

    public function __construct(string $host, string $user, string $password, string $database)
    {
        ConnectionManager::config("default", [
            "host" => $host,
            "user" => $user,
            "password" => $password,
            "database" => $database
        ]);

        $this->conn = new Connection(ConnectionManager::get("default"));
    }
    
    public function query(string $query){
        $this->stmt = $this->conn->prepareQuery($query);
        if(!$this->stmt->execute()) {
            throw new \Exception("Fail to execute statement query");
        }
        return $this->stmt->resultset();
    }
    
}
