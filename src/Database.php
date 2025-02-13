<?php

namespace App;

use PDO;
use PDOException;

class Database
{
    private $host = 'db';
    private $dbname = 'crud_teste';
    private $username = 'root';
    private $password = 'rootpassword';
    private $conn;

    public function connect()
    {
        if ($this->conn === null) {
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->dbname}", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->conn;
    }
}