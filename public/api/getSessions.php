<?php
include "./lib/handler.php";
include './lib/db.php';
 
try{
    $db = new DB();
    $conn = $db->Connect();

    if($conn){

        $query = "SELECT * FROM `session` WHERE `status` != -1 ORDER BY `pkid` ASC";
        $statement = $conn->prepare($query);
        $statement->execute();
        $results = $statement->fetchAll(PDO::FETCH_ASSOC);
        
        $handler = new handler();
        $handler->response(200, $results);
    }
    else{
        echo $conn;
    }
}
catch(PDOException $ex){
    echo $ex->getMessage();
}