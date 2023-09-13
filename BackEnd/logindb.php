<?php
include 'includes/connect_database.php';
session_start();

$username = $_POST["UserName"];
$password = $_POST["Password"];

$sql = "SELECT * FROM users WHERE UserName = '{$username}' and Password = '{$password}'";

if ($row = mysqli_fetch_assoc(mysqli_query($conn, $sql))) {
    $_SESSION["userid"] = $row['UserID'];
    $_SESSION["firstname"] = $row['FirstName'];
    $_SESSION["lastname"] = $row['LastName'];
    $_SESSION["username"] = $row['UserName'];
    $_SESSION["email"] = $row['Email'];
    $_SESSION["password"] = $row['Password'];
    $_SESSION["phonenumber"] = $row['PhoneNumber'];
    $_SESSION["address"] = $row['Address'];
    $_SESSION["role"] = $row['role'];
    header("location: ../FrontEnd/homepage.php");
}else{
    header("location: ../FrontEnd/login.php");
}

?>