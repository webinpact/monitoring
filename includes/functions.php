<?php
/**
 * Main functions of the web interface
 * User: pingusman
 * Date: 08/05/14
 * Time: 19:07
 */

//check login/pass filled by user, put cookies if ok, redirect to main page
function doLogin() {

    if($_POST['login']==WEB_LOGIN && $_POST['password']==WEB_PASSWORD) {
        setcookie("logged", 1, time()+3600);
        header("Location: index.php?do=graphs");
    }
    else {
        header("Location: index.php?do=login&error=1");
    }

}

//logout user
function doLogout() {
    setcookie("logged", 0, time());
    header("Location: index.php");
}

//return an array with the list of hosts created in database
function getAllHosts() {
    $query = sql("SELECT * FROM hosts");
    return mysql_fetch_all($query);
}

//return all informations for one host
function getHostInfos($host_id) {
    $host_infos = array();

    $query = sql("SELECT * FROM hosts WHERE host_id='".(int)$host_id."'");
    if(mysql_num_rows($query)) {
        $host_infos['infos'] = mysql_fetch_array($query);

        $query = sql("SELECT *
        FROM hosts h
        JOIN hosts_sensors hs ON (hs.host_id=h.host_id)
        WHERE h.host_id='".(int)$host_id."'");
        while($array=mysql_fetch_array($query)) {
            $host_infos['sensors'][]=$array;
        }
    }
    else {

        die("No host with this ID ('.$host_id.')");
    }

    return $host_infos;
}

function getSensorOrder($sensor) {
    $query = sql("SELECT sensor_order FROM hosts_sensors WHERE sensor_id='".(int)$sensor."'");
    if(mysql_num_rows($query)) {
        $array = mysql_fetch_array($query);
        return $array['sensor_order'];
    }
    else {
        return false;
    }
}

function getSensorByOrder($host,$order) {
    $query = sql("SELECT sensor_id FROM hosts_sensors WHERE host_id='".(int)$host."' AND sensor_order='".(int)$order."'");
    if(mysql_num_rows($query)) {
        $array = mysql_fetch_array($query);
        return $array['sensor_id'];
    }
    else {
        echo "SELECT sensor_id FROM hosts_sensors WHERE host_id='".(int)$host."' AND sensor_order='".(int)$order."'";
        return false;
    }
}