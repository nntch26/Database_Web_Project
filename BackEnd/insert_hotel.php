<?php
include 'includes/connect_database.php';
session_start();

$sql = "INSERT INTO hotels (name, address, description, ImageUrl, StartingPrice)
VALUES ('PhumHotel', 'lalala', 'ม่านรูด', 'www.bruh.jpg', 1000)";

if (mysqli_query($conn, $sql)) {
  echo " New record created successfully";
} else {
  echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
