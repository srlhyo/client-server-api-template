<?php

require_once "class.database.php";

class Api 
{
    private $databaseInstance;
    private $buildVersion = "1.4 stable";

    public function __construct() {
        $this->databaseInstance = new Database();
    }

    public function getBuildVersion() {
        return $this->buildVersion;
    }

    public function getUsers() {
        return $this->databaseInstance->getUsers();
    }

    public function createUser($query) {
        if (!array_key_exists("name", $query)) {
            throw new Exception('Name is not set!');   
        }

        if (!array_key_exists("age", $query)) {
            throw new Exception('Age is not set!');   
        }
        return $this->databaseInstance->createUser($query["name"], $query["age"]);
    }

    public function deleteUser($query) {
        if (!array_key_exists("id", $query)) {
            throw new Exception('id is not set!');   
        }
        return $this->databaseInstance->deleteUser($query["id"]);
    }   
}

