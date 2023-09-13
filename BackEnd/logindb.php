<?php
include 'includes/connect_database.php';
session_start();

$username = $_POST["users_username"];
$password = $_POST["users_password"];

$sql = "SELECT * FROM users WHERE users_username = '{$username}' and users_password = '{$password}'";

if ($row = mysqli_fetch_assoc(mysqli_query($conn, $sql))) {
    $_SESSION["userid"] = $row['user_id'];
    $_SESSION["firstname"] = $row['users_first_name'];
    $_SESSION["lastname"] = $row['users_last_name'];
    $_SESSION["username"] = $row['users_username'];
    $_SESSION["email"] = $row['users_email'];
    $_SESSION["password"] = $row['users_password'];
    $_SESSION["phonenumber"] = $row['users_phone_number'];
    $_SESSION["address"] = $row['users_address'];
    $_SESSION["role"] = $row['users_role'];
    header("location: ../FrontEnd/homepage.php");
}else{
    header("location: ../FrontEnd/login.php");
}

?>