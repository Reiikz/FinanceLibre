<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include $_SERVER["DOCUMENT_ROOT"] . "/lib/User.php";

session_start();
if(isset($_SESSION["username"])){
    header("Location: ../");
    exit(0);
}


if(isset($_POST["login"])){
    $username = $_POST["username"];
    $password = $_POST["password"];

    $user = new User();
    if($user->loadByUsername($username) == false){
        header("Location: /?action=LOGIN&username=$username&error=%username_not_found%");
        exit(0);
    }

    if(!$user->verify($password)){
        header("Location: /?action=LOGIN&username=$username&error=%username_password_missmatch%");
        exit(0);
    }

    $_SESSION["username"] = $user->username;
    $_SESSION["id"] = $user->id;
    $_SESSION["locale"] = $user->locale;

    header("Location: /");
    exit(0);

}