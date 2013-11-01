<?php
	$cause = $_GET['c'];
	$temp = $_GET['t'];
	$sid = $_GET['s'];
	$imb = $_GET['i'];
	
	// Connects to Database
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("causes") or die("Couldnt find database");	

	$causes = mysql_query("SELECT * FROM causes WHERE code='$cause' LIMIT 1");
	$temps = mysql_query("SELECT * FROM temp WHERE code='$temp' LIMIT 1");
	
	$checknum = mysql_num_rows($causes);
	$checknumtemp = mysql_num_rows($temps);
	$c = mysql_fetch_array($causes);
	$t = mysql_fetch_array($temps);
	
	if($checknum == 1)
	{
		$name = $c['name'];
		$link = $c['link'];
		$abrv = $c['id'];
		$aid = $c['aid'];
	}
	
	else if($checknumtemp == 1)
	{
		$name = $t['name'];
		$link = $t['link'];
		$abrv = $t['id'];
		$aid = $t['aid'];
	}
	
	mysql_select_db("stores") or die("Couldnt find database");
	
	$stores = mysql_query("SELECT * FROM stores WHERE id='$sid' LIMIT 1");
	
	$checknum = mysql_num_rows($stores);
	$s = mysql_fetch_array($stores);
	
	if($checknum == 1)
	{
		$sname = $s['name'];
		$sp1 = $s['p1'];
		$sp2 = $s['p2'];
		$sa1 = $s['a1'];
		$sa2 = $s['a2'];
		$cur = $s['currency'];
	}
	$sname = str_replace("#", "'", $sname);
	$name = str_replace("#", "'", $name);
?>
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
			<meta name="description" content="Jatna is an online fundraising platform that makes fundraising for charities, schools, churches, spiritual groups, clubs, events, non-profit organizations, and for-profit organizations very simple. Jatna is free and easy to use."/>
			<meta name="keywords" content="about,jatnaabout,jatna,jatna.com,fundraising,online fundraising,team fundraising,fundraising ideas,fundraiser,community,free,donate,simple,charity,school,donation,cause,nonprofit,unique,church,fund,simple fundraising,charity fundraising,school fundraising,donation fundraising,cause fundraising,nonprofit fundraising,unique fundraising,church fundraising,fund fundraising"/>
			<title>Jatna - Calculator</title>
			<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
			<?
			if($imb == "1")
			{
				echo '<link href="css/d/calci.css" rel="stylesheet" type="text/css">';
			}
			else
			{
				echo '<link href="css/d/calc.css" rel="stylesheet" type="text/css">';
			}
			?>
			
			<link rel="SHORTCUT ICON" href="images/favicon.ico">
			
			<script type="text/javascript">
				function calculate(value)
				{
					if(!isNaN(parseFloat(value)))
					{
					<?
						if($cur == "USD")
						{
							$curType = '$';
						}
						
						if($sp1 != 0)
						{
							echo '
							var p1 = "'.$curType.' " + (parseFloat(value) * '.$sp1.'/100).toFixed(2);
							var result = p1;';
							if($sp2 != 0 && $sp2 != $sp1)
							{
								echo '
								var p2 = (parseFloat(value) * '.$sp2.'/100).toFixed(2);
								var result = p1 + " '.$curType.' to " + p2 + " '.$curType.'";';
							}
						}
						else
						{
							echo 'var result = "'.$sa1.' '.$curType.'";';
							if($sa2 != 0 && $sa2 != $sa1)
							{
								echo 'var result = "'.$curType.' '.$sa1.' + " to " + '.$sa2.'";';
							}
						}
					?>
						document.getElementById("return").innerHTML = result;
					}
					else
					{	
						document.getElementById("return").innerHTML = "";
					}
				}
				
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
						calculate(input.value)
					}
					else
					{
						  return true;
					}
				}
			</script>
			
		</head>
		<body onload="document.calc.input.focus();">
			<div id="content">
					<img src="images/leaf.png" alt="Leaf" id="leaf"/>
					<br/>
					<br/>
					<div id="namepar1">
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
					</div>
					<div id="content2">
						<p id="desc">Enter the amount you spent at <?echo $sname;?>  to see how much you donated to <?echo $name;?>.</p>
						<form id="calc" name="calc"  >
								<input type="text" onkeyup="calculate(this.value)" class="input" name="input" id="input" onkeypress="return noenter()"/>
						</form>
						<br/>
						<div id="retpar"><div id="return"></div></div>
						<p id="note">This is completely optional.<br/>Its only purpose is to satisfy your curiosity.</p>
					</div>
			</div>
		</body>
		</html>