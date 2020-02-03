<?php 
session_start();
ob_start();
if(!isset($_SESSION['user'])){
   header("Location:login.php");
}
 ?>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<title>Profile</title>
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
	        		<a class="nav-link" href="search.php" >Search</a>
	      		</li>
	      		<li class="nav-item" >
	        		<a class="nav-link" href="logout.php" >Logout</a>
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
	

			$errMob = $errfn = $errln = $errMail = $errMob_exst = $errssc = $errhsc = $errug = $errssc_per = $errhsc_per = $errug_per = "";
			$success_flag = false;
			if(isset($_POST["submit"])) 
			{

				$valid  = true;
				
				$id = $_SESSION['user'];

			 	$fname = test_input(ucfirst(strtolower($_POST['fname'])));
			 	$lname = test_input(ucfirst(strtolower($_POST['lname'])));
			 	$addr = test_input(ucfirst(strtolower($_POST['addr'])));
			 	$email = $_POST['email'];
				$mobile = test_input($_POST['mobile']);
				$company = test_input(ucfirst($_POST['company']));
				$dept = test_input($_POST['dept']);
				$passout = test_input($_POST['passout']);
				$desgn = test_input($_POST['desgn']);
				$from_yr = test_input($_POST['from_yr']);
				$to_yr = test_input($_POST['to_yr']);
				$git = $_POST['git'];
				$linkedin = $_POST['linkedin'];
				$website = $_POST['website'];
				$bio = $_POST['bio'];


				

				// edu
				$ssc = test_input($_POST['ssc']);
				$ssc_per = test_input($_POST['ssc_per']);
				$hsc = test_input($_POST['hsc']);
				$hsc_per = test_input($_POST['hsc_per']);
				$ug = test_input($_POST['ug']);
				$ug_per =  test_input($_POST['ug_per']);

				// skills
				$skills = mysqli_real_escape_string($GLOBALS['conn'],$_POST['skills']);
				$certi =  mysqli_real_escape_string($GLOBALS['conn'],$_POST['certi']);
				$project =  mysqli_real_escape_string($GLOBALS['conn'],$_POST['project']);
				$papers =  mysqli_real_escape_string($GLOBALS['conn'],$_POST['papers']);
				$accomp =  mysqli_real_escape_string($GLOBALS['conn'],$_POST['accomp']);
			
				if(is_numeric($ssc) || preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $ssc)){
					$errssc = "Invalid School Name. Only alphabets allowed.";
					$valid = false;
				}

				if(is_numeric($hsc) || preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $hsc)){
					$errhsc = "Invalid College Name. Only alphabets allowed.";
					$valid = false;
				}

				if(is_numeric($ug) || preg_match('/[\'^£$%&*()}{@#~?><>|=_+¬-]/', $ug)){
					$errug = "Invalid College Name. Only alphabets allowed.";
					$valid = false;
				}

				if((!is_numeric($ssc_per) && strlen($ssc_per)>0) || strlen($ssc_per)>5)
				{
					$errssc_per = "Invalid %";
					$valid = false;
				}

				if((!is_numeric($hsc_per) && strlen($hsc_per)>0) || strlen($hsc_per)>5)
				{
					$errhsc_per = "Invalid %";
					$valid = false;
				}

				if((!is_numeric($ug_per) && strlen($ug_per)>0 ) || strlen($ug_per)>5) 
				{
					$errug_per = "Invalid %";
					$valid = false;
				}

				// $valid=true;
				// echo "".strlen($mobile)."<br>";
				if(empty($company)){
					$company = 'Unemployed';
				}

				if(!is_numeric($mobile) || strlen($mobile)!=10)
				{
					$errMob = "Invalid mobile no";
					$valid = false;
				}

				

				if(is_numeric($fname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $fname)){
					$errfn = "Invalid First Name. Only alphabets allowed.";
					$valid = false;
				}

				if(!checkPresentSearch($email, 'email', $id)){
					$valid = false;
					$errMail = "Email already exists"; 
				}

				if(!checkPresentSearch($mobile, 'mobile', $id)){
					$valid = false;
					$errMob_exst = "Mobile no already exists"; 
				}

				if(is_numeric($lname) || preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', $lname)){
					$errln = "Invalid Last Name. Only alphabets allowed.";
					$valid = false;
				}

				function GetImageExtension($imagetype)
			   	{
			       if(empty($imagetype)) return false;
			       switch($imagetype)
			       {
			           case 'image/jpeg': return '.jpg';
			           case 'image/jpg': return '.jpg';
			           default: return false;
			       }
			    }

			    

				if($valid) 
				{
					
					$success_flag = true;
					$sql = "Update alumni_info SET fname = '$fname' , lname = '$lname', addr = '$addr', mobile = '$mobile', company = '$company', desgn = '$desgn', dept = '$dept', passout = '$passout' , email = '$email' , from_yr = '$from_yr', to_yr = '$to_yr', git = '$git', linkedin = '$linkedin', website = '$website', bio = '$bio' where id = '$id' ;";
					// echo "".$_FILES["dp"]["name"]."<br>";
					
					if (!empty($_FILES["dp"]["name"])) 
					{

						$file_name=$_FILES["dp"]["name"];
						$temp_name=$_FILES["dp"]["tmp_name"];
						$imgtype=$_FILES["dp"]["type"];
						$ext= GetImageExtension($imgtype);
						$imagename = $id.$ext;
						// 
						$target_path = "./profiles/".$imagename;
						// echo "".$target_path."<br>";
						uploadImage($temp_name,$target_path, $id);
					
					}

					if(!mysqli_query($GLOBALS['conn'], $sql))
					{
						$success_flag = false;
						// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
						ob_start();
						header('Location: 404.php');
						ob_end_flush();
						die();
					}
					
					$sql = "Select pid from education where pid = '$id';";
					$result = mysqli_query($GLOBALS['conn'], $sql);
					if(mysqli_num_rows($result)==0)
					{
						// echo "In insert<br>";
						$query = "insert into education (pid, ssc, ssc_per, hsc, hsc_per, ug, ug_per) values ('$id', '$ssc','$ssc_per', '$hsc', '$hsc_per', '$ug', '$ug_per');";
					}
					else
					{
						$query = "Update education set ssc='$ssc', hsc='$hsc', ug='$ug', ssc_per='$ssc_per', hsc_per='$hsc_per', ug_per='$ug_per' where pid = '$id'";
					}

					if(!mysqli_query($GLOBALS['conn'], $query))
					{
						$success_flag = false;
						// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
						ob_start();
						header('Location: 404.php');
						ob_end_flush();
						die();
					}

					if(isset($_POST['desgn_work']))
					{
						//work
						$desgn_work = $_POST['desgn_work'];
						$company_work = $_POST['company_work'];
						$from_work = $_POST['from_work'];
						$to_work = $_POST['to_work'];

						$sql = "Select pid from work where pid = '$id'";
						$result = mysqli_query($GLOBALS['conn'], $sql);
						// echo " rows:- ".mysqli_num_rows($result)."<br>";
						if(mysqli_num_rows($result)!=0)
						{
							$query = "delete from work where pid = '$id';";
							// echo "In query...<br>";
							if(!mysqli_query($GLOBALS['conn'], $query))
							{
								$success_flag = false;
								echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
								// ob_start();
								// header('Location: 404.php');
								// ob_end_flush();
								// die();
							}
						}
						for($i = 0; $i<count($desgn_work); $i++)
						{
							// echo " ".$i." work: ".$desgn_work[$i]." company: ".$company_work[$i]." <br>";
							// echo "In insert<br>";
							$query = "insert into work (pid, company_name, desgn, from_yr, to_yr) values ('$id', '$company_work[$i]','$desgn_work[$i]', '$from_work[$i]', '$to_work[$i]');";

							if(!mysqli_query($GLOBALS['conn'], $query))
							{
								$success_flag = false;
								// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
								ob_start();
								header('Location: 404.php');
								ob_end_flush();
								die();
							}
						}					
					}
					else{
						// Delete all records
						$sql = "Select pid from work where pid = '$id'";
						$result = mysqli_query($GLOBALS['conn'], $sql);
						// echo " rows:- ".mysqli_num_rows($result)."<br>";
						if(mysqli_num_rows($result)!=0)
						{
							$query = "delete from work where pid = '$id';";
							// echo "In query...<br>";
							if(!mysqli_query($GLOBALS['conn'], $query))
							{
								$success_flag = false;
								// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
								ob_start();
								header('Location: 404.php');
								ob_end_flush();
								die();
							}
						}						
					}

					if (!save_skills($id, $skills, $project, $certi, $papers, $accomp))
					{
						$success_flag = false;
					}
					

					if($success_flag)
					{
						echo '<div class="alert alert-success" role="alert">Updated Profile</div>';
					}
				}
				if(!$success_flag)
				{
					echo '<div class="alert alert-danger" role="alert">Error in form!! Check Again</div>';
				}
			}			
		?>
		
		<?php 
			$id = $_SESSION['user'];
			$fname = $lname = $addr = $mobile = $company = $dept = $passout = $desgn = $from_yr = $to_yr = $git = $linkedin = $website = $bio = "";
			
			$result = mysqli_query($GLOBALS['conn'], "SELECT * FROM alumni_info WHERE id= '$id';");

			while($row = mysqli_fetch_array($result))
			{
				$fname = $row['fname'];
			 	$lname =  $row['lname'];
			 	$addr =  $row['addr'];
				$email = $row['email'];			
				$mobile =  $row['mobile'];
				$company =  $row['company'];
				$dept =  $row['dept'];
				$passout =  $row['passout'];
				$desgn = $row['desgn'];
				$from_yr = $row['from_yr'];
				$to_yr = $row['to_yr'];
				$git = $row['git'];
				$linkedin = $row['linkedin'];
				$website = $row['website'];
				$bio = $row['bio'];
				// echo "".$bio;
			}

			$ssc = $ssc_per = $hsc = $hsc_per = $ug = $ug_per = "";

			$result = mysqli_query($GLOBALS['conn'], "SELECT * FROM education WHERE pid= '$id';");
			while($row = mysqli_fetch_array($result))
			{
				$ssc = $row['ssc'];
				$hsc = $row['hsc'];
				$ug = $row['ug'];
				$hsc_per = $row['hsc_per'];
				$ssc_per = $row['ssc_per'];
				$ug_per = $row['ug_per'];
			}

			$desgn_work = $company_work = $from_work = $to_work = array(); 

			$result = mysqli_query($GLOBALS['conn'], "SELECT * FROM work WHERE pid= '$id';");
			$count = 0;
			while($row = mysqli_fetch_array($result))
			{
				
				$desgn_work[$count] = $row['desgn'];
				$company_work[$count] = $row['company_name'];
				$from_work[$count] = $row['from_yr'];
				$to_work[$count] = $row['to_yr'];
				// echo " ".$desgn_work."<br>";
				$count+=1;
			
			}

			$skills = $project = $certi = $accomp = $papers = "";
			$result = mysqli_query($GLOBALS['conn'], "SELECT * FROM skills WHERE pid= '$id';");
			while($row = mysqli_fetch_array($result))
			{
				$skills = $row['skills'];
				$proj = $row['project'];
				$certi = $row['certi'];
				$papers = $row['papers'];
				$accomp = $row['accomp'];
			}


		 ?>
		<h2 style="text-align: center; padding-bottom: 1%">Profile Update Form</h2>

		<?php 
			$sql = "Select img_path from profile where pid = '$id';";
			$result = mysqli_query($GLOBALS['conn'], $sql);

			if(mysqli_num_rows($result)==0)
			{
				echo '<img src="./profiles/default.jpeg" alt="No profile" class="img-thumbnail" style="margin-bottom:3%;">';
				// echo '<br>';
			}
			else
			{
				$row = mysqli_fetch_array($result);
				echo '<img src ="'.$row['img_path'].'" alt="No profile" class="img-thumbnail" style="width: 150px; height: 150px; margin-bottom:3%;">';	
			}

		 ?>
		<form role="form" method="post" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

		<div>
			<fieldset>
				<legend> Personal Information</legend>
				<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">First Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="fname" value = "<?php echo $fname; ?>" >
					<?php echo $errfn; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Last Name</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="lname"  value = "<?php echo $lname; ?>" >		
					<?php echo $errln; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Address</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="addr" value = "<?php echo $addr; ?>" >	
				</div>
			</div>
			
			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Email</label>
				<div class="col-sm-10">
					<input type="email" class="form-control col-sm-8" name="email" value= "<?php echo $email; ?>" >
					<?php echo $errMail; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Mobile</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="mobile" value = "<?php echo $mobile; ?>" >
					<?php echo $errMob; ?>
					<?php echo $errMob_exst; ?>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Github</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="git" value= "<?php echo $git; ?>" >
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Linkedin</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="linkedin" value= "<?php echo $linkedin; ?>" >
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Personal Website</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="website" value= "<?php echo $website; ?>" >
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">About You</label>
				<div class="col-sm-10">
					<textarea class="form-control col-sm-8" name="bio" rows="5"><?php echo $bio; ?> </textarea>
				</div>
			</div>


			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Profile Image</label>
				<div class="col-sm-10">
					<input type="file" class="form-control col-sm-8" name="dp">
					(Upload only jpg/jpeg image <5MB)<br>(Pic changes might take some time to reflect)
				</div>
			</div>

			</fieldset>
		
			<fieldset >
				<legend style="padding-top: 2%">Educational Information</legend>
				(Enter only upto 2 decimal places) 
				<br>
				
			<div class="form-group row" style="padding-top: 2%">
				<label for="inputUser" class="col-sm-2 col-form-label" >UG College</label>
				<input type="text" name="ug" class="form-control col-sm-6" value = "<?php echo $ug; ?>" style="margin-left: 1% ; margin-right:2%;">
				<!-- <div class="col-sm-6"> -->
				<label for="inputUser" class="col-sm-2 col-form-label">UG percentage</label>
				<input type="text" name="ug_per" class="form-control col-sm-1" style="margin-left: -3% ;" value = "<?php echo $ug_per; ?>" >
				<?php echo $errug; ?>
				<?php echo "    " ?>
				<?php echo $errug_per; ?>
				<!-- </div> -->
			</div>

			<div class="form-group row">
				<label for="dept" class="col-sm-2 col-form-label" style="margin-right:1%;"> Department: </label>
				<!-- <div class="col-sm-10" > -->
	                 <select style="width:100%" class="form-control col-sm-6" name="dept">
	                 	<option selected="selected"><?php echo $dept;?></option>
	                 	<?php 
	                 		if($dept != 'Computer Science and Engneering')
	                 		{
	                 			echo '<option>Computer Science and Engneering</option>';
	                 		}

	                 		if($dept != 'Mechanical Engneering')
	                 		{
	                 			echo '<option>Mechanical Engneering</option>';
	                 		}

	                 		if($dept != 'Electronics Engneering')
	                 		{
	                 			echo '<option>Electronics Engneering</option>';
	                 		}

	                 		if($dept != 'Electronics and Telecommunication Engneering')
	                 		{
	                 			echo '<option>Electronics and Telecommunication Engneering</option>';
	                 		}

	                 		if($dept != 'Information Technology')
	                 		{
	                 			echo '<option>Information Technology</option>';
	                 		}

	                 	 ?>
	                </select>

				<label for="inputUser" class="col-sm-2 col-form-label" style="margin-left:2%;">Passout Year</label>
				<!-- <div class="col-sm-10"> -->
					<select class="form-control col-sm-1" name="passout" style="margin-left:-3%;">
						<option selected="selected"><?php echo $passout;?></option>
						<?php 
						   for($i = 1993 ; $i < date('Y') + 5; $i++){
						   		if($i != $passout)
						   		{
						   			echo "<option>$i</option>";
						   		}
						      
						   }
						?>
					</select>
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label" >HSC/Diploma</label>
				<input type="text" name="hsc" class="form-control col-sm-6" value = "<?php echo $hsc; ?>" style="margin-left: 1% ; margin-right:2%;">
				
				<!-- <div class="col-sm-6"> -->
				<label for="inputUser" class="col-sm-2 col-form-label">Percentage</label>
				<input type="text" name="hsc_per" class="form-control col-sm-1" value = "<?php echo $hsc_per; ?>" style="margin-left: -3% ;">
				<?php echo $errhsc; ?> 
				<?php echo "    " ?>
				<?php echo $errhsc_per; ?>
				<!-- </div> -->
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label" >SSC School</label>
				<input type="text" name="ssc" class="form-control col-sm-6" value = "<?php echo $ssc; ?>" style="margin-left: 1% ; margin-right:2%;">
				<!-- <div class="col-sm-6"> -->
				<label for="inputUser" class="col-sm-2 col-form-label">Percentage</label>
				<input type="text" name="ssc_per" class="form-control col-sm-1" value = "<?php echo $ssc_per; ?>" style="margin-left: -3% ;">
				<?php echo $errssc; ?>
				<?php echo "    " ?>
				<?php echo $errssc_per; ?>
				<!-- </div> -->
			</div>
			</fieldset>

			<fieldset >
				<legend style="padding-top: 2%">Skills and Certifications </legend>


				<div class="form-group row">
					<label for="inputUser" class="col-sm-2 col-form-label">Skills<br> <small>(Separate skills by comma)</small></label>
					<div class="col-sm-10">
						<textarea class="form-control col-sm-10" name="skills" rows="3"><?php if($skills): echo $skills; endif;?> </textarea>
						
					</div>
				</div>
				
				<div>
					<small>(From here on hash (#) with space is added automatically after u enter new line for each entry. If not add it yourself "BETA" phase else put cursor on new line and start typing, when you press enter "#" will be added .)</small>
					<br>
					<br>
				</div>
				<div class="form-group row">
					<label for="inputUser" class="col-sm-2 col-form-label ">Projects <br><small>(Only short project title) </small><br><small>(Enter each new project on a new line)</small></label>

					<div class="col-sm-10">
						<textarea class="todolist form-control col-sm-10" name="project" rows="6" ><?php if($proj): echo $proj; endif;?> </textarea>
						
					</div>
				</div>

				<div class="form-group row">
					<label for="inputUser" class="col-sm-2 col-form-label">Certifications <br><small>(Enter each new certificate on a new line)</small></label>
					<div class="col-sm-10">
						<textarea class="todolist form-control col-sm-10" name="certi" rows="6"><?php if($certi): echo $certi; endif;?> </textarea>
						
					</div>
				</div>

				<div class="form-group row">
					<label for="inputUser" class="col-sm-2 col-form-label">Papers Published <br><small>(Enter each new paper on a new line)</small></label>
					<div class="col-sm-10">
						<textarea class="todolist form-control col-sm-10" name="papers" rows="6"><?php if($papers): echo $papers; endif;?> </textarea>
						
					</div>
				</div>

				<div class="form-group row">
					<label for="inputUser" class="col-sm-2 col-form-label">Other Accomplishments <br><small>(Enter each new accomplishment on a new line)</small></label>
					<div class="col-sm-10">
						<textarea class="todolist form-control col-sm-10" name="accomp" rows="6"><?php if($accomp): echo $accomp; endif;?> </textarea>
						
					</div>
				</div>



			</fieldset>
			<fieldset>
				<legend style="padding-top: 2%">Work Experience <small>(In reverse Chronological Order)</small></legend>

				<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Curr. Company</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-8" name="company" value = "<?php echo $company; ?>" >
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label" >Designation</label>
				<input type="text" name="desgn" class="form-control col-sm-4" value="<?php echo $desgn; ?>" style="margin-left: 1% ; margin-right:2%;">
				
				<!-- <div class="col-sm-6"> -->
				<label for="inputUser" class="col-sm-2 col-form-label" style="margin-left: -1%">From</label>
				<select class="form-control col-sm-1" name="from_yr" style="margin-left: -10%" required>
					<option selected="selected"><?php echo $from_yr;?></option>
					<?php 

					   for($i = 1993 ; $i < date('Y') + 5; $i++){
					   		if($i != $from_yr)
					   		{
					   			echo "<option>$i</option>";		
					   		}
					      
					   }
					?>
				</select>

				<label for="inputUser" class="col-sm-2 col-form-label">To</label>
				<select class="form-control col-sm-2" name="to_yr" style="margin-left: -12%"required>
					<option selected="selected"><?php echo $to_yr;?></option>
					<?php 
					   for($i = 1993 ; $i < date('Y') + 5; $i++){
					      if($i != $to_yr)
					   		{
					   			echo "<option>$i</option>";		
					   		}
					   }
					?>
				</select>
			</div>

			
				<?php 

					for($j = 0; $j<count($desgn_work); $j++)
					{
						if (strlen($desgn_work[$j])) : ?>
						<div class="container0" id="del">
							<div class="form-group row ">
									<label for="inputUser" class="col-sm-2 col-form-label">Company</label>
									<div class="col-sm-10">
										<input type="text" class="form-control col-sm-8" name="company_work[]" value = "<?php echo $company_work[$j]; ?>" required>
									</div>
							</div>
								
							<div class="form-group row">
								<label for="inputUser" class="col-sm-2 col-form-label" >Designation</label>
								<input type="text" name="desgn_work[]" class="form-control col-sm-4" value = "<?php echo $desgn_work[$j]; ?>" style="margin-left: 1% ; margin-right:2%;" required>
								
								<!-- <div class="col-sm-6"> -->
								<label for="inputUser" class="col-sm-2 col-form-label" style="margin-left: -1%">From</label>
								<select class="form-control col-sm-1" name="from_work[]" style="margin-left: -10%" required>
									<?php 
										if(strlen($from_work[$j]))
										{
											echo '<option selected="selected">'.$from_work[$j].'</option>';
											for($i = 1993 ; $i < date('Y') + 5; $i++)
											{
										   		if($i != $from_work[$j])
										   		{
										   			echo "<option>$i</option>";		
										   		}
									      
									  		}
										}
										else
										{
											for($i = 1993 ; $i < date('Y') + 5; $i++)
											{
									      		echo "<option>$i</option>";
									   		}
										} 
									   
									?>
								</select>

								<label for="inputUser" class="col-sm-2 col-form-label">To</label>
								<select class="form-control col-sm-2" name="to_work[]" style="margin-left: -12%"required>
									<?php 
										if(strlen($to_work[$j]))
										{
											echo '<option selected="selected">'.$to_work[$j].'</option>';
											for($i = 1993 ; $i < date('Y') + 5; $i++){
											    if($i != $to_work[$j][$j])	
										   		{
										   			echo "<option>$i</option>";		
										   		}
										   }
										}
										else 
										{
											for($i = 1993 ; $i < date('Y') + 5; $i++)
											{
												echo "<option>$i</option>";
											}
									
										}
									   
									?>
								</select>
							</div>
								<a href="#" class="delete1">Delete</a>

						</div>
				<?php 
					endif; 
					}
				 ?>
			<div>
				<div class="container1" id = "app_here">
				</div>
			    <button class="add_form_field">Add New Work Experience &nbsp; 
			      <span style="font-size:16px; font-weight:bold;">+ </span>
			    </button>
			</div>
			
			</fieldset>

			<div class="form-group row" >
				<div class="offset-sm-2 col-sm-10"  >
					<input type="submit" value="Update" style="margin-top: 3%; margin-left: 25%; display: block;" name="submit" class="btn btn-primary"/>
				</div>
			</div>

		</div>
	</form>



	
	
	 <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	
	<script >
		

		$(document).ready(function() {

		    var wrapper = $(".container1");
		    var add_button = $(".add_form_field");

		    var x = 1;
		    var append;
		    $(add_button).click(function(e) {
		        e.preventDefault();
		        x++;
		        $("#app_here").append(`<div class="hide" id="template">
			<div>
				<div class="form-group row ">
					<label for="inputUser" class="col-sm-2 col-form-label">Company</label>
					<div class="col-sm-10">
						<input type="text" class="form-control col-sm-8" name="company_work[]" required>
					</div>
				</div>
				
				<div class="form-group row">
					<label for="inputUser" class="col-sm-2 col-form-label" >Designation</label>
					<input type="text" name="desgn_work[]" class="form-control col-sm-4" style="margin-left: 1% ; margin-right:2%;" required>
					
					<!-- <div class="col-sm-6"> -->
					<label for="inputUser" class="col-sm-2 col-form-label" style="margin-left: -1%">From</label>
					<select class="form-control col-sm-1" name="from_work[]" style="margin-left: -10%" required>
						<?php 

								for($i = 1993 ; $i < date('Y') + 5; $i++)
								{
						      		echo "<option>$i</option>";
						   		}
						?>
					</select>

					<label for="inputUser" class="col-sm-2 col-form-label">To</label>
					<select class="form-control col-sm-2" name="to_work[]" style="margin-left: -12%"required>
						<?php 
								for($i = 1993 ; $i < date('Y') + 5; $i++)
								{
									echo "<option>$i</option>";
								}
						?>
					</select>
				</div>
				<a href="#" class="delete">Delete</a>
			</div>
		</div>
	`)});

	    $(wrapper).on("click", ".delete", function(e) {
	        e.preventDefault();
	        $(this).parent('div').remove();
	        x--;
	    });


		var del = $(".container0");
		// var del = $("#del");
		$(del).on("click", ".delete1", function(e) {
	        e.preventDefault();
	        $(this).parent('div').remove();
	        $j--;
	    });

	 
		var linestart = function(st, txt) {
			var ls = txt.split("\n");
			var i = ls.length-1;
			ls[i] = st+ls[i];
			return ls.join("\n");
		};


		$(".todolist").on('keydown', function(e) {
			var t = $(this);
			if(e.which == 13) {
				t.val(linestart('# ', t.val() ) + "\n");
			return false;
			}  
		});
	});


	</script>
</body>
</html>
