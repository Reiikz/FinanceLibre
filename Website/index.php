<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//includes
include "lib/locale/LocaleLoader.php";


//--------------------------- check server state ------------------------------------
include "./config/config.php";

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

    //---------------------------- catch action=login
    if($_GET["action"] == "LOGIN"){
        $template = file_get_contents("templates/login.html");
        $template = $lc->loadText("login", $template);
        $username="";
        $error="";
        if(isset($_GET["username"])) $username = $_GET["username"];
        if(isset($_GET["error"])) $error = $_GET["error"];
        $template = str_replace("%%USERNAME%%", $username, $template);
        $template = str_replace("%%ERROR%%", $error, $template);
        echo $template;
        unset($username);
        unset($eror);
        exit(0);
    }
}


//load home if nothing gets caught
$home = file_get_contents("templates/home.html");
$home = $lc->loadText("home", $home);
$home = str_replace("%%MAIN_IFRAME_URL%%", "/?action=HISTORY", $home);
echo $home;

//*************************************************************************************
