To easily understand the files, I have listed the basic purpose of each one below.

------------------------------------

root (dir)
	track.php
		Generates graphs about usage statistics. Includes daily page views, monthly page views, device usage, browser usage, international view statistics and United States usage statistics.
	sitemap.php
		INDEV - Generates a site map of the dynamic pages for search engine optimization
	resources.php
		Provides tools and images for causes or individuals to promote Jatna.
	r.php
		After a 3 second countdown, the store link is opened in a new page and r.php redirects to calc.php
	list.php
		INDEV - Generates a list of all the causes and stores on Jatna
	jatna2u.php
		Explains the service "Jatna2U". Jatna2U is a simplified version of Jatna that causes can imbed in their websites.
	index.php
		Landing page. Has a searchable list of all causes on Jatna.
	i.php
		The page that is imbedded when Jatna2U is used.
	howto.php
		Provides a basic explanation of how Jatna works and how to use it
	finish.php
		Finalizes the addition process
	faq.php
		Frequently asked questions
	e.php
		When the user uses the chrome extension, e.php is where they select the cause they would like to support. It then redirects back to their store.
	done.php
		add.php redirects to done.php. This page adds the cause the user added to the temporary causes table and then sends an email to me to alert me that a new cause was added.
	contact.php
		Provides Jatna's contact information
	calc.php
		A tool that appears after a user has chosen a store to shop at. It prompts the user for how much they spent and provides the approximate amount that was donated to charity.
	c.php
		The cause page. It populates with data from the database and formulates a searchable list of all the stores.
	add.php
		Page that allows a user to add a cause to Jatna. Until the cause is confirmed by me, it appears as a "temporary" cause in the search box. The "temporary" causes only appear for the IP that added them until I confirm the cause.
	about.php
		Provides information about Jatna
css (dir)
	t,d (dir)
		style.css
			CSS that is universal to every Jatna page
		resources.css
			CSS for resources.php
		list.css
			CSS for list.php
		index.css
			CSS for index.php
		imbd.css
			CSS for i.php
		howto.css
			CSS for howto.php
		count.css
			CSS for the countdown timer on r.php
		cause.css
			CSS for c.php
		calci.css
			CSS for calc.php if the user came from the Chrome Extension
		calc.css
			CSS for calc.php if the user did not come from the Chrome Extension
		add.css
	t
		CSS styling for tablets and mobile devices
	d
		CSS styling for desktops
javascript
	search.js
		Javascript file that provides the AJAX required for searching
	list.js
		Javascript file that provides the AJAX required for the cause and store lists (list.php)
php
	resources
		jatna2u.php
			Echos the Jatna2U text for resources.php
		images.php
			Echos the Images text for resources.php
		chrome.php
			Echos the Chrome Extension text for resources.php
	storesearch.php
		Sends a query the store database for the user's search input and echos the results
	public.php
		Sensors out all "adult" stores from appearing on the random store list on c.php
	lists.php
		Echos the list of stores for list.php
	listc.php
		Echos the list of causes for list.php
	image.php
		Download script for downloading images in resources.php
	e.php
		Generates a list of causes for the Chrome Extension. This file is where the Chrome Extension checks to see if a store is on Jatna
	click.php
		Included in nearly every page. This file gathers statistics on the usage including the date of usage, the number of clicks, the browser, the country, the state and the city.
	causesearche.php
		causesearch.php for the Chrome Extension
	causesearch.php
		Sends a query the cause database for the user's search input and echos the results
	address.php
		Included on nearly every page. Generates a footer. This includes the email, links to pages, the motto and links to Facebook and Twitter.
chrome extension
	popup.js
		Required for proper functioning of the popup
	jquery.js
		Includes jQuery
	jquery.jgrowl.js
		Includes jGrowl (http://stanlemon.net/2013/03/16/jgrowl-1-2-11/)
	contentscript.js
		Checks to see if the site is on Jatna and alerts the user
	background.js
		Ensures that the jGrowl does not popup if the user went through Jatna
	popup.html
		Popup page when the "leaf" icon is clicked
	background.html
		Includes background.js and jquery.js
	manifest.json
		Main file required for all Chrome Extension. Indicates the contentscript.js and background.js
	jquery.jgrowl.css
		CSS required for jGrowl to look nice