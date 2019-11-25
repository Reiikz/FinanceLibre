<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/Account.php";
session_start();

if(isset($_POST["save"])){
    $a = new Account();
    $a->user_id = $_SESSION["id"];
    $a->name = $_POST["account_name"];
    $a->currency = $_POST["currency_name"];
    $a->type = $_POST["type"];
    $a->description = $_POST["account_description"];
    $a->saveNew();
    $a->close();
    //header("Location: /?action=ACCOUNTS");
}