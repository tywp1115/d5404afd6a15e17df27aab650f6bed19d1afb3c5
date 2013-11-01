<?php
	// Detect Device
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
	
	echo '<div id="address">Jatna<br/>';
	
	if($browser != 'desktop')
	{
		echo '<a href="mailto:fundraising@jatna.com">fundraising@jatna.com</a>';
	}
	else
	{
		echo 'fundraising@jatna.com';
	}

	echo'<br/><a href="/about">About</a> &#8226; <a href="/faq">FAQ</a> &#8226; <a href="/howto">How To</a> &#8226; <a href="/resources">Resources</a> &#8226; <a href="/list">Partners</a> &#8226; <a href="/jatna2u">Jatna2U</a>  &#8226; <a href="/contact">Contact</a><br/><span id="motto">Donating <span style="font-family: calibri">&</span> Fundraising : Simple <span style="font-family: calibri">&</span> Free</span><br/><a href="https://www.facebook.com/JatnaFundraise" target="_blank" title="Jatna on Facebook"><img src="../images/social/facebook.png" height="25px"/></a><a href="https://twitter.com/#!/JatnaFundraise" target="_blank" title="Jatna on Twitter"><img src="../images/social/twitter.png" height="25px"/></a></div>';
?>