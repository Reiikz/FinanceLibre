<?php

class MySQL extends mysqli {
    function __construct($CONFIG){
        parent::__construct($CONFIG["db_address"], $CONFIG["db_user"], $CONFIG["db_password"], $CONFIG["db_database"], $CONFIG["db_port"]);
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