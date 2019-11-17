<?php

include "./config/config.php";

if (!$CONFIG["installed"])
{
    header("Location: installer");
}

if ($CONFIG["occupied"]){
    header("Location: occupied.html");
}
