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

    $config="<?php
    class CONFIG {
        public static \$db_database   = \"$db_name\";
        public static \$db_prefix     = \"$db_prefix\";
        public static \$db_user       = \"$db_username\";
        public static \$db_password   = \"$db_password\";
        public static \$db_address    = \"$db_server\";
        public static \$db_port       = \"$db_port\";
        public static \$installed     = true;
        public static \$occupied      = false;
    }";

    $free=="<?php
    class CONFIG {
        public static \$db_database   = \" \";
        public static \$db_prefix     = \" \";
        public static \$db_user       = \" \";
        public static \$db_password   = \" \";
        public static \$db_address    = \" \";
        public static \$db_port       = \" \";
        public static \$installed     = false;
        public static \$occupied      = false;
    }";

    $occupied="<?php
    class CONFIG {
        public static \$db_database   = \" \";
        public static \$db_prefix     = \" \";
        public static \$db_user       = \" \";
        public static \$db_password   = \" \";
        public static \$db_address    = \" \";
        public static \$db_port       = \" \";
        public static \$installed     = false;
        public static \$occupied      = true;
    }";

    include_once "../lib/SQL/MySQL.php";
    
    //echo "" . $CONFIG["db_address"] . ", " . $CONFIG["db_user"] . ", " . $CONFIG["db_password"] . ", " . $CONFIG["db_database"] . ", " . $CONFIG["db_port"];
    unlink("../config/config.php") or header("/installer/?error=could not delete file, check your permissions");
    $f = fopen("../config/config.php", 'w') or header("/installer/?error=could not create file, check your permissions");
    fwrite($f, $config);
    fclose($f);
    try {
        $conn = new MySQL();
    }catch (Exception $e){
        unlink("../config/config.php") or header("/installer/?error=could not delete file, check your permissions");
        $f = fopen("../config/config.php", 'w') or header("/installer/?error=could not create file, check your permissions");
        fwrite($f, $free);
        fclose($f);
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

    $script = $conn->parseSqlScript("../lib/SQL/GenerateDatabase.sql");
    foreach($script as $query){
        query($conn, $query, $db_prefix);
    }
    query($conn, "INSERT INTO fcl_user(username, password) VALUES('" . $username . "', '" . password_hash($password, PASSWORD_DEFAULT) . "');", $db_prefix);

    $conn->close();

    unlink("../config/config.php") or header("/installer/?error=could not delete file, check your permissions");
    $f = fopen("../config/config.php", 'w') or header("/installer/?error=could not create file, check your permissions");
    fwrite($f, $config);
    fclose($f);
    header("Location: ../");
}

function query(MySQL $con, $query, $db_prefix){
    if(!$con->query(str_replace("fcl_", $db_prefix, $query)) === true){
        header("Location: /installer/?error=Error running query: '" . $query . "'");
        $occupied="<?php
        class CONFIG {
            public static \$db_database   = \" \";
            public static \$db_prefix     = \" \";
            public static \$db_user       = \" \";
            public static \$db_password   = \" \";
            public static \$db_address    = \" \";
            public static \$db_port       = \" \";
            public static \$installed     = false;
            public static \$occupied      = false;
        }";
        unlink("../config/config.php") or header("/installer/?error=could not delete file, check your permissions");
        $f = fopen("../config/config.php", 'w') or header("/installer/?error=could not create file, check your permissions");
        fwrite($f, $occupied);
        fclose($f);
        die();
    }
}

include "../config/config.php";

if (CONFIG::$installed) header("Location: /index.php" && !isset($_GET["error"]));

if (CONFIG::$occupied) header("Location: /index.php" && !isset($_GET["error"]));

?>