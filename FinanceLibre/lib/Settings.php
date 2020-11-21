<?php

if(function_exists("yaml_parse_file")){
    if(! isset($GLOBALS["config"])) $GLOBALS["config"] = yaml_parse_file("settings/settings.yaml");
}else{
    $GLOBALS["config"] = array(
        "table_pfx" => "fl_",
        "installed" => false,
    );
}

function SaveConfig(){
    yaml_emit_file("settings/settings.yaml", $GLOBALS["config"]);
}