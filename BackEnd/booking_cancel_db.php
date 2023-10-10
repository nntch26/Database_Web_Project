<?php



    // เปลี่ยนสถานะของ booking
    $sql2 = "UPDATE bookings SET bookings_status = 'Cancel Booking' WHERE booking_id = :booking_id";
  
    $upstmt2 = $db->prepare($sql2);
    $upstmt2->bindParam(':booking_id', $_SESSION["booking_id"]);
    $upstmt2->execute();



    // เปลี่ยนสถานะของ payment
    $sql3 = "UPDATE payments SET payments_status = 'Cancel Booking' 
            WHERE booking_id = :booking_id";

    $upstmt3 = $db->prepare($sql3);
    $upstmt3->bindParam(':booking_id', $_SESSION["booking_id"]);
    $upstmt3->execute();

?>