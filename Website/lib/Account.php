<?php


include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/SQL/MySQL.php";
include_once $_SERVER["DOCUMENT_ROOT"] . "/lib/Data/AccountData.php";

class Account extends MySQL {

    public function saveNew(AccountData $d){
        $name_ = $this->real_escape_string($d->name);
        $currency_ = $this->real_escape_string($d->currency);
        $balance_ = 0.0;
        $type_ = $this->real_escape_string($d->type);
        $description_ = $this->real_escape_string($d->description);
        $user_id_ = $d->user_id;
        //$q = "SELECT EXISTS (SELECT * FROM fcl_" have to do the prefix thingy

        $q = "INSERT INTO fcl_account(`user_id`, `name`, `currency`, `balance`, `type`, `description`) VALUES($user_id_, '$name_', '$currency_', $balance_, '$type_', '$description_');";
        return $this->query($q);
    }
    
    public function getAll($us){
        $q = "SELECT * FROM fcl_account WHERE user_id = $us;";
        $result = $this->query($q);
        while($row = $result->fetch_array(MYSQLI_ASSOC)){
            $ac = new AccountData();
            $ac->id             = $row["id"];
            $ac->user_username  = $us;
            $ac->user_id        = $row["user_id"];
            $ac->name           = $row["name"];
            $ac->currency       = $row["currency"];
            $ac->balance        = $row["balance"];
            $ac->type           = $row["type"];
            $ac->description    = $row["description"];
            $out[] = $ac;
        }
        if(! isset($out)){
            return 0;
        }else{
            return $out;
        }
    }

    public function getTable($us){
        $in = $this->getAll($us);
        if($in === 0) return 0;
        $out="";
        foreach($in as $ac){
            $out .= "<tr><td>" . $ac->name . "</td>";
            $out .= "<td>" . $ac->description . "</td>";
            $out .= "<td>" . $ac->currency . "</td>";
            $out .= "<td>" . $ac->balance . "</td>";
            $out .= "<td><form action='/actions/accounts/delete.php' method='POST'> <input class='delete_button' type='submit' name='delete' value='%text_delete%'/> <input type='hidden' value='" . $ac->id . "' name='id'/></form></td>";
            $out .= "<td><a class='edit_button' href='/?action=EDITACCOUNT'>%text_edit%</a></td></tr>";
        }
        return $out;
    }

}