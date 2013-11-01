<?php
$id = $_GET['i'];
$idc = $_GET['a'];
$tmp = $_GET['t'];
	
$connect = mysql_connect("mysql", "Jatna", "ZIA1YOKO2") or die("Couldnt Connect");

mysql_select_db("stores") or die("Couldnt find database");
$stores = mysql_query("SELECT name FROM stores WHERE id='$id'");
$store = mysql_fetch_array($stores);
	
mysql_select_db("causes") or die("Couldnt find database");
if($tmp == "")
{
	$causes = mysql_query("SELECT name FROM causes WHERE code='$idc'");
}
else
{
	$causes = mysql_query("SELECT name FROM temp WHERE code='$tmp'");
}
$cause = mysql_fetch_array($causes);
	
$sname = $store['name'];
$cname = $cause['name'];
	
$img = imagecreatefrompng("template.png");

$gray = imageColorAllocate($img, 135, 135, 135);
$font = 'trebuc.ttf';

$bbox=imagettfbbox(20,0,$font,$cname);
$textWidth=$bbox[2]-$bbox[0];
$z=$bbox[2]/2;
$x=340-$z;
$y=266;
imagettftext($img, 20, 0, $x+2, $y+2, $gray, $font, $cname);

$bbox=imagettfbbox(20,0,$font,$sname);
$textWidth=$bbox[2]-$bbox[0];
$z=$bbox[2]/2;
$x=340-$z;
$y=376;
imagettftext($img, 20, 0, $x+2, $y+2, $gray, $font, $sname);

header( "Content-type: image/png" );
imagepng( $img );
?>