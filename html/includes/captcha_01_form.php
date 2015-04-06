<?php 

session_start();

?>

<!--  must be run under web.njit.edu -->


<!DOCTYPE html>

<form method="post" action="">


<br><br>

<img id="captchaimage"  src="includes/captcha_01_image.php"  >

<br><br><br><br>

<input type="text" 		  name="captcha"   size = 40
       autocomplete="off" placeholder="What do you see?"><br><br><br>
<!--	  
<input type="text" 		  size = 40
	   value="$_SESSION['captcha'] = <?php  echo $_SESSION["captcha"] ; ?>" >
<br><br><br>
-->

<input type="submit" value="Submit">

</form><br><br>


<?php

//echo "<br> SESSION[captcha] is: " . $_SESSION["captcha"] ;

if( isset($_POST["captcha"]) )
{	
  	echo "<br> POST[captcha] is: 	" . $_POST["captcha"] . "<br><br>" ;
	
	if($_SESSION["captcha"]==$_POST["captcha"])
	{	
		$_SESSION["captcha_passed"] = TRUE;
	//echo 'Should redirect at this point.<br>
		//	  CAPTCHA guess is valid. <br>Proceed with your task message.';	
		ob_end_clean();
		header('Location: '.$_SERVER['REQUEST_URI']);
		exit;
	}
	
	else
	
	{	
	$_SESSION["captcha_passed"] = FALSE;
	echo 'CAPTHCA guess is wrong. <br>Try again. 
	          We stay on self_submit page.';	
	}
	
	if($_SESSION["captcha_passed"] == FALSE)
	{
	exit;
	}
}

else
{
	
exit;	
}

?>