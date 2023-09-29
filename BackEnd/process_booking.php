<?php
session_start();
include('includes/connect_database.php');
$booking_number = $_POST["bookings_number"];
$price_with_night = intval($_POST["price_with_night"]);
$bookings_nights = intval($_POST["number_of_nights"]);
$_SESSION["booking_number"] = $booking_number;
$_SESSION["price_with_night"] = $price_with_night;
$_SESSION["bookings_nights"] = $bookings_nights;
// calculate total price
$total_pay = ($price_with_night * $booking_number);
$_SESSION["total_pay"] = $total_pay;

// *-------------------------------------* //

$update_stmt = $db->prepare("UPDATE users SET users_first_name = :u_firstname, 
    users_last_name = :u_lastname , users_phone_number = :u_phone, users_address = :u_address 
    WHERE user_id = :u_userid");

$update_stmt->bindParam(':u_firstname', $_POST["fname"]);
$update_stmt->bindParam(':u_lastname', $_POST["lname"]);
$update_stmt->bindParam(':u_phone', $_POST["phone"]);
$update_stmt->bindParam(':u_address', $_POST["address"]);
$update_stmt->bindParam(':u_userid', $_SESSION["userid"]);

$update_stmt->execute();

// *-------------------------------------* //

$insert_stmt = $db->prepare("INSERT INTO bookings (user_id, hotel_id, room_id, bookings_check_in, bookings_check_out, bookings_nights, bookings_number, bookings_total_price, bookings_status)
                            VALUES (:user_id, :hotel_id, :room_id, :bookings_check_in, :bookings_check_out, :bookings_nights, :bookings_number, :bookings_total_price, 'WAITING')");

$insert_stmt->bindParam(':user_id', $_SESSION["userid"]);
$insert_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
$insert_stmt->bindParam(':room_id', $_SESSION["room_id"]);
$insert_stmt->bindParam(':bookings_check_in', $_SESSION["checkin"]);
$insert_stmt->bindParam(':bookings_check_out', $_SESSION["checkout"]);
$insert_stmt->bindParam(':bookings_nights', $_SESSION["bookings_nights"] );
$insert_stmt->bindParam(':bookings_number', $_SESSION["booking_number"]);
$insert_stmt->bindParam(':bookings_total_price', $_SESSION["total_pay"]);

$insert_stmt->execute();

// *-------------------------------------* //

if ($update_stmt && $insert_stmt) {
    header('location: ../payments.php');
}
