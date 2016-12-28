<?php

namespace Dbfit;

use \PDO;

/**
 * Statement
 * 
 * Responsible for statements on single PDO connection 
 * 
 * @since 0.1
 * @author Abraao Levi <https://github.com/abraaolevi>
 */
class Statement
{
    /**
     * Current query statement
     * @var \PDOStatement 
     */
    private $stmt;
    
    /**
     * Constructor class
     * @param \PDOStatement $statemanet
     */
    public function __construct(\PDOStatement $statemanet)
    {
        $this->stmt = $statemanet;
    }
    
    /**
     * Bind values on statement
     * @param string $param
     * @param mixed $value based on `$type`
     * @param mixed $type can be `null` for any type or `\PDO::PARAM_INT`, `\PDO::PARAM_BOOL`, `\PDO::PARAM_NULL` or `\PDO::PARAM_STR`
     * @return bool
     */
    public function bind(string $param, $value, $type = null): bool
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = \PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = \PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = \PDO::PARAM_NULL;
                    break;
                default:
                    $type = \PDO::PARAM_STR;
            }
        }
        return $this->stmt->bindValue($param, $value, $type);
    }
    
    /**
     * Executes a prepared statement
     * @return bool
     */
    public function execute(): bool
    {
        return $this->stmt->execute();
    }

    /**
     * Returns an array containing all of the result set rows
     * @return array
     */
    public function resultset(): array
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Return single first record from result set
     * @return array
     */
    public function single(): array
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Returns the number of rows affected by the last SQL statement
     * @return int
     */
    public function rowCount(): int
    {
        return $this->stmt->rowCount();
    }
    
    /**
     * Dump an SQL prepared command
     * @return type
     */
    public function debug()
    {
        return $this->stmt->debugDumpParams();
    }
}
