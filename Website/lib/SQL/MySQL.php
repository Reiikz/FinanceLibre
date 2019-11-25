<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";

class MySQL extends mysqli {
    
    private $prefix;

    function __construct(){
        parent::__construct(CONFIG::$db_address, CONFIG::$db_user, CONFIG::$db_password, CONFIG::$db_database, CONFIG::$db_port);
        $this->prefix = CONFIG::$db_prefix;
    }

    function query($in){
        $in = $this->filter($in);
        return parent::query($in);
    }

    private function filter ($in){
        $s1;
        $s2;
        $t = "";
        $s = false;
        $out = "";
        $q = false;
        $keyword = false;
        //echo $in;
        for($i = 0; $i < strlen($in); $i ++){
            $bef = $s;
            $t .= $in[$i];
            if($in[$i] == "(" && strpos($in, 'VALUES') == $i - strlen('VALUES')) $keyword = true;
            if($in[$i] == "(" && strpos($in, 'EXISTS') == $i - strlen('EXISTS')) $keyword = true;
            if((($in[$i] == "'" || $in[$i] == "\"") && $in[$i -1] != "\\") || ( ($in[$i] == "(" || $in[$i] == ")") && ! $q  && ! $keyword) ){
                $s = ! $s;
                if(($in[$i] == "'" || $in[$i] == "\"") && $s == true) $q = true; else $q = false;
            }
            if($s == true && $bef == false){
                $s1[] = $t;
                $t = "";
            }else if($s == false && $bef == true){
                $s2[] = $t;
                $t = "";
            }
            $keyword = false;
        }
        if(!empty($t)){
            $s2[] = $t;
        }
        unset($t);
        unset($s);
        unset($q);
        unset($keyword);
        /*
        echo "<br/><br/><br/>";
        var_dump($s1);
        echo "<br/><br/><br/>";
        var_dump($s2);
        echo "<br/><br/><br/>";*/
        for($i = 0; $i < sizeof($s1); $i++){
            $s1[$i] = preg_replace("/fcl_/", $this->prefix, $s1[$i]);
            $out .= $s1[$i] . $s2[$i];
        }
        //echo $out;
        return $out;
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