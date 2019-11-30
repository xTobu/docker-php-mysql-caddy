<?php
include "./lib/handler.php";
include "./lib/db.php";

$handler = new handler();

try {
    $db = new DB();
    $conn = $db->Connect();

    $pkid = $_POST['pkid'];
    $status = $_POST['status'];

    if (!isset($pkid, $status)) {
        $handler->response(400, "Bad Request: Incomplete Request");
        exit();
    }

    $query = "UPDATE `session` SET `status` = :status WHERE `pkid` = :pkid";
    $statement = $conn->prepare($query);

    $statement->bindParam(':pkid', $pkid, PDO::PARAM_INT);
    $statement->bindParam(':status', $status, PDO::PARAM_INT);

    $statement->execute();

    $handler->response(200, "Success");
} catch (PDOException $ex) {
    $handler->response(500, $ex->getMessage());
}
