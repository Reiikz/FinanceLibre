<html>

    <head>
        <title>
            FinanceLibre Installer
        </title>
    </head>
    
    <style>
            .wrapper{
                display: grid;
                grid-template-columns: 1fr;
                grid-template-rows: auto;
                text-align:center;
            }

            input{
                width: 300px;
            }

            .error{
                margin-left: calc(50% - 150px);
                margin-right: calc(50% - 150px);
                font-size:20px;
                font-weight:bold;
                color: red;
                border: 3px solid red;
            }
    </style>

    <body>

        <div class='wrapper'>
        <?php
                if (isset($_GET["error"]))
                {
                    $out = str_replace("<", "&lt", $_GET["error"]);
                    $out = str_replace(">", "&gt", $out);
                    $out = str_replace("&ltbr/&gt", "<br/>", $out);
                    echo "<div class='error'>\n";
                    echo "$out \n";
                    echo "</div>\n";
                }

            ?>

        <div class='smallForm'>

                <form action='/installer/index.php' method='POST'>
                    <h1> User </h1>
                        <input type='text' name='username' placeholder='Username'/> <br/> <br/>

                        <input type='password' name='password' placeholder='password'/>

                    <h1> Databse Config </h1>

                        <input type='text' name='database' placeholder='Database Name'/> <br/> <br/>

                        <input type='text' name='database_prefix' placeholder='Database Prefix' value='fcl_' /> <br/> <br/>

                        <input type='text' name='database_username' placeholder='Database Username'/> <br/> <br/>

                        <input type='password' name='database_password' placeholder='Database Password'/> <br/> <br/>

                        <input type='text' name='database_server' placeholder='Server address (localhost:3306)' value='localhost:3306'/> <br/> <br/>

                        <input type='submit' name='install' value='Install FinanceLibre'/>

                </form>
            </div>
        </div>

    </body>

</html>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if(isset($_POST["install"])){

    $username = $_POST["username"];
    $password = $_POST["password"];
    $db_name = $_POST["database"];
    $db_prefix = $_POST["database_prefix"];
    $db_username = $_POST["database_username"];
    $db_password = $_POST["database_password"];
    $db_server = explode(":", $_POST["database_server"])[0];
    $db_port = explode(":", $_POST["database_server"])[1];

    if(empty($username)){
        header("Location: /installer/?error=Username empty!");
        die();
    }

    if(empty($password)){
        header("Location: /installer/?error=Password empty!");
        die();
    }

    if(empty($db_name)){
        header("Location: /installer/?error=Database Name empty!");
        die();
    }

    if(empty($db_prefix)){
        header("Location: /installer/?error=Database Prefix empty!");
        die();
    }

    if(empty($db_username)){
        header("Location: /installer/?error=Database Usernmae empty!");
        die();
    }

    if(empty($db_password)){
        header("Location: /installer/?error=Database password empty!");
        die();
    }

    if(empty($db_server)){
        header("Location: /installer/?error=Database Server empty!");
        die();
    }

    if(empty($db_port)){
        header("Location: /installer/?error=Database Port empty!");
        die();
    }

    $CONFIG = array(
        'db_database'   => "$db_name",
        'db_prefix'     => "$db_prefix",
        'db_user'       => "$db_username",
        'db_password'   => "$db_password",
        'db_address'    => "$db_server",
        'db_port'       => "$db_port",
        'installed' => true,
        'occupied' => false,
    );

    $config="<?php
    \$CONFIG = array(
        'db_database'   => \"$db_name\",
        'db_prefix'     => \"$db_prefix\",
        'db_user'       => \"$db_username\",
        'db_password'   => \"$db_password\",
        'db_address'    => \"$db_server\",
        'db_port'       => \"$db_port\",
        'installed' => true,
        'occupied' => false,
    );";

    $occupied="<?php
    \$CONFIG = array(
        'installed' => false,
        'occupied' => true,
    );";

    include_once "../lib/SQL/MySQL.php";
    //echo "" . $CONFIG["db_address"] . ", " . $CONFIG["db_user"] . ", " . $CONFIG["db_password"] . ", " . $CONFIG["db_database"] . ", " . $CONFIG["db_port"];
    try {
        $conn = new MySQL($CONFIG);
    }catch (Exception $e){
        header("Location: /installer/?error='" . $e->getMessage() . "'");
        die();
    }
    
    if($conn->connect_error){
        header("Location: /installer/?error='" . $conn->connect_error . "'");
        die();
    }
    
    unlink("../config/config.php") or header("/installer/?error=could not delete file, check your permissions");
    $f = fopen("../config/config.php", 'w') or header("/installer/?error=could not create file, check your permissions");
    fwrite($f, $occupied);
    fclose($f);

    //Redirect to another file that shows that mail queued
    header("Location: /index.php");

    //Erase the output buffer
    ob_end_clean();

    //Tell the browser that the connection's closed
    header("Connection: close");

    //Ignore the user's abort (which we caused with the redirect).
    ignore_user_abort(true);
    //Extend time limit to 30 minutes
    set_time_limit(1800);
    //Extend memory limit to 10MB
    //ini_set("memory_limit","10M");
    //Start output buffering again
    ob_start();

    //Tell the browser we're serious... there's really
    //nothing else to receive from this page.
    header("Content-Length: 0");

    //Send the output buffer and turn output buffering off.
    ob_end_flush();
    flush();
    //Close the session.
    session_write_close();
    
    query($conn, "SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0;");
    query($conn, "SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0;");
    query($conn, "SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='ONLY_FULL_GROUP_BY,STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION';");
    query($conn, "DROP SCHEMA IF EXISTS `FinanceLibre`;");
    query($conn, "CREATE SCHEMA IF NOT EXISTS `FinanceLibre` ;");
    query($conn, "USE `FinanceLibre` ;");
    query($conn, "CREATE TABLE IF NOT EXISTS `FinanceLibre`.`" . $db_prefix . "user` (`id` INT NOT NULL AUTO_INCREMENT, `username` VARCHAR(45) NOT NULL, `password` VARCHAR(200) NOT NULL, PRIMARY KEY (`id`), UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE) ENGINE = InnoDB;");
    query($conn, "CREATE TABLE IF NOT EXISTS `FinanceLibre`.`" . $db_prefix . "account` (`id` INT NOT NULL AUTO_INCREMENT,`user_id` INT NOT NULL,`name` VARCHAR(100) NOT NULL,`currency` VARCHAR(45) NULL,`balance` DOUBLE NULL,PRIMARY KEY (`id`),INDEX `fk_account_user_idx` (`user_id` ASC) VISIBLE,CONSTRAINT `fk_account_user`  FOREIGN KEY (`user_id`)  REFERENCES `FinanceLibre`.`fcl_user` (`id`)  ON DELETE NO ACTION  ON UPDATE NO ACTION) ENGINE = InnoDB;");
    query($conn, "CREATE TABLE IF NOT EXISTS `FinanceLibre`.`" . $db_prefix . "transaction` ( `id` INT NOT NULL AUTO_INCREMENT, `amount` DOUBLE NOT NULL, `short` VARCHAR(45) NOT NULL, `description` VARCHAR(300) NULL, `date` DATETIME(4) NOT NULL, `from_account` INT NOT NULL, `to_account` INT NOT NULL, PRIMARY KEY (`id`), INDEX `fk_fcl_transaction_flc_account1_idx` (`from_account` ASC) VISIBLE, INDEX `fk_fcl_transaction_flc_account2_idx` (`to_account` ASC) VISIBLE, CONSTRAINT `fk_fcl_transaction_flc_account1` FOREIGN KEY (`from_account`) REFERENCES `FinanceLibre`.`flc_account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION, CONSTRAINT `fk_fcl_transaction_flc_account2` FOREIGN KEY (`to_account`) REFERENCES `FinanceLibre`.`flc_account` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION) ENGINE = InnoDB;");
    query($conn, "SET SQL_MODE=@OLD_SQL_MODE;");
    query($conn, "SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS;");
    query($conn, "SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS;");
    query($conn, "INSERT INTO " . $db_prefix . "user(username, password) VALUES('" . $username . "', '" . password_hash($password, PASSWORD_DEFAULT) . "');");

    $conn->close();

    unlink("../config/config.php") or header("/installer/?error=could not delete file, check your permissions");
    $f = fopen("../config/config.php", 'w') or header("/installer/?error=could not create file, check your permissions");
    fwrite($f, $config);
    fclose($f);
}

function query(MySQL $con, $query){
    if(!$con->query($query) === true){
        header("Location: /installer/?error=Error running query: '" . $query . "'");
        die();
    }
}

include "../config/config.php";

if ($CONFIG["installed"]) header("Location: /index.php");

if ($CONFIG["occupied"]) header("Location: /index.php");

?>