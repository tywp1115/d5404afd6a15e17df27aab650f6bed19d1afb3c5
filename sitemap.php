<?php
	echo '<?xml version="1.0" encoding="UTF-8"?>';
	echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
	
	$connect = mysql_connect("host", "username", "password") or die("Couldnt Connect");
	mysql_select_db("causes") or die("Couldnt find database");	
	
	$causes = mysql_query("SELECT name,code FROM causes ORDER BY name");
	
	echo '<url><loc>http://jatna.com/about</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>';
	echo '<url><loc>http://jatna.com/add</loc><changefreq>weekly</changefreq><priority>0.6</priority></url>';
	echo '<url><loc>http://jatna.com/contact</loc><changefreq>weekly</changefreq><priority>0.6</priority></url>';
	echo '<url><loc>http://jatna.com/example</loc><changefreq>weekly</changefreq><priority>0.2</priority></url>';
	echo '<url><loc>http://jatna.com/faq</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>';
	echo '<url><loc>http://jatna.com/howto</loc><changefreq>weekly</changefreq><priority>0.7</priority></url>';
	echo '<url><loc>http://jatna.com/</loc><changefreq>weekly</changefreq><priority>1.0</priority></url>';
	echo '<url><loc>http://jatna.com/list</loc><changefreq>weekly</changefreq><priority>0.6</priority></url>';
	echo '<url><loc>http://jatna.com/resources</loc><changefreq>weekly</changefreq><priority>0.6</priority></url>';
	
	while($c = mysql_fetch_array($causes))
	{
		echo '<url><loc>http://jatna.com/c?c='.$c['code'].'</loc><changefreq>monthly</changefreq><priority>0.4</priority></url>';
	}

	echo '</urlset>';
?>