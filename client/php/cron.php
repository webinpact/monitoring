<?php
/**
 * Run commands and save results
 * User: pingusman
 * Date: 08/05/14
 * Time: 18:53
 */
$run_date = date("Y-m-d H:i:s");
$run_minute = date("i");

include "config.client.php";
include "functions.php";

//Run update commands if necessary
if($minute%UPDATE_INTERVAL==0) {
    include "update.php";
}

//Open file with commands to run


//Run commands


//Save results

?>