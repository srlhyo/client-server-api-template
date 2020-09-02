<?php

class Database 
{
    private  $database;

    public function __construct() {
        $host = '127.0.0.1'; // still don't understand :(
        $db   = 'api';
        $user = 'shinobi';
        $pass = '1234';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        // do some sort of validation to make sure that connectino is made
        try {
            $this->database = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function getUsers() {
        $stmt = $this->database->query('SELECT * FROM users');
        return $stmt->fetchAll();
    }

    public function createUser($name, $age) {
        $sql = "INSERT INTO users (name, age) VALUES (?, ?)";
        return $this->database->prepare($sql)->execute([$name, $age]);
    }

    public function deleteUser($id) {
        $sql = "DELETE FROM users WHERE id = ?";
        return $this->database->prepare($sql)->execute([$id]);
    }
}