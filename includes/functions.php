<?php
/**
 * Main functions of the web interface
 * User: pingusman
 * Date: 08/05/14
 * Time: 19:07
 */

//check login/pass filled by user, put cookies if ok, redirect to main page
function doLogin() {


    setcookie("logged", 1, time()+3600);
    header("Location: index.php");

}

//return an array with the list of hosts created in database
function getAllHosts() {
    $query = sql("SELECT * FROM hosts");
    return mysql_fetch_all($query);
}