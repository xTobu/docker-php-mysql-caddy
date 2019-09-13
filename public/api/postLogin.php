<?php
if (! empty($_POST["formName"]) || $_POST["formName"] != "login") {
    session_start();

    $user = filter_var($_POST["user"], FILTER_SANITIZE_STRING);
    $pwd = filter_var($_POST["pwd"], FILTER_SANITIZE_STRING);

    $isLoggedIn = processLogin($user, $pwd);
    if($isLoggedIn)
    {
        header("Location: /backoffice");
    }
    else{
        $_SESSION["errorMessage"] = "帳號或密碼錯誤";
        header("Location: /backoffice/login.php");
    }
    exit();
}
else{
    header("Location: /backoffice/login.php");
}

function processLogin($user, $pwd) {
    $config = include('lib/config.php');
    if($user == $config["su"]["user"] && $pwd == $config["su"]["pwd"] )
    {
        $_SESSION["su"] = $user;
        return true;
    }
    else{
        return false;
    }
}