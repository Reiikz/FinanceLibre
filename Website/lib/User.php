<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/SQL/MySQL.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";


class User extends MySQL{


    public function loadByUsername($us){
        $us_ = $this->real_escape_string($us);
        $q = "SELECT * FROM fcl_user WHERE `username` = '$us_'";
        $result = $this->query($q);
        if($row = $result->fetch_array(MYSQLI_ASSOC)){
            $this->username = $row["username"];
            $this->password = $row["password"];
            $this->name = $row["name"];
            $this->locale = $row["locale"];
            $this->id = $row["id"];
            return 1;
        }else{
            return 0;
        }
    }

    public function save(){
        if($this->usernameExists($username)){
            $name_ = $this->real_escape_string($this->name);
            $locale_ = $this->real_escape_string($this->locale);
            $password_ = $this->password;
            $username = $this->real_escape_string($this->username);
            $q ="UPDATE fcl_user SET `username`='$username_', `password`='$password_', `name`='$name_', `locale`='$locale_';";        
            return $this->query($q);
        }else{
            return -1;
        }
    }

    public function usernameExists($name_){
        $name_ = $this->real_escape_string($name_);
        $q="SELECT EXISTS (SELECT * FROM fcl_user WHERE username = '$name_');";
        if( 1 == $this->query($q)->fetch_array(MYSQLI_NUM)[0]){
            return true;
        }else{
            return false;
        }
    }

    public function saveNew(){
        if($this->usernameExists($username)){
            return -1;
        }else{
            $name_ = $this->real_escape_string($this->name);
            $locale_ = $this->real_escape_string($this->locale);
            $password_ = $this->password;
            $username = $this->real_escape_string($this->username);
            $q ="INSERT INTO fcl_user(`username`, `password`, `name`, `locale`) VALUES('$username_', '$password_', '$name_', '$locale_');";        
            return $this->query($q);
        }
        
    }
    
    public function verify($in){
        return password_verify($in, $this->password);
    }

    public function setPassword($in){
        $password = password_hash($in, PASSWORD_DEFAULT);
    }

    private $password;


    public $name;
    public $username;
    public $id;
    public $locale;

}