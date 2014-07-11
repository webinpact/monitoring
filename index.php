<?php
/*
 * Pingusman - Created on 2014-05-08
 * Main Page
 * https://github.com/webinpact/monitoring
 */

include "includes/top.php";
include "includes/top_html.php";


switch($_GET['do']) {
    case 'login':
        echo displayLoginForm();
        break;
    default:
        echo 'DASHBOARD';
        break;
}









include "includes/footer_html.php";
include "includes/footer.php";

?>