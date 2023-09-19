<?php
session_start();
include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


if (isset($_POST['ad_submit'])) {
    $request_id = $_POST["request_id"];
    $user_id = $_POST["user_id"];
    $location_id = $_POST["location_id"];

    $sql = "SELECT * FROM requests r 
            JOIN users u ON r.user_id = u.user_id 
            JOIN locations l ON r.location_id = l.location_id
            WHERE request_id = :request_id";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':request_id', $request_id);
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);


     // พิ่มข้อมูลลงในตาราง hotels
     $insert_stmt = $db->prepare("INSERT INTO hotels (`hotels_name`, `hotels_phone`, `hotels_address`, 
     `hotels_postcode`, `hotels_description`, `hotels_img`, `location_id`, `user_id`)
     VALUES(:hotels_name, :hotels_phone, :hotels_address, 
     :hotels_postcode, :hotels_description, :hotels_img, :location_id, :user_id);");

     $insert_stmt->bindParam(':hotels_name', $row['req_hotels_name']);
     $insert_stmt->bindParam(':hotels_phone',  $row['req_hotels_phone']);
     $insert_stmt->bindParam(':hotels_address',  $row['req_hotels_address']);
     $insert_stmt->bindParam(':hotels_description',  $row['req_hotels_description']);
     $insert_stmt->bindParam(':hotels_postcode',  $row['req_hotels_postcode']);
     $insert_stmt->bindParam(':hotels_img',  $row['req_hotels_img']);
     $insert_stmt->bindParam(':location_id', $location_id);
     $insert_stmt->bindParam(':user_id', $user_id);

     $insert_stmt->execute();
    



    // กดยืนยัน ถ้าเพิ่มข้อมูลผ่านแล้ว จะให้ทำการเก็บ username เอาไปใช้ต่อ
    if ($insert_stmt) {

        // เปลี่ยนสถานะของ ผู้ใช้ที่ร้องขอ  เป็น Approve
        $sql2 = "UPDATE requests SET req_status = 'APPROVE' WHERE request_id = :request_id";

        $stmt2 = $db->prepare($sql2);
        $stmt2->bindParam(':request_id', $request_id);
        $stmt2->execute();

        // ดึงสถานะการร้องขอ ของผู้ใช้
        $select_stmt3 = $db->prepare("SELECT req_status FROM requests WHERE user_id = :user_id");
        $select_stmt3->bindParam(':user_id', $user_id);
        $select_stmt3->execute();

        $rowstatus = $select_stmt3->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา 
        $_SESSION["req_status"] = $rowstatus['req_status'];
        $_SESSION['is_register'] = true;
        


        // เปลี่ยน role ของผู้ใช้
        $sql3 = "UPDATE users SET users_role = 'HOTELOWNER' WHERE user_id = :user_id";

        $stmt3 = $db->prepare($sql3);
        $stmt3->bindParam(':user_id', $user_id);
        $stmt3->execute();


        header('location: admin.php');

    }

    // สมัครไม่สำเร็จ
    else {
        $_SESSION['err_insert'] = "ไม่สามารถนำเข้าข้อมูลได้";
        header('location: admin.php');
        exit;
    }

        

    
// ลงทะเบียนไม่ผ่าน

}elseif(isset($_POST['ad_cancel'])){
    $request_id = $_POST["request_id"];

    // ลบคำร้องขอ ของผู้ใช้
    $sql4 = "DELETE FROM requests WHERE request_id = :request_id";

    $stmt4 = $db->prepare($sql4);
    $stmt4->bindParam(':request_id', $request_id);
    $stmt4->execute();

    $_SESSION['is_register'] = false;
    header('location: admin.php');


}
