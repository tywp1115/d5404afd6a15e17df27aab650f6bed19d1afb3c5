<?php
	include 'php/click.php';
	
    $email_to1 = "me1@jatna.com";
    $email_to2 = "me2@jatna.com";
    $email_subject = "Add Cause: ";
    $email_message = "";
	$headers = "From: add@jatna.com";
		
	$cont = true;
	
	$ipaddress = getenv(REMOTE_ADDR);
	$ip = (String)$ipaddress;
     
    function died($error) 
	{
		echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html>
				<head>
					<title>Jatna - Add</title>
					<link href="css/d/classic.css" rel="stylesheet" type="text/css">
					<link href="css/d/style.css" rel="stylesheet" type="text/css">
					<link rel="SHORTCUT ICON" href="images/favicon.ico">
					<style type="text/css">
						#back
						{
							border-width: 1px;
							border-style: solid;
							border-color: #c4c4c4;
							width: 140px;
							margin-left: 280px;
							align: center;
						}
						
						#back:hover
						{
							border-color: #5f5f5f;
						}
					</style>
				</head>
				<body>
					<div id="content">
						<a href="/"><img src="images/logosmall.png" id="logo" alt="Jatna"/></a>
						<p>We are very sorry, but there were error(s) found with the form you submitted. 
						<br/>
						<br/>
						'.$error.'<p>Please fix these errors.</p>
						<form>
						<input type="button" value="Back to Add" id="back" onClick="history.go(-1);return true;">
						</form>
						<br/>
						<div id="address">
							Jatna
							<br/>
							info@jatna.com
							<br/>
							<br/>
							<a href="about.php">About</a> &#8226; <a href="faq.php">FAQ</a> &#8226; <a href="contact.php">Contact</a>
							<br/>
							<span id="motto">Fundraising Made Simple</span>
						</div>
					</div>
				</body>
			</html>';
        die();
    }

    if(!isset($_POST['cause']) ||
        !isset($_POST['url']) ||
        !isset($_POST['email']) ||
        !isset($_POST['phone']) ||
        !isset($_POST['name'])) 
	{
        died('We are sorry, but there appears to be a problem with the form you submitted.');      
    }
     
    $cause = $_POST['cause'];
    $url = $_POST['url'];
    $email_user = $_POST['email'];
    $phone = $_POST['phone'];
    $name = $_POST['name'];
	$nat = $_POST['nat'];
	$cat = $_POST['cat'];
	
	$abrv = $cause;
	$abrv = str_replace('"',"",$cause);
	$abrv = str_replace("'","",$abrv);
	$abrv = str_replace("!","",$abrv);
	$abrv = str_replace("-","",$abrv);
	$abrv = str_replace("+","",$abrv);
	$abrv = str_replace("_","",$abrv);
	$abrv = str_replace("=","",$abrv);
	$abrv = str_replace("(","",$abrv);
	$abrv = str_replace(")","",$abrv);
	$abrv = str_replace("&","",$abrv);
	$abrv = str_replace("^","",$abrv);
	$abrv = str_replace("%","",$abrv);
	$abrv = str_replace("$","",$abrv);
	$abrv = str_replace("#","",$abrv);
	$abrv = str_replace("@","",$abrv);
	$abrv = str_replace("~","",$abrv);
	$abrv = str_replace("{","",$abrv);
	$abrv = str_replace("}","",$abrv);
	$abrv = str_replace("[","",$abrv);
	$abrv = str_replace("]","",$abrv);
	$abrv = str_replace("|","",$abrv);
	$abrv = str_replace("/","",$abrv);
	$abrv = str_replace("?","",$abrv);
	$abrv = str_replace(">","",$abrv);
	$abrv = str_replace("<","",$abrv);
	$abrv = str_replace(".","",$abrv);
	$abrv = str_replace(",","",$abrv);
	$abrv = str_replace("*","",$abrv);
	$abrv = str_replace("`","",$abrv);											
	
    $error_message = "";
	
	$email_exp = "/^[A-Za-z0-9._%-]+@[A-Za-z0-9.-]+\.[A-Za-z]{2,4}$/";
	
	//$url_exp = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";
	//$phone_exp = "/^(?:1)?(?(?!(37|96))[2-9][0-8][0-9](?<!(11)))?[2-9][0-9]{2}(?<!(11))[0-9]{4}(?<!(555(01([0-9][0-9])|1212)))$/";
	
	$phone = preg_replace('/\D/', '', $phone);

	if(strlen($cause) < 4)
	{
		$error_message .= 'The Cause Name you entered was too short.<br />';
	}
	if(strlen($name) < 2)
	{
		$error_message .= 'Your name is not real.<br />';
	}
	if(!preg_match($email_exp,$email_user)) 
	{
		$error_message .= 'The Email Address you entered does not appear to be valid.<br />';
	}
	
	if($error_message != "")
	{
		died($error_message);
	}
	
	$connect = mysql_connect("mysql", "Jatna", "ZIA1YOKO2") or die("Couldnt Connect");
	mysql_select_db("causes") or die("Couldnt find database");
  
	$matchs = mysql_query("SELECT * FROM causes WHERE name LIKE '%$abrv%' LIMIT 20");
	$matchrow = mysql_num_rows($matchs);
	
	$mReturn ='';
	
	if($matchrow != 0)
	{
		while($m = mysql_fetch_array($matchs))
		{	
			$mReturn.=$m['name'].'\n';
		}
		?>
		<script type="text/javascript">
			var answer = window.confirm("The cause that you entered is similar to another cause:\n\n <?echo $mReturn;?>\n Would you like to still add this cause?");
		
			if(answer)
			{
				<?$cont = true;?>
			}
			else
			{
				<?$cont = false;?>history.go(-1);
			}
		</script>
		<?
	}
	
	if($cont)
	{
		$abrv = str_replace(" ","",$abrv);
		$abrv = strtoupper($abrv);
  
		if(strlen($error_message) > 0) 
		{
			died($error_message);
		}  
  
		function clean_string($string) 
		{
			$bad = array("content-type","bcc:","to:","cc:","href");
			$str = str_replace($bad,"",$string);
			$str = str_replace("'","#",$string);
			return $str;
		}
	
		// Connects to Database
		$connect = mysql_connect("mysql", "Jatna", "ZIA1YOKO2") or die("Couldnt Connect");
		mysql_select_db("causes") or die("Couldnt find database");
		
		$cause = str_replace("%"," ",$cause);
		$cause = str_replace("'","#",$cause);
		
		$query = mysql_query('INSERT INTO temp VALUES ("", "'.$ip.'","'.$cause.'", "'.$url.'", "'.$abrv.'", "", "jatnafundraising-20", "'.$nat.'", "null", "'.$cat.'", "'.$email_user.'", "'.$phone.'", "'.$name.'")');
		
		$codeMaker = mysql_query("SELECT id,name FROM temp WHERE name='$cause'");
		$hid = "";
		while($c = mysql_fetch_array($codeMaker))
		{
			$hid = $c['name'];
			srand($hid);
			$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
			$code = '';
			for ($i = 0; $i < 6; $i++) 
			{
				$code .= $characters[rand(0, strlen($characters) - 1)];
			}
			$q2 = mysql_query("UPDATE temp SET code='$code' WHERE name='$hid'");
			$causeid = $c['id'];
		}
		
		$email_message .= "Cause:\n".clean_string($cause)."\n";
		$email_message .= "\nUrl:\n".clean_string($url)."\n";
		$email_message .= "\nEmail:\n".clean_string($email_user)."\n";
		$email_message .= "\nPhone:\n".clean_string($phone)."\n";
		$email_message .= "\nContacter's Name:\n".clean_string($name)."\n";
		$email_message .= "\nType:\n".clean_string($cat)."\n";
		$email_message .= "\nNationality:\n".clean_string($nat)."\n";
		$email_message .= "</body>\n</html>";
		
		$email_subject.=$cause;
		
		mail($email_to1, $email_subject, $email_message, $headers);
		mail($email_to2, $email_subject, $email_message, $headers);
	}
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<title>Jatna - Add</title>
	<link href="css/d/classic.css" rel="stylesheet" type="text/css">
	<link href="css/d/style.css" rel="stylesheet" type="text/css">
	<link rel="SHORTCUT ICON" href="images/favicon.ico">
</head>
<body>
	<div id="content">
		<a href="/"><img src="images/logosmall.png" id="logo" alt="Jatna"/></a>
		<p>Your cause addition was sent!</p>
		<p>You can shop for your cause before it is approved by going to the homepage and clicking on the cause highlighted in yellow.  However, until the cause is officially approved, your cause will only appear on the homepage on your current IP Address.</p>
		<p>Your cause will be officially approved within 24 hours.</p>
		<p>Thank you for contributing to Jatna's growing list of charities!</p>
		<?
			include 'php/address.php';
		?>
	</div>
</body>
</html>