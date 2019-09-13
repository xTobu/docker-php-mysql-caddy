<?php 
session_start();
$_SESSION["su"] = "";
session_destroy();
header("Location: /backoffice/index.php");