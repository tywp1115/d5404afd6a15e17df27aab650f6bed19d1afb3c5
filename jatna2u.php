<?php
	include 'php/click.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="description" content="Jatna is an online fundraising platform that makes fundraising for charities, schools, churches, spiritual groups, clubs, events, non-profit organizations, and for-profit organizations very simple. Jatna is free and easy to use."/>
	<meta name="keywords" content="jatna2u,jatnaabout,jatna,jatna.com,fundraising,online fundraising,team fundraising,fundraising ideas,fundraiser,community,free,donate,simple,charity,school,donation,cause,nonprofit,unique,church,fund,simple fundraising,charity fundraising,school fundraising,donation fundraising,cause fundraising,nonprofit fundraising,unique fundraising,church fundraising,fund fundraising"/>
	<title>Jatna - Jatna2U</title>
	<link href="css/d/classic.css" rel="stylesheet" type="text/css">
	<link href="css/d/style.css" rel="stylesheet" type="text/css">
	<link rel="SHORTCUT ICON" href="images/favicon.ico">
</head>
<body>
	<div id="fb-root"></div>
	<script>
		// Facebook Like Button - To be implemented
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=131700514842";
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>
	<div id="content">
		<a href="/"><img src="images/logosmall.png" id="logo" alt="Jatna"/></a>
		<h2>Jatna2U</h2>
		
		<p>Jatna2U allows you to embed Jatna in your website or in an email.<b>*</b>  Always loaded with up-to-date data, this page allows the user to shop online and donate to your cause directly from your website.  Give this HTML code to your web developer to implement into your website.</p>
		
		<code>&#60;iframe src="http://jatna.com/i?c=xxxxxxxx" width="700" height="366"&#62;&#60;/iframe&#62;</code>
		
		<p>Replace "<code>xxxxxxxx</code>" with the code for your charity.  This code can be found by going to your charity\'s Jatna page and getting the 8 character section of the url after "<code>c?c=</code>".</p>
		
		<p>The width and height attributes are adjustable.</p>
		
		<p><b>*</b> <code>iframe</code> compatiability in emails is very limited.  Although some email services display iframes, most do not.  Although doable, we discourage embedding Jatna in emails.</p>
		
		<p>Here is Jatna2U embedded into this page.</p>
		
		<iframe src="http://jatna.com/i?c=429aa7bf" width="700" height="366"></iframe>
		
		<br/>
		<!--<div class="fb-like" data-href="https://www.facebook.com/JatnaFundraise" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="trebuchet ms"></div>-->
		<?
			include 'php/address.php';
		?>
	</div>
</body>
</html>