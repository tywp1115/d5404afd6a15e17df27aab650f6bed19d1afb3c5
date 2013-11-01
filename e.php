<?php 
	include 'php/click.php';
	
	// Detect Device
	$user_agent = $_SERVER['HTTP_USER_AGENT'];
	$iphone 	= strpos($user_agent,"iPhone");
	$ipod	 	= strpos($user_agent,"iPod");
	$ipad 		= strpos($user_agent,"iPad");
	$blackberry	= stristr($user_agent,"BlackBerry");
	$android 	= strpos($user_agent,"Android");
	 
	$browser = 'desktop'; 
	
	if ($iphone || $ipod || $blackberry || $android)
	{
	   $browser = 'mobile phone';
	   if($iphone) 		{$browser .= ' iphone';}
	   if($ipod) 		{$browser .= ' ipod';}
	   if($blackberry) 	{$browser .= ' blackberry';}
	   if($android) 	{$browser .= ' android';}
	}
	else if($ipad)
	{
	   $browser = 'tablet';
	}
	else
	{
	   $browser = 'desktop';	
	}
	
	// Check IP
	$ipaddress = getenv(REMOTE_ADDR);
	$ip = (String)$ipaddress;
	
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("ips") or die("Couldnt find database");
	
	$query = mysql_query('SELECT * FROM ips WHERE ip="'.$ip.'"');
	
	if(mysql_num_rows($query) == 0)
	{
		$go = mysql_query('INSERT INTO ips VALUES ("", "'.$ip.'")');
	}
	
	// Track
	
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("track") or die("Couldnt find database");
	
	$ref = $_GET['r'];
	$cook = $_GET['o'];
	
	$red = $_GET['s'];
	
	if($cook != "")
	{
		setcookie ("JatnaReferral", "$cook",time()+20);
		header('Location: /');
	}
	
	mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("causes") or die("Couldnt find database");
	mysql_pconnect();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="description" content="Jatna is an online fundraising platform that makes fundraising for charities, schools, churches, spiritual groups, clubs, events, non-profit organizations, and for-profit organizations very simple. Jatna is free and easy to use."/>
	<meta name="keywords" content="jatna,jatna.com,fundraising,online fundraising,team fundraising,fundraising ideas,fundraiser,community,free,donate,simple,charity,school,donation,cause,nonprofit,unique,church,fund,simple fundraising,charity fundraising,school fundraising,donation fundraising,cause fundraising,nonprofit fundraising,unique fundraising,church fundraising,fund fundraising"/>
	<title>Jatna</title>
	<?
	if ($browser=="desktop") 
	{
	   echo 
		'<link href="css/d/style.css" rel="stylesheet" type="text/css">
		<link href="css/d/index.css" rel="stylesheet" type="text/css">
		<link href="css/d/walk.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="javascript/walkd.js"></script>';
	}
	else //if($browser=="tablet")
	{
		echo 
		'<meta name="viewport" content="width=1024px, initial-scale=1.0, maximum-scale=10.0" />
		<link href="css/t/style.css" rel="stylesheet" type="text/css">
		<link href="css/t/index.css" rel="stylesheet" type="text/css">
		<link href="css/t/walk.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="javascript/walkm.js"></script>';
	}/*
	else
	{
		echo 
		'<link href="css/m/style.css" rel="stylesheet" type="text/css">
		<link href="css/m/index.css" rel="stylesheet" type="text/css">
		<link href="css/m/walk.css" rel="stylesheet" type="text/css">
		<script type="text/javascript" src="javascript/walkm.js"></script>';
	}*/
	
	?>

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="javascript/search.js"></script>
	<script type="text/javascript">
		var walkthrough = false;
		var time = 0;
		
		function noenter(e) 
		{
			var key;
			if(window.event)
			{
				key = window.event.keyCode;
			}
			else
			{
				key = e.which;
			}
			if(key == 13)
			{
				return false;
				findCause(searchbar.value, '<?echo $ref?>');
			}
			else
			{
				  return true;
			}
		}
		
		function calc(c, e)
		{
			var loc = "calc?c="+c+"&s="+e;
			setInterval(function(){window.location = loc;},3000);
		}
</script>
	</script>
	<link rel="SHORTCUT ICON" href="images/favicon.ico">
</head>
<body onLoad="loadContentIndexE('<?echo $ref?>', '<?echo $red;?>')">
	<div id="content">	
		<div id="walk"></div>
		<a href="/"><img src="images/logo.png" id="logo" alt="Jatna"/></a>
		<br/>
		<form name="searchform">
			<span id="explain">Search for a Cause here or choose one below...</span>
			<input id="searchbarIndex2" autocomplete="off" onkeyup="findCauseE('<?echo $red;?>',this.value, '<?echo $ref;?>')" onmousedown="focusSearch()" onkeypress="return clearSearch(event)" type="text" name="searchbar"/>
		</form><!--
		<div id="helpbox">
			
		</div>-->
		
		<div id="results">
			<img src="images/load.gif" id="load" alt="Loading"/>
		</div>
	</div>
</body>
</html>

<??>