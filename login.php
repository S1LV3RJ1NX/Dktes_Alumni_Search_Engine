<?php 
session_start();
ob_start();
?>

	<?php 

		include('ckcn.php');

		function test_input($data) 
		{
			$data = trim($data);
			$data = stripslashes($data);
			$data = htmlspecialchars($data);
			return $data;
		}

		if(isset($_POST["submit"])) {

			$email = test_input($_POST['email']);
			$pass = $_POST['password'];
			$valid=true;
			$err = "";

			$valid = checkLogin($email, $pass, $valid);

			if($valid){
				$sql = "Select id from alumni_info where email = '$email'";
				$result = mysqli_query($GLOBALS['conn'], $sql);
				if(mysqli_num_rows($result) > 0)
				{
					$row = mysqli_fetch_array($result);
					$_SESSION["user"] = $row['id'];
					header('Location: search.php');
					ob_end_flush();
					// die();	
				}
				
			}

			else{
				$err = "Invalid email/password";
			}
		}

	 ?>
<html>
<head>
	<title>Login</title>

	 <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="css/login.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>
<body>




	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="index.php" style="padding-left: 3%">DKTES Alumni Portal </a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  	</button>

	  	<div class="collapse navbar-collapse" id="navbar" style="padding-left: 73%">
	    	<ul class="navbar-nav mr-auto">
	    		<li class="nav-item" >
	        		<a class="nav-link" href="register.php" >Register</a>
	      		</li>
	    	</ul>
	  </div>
	</nav>
	<div class="wrapper fadeInDown">
		<?php
			$success = $_GET['success_msg'];

			if(strlen($success)>0){
				echo '<div class="alert alert-success" role="alert" style="margin-top: -7%; margin-bottom: -1% ">'.$success.'</div>';

			} 
	 	?>
	 	<?php 
		       
		      if(strlen($err)>0){
				echo '<div class="alert alert-danger" role="alert" style="margin-top: -7%; margin-bottom: -1% ">'.$err.'</div>';
				$err = '';
				}
		?>
	 	<br>

	 	<h1 style="margin-bottom: 2%;"> Portal Login </h1>
 		 <div id="formContent" style="padding-top: 2%;">

		    <!-- Login Form -->
		    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		      <input type="text" class="fadeIn second" name="email" placeholder="email" required>
		      <input type="password" class="fadeIn third" name="password" placeholder="password" required>
		      
		      <input type="submit" class="fadeIn fourth" value="Login" name="submit">
		    </form>

		    <!-- Remind Passowrd -->
		    <div id="formFooter">
		      <a class="underlineHover" href="password_reset.php">Forgot Password?</a>
		    </div>


  		</div>
	</div>	

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  
</body>
</html>
