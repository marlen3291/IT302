<?php # Script 18.6 - who_logged_in.php
// This is the administration page to see who logged in for the site.
require ('includes/config.inc.php');
$page_title = 'View Users';
include ('includes/header.html');

echo "<h1>View Users</h1>";

//if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

	

	// Need the database connection:
	require (MYSQL);
	
	// Trim all the incoming data:
	$trimmed = array_map('trim', $_POST);

	
	if ($_SESSION['user_level'] == 1 && isset($_SESSION['user_id'])){
	
	//Select everything from users
	$q = "SELECT * FROM users";
	
	
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));
	
    echo "<table>";
	echo "<tbody>";
	echo "<tr>";
	
	echo "<th>User ID</th>";
	echo "<th>First Name</th>";
	echo "<th>Last Name</th>";
	echo "<th>Email</th>";
	echo "<th>User Level</th>";
	echo "<th>Registration Date</th>";
	echo "<th>Last Login Date</th>";
	
	echo "</tr>";
	
	while($row = mysqli_fetch_array($r))
	{
		
	$user_id = $row["user_id"];
	$first_name = $row["first_name"];
	$last_name = $row["last_name"];
	$email = $row["email"];
	$user_level = $row["user_level"];
	$registration_date = $row["registration_date"];
	$last_logged_in = $row["last_logged_in"];
	
	
	
	echo "<tr>";

		echo "<td>" .	$user_id	.	"</td>"	;
		echo "<td>" .	$first_name	.	"</td>"	;
		echo "<td>" .	$last_name	.	"</td>"	;
		echo "<td>" .	$email.	"</td>"	;
		echo "<td>" .	$user_level	.	"</td>"	;
		echo "<td>" .	$registration_date	.	"</td>"	;
		echo "<td>" .	$last_logged_in	.	"</td>"	;
		
		
		echo "</tr>";
	
	
	
	}
	echo "</tbody>";
	echo "</table>";
	
	
	
	}
	
	else
	{
	
	$url = BASE_URL . 'index.php';
	
	ob_end_clean();
	header("Location: $url");
	exit();
	}
	
mysqli_close($dbc);

 // End of the main Submit conditional.
?>

<style>
table, th, tr, td
{
    border-style: solid;
    border-width: 1px;
}

</style>
	


<!--
<form action="who_logged_in.php" method="post">
	<fieldset>
	
	
	<p><b>Email Address:</b> <input type="text" name="email" size="20" maxlength="60" /></p>
	<p><b>Password:</b> <input type="password" name="pass" size="20" maxlength="20" /></p>
	
	
	<p><b>Hours:</b> <input type="text" name="hours" size="20" maxlength="60" value=1 /></p>
	<p><b>Minutes:</b> <input type="text" name="minutes" size="20" maxlength="60" value=0 /></p>
	<p><b>Seconds:</b> <input type="text" name="seconds" size="20" maxlength="60" value=0 /></p>

	
	<div align="center"><input type="submit" name="submit" value="Submit" /></div>
	</fieldset>
</form>
-->

<?php include ('includes/footer.html'); ?>