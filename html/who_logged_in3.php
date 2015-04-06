<?php
require ('includes/config.inc.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Handle the form.

	

	// Need the database connection:
	require (MYSQL);
	
	// Trim all the incoming data:
	//$trimmed = array_map('trim', $_POST);

	
	/*
	// Assume invalid values:
	$ht = FALSE;
	
	// Check for hours
	if (preg_match ('/^\d{1,4}$/i', $trimmed['hours'])) {
		$h = mysqli_real_escape_string ($dbc, $trimmed['hours']);
		$ht = TRUE;
	} else {
		echo '<p class="error">Please enter the amount of hours within 1 to 4 digits!</p>';
	}
	
	*/
	$h = $_POST["u"];
	
	sleep(2);

	print "These are the users who logged on in the last " . $h . " hours: <br><br>" ;
	
	//$ht = TRUE;
	
	//if ($ht) { // If everything's OK.

	//Convert input hours into seconds
	$hc =$h*3600;
	

	
	//Selects users within inputted time
	$q = "SELECT * FROM users WHERE UNIX_TIMESTAMP() - UNIX_TIMESTAMP(`last_logged_in`) < $hc";
	
	
	$r = mysqli_query ($dbc, $q) or trigger_error("Query: $q\n<br />MySQL Error: " . mysqli_error($dbc));

    echo "<table>";
	echo "<tbody>";
	echo "<tr>";
	
	echo "<th>First Name</th>";
	echo "<th>Last Name</th>";
	echo "<th>Email</th>";
	echo "<th>Login Date</th>";
	echo "<th>Time Elapsed Since Last Login</th>";
	
	echo "</tr>";
	
	while($row = mysqli_fetch_array($r))
	{
	$first_name = $row["first_name"];
	$last_name = $row["last_name"];
	$email = $row["email"];
	$last_logged_in = $row["last_logged_in"];
	
	$time_last = time() - strtotime($last_logged_in);
	
	$htime_last = floor($time_last/3600);
	$break_time_last = $time_last%3600;
	$mtime_last = floor($break_time_last/60);
	$stime_last = $break_time_last%60;
	
	echo "<tr>";

		echo "<td>" .	$first_name	.	"</td>"	;
		echo "<td>" .	$last_name	.	"</td>"	;
		echo "<td>" .	$email.	"</td>"	;
		echo "<td>" .	$last_logged_in	.	"</td>"	;
		echo "<td>" .   $htime_last . " hours " . $mtime_last . " minutes " . $stime_last . " seconds";
		//echo "<td>" .   $unix	.	"</td>";
		
		echo "</tr>";
	
	
	
	}
	echo "</tbody>";
	echo "</table>";
	
	
	
	
	
mysqli_close($dbc);


} // End of the main Submit conditional.


?>