<?php

class MySQL extends mysqli {
    function __construct($CONFIG){
        parent::__construct($CONFIG["db_address"], $CONFIG["db_user"], $CONFIG["db_password"], $CONFIG["db_database"], $CONFIG["db_port"]);
    }
}