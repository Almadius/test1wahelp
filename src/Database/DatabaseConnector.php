<?php
namespace Src\Database;

use PDO;

class DatabaseConnector {
    private $connection = null;

    public function __construct() {
        $config = require 'config/db.php';
        $dsn = "mysql:host={$config['host']};dbname={$config['db']};charset={$config['charset']}";
        try {
            $this->connection = new PDO($dsn, $config['user'], $config['pass'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getConnection() {
        return $this->connection;
    }
}