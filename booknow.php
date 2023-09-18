<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotelId = $_POST["hotel_id"];
    $hotelName = $_POST["hotel_name"];
    $hotelAddress = $_POST["hotel_address"];
  echo $hotelId . $hotelName . $hotelAddress;
  // ทำสิ่งที่คุณต้องการกับข้อมูลที่ได้รับ
  // ตัวอย่าง: บันทึกข้อมูลลงในฐานข้อมูลหรือทำการประมวลผลเพิ่มเติม
  // เช่น: $query = "INSERT INTO bookings (hotel_id, hotel_name, hotel_address) VALUES (:hotelId, :hotelName, :hotelAddress)";
  // แล้วใช้ PDO เพื่อส่งคำสั่ง SQL ไปทำงาน
} else {
  echo "ไม่พบข้อมูลที่ต้องการ";
}
?>