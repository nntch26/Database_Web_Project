<?php
session_start();
session_destroy();
header("location: ../FrontEnd/login.php");
?>
