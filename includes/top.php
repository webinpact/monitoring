<?php

//New Install ?
if(!file_exists("config.php")) {
    header("Location: install/");
}

//Logged ?
if(!isset($_COOKIE['logged']) && !$_GET['do']=="login") {
    header("Location: index.php?do=login");
}

//Load functions
include "includes/display.php";





?>