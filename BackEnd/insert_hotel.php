<?php
include 'includes/connect_database.php';
session_start();

$hotels_name = 'PhumHotel';
$hotels_address = 'lalala';
$hotels_description = 'ม่านรูด';
$hotels_imageUrl = 'www.bruh.jpg';
$location_id = 1;

$select_stmt = $db->prepare("INSERT INTO hotels (hotels_name, hotels_address, hotels_description, hotels_imageUrl, location_id) VALUES (:name, :address, :description, :imageurl, :location)");
$select_stmt->bindParam(':name', $hotels_name);
$select_stmt->bindParam(':address', $hotels_address);
$select_stmt->bindParam(':description', $hotels_description);
$select_stmt->bindParam(':imageurl', $hotels_imageUrl);
$select_stmt->bindParam(':location', $location_id);

try {
  $select_stmt->execute();
  echo " New record created successfully";
} catch (Exception $e) {
  echo "Error" .$e->getMessage() ;
}
