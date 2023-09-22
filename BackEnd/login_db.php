
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
        header('location: ../login.php'); // กลับไปหน้า login เหมือนเดิม
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
            header('location: ../login.php');
            exit;
        } else {

            // กรณี login สำเร็จ
            if ($row['users_password'] == $password) {
                $_SESSION["username"] = $username;
                $_SESSION['is_login'] = true;

                // query ข้อมูลของคนที่ login เข้ามา เพื่อแสดงผลใน html
                $select_stmt3 = $db->prepare("SELECT * FROM users WHERE users_username = :username");
                $select_stmt3->bindParam(':username', $_SESSION["username"]);
                $select_stmt3->execute();
                $result = $select_stmt3->fetch(PDO::FETCH_ASSOC);  // ทำบรรทัดนี้ กรณีที่เราต้องการดึงข้อมูลมาแสดง
                // query ข้อมูลของคนที่ login เข้ามา 

                $_SESSION["userid"] = $result['user_id'];
                $_SESSION["firstname"] = $result['users_first_name'];
                $_SESSION["lastname"] = $result['users_last_name'];
                $_SESSION["username"] = $result['users_username'];
                $_SESSION["email"] = $result['users_email'];
                $_SESSION["password"] = $result['users_password'];
                $_SESSION["phonenumber"] = $result['users_phone_number'];
                $_SESSION["address"] = $result['users_address'];
                $_SESSION["city"] = $result['users_city'];
                $_SESSION["postcode"] = $result['users_postcode'];
                $_SESSION["role"] = $result['users_role'];

                if ($result['users_role'] == "ADMIN") {
                    header('location: ../Admin/admin.php');
                } else {
                    header('location: ../index.php');
                }
            }

            // กรณี login ไม่สำเร็จ
            else {
                $_SESSION['err_pw'] = "กรุณากรอกรหัสผ่านให้ตรงกัน";
                header('location: ../login.php');
                exit;
            }
        }
    }
}
