<?php
	mysql_connect("host", "username", "password") or die("Couldnt Connect");	
	
	$lastLetter = '';
	$currLetter = '';
	$echo = '';
	$num = true;
	
	mysql_select_db("causes") or die("Couldnt find database");

	$cs = mysql_query("SELECT * FROM causes ORDER BY name");

	while($c = mysql_fetch_array($cs))
	{
		$currLetter =   strtoupper(substr($c['name'],0,1));
		
		if($lastLetter != $currLetter && !is_numeric($currLetter))
		{
			$echo .= '<br/><a name="'.$currLetter.'" class="anchor"/><b>'.$currLetter.'</b><a class="arrow" href="#">&#8679;</a><br/>';
			$lastLetter = $currLetter;
		}
		else if(is_numeric($currLetter) && $currLetter == '1' && $num)
		{
			$echo .= '<br/><a name="1" class="anchor"/><b>1-9</b><a class="arrow" href="#">&#8679;</a><br/>';
			$lastLetter = $currLetter;
			$num = false;
		}
		
		$echo .= '<a href="c?c='.$c['code'].'" class="anchor">'.$c['name'].'</a><br/>';
	}
	
	echo $echo;
?>