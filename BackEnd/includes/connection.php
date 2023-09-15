

<?php 

$db_host = "localhost";
$db_user = "root";
$db_password = "1234";
$db_name = "mydb";


try{

    $db = new PDO("mysql:host={$db_host};dbname={$db_name}", $db_user, $db_password);
    $db->setAttribute(PDO::ATTR_AUTOCOMMIT, PDO::ERRMODE_EXCEPTION);
    echo "Success!";
}
catch(PDOException $e){
    echo "Failed to connect". $e->getMessage();
}


?>