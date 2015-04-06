<?php # Script 18.6 - register.php
// This is the registration page for the site.
require ('includes/config.inc.php');
$page_title = 'Register';
include ('includes/header.html');

if($_SESSION["captcha_passed"] != TRUE)
{
include ('includes/captcha_01_form.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

	// Need the database connection:
	require (MYSQL);
	
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	// Assume invalid values:
	$fn = $ln = $e = $p = $sq = $sa = FALSE;
	
	// Check for a first name:
	if (preg_match ('/^[A-Z \'.-]{2,20}$/i', $trimmed['first_name'])) {
		$fn = mysqli_real_escape_string ($dbc, $trimmed['first_name']);
	} else {
		echo '<p class="error">Please enter your first name!</p>';
	}

	// Check for a last name:
	if (preg_match ('/^[A-Z \'.-]{2,40}$/i', $trimmed['last_name'])) {
		$ln = mysqli_real_escape_string ($dbc, $trimmed['last_name']);
	} else {
		echo '<p class="error">Please enter your last name!</p>';
	}
	
	// Check for an email address:
	if (filter_var($trimmed['email'], FILTER_VALIDATE_EMAIL)) {
		$e = mysqli_real_escape_string ($dbc, $trimmed['email']);
	} else {
		echo '<p class="error">Please enter a valid email address!</p>';
	}

	// Check for a password and match against the confirmed password:
	if (preg_match ('/^\w{4,20}$/', $trimmed['password1']) ) {
		if ($trimmed['password1'] == $trimmed['password2']) {
			$p = mysqli_real_escape_string ($dbc, $trimmed['password1']);
		} else {
			echo '<p class="error">Your password did not match the confirmed password!</p>';
		}
	} else {
		echo '<p class="error">Please enter a valid password!</p>';
	}
	
	// Check for a security question:
	

	if (preg_match ('/^(?!\s*$).+/', $trimmed['security_question'])) 
	
	{
		
		
		$sq = mysqli_real_escape_string ($dbc, $trimmed['security_question']);
		
	} else {
		echo '<p class="error">Please select a security question!</p>';
		
		
	}
	
	
	// Check for a security answer:
	if (preg_match ('/^(?!\s*$).+/', $trimmed['security_answer'])) {
		$sa = mysqli_real_escape_string ($dbc, $trimmed['security_answer']);
		
	} else {
		echo '<p class="error">Please enter an answer to the security question!</p>';
	}
	
	
	
	if ($fn && $ln && $e && $p && $sq && $sa) { // If everything's OK...

		// Make sure the email address is available:
		$q = "SELECT user_id FROM users WHERE email='$e'";
		$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
		
		if (mysqli_num_rows($r) == 0) { // Available.

			// Create the activation code:
			$a = md5(uniqid(rand(), true));

			// Add the user to the database:
			$s= "INSERT INTO users (email, pass, first_name, last_name, active, registration_date, security_question, security_answer) VALUES ('$e', SHA1('$p'), '$fn', '$ln', '$a', NOW(), '$sq', '$sa' )";
			$t = mysqli_query ($dbc, $s) or trigger_error("Query: $s\n<br />MySQL Error: " . mysqli_error($dbc));

			if (mysqli_affected_rows($dbc) == 1) { // If it ran OK.

				// Send the email:
				$body = "Thank you for registering at <whatever site>. To activate your account, please click on this link:\n\n";
				$body .= BASE_URL . 'activate.php?x=' . urlencode($e) . "&y=$a";
				mail($trimmed['email'], 'Registration Confirmation', $body, 'From: admin@sitename.com');
				
				// Finish the page:
				echo '<h3>Thank you for registering! A confirmation email has been sent to your address. Please click on the link in that email in order to activate your account.</h3>';
				include ('includes/footer.html'); // Include the HTML footer.
				exit(); // Stop the page.
				
			} else { // If it did not run OK.
				echo '<p class="error">You could not be registered due to a system error. We apologize for any inconvenience.</p>';
			}
			
		} else { // The email address is not available.
			echo '<p class="error">That email address has already been registered. If you have forgotten your password, use the link at right to have your password sent to you.</p>';
		}
		
	} else { // If one of the data tests failed.
		echo '<p class="error">Please try again.</p>';
	}

	mysqli_close($dbc);

} // End of the main Submit conditional.
?>
	
<h1>Register</h1>
<form action="register.php" method="post">
	<fieldset>
	
	<p><b>First Name:</b> <input type="text" name="first_name" size="20" maxlength="20" value="<?php if (isset($trimmed['first_name'])) echo $trimmed['first_name']; ?>" /></p>
	
	<p><b>Last Name:</b> <input type="text" name="last_name" size="20" maxlength="40" value="<?php if (isset($trimmed['last_name'])) echo $trimmed['last_name']; ?>" /></p>

	<p><b>Email Address:</b> <input type="text" name="email" size="30" maxlength="60" value="<?php if (isset($trimmed['email'])) echo $trimmed['email']; ?>" /> </p>
		
	<p><b>Password:</b> <input type="password" name="password1" size="20" maxlength="20" value="<?php if (isset($trimmed['password1'])) echo $trimmed['password1']; ?>" /> <small>Use only letters, numbers, and the underscore. Must be between 4 and 20 characters long.</small></p>

	<p><b>Confirm Password:</b> <input type="password" name="password2" size="20" maxlength="20" value="<?php if (isset($trimmed['password2'])) echo $trimmed['password2']; ?>" /></p>
	
	<!-- A security question to use if user forgets password-->
	
	<p><b>Select a security question:</b> <select name="security_question">
	
   <option value="<?php if (isset($trimmed['security_question'])) echo $trimmed['security_question']; else echo ""; ?>"><?php if (isset($trimmed['security_question'])) echo $trimmed['security_question']; else echo "Select a security question";?></option>
   <option value="What was the name of your first pet?">What was the name of your first pet?</option>
    <option value="What's your favourite colour?">What's your favourite colour?</option>
    <option value="What's the name of the street you grew up in?">What's the name of the street you grew up in?</option>
    <option value="What's the name of your first grade teacher?">What's the name of your first grade teacher?</option>
  </select>
	
	<!-- Answer to the security question-->
	
	<p><b>Security Answer:</b> <input type="security_answer" name="security_answer" size="20" maxlength="20" value="<?php if (isset($trimmed['security_answer'])) echo $trimmed['security_answer']; ?>" /></p>
	
	<div align="center"><input type="submit" name="submit" value="Register" /></div>

</form>

<?php include ('includes/footer.html'); ?>