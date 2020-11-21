<?php

require_once "lib/sql/Query.php";
require_once "lib/sql/DBC.php";

class DBGenerator {

    function generate($arr){
        $q = new Query();
        $conn = new DBC();
        if($conn->isNotDB()){
            $conn->exec("CREATE DATABASE " .  $GLOBALS["config"]["db"] . ";");
            $conn->exec("USE " . $GLOBALS["config"]["db"] . ";");
        }
        
        foreach( $arr["tables"] as &$array ){
            $q->clear();
            $q->createFromArray($array, true);
            try{
                $conn->exec($q->getQuery());
            }catch(Exception $e){
                echo "<pre>", $e->getMessage(), "</pre>";
            }
        }
    }

    function integrity($arr){
        $q = new Query();
        foreach( $arr["tables"] as &$array ){
            $q->clear();
            $q->isTable($array["tbname"], $arr["schema"]);
            echo $q->getQuery(), "<br/>";
            $q->clear();
            $q->getFields($array["tbname"]);
            echo $q->getQuery(), "<br/>";
            foreach($array["fields"] as $name => &$field){
                
            }
            echo "<br/>";
        }
    }

}