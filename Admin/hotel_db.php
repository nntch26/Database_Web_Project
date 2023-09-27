<?php
session_start();
include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

if (isset($_POST['ad_delete'])) {

    $hotel_id = $_POST["hotel_id"];
    $user_id = $_POST["user_id"];

     // ลบรูปก่อนที่จะเก็บไฟล์ใหม่
     $delete_stmt = $db->prepare('SELECT * FROM hotels WHERE hotel_id = :hotel_id');
     $delete_stmt->bindParam(':hotel_id', $hotel_id );
     $delete_stmt->execute();
     $row = $delete_stmt->fetch(PDO::FETCH_ASSOC);
 
     unlink(__DIR__ . "/uploads_img/" . $row['hotels_img']);
 


    $sql4 = "DELETE FROM requests WHERE user_id = :user_id";

    $sql5 = "DELETE FROM hotels WHERE hotel_id = :hotel_id";

    $sql6 = "DELETE FROM hotelsfacility WHERE hotel_id = :hotel_id";


    $stmt4 = $db->prepare($sql4);
    $stmt4->bindParam(':user_id', $user_id);
    $stmt4->execute();

    $stmt5 = $db->prepare($sql5);
    $stmt5->bindParam(':hotel_id', $hotel_id);

    $stmt5->execute();

    $stmt6 = $db->prepare($sql6);
    $stmt6->bindParam(':hotel_id', $hotel_id);

    $stmt6->execute();

    // เปลี่ยน role ของผู้ใช้
    $sql3 = "UPDATE users SET users_role = 'TOURIST' WHERE user_id = :user_id";

    $stmt3 = $db->prepare($sql3);
    $stmt3->bindParam(':user_id', $user_id);

    $stmt3->execute();


   

    header('location: admin.php?page=hotel');

    
}