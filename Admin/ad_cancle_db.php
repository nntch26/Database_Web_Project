<?php
session_start();
include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


if (isset($_POST['ad_submitpay'])) {
    $payment_id = $_POST["payment_id"];
    $booking_id = $_POST["booking_id"];
    $user_id = $_POST["user_id"];

    
     $_SESSION['is_cancle'] = true;


    header('location: admin.php?page=booking');

    



        

    
// ไม่ยืนยัน

}elseif(isset($_POST['ad_cancelpay'])){
    $payment_id = $_POST["payment_id"];
    $booking_id = $_POST["booking_id"];
    $user_id = $_POST["user_id"];



      // เปลี่ยนสถานะของ payment
      $sql = "UPDATE payments SET payments_status = 'Declined' WHERE payment_id = :payment_id";

      $stmt = $db->prepare($sql);
      $stmt->bindParam(':payment_id', $payment_id);
      $stmt->execute();
  
  
       // เปลี่ยนสถานะของ booking
       $sql2 = "UPDATE bookings SET bookings_status = 'Cancle' WHERE booking_id = :booking_id";
  
       $stmt2 = $db->prepare($sql2);
       $stmt2->bindParam(':booking_id', $booking_id);
       $stmt2->execute();

    $_SESSION['is_pay'] = false;
    header('location: admin.php?page=booking');




}
