<?php

$s = parseSqlScript("GenerateDatabase.sql");

foreach($s as $d){
    echo "$d \n";
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