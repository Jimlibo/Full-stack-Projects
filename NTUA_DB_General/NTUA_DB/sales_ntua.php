<?php
# Created 26 May, 2021
# Created by Dimitris Liberopoulos
# Script that shows the sales for each service (for ntua_databases project) 

$page_title = 'Sales';
include ('includes/header.html');

if (isset($_POST['submitted'])) {
	require_once ('../mysqli_connect.php');     // connect to MySQL (database ntua_db)
	
	$srv = $_POST['services'];
	$check = "SELECT * FROM services_without_enrollment JOIN services AS s USING (Service_ID) WHERE s.Description = '$srv'";
	$rc = mysqli_query($dbc, $check);
	$numc = mysqli_num_rows($rc);
	mysqli_free_result($rc);

	if ($numc > 0) $q = "SELECT NFC_ID, TD_of_charge, Charge FROM usage_of_services AS cs JOIN services AS s USING (Service_ID) WHERE s.Description = '$srv'";
	else $q = "SELECT NFC_ID, TD_of_enrollment AS TD_of_charge, Charge FROM enroll_in_services JOIN services USING (Service_ID) WHERE Description = '$srv'";

	$r = mysqli_query($dbc, $q);
	$num = mysqli_num_rows($r);

	if ($num == 0) {
		echo '<br>';
		echo "<h2>No sales have been made yet!</h2>";
	} else {

		echo '<table align="center" cellspacing="10" cellpadding="3" width="80%">
	<tr>
	<td align="left"><b>Customers NFC ID</b></td>
	<td align="left"><b>Date & Time of charge</b></td>
	<td align="left"><b>Sum</b></td>
	</tr>';

	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			echo '<tr>
			<td align="left">' . $row['NFC_ID'] . '</td>
			<td align="left">' . $row['TD_of_charge'] . '</td>
			<td align="left">' . $row['Charge'] . '</td>
			</tr>';
	}

	echo '</table>';  // end of <table>
	mysqli_free_result($r);

	}

mysqli_close($dbc); // closing the connection with MySQL

include ('includes/footer.html');

} else {
	echo '<h1>Find the sales for each service!</h1>
<hr>
<p><big>All you have to do is select from below which service\'s sales you would like to see, and then click submit. A list with all the sales of the selected service will appear.</big></p>
<br>
<br>

<!-- drop-down list -->
<form action="sales_ntua.php" method="post">
  <label for="services"><big>Choose a service:</big></label>
  <select name="services" id="services">
    <option value="Drinks at bar">Drinks at bar</option>
    <option value="Food and drinks at restaurant">Food and drinks at restaurant</option>
    <option value="Hairdressing & Barbering">Hairdressing & Barbering</option>
    <option value="Gym usage">Gym usage</option>
    <option value="Sauna visit">Sauna visit</option>
    <option value="Conference room usage">Conference room usage</option>
    <option value="Stay in a room">Stay in a room</option>
  </select>
  <br><br>
  <p align="center"><input type="submit" name="submit" value="select" class = "form-submit-button" style ="border-color:black; border-width:2px; border-style:solid"></p>
	<input type="hidden" name="submitted" value="TRUE">
</form>
';

include ('includes/footer.html');
}
?>