<?php
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา
$_SESSION["booking_id"] = $_POST["booking_id"];

if (isset($_POST['confirm_pay']) && isset($_SESSION['booking_id'])) {
    header('location: ../confirm_payment.php');
    exit;
}

?>