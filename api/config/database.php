<?php

class Database
{

    private $host = "localhost";
    private $db_name = "testphp";
    private $username = "root";
    private $pass = "-FZk9l*bBt0IVYE7";
    public $conn;

    // get the database connection
    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->pass);
            $this->conn->exec("set names utf8mb4");
        } catch (PDOException $exception) {
            echo "Connection error: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
