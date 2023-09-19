<?php
ob_start();
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

// เช็คว่ามีการกดปุ่ม submit มาหรือไม่

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // เช็คว่าข้อมูลที่รับมา เป็นค่าว่างหรือไม่ มีข้อมูลมั้ย
    if (empty($username) || empty($password) || empty($confirm_password || empty($email))) {

        // ถ้าเป็นข้อมูลว่าง  กำหนด error จะเก็บไว้ใน session
        $_SESSION['err_fill'] = "กรุณากรอกข้อมูลให้ครบถ้วน";

        // พอมี error ให้ส่งกลับไปที่หน้า สมัครสมาชิกเหมือนเดิม
        header('location: ../register.php');
        exit(); // จบการทำงาน
    }

    // ถ้าข้อมูลไม่เป็นค่าว่าง มีข้อมูล
    else {

        // กรณีที่ รหัสผ่านไม่ตรงกัน
        if ($password != $confirm_password) {
            $_SESSION['err_pw'] = "กรุณากรอกรหัสผ่านให้ตรงกัน";
            header('location: ../register.php');
            exit();
        }

        // ถ้าข้อมูลถูกต้อง ทำการเพิ่มข้อมูล ลงใน database
        else {

            //เช็คว่าข้อมูลที่กรอกเข้ามาซ้ำ ใน database หรือไม่
            $select_stmt = $db->prepare("SELECT COUNT(users_username) AS count_uname FROM users WHERE users_username = :users_username");
            $select_stmt2 = $db->prepare("SELECT COUNT(users_email) AS count_email FROM users WHERE users_email= :users_email");

            $select_stmt->bindParam(':users_username', $username);
            $select_stmt2->bindParam(':users_email', $email);

            $select_stmt->execute();
            $select_stmt2->execute();

            $rowuser = $select_stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา username
            $rowem = $select_stmt2->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา email

            // ถ้าแสดงแถวแล้วได้จำนวน > 0 แปลว่า ข้อมูลซ้ำ
            if ($rowuser['count_uname'] != 0) {
                $_SESSION['exist_uname'] = "มี Username นี้แล้วในระบบ";
                header('location: ../register.php');
                exit();
            }

            // ถ้า เมลในระบบ ซ้ำ
            else if ($rowem['count_email'] != 0) {
                $_SESSION['exist_email'] = "มี Email นี้แล้วในระบบ";
                header('location: ../register.php');
                exit();
            }

            // ถ้าไม่มี username ซ้ำ สมัครได้
            else {
                
                $insert_stmt = $db->prepare("INSERT INTO users (users_username, users_password, users_email, users_role) 
                VALUES (:users_username, :users_password, :users_email ,'TOURIST')");

                $insert_stmt->bindParam(':users_username', $username);
                $insert_stmt->bindParam(':users_password', $password);
                $insert_stmt->bindParam(':users_email', $email);
                $insert_stmt->execute();

                // สมัครสำเร็จ เช็คว่า ถ้าเพิ่มข้อมูลผ่านแล้ว จะให้ทำการเก็บ username เอาไปใช้ต่อ
                if ($insert_stmt) {
                    header('../login.php');
                    echo '<script type="text/javascript">
                    window.location = "../login.php"; // เปลี่ยนเป็น URL ของหน้าที่ต้องการเปลี่ยนไป
                    </script>';
                }

                // สมัครไม่สำเร็จ
                else {
                    $_SESSION['err_insert'] = "ไม่สามารถนำเข้าข้อมูลได้";
                    header('location: ../register.php');
                    exit();
                }
            }
        }
    }
}
ob_end_flush();
?>