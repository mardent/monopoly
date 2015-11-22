<?php
@session_start();

$font = 'captcha.ttf';
$width = 90;
$height = 50;

/* NOT CHANGE!!! */
if (
	(
		( !isset($_SESSION['captcha_session']) ) &&
		( empty($_SESSION['captcha_session']) )
	) or (
		( isset($_SERVER['QUERY_STRING']) ) &&
		( !empty($_SERVER['QUERY_STRING']) )
	)
) {
	$_SESSION['captcha_session'] = substr(md5(uniqid("")), 0, 5);
}

$char = $_SESSION['captcha_session'];

if ( !file_exists($font) ) {
	header("Cache-Control: no-cache, must-revalidate");
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
	header('Content-Type: image/png');
	echo base64_decode('iVBORw0KGgoAAAANSUhEUgAAAAEAAAABAQMAAAAl21bKAAAAA1BMVEUAAACnej3aAAAAAXRSTlMAQObYZgAAAApJREFUCNdjYAAAAAIAAeIhvDMAAAAASUVORK5CYII=');
}

$img = imagecreatetruecolor($width, $height);
imagealphablending($img, true);
$white = imagecolorallocate($img, 255, 255, 255);
$black = imagecolorallocate($img, 0, 0, 0);
imagefilledrectangle($img, 0, 0, $width-1, $height-1, $white);

imagettftext($img, 20, 0, 15, 35, $black, $font, $char);

$img2 = imagecreatetruecolor($width, $height);
imagefilledrectangle($img2, 0, 0, $width-1, $height-1, $white);

$frequency1 = mt_rand(700000, 1000000) / 15000000;
$frequency2 = mt_rand(700000, 1000000) / 15000000;
$frequency3 = mt_rand(700000, 1000000) / 15000000;
$frequency4 = mt_rand(700000, 1000000) / 15000000;
$phase1 = mt_rand(0, 3141592) / 1000000;
$phase2 = mt_rand(0, 3141592) / 1000000;
$phase3 = mt_rand(0, 3141592) / 1000000;
$phase4 = mt_rand(0, 3141592) / 1000000;
$amplitude1 = mt_rand(400, 600) / 100;
$amplitude2 = mt_rand(400, 600) / 100;

for ( $x=0; $x<$width; $x++ ) {
	for ( $y=0; $y<$height; $y++ ) {
		$sx = $x + ( sin($x*$frequency1+$phase1) + sin($y*$frequency3+$phase2) ) * $amplitude1;
		$sy = $y + ( sin($x*$frequency2+$phase3) + sin($y*$frequency4+$phase4) ) * $amplitude2;

		if ( $sx<0 || $sy<0 || $sx>=$width-1 || $sy>=$height-1 ) { 
			$color = 255;
			$color_x = 255;
			$color_y = 255;
			$color_xy = 255;
		} else {
			$color = (imagecolorat($img, $sx, $sy) >> 16) & 0xFF;
			$color_x = (imagecolorat($img, $sx + 1, $sy) >> 16) & 0xFF;
			$color_y = (imagecolorat($img, $sx, $sy + 1) >> 16) & 0xFF;
			$color_xy = (imagecolorat($img, $sx + 1, $sy + 1) >> 16) & 0xFF;
		}

		if ( $color==$color_x && $color==$color_y && $color==$color_xy ) {
			$newcolor=$color;
		} else {
			$frsx = $sx-floor($sx);
			$frsy = $sy-floor($sy);
			$frsx1 = 1-$frsx;
			$frsy1 = 1-$frsy;
			$newcolor = floor($color*$frsx1*$frsy1 + $color_x*$frsx*$frsy1 + $color_y*$frsx1*$frsy	+ $color_xy*$frsx*$frsy);
		}
		imagesetpixel($img2, $x, $y, imagecolorallocate($img2, $newcolor, $newcolor, $newcolor));
	}
}

header("Cache-Control: no-cache, must-revalidate");
header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header("Content-type: image/png");

imagepng($img2);

imagedestroy($img);
imagedestroy($img2);
