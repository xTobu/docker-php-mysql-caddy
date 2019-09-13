<?php

class DB
{
    protected $conn = null;

    public function Connect()
    {
        $dbType   = "mysql";
        $host     = "mysql";
        $port     = "3306";
        $dbName   = "db_Event";
        $user     = "root";
        $pwd      = "1234";
        $dsn      = "$dbType:host=$host;port=$port;dbname=$dbName";

        try {

            $options  = array(
                PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            );
            $this->conn = new PDO($dsn, $user, $pwd, $options);
            return $this->conn;

        } catch (PDOException $e) {
            echo 'Connection error: ' . $e->getMessage();
        }
    }

    public function Close()
    {
        $this->conn = null;
    }
}