<?php # Script 18.5 - index.php
// This is the main page for the site.

// Include the configuration file:
require ('includes/config.inc.php'); 

// Set the page title and include the HTML header:
$page_title = 'Welcome to this Site!';
include ('includes/header.html');

if($_SESSION["captcha_passed"] != TRUE || !isset($_SESSION["captcha_passed"]))
{
include ('includes/captcha_01_form.php');
}
// Welcome the user (by name if they are logged in):
echo '<h1>Welcome';
if (isset($_SESSION['first_name'])) {
	echo ", {$_SESSION['first_name']}";
}
echo '!</h1>';
?>
<p>Spam spam spam spam spam spam
spam spam spam spam spam spam 
spam spam spam spam spam spam 
spam spam spam spam spam spam.</p>
<p>Spam spam spam spam spam spam
spam spam spam spam spam spam 
spam spam spam spam spam spam 
spam spam spam spam spam spam.</p>

<?php include ('includes/footer.html'); ?>