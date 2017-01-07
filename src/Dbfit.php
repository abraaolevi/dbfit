<?php

namespace Dbfit;

use Dbfit\Connection;
use Dbfit\ConnectionManager;

/**
 * Dbfit
 * 
 * Responsible for facilitating day-to-day SQL queries
 * 
 * ### USAGE
 * 
 * Simple queries:
 * 
 * ```
 * $db = new Dbfit($host, $user, $password, $database);
 * $result = $db->query("SELECT * FROM users");
 * ```
 * 
 * Transactions queries:
 * ```
 * $db->getConnection()->beginTransaction();
 * $db->query($sql);
 * $db->query($sql);
 * $db->query($sql);
 * $db->getConnection()->endTransaction();
 * ```
 * 
 * You can cancel a transaction using `$db->getConnection()->cancelTransaction();`
 * 
 * @since 0.1.0
 * @author Abraao Levi <https://github.com/abraaolevi>
 */
class Dbfit
{

    /**
     * Database connection
     * @var \Dbfit\Connection
     */
    private $conn;

    /**
     * Statement query
     * @var \Dbfit\Statement 
     */
    private $stmt;

    /**
     * Constructor class
     * @param string $host
     * @param string $user
     * @param string $password
     * @param string $database
     */
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

    /**
     * Get result from SQL
     * this method prepare, execute and get result set from string SQL
     * 
     * ### Usage
     * 
     * ```
     * $result = $db->query("SELECT * FROM users");
     * ```
     * 
     * or
     * 
     * ```
     * $result = $db->query("INSERT INTO users (name, age, gender) VALUES (:name, :age, :gender)", [
     *      ":name" => "John",
     *      ":age" => 25,
     *      ":gender" => "male"
     * ]);
     * ```
     * 
     * @param string $sql
     * @param array $params
     * @param bool $rawResponse
     * @return array
     * @throws \Exception
     */
    public function query(string $sql, array $params = [], bool $rawResponse = true): array
    {
        $this->prepareQuery($sql);

        foreach ($params as $key => $value) {
            $this->stmt->bind($key, $value);
        }

        if (!$this->stmt->execute()) {
            throw new \Exception("Fail to execute statement query");
        }
        
        if($rawResponse){
            return $this->stmt->resultset();
        }
        
        return [
            "result" => $this->stmt->resultset(),
            "count" => $this->stmt->rowCount()
        ];
    }
    
    public function prepareQuery(string $sql)
    {
        $this->stmt = $this->conn->prepareQuery($sql);
    }
    
    /**
     * Return the Connection
     * @return \Dbfit\Connection
     */
    public function getConnection(): Connection
    {
        return $this->conn;
    }
    
    /**
     * Return the Statement
     * @return \Dbfit\Statement
     */
    public function getStatement(): Statement
    {
        return $this->stmt;
    }
    
}
