<?php
/**
 * Created by PhpStorm.
 * User: pingusman
 * Date: 08/05/14
 * Time: 13:36
 */

//New Install ?
if(!file_exists("config.php")) {
    header("Location: install/");
}

//Logged ?
if(!isset($_COOKIE['logged']) && !$_GET['do']=="login") {
    header("Location: index.php?do=login");
}

//Load functions
include "includes/"





?>