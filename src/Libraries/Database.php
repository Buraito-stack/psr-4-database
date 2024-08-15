<?php

namespace MiniMarkPlace\Libraries;

use mysqli;

class Database
{
    private $host     = 'localhost';  
    private $user     = 'root';       
    private $password = '';       
    private $dbname   = 'demo_intern';  

    protected $conn;

    public function __construct()
    {
        $this->conn = new mysqli($this->host, $this->user, $this->password, $this->dbname);

        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function connection()
    {
        return $this->conn;
    }
}
