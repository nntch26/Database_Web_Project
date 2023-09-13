<?php
include 'includes/connect_database.php';

$firstname = $_POST["users_first_name"];
$lastname = $_POST["users_last_name"];
$username = $_POST["users_username"];
$email = $_POST["users_email"];
$password = $_POST["users_password"];
$phonenumber = $_POST["users_phone_number"];
$address = $_POST["users_address"];

$sql = "INSERT INTO users (users_first_name, users_last_name, users_username, users_email, users_password, users_phone_number, users_address)
VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$password}', '{$phonenumber}', '{$address}')";

if (mysqli_query($conn, $sql)) {
  header("location: ../FrontEnd/login.php");
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
