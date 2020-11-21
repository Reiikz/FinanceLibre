<html>

    <header>

        <title>
            FinanceLibre Installer
        </title>

        <style>
            body{
                background-color: #fff7d9;
            }

            .wrapper{
                text-align: center;
            }

            .formbox{
                font-family: sans;
                background-color: #b5d490;
                display: grid;
                grid-column: 1;
                grid-row: auto;
                height: auto;
                margin: 50px auto;
                padding: 10px;
                position: relative;
                width: max-content;
                min-width: 300px;
                max-width: 700px;
                border: 2px solid #879e6c;
                border-radius: 3px;
                box-shadow: 6px 3px rgba(163, 163, 163, .6);
            }

            .formbox input{
                border-radius: 0x;
                font-family: sans;
                margin: 5px;
            }

            .inputField{
                margin: 25px;
            }

            .err{
                margin: auto;
                text-align: center;
                width: max-content;
                max-width: 600px;
                color: #8b2ec9;
                border: 2px solid #c9b42e;
                padding: 1em;
                word-wrap: break-word;
            }

            .err:empty{
                display:none;
            }

        </style>

        <script type="text/javascript" src="../lib/sql/GetAvailableDrivers.php"></script>
        <script type="text/javascript">

            function Load() {
                combo = document.getElementById("dbtype");
                for( c = 0; c < MySQLDrivers.length; c++ ) {
                    combo.innerHTML = combo.innerHTML + " <option value='" + MySQLDrivers[c] + "'>" + MySQLDrivers[c] + "</option>\n";
                }
            }
        
        </script>
    
    </header>

    <body OnLoad='Load();'>

        <div class="wrapper">

            <div class="formbox">

                <div class="err"><?php
                        if (!extension_loaded('mysqli')) {
                        echo "ERROR: php extension mysqli is missing";
                        }
                        if(!extension_loaded("yaml")){
                        echo "ERROR: php extension yaml is missing<br/>";
                        echo "to install php-yaml on debian use: sudo apt install php-yaml -y";
                        }
                ?></div>

                <div>

                    <form action='install.php' method='POST'>
                        
                        <div class='inputField'>
                            Branding <br/>
                            <input type='text' name='branding' placeholder='Website Name Brand' value='FinanceLibre'/>
                        </div>

                        <div class='inputField'>
                            Admin Username <br/>
                            <input type='text' name='username' placeholder='Admin Username'/>
                        </div>

                        <div class='inputField'>
                            Admin Password <br/>
                            <input type='password' name='password' placeholder='Admin Password'/>
                        </div>

                        <div class='inputField'>
                            DBMS Username <br/>
                            <input type='text' name='dbuser' placeholder='DBMS User' value='financelibre_user'/>
                        </div>

                        <div class='inputField'>
                            DBMS password <br/>
                            <input type='password' name='dbpass' placeholder='DBMS Password'/>
                        </div>
                        
                        <div class='inputField'>
                            DBMS <br/>
                            <select name="dbtype" id="dbtype">
                            </select>
                        </div>

                        <div class='inputField'>
                            DBMS address <br/>
                            <input type='text' name='dbaddr' placeholder='DBMS Address' value='localhost'/>
                        </div>

                        <div class='inputField'>
                            DBMS Port <br/>
                            <input type='text' name='dbport' placeholder='DBMS Port' value='3306'/>
                        </div>

                        <div class='inputField'>
                            DB Name <br/>
                            <input type='text' name='db' placeholder='DB Name' value='FinanceLibre'/>
                        </div>

                        <div class='inputField'>
                            DB Prefix <br/>
                            <input type='text' name='dbpfx' placeholder='DB Prefix' value='fl_'/>
                        </div>

                        <div class='inputField'>
                            <input type='submit' name='install' value='Install'/>
                        </div>
                        
                        
                    </form>

                </div>

            </div>

        </div>

    </body>

</html>



