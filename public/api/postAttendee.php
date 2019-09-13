<?php
include "./lib/handler.php";
include "./lib/db.php";

$handler = new handler();

try{
    $db = new DB();
    $conn = $db->Connect();

    $event = $_POST['event'];
    $session = $_POST['session'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    if(isset($event, $session, $name, $phone, $email)){

        $query = "INSERT INTO `attendee` (`event`, `session`, `name`, `phone`, `email`) VALUES (:event, :session, :name, :phone, :email)";
        $statement = $conn->prepare($query);
        
        $statement->bindParam(':event', $event);
        $statement->bindParam(':session', $session);
        $statement->bindParam(':name', $name);
        $statement->bindParam(':phone', $phone);
        $statement->bindParam(':email', $email);

        $statement->execute();

        $handler->response(200, "Success");
    }
    else{
        $handler->response(400, "Incomplete Request");
    }
}
catch(PDOException $ex){
    $handler->response(500, $ex->getMessage());
}