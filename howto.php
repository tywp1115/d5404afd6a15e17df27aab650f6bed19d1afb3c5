<?php
	include 'php/click.php';
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
	<meta name="description" content="Learn how to Jatna: go to Jatna, choose a cause, select a store and earn money for your cause!"/>
	<meta name="keywords" content="how to,how to jatna,jatna,jatna.com,fundraising,online fundraising,team fundraising,fundraising ideas,fundraiser,community,free,donate,simple,charity,school,donation,cause,nonprofit,unique,church,fund,simple fundraising,charity fundraising,school fundraising,donation fundraising,cause fundraising,nonprofit fundraising,unique fundraising,church fundraising,fund fundraising"/>
	<title>Jatna - How to Jatna</title>
	<link href="css/d/classic.css" rel="stylesheet" type="text/css">
	<link href="css/d/style.css" rel="stylesheet" type="text/css">
	<link href="css/d/howto.css" rel="stylesheet" type="text/css">
	<link rel="SHORTCUT ICON" href="images/favicon.ico">
</head>
<body>
	<div id="content">
		<a href="/"><img src="images/logosmall.png" id="logo" alt="Jatna"/></a>
		<center><h2>How to Jatna</h2></center>
		<a href="/"><img src="images/howto/works.png" id="works" alt="How Jatna Works"/></a>
		<br/>
		<form>
			<center><input type="button" name="addCharity" id="addCharity" value="Add a Cause" onclick="window.location.href='/add'"/></center>
		</form>
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
		<?
			include 'php/address.php';
		?>
	</div>
</body>
</html>