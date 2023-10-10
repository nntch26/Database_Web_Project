
<?php
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


// เช็คว่า กดปุ่ม
if (isset($_POST['submit'])) {
    $_SESSION["banknum"]= $_POST['banknum'];
    $_SESSION["bank"]= $_POST['bank'];
    $_SESSION["booking_cancle_date"] = date('Y-m-d');
    $_SESSION["reason"] = $_POST['reason'];




    // เปลี่ยนสถานะของ booking
    $sql2 = "UPDATE bookings SET bookings_status = 'Cancle Booking' WHERE booking_id = :booking_id";
  
    $upstmt2 = $db->prepare($sql2);
    $upstmt2->bindParam(':booking_id', $_SESSION["booking_id"]);
    $upstmt2->execute();



    // เปลี่ยนสถานะของ payment
    $sql3 = "UPDATE payments SET payments_status = 'Cancle Booking' 
            WHERE booking_id = :booking_id";

    $upstmt3 = $db->prepare($sql3);
    $upstmt3->bindParam(':booking_id', $_SESSION["booking_id"]);
    $upstmt3->execute();


    $_SESSION['cancle'] = "โปรดรอเจ้าหน้าที่ตรวจสอบ เมื่อเสร็จสิ้นแล้วระบบจะคืนเงินให้ภายใน 24 ชม.";
    header('location: ../booking_cancle.php');

}

?>