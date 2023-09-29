<?php
ob_start();
session_start();
include('includes/connect_database.php'); // ดึงไฟล์เชื่อม database เข้ามา

// เช็คว่ามีการกดปุ่ม submit มาหรือไม่
echo 'here';
if (isset($_GET['search'])){
    $_SESSION['GetSearch'] = 'getsearch';
    $_SESSION["hotel_id"] = $_GET["hotel_id"];
    $_SESSION["checkin"] = $_GET["checkin_date"];
    $_SESSION["checkout"] = $_GET["checkout_date"];

    // เช็คว่ามีการกดปุ่ม submit มาหรือไม่
    //$checkin_date = new DateTime($_GET['checkin_date']);
   // $checkout_date = new DateTime($_GET['checkout_date']);
    //$interval = $checkin_date->diff($checkout_date);
   // $day_difference = $interval->days;
    $hotel_id = $_GET["hotel_id"];
    $checkin = $_GET["checkin_date"];
    $checkout = $_GET["checkout_date"];
    // เช็คว่ามีการกดปุ่ม submit มาหรือไม่

    echo  $hotel_id;
    echo $_GET["checkout_date"];
    echo "จำนวนวันระหว่าง check-in และ check-out: " . $day_difference . "คืน";
    $sql = "SELECT r.room_id, rooms_img, rooms_type, rooms_size, rooms_number - IFNULL(num_booked, 0) AS available_rooms
    FROM hotels h
    JOIN rooms r USING (hotel_id)
    LEFT JOIN (
      SELECT b.room_id, COUNT(bookings_status) AS num_booked
      FROM hotels h
      JOIN rooms r USING (hotel_id)
      LEFT JOIN bookings b USING (hotel_id, room_id)
      WHERE hotel_id = :hotel_id
      AND bookings_status = 'Confirmed'
      AND (
        (bookings_check_in >= :checkin AND bookings_check_in < :checkout)
        OR (bookings_check_out > :checkin AND bookings_check_out <= :checkout)
        OR (bookings_check_in <= :checkin AND bookings_check_out >= :checkout)
      )
      GROUP BY b.room_id
    ) AS booked_rooms ON r.room_id = booked_rooms.room_id
    WHERE h.hotel_id = :hotel_id";

try {
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':hotel_id', $hotel_id, PDO::PARAM_INT);
    $stmt->bindParam(':checkin',  $checkin, PDO::PARAM_STR);
    $stmt->bindParam(':checkout', $checkout, PDO::PARAM_STR);
    $stmt->execute();

    // แสดงข้อมูล
    echo '<table>';
    echo '<tr><th>Room ID</th><th>Room Image</th><th>Room Type</th><th>Room Size</th><th>Available Rooms</th><th>จำนวนห้องที่จะจอง</th></tr>';
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo '<tr>';
        echo '<td>' . $row['room_id'] . '</td>';
        echo '<td>' . $row['rooms_img'] . '</td>';
        echo '<td>' . $row['rooms_type'] . '</td>';
        echo '<td>' . $row['rooms_size'] . '</td>';
        echo '<td>' . $row['available_rooms'] . '</td>';
        echo '<td>  หฟก  </td>';
        echo '</tr>';
    }
    echo '</table>';
} catch (PDOException $e) {
    echo 'เกิดข้อผิดพลาดในการประมวลผลคำสั่ง SQL: ' . $e->getMessage();

}
  header('location: ../book.php');
}else{
  
}
ob_end_flush();
?>

