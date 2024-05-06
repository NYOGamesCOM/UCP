<?php
header('Content-Type: image/png');
$img = imagecreatefromjpeg('http://ap-rp.com/assets/img/map.jpg');
$red = imagecolorallocate($img, 255, 0, 0);
if(isset(Config::$_url[1]) && isset(Config::$_url[2])) 
{
	$x = (int)Config::$_url[1];
	$y = (int)Config::$_url[2];
	
	$x = $x/7.5;
	$y = $y/7.5;
	
	$x = $x + 400;
	$y = -($y - 400);
	
	imagefilledrectangle($img, $x, $y, $x+10, $y + 10, $red);
}
imagepng($img);
imagedestroy($img);
?>