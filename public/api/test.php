<?php
header('Content-Type: application/json; charset=utf-8');
include_once "handler.php";

$data['name'] = "GVM";

$handler = new handler();
$handler->response(200, $data);
//$handler->response(400, "<錯誤訊息>");