<?php 
session_start();
ob_start();
if(!isset($_SESSION['user'])){
	header("Location:login.php");
}
?>
<html>
<head>
	<title>Search Alumni</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- <link rel="stylesheet" type="text/css" href="css/login.css"> -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>


   	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
	<a class="navbar-brand" href="#" style="padding-left: 3%">DKTES Alumni Portal </a>
  	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  	</button>

	  	<div class="collapse navbar-collapse" id="navbar" style="padding-left: 70%">
	    	<ul class="navbar-nav mr-auto">
	    		<li class="nav-item" >
	        		<a class="nav-link" href="profile.php" >Profile</a>
	      		</li>
	      		<li class="nav-item" >
	        		<a class="nav-link" href="logout.php" >Logout</a>
	      		</li>
	    	</ul>
	  </div>
	</nav>
	<div>
		<h1 style="text-align: center; margin-top: 3%;">Alumni Search</h1>
	</div>
	<div class="container-fluid" style="padding-left: 10%">
		

		<div style="margin-top: 5%;">
			<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
				<fieldset>
					<div class="form-row">
			            <div class="form-group col-md-2">
			              <input style="width:100%" type="text" autofocus class="form-control" name="fname" placeholder="First Name">
			            </div>
			            <div class="form-group col-md-2">
			              <input style="width:100%" type="text" class="form-control" name="lname" placeholder="Last Name">
			            </div>
			            <div class="form-group col-md-2">
			            	<select style="width:100%" class="form-control" name="dept">
				              	<option>Department</option>
								<option>Computer Science and Engneering</option>
								<option>Mechanical Engneering</option>
								<option>Electronics Engneering</option>
								<option>Electronics and Telecommunication Engneering</option>
								<option>Information Technology</option>
	                		</select>
			            </div>
			            <div class="form-group col-md-2">
			              <input type="text"  style="width:100%" class="form-control" name="company" placeholder="Company">
			            </div>
			            <div class="form-group col-md-2">
			              <select class="form-control " name="passout">
			              	<option>Passout Year</option>
								<?php 
								   for($i = 1993 ; $i < date('Y') + 5; $i++){
								      echo "<option>$i</option>";
								   }
								?>
							</select>
			            </div>
			            <div class="form-group col-md-2">
			                <button class="btn btn-primary" type="submit" name="submit">Search</button>
			            </div>
			       </div>
		   </fieldset>
		</form>
		</div>
			
		<div class= "container-fluid" style="padding-left: 0%; padding-right: 11%; margin-top: 3%;">
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

			$fname = test_input(ucfirst(strtolower($_POST['fname'])));
			$lname = test_input(ucfirst(strtolower($_POST['lname'])));
			$company = test_input(ucfirst($_POST['company']));
			$dept = test_input($_POST['dept']);
			$passout = test_input($_POST['passout']);

			$sql = "SELECT id, fname, lname, email, company, dept, passout FROM alumni_info  WHERE ";
			$count = 0;
			if($fname){
				$fname = mysqli_real_escape_string($GLOBALS['conn'], $fname);
				$sql .= "fname LIKE '".$fname."%'";
				$count += 1;
			}

			if($lname){
				if($count){
					$sql .= " OR ";
				}
				$lname = mysqli_real_escape_string($GLOBALS['conn'], $lname);
				$sql .= "lname LIKE '".$lname."%'";
				$count += 1;
			}

			if($company){
				if($count){
					$sql .= " OR ";
					$condn .= ", ";
				$company = mysqli_real_escape_string($GLOBALS['conn'], $company);
				}
				$sql .= "company LIKE '".$company."%'";
				$count += 1;
			}

			if($dept && $dept != 'Department'){

				if($count){
					$sql .= " OR ";
				}
				$dept = mysqli_real_escape_string($GLOBALS['conn'], $dept);
				$sql .= "dept LIKE '".$dept."%'";
				$count += 1;
			}

			if($passout && $passout != 'Passout Year'){
				if($count){
					$sql .= " OR ";
				}

				$passout = mysqli_real_escape_string($GLOBALS['conn'], $passout);
				$sql .= "passout LIKE '".$passout."%'";
				$count += 1;
			}

			$result = mysqli_query($GLOBALS['conn'], $sql);
			
			if(mysqli_num_rows($result) > 0)
			{
				$counter = 1;
				echo '<div class="table-responsive table-hover">' ;
					echo '<table class="table">'; 
					echo '<thead class="thead-dark">';
						echo '<tr class="text-center">';
							echo ' <th scope="col">Sr.</th> ';
							echo ' <th scope="col">Name</th> ';
							echo ' <th scope="col">Department</th> ';
							echo ' <th scope="col">Company</th> ';
							echo ' <th scope="col">Passout Year</th> ';
						echo '</tr>';
					echo '</thead>';
					echo '<tbody>';
    
				while($row = mysqli_fetch_array($result))
				{
					echo '<tr class="text-center">';
						echo '<th scope="row">'.$counter.'</th>';
						echo '<th scope="row"> <a href="display.php?profile_id='.$row['id'].'" target="_blank">'.$row['fname'].' '.$row['lname'].'</th></a>';
						echo '<th scope="row">'.$row['dept'].'</th>';
						echo '<th scope="row">'.$row['company'].'</th>';
						echo '<th scope="row">'.$row['passout'].'</th>';
					echo '</tr>';
					$counter += 1;
					
				}
					echo '</table>';
				echo '</div>';
			}
			
		}

	?>

		</div>
	</div>
	



	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>
</html>