
<?php
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

// เช็คว่ามีการกดปุ่ม submit มาหรือไม่

if (isset($_POST['room_submit'])) {
    $roomtype = $_POST['room_type'];
    $roomdes = $_POST['room_description'];
    $roomprice = $_POST['room_price'];
    $roomsize = $_POST['room_size'];
    $room_facility = $_POST['room_facility'];
    $room_num = $_POST['room_num'];
    

    // เรียกใช้ hotel id
    $select_stmt4 = $db->prepare("SELECT * FROM hotels WHERE user_id = :user_id");
    $select_stmt4->bindParam(':user_id', $_SESSION["userid"]);
    $select_stmt4->execute();
    $row = $select_stmt4->fetch(PDO::FETCH_ASSOC);

    $_SESSION["hotel_id"] = $row['hotel_id']; // เอาไปใช้ต่อ


    // เช็คว่า เป็นข้อมูลที่รับมาเป็นค่าว่าง หรือไม่
    if (empty($roomtype) || empty($roomdes) || empty($roomprice) 
        || empty($roomsize) || empty($room_facility) || empty($room_num)) {

        $_SESSION['err_editroom'] = "โปรดระบุข้อมูลของคุณให้ครบถ้วน";
        header('location: ../insertroom.php'); // กลับไปหน้า edit
        exit; // จบการทำงาน
    }



    // กรอกข้อมูลครบ 
    else {

        //////////////////////////// IMAGE FILES ////////////////////////////

        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            exit('POST request method required');
        }

        if (empty($_FILES)) {
            exit('$_FILES is empty - is file_uploads set to "Off" in php.ini?');
        }

        if ($_FILES["room_img"]["error"] !== UPLOAD_ERR_OK) {

            switch ($_FILES["room_img"]["error"]) {
                case UPLOAD_ERR_PARTIAL:
                    exit('File only partially uploaded');
                case UPLOAD_ERR_NO_FILE:
                    $_SESSION['err_editroomimg'] = "โปรดใส่รูปภาพของคุณให้ครบถ้วน";
                    header('location: ../insertroom.php'); // กลับไปหน้า edit
                    exit;

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


        // เช็คว่านามสกุลไฟล์เป็น
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime_type = $finfo->file($_FILES["room_img"]["tmp_name"]);

        $mime_types = ["image/gif", "image/png", "image/jpeg"];

        if (!in_array($_FILES["room_img"]["type"], $mime_types)) {
            print_r($_FILES);
            exit("Invalid file type");
        }

        // แก้ชื่อไฟล์ถ้าชื่อไฟล์มีตัวอักษรพิเศษ
        $pathinfo = pathinfo($_FILES["room_img"]["name"]);

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

        if (!move_uploaded_file($_FILES["room_img"]["tmp_name"], $destination)) {

            exit("Can't move uploaded file");
        }

        // echo "File uploaded successfully.";

        //////////////////////////// END IMAGE FILES ////////////////////////////



        //  เพิ่มข้อมูลลงในตาราง rooms
        $sql = "INSERT INTO rooms (hotel_id, rooms_price, rooms_type, rooms_size, rooms_description ,rooms_img ,rooms_number)
        VALUES (:hotel_id, :room_price, :room_type, :room_size, :rooms_des, :rooms_img, :rooms_num)";
        
        $insert_stmt = $db->prepare($sql);



        $insert_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
        $insert_stmt->bindParam(':room_price', $roomprice);
        $insert_stmt->bindParam(':room_type', $roomtype);
        $insert_stmt->bindParam(':room_size', $roomsize);
        $insert_stmt->bindParam(':rooms_des', $roomdes);
        $insert_stmt->bindParam(':rooms_img', $filename);
        $insert_stmt->bindParam(':rooms_num', $room_num);

        $insert_stmt->execute();

        ////////////////////////////////////////////////////////////

        $select_stmt5 = $db->prepare("SELECT * FROM rooms WHERE hotel_id = :hotel_id ORDER BY room_id DESC");
        $select_stmt5->bindParam(':hotel_id', $_SESSION["hotel_id"]);
        $select_stmt5->execute();

        $rowidro = $select_stmt5->fetch(PDO::FETCH_ASSOC); // ดึงข้อมูลออกมา id ล่าสุดออกมา

         // เพิ่มข้อมูลลงในตาราง roomsfacility
 
         foreach ($room_facility as $facility_id) {
            $sqlf = "INSERT INTO `roomsfacility` (`facility_id`, `room_id`)
            VALUES(:facility_id, :room_id)";

            $select_stmt6 = $db->prepare($sqlf);

            $select_stmt6->bindParam(':facility_id',  $facility_id);
            $select_stmt6->bindParam(':room_id', $rowidro['room_id']);
            $select_stmt6->execute();
        }




        // สำเร็จ  ถ้าเพิ่มข้อมูลผ่านแล้ว 
        if ($insert_stmt) {
            $_SESSION['is_room'] = true;

            header('location: ../insertroom.php');
        }

        // ไม่สำเร็จ
        else {
            $_SESSION['err_roominsert'] = "ไม่สามารถนำเข้าข้อมูลได้";
            header('location: ../insertroom.php');
            exit;
        }
    } 
    

} elseif (isset($_POST['room_back'])) {
    header('location: ../profilehotel.php');
    exit;

} elseif (isset($_POST['room_cancel'])) {
    header('location: ../profilehotel.php');
    exit;
}




