<?php
/**
 * Clase Database - Maneja la conexión a la base de datos
 */
class Database 
{
    private static $instance = null;
    private $connection;
    private $config;

    private function __construct() 
    {
        $this->config = require_once __DIR__ . '/database.php';
        $this->connect();
    }

    public static function getInstance() 
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    private function connect() 
    {
        try {
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['dbname']};charset={$this->config['charset']}";
            $this->connection = new PDO($dsn, $this->config['username'], $this->config['password'], $this->config['options']);
        } catch (PDOException $e) {
            throw new Exception("Error de conexión a la base de datos: " . $e->getMessage());
        }
    }

    public function getConnection() 
    {
        return $this->connection;
    }

    public function testConnection() 
    {
        try {
            $this->connection->query('SELECT 1');
            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Prevenir clonación del objeto
    private function __clone() {}
    
    // Prevenir deserialización del objeto
    public function __wakeup() 
    {
        throw new Exception("No se puede deserializar una instancia de " . __CLASS__);
    }
}
