<?php

include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/SQL/MySQL.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/Data/UserData.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/config/config.php";


class User extends MySQL{


    public function loadByUsername($us){
        $us_ = $this->real_escape_string($us);
        $q = "SELECT * FROM fcl_user WHERE `username` = '$us_'";
        $user = new UserData();
        $result = $this->query($q);
        if($row = $result->fetch_array(MYSQLI_ASSOC)){
            $user->username = $row["username"];
            $user->password = $row["password"];
            $user->name = $row["name"];
            $user->locale = $row["locale"];
            $user->id = $row["id"];
            return $user;
        }else{
            return 0;
        }
    }

    public function save(UserData $user){
        if($this->usernameExists($username)){
            $name_ = $this->real_escape_string($user->name);
            $locale_ = $this->real_escape_string($user->locale);
            $password_ = $user->password;
            $username = $this->real_escape_string($user->username);
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

    public function saveNew(UserData $user){
        if($this->usernameExists($user->username)){
            return -1;
        }else{
            $name_ = $this->real_escape_string($user->name);
            $locale_ = $this->real_escape_string($user->locale);
            $password_ = $user->password;
            $username = $this->real_escape_string($user->username);
            $q ="INSERT INTO fcl_user(`username`, `password`, `name`, `locale`) VALUES('$username_', '$password_', '$name_', '$locale_');";        
            return $this->query($q);
        }
        
    }

    

}