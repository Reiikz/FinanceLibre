<?php

require_once "lib/Settings.php";
require_once "lib/StrUtils.php";

class Query {

    public function __construct(){
        $this->tablepfx = $GLOBALS["config"]["table_pfx"];
        $this->query = "";
    }

    private $tablepfx;

    private $query;

    function false(){
        $this->query .= " FALSE ";
        return $this;
    }

    function true(){
        $this->query .= " TRUE ";
        return $this;
    }

    function equals(){
        $this->query .= " = ";
        return $this;
    }

    function and(){
        $this->query .= " AND ";
        return $this;
    }

    function or(){
        $this->query .= " OR ";
        return $this;
    }

    function not(){
        $this->query .= " NOT ";
        return $this;
    }

    function from(){
        $this->query .= " FROM ";
        return $this;
    }

    function all(){
        $this->query .= " * ";
        return $this;
    }

    function insert(DBC $conn, $table, $data){
        $this->query = "INSERT INTO `$this->tablepfx$table`( ";
        $values="VALUES(";
        foreach($data as $field => &$value){
            $f = str_replace(":", "", $field);
            $this->query .= "`$f`, ";
            $values .= "$field, ";
        }
        $this->query = str_lreplace(",", "", $this->query);
        $this->query .= ") ";
        $values = str_lreplace(",", "", $values);
        $values .= ")";
        $this->query .= $values;
        $st = $conn->prepare($this->getQuery());
        foreach($data as $key => &$val){
            $st->bindParam($key, $val);
        }
        return $st;
    }

    function createFromArray($array, $includepfx){
        
        switch($array["type"]){

            case "database":{
                $this->query = "CREATE DATABASE " . str_replace(" ", "_", $array["dbname"]);
                break;
            }

            case "table":{

                //parse field definitions
                $this->query = "CREATE TABLE ";
                if($includepfx){
                    $this->query .= "`" . $this->tablepfx;
                }else{
                    $this->query .= "`";
                }
                $this->query .= $array["tbname"] . "`( ";

                foreach($array["fields"] as $key => $val){
                     
                    $this->query .= "`$key` " . strtoupper($val["type"]);
                    if($val["nn"] === true){
                        $this->query .= " NOT NULL";
                    }
                    if($val["ai"] === true){
                        $this->query .= " AUTO_INCREMENT";
                    }
                    $this->query .= ", ";

                }

                //parse primary keys definitions
                if(isset($array["primary"])){
                    $this->query .= "PRIMARY KEY( ";
                    foreach($array["primary"] as $val){
                        $this->query .= "`$val`, ";
                    }
                    $this->query = str_lreplace(",", "", $this->query);
                    $this->query .= " ), ";
                }

                //parse foreign keys
                if(isset($array["foreign"])){
                    // foreach($array["foreign"] as $key => $val){
                    //     $this->query .= "INDEX `fk_$key" . "_idx` (`$key` ASC) VISIBLE, ";
                    // }
                    foreach($array["foreign"] as $key => $val){
                        $this->query .= "FOREIGN KEY( `$key` ) REFERENCES `" . $this->tablepfx . $val["table"] . "`(`" . $val["references"] . "`) ON DELETE " . strtoupper($val["delete"]) . " ON UPDATE " . strtoupper($val["update"]) . ", ";
                    }
                    $this->query = str_lreplace(", ", "", $this->query);
                }else{
                    $this->query = str_lreplace(",", "", $this->query);
                }

                //$this->query = str_lreplace(", ", "", $this->query);

                $this->query .= " )";
                break;
            }

        }

        return $this;
    }

    function isTable($table, $schema){
        // $this->query = "SELECT EXISTS(SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = '$schema' AND TABLE_NAME = '$table')";
        $this->query = "SHOW TABLES WHERE Tables_in_$schema = '" . $this->tablepfx . "$table'";
        return $this;
    }

    function getFields($table){
        $this->query = "SHOW FIELDS FROM `" . $this->tablepfx . "$table`";
    }

    function select(){
        $this->query .= "SELECT ";
        return $this;
    }

    function where(){
        $this->query .= " WHERE ";
        return $this;
    }

    function text($text){
        $this->query .= " '" . $text . "' ";
        return $this;
    }

    function field($table, $field){
        $table = str_replace(" ", "_", $table);
        $field = str_replace(" ", "_", $field);

        $this->query .= " `" . $this->tablepfx . "$table`.`$field` ";

        return $this;
    }

    function inner_join($table_to_join, $origin_table, $operator, $fk_join, $fk_origin){
        $table_to_join = str_replace(" ", "_", $table_to_join);
        $origin_table = str_replace(" ", "_", $origin_table);
        $fk_join = str_replace(" ", "_", $fk_join);
        $fk_origin = str_replace(" ", "_", $fk_origin);

        $this->query .= " INNER JOIN `$this->tablepfx$table_to_join` ON `$this->tablepfx$table_to_join`.`$fk_join $operator` `$this->tablepfx$origin_table`.`$fk_origin` ";
        return $this;
    }

    function table($tableName){
        $tableName = str_replace(" ", "_", $tableName);
        $this->query .= " `$this->tablepfx$tableName`";
        return $this;
    }

    function getQuery(){
        if(empty($this->query)){
            return false;
        }
        return "$this->query;";
    }

    function clear(){
        $this->query = "";
    }

}