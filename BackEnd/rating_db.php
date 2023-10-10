<?php
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


if (isset($_POST['post_com'])) {
    $hotelid = $_POST["hotel_id"];
    $rating = $_POST["rating"];
    $comment = $_POST["comment"];

    $sql = "INSERT INTO reviews (user_id, hotel_id, reviews_rating, reviews_comment)
    VALUES (:user_id, :hotel_id, :reviews_rating, :reviews_comment)";

    $insert_stmt = $db->prepare($sql);

    $insert_stmt->bindParam(':user_id', $_SESSION['userid']);
    $insert_stmt->bindParam(':hotel_id', $hotelid);
    $insert_stmt->bindParam(':reviews_rating', $rating);
    $insert_stmt->bindParam(':reviews_comment', $comment);

    $insert_stmt->execute();
    $row = $insert_stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา

    // เช็คว่า ถ้าเพิ่มข้อมูลผ่านแล้ว 
    if ($insert_stmt) {
        $_SESSION["is_reviews"] = $hotelid;
        header('location: ../confirm_payment.php');
    }

    // สมัครไม่สำเร็จ
    else {
        $_SESSION['err_insert'] = "ไม่สามารถนำเข้าข้อมูลได้";
        header('location: ../confirm_payment.php');
        exit();
    }




// ยกเลิกการจอง
}elseif (isset($_POST['cancle_pay'])) {

    header('location: ../booking_cancle.php');



}elseif (isset($_POST['back'])){
    header('location: ../index.php');


}
