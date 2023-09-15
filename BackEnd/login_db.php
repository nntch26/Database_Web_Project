
<?php

session_start();
include('includes/connection.php'); // ดึงไฟล์เชื่อม database เข้ามา


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
        $select_stmt = $db->prepare("SELECT COUNT(username) AS count_uname, password FROM users WHERE username = :username GROUP BY password");
        $select_stmt->bindParam(':username', $username);
        $select_stmt->execute();

        $row = $select_stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา

        // กรณีที่ไม่มีข้อมูล ในระบบ
        if ($row['count_uname'] == 0) {
            $_SESSION['exist_uname'] = "ไม่มี Username นี้ในระบบ";
            header('location: ../FrontEnd/login.php');
            exit;
        } else {

            // กรณี login สำเร็จ
            if ($row['password'] == $password) {
                $_SESSION["userid"] = $row['user_id'];
                $_SESSION["firstname"] = $row['users_first_name'];
                $_SESSION["lastname"] = $row['users_last_name'];
                $_SESSION["username"] = $row['users_username'];
                $_SESSION["email"] = $row['users_email'];
                $_SESSION["password"] = $row['users_password'];
                $_SESSION["phonenumber"] = $row['users_phone_number'];
                $_SESSION["address"] = $row['users_address'];
                $_SESSION["role"] = $row['users_role'];
                $_SESSION['is_login'] = true;
                header('location: ../FrontEnd/homepage.php');
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
