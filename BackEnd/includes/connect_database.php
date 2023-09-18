<?php 

$db_host = "161.246.127.24";
$db_user = "clmonqc1u002obsmnf8f9h7my";
$db_password = "clmonqc1u002obsmnf8f9h7my";
$db_name = "dbtesto";


try{
    $db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_AUTOCOMMIT, PDO::ERRMODE_EXCEPTION);
    //echo "Success!";
}
catch(PDOException $e){
    echo "Failed to connect". $e->getMessage();
}


?>