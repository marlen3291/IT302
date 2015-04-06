<?php
session_start() ;

$font = 'fonts/LaBelleAurore.ttf';  //so realpath has trailing /

header('Content-Type: image/png');

$im 		= imagecreatetruecolor(260, 80);

$greyish 	= imagecolorallocate($im, 215, 215, 215);
imagefilledrectangle($im, 10, 10, 255, 34, $greyish);

$text 	= 'same';
$white 	= imagecolorallocate($im, 255, 255, 255);
$green  = imagecolorallocate($im, 0, 255, 0);
imagettftext( $im, 18, 5, 56, 26, $green, $font, $text );

$_SESSION["captcha"]=$text;

imagepng($im);

//CREATE SOME COLORS
$white 		= imagecolorallocate($im, 255, 255, 255);
$black 		= imagecolorallocate($im, 0, 0, 0);


//CAPTCHA TEXT TO DRAW ON IMAGE
$text 	= 'Testing...Goodbye';

//SESSION VARIABLE SHARED WITH FORM SCRIPT
$_SESSION["captcha"] = $text;

//ADD SHADOW TO TEXT
//imagettftext( $im, 20, 0, 16, 26, $white, $font, $text );

//ADD THE TEXT [OVERLAYS THE ABOVE 'SHADOW' TEXT!]
imagettftext( $im, 20, 0, 15, 25, $black, $font, $text );


//TRANSMIT IMAGE TO BROWSER. 
//USING IMAGEPNG() RESULTS IN CLEARER TEXT COMPARED WITH IMAGEJPEG()

imagepng($im);

//DESTROY SERVER-SIDE STORAGE FOR IMAGE

imagedestroy($im);

?>
