<?php

namespace Dbfit;

class ConnectionManager
{

    private $_config = [];
    
    /**
     * Configure the Connection Manager
     * 
     * @param string $key connection's name
     * @param array $config an array like <br>
     *                      ["host" => "", "user" => "", "password" => "", "database" => ""] 
     * @throws \InvalidArgumentException
     */
    public static function config(string $key, array $config = [])
    {
        if (empty($key)) {
            throw new \InvalidArgumentException("Config key is required");
        }

        $this->_config[$key] = $config;
    }

    public static function get(string $key): \PDO
    {
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        
        return new \PDO(
                self::parseDsn($this->_config[$key]), 
                $this->_config['user'], 
                $this->_config['password'], 
                $options
            );
    }

    public static function parseDsn(array $config = [])
    {
        if (empty($config)) {
            throw new \InvalidArgumentException("Config is empty. Can't parse DNS without config");
        }
        return 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'];
    }

}
