<?php
session_start();
include('includes/connect_database.php');
$date = date('Y-m-d');

$select_stmt = $db->prepare("SELECT booking_id
                            FROM bookings
                            WHERE user_id = :user_id
                            AND hotel_id = :hotel_id
                            AND room_id = :room_id
                            AND bookings_check_in = :check_in
                            AND bookings_check_out = :check_out
                            AND bookings_total_price = :bookings_total_price
                            LIMIT 1;");
$select_stmt->bindParam(':user_id', $_SESSION["userid"]);
$select_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
$select_stmt->bindParam(':room_id', $_SESSION["room_id"]);
$select_stmt->bindParam(':check_in', $_SESSION["checkin"]);
$select_stmt->bindParam(':check_out', $_SESSION["checkout"]);
$select_stmt->bindParam(':bookings_total_price', $_SESSION["total_pay"]);
$select_stmt->execute();

$result = $select_stmt->fetch(PDO::FETCH_ASSOC);

//////////////////////////// IMAGE FILES ////////////////////////////

// เพิ่มไฟล์รูป

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit('POST request method required');
}

if (empty($_FILES)) {
    exit('$_FILES is empty - is file_uploads set to "Off" in php.ini?');
}

if ($_FILES["bill_img"]["error"] !== UPLOAD_ERR_OK) {

    switch ($_FILES["bill_img"]["error"]) {
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
// if ($_FILES["bill_img"]["size"] > 1048576) {
//     exit('File too large (max 1MB)');
// }

// เช็คว่านามสกุลไฟล์เป็น
$finfo = new finfo(FILEINFO_MIME_TYPE);
$mime_type = $finfo->file($_FILES["bill_img"]["tmp_name"]);

$mime_types = ["image/gif", "image/png", "image/jpeg"];

if (!in_array($_FILES["bill_img"]["type"], $mime_types)) {
    print_r($_FILES);
    exit("Invalid file type");
}

// แก้ชื่อไฟล์ถ้าชื่อไฟล์มีตัวอักษรพิเศษ
$pathinfo = pathinfo($_FILES["bill_img"]["name"]);

$base = $pathinfo["filename"];

$base = preg_replace("/[^\w-]/", "_", $base);

$filename = $base . "." . $pathinfo["extension"];

//ตำแหน่งไฟล์
$destination = __DIR__ . "/bill_img/" . $filename;

// ชื่อไฟล์ซ้ำ
$i = 1;

while (file_exists($destination)) {

    $filename = $base . "($i)." . $pathinfo["extension"];
    $destination = __DIR__ . "/bill_img/" . $filename;

    $i++;
}

if (!move_uploaded_file($_FILES["bill_img"]["tmp_name"], $destination)) {

    exit("Can't move uploaded file");
}

// echo "File uploaded successfully.";

//////////////////////////// END IMAGE FILES ////////////////////////////

$insert_stmt = $db->prepare("INSERT INTO payments (booking_id, payment_date, payments_amount, payments_img, payments_status)
VALUES (:booking_id, :payment_date, :payments_amount, :payments_img, :payments_status)");

$insert_stmt->bindParam(':booking_id', $result["booking_id"]);
$insert_stmt->bindParam(':payment_date', $date);
$insert_stmt->bindParam(':payments_amount', $_SESSION["total_pay"]);
$insert_stmt->bindParam(':payments_img', $filename);
$insert_stmt->bindValue(':payments_status', 'WAITING');

$insert_stmt->execute();

if ($insert_stmt) {
    header('location: ../confirm_payment.php');
}
