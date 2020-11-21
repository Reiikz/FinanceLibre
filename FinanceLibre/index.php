<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once "./lib/Settings.php";

if(!$GLOBALS["config"]["installed"]){
    header("Location: installer/index.php");
}

session_start();
if(!isset($_SESSION["user"])){
    require "core/Login/";
}