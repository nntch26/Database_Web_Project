
<?php

session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


// เช็คว่า กดปุ่ม update
if (isset($_POST['update'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    

   

        $update_stmt = $db->prepare("UPDATE users SET users_first_name = :firstname, 
        users_last_name = :lastname , users_phone_number = :phone, 
        users_address = :address
        WHERE users_username = :username");


        $update_stmt->bindParam(':firstname', $firstname);
        $update_stmt->bindParam(':lastname', $lastname);
        $update_stmt->bindParam(':phone', $phone);
        $update_stmt->bindParam(':address', $address);
        $update_stmt->bindParam(':username', $_SESSION["username"]);

        $update_stmt->execute();

        // เพิ่มข้อมูลแล้ว 
        if ($update_stmt) {
            $_SESSION['profile_update'] = "อัปเดตข้อมูลของคุณเรียบร้อยแล้ว";
            header('location: ../editprofile.php');
        }

        // เพิ่มข้อมูลไม่สำเร็จ
        else {
            $_SESSION['err_update'] = "ไม่สามารถนำเข้าข้อมูลได้";
            header('location: ../editprofile.php');
            exit;
        }

    

} elseif (isset($_POST['back'])){
    header('location: ../profile.php');
    exit;
    
}elseif (isset($_POST['cancel'])){
    header('location: ../profile.php');
    exit;

}


      


?>

