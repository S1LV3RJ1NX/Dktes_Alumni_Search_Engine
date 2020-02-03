<?php 
session_start();
ob_start();
if(!isset($_SESSION['user']) && !isset($_SESSION['admin'])){
   header("Location:login.php");
} 
?>
<html>
<head>
	<title>Alumni Info</title>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<!-- <link rel="stylesheet" type="text/css" href="css/login.css"> -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <style type="text/css">
        * { margin: 0; padding: 0; }
        body { font: 16px Helvetica, Sans-Serif; line-height: 24px; background: url(images/noise.jpg); }
        .clear { clear: both; }
        #page-wrap { width: 800px; margin: 40px auto 60px; }
        #pic { float: right; margin: -30px 0 0 0; }
        h1 { margin: 0 0 16px 0; padding: 0 0 16px 0; font-size: 42px; font-weight: bold; letter-spacing: -2px; border-bottom: 1px solid #999; }
        h2 { font-size: 20px; margin: 0 0 6px 0; position: relative; }
        h2 span { position: absolute; bottom: 0; right: 0; font-style: italic; font-family: Georgia, Serif; font-size: 16px; color: #999; font-weight: normal; }
        p { margin: 0 0 16px 0; }
        a { color: #999; text-decoration: none; border-bottom: 1px dotted #999; }
        a:hover { border-bottom-style: solid; color: black; }
        ul { margin: 0 0 32px 17px; }
        #objective { width: 500px; float: left; }
        #objective p { font-family: Georgia, Serif; font-style: italic; color: #666; }
        dt { font-style: italic; font-weight: bold; font-size: 18px; text-align: right; padding: 0 26px 0 0; width: 150px; float: left; height: 100px; border-right: 1px solid #999;  }
        dd { width: 600px; float: right; }
        dd.clear { float: none; margin: 0; height: 15px; }
     </style>

</head>
<body>
	<?php 

		

		include('ckcn.php');
		$id = $_GET['profile_id'];

		$result = mysqli_query($GLOBALS['conn'], "SELECT * FROM alumni_info WHERE id= '$id';");
		$fname = $lname = $addr = $mobile = $company = $dept = $passout = $desgn = $from_yr = $to_yr = $git = $linkedin = $website = "";
		
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

		$result = mysqli_query($GLOBALS['conn'], "SELECT * FROM work WHERE pid= '$id' Order by from_yr;");
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
		// echo "".$count;
		
		$skills = $proj = $certi = $accomp = $papers = "";
		$result = mysqli_query($GLOBALS['conn'], "SELECT * FROM skills WHERE pid= '$id';");
		while($row = mysqli_fetch_array($result))
		{
			$skills = $row['skills'];
			$proj = $row['project'];
			$certi = $row['certi'];
			$papers = $row['papers'];
			$accomp = $row['accomp'];
		} 
		

		$skills = str_replace("# ","",$skills);
		
	?>
	
		


	<div id="page-wrap">
		<?php 

			$sql = "Select img_path from profile where pid = '$id';";
			$result = mysqli_query($GLOBALS['conn'], $sql);

			if(mysqli_num_rows($result)==0)
			{
				echo '<img src="./profiles/default.jpeg" alt="No profile" class="img-thumbnail" style="width: 150px; height: 150px; margin-bottom:3%;" id="pic">';
				// echo '<br>';
			}
			else
			{
				$row = mysqli_fetch_array($result);
				echo '<img src ="'.$row['img_path'].'" alt="profile photo" class="img-thumbnail" style="width: 150px; height: 150px; margin-bottom:3%;" id="pic">';	
			}
		 ?>

    
        <div id="contact-info" class="vcard">
            <h1 class="fn"><?php echo $fname." ".$lname; ?></h1>
        
            <p>
            	<?php if($email): ?>
                <strong>Email:</strong> <a class="email" href="<?php echo "mailto:".$email; ?>"> <?php echo $email ?> </a>
                <br>
            <?php endif ?>
            	<?php if($git): ?>
                <strong>Github:</strong> <a class='email' href=<?php echo $git.' target="_blank"'; ?>><?php echo $git ?></a> <br>
                <?php endif ?>
                <?php if($linkedin): ?>
                <strong>Linkedin:</strong> <a class="email" href=<?php echo $linkedin.' target="_blank"'; ?>><?php echo $linkedin ?></a><br>
                <?php endif ?>
                <?php if($website): ?>
                Website: <a class="email" href=<?php echo $website.' target="_blank"'; ?>><?php echo $website ?></a>
                <?php endif ?>
            </p>
        </div>
                
        <div id="objective">
            <p>
                <?php echo $bio; ?>
            </p>
        </div>
        
        <div class="clear"></div>
        
        <dl>
            <dd class="clear"></dd>
            
          
            <dt><h5><b>Education</b></h5></dt>
            <dl>
            <dd>
                <strong>D.K.T.E.S Textile and Engineering Institute, Ichalkaranji </strong>
                <?php if($dept): ?>
                <p><strong>Department:</strong> <?php echo $dept ?><br />
                <?php endif ?>
                <?php if($ug_per): ?>
                   <strong>CGPA/Percentage:</strong> <?php echo $ug_per ?></p>
                  <?php endif ?>
            </dd>
            </dl>
	
            <dd>
            	<?php if($hsc): ?>
                <strong><?php echo $hsc ?></strong>		<I>(H.S.C)</I>
            	
                <?php if($hsc_per): ?>
                  <p> <strong>CGPA/Percentage:</strong> <?php echo $hsc_per ?></br>
                  <?php endif ?>
                <?php endif ?>
            </dd>

            <dd>
            	<?php if($ssc): ?>
                <strong><?php echo $ssc ?></strong>		<I>(S.S.C)</I>
            	
                <?php if($ssc_per): ?>
                   <P><strong>CGPA/Percentage:</strong> <?php echo $ssc_per ?></p>
                  <?php endif ?>
                <?php endif ?>
            </dd>

            <dd class="clear"></dd>
            <dd class="clear"></dd>
                
            <?php if($skills != '')
	            {    
		            echo '<dt><h4><b>Skills</b></h4></dt>
		            <dd>';
		            	echo $skills;
		            echo '</dd>';
		            echo '<dd class="clear"></dd> <dd class="clear"></dd>';
	             }

             ?>
            
                   
            <dt><h5><b>Experience</b></h5></dt>
            <dd>
            	<?php 
            		echo '<strong>'.$company.'</strong> <h2><span>'.$from_yr.' - '.$to_yr.'</span></h2>';
            		echo '<h2><small>'.$desgn.'</small></h2>';
            		for($j = 0; $j<$count; $j++)
            		{
            			echo "<br>";
            			echo '<strong>'.$company_work[$j].'</strong> <h2><span>'.$from_work[$j].' - '.$to_work[$j].'</span></h2>';
            			echo '<h2><small>'.$desgn_work[$j].'</small></h2>';
            		}
            		echo "<br>";
            	 ?>
            </dd>

           <?php if($proj != '') 
           	{
           		$proj = explode("# ",$proj);
				$proj = str_replace("# ","",$proj);
	            echo '<dd class="clear"></dd>';
	            echo '<dd class="clear"></dd>';

	            echo '<dt><h5><b>Projects</b></h5></dt>';
	            
	    		
	    		for($j = 1; $j<sizeof($proj); $j++)
	    		{
	    			echo '<dd><li >'.$proj[$j].'</li></dd>';
	    		}
	        	 
	            
            }
           ?>
			
			<?php if($certi != '') 
			{
				$certi = explode("# ",$certi);
				$certi = str_replace("# ","",$certi);

		
	            echo '<dd class="clear"></dd>';
	            echo '<dd class="clear"></dd>';

	            echo '<dt><h5><b>Certifications</b></h5></dt>';
	            
	    		
	    		for($j = 1; $j<sizeof($certi); $j++)
	    		{
	    			echo '<dd><li >'.$certi[$j].'</li></dd>';
	    		}
	        	 
	            
            }
           ?>

           <?php if($papers != '') 

           	{
           		$papers = explode("# ",$papers);
				$papers = str_replace("# ","",$papers);

		
	            echo '<dd class="clear"></dd>';
	            echo '<dd class="clear"></dd>';

	            echo '<dt><h55Papers</b></h5></dt>';
	            
	    		for($j = 1; $j<=sizeof($papers); $j++)
	    		{
	    			echo '<dd><li >'.$papers[$j].'</li></dd>';
	    		}
            }
           ?>

           <?php if($accomp != '') 
           {
           		$accomp = explode("# ",$accomp);
				$accomp = str_replace("# ","",$accomp);
	            echo '<dd class="clear"></dd>';
	            echo '<dd class="clear"></dd>';

	            echo '<dt><h5><b>Achievements</b></h5></dt>';
	            
	    		for($j = 1; $j<sizeof($accomp); $j++)
	    		{
	    			echo '<dd><li >'.$accomp[$j].'</li></dd>';
	    		}

            }
           ?>
        </dl>
        
        <div class="clear"></div>
    
    </div>
</body>
</html>