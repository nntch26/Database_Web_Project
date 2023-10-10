
<?php
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


// เช็คว่า กดปุ่ม
if (isset($_POST['submit'])) {
    $banknum = $_POST['banknum'];
    $bank= $_POST['bank'];
    $booking_cancle_date= date('Y-m-d');
    $reason = $_POST['reason'];




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



    $sql4 = "INSERT INTO canclebooking (booking_id, user_id, cancle_banknum, cancle_bankname, cancle_date, cancle_reason, cancle_status)
    VALUES (:booking_id, :user_id, :banknum, :bank, :cancledate, :reason, 'WAITING')";

    $upstmt4 = $db->prepare($sql4);
    $upstmt4->bindParam(':booking_id', $_SESSION["booking_id"]);
    $upstmt4->bindParam(':user_id', $_SESSION["userid"]);
    $upstmt4->bindParam(':banknum', $banknum);
    $upstmt4->bindParam(':bank', $bank);
    $upstmt4->bindParam(':cancledate', $booking_cancle_date);
    $upstmt4->bindParam(':reason', $reason);

    $upstmt4->execute();

    $_SESSION['cancle'] = "โปรดรอเจ้าหน้าที่ตรวจสอบ เมื่อเสร็จสิ้นแล้วระบบจะคืนเงินให้ภายใน 24 ชม.";
    header('location: ../booking_cancle.php');

}

?>