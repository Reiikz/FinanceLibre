<?php

//includes
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/locale/LocaleLoader.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/Account.php";


//--------------------------- check server state ------------------------------------
include_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";

if (!CONFIG::$installed)
{
    header("Location: installer");
}

if (CONFIG::$occupied){
    header("Location: occupied.html");
}

//***********************************************************************************


//--------------------------- check sesion state ---------------------------------------

session_start();

if(! isset($_SESSION["username"]) && $_GET["action"] != "LOGIN"){
    header("Location: /?action=LOGIN");
    exit(0);
}

//*************************************************************************************


//load locales
if (!isset($_SESSION["locale"])){
    include "lib/locale/locales/en_US.php";
    $lang = new Lang();
    $lc = new LocaleLoader($lang);
}


//---------------------------------- handle actions ----------------------------------
if(isset($_GET["action"])){
    
    //---------------------------- catch action=HISTORY
    if($_GET["action"] == "HISTORY"){
        $template = file_get_contents("templates/transactionTable.html");
        $template = $lc->loadText("transactionTable", $template);
        $template = str_replace("%%DATA%%", "", $template);
        echo $template;
        exit(0);
    }

    //---------------------------- catch action=LOGIN
    if($_GET["action"] == "LOGIN"){
        $template = file_get_contents("templates/login.html");
        $username="";
        $error="";
        if(isset($_GET["username"])) $username = $_GET["username"];
        if(isset($_GET["error"])) $error = $_GET["error"];
        $template = str_replace("%%USERNAME%%", $username, $template);
        $template = str_replace("%%ERROR%%", $error, $template);
        $template = $lc->loadText("login", $template);
        echo $template;
        unset($username);
        unset($error);
        exit(0);
    }

    //---------------------------- catch action=LOGOUT
    if($_GET["action"] == "LOGOUT"){
        unset($_SESSION["username"]);
        session_destroy();
        header("Location: /");
        exit(0);
    }

    //---------------------------- catch action=TRANSACTION
    if($_GET["action"] == "TRANSACTION"){
        $temp = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/templates/transaction.html");
        $temp = $lc->loadText("transaction", $temp);
        echo $temp;
        exit(0);
    }

    //---------------------------- catch action=NEWACCOUNT
    if($_GET["action"] == "NEWACCOUNT"){
        $temp = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/templates/newaccount.html");
        $temp = $lc->loadText("newaccount", $temp);
        echo $temp;
        exit(0);
    }

    //---------------------------- catch action=ACCOUNTS
    if($_GET["action"] == "ACCOUNTS"){
        $temp = file_get_contents($_SERVER["DOCUMENT_ROOT"] . "/templates/accounts.html");
        $ac = new Account();
        $table = $ac->getTable($_SESSION["id"]);
        $temp = str_replace("%%DATA%%", $table, $temp);
        $temp = $lc->loadText("accounts", $temp);
        echo $temp;
        exit(0);
    }
}


//load home if nothing gets caught
$home = file_get_contents("templates/home.html");
$home = $lc->loadText("home", $home);
$home = str_replace("%%MAIN_IFRAME_URL%%", "/?action=HISTORY", $home);
echo $home;

//*************************************************************************************
