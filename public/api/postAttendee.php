<?php
include "./lib/handler.php";
include "./lib/db.php";

$handler = new handler();

try {
    $db = new DB();
    $conn = $db->Connect();

    $event = $_POST['event'];
    $session = $_POST['session'];
    $job = $_POST['job'];
    $dept = $_POST['dept'];
    $rocid = $_POST['rocid'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];

    if (!isset($event, $session, $job, $dept, $name, $phone, $email)) {
        $handler->response(400, "Bad Request: Incomplete Request");
        exit();
    }

    $query = "SELECT COUNT(*) FROM `attendee` WHERE `event` = :event AND `session` = :session AND `email` = :email";
    $statement = $conn->prepare($query);
    $statement->bindParam(':event', $event);
    $statement->bindParam(':session', $session);
    $statement->bindParam(':email', $email);
    $statement->execute();
    
    // 檢查重複資料
    $count = $statement->fetchColumn();
    if($count > 0){
        $handler->response(409, "Conflict: Duplicate Data");
        exit();
    }
    
    $query = "INSERT INTO `attendee` (`event`, `session`, `job`, `dept`, `rocid`, `name`, `phone`, `email`) VALUES (:event, :session, :job, :dept, :rocid, :name, :phone, :email)";
    $statement = $conn->prepare($query);

    $statement->bindParam(':event', $event);
    $statement->bindParam(':session', $session);
    $statement->bindParam(':job', $job);
    $statement->bindParam(':dept', $dept);
    $statement->bindParam(':rocid', $rocid ?: null);
    $statement->bindParam(':name', $name);
    $statement->bindParam(':phone', $phone);
    $statement->bindParam(':email', $email);

    $statement->execute();

    $handler->response(200, "Success");
} catch (PDOException $ex) {
    $handler->response(500, $ex->getMessage());
}
