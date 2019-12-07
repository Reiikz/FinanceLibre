<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/User.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/Data/UserData.php";

session_start();
if(isset($_SESSION["username"])){
    header("Location: ../");
    exit(0);
}


if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = new User();
    $user_ = $user->loadByUsername($username);
    if($user_ === false){
        header("Location: /?action=LOGIN&username=$username&error=%username_not_found%");
        exit(0);
    }
    
    if(!$user_->verify($password)){
        header("Location: /?action=LOGIN&username=$username&error=%username_password_missmatch%");
        exit(0);
    }

    $_SESSION["username"] = $user_->username;
    $_SESSION["id"] = $user_->id;
    $_SESSION["locale"] = $user_->locale;
    
    $user->close();
    header("Location: /");
    exit(0);

}