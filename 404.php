<?php 
session_start();
ob_start();
include('ckcn.php'); 
mysqli_close($GLOBALS['conn']);
unset($_SESSION["user"]);
?>
<html>
<head>
	<title>404</title>
</head>
<body>
	<div class="container" style="text-align: center;">
		<h1>Something Wrong on Server Side!!</h1>
		<h2>Our Sincere appologies we shall fix it as soon as possible!!</h2>
	</div>
	
</body>
</html>