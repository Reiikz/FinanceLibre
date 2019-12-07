<?php

class UserData{
    
    public function verify($in){
        return password_verify($in, $this->password);
    }

    public function setPassword($in){
        $password = password_hash($in, PASSWORD_DEFAULT);
    }

    public $password;
    public $name;
    public $username;
    public $id;
    public $locale;
}