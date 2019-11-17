<?php

include "config/config.php";

if (!$CONFIG["installed"])
{
    header("Location: installer")
}
