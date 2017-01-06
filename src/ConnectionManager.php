<?php

namespace Dbfit;

use \PDO;

/**
 * ConnectionManager
 * 
 * Responsible by manage PDO connections  
 * 
 * @since 0.1.0
 * @author Abraao Levi <https://github.com/abraaolevi>
 */
class ConnectionManager
{

    /**
     * Array of connections
     * @var array 
     */
    protected static $_config = [];
    
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

        self::$_config[$key] = $config;
    }

    /**
     * Get PDO connection by configuration key/name
     * @param string $key
     * @return \PDO
     */
    public static function get(string $key): \PDO
    {
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ];
        
        return new PDO(
                self::parseDsn(self::$_config[$key]), 
                self::$_config['user'], 
                self::$_config['password'], 
                $options
            );
    }

    /**
     * Get DNS string by configuration
     * @param array $config
     * @return string
     * @throws \InvalidArgumentException
     */
    public static function parseDsn(array $config = []): string
    {
        if (empty($config)) {
            throw new \InvalidArgumentException("Config is empty. Can't parse DNS without config");
        }
        return 'mysql:host=' . $config['host'] . ';dbname=' . $config['database'];
    }

}
