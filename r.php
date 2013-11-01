<?php
	$id = $_GET['i'];
	$idc = $_GET['a'];
	$ref = $_GET['r'];
	$tmp = $_GET['t'];
	
	
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
	
	setcookie("JatnaStore", "", '/');
	setcookie("JatnaStore", false, time()-3600, '/');
	
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("stores") or die("Couldnt find database");
	
	$stores = mysql_query("SELECT * FROM stores WHERE id='$id'");
	
	$store = mysql_fetch_array($stores);
	$clicks = $store['clicks'] + 1;
	mysql_query("UPDATE stores SET clicks='$clicks' WHERE id='$id'");
	
	mysql_select_db("causes") or die("Couldnt find database");
	if($idc != "")
	{
		$causes = mysql_query("SELECT * FROM causes WHERE code='$idc'");
	}
	else
	{
		$causes = mysql_query("SELECT * FROM temp WHERE code='$tmp'");
	}
	$cause = mysql_fetch_array($causes);
	
	$abrv = $cause['abrv'];
	$sname = $store['name'];
	$cname = $cause['name'];
	$aid = $cause['aid'];
	$link = $store['link'];
	
	if(strtolower ($store['name']) != "amazon")
	{
		if($ref == "")
		{
			$link = str_replace ('JATNAFUNDRAISING-20', $abrv, $store['link']);
		}
		else
		{
			$link = str_replace ('JATNAFUNDRAISING-20', $abrv.'-r-'.$ref, $store['link']);
		}
	}
	else
	{	
		$link = str_replace ('JATNAFUNDRAISING-20', $aid, $store['link']);
	}
	
	$co = $_COOKIE["JatnaReferral"];
	
	if($ref != "" || $co != "")
	{
		$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
		mysql_select_db("track") or die("Couldnt find database");
		
		$q = mysql_query("SELECT get FROM referral WHERE code='$ref'");
		
		while($tracker = mysql_fetch_array($q))
		{
			$clicks = $tracker['get'] + 1;
			$q2 = mysql_query("UPDATE referral SET get='$clicks' WHERE code='$ref'");
		}
		
		$query = mysql_query("SELECT cook FROM referral WHERE code='$co'");

		$q= mysql_fetch_array($query);
		$clicks = $q['cook'] + 1;

		mysql_query("UPDATE referral SET cook='$clicks' WHERE code='$co'");
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
	<head>
		<title>Jatna - Redirect: <?echo $cname;?></title>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
		<link href="css/d/count.css" rel="stylesheet" type="text/css">
		<link rel="SHORTCUT ICON" href="images/favicon.ico">
		<script>
		var t = 3;
		function start()
		{
			document.getElementById("timer").innerHTML=t;
			setInterval(function(){timer();},1000);
		}
		
		function timer()
		{
			if(t > 0)
			{
				t--;
				document.getElementById("timer").innerHTML=t;
			}
			
			if(t == 0)
			{
				window.location = "<?echo $link;?>";
				t = -1;
			}
		}
		</script>
	</head>
	<body onload="start()">
	<div id="content">
	<?
		if($tmp == "")
		{
			echo '<img src="images/redgen?i='.$id.'&a='.$idc.'" alt="Redirecting..." id="redgen"/>';
		}
		else
		{
			echo '<img src="images/redgen?i='.$id.'&t='.$tmp.'" alt="Redirecting..." id="redgen"/>';
		}
	?>
		<div class="head2" id="timer">3</div>
		<br/>
		<div class="head4">If you are not redirected within 3 seconds, click <a id="here" target="_blank" href="<?echo $link;?>">here</a></div>
	</div>
	</body>
</html>