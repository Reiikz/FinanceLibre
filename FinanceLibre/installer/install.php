<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

chdir("../");

//basic persistance
require_once "lib/sql/Query.php";
require_once "lib/sql/DBGenerator.php";

//data structure libraries
require_once "lib/Data/User.php";

if(isset($_POST["install"])){
    $ds = yaml_parse_file("source/datasets/database.yaml");
    $ds["schema"] = $_POST["db"];
    $GLOBALS["config"]["dbtype"] = $_POST["dbtype"];
    $GLOBALS["config"]["dbaddr"] = $_POST["dbaddr"];
    $GLOBALS["config"]["dbport"] = $_POST["dbport"];
    $GLOBALS["config"]["db"] = $_POST["db"];
    $GLOBALS["config"]["branding"] = $_POST["db"];
    $GLOBALS["config"]["dbpass"] = $_POST["dbpass"];
    $GLOBALS["config"]["dbpfx"] = $_POST["dbpfx"];
    $GLOBALS["config"]["dbuser"] = $_POST["dbuser"];
    session_start();
    SaveConfig();
    $d = new DBGenerator();
    $d->generate($ds);
    $user = new User();
    $user->setPassword($_POST["password"]);
    $user->username = $_POST["username"];
    if ($user->add()) $_SESSION["user"] = $user;
    $GLOBALS["config"]["installed"] = true;
    SaveConfig();
    header("Location: ../index.php");
}else{
    header("Location: index.php");
}

