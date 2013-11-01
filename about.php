<?php
	include 'php/click.php';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="description" content="Jatna is an online fundraising platform that makes fundraising for charities, schools, churches, spiritual groups, clubs, events, non-profit organizations, and for-profit organizations very simple. Jatna is free and easy to use."/>
	<meta name="keywords" content="about,jatnaabout,jatna,jatna.com,fundraising,online fundraising,team fundraising,fundraising ideas,fundraiser,community,free,donate,simple,charity,school,donation,cause,nonprofit,unique,church,fund,simple fundraising,charity fundraising,school fundraising,donation fundraising,cause fundraising,nonprofit fundraising,unique fundraising,church fundraising,fund fundraising"/>
	<title>Jatna - About</title>
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
		<p>Jatna is an online fundraising platform that makes fundraising for charities, schools, churches,
		spiritual groups, clubs, events, non-profit organizations, and for-profit organizations very
		simple. Jatna is free and easy to use.</p>
		<p>Here’s how it works…</p>
		<p>Thousands of online stores (like Amazon.com, iTunes, etc.) offer commissions to websites (like
		Jatna) for bringing them internet shoppers (like you). Rather than keeping the commissions
		generated from your online purchases, Jatna shares these commissions with your favorite
		charities, schools, churches, spiritual groups, clubs, events, non-profit organizations, and for-
		profit organizations.</p>
		<p>It's quick and easy to find a cause or to add a cause that you’d like to support.</p>
		<p>From the Jatna home page, search for the cause that you’d like to support. When you find it,
		click on it, and you’ll be directed to their Jatna fundraising page. From there, you can find over
		3,000 online stores that are partnered with Jatna. Commissions generated from your online
		shopping trips will be shared with the your cause of choice. It’s that easy!</p>
		<p>(If you don’t find your cause on our home page, no problem, just add it by clicking "Add a Cause" on the homepage.)</p>
		<p>If you want to learn more, specifically on how to use Jatna, see the diagram and instructions below. Alternatively, you can click "Walkthrough" on the homepage to get a step by step explanation.</p>
		<center><img src="images/howto/works.png" id="works" alt="How Jatna Works"/></center>
		<p>Fundraising through Jatna can be simplfied into 4 steps:</p>
			<ol>
				<li><b>Go to Jatna.</b></li>
				<li><b>Choose a cause you would like to support.</b></li>
					- Causes are listed in the box on the homepage.
					<br/>
					- The search box allows you to search for a cause.
					<br/>
					- If you do not find your cause you may click the "Add A Cause" button.
					<br/>
					- Simply click the cause you would like to support to continue.
				<li><b>Select a store you would like to shop through.</b></li>
					- Like on the homepage, stores are listed in the central box.
					<br/>
					- To shop through that store, click the name of the store.
					<br/>
					- The percentages/dollar amounts listed to the right are the amount the cause will receive of your final purchase.
				<li><b>Shop.</b></li>
			</ol>
		<br/>
		<!--<div class="fb-like" data-href="https://www.facebook.com/JatnaFundraise" data-send="false" data-layout="button_count" data-width="450" data-show-faces="false" data-font="trebuchet ms"></div>-->
		<?
			include 'php/address.php';
		?>
	</div>
</body>
</html>