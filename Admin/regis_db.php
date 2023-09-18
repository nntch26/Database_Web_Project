<?php
session_start();
include('../BackEnd/includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


if (isset($_POST['ad_submit'])) {
    $request_id = $_POST["request_id"];


     // ส่ง requests  เพิ่มข้อมูลลงในตาราง requests
     $insert_stmt = $db->prepare("INSERT INTO requests
     (user_id, req_hotels_name, req_hotels_phone, req_hotels_address, req_hotels_postcode, req_hotels_description, req_hotels_img, req_sent_date, req_status, location_id)
     VALUES (:user_id, :hotels_name , :hotels_phone , :hotels_address, :hotels_postcode, :hotels_des, :hotels_img, :req_sent_date, 'WAITING', :location_id)");

     

     $insert_stmt->bindParam(':user_id', $_SESSION["userid"]);
     $insert_stmt->bindParam(':hotels_name', $hotelname);
     $insert_stmt->bindParam(':hotels_phone', $hotelphone);
     $insert_stmt->bindParam(':hotels_address', $hoteladd);
     $insert_stmt->bindParam(':hotels_des', $hoteldes);
     $insert_stmt->bindParam(':hotels_postcode', $hotelcode);
     $insert_stmt->bindParam(':hotels_img', $hotelimg);
     $insert_stmt->bindParam(':req_sent_date', $req_date);
     $insert_stmt->bindParam(':location_id', $rowid['location_id']);

     $insert_stmt->execute();
    



    // สมัครสำเร็จ เช็คว่า ถ้าเพิ่มข้อมูลผ่านแล้ว จะให้ทำการเก็บ username เอาไปใช้ต่อ
    if ($insert_stmt) {
        header('location: ../FrontEnd/login.php');
    }

    // สมัครไม่สำเร็จ
    else {
        $_SESSION['err_insert'] = "ไม่สามารถนำเข้าข้อมูลได้";
        header('location: ../FrontEnd/register.php');
        exit;
    }

        
    
}
