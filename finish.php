<?php
	include 'php/click.php';

	$id = $_POST['id'];
	$cause = $_POST['cause'];
	$link = $_POST['link'];
	$nat = $_POST['nat'];
	$cat = $_POST['cat'];
	$abrv = $_POST['abrv'];
	$aid = $_POST['aid'];
	$code = "";
	
	// Connects to Database
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("causes") or die("Couldnt find database");
	
	$str = str_replace("%"," ",$cause);
	$str = str_replace("'","#",$str);
	
	$query = mysql_query('INSERT INTO causes VALUES ("", "'.$str.'", "'.$link.'", "'.$abrv.'", "'.$code.'","'.$aid.'", "'.$nat.'", "null", "'.$cat.'", "")');
	
	$query = mysql_query("DELETE FROM temp WHERE id='$id'");
	
	$q = mysql_query("SELECT id FROM causes ORDER BY id DESC LIMIT 1");
	
	while($e = mysql_fetch_array($q))
	{
		$highId = $e['id'];
		do
		{
			srand($highId);
			$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
			$string = '';
			
			for ($i = 0; $i < 6; $i++) 
			{
				$string .= $characters[rand(0, strlen($characters) - 1)];
			}
			
			$q3 = mysql_query("SELECT code FROM causes WHERE code='$string'");
			
			if(mysql_num_rows($q3) != 0)
			{
				$highId = $e['id'].'1';
			}
		}
		while(mysql_num_rows($q3) != 0);

		$q2	= mysql_query("UPDATE causes SET code='$string' WHERE id='$highId'");
	}

	echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
		<html>
		<head>
			<title>Jatna - Add</title>
			<link rel="SHORTCUT ICON" href="images/favicon.ico">
			<script type="text/javascript">
				alert("'.$str.' was added.");
				window.location = "http://jatna.com/";
			</script>
		</head>
		</html>';

?>