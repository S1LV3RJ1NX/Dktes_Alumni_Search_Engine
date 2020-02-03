<?php 
session_start(); 
ob_start();
?>
<html>
<head>
	<title>New Password</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	
	<div class="container" style="padding-top: 3%"> 

		<?php

			include('ckcn.php');
			$errPassMatch = $errPass = "";


			if(isset($_POST["submit"]) && isset($_SESSION['tk'])) {

				$valid=true;
				$err = "";
				$pass = $_POST['password'];
				$pass2 = $_POST['password2'];
				$token = $_SESSION['tk'];
				if(empty($pass) || (preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $pass) === 0)) {

					$errPass = '<p class="errText">ERROR:=> Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit</p>';
					$valid=false;
				}

				if($pass != $pass2){
					$errPassMatch = '<p>Password do not match!!</p>';
					$valid = false;
				}

				if($valid){
					$password = password_hash($pass, PASSWORD_DEFAULT);
					
					$sql = "select email from pass_reset where token='$token';";
					$result = mysqli_query($GLOBALS['conn'], $sql);

					if(mysqli_num_rows($result) > 0)
					{
						$row = mysqli_fetch_array($result);
						$email = $row['email'];

						$sql = "Update alumni_info set password = '$password' where email = '$email';";

						if(mysqli_query($GLOBALS['conn'], $sql))
						{
							$query = "delete from pass_reset where email='$email';";
							$res = mysqli_query($GLOBALS['conn'], $query);
							$success_msg = "Password changed successfully";
							unset($_SESSION["token"]);
							header("location:login.php?success_msg=".urlencode($success_msg));
						}
						else{
							// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
							// $_SESSION['tk'] = $_GET['token']; 
							ob_start();
							header('Location: 404.php');
							ob_end_flush();
							die();
						}
					}
					else{
						$err = "Reset link not valid";
					}

				}
			}
		?>

		<h2 style="text-align: center; padding-bottom: 1%">Password Reset Form</h2>
		<?php 
			
			$_SESSION['tk'] = $_GET['token']; 
			// echo "".$_SESSION['tk'];
				
		?>

		<?php 
				if(strlen($err)>0){
					echo '<div class="alert alert-danger col-sm-6" role="alert" style="margin-left:20%; text-align:center;" >'.$err.'</div>';
					$err = '';
				}
		?>
		<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

			
			<div class="form-group row">
				<label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
				<div class="col-sm-10">
					<input type="password" class="form-control col-sm-8"  name="password" placeholder="Password" required>
					<small>Password must be 8 characters and must contain at least one lower case letter, one upper case letter and one digit</small>
					<?php echo "<br>".$errPass; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputPassword3" class="col-sm-2 col-form-label">Password Confirm</label>
				<div class="col-sm-10">
					<input type="password" class="form-control col-sm-8"  name="password2" placeholder="Password" required>
					<?php echo $errPassMatch; ?>
				</div>
			</div>

			<div class="form-group row"  >
				<div class="offset-sm-2 col-sm-10"  >
					<input type="submit" value="Reset" style="margin-top: 2%; margin-left: 25%; display: block;" name="submit" class="btn btn-primary"/>
				</div>
			</div>

		</form>
</body>
</html>