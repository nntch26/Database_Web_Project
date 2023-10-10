<?php
session_start();
include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


if (isset($_POST['ad_submitpay'])) {
    $payment_id = $_POST["payment_id"];
    $booking_id = $_POST["booking_id"];
    $user_id = $_POST["user_id"];

   $sql = "UPDATE canclebooking SET cancle_status = 'Confirmed' WHERE booking_id = :booking_id";
 
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':booking_id', $booking_id);
    $stmt->execute();

    
    $_SESSION['is_cancle'] = true;


    header('location: admin.php?page=booking');

    



        

    
// ไม่ยืนยัน

}elseif(isset($_POST['ad_cancelpay'])){
    $payment_id = $_POST["payment_id"];
    $booking_id = $_POST["booking_id"];
    $user_id = $_POST["user_id"];


    $sql = "UPDATE canclebooking SET cancle_status = 'Declined' WHERE booking_id = :booking_id";
 
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':booking_id', $booking_id);
    $stmt->execute();

    $_SESSION['is_pay'] = false;

    header('location: admin.php?page=booking');




}
