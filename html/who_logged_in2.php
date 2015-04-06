<?php # Script 18.6 - who_logged_in.php
// This is the administration page to see who logged in for the site.
require ('includes/config.inc.php');
$page_title = 'Login Logs';
include ('includes/header.html');

echo "<h1>Login Logs</h1>";

if ($_SESSION['user_level'] == 1 && isset($_SESSION['user_id'])){
	
	
}

else
	{
	
	$url = BASE_URL . 'index.php';
	
	ob_end_clean();
	header("Location: $url");
	exit();
	}
?>


	
<!--<h1>Login Logs</h1>-->
<br>

<!--<form action="who_logged_in2.php" > 

<!--  	Associated display field for slide event handler 
		Make readonly to protect its value which is seet by slide event
		on associated slider.
-->
<p>Check who logged in within a certain number of hours</p>
<p>Slide to select hours</p>
<br>

<div id="slide_me"></div>
<br>

<input type=text id="associated" >
<input type=text id="associatedchange" >
<br><br>

<div id="B" >DIV CONTENTS GO HERE</div>
<!--  HTML UI slider reference 
	A style has been added in head to determine width.
-->

<br><br>

<!-- Rendered via $("#submit").button(); above
<input type="submit" id="submit" value = "Nice" /> 
</form>
-->


<?php include ('includes/footer.html'); ?>