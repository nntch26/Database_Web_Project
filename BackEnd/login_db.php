
<?php

session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


// เช็คว่า กดปุ่ม submit
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // เช็คว่า เป็นข้อมูลที่รับมาเป็นค่าว่าง หรือไม่
    if (empty($username) || empty($password)) {

        // ถ้าเป็นข้อมูลว่าง  กำหนด error จะเก็บไว้ใน session
        $_SESSION['err_fill'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
        header('location: ../FrontEnd/login.php'); // กลับไปหน้า login เหมือนเดิม
        exit; // จบการทำงาน
    }

    // ถ้าไม่ได้เป็น ค่าว่าง
    else {

        // เช็คว่ามี username นั่นจริงมั้ย , ดึง password ออกมาตรวจสอบด้วย
        $select_stmt = $db->prepare("SELECT COUNT(users_username) AS count_uname, users_password FROM users WHERE users_username  = :users_username GROUP BY users_password");
        $select_stmt->bindParam(':users_username', $username);
        $select_stmt->execute();

        $row = $select_stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา

        // กรณีที่ไม่มีข้อมูล ในระบบ
        if ($row['count_uname'] == 0) {
            $_SESSION['exist_uname'] = "ไม่มี Username นี้ในระบบ";
            header('location: ../FrontEnd/login.php');
            exit;
        } else {

            // กรณี login สำเร็จ
            if ($row['users_password'] == $password) {
                $_SESSION["username"] = $username;
                $_SESSION['is_login'] = true;
                header('location: ../FrontEnd/index.php');
            }

            // กรณี login ไม่สำเร็จ
            else {
                $_SESSION['err_pw'] = "กรุณากรอกรหัสผ่านให้ตรงกัน";
                header('location: ../FrontEnd/login.php');
                exit;
            }
        }
    }
}
