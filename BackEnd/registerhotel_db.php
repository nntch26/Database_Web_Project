
<?php
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

// เช็คว่ามีการกดปุ่ม submit มาหรือไม่

if (isset($_POST['req_submit'])) {
    $hotelname = $_POST['hotel_name'];
    $hotelphone = $_POST['hotel_phone'];
    $hoteldes = $_POST['hotels_description'];
    $hoteladd = $_POST['hotel_address'];
    $hotelcity = $_POST['hotel_city'];
    $hotelcode = $_POST['hotel_postcode'];
    $req_date = $_POST['req_date'];

    // เช็คว่าข้อมูลที่รับมา เป็นค่าว่างหรือไม่ มีข้อมูลมั้ย
    if (empty($hotelname) || empty($hotelphone) || empty($hoteldes || empty($hotelimg)
        || empty($hoteladd) || empty($hotelcity) || empty($hotelcode) || empty($req_date))) {

        // ถ้าเป็นข้อมูลว่าง  กำหนด error จะเก็บไว้ใน session
        $_SESSION['err_regis'] = "กรุณากรอกข้อมูลให้ครบถ้วน";

        // พอมี error ให้ส่งกลับไปที่หน้า สมัครสมาชิกเหมือนเดิม
        header('location: ../registerhotel.php');
        exit; // จบการทำงาน
    }

    // ถ้าข้อมูลไม่เป็นค่าว่าง มีข้อมูล
    else {


        //เช็คว่าข้อมูลที่กรอกเข้ามาซ้ำ ใน database หรือไม่
        $select_stmt = $db->prepare("SELECT COUNT(hotels_name) AS count_name 
        FROM hotels WHERE hotels_name = :hotels_name");

        $select_stmt->bindParam(':hotels_name', $hotelname);

        $select_stmt->execute();
        $row = $select_stmt->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา

        // ถ้าแสดงแถวแล้วได้จำนวน > 0 แปลว่า ข้อมูลซ้ำ
        if ($row['count_name'] != 0) {
            $_SESSION['exist_hotelname'] = "มี โรงแรม นี้แล้วในระบบ";
            header('location: ../registerhotel.php');
            exit;
        }


        // ถ้าไม่มี ลงทะเบียนได้
        else {

            //////////////////////////// IMAGE FILES ////////////////////////////

            if ($_SERVER["REQUEST_METHOD"] !== "POST") {
                exit('POST request method required');
            }

            if (empty($_FILES)) {
                exit('$_FILES is empty - is file_uploads set to "Off" in php.ini?');
            }

            if ($_FILES["hotel_img"]["error"] !== UPLOAD_ERR_OK) {

                switch ($_FILES["hotel_img"]["error"]) {
                    case UPLOAD_ERR_PARTIAL:
                        exit('File only partially uploaded');
                    case UPLOAD_ERR_NO_FILE:
                        exit('No file was uploaded');
                    case UPLOAD_ERR_EXTENSION:
                        exit('File upload stopped by a PHP extension');
                    case UPLOAD_ERR_FORM_SIZE:
                        exit('File exceeds MAX_FILE_SIZE in the HTML form');
                    case UPLOAD_ERR_INI_SIZE:
                        exit('File exceeds upload_max_filesize in php.ini');
                    case UPLOAD_ERR_NO_TMP_DIR:
                        exit('Temporary folder not found');
                    case UPLOAD_ERR_CANT_WRITE:
                        exit('Failed to write file');
                    default:
                        exit('Unknown upload error');
                }
            }

            // กำหนดขนาดไฟล์
            // if ($_FILES["hotel_img"]["size"] > 1048576) {
            //     exit('File too large (max 1MB)');
            // }

            // เช็คว่านามสกุลไฟล์เป็น
            $finfo = new finfo(FILEINFO_MIME_TYPE);
            $mime_type = $finfo->file($_FILES["hotel_img"]["tmp_name"]);

            $mime_types = ["image/gif", "image/png", "image/jpeg"];

            if (!in_array($_FILES["hotel_img"]["type"], $mime_types)) {
                print_r($_FILES);
                exit("Invalid file type");
            }

            // แก้ชื่อไฟล์ถ้าชื่อไฟล์มีตัวอักษรพิเศษ
            $pathinfo = pathinfo($_FILES["hotel_img"]["name"]);

            $base = $pathinfo["filename"];

            $base = preg_replace("/[^\w-]/", "_", $base);

            $filename = $base . "." . $pathinfo["extension"];

            //ตำแหน่งไฟล์
            $destination = __DIR__ . "/uploads_img/" . $filename;

            // ชื่อไฟล์ซ้ำ
            $i = 1;

            while (file_exists($destination)) {

                $filename = $base . "($i)." . $pathinfo["extension"];
                $destination = __DIR__ . "/uploads_img/" . $filename;

                $i++;
            }

            if (!move_uploaded_file($_FILES["hotel_img"]["tmp_name"], $destination)) {

                exit("Can't move uploaded file");
            }

            // echo "File uploaded successfully.";

            //////////////////////////// END IMAGE FILES ////////////////////////////

            // ค้นหา location_id จากตาราง Locations โดยใช้ชื่อจังหวัดเป็นเงื่อนไข
            $select_stmt2 = $db->prepare("SELECT location_id FROM locations WHERE location_name = :hotels_city");
            $select_stmt2->bindParam(':hotels_city', $hotelcity);
            $select_stmt2->execute();

            $rowid = $select_stmt2->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา id


            // ส่ง requests  เพิ่มข้อมูลลงในตาราง requests
            $insert_stmt = $db->prepare("INSERT INTO requests
            (user_id, req_hotels_name, req_hotels_phone, req_hotels_address, req_hotels_postcode, 
            req_hotels_description, req_hotels_img, req_sent_date, req_status, location_id)
            VALUES (:user_id, :hotels_name , :hotels_phone , :hotels_address, :hotels_postcode, 
            :hotels_des, :hotels_img, :req_sent_date, 'WAITING', :location_id)");



            $insert_stmt->bindParam(':user_id', $_SESSION["userid"]);
            $insert_stmt->bindParam(':hotels_name', $hotelname);
            $insert_stmt->bindParam(':hotels_phone', $hotelphone);
            $insert_stmt->bindParam(':hotels_address', $hoteladd);
            $insert_stmt->bindParam(':hotels_des', $hoteldes);
            $insert_stmt->bindParam(':hotels_postcode', $hotelcode);
            $insert_stmt->bindParam(':hotels_img', $filename);
            $insert_stmt->bindParam(':req_sent_date', $req_date);
            $insert_stmt->bindParam(':location_id', $rowid['location_id']);
            $insert_stmt->execute();

            // ลงทะเบียนสำเร็จ  ถ้าเพิ่มข้อมูลผ่านแล้ว จะให้ทำการเก็บ status เอาไปใช้ต่อ
            if ($insert_stmt) {
                $select_stmt3 = $db->prepare("SELECT req_status FROM requests WHERE user_id = :user_id");
                $select_stmt3->bindParam(':user_id', $_SESSION["userid"]);
                $select_stmt3->execute();

                $rowstatus = $select_stmt3->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา 
                $_SESSION["req_status"] = $rowstatus['req_status'];
                $_SESSION['is_req'] = true;

                header('location: ../registerhotel.php');
            }

            // ลงทะเบียนไม่สำเร็จ
            else {
                $_SESSION['err_insert'] = "ไม่สามารถนำเข้าข้อมูลได้";
                header('location: ../registerhotel.php');
                exit;
            }
        }
    }
} elseif (isset($_POST['req_back'])) {
    header('location: ../index.php');
    exit;
} elseif (isset($_POST['req_cancel'])) {
    header('location: ../index.php');
    exit;
}



/*

$insert_stmt = $db->prepare("INSERT INTO hotels (hotels_name, hotels_address, hotels_phone,hotels_city,
hotels_postcode,hotels_imageUrl,hotels_description)
VALUES (:hotels_name, :hotels_address, :hotels_phone,:hotels_city,
:hotels_postcode,:hotels_imageUrl,:hotels_description)");

$insert_stmt->bindParam(':hotels_name', $hotelname);
$insert_stmt->bindParam(':hotels_address', $hoteladd);
$insert_stmt->bindParam(':hotels_phone', $hoteladd);
$insert_stmt->bindParam(':hotels_city', $hotelcity);
$insert_stmt->bindParam(':hotels_postcode', $hotelcode);
$insert_stmt->bindParam(':hotels_img', $hotelimg);
$insert_stmt->bindParam(':hotels_description', $hoteldes)

$insert_stmt->execute();

*/
