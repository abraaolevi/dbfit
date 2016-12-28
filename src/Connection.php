<?php

namespace Dbfit;

use Dbfit\Statement;

/**
 * Connection
 * 
 * Responsible by manage single PDO connection 
 * 
 * @since 0.1
 * @author Abraao Levi <https://github.com/abraaolevi>
 */
class Connection
{
    /**
     * PDO Connection
     * @var \PDO 
     */
    private $conn = null;

    /**
     * Construct class
     * @param \PDO $connection
     */
    public function __construct(\PDO $connection)
    {
        $this->conn = $connection;
    }

    /**
     * Prepare a query string in a Statement
     * for more information @see http://php.net/manual/en/pdo.prepare.php
     * @param string $query
     * @return \Dbfit\Statement
     */
    public function prepareQuery(string $query)
    {
        return new Statement($this->conn->prepare($query));
    }

    /**
     * Get last inserted Id on connection
     * @return string
     */
    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    /**
     * Starts a transaction
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function beginTransaction()
    {
        return $this->conn->beginTransaction();
    }

    /**
     * Ends a transaction
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function endTransaction()
    {
        return $this->conn->commit();
    }

    /**
     * Cancels a transaction
     * @return bool <b>TRUE</b> on success or <b>FALSE</b> on failure.
     */
    public function cancelTransaction()
    {
        return $this->conn->rollBack();
    }

}

