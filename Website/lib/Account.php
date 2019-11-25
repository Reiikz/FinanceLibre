<?php


include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/SQL/MySQL.php";


class Account extends MySQL {



    public function saveNew(){
        $name_ = $this->real_escape_string($this->name);
        $currency_ = $this->real_escape_string($this->currency);
        $balance_ = 0.0;
        $type_ = $this->real_escape_string($this->type);
        $description_ = $this->real_escape_string($this->description);
        $user_id_ = $this->user_id;
        //$q = "SELECT EXISTS (SELECT * FROM fcl_" have to do the prefix thingy

        $q = "INSERT INTO fcl_account(`user_id`, `name`, `currency`, `balance`, `type`, `description`) VALUES($user_id_, '$name_', '$currency_', $balance_, '$type_', '$description_');";
        return $this->query($q);
    }

    public $id;
    public $user_username;
    public $user_id;
    public $name;
    public $currency;
    public $balance;
    public $type;
    public $description;
    
}