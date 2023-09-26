<?php
session_start();
include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

if (isset($_POST['ad_delete'])) {

    $hotel_id = $_POST["hotel_id"];
    $user_id = $_POST["user_id"];


    $sql5 = "DELETE FROM hotels WHERE hotel_id = :hotel_id";
    $sql6 = "DELETE FROM hotelsfacility WHERE hotel_id = :hotel_id";



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