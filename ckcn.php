<?php 
ob_start();
	
	# PHP mailer must be installed to access mail services
	use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
	function redirect($url) {
		ob_start();
		header('Location: '.$url);
		ob_end_flush();
		die();
	}
	
	$GLOBALS['ini'] = parse_ini_file("app.ini.php");

	$servername = $GLOBALS['ini']['servername'];
	$username = $GLOBALS['ini']['username'];
	$password = $GLOBALS['ini']['password'];
	$dbname = $GLOBALS['ini']['dbname'];

	$GLOBALS['conn'] = mysqli_connect($servername, $username, $password, $dbname);

	if (!$GLOBALS['conn']) {
		redirect('404.php');
	}

	function dbStore($fname, $lname, $addr, $email, $password,  $dept, $passout,  $mobile,  $company, $desgn, $from_yr, $to_yr, $id)
	{
		// echo "".$fname." ".$lname." ".strlen($addr)." ".$dept." pass".$passout."<br>";
		$sql = "Insert into alumni_info (fname, lname, addr, email, password, dept, passout, mobile, company, desgn, from_yr, to_yr, id) VALUES ('$fname', '$lname', '$addr', '$email', '$password',  '$dept', '$passout', '$mobile', '$company', '$desgn', '$from_yr', '$to_yr','$id');";

		if(!mysqli_query($GLOBALS['conn'], $sql))
		{
			// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
			ob_start();
			header('Location: 404.php');
			ob_end_flush();
			die();
		}
	}

	function checkPresent($value, $st) {
		$sql = "Select id from alumni_info where $st = '$value';";

		$result = mysqli_query($GLOBALS['conn'], $sql);
		// $row = mysqli_fetch_array($result);
		$flag = false;

		if (mysqli_num_rows($result) > 0 )  
		{
				$flag = true;
		}
		return $flag;
	}

	function checkPresentSearch($value, $st, $id) {
		$sql = "Select id from alumni_info where $st = '$value';";

		$result = mysqli_query($GLOBALS['conn'], $sql);
		$row = mysqli_fetch_array($result);
		$flag = true;
		
		if (mysqli_num_rows($result) > 0 )  
		{
			
			if($row['id'] == $id)
			{
				$flag = true;
			}
			else
			{
				// echo "Converting...<br>";
				$flag = false;
			}
		}
		
		// echo " id: ".$id." row: ".$row['id']." st: ".$st."<br>";
		return $flag;
	}


	function checkLogin($email, $pass, $valid)
	{

		$sql = "Select password from alumni_info where email = '$email';";

		$result = mysqli_query($GLOBALS['conn'], $sql);
		$row = mysqli_fetch_array($result);

		if (mysqli_num_rows($result) == 0 || !password_verify($pass, $row['password']))  
		{
				$valid = false;
		}
		return $valid;
	}


	function checkLoginAdmin($email, $pass, $valid)
	{

		$sql = "Select password from admin where email = '$email';";

		$result = mysqli_query($GLOBALS['conn'], $sql);
		$row = mysqli_fetch_array($result);

		if (mysqli_num_rows($result) == 0 || !password_verify($pass, $row['password']))  
		{
				$valid = false;
		}
		return $valid;
	}

	function uploadImage($temp_name, $target_path, $id)
	{
		$sql = "Select pid from profile where pid = '$id';";
		$result = mysqli_query($GLOBALS['conn'], $sql);
		// $row = mysqli_fetch_array($result);
		$query = "";
		if(mysqli_num_rows($result)==0)
		{
			if(move_uploaded_file($temp_name, $target_path))
			{
				// echo "In insert <br>";
				$query = "Insert into profile (pid, img_path) VALUES ('$id','$target_path')";
			}

		}
		else
		{
			unlink($target_path);
			if(move_uploaded_file($temp_name, $target_path))
			{
				// echo "In update <br>";
				$query = "Update profile SET img_path = '$target_path' WHERE pid = '$id';";

			}

		}
		// echo "Exe<br>";
		if(!mysqli_query($GLOBALS['conn'], $query))
		{
			// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
			ob_start();
			header('Location: 404.php');
			ob_end_flush();
			die();
		}

	}

	function save_skills($id, $skills, $project, $certi, $papers, $accomp)
	{
		$flag = true;
		$sql = "Select pid from skills where pid = '$id';";
		$result = mysqli_query($GLOBALS['conn'], $sql);

		if ((strlen(trim($skills)) != strlen($skills)) && (strlen(trim($skills)) == 0))
		{
			$skills = "";
		}

		if ((strlen(trim($project)) != strlen($project)) && (strlen(trim($project)) == 0))
		{
			$project = "";
		}
		if ((strlen(trim($certi)) != strlen($certi)) && (strlen(trim($certi)) == 0))
		{
			$certi = "";
		}
		if ((strlen(trim($papers)) != strlen($papers)) && (strlen(trim($papers)) == 0))
		{
			$papers = "";
		}
		if ((strlen(trim($accomp)) != strlen($accomp)) && (strlen(trim($accomp)) == 0))
		{
			$accomp = "";
		}

		if(mysqli_num_rows($result)==0)
		{

			$sql = "Insert into skills VALUES ('$id','$skills','$project','$certi','$papers','$accomp')";
		
			if(!mysqli_query($GLOBALS['conn'], $sql))
			{
				$flag = false;
				// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
				ob_start();
				header('Location: 404.php');
				ob_end_flush();
				die();
			}
			return $flag;
		}
		else
		{
			$sql = "update skills set  skills = '$skills', project = '$project', certi = '$certi', papers = '$papers', accomp = '$accomp' where pid = '$id';";
		
			if(!mysqli_query($GLOBALS['conn'], $sql))
			{
				$flag = false;
				// echo "Error: ".$sql."<br>".mysqli_error($GLOBALS['conn']);
				ob_start();
				header('Location: 404.php');
				ob_end_flush();
				die();
			}
			return $flag;
		}
		
	}

	
	

	function password_reset($email, $token)
	{
		


        require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
        require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

		$mail = new PHPMailer;
		$site = "http://localhost:8000";

		$url = $site."/new_password.php?token=".urlencode($token);


		$mail->setFrom('cse@dktes.com', 'DKTES Alumni');
		$mail->addAddress($email);
		$mail->Subject = 'Password reset for alumni portal';

		// Message
		$message = '<p>We recieved a password reset request. If you did not make this request, you can ignore this email</p>';
		$message .= '<p>Click on below link to reset password:</p><p>';
		$message .= sprintf('<a href="%s">%s</a></p>', $url, "Password-Reset");
		$message .= '</p><p>Thanks!</p>';



		$mail->Body = $message;
		$mail->IsHTML(true); 
		$mail->IsSMTP();
		$mail->SMTPSecure = 'tls';
		$mail->Host = 'smtp.gmail.com';
		$mail->SMTPAuth = true;
		$mail->Port = 587;
        $mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
		//Set your existing gmail address as user name
		$mail->Username = $GLOBALS['ini']['mail'];

		//Set the password of your gmail address here
		$mail->Password = $GLOBALS['ini']['mail_pass'];
		if(!$mail->send()) {
			// echo ' '.$ini['mail'].'<br>';
// 			echo 'Email error: ' . $mail->ErrorInfo;
			ob_start();
			header('Location: 404.php');
			ob_end_flush();
			die();
			return false;
		} 
		else
		{
			$success_msg = "One time link password-reset link sent to your email";
			header("location:password_reset.php?success_msg=".urlencode($success_msg));

		}

		return true;
	}
	// mysqli_close($conn);
 ?>