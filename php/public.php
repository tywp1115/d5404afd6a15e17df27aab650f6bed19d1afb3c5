<?php
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("stores") or die("Couldnt find database");
	
	// Prevent all stores with the $ban string in their name from appearing on the random list of stores
	
	$ban = "sex";
	mysql_query("UPDATE stores SET public='0' WHERE name LIKE '%$ban%'");
	$ban = "adult shop";
	mysql_query("UPDATE stores SET public='0' WHERE name LIKE '%$ban%'");
	$ban = "adult store";
	mysql_query("UPDATE stores SET public='0' WHERE name LIKE '%$ban%'");
	$ban = "adult toys";
	mysql_query("UPDATE stores SET public='0' WHERE name LIKE '%$ban%'");
	$ban = "erotic";
	mysql_query("UPDATE stores SET public='0' WHERE name LIKE '%$ban%'");
	echo "Done.";
?>