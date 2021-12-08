<?php
# Created 27 May, 2021
# Created by Dimitris Liberopoulos
# Script that shows information about selected services (for ntua_databases project) 

#initial menu bar and filter bar
$page_title = 'Sales';
include ('includes/header.html');
echo '<br><br>';
include ('includes/filters_ntua.html');
echo '<br>';


# show results

if (isset($_POST['submitted'])) {
	require_once ('../mysqli_connect.php');

	$srv = $_POST['services'];

	if (!isset($_POST['date']) and !isset($_POST['price']) and $srv == 'all') $q = "SELECT c.Last_name, c.First_name, TD_of_charge, s.Description, Charge FROM client AS c JOIN usage_of_services AS cs USING(NFC_ID) JOIN services AS s USING (Service_ID) ORDER BY s.Description";   // all

	elseif (!isset($_POST['date']) and !isset($_POST['price']) and $srv != 'all')  $q = "SELECT c.Last_name, c.First_name, TD_of_charge, s.Description, Charge FROM clients AS c JOIN usage_of_services AS cs USING(NFC_ID) JOIN services AS s USING (Service_ID) WHERE s.Description = '$srv' ORDER BY c.Last_name";     // all except service

	elseif (isset($_POST['date']) and !isset($_POST['price']) and $srv == 'all') {    // all except date
		$date = $_POST['date'];
	 	$q = "SELECT c.Last_name, c.First_name, TD_of_charge, s.Description, Charge FROM client AS c JOIN usage_of_services AS cs USING(NFC_ID) JOIN services AS s USING (Service_ID) WHERE 
	 	CONVERT(TD_of_charge, DATE) = '$date' ORDER BY s.Description ";    
	 }

	 elseif (!isset($_POST['date']) and isset($_POST['price']) and $srv == 'all') {    // all except price
		$price = $_POST['price'];
	 	$q = "SELECT c.Last_name, c.First_name, TD_of_charge, s.Description, Charge FROM client AS c JOIN usage_of_services AS cs USING(NFC_ID) JOIN services AS s USING (Service_ID) WHERE Charge <= '$price' ORDER BY s.Description";    
	 }

	 elseif (isset($_POST['date']) and !isset($_POST['price']) and $srv != 'all') {    // all except date and service
		$date = $_POST['date'];
	 	$q = "SELECT c.Last_name, c.First_name, TD_of_charge, s.Description, Charge FROM client AS c JOIN usage_of_services AS cs USING(NFC_ID) JOIN services AS s USING (Service_ID) WHERE 
	 	CONVERT(TD_of_charge, DATE) = '$date' AND s.Description = '$srv' ORDER BY c.Last_name";    
	 }

	 elseif (!isset($_POST['date']) and isset($_POST['price']) and $srv != 'all') {    // all except price and service
		$price = $_POST['price'];
	 	$q = "SELECT c.Last_name, c.First_name, TD_of_charge, s.Description, Charge FROM client AS c JOIN usage_of_services AS cs USING(NFC_ID) JOIN services AS s USING (Service_ID) WHERE Charge <= '$price' AND s.Description = '$srv' ORDER BY c.Last_name";    
	 }

	 elseif (isset($_POST['date']) and isset($_POST['price']) and $srv == 'all') {    // all except date and price
		$date = $_POST['date'];
		$price = $_POST['price'];
	 	$q = "SELECT c.Last_name, c.First_name, TD_of_charge, s.Description, Charge FROM client AS c JOIN usage_of_services AS cs USING(NFC_ID) JOIN services AS s USING (Service_ID) WHERE
	 	 CONVERT(TD_of_charge, DATE) = '$date' AND Charge <= '$price' ORDER BY s.Description";    
	 }

	 else {    // service date and price --> all specified
		$date = $_POST['date'];
		$price = $_POST['price'];
	 	$q = "SELECT c.Last_name, c.First_name, TD_of_charge, s.Description, Charge FROM client AS c JOIN usage_of_services AS cs USING(NFC_ID) JOIN services AS s USING (Service_ID) WHERE 
	 	CONVERT(TD_of_charge, DATE) = '$date' AND Charge <= '$price' AND s.Description= '$srv' ORDER BY c.Last_name";    
	 }

	 echo '<br>';

	 $r = mysqli_query($dbc, $q);
	 $num = mysqli_num_rows($r);

	 if ($num <= 0) echo "<h2>Nothing was found! Please change the filters and try again.</h2>";
	 else {

			 	echo '<table align="center" cellspacing="10" cellpadding="3" width="80%">
			<tr>
			<td align="left"><b>Last Name</b></td>
			<td align="left"><b>First Name</b></td>
			<td align="left"><b>T&D of use</b></td>
			<td align="left"><b>Service</b></td>
			<td align="left"><b>Cost</b></td>
			</tr>';

			while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
					echo '<tr>
					<td align="left">' . $row['Last_name'] . '</td>
					<td align="left">' . $row['First_name'] . '</td>
					<td align="left">' . $row['TD_of_charge'] . '</td>
					<td align="left">' . $row['Description'] . '</td>
					<td align="left">' . $row['Charge'] . '</td>
					</tr>';
			}

			echo '</table>';  // end of <table>
			mysqli_free_result($r);

	     }


	 mysqli_close($dbc); // closing the connection with MySQL
}  


include('includes/footer.html');
?>