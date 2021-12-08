<?php
# Created 20 May, 2021
# Created by Dimitris Liberopoulos
# Script that shows most crowded spaces and most used services (for ntua_databases project) 

#initial menu bar and filter bar
$page_title = 'Sales';
include ('includes/header.html');
?>
<br>

<!-- input form to get the desired age group and choose between spaces, most used services or services used by most clients -->
<p><big><b>Please choose one option from below, and then select the desired age group.</b></big></p>
<br>
<form action="info.php" method="post">
	<label for="options"><big>Info about:</big></label>
  	<select name="options" id="options">
    <option value="choice1">Most crowded spaces</option>
    <option value="choice2">Services used more often</option>
    <option value="choice3">Services used by most clients</option>
  	</select>
  	<br>
  	<p><big>Please select an age group from below:</big></p>
  	<input type="radio" id="1" name="age" value="1">
  	<label for="1">20-40</label><br>
  	<input type="radio" id="2" name="age" value="2">
  	<label for="2">41-60</label><br>
  	<input type="radio" id="3" name="age" value="3">
  	<label for="3">61+</label><br>
	<p align="center"><input type="submit" name="submit" value="select" class = "form-submit-button" style ="border-color:black; border-width:2px; border-style:solid"></p>
  	<input type="hidden" name="submitted" value="TRUE">

<?php

if (isset($_POST['submitted'])) {
	require_once ('../mysqli_connect.php');   // start the connection with MySQL

	if (isset($_POST['options'])) {
		if (isset($_POST['age'])) {    // if all options are set

			$opt = $_POST['options'];
			$age = $_POST['age'];
			$min=0;
			$max=0;

			if ($age == 1) {   // 20-40
				$min = 20;
				$max = 40;
			} elseif ($age == 2) {   // 41-60
				$min = 41;
				$max = 60;
			} else {   // 61+
				$min = 61;
				$max = 200;  // noone is going to be more than 200 years old, so this option is for age group 61+    
			}

			if ($opt == "choice1") {   // option 1 -> crowded spaces
				$q = "SELECT  DISTINCT Name, COUNT(NFC_ID) AS visits FROM rooms JOIN visit AS v USING (Room_ID) JOIN client USING(NFC_ID) WHERE Birth_Date BETWEEN DATE_SUB(NOW(), INTERVAL '$max' YEAR) AND DATE_SUB(NOW(), INTERVAL '$min' YEAR) AND TD_of_entrance 
					BETWEEN DATE_SUB(NOW(), INTERVAL 31 DAY) AND NOW() GROUP BY NAME ORDER BY visits DESC";

			} elseif ($opt == "choice2") {   // option 2 -> most used services
				$q = "SELECT  DISTINCT s.Description, COUNT(NFC_ID) AS uses FROM services AS s JOIN usage_of_services USING (Service_ID) JOIN client USING(NFC_ID) WHERE Birth_Date BETWEEN DATE_SUB(NOW(), INTERVAL '$max' YEAR) AND DATE_SUB(NOW(), INTERVAL '$min' YEAR) AND TD_of_charge 
					BETWEEN DATE_SUB(NOW(), INTERVAL 31 DAY) AND NOW() GROUP BY s.Description ORDER BY uses DESC";

			} else {    // option 3 -> services used by most clients
				$q = "SELECT  DISTINCT s.Description, COUNT(DISTINCT NFC_ID) AS uses FROM services AS s JOIN usage_of_services USING (Service_ID) JOIN client USING(NFC_ID) WHERE Birth_Date BETWEEN DATE_SUB(NOW(), INTERVAL '$max' YEAR) AND DATE_SUB(NOW(), INTERVAL '$min' YEAR) AND TD_of_charge 
					BETWEEN DATE_SUB(NOW(), INTERVAL 31 DAY) AND NOW() GROUP BY s.Description ORDER BY uses DESC";
			}

			$r = mysqli_query($dbc, $q);   // executing the query in our database
			$num = mysqli_num_rows($r);

			if ($num <= 0) echo "<h2>No results were found with the above filters. Please change the filters and try again!</h2>";   // an error occured
			else {   // results were found

				if ($opt == "choice1") {  // results for option 1 -> most crowded spaces
					echo '<table align="center" cellspacing="10" cellpadding="3" width="80%">
					<tr>
					<td align="left"><b>Space Name</b></td>
					<td align="left"><b>Number of visits during the last month</b></td>
					</tr>';

					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						echo '<tr>
						<td align="left">' . $row['Name'] . '</td>
						<td align="left">' . $row['visits'] . '</td>
						</tr>';
					}

					echo '</table>';  // end of <table>
					mysqli_free_result($r);

				} else if ($opt == "choice2") {  // results for option 2 -> most used services
					echo '<table align="center" cellspacing="10" cellpadding="3" width="80%">
					<tr>
					<td align="left"><b>Service</b></td>
					<td align="left"><b>Number of uses during the last month</b></td>
					</tr>';

					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						echo '<tr>
						<td align="left">' . $row['Description'] . '</td>
						<td align="left">' . $row['uses'] . '</td>
						</tr>';
					}

					echo '</table>';  // end of <table>
					mysqli_free_result($r);

				} else {    // results for option 3 -> services used by most clients
					echo '<table align="center" cellspacing="10" cellpadding="3" width="80%">
					<tr>
					<td align="left"><b>Service</b></td>
					<td align="left"><b>Number of clients using the service during the last month</b></td>
					</tr>';

					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						echo '<tr>
						<td align="left">' . $row['Description'] . '</td>
						<td align="left">' . $row['uses'] . '</td>
						</tr>';
					}

					echo '</table>';  // end of <table>
					mysqli_free_result($r);

				}
			}

		}
	}

	mysqli_close($dbc); // closing the connection with MySQL
}

include('includes/footer.html');
?>