<?php

//New Install ?
if(!file_exists("config.php")) {
    header("Location: install/");
}
else {
    include "config.php";
}


//Load functions
include "includes/display.php";
include "includes/functions.php";
include "includes/database.php";

//Logged ?
if($_POST['do']=="login_valid") {
    doLogin();
}
elseif(!isset($_COOKIE['logged']) && !$_GET['do']=="login") {
    header("Location: index.php?do=login");
}






?>