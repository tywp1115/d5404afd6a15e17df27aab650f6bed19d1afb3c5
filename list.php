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
	<title>Jatna - Cause Directory</title>
	<link href="css/d/classic.css" rel="stylesheet" type="text/css">
	<link href="css/d/style.css" rel="stylesheet" type="text/css">	
	<link href="css/d/list.css" rel="stylesheet" type="text/css">
	<link rel="SHORTCUT ICON" href="images/favicon.ico">
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript">
		function add()
		{
			window.location.href='/add';
		}
	
		function loadCauses()
		{
			$("#box1").html('<?echo $head1;?> <form><center><input type="button" name="addCharity" id="addCharity" value="Add a Cause" onclick="add();"/></center></form><br/>');
			$("#results").html('<img src="images/load.gif" id="load" alt="Loading"/>');
			
			$.post("php/listc.php", {},function(data)
			{
				$("#results").html(data);
			});
		}
		function loadStores()
		{
			$("#box1").html('<?echo $head2;?>');
			$("#results").html('<img src="images/load.gif" id="load" alt="Loading"/>');
			
			$.post("php/lists.php", {},function(data)
			{
				$("#results").html(data);
			});
			
		}
	</script>
</head>
<body onLoad="loadCauses()"> 
	<div id="content">
		<a href="/"><img src="images/logosmall.png" id="logo" alt="Jatna"/></a>
		<br/>
		<form>
			<input type="button" name="causeButton" id="causeButton" value="Display Causes" onclick="loadCauses();"/>
			<input type="button" name="storeButton" id="storeButton" value="Display Stores" onclick="loadStores();"/>
		</form>
		<br/>
		<div id="box1">	
		</div><br/><div id="box2">
		<a href="#1" class="topanch">1-9</a> | 
		<a href="#A" class="topanch">A</a> | 
		<a href="#B" class="topanch">B</a> | 
		<a href="#C" class="topanch">C</a> | 
		<a href="#D" class="topanch">D</a> | 
		<a href="#E" class="topanch">E</a> | 
		<a href="#F" class="topanch">F</a> | 
		<a href="#G" class="topanch">G</a> | 
		<a href="#H" class="topanch">H</a> | 
		<a href="#I" class="topanch">I</a> | 
		<a href="#J" class="topanch">J</a> | 
		<a href="#K" class="topanch">K</a> | 
		<a href="#L" class="topanch">L</a> | 
		<a href="#M" class="topanch">M</a> | 
		<a href="#N" class="topanch">N</a> | 
		<a href="#O" class="topanch">O</a> | 
		<a href="#P" class="topanch">P</a> | 
		<a href="#Q" class="topanch">Q</a> | 
		<a href="#R" class="topanch">R</a> | 
		<a href="#S" class="topanch">S</a> | 
		<a href="#T" class="topanch">T</a> | 
		<a href="#U" class="topanch">U</a> | 
		<a href="#V" class="topanch">V</a> | 
		<a href="#W" class="topanch">W</a> | 
		<a href="#X" class="topanch">X</a> | 
		<a href="#Y" class="topanch">Y</a> | 
		<a href="#Z" class="topanch">Z</a>
		<br/><div id="results"></div>
		</div>
		<br/><br/>
		<?include 'php/address.php';?>
	</div>
</body>
</html>