<?php

require_once "lib/sql/Query.php";
require_once "lib/sql/DBC.php";


class User{

    public $username;
    private $password;

    function __construct(){

    }

    function add(){
        $q = new Query();
        $conn = new DBC();
        $st = $q->insert($conn, "user", array(":username" => "$this->username",
                                              ":password" => "$this->password"
        ));
        try{
            $st->execute();
        }catch(Exception $e){
            return false;
            // echo "<pre>", $e->getMessage(), "</pre>";
        }
        return true;
    }

    function isPassword($in){
        return password_verify($in, $this->password, PASSWORD_DEFAULT);
    }

    function setPassword($in){
        $this->password = password_hash($in, PASSWORD_DEFAULT);
    }

}