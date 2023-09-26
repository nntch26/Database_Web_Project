
<?php

session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา


// เช็คว่า กดปุ่ม update
if (isset($_POST['edithotel_update'])) {
    $hotelname = $_POST['hotel_name'];
    $hotelphone = $_POST['hotel_phone'];
    $hoteldes = $_POST['hotels_description'];
    $hotelimg = $_POST['hotel_img'];
    $hoteladd = $_POST['hotel_address'];
    $hotelcity = $_POST['hotel_city'];
    $hotelcode = $_POST['hotel_postcode'];
    $hotel_facility = $_POST['hotel_facility'];



    // เช็คว่า เป็นข้อมูลที่รับมาเป็นค่าว่าง หรือไม่
    if (empty($hotelname) || empty($hotelphone) || empty($hoteldes) || empty($hotelimg)
        || empty($hoteladd) || empty($hotelcity) || empty($hotelcode)) {
        $_SESSION['err_edithotel'] = "โปรดระบุข้อมูลของคุณให้ครบถ้วน";
        header('location: ../edithotel.php'); // กลับไปหน้า edit
        exit; // จบการทำงาน
    }



    // กรอกข้อมูลครบ 
    else {

        //เช็คว่าข้อมูลที่กรอกเข้ามาซ้ำ ใน database หรือไม่
        $select_stmt = $db->prepare("SELECT COUNT(hotels_name) AS count_name 
        FROM hotels WHERE hotels_name = :hotels_name");

        $select_stmt2 = $db->prepare("SELECT COUNT(hotels_phone) AS count_p
        FROM hotels WHERE hotels_phone = :hotel_phone");

        $select_stmt->bindParam(':hotels_name', $hotelname);
        $select_stmt2->bindParam(':hotel_phone', $hotelphone);

        $select_stmt->execute();
        $select_stmt2->execute();

        $row = $select_stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา
        $rowp = $select_stmt2->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา

        // ถ้าแสดงแถวแล้วได้จำนวน > 0 แปลว่า ข้อมูลซ้ำ
        if ($row['count_name'] != 0) {
            $_SESSION['exist_hotelname'] = "มี โรงแรม นี้แล้วในระบบ";
            header('location: ../edithotel.php');
            exit;
        }

        // เช็คว่าเบอร์ซ้ำ ไหม
        elseif ($rowp['count_p'] != 0) {
            $_SESSION['exist_hotelp'] = "มี เบอร์ติดต่อ นี้แล้วในระบบ";
            header('location: ../edithotel.php');
            exit;
        }



        // กรอกข้อมูลครบ 
        else {

            // ลบรูปก่อนที่จะเก็บไฟล์ใหม่
            $delete_stmt = $db->prepare('SELECT * FROM hotels WHERE hotel_id = :hotel_id');
            $delete_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
            $delete_stmt->execute();
            $row = $delete_stmt->fetch(PDO::FETCH_ASSOC);

            unlink(__DIR__ . "/uploads_img/" . $row['hotels_img']);

            // ค้นหา location_id จากตาราง Locations โดยใช้ชื่อจังหวัดเป็นเงื่อนไข
            $select_stmt3 = $db->prepare("SELECT location_id FROM locations WHERE location_name = :hotels_city");
            $select_stmt3->bindParam(':hotels_city', $hotelcity);
            $select_stmt3->execute();

            $rowid = $select_stmt3->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา id

            $sql = "UPDATE hotels
            SET
              hotels_name = :hotels_name,
              hotels_phone = :hotels_phone,
              hotels_address = :hotels_address,
              hotels_postcode = :hotels_postcode,
              hotels_description = :hotels_des,
              hotels_img = :hotels_img,
              location_id = :location_id
            WHERE user_id = :user_id";

            $update_stmt = $db->prepare($sql);


            $update_stmt->bindParam(':hotels_name', $hotelname);
            $update_stmt->bindParam(':hotels_phone', $hotelphone);
            $update_stmt->bindParam(':hotels_address', $hoteladd);
            $update_stmt->bindParam(':hotels_des', $hoteldes);
            $update_stmt->bindParam(':hotels_postcode', $hotelcode);
            $update_stmt->bindParam(':hotels_img', $hotelimg);
            $update_stmt->bindParam(':location_id', $rowid['location_id']);
            $update_stmt->bindParam(':user_id', $_SESSION["userid"]);


            $update_stmt->execute();


            /////////////////////////////////////////////////////

            // อัปเดทข้อมูลลงในตาราง hotelsfacility

            $select_stmt5 = $db->prepare("SELECT * FROM hotels WHERE user_id = :user_id");
            $select_stmt5->bindParam(':user_id', $_SESSION["userid"]);
            $select_stmt5->execute();

            $rowidho = $select_stmt5->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา id


            // ลบข้อมูลเก่า
            $sql6 = "DELETE FROM hotelsfacility WHERE hotel_id = :hotel_id";
            $destmt6 = $db->prepare($sql6);
            $destmt6->bindParam(':hotel_id',  $rowidho['hotel_id']);
            $destmt6->execute();


             // เพิ่มข้อมูลลงในตาราง hotelsfacility
 
            foreach ($hotel_facility as $facility_id) {
                $sql = "INSERT INTO `hotelsfacility` (`facility_id`, `hotel_id`)
                VALUES(:facility_id, :hotel_id)";
    
                $select_stmt6 = $db->prepare($sql);
    
                $select_stmt6->bindParam(':facility_id',  $facility_id);
                $select_stmt6->bindParam(':hotel_id', $rowidho['hotel_id']);
                $select_stmt6->execute();
            }





            // เพิ่มข้อมูลแล้ว 
            if ($update_stmt) {
                $_SESSION['hotel_update'] = "อัปเดตข้อมูลของคุณเรียบร้อยแล้ว";
                header('location: ../edithotel.php');
            }

            // เพิ่มข้อมูลไม่สำเร็จ
            else {
                $_SESSION['err_update'] = "ไม่สามารถนำเข้าข้อมูลได้";
                header('location: ../edithotel.php');
                exit;
            }
        }
    }
} elseif (isset($_POST['edithotel_back'])) {
    header('location: ../profilehotel.php');
    exit;
} elseif (isset($_POST['edithotel_cancel'])) {
    header('location: ../profilehotel.php');
    exit;
}





?>

