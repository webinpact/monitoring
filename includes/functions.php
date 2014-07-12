<?php
/**
 * Main functions of the web interface
 * User: pingusman
 * Date: 08/05/14
 * Time: 19:07
 */

function doLogin() {


    setcookie("logged", 1, time()+3600);
    header("Location: index.php");

}