<?php 
session_start();
ob_start();
include('../ckcn.php'); 
mysqli_close($GLOBALS['conn']);
unset($_SESSION["admin"]);
header("Location: admin_login.php");
 ?>