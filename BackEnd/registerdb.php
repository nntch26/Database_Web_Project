<?php
include 'includes/connect_database.php';

$firstname = $_POST["FirstName"];
$lastname = $_POST["LastName"];
$username = $_POST["UserName"];
$email = $_POST["email"];
$password = $_POST["Password"];
$phonenumber = $_POST["PhoneNumber"];
$address = $_POST["Address"];
$role = $_POST["role"];

$sql = "INSERT INTO users (FirstName, LastName, UserName, email, Password, PhoneNumber, Address, role)
VALUES ('{$firstname}', '{$lastname}', '{$username}', '{$email}', '{$password}', '{$phonenumber}', '{$address}', '{$role}')";

if (mysqli_query($conn, $sql)) {
  echo " New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
