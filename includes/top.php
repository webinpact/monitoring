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

//Action needed ?
$action_result = "";
if($_POST['action']=="add_sensor") {
	if($_POST['name']!="" && $_POST['value']!="" && $_POST['type']!="" && $_POST['host_id']>0) {
		sql("INSERT INTO hosts_sensors (host_id, sensor_type, sensor_value, sensor_name)
		VALUES ('".(int)$_POST['host_id']."','".db($_POST['type'])."','".db($_POST['value'])."','".db($_POST['name'])."')");
		$action_result = "<span style='color:limegreen'>Sensor added</span><br />";
	}
	else {
		$action_result = "<span style='color:red'>Bad sensor parameters. Nothing done.</span><br />";
	}
		
}
elseif($_POST['action']=="add_host") {
    if($_POST['name']!="" && $_POST['description']!="" && $_POST['ip']!="") {
        sql("INSERT INTO hosts (host_name, host_description, host_ip)
        VALUES ('".db($_POST['name'])."','".db($_POST['description'])."','".db($_POST['ip'])."')");
        $action_result = "<span style='color:limegreen'>Host added</span><br />";
    }
    else {
        $action_result = "<span style='color:red'>Bad host parameters. Nothing done.</span><br />";
    }

}






?>