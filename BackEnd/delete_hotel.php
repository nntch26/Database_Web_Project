<?php
include 'includes/connect_database.php';
session_start();

$sql = "DELETE FROM hotels WHERE HotelID = 3";

if ($db->query($sql) === TRUE) {
  echo " Record deleted successfully";
} else {
  echo "Error deleting record: " . $conn->error;
}
