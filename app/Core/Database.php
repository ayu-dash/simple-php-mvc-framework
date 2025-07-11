<?php

namespace App\Core;

use PDO;
use PDOException;
use PDOStatement;

class Database {
    private PDO $pdo;
    private PDOStatement $stmt;

    public function __construct() {
        try {
            $dsn = 'mysql:host='. DB_HOST. ';dbname=' . DB_NAME;

            $this->pdo = new PDO($dsn, DB_USERNAME, DB_PASSWORD, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        } catch(PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }   

    public function query($query) {
        $this->stmt = $this->pdo->prepare($query);
    }

    public function execute($params = []) {
        $this->stmt->execute($params);
    }

    public function fetchAll() {
        return $this->stmt->fetchAll();
    }
}