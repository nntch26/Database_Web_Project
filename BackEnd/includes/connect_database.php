<?php

$servername = "localhost";
$username = "root";

// Create connection
$conn = new mysqli($servername, $username, "", "dbtesto");

// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully";

?>
