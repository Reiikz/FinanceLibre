<?php

include_once "SQL/MySQL.php";
include_once "../config/config.php";


class User extends MySQL{


    public function save(){
        if($this->usernameExists($username)){
            $name_ = $this->real_escape_string($this->name);
            $locale_ = $this->real_escape_string($this->locale);
            $password_ = $this->password;
            $username = $this->real_escape_string($this->username);
            $q ="UPDATE fcl_user SET `username`='$username_', `password`='$password_', `name`='$name_', `locale`='$locale_';";        
            return $this->query($q);
        }else{
            throw new Exception("%%Message_username_doesnt_exist_at_save%%");
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
            throw new Exception("%%Message_username_already_exist_at_new%%");
        }else{
            $name_ = $this->real_escape_string($this->name);
            $locale_ = $this->real_escape_string($this->locale);
            $password_ = $this->password;
            $username = $this->real_escape_string($this->username);
            $q ="INSERT INTO fcl_user(`username`, `password`, `name`, `locale`) VALUES('$username_', '$password_', '$name_', '$locale_');";        
            return $this->query($q);
        }
        
    }

    public function close(){
        $conn->close()();
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