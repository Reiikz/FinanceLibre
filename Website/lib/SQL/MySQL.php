<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";

class MySQL extends mysqli {
    
    private $prefix;

    function __construct(){
        parent::__construct(CONFIG::$db_address, CONFIG::$db_user, CONFIG::$db_password, CONFIG::$db_database, CONFIG::$db_port);
        $this->prefix = CONFIG::$db_prefix;
    }

    function query($in){
        $in = preg_replace("/fcl_/", $this->prefix, $in, 1);
        return parent::query($in);
    }

    function parseSqlScript($file) {
        $in =  file_get_contents($file);
        $in = explode("\n", $in);
        $out = array();
        $t ="";
        foreach($in as $val){
            if(strpos($val, "-- ") !== false) continue;
            $t .= $val;
            if(strpos($t, ";") !== false) {
                $out[] = $t;
                $t = "";
            }
        }
        return $out;
    }
}