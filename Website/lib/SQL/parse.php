<?php

function parse($file) {
    $in =  file_get_contents($file);
    $in = explode("\n", $in);
    $out = array();
    $t ="";
    foreach($in as $val){
        if(strpos($val, "-- ") !== false) continue;
        if(strpos($val, ";") !== false && ! empty($t)) {
            $out[] = $t;
            $t = "";
        }
        $t .= $val;
    }
    return $out;
}