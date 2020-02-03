<?php 
session_start();
ob_start();
include('ckcn.php'); 
mysqli_close($GLOBALS['conn']);
unset($_SESSION["user"]);
header("Location: login.php");
?>