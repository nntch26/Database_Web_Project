<?php
session_start();
session_destroy();
header('location: ../FrontEnd/index.php');
?>
