<?php

class DB
{
    protected $conn = null;

    public function Connect()
    {
        $config = include('config.php');
        $dbType   = $config["db"]["dbType"];
        $host     = $config["db"]["host"];
        $port     = $config["db"]["port"];
        $dbName   = $config["db"]["dbName"];
        $user     = $config["db"]["user"];
        $pwd      = $config["db"]["pwd"];
        $dsn      = "$dbType:host=$host;port=$port;dbname=$dbName";

        try {

            $options  = array(
                PDO::ATTR_ERRMODE =>PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                // PDO::MYSQL_ATTR_INIT_COMMAND =>"SET time_zone = 'Asia/Taipei'"
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