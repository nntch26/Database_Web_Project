<?php 
 // ประกาศ session และทำลายทิ้ง
session_start(); 
session_destroy();
header('location: ../FrontEnd/index.php');
?>