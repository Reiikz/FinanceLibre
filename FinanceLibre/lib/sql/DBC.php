<?php

require_once "lib/Settings.php";

class DBC extends PDO{
    
    private $nodb;

    function __construct(){
        $_conn_string = $GLOBALS["config"]["dbtype"] . ":host=" . $GLOBALS["config"]["dbaddr"] . ":" . $GLOBALS["config"]["dbport"] . ";dbname=" . $GLOBALS["config"]["db"] . ";";
        $_conn_string_nodb = $GLOBALS["config"]["dbtype"] . ":host=" . $GLOBALS["config"]["dbaddr"] . ":" . $GLOBALS["config"]["dbport"];
        try{
            parent::__construct($_conn_string, $GLOBALS["config"]["dbuser"], $GLOBALS["config"]["dbpass"]);
            $this->nodb = false;
        }catch(Exception $e){
            parent::__construct($_conn_string_nodb, $GLOBALS["config"]["dbuser"], $GLOBALS["config"]["dbpass"]);
            $this->nodb = true;
        }
        $this->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function isNotDB(){
        return $this->nodb;
    }

    function currDate(){
        return date("Y-m-d H:i:s", time());
    }

    function date($timestamp){
        return date("Y-m-d H:i:s", $timestamp);
    }

}