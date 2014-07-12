<?php
/*
 * Pingusman - Created on 2014-05-08
 * Main Page
 * https://github.com/webinpact/monitoring
 */

include "includes/top.php";
include "includes/top_html.php";

$do = $_POST['do'];
if($_GET['do']) $do=$_GET['do'];

switch($do) {
    case 'login':
        echo getLoginForm();
        break;
    default:
        echo getDashBoard();
        break;
}









include "includes/footer_html.php";
include "includes/footer.php";

?>