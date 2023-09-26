<?php
session_start();
include('includes/connect_database.php');

$update_stmt = $db->prepare("UPDATE users SET users_first_name = :u_firstname, 
        users_last_name = :u_lastname , users_email = :u_email , users_phone_number = :u_phone, users_address = :u_address 
        WHERE users_username = :username");

$update_stmt->bindParam(':u_firstname', $_POST["fname"]);
$update_stmt->bindParam(':u_lastname', $_POST["lname"]);
$update_stmt->bindParam(':u_email', $_POST["email"]);
$update_stmt->bindParam(':u_phone', $_POST["phone"]);
$update_stmt->bindParam(':u_address', $_POST["address"]);
$update_stmt->bindParam(':u_username', $_SESSION["username"]);

$update_stmt->execute();

$insert_stmt = $db->prepare("INSERT INTO bookings (user_id, hotel_id, room_id, bookings_check_in, bookings_check_out, bookings_night, bookings_number, bookings_number_total_price, bookings_status)
                            VALUES (:user_id, :hotel_id, :room_id, :bookings_check_in, :bookings_check_out, :bookings_number, :bookings_number_total_price, 'WAITING')");

$insert_stmt->bindParam(':user_id', $_SESSION["user_id"]);
$insert_stmt->bindParam(':hotel_id', $_SESSION["hotel_id"]);
$insert_stmt->bindParam(':room_id', $_SESSION["room_id"]);
$insert_stmt->bindParam(':bookings_check_in', $_POST["email"]);
$insert_stmt->bindParam(':bookings_check_out', $_POST["phone"]);
$insert_stmt->bindParam(':bookings_number', $_POST["address"]);
$insert_stmt->bindParam(':bookings_number_total_price', $_SESSION["username"]);

$insert_stmt->execute();

if ($update_stmt || $insert_stmt) {
    header('location: ../payments.php');
}
?>