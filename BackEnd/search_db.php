<?php
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

$get_location = $_POST['location'];
$get_checkin = $_POST['checkin'];
$get_checkout = $_POST['checkout'];
$get_num_guest = $_POST['num_guest'];

echo $get_location . " " . $get_checkin . " "  . $get_checkout . " " . $get_num_guest;

?>