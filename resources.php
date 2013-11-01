<?php
	include 'php/click.php';

	mysql_connect("host", "username", "password") or die("Couldnt Connect");	
	
	$lastLetter = '';
	$currLetter = '';
	$echo = '';
	$num = true;
	
	mysql_select_db("causes") or die("Couldnt find database");

	$cs = mysql_query("SELECT id FROM causes");
	
	$head1 = '<h2 id="head">'.number_format(mysql_num_rows($cs)).' Causes and growing...</h2>';
		
	mysql_select_db("stores") or die("Couldnt find database");

	$ss = mysql_query("SELECT id FROM stores");
	
	$head2 = '<h2 id="head">'.number_format(mysql_num_rows($ss)).' Stores and growing...</h2>';	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="description" content="Jatna is an online fundraising platform that makes fundraising for charities, schools, churches, spiritual groups, clubs, events, non-profit organizations, and for-profit organizations very simple. Jatna is free and easy to use."/>
	<meta name="keywords" content="about,jatnaabout,jatna,jatna.com,fundraising,online fundraising,team fundraising,fundraising ideas,fundraiser,community,free,donate,simple,charity,school,donation,cause,nonprofit,unique,church,fund,simple fundraising,charity fundraising,school fundraising,donation fundraising,cause fundraising,nonprofit fundraising,unique fundraising,church fundraising,fund fundraising"/>
	<title>Jatna - Resources</title>
	<link href="css/d/classic.css" rel="stylesheet" type="text/css">
	<link href="css/d/style.css" rel="stylesheet" type="text/css">	
	<link href="css/d/list.css" rel="stylesheet" type="text/css">
	<link href="css/d/resources.css" rel="stylesheet" type="text/css">
	<link rel="SHORTCUT ICON" href="images/favicon.ico">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">
		function loadImages()
		{
			$("#results").html('<img src="images/load.gif" id="load" alt="Loading"/>');
			$.post("php/resources/images.php", {},function(data)
			{
				$("#results").html(data);
			});
			
		}
		
		function loadJatna2U()
		{
			$("#results").html('<img src="images/load.gif" id="load" alt="Loading"/>');
			$.post("php/resources/jatna2u.php", {},function(data)
			{
				$("#results").html(data);
			});
		}
		
		function loadChrome()
		{
			$("#results").html('<img src="images/load.gif" id="load" alt="Loading"/>');
			$.post("php/resources/chrome.php", {},function(data)
			{
				$("#results").html(data);
			});
		}
		
		
	</script>
</head>
<body onLoad="loadJatna2U()"> 
	<div id="content">
		<a href="/"><img src="images/logosmall.png" id="logo" alt="Jatna"/></a>
		<br/>
		<br/>
		Use these tools, images, downloads and resources to promote fundraising on your website!
		<br/>
		<br/>
		<form>
			<input type="button" name="jatna2uButton" id="jatna2uButton" class="button" value="Jatna2U" onclick="loadJatna2U();"/>
			<input type="button" name="imagesButton" id="imagesButton" class="button" value="Images" onclick="loadImages();"/>
			<input type="button" name="chromeButton" id="chromeButton" class="button" value="Chrome Extension" onclick="loadChrome();"/>
		</form>
		<div id="results"></div>
		<br/><br/>
		<?include 'php/address.php';?>
	</div>
</body>
</html>