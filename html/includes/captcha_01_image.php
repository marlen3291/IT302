<?php

session_start();


//SET ENVIROMENT VARIABLE FOR GD [WIDELY USED GRAPHICS LIBRARY]
putenv('GDFONTPATH=' . realpath('.') );

//NAME FONT TO USE  
$font = 'fonts/LaBelleAurore.ttf';

//SET content-type header FOR OUTPUT IMAGE
//SENT BEFORE ANY OTHER OUTPUT

header('Content-Type: image/png');

//CREATE IMAGE RECTANGLE
$im 	= imagecreatetruecolor(260, 40);

//CREATE SOME COLORS
$white 		= imagecolorallocate($im, 255, 255, 255);
$greyish 	= imagecolorallocate($im, 215, 215, 215);
$black 		= imagecolorallocate($im, 0, 0, 0);

imagefilledrectangle($im, 3, 3, 255, 34, $greyish);

//function for generating random numbers
function _generateRandom($length=8)
{
	$_rand_src = array(
		  array(48,57)  //digits
		, array(97,122) //lowercase chars
  		, array(65,90)  //uppercase chars
        //above makes 3x2 array with values:
        //  48  57
        //  97  122
        //  65  90
	); 
	srand ( (double) microtime() * 1000000 );  
	//microtime gives msec epoch & (double) extracts the msec [microseconds] part
	//This sets the random "seed" for function rand( ) below
	//as of PHP4.2+ seed is not required but is instructive/useful
	
	$random_string = "";
	
	for($i=0;$i<$length;$i++){
		$i1=rand(0,sizeof($_rand_src)-1);
		$random_string .= chr(rand($_rand_src[$i1][0],$_rand_src[$i1][1]));
	}
	return $random_string;
} //end of function definition

$rand = _generateRandom(8);	
//CAPTCHA TEXT TO DRAW ON IMAGE
$text 	= $rand;

//SESSION VARIABLE SHARED WITH FORM SCRIPT
$_SESSION["captcha"] = $text;

//ADD SHADOW TO TEXT
imagettftext( $im, 20, 0, 16, 26, $white, $font, $text );



//ADD THE TEXT [OVERLAYS THE ABOVE 'SHADOW' TEXT!]
imagettftext( $im, 20, 0, 15, 25, $black, $font, $text );


//TRANSMIT IMAGE TO BROWSER. 
//USING IMAGEPNG() RESULTS IN CLEARER TEXT COMPARED WITH IMAGEJPEG()

imagepng($im);

//DESTROY SERVER-SIDE STORAGE FOR IMAGE

imagedestroy($im);




?>