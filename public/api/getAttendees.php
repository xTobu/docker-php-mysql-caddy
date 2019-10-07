<?php
include "./lib/handler.php";
include './lib/db.php';
 
try{
    $db = new DB();
    $conn = $db->Connect();

    if($conn){

        $query = "SELECT `pkid`, `session`, `job`, `dept`, `rocid`, `name`, `phone`, `email`, `status`, `created_at` as `created_at` FROM `attendee` WHERE `status` = 1 ORDER BY `pkid` DESC";
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