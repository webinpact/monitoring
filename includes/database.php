<?php
//connect to database
$link = mysql_connect(DB_HOST,DB_LOGIN,DB_PASSWORD) or die("Unable to connect to mysql server : ".mysql_error());
mysql_select_db(DB_NAME,$link) or die("Unable to find database : ".mysql_error());

//execute mysql query with error management
function sql($query) {
    global $link;
    $return = mysql_query($query);
    if (mysql_error() && ADMIN_EMAIL) {
        $message_destinataire = ADMIN_EMAIL;
        $message_titre = "Mysql Error" ;
        $message_corps = "Mysql error on " . $_SERVER['REQUEST_URI'] . "\r\n" .
            "Error message :\r\n" .
            mysql_error() . "\r\n" .
            "----------------------------------------------\r\n" .
            "SQL Query : \r\n" .
            $query. "\r\n" .
            "----------------------------------------------\r\n" .
            "Debug SERVER : \r\n" .
            print_r($_SERVER, true) . "\r\n" .
            "----------------------------------------------\r\n" .
            "Debug REQUEST : \r\n" .
            print_r($_REQUEST, true) . "\r\n" .
            "----------------------------------------------\r\n" .
            "DEBUG COOKIE : \r\n" .
            print_r($_COOKIE, true) . "\r\n" ;
        //echo $message_corps;
        mail($message_destinataire, $message_titre, $message_corps);
        die("Database query error");
    }
    return $return;
}

//add slashes to parameters of mysql query to avoid injection
function db($var) {
    return addslashes($var);
}

//fetch all results of a query into an array
function mysql_fetch_all($result) {
    while($row=mysql_fetch_array($result)) {
        $return[] = $row;
    }
    return $return;
}
?>