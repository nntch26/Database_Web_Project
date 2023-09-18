
<?php

session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


// เช็คว่า กดปุ่ม update
if (isset($_POST['update'])) {
    $firstname = $_POST['hotel_name'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $postcode = $_POST['postcode'];
    $phone = $_POST['phone'];
    

    // เช็คว่า เป็นข้อมูลที่รับมาเป็นค่าว่าง หรือไม่
    if (empty($firstname) || empty($lastname) || empty($address) || empty($phone) || empty($city)|| empty($postcode)) {
        $_SESSION['err_edit'] = "โปรดระบุข้อมูลของคุณให้ครบถ้วน";
        header('location: ../FrontEnd/editprofile.php'); // กลับไปหน้า editprofile 
        exit; // จบการทำงาน
    }

    // กรอกข้อมูลครบ 
    else {

        $update_stmt = $db->prepare("UPDATE users SET users_first_name = :firstname, 
        users_last_name = :lastname , users_phone_number = :phone, 
        users_address = :address , users_city = :city, users_postcode = :postcode
        WHERE users_username = :username");


        $update_stmt->bindParam(':firstname', $firstname);
        $update_stmt->bindParam(':lastname', $lastname);
        $update_stmt->bindParam(':phone', $phone);
        $update_stmt->bindParam(':address', $address);
        $update_stmt->bindParam(':city', $city);
        $update_stmt->bindParam(':postcode', $postcode);
        $update_stmt->bindParam(':username', $_SESSION["username"]);

        $update_stmt->execute();

        // เพิ่มข้อมูลแล้ว 
        if ($update_stmt) {
            $_SESSION['profile_update'] = "อัปเดตข้อมูลของคุณเรียบร้อยแล้ว";
            header('location: ../FrontEnd/editprofile.php');
        }

        // เพิ่มข้อมูลไม่สำเร็จ
        else {
            $_SESSION['err_update'] = "ไม่สามารถนำเข้าข้อมูลได้";
            header('location: ../FrontEnd/editprofile.php');
            exit;
        }

    }

} elseif (isset($_POST['back'])){
    header('location: ../FrontEnd/profile.php');
    exit;
    
}elseif (isset($_POST['cancel'])){
    header('location: ../FrontEnd/profile.php');
    exit;

}


      


?>

