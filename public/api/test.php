<?php
include "./lib/handler.php";

$data['name'] = "GVM";

$handler = new handler();
$handler->response(200, $data);
//$handler->response(400, "<錯誤訊息>");