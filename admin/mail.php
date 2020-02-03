<?php 
session_start();
ob_start();
if(!isset($_SESSION['admin'])){
   header("Location: admin_login.php");
}
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
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
<?php 

	

	include('../ckcn.php');
	if(isset($_POST["sendmail"]))
	{
		if(!empty($_POST['mailid'])){
			$_SESSION['mail_ids'] = $_POST['mailid'];
		}
	}

	if(isset($_POST["submit"]))
	{

		$subject = $_POST['subject'];
		$body = $_POST['body'];
		if(strlen($subject)>0  && strlen($body)>0)
		{
			$flag = true;
			
            require $_SERVER['DOCUMENT_ROOT'] . '/mail/Exception.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/mail/PHPMailer.php';
            require $_SERVER['DOCUMENT_ROOT'] . '/mail/SMTP.php';

			$mail = new PHPMailer;  
			$mail->setFrom($GLOBALS['ini']['mail'], 'DKTES Alumni');
			$mail->Subject = $subject;
			$mail->Body = $body;
			$mail->IsSMTP();
			$mail->SMTPDebug = 0; // 0 = off (for production use) - 1 = client messages - 2 = client and server messages
			$mail->SMTPSecure = 'tls';
			$mail->Host = 'smtp.gmail.com';
			$mail->SMTPAuth = true;
			$mail->Port = 587;
			// $mail->IsHTML(true); 
			$mail->SMTPKeepAlive = true;
			//Set your existing gmail address as user name
			$mail->Username = $GLOBALS['ini']['mail'];
			//Set the password of your gmail address here
			$mail->Password = $GLOBALS['ini']['mail_pass'];

			// loop to retrieve checked values
			foreach($_SESSION['mail_ids'] as $selected){
				$mail->ClearAddresses();
				$mail->addAddress($selected);
				 
	        }

	        if(!$mail->send()) {
					// echo 'Email error: ' . $mail->ErrorInfo;
					$flag = false;			
			}
			$mail->ClearAllRecipients();
			$mail->SmtpClose();
	        if($flag)
	        {
	        	$msg = "Mail(s) sent successfully.";
	        }
	        else
	        {
	        	$err = 'Some error occured'.$mail->ErrorInfo;
	        }

		}		
	}

	if(isset($_POST["back"]))
	{
		if(isset($_SESSION['mail_ids'])){
		  unset($_SESSION["mail_ids"]);
		}
		header("Location: admin_search.php");
	}

 ?>
	<div class="container" style="padding-top: 3%"> 
		<?php 
			if($msg)
			{
				echo '<div class="alert alert-success" role="alert">'.$msg.'</div>';
				$msg = "";
			}

			if($err)
			{
				echo '<div class="alert alert-danger" role="alert">'.$err.'</div>';
				$err = "";
			}

		?>
		<h2 style="text-align: center; padding-bottom: 1%">Mail Form</h2>
		<form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label">Subject</label>
				<div class="col-sm-10">
					<input type="text" class="form-control col-sm-10" name="subject">
				</div>
			</div>

			<div class="form-group row">
				<label for="inputUser" class="col-sm-2 col-form-label ">Body </label>

					<div class="col-sm-10">
						<!-- Do no move the text it appeares similar in body -->
						<textarea class="todolist form-control col-sm-10" name="body" rows="15" >
Dear Alumni,




Alumni Association,
Dattajirao Kadam Technical Education Society's, 
Textile and Engineering Institute, 
Ichalkaranji.
						</textarea>		
				</div>
			</div>

			<div class="form-group row" >
				<div class="offset-sm-2 col-sm-10"  >
					<button class="btn btn-primary" type="submit" name="submit" style="margin-top: 1%; margin-left: 25%; display: inline-block;">Send Mail</button>

					<button class="btn btn-primary" type="submit" name="back" style="margin-top: 1%; margin-left: 10%; display: inline-block;">Back</button>
				</div>
			</div>
		</form>
	</div>
