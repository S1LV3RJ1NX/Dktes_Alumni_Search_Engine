<?php 
ob_start();
 ?>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Register</title>
</head>
<body>
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="index.php" style="padding-left: 3%">DKTES Alumni Portal </a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  	</button>

	  	<div class="collapse navbar-collapse" id="navbar" style="padding-left: 70%">
	    	<ul class="navbar-nav mr-auto">
	    		<li class="nav-item" >
	        		<a class="nav-link" href="login.php" >Login</a>
	      		</li>
	    	</ul>
	  </div>
	</nav>
	<div class="container" style="padding-top: 3%"> 

		<?php

			include('ckcn.php');

			function test_input($data) 
			{
				$data = trim($data);
				$data = stripslashes($data);
				$data = htmlspecialchars($data);
				return $data;
			}
	

			$errPassMatch = $errPass = $errMob = $errfn = $errln = $errMail = $errMob_exst = $errPrn = "";

			if(isset($_POST["submit"])) {

			 	$fname = test_input(ucfirst(strtolower($_POST['fname'])));
			 	$lname = test_input(ucfirst(strtolower($_POST['lname'])));
			 	$addr = test_input(ucfirst(strtolower($_POST['addr'])));
				$email = test_input($_POST['email']);
				$pass = $_POST['password'];
				$pass2 = $_POST['password2'];
				$id = test_input(strtolower($_POST['prn']));
				$mobile = test_input($_POST['mobile']);
				$company = test_input(ucfirst($_POST['company']));
				$dept = test_input($_POST['dept']);
				$desgn = test_input($_POST['desgn']);
				$passout = test_input($_POST['passout']);
				$from_yr = test_input($_POST['from_yr']);
				$to_yr = test_input($_POST['to_yr']);

				$valid=true;

				if(checkPresent($email, 'email')){
					$valid = false;
					$errMail = "Email already exists"; 
				}

				if(checkPresent($id, 'id')){
					$valid = false;
					$errPrn = "PRN already exists"; 
				}
				
				if(checkPresent($mobile, 'mobile')){
					$valid = false;
					$errMob_exst = "Mobile no already exists"; 
				}
				
				if(empty($pass) || (preg_match("/^.*(?=.{8,})(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/", $pass) === 0)) {

					$errPass = '<p class="errText">ERROR:=> Password must be at least 8 characters and must contain at least one lower case letter, one upper case letter and one digit</p>';
					$valid=false;
				}

				if($pass != $pass2){
					$errPassMatch = '<p>Password do not match!!</p>';
					$valid = false;
				}

				if(empty($company)){
					$company = 'Unemployed';
				}

				if(!is_numeric($mobile) && strlen($mobile)!=10){
					$errMob = "Invalid mobile no";
					$valid = false;
				}

				if(is_numeric($fname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $fname)){
					$errfn = "Invalid First Name. Only alphabets allowed.";
					$valid = false;
				}

				if(is_numeric($lname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lname)){
					$errln = "Invalid Last Name. Only alphabets allowed.";
					$valid = false;
				}

				if($valid){
					$password = password_hash($pass, PASSWORD_DEFAULT);
					dbStore($fname, $lname, $addr, $email, $password,  $dept, $passout,  $mobile, $company, $desgn, $from_yr, $to_yr, $id);
					$success_msg = "Registered successfully";
					header("location:login.php?success_msg=".urlencode($success_msg));
				}


				
			 
			}
		
		?>

		<h2 style="text-align: center; padding-bottom: 1%">Alumni Registration Form</h2>
		<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">First Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="fname" placeholder="Adam" required>
					<?php echo $errfn; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Last Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="lname" placeholder="Joe" required>
					<?php echo $errln; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Address</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="addr" placeholder="Building, Society, Street, Area" >
				</div>
			</div>
			
			<div class="form-group row">
				<label for="inputEmail" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control col-sm-8" id="inputEmail" name="email" placeholder="abc@example.com" required>
					<?php echo $errMail; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputEmail" class="col-sm-2 col-form-label">Prn</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="prn" placeholder="16ucs12051xx" required>
					<small>Enter carefully cannot be changed later</small>
					<?php echo "<br>".$errPrn; ?>
				</div>
			</div>

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

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Mobile</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="mobile" placeholder="9305715867" required>
					<?php echo $errMob; ?>
					<?php echo $errMob_exst; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="dept" class="col-sm-2 col-form-label"> Department: </label>
				<div class="col-sm-10">
	                 <select style="width:100%" class="form-control col-sm-8" name="dept" required>
	                      <option>Computer Science and Engneering</option>
	                      <option>Mechanical Engneering</option>
	                      <option>Electronics Engneering</option>
	                      <option>Electronics and Telecommunication Engneering</option>
	                      <option>Information Technology</option>
	                </select>
                </div>
			</div>
			
			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Passout Year</label>
				<div class="col-sm-10">
				<select class="form-control col-sm-8" name="passout" required>
					<?php 
					   for($i = 1993 ; $i < date('Y') + 5; $i++){
					      echo "<option>$i</option>";
					   }
					?>
				</select>
				</div>
			</div>
			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Curr. Company</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="company" placeholder="Microsoft" >
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label" >Designation</label>
				<input type="text" name="desgn" class="form-control col-sm-4" placeholder="Manager" style="margin-left: 1% ; margin-right:2%;">
				
				<!-- <div class="col-sm-6"> -->
				<label for="inputUser" class="col-sm-2 col-form-label" style="margin-left: -1%">From</label>
				<select class="form-control col-sm-1" name="from_yr" style="margin-left: -10%" required>
					<?php 
					   for($i = 1993 ; $i < date('Y') + 5; $i++){
					      echo "<option>$i</option>";
					   }
					?>
				</select>

				<label for="inputUser" class="col-sm-2 col-form-label">To</label>
				<select class="form-control col-sm-2" name="to_yr" style="margin-left: -12%"required>
					<?php 
						echo "<option>present</option>";
					   for($i = 1993 ; $i < date('Y') + 5; $i++){
					      echo "<option>$i</option>";
					   }
					?>
				</select>
			</div>

					
			<div class="form-group row"  >
				<div class="offset-sm-2 col-sm-10"  >
					<input type="submit" value="Register" style="margin-top: 2%; margin-left: 25%; display: block;" name="submit" class="btn btn-primary"/>
				</div>
			</div>
		</form>
	</div>





	 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</body>
</html>