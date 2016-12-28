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
     * 
     * @param mixed $param
     * @param mixed $value
     * @param mixed $type
     */
    public function bind($param, $value, $type = null)
    {
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
            }
        }
        $this->stmt->bindValue($param, $value, $type);
    }
    
    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultset()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
    
    public function debug()
    {
        return $this->stmt->debugDumpParams();
    }
}
