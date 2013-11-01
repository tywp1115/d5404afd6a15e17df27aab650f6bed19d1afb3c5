<?php
	include 'php/click.php';
	
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
	
	$name = '';
	$link = '';
	$abrv = '';
	$aid = '';

	$cause = $_GET['c'];
	$temp = $_GET['t'];
	$ref = $_GET['r'];

	$ipaddress = getenv(REMOTE_ADDR);
	$ip = (String)$ipaddress;
	
	// Connects to Database
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("causes") or die("Couldnt find database");	
	
	$causes = mysql_query("SELECT * FROM causes WHERE code='$cause' LIMIT 1");
	$temps = mysql_query("SELECT * FROM temp WHERE code='$temp' LIMIT 1");
	
	$checknum = mysql_num_rows($causes);
	$checknumtemp = mysql_num_rows($temps);
	if(strcmp($temp, '') == 0)
	{
		$checknumtemp = 0;
	}
	$c = mysql_fetch_array($causes);
	$t = mysql_fetch_array($temps);
	
	if($checknum == 1)
	{
		$name = $c['name'];
		$link = $c['link'];
		$abrv = $c['code'];
		$aid = $c['aid'];
	}
	
	else if($checknumtemp == 1)
	{
		$name = $t['name'];
		$link = $t['link'];
		$abrv = $t['code'];
		$aid = $t['aid'];
	}

	if($checknum == 1)
	{
		$views = explode(";", $_COOKIE["views"]);
		$newarr = '';
		
		$good = false;
		$num = 0;
		
		for($q = 0; $q < count($views); $q++)
		{
			if(strpos($views[$q],$cause) !== false)
			{
				$num = (int)str_replace($cause.":", "", $views[$q]);
				$num++;
				$newarr = $newarr.$cause.':'.$num.';';
				$good = true;
			}
			else if($views[$q] != "")
			{
				$newarr = $newarr.$views[$q].';';
			} 
			
		}
		
		if($good === false)
		{
			$newarr = $newarr.$cause.':1;';
		}
		
		setcookie("views", $newarr, time() + (20 * 365 * 24 * 60 * 60));
	}
	$name = str_replace("#", "'", $name);
	
	if($checknum == 1 || $checknumtemp == 1)
	{		
		?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
			<html>
			<head>
				<meta name="description" content="Jatna can help raise money for <?echo $name;?>.  Shop at any of our thousands of stores and help out your cause."/>
				<meta name="keywords" content="<?echo $name;?>,<?echo $name;?> fundraising,jatna,jatna.com,fundraising,online fundraising,team fundraising,fundraising ideas,fundraiser,community,free,donate,simple,charity,school,donation,cause,nonprofit,unique,church,fund,simple fundraising,charity fundraising,school fundraising,donation fundraising,cause fundraising,nonprofit fundraising,unique fundraising,church fundraising,fund fundraising"/>
				<title>Jatna - <?echo $name;?></title>
				<link href="css/d/style.css" rel="stylesheet" type="text/css">
				<link href="css/d/cause.css" rel="stylesheet" type="text/css">
				<link rel="SHORTCUT ICON" href="../images/favicon.ico">
				<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
				<script type="text/javascript" src="javascript/search.js"></script>
				<script type="text/javascript" src="javascript/bookmark.js"></script>
				<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
				
				<script type="text/javascript">
					var time = 6;
				</script>
					
				<script type="text/javascript">
					function goCause()
					{
						loadContentCause("<?echo $abrv;?>", "<?echo $aid;?>", "<?echo $ref;?>", "<?echo $checknumtemp;?>");
					}
			
					var value2 = "<?echo $abrv;?>";
					var value3 = "<?echo $aid;?>";
					var value4 = "<?echo $ref;?>";
					<?
						echo "var value5 = ".$checknumtemp.";";
					
					//$broname = get_browser(null, true);
					//if(strpos($broname['parent'], "Safari") === false) 
					//{
						echo 'function calc(e)
					{
						var loc = "calc?c='.$cause.'&s="+e;
						setInterval(function(){window.location = loc;},3000);
					}';
					//}?>
					

					function noenter(e) 
					{
						var key;
						if(window.event)
						{
							key = window.event.keyCode;     //IE
						}
						else
						{
							key = e.which;     //firefox
						}
						if(key == 13)
						{
							return false;
							findStore(searchbar.value, value2, value3, value4, value5);
						}
						else
						{
							  return true;
						}
					}
				</script>
			</head>
			<body onLoad="goCause()">
				<div id="content">
					<a href="../"><img src="images/logosmall.png" id="logo" alt="Jatna"/></a>
					<?
						if($link != "")
						{
							echo '<a id="name" href="'.$link.'" target="_blank">'.$name.'</a>';
						}
						else
						{
							echo '<a id="name">'.$name.'</a>';
						}
					?>
					<form name="searchform">
						<span id="explain">Search for a Store here or choose one below...</span>
						<input id="searchbar" autocomplete="off" onmousedown="focusSearch()" onkeyup="findStore(this.value, value2, value3, value4, value5)" onkeypress="return clearSearch(event)" type="text" name="searchbar" onkeypress="return noenter()"/>
					</form>
					
					<div id="results">
					<img src="images/load.gif" id="load" alt="Loading"/>
					</div>
					

					<br/>
					
					<a href="/"><img src="images/howto/works.png" id="works" alt="How Jatna Works"/></a>
					
					<?
					include 'php/address.php';
					?>
				</div>
			</body>
			</html><?
	}
	else
	{
		echo("Invalid Link");
	}
	
	mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("stores") or die("Couldnt find database");
	mysql_pconnect();
?>