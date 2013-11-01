<?php
	$location = $_GET['l'];
	$id = $_GET['i'];
	$cause = $_GET['c'];
	
	mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("stores") or die("Couldnt find database");
	
	if($location)
	{
	
		$stores = mysql_query("SELECT id FROM stores WHERE home LIKE '%$location%' LIMIT 1");
	
		$store = mysql_fetch_array($stores);
	
		echo $store['id'];
	}
	else
	{
		$stores = mysql_query("SELECT p1,p2,a1,a2,currency FROM stores WHERE id='$id' LIMIT 1");
	
		$store = mysql_fetch_array($stores);
		
		$curType = '';
		$return = '';
	
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
		
		echo $return.'|';
	
		mysql_select_db("causes") or die("Couldnt find database");
		
		$causes = mysql_query("SELECT name FROM causes WHERE code='$cause' LIMIT 1");
	
		$cause = mysql_fetch_array($causes);
	
		echo $cause['name'];
	}
	
	
?>