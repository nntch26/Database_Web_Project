<?php
session_start();
include('includes/connect_database.php');

$get_location = $_POST['location'];
$get_checkin = $_POST['checkin'];
$get_checkout = $_POST['checkout'];
$get_num_guest = $_POST['num_guest'];

// ยังไม่ได้เขียนดักเด้อ







// ยังไม่ได้เขียนดักเด้อ

$_SESSION["location"] = $get_location;
$_SESSION["checkin"] = $get_checkin;
$_SESSION["checkout"] = $get_checkout;
$_SESSION["num_guest"] = $get_num_guest;

header("Location: ../rooms.php");

?>