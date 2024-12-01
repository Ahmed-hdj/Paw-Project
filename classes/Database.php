<?php

class Database {
    private $server;
    private $username;
    private $password;
    private $dbname;
    private $conn;

    public function __construct($server, $username, $password, $dbname) {
        $this->server = $server;
        $this->username = $username;
        $this->password = $password;
        $this->dbname = $dbname;
        $this->connect();
    }
    

    private function connect() {
        try {
            $this->conn = new PDO("mysql:host={$this->server};dbname={$this->dbname}", $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->conn;
    }

public function closeConnection() {
    $this->conn = null;
}
}