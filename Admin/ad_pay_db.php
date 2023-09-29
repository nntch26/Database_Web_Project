<?php
session_start();
include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


if (isset($_POST['ad_submitpay'])) {
    $payment_id = $_POST["payment_id"];
    $booking_id = $_POST["booking_id"];


    // เปลี่ยนสถานะของ payment
    $sql = "UPDATE payments SET payments_status = 'Paid' WHERE payment_id = :payment_id";

    $stmt = $db->prepare($sql2);
    $stmt->bindParam(':payment_id', $payment_id);
    $stmt->execute();


     // เปลี่ยนสถานะของ booking
     $sql2 = "UPDATE bookings SET bookings_status = 'Confirm' WHERE booking_id = :booking_id";

     $stmt2 = $db->prepare($sql2);
     $stmt2->bindParam(':booking_id', $booking_id);
     $stmt2->execute();



     




    header('location: admin.php?page=payment');

    



        

    
// ไม่ยืนยัน

}elseif(isset($_POST['ad_cancelpay'])){
    $payment_id = $_POST["payment_id"];
    $booking_id = $_POST["booking_id"];



    $sql4 = "DELETE FROM requests WHERE request_id = :request_id";

    $sql5 = "DELETE FROM hotels WHERE request_id = :request_id";

   
    $stmt4 = $db->prepare($sql4);
    $stmt4->bindParam(':request_id', $request_id);

    $stmt5 = $db->prepare($sql5);
    $stmt5->bindParam(':request_id', $request_id);

    
    $stmt4->execute();
    $stmt5->execute();




    $_SESSION['is_register'] = false;
    header('location: admin.php?page=payment');




}
