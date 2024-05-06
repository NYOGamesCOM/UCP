<?php
if(!defined('AWM'))
	die('Nope.');

header('Content-Type: image/png');
$im = imagecreatefrompng('assets/img/signature2.png');

$color = imagecolorallocate($im, 255, 255, 255);

$color1 = imagecolorallocate($im, 245, 5, 5);

$color2 = imagecolorallocate($im, 62, 191, 36);

$font = 'assets/fonts/signature_font.ttf';

$q = Config::$g_con->prepare('SELECT * FROM PlayerInfo WHERE SQLID = ?');
$q->execute(array((int)Config::$_url[1]));



$data = $q->fetch(PDO::FETCH_OBJ);


imagettftext($im, 9, 0, 55, 15, $color, $font, 'Name: ' . $data->PlayerName);
imagettftext($im, 9, 0, 55, 29, $color, $font, 'Status: ');
imagettftext($im, 9, 0, 95, 29, $color1, $font, $data->Online ? '' : 'Offline');
imagettftext($im, 9, 0, 95, 29, $color2, $font, $data->Online ? 'Online' : '');
imagettftext($im, 9, 0, 190, 15, $color, $font, 'Level: ' . $data->level); 
imagettftext($im, 9, 0, 190, 29, $color, $font, 'Hours played: ' . $data->TotalPlayTime); 
imagettftext($im, 9, 0, 325, 15, $color, $font, 'Phone: ' . $data->PhoneNumber); 
imagettftext($im, 9, 0, 325, 29, $color, $font, 'Warns: ' . $data->Warns . '/3');

	
imagepng($im);
imagedestroy($im);