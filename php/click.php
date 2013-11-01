<?php
	$crawler = true;

	function getCrawler($userAgent) 
	{
		$crawlers = 'firefox|Google|msnbot|Rambler|Yahoo|AbachoBOT|accoona|' .
		'AcioRobot|ASPSeek|CocoCrawler|Dumbot|FAST-WebCrawler|' .
		'GeonaBot|Gigabot|Lycos|MSRBOT|Scooter|AltaVista|IDBot|eStyle|Scrubby';
		$crawler = (preg_match("/$crawlers/i", $userAgent) > 0);
		return !$crawler;
	}

	$crawler = getCrawler($_SERVER['HTTP_USER_AGENT']);

	if ($crawler) 
	{
		//$cook = $_COOKIE["Visit"];
		//setcookie("Visit", 1);
		$ip = $_SERVER['REMOTE_ADDR'];
		$url = 'http://api.hostip.info/get_html.php?ip='.$ip.'&position=true';
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_NOBODY, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$result = curl_exec ($ch);
		curl_close ($ch);

		$array = explode("\n", $result);

		$array[0] = substr($array[0], strpos ($array[0], '(') + 1, 2);
		$array[1] = str_replace('City: ', '', $array[1]);
		$array[2] = str_replace('Latitude: ', '', $array[3]);
		$array[3] = str_replace('Longitude: ', '', $array[4]);		
		
		
		if(date_default_timezone_set('GMT') !== FALSE)
		{
			$day = idate("z");
			$mon = idate("m");
			$year = idate("y");
		}
		
		// Month
		if(strlen($mon) == 1)
		{
			$mon = '0'.$mon;
		}
		
		if($day <= 31)
		{
			$lday = 365 - ($day - 31);
		}
		else
		{
			$lday = $day - 31;
		}
		
		while(strlen($day) != 3)
		{
			$day = '0'.$day;
		}
		
		// Table Names
		$tablen1 = "clickM".$mon.$year;
		$tablen2 = "clickD".$day;
		$tablen3 = "clickD".$lday;
		$tablen4 = "browser".$mon.$year;
		$tablen5 = "device".$mon.$year;
		$tablen6 = "user".$mon.$year;
		$tablen7 = "uniqueD".$day;
		$tablen8 = "uniqueD".$lday;
		$tablen9 = "uniqueM".$mon.$year;

		$tablea = getdate(date("U"));
		$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
		mysql_select_db("track") or die("Couldnt find database");
		
		$uniqueMonth = 1;	

		$uniqueMCook = array();
		$cookieU = $_COOKIE["month_user"];
		$uniqueMCook = explode(':',$cookieU);
		
		$uniqueMonth = intval($uniqueMCook[0]) + 1;
		$uniqueMCode = (string)$uniqueMCook[1];
		
		if(isset($uniqueMCook[0]) && $uniqueMCode != '')
		{
			setcookie("month_user", $uniqueMonth.':'.$uniqueMCode);
		}
		else
		{
			setcookie("month_user", $uniqueMonth.':'.uniqid());
		}
		
		mysql_query("CREATE TABLE $tablen9(id INT NOT NULL AUTO_INCREMENT, code VARCHAR(256), ip VARCHAR(256), click INT NOT NULL, PRIMARY KEY (id))");
		
		$dupeU1 = mysql_query("SELECT id FROM $tablen9 WHERE code='$uniqueMCode'");  
				
		if (mysql_num_rows($dupeU1) == 0) 
		{ 
			mysql_query("INSERT INTO $tablen9 VALUES ('', '$uniqueMCode', '$ip', '1')");
		}
			
		mysql_query("UPDATE $tablen9 SET click='$uniqueMonth' WHERE code='$uniqueMCode'");
		
		
		//////////////////////////////////////////////
				
		$uniqueDay = 1;	

		$uniqueDCook = array();
		$cookieU = $_COOKIE["day_user"];
		$uniqueDCook = explode(':',$cookieU);
		
		$uniqueDay = intval($uniqueDCook[0]) + 1;
		$uniqueDCode = (string)$uniqueDCook[1];
		
		if(isset($uniqueDCook[0]) && $uniqueDCode != '')
		{
			setcookie("day_user", $uniqueDay.':'.$uniqueDCode);
		}
		else
		{
			setcookie("day_user", $uniqueDay.':'.uniqid());
		}
		
		mysql_query("CREATE TABLE $tablen7(id INT NOT NULL AUTO_INCREMENT, code VARCHAR(256), ip VARCHAR(256), click INT NOT NULL, PRIMARY KEY (id))");
		
		$dupeU1 = mysql_query("SELECT id FROM $tablen7 WHERE code='$uniqueDCode'");  
				
		if (mysql_num_rows($dupeU1) == 0) 
		{ 
			mysql_query("INSERT INTO $tablen7 VALUES ('', '$uniqueDCode', '$ip', '1')");
		}
			
		mysql_query("UPDATE $tablen7 SET click='$uniqueDay' WHERE code='$uniqueDCode'");
		
		
		
		
		/////////////////////////////////////////////
		
		mysql_query("CREATE TABLE $tablen6(id INT NOT NULL AUTO_INCREMENT, ip VARCHAR(256), country VARCHAR(256), city VARCHAR(256), latitude VARCHAR(48), longitude VARCHAR(48),click INT NOT NULL, PRIMARY KEY (id))");
		
		if(strcmp($array[1], '(Unknown city)') != 0 && !empty($array[2]) && !empty($array[3]))
		{
			$dupe1 = mysql_query("SELECT * FROM $tablen6 WHERE ip = '".$ip."'"); 
			
			if (mysql_num_rows($dupe1) == 0) 
			{ 
				mysql_query("INSERT INTO $tablen6 VALUES ('', '$ip', '".$array[0]."', '".$array[1]."', '".$array[2]."', '".$array[3]."', '0')");
			}
			
			$clicks1 = mysql_query("SELECT click FROM $tablen6 WHERE ip='".$ip."'");
			$click1 = mysql_fetch_array($clicks1);
			$num1 = $click1['click'] + 1;
			mysql_query("UPDATE $tablen6 SET click='".$num1."' WHERE ip='".$ip."'");
		}
		
		// Record Clicks
		$page = $_SERVER['REQUEST_URI'];
		$page = substr($page, 1);
		if(strpos($page,'/') !== false)
		{
			$page = '';
		}
		
		if(strpos($page,'?') !== false)
		{
			$pagea = array();
			$pagea = explode('?',$page);
			$page = $pagea[0];
			$c = $pagea[1];
			if(strlen($c) != 10)
			{
				$c = '';
			}
		}
		
		$page = str_replace('.php', '', $page);
		
		if(strcmp($page, "") == 0)
		{
			$page = "index";
		}
		
		
		function get_user_browser() 
		{ 
			$u_agent = $_SERVER['HTTP_USER_AGENT']; 
			$ub = ''; 
			if(preg_match('/MSIE/i',$u_agent)) 
			{ 
				$ub = "IE"; 
			} 
			elseif(preg_match('/Firefox/i',$u_agent)) 
			{ 
				$ub = "Firefox"; 
			} 
			elseif(preg_match('/Safari/i',$u_agent)) 
			{ 
				$ub = "Safari"; 
			} 
			elseif(preg_match('/Chrome/i',$u_agent)) 
			{ 
				$ub = "Chrome"; 
			} 
			elseif(preg_match('/Flock/i',$u_agent)) 
			{ 
				$ub = "Flock"; 
			} 
			elseif(preg_match('/Opera/i',$u_agent)) 
			{ 
				$ub = "Opera"; 
			} 
			elseif(preg_match('/Netscape/i',$u_agent)) 
			{ 
				$ub = "Netscape"; 
			} 
			
			return $ub; 
		} 
		$browserA = get_browser($_SERVER['HTTP_USER_AGENT'], true);
		$browser = $browserA['browser'];
		if(strcmp($browser, 'Default Browser') == 0)
		{
			$browser = get_user_browser();
		}
		
		$user_agent = $_SERVER['HTTP_USER_AGENT'];
		$iphone 	= strpos($user_agent,"iPhone");
		$ipod	 	= strpos($user_agent,"iPod");
		$ipad 		= strpos($user_agent,"iPad");
		$blackberry	= stristr($user_agent,"BlackBerry");
		$android 	= strpos($user_agent,"Android");
		 
		$device = 'Desktop'; 
		$deviceS = '';
		
		if ($iphone || $ipod || $blackberry || $android)
		{
		   $device = 'Mobile Phone';
		   if($iphone) 		{$deviceS = 'iPhone';}
		   if($ipod) 		{$deviceS = 'iPod';}
		   if($blackberry) 	{$deviceS = 'Blackberry';}
		   if($android) 	{$deviceS = 'Android';}
		}
		else if($ipad)
		{
		   $device = 'Tablet';
		}
		else
		{
		   $device = 'Desktop';	
		}
		
		// Create Month Table
		mysql_query("CREATE TABLE $tablen1(page VARCHAR(256),click INT NOT NULL)");
		
		$dupe1 = mysql_query("SELECT * FROM $tablen1 WHERE page = '".$page."'"); 
		$dupe2 = mysql_query("SELECT * FROM $tablen1 WHERE page = '".$c."'"); 
		
		if (mysql_num_rows($dupe1) == 0) 
		{ 
			mysql_query('INSERT INTO '.$tablen1.' VALUES ("'.$page.'", "0")');
		}
		if (mysql_num_rows($dupe2) == 0) 
		{ 
			mysql_query('INSERT INTO '.$tablen1.' VALUES ("'.$c.'", "0")');
		}
		
		$clicks1 = mysql_query("SELECT * FROM $tablen1 WHERE page='".$page."'");
		$click1 = mysql_fetch_array($clicks1);
		$num1 = $click1['click'] + 1;
		mysql_query("UPDATE $tablen1 SET click='".$num1."' WHERE page='".$page."'");
		
		$clicks2 = mysql_query("SELECT * FROM $tablen1 WHERE page='".$c."'");
		$click2 = mysql_fetch_array($clicks2);
		$num2 = $click2['click'] + 1;
		mysql_query("UPDATE $tablen1 SET click='".$num2."' WHERE page='".$c."'");
		
		// Create Day Table
		mysql_query("CREATE TABLE $tablen2(page VARCHAR(256),click INT NOT NULL)");
		
		$dupe1 = mysql_query("SELECT * FROM $tablen2 WHERE page = '".$page."'"); 
		$dupe2 = mysql_query("SELECT * FROM $tablen2 WHERE page = '".$c."'"); 
		
		if (mysql_num_rows($dupe1) == 0) 
		{ 
			mysql_query('INSERT INTO '.$tablen2.' VALUES ("'.$page.'", "0")');
		}
		$clicks1 = mysql_query("SELECT * FROM $tablen2 WHERE page='".$page."'");
		$click1 = mysql_fetch_array($clicks1);
		$num1 = $click1['click'] + 1;
		mysql_query("UPDATE $tablen2 SET click='".$num1."' WHERE page='".$page."'");
		
		if (mysql_num_rows($dupe2) == 0) 
		{ 
			mysql_query('INSERT INTO '.$tablen2.' VALUES ("'.$c.'", "0")');
		}
		$clicks2 = mysql_query("SELECT * FROM $tablen2 WHERE page='".$c."'");
		$click2 = mysql_fetch_array($clicks2);
		$num2 = $click2['click'] + 1;
		mysql_query("UPDATE $tablen2 SET click='".$num2."' WHERE page='".$c."'");

		// Create Month Table Device
		mysql_query("CREATE TABLE $tablen4(browser VARCHAR(256),click INT NOT NULL)");
		
		$dupe1 = mysql_query("SELECT * FROM $tablen4 WHERE browser = '".$browser."'");  
		
		if (mysql_num_rows($dupe1) == 0) 
		{ 
			mysql_query('INSERT INTO '.$tablen4.' VALUES ("'.$browser.'", "0")');
		}
		
		$clicks1 = mysql_query("SELECT * FROM $tablen4 WHERE browser='".$browser."'");
		$click1 = mysql_fetch_array($clicks1);
		$num1 = $click1['click'] + 1;
		mysql_query("UPDATE $tablen4 SET click='".$num1."' WHERE browser='".$browser."'");
		
		// Create Month Table Device
		mysql_query("CREATE TABLE $tablen5(device VARCHAR(256),click INT NOT NULL)");
		
		$dupe1 = mysql_query("SELECT * FROM $tablen5 WHERE device = '".$device."'"); 
		$dupe2 = mysql_query("SELECT * FROM $tablen5 WHERE device = '".$deviceS."'"); 
		
		if (mysql_num_rows($dupe1) == 0) 
		{ 
			mysql_query('INSERT INTO '.$tablen5.' VALUES ("'.$device.'", "0")');
		}
		if (mysql_num_rows($dupe2) == 0) 
		{ 
			mysql_query('INSERT INTO '.$tablen5.' VALUES ("'.$deviceS.'", "0")');
		}
		
		$clicks1 = mysql_query("SELECT * FROM $tablen5 WHERE device='".$device."'");
		$click1 = mysql_fetch_array($clicks1);
		$num1 = $click1['click'] + 1;
		mysql_query("UPDATE $tablen5 SET click='".$num1."' WHERE device='".$device."'");
		
		$clicks2 = mysql_query("SELECT * FROM $tablen5 WHERE device='".$deviceS."'");
		$click2 = mysql_fetch_array($clicks2);
		$num2 = $click2['click'] + 1;
		mysql_query("UPDATE $tablen5 SET click='".$num2."' WHERE device='".$deviceS."'");
		
		// Delete Last Day Table
		mysql_query("DROP TABLE $tablen3");
		mysql_query("DROP TABLE $tablen8");
		mysql_query("DELETE FROM $tablen1 WHERE page=''");
		mysql_query("DELETE FROM $tablen2 WHERE page=''");
		mysql_query("DELETE FROM $tablen5 WHERE device=''");
		mysql_query("DELETE FROM $tablen1 WHERE page='_'");
		mysql_query("DELETE FROM $tablen2 WHERE page='_'");
		mysql_close();
	}
?>