<?php
	$j = 0;

	$partialStore = $_POST['partialStore'];
	$searchQuery = $_POST['searchQuery'];
	$name = "";
	$return = "";
	$abrv = $_POST['causeAbrv'];
	$aid = $_POST['causeAID'];
	$ref = $_POST['ref'];
	$temp = $_POST['temp'];
	$storearr = array();
	
	mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("stores") or die("Couldnt find database");
	mysql_pconnect();
	
	if ($searchQuery == "false" || $partialStore == "" || !$partialStore)
	{
		//$stores = mysql_query('SELECT * FROM stores WHERE public="1" AND active="1" ORDER BY RAND() LIMIT 11');
		$stores = mysql_query('SELECT * FROM stores WHERE name="Amazon" UNION SELECT * FROM stores WHERE name="iTunes" UNION SELECT * FROM stores WHERE name="Buy.com" UNION SELECT * FROM stores WHERE name="Staples" UNION SELECT * FROM stores WHERE name="Target" UNION SELECT * FROM stores WHERE name="OfficeMax" UNION SELECT * FROM stores WHERE name="Zappos" UNION SELECT * FROM stores WHERE name="Travelocity" UNION SELECT * FROM stores WHERE name="Walmart" UNION SELECT * FROM stores WHERE name="Match.com"');
	}
	else if (strlen($partialStore) <= 2)
	{
		$stores = mysql_query("SELECT * FROM stores WHERE public='1' AND active='1' AND name LIKE '$partialStore%' LIMIT 12");
	}
	else
	{
		$words = explode(' ', $partialStore);

		$sql = "SELECT * FROM stores WHERE active='1'";
		$sql_end = '';

		foreach($words as $word) {
			$sql_end .= " AND name LIKE '%$word%'";
		}

		$sql = $sql.$sql_end;		
		$stores = mysql_query($sql);
	}
	
	while($store = mysql_fetch_array($stores))
	{	
		$name = str_replace("@", ",",str_replace("#","'",$store['name']));
		$return = "";
		if($store['currency'] == "USD")
		{
			$curType = '$';
		}
		
		if($store['p1'] != 0)
		{
			$return = $store['p1'].' %';
			if($store['p2'] != 0 && $store['p2'] != $store['p1'])
			{
				$return = $return.' - '.$store['p2'].' %';
			}
		}
		else
		{
			$return = $store['a1'].' '.$curType;
			if($stores['a2'] != 0 && $store['a2'] != $store['a1'])
			{
				$return = $return.' - '.$store['a2'].' '.$curType;
			}
		}
		if((int)$temp > 0)
		{
			if($ref == "")
			{
				echo ('<a href="r?i='.$store['id'].'&t='.$abrv.'" target="_blank" id="store" onclick="calc(\''.$store['id'].'\')"><span class="result">'.$name.'<span class="return">'.$return.'</span></span></a><br/>');
			}
			else
			{
				echo ('<a href="r?i='.$store['id'].'&t='.$abrv.'&r='.$ref.'" id="store" onclick="calc(\''.$store['id'].'\')" target="_blank"><span class="result">'.$name.'<span class="return">'.$return.'</span></span></a><br/>');
			}
		}
		else
		{
			if($ref == "")
			{
				echo ('<a href="r?i='.$store['id'].'&a='.$abrv.'" target="_blank" id="store" onclick="calc(\''.$store['id'].'\')"><span class="result">'.$name.'<span class="return">'.$return.'</span></span></a><br/>');
			}
			else
			{
				echo ('<a href="r?i='.$store['id'].'&a='.$abrv.'&r='.$ref.'" id="store" onclick="calc(\''.$store['id'].'\')" target="_blank"><span class="result">'.$name.'<span class="return">'.$return.'</span></span></a><br/>');
			}
		}
	}
?>

