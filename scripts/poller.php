<?php
/*
 * This script must be added in the crontab to run frequently
 * Get current value for all configured sensors in database
 * Log them into table poller_data
 */

//load config and functions
set_include_path(realpath(dirname(__FILE__)."/..")."/");
include "config.php";
include "includes/database.php";

//get sensors
$query = sql("SELECT * FROM hosts_sensors
              JOIN hosts ON (hosts.host_id=hosts_sensors.host_id)");
$poller_data = array();
while($sensor = mysql_fetch_array($query)) {

    $value = snmpget($sensor['host_ip'], "public", $sensor['sensor_value']);

    //clean data
    if(substr($value,0,7)=="STRING:") {
        $value = str_replace('STRING: "','',$value); //remove STRING: " at the beginning
        $value = substr($value,0,strlen($value)-1);//remove last "
    }
    elseif(substr($value,0,8)=="INTEGER:") {
        $value = (int)str_replace('INTEGER: ','',$value); //remove INTEGER: at the beginning
    }


    $poller_data[] = "('".$sensor['sensor_id']."','".db($value)."','".date("Y-m-d H:i:s")."')";

}

sql("INSERT INTO poller_data (sensor_id, value, log_date)
    VALUES ".implode(",",$poller_data)."");



?>