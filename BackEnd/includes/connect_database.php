<?php 
session_start();
$db_host = "161.246.127.24";
$db_port = 9069;
$db_user = "clmonqc1u002obsmnf8f9h7my";
$db_password = "77o93FGfV3QfYHEAuIxyMrH4";
$db_name = "dbtesto";

try {
    // เชื่อมต่อกับ MySQL
    $db = new PDO("mysql:host=$db_host;port=$db_port;dbname=$db_name", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Success!";
}
catch(PDOException $e){
    echo "Failed to connect". $e->getMessage();
}


?>