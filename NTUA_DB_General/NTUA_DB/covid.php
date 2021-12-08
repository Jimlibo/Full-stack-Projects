<?php
# Created 19 June, 2021
# Created by Dimitris Liberopoulos
# Script that shows information about a client that was found positive to Covid-19 (for ntua_databases project) 

$page_title = 'Covid Victim Info';
include ('includes/header.html');
?>

<!-- the form in which nfc_id will be given as input, and we can choose if we want to see the spaces the victim visited, or other possible victims -->
<form action="covid.php" method="post">
	<p><big>NFC ID: </big><input type="text" name="nfc_id" size="15" maxlength="20"></p>
	<p><b><big>Please select an option from below:</big></b></p>
  	<input type="radio" id="spaces" name="choice" value="spaces">
  	<label for="spaces"><big>Spaces he visited</big></label><br>
  	<input type="radio" id="others" name="choice" value="others">
  	<label for="others"><big>Clients that were in the same space with the patient</big></label><br>
	<p align="center"><input type="submit" name="submit" value="select" class = "form-submit-button" style ="border-color:black; border-width:2px; border-style:solid"></p>
  	<input type="hidden" name="submitted" value="TRUE">

<?php
if (isset($_POST['submitted'])) {   // the nfc_id of client positive to covid, has been given
	require_once ('../mysqli_connect.php');

	if (isset($_POST['nfc_id'])) {
		$id = $_POST['nfc_id'];

		if (isset($_POST['choice'])) {   // all options are set , and we can show some results

			echo '<br>';
			$c = $_POST['choice'];
			
			if ($c == "spaces") {  // we want to know the locations visited by the victim
				$q = "SELECT Name, TD_of_entrance, TD_of_departure FROM visit JOIN rooms USING(Room_ID) WHERE NFC_ID = '$id'";    // find space names
				$r = mysqli_query($dbc, $q);   // the results
				$num = mysqli_num_rows($r);

				if ($num <= 0) echo "<h2>Nothing was found! This client has not visited any rooms yet.</h2>";   // no results were found
	 			else {  // result were found
	 				echo '<table align="center" cellspacing="10" cellpadding="3" width="80%">
					<tr>
					<td align="left"><b>Space Name</b></td>
					<td align="left"><b>T&D of Entrance</b></td>
					<td align="left"><b>T&D of Departure</b></td>
					</tr>';

					while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
						echo '<tr>
						<td align="left">' . $row['Name'] . '</td>
						<td align="left">' . $row['TD_of_entrance'] . '</td>
						<td align="left">' . $row['TD_of_departure'] . '</td>
						</tr>';
					}

					echo '</table>';  // end of <table>
					mysqli_free_result($r);
				}  

			} else {   // we want to know clients that were in the same space with the patient at the same time (+1 hr)
				$q1 = "CREATE VIEW visited_rooms AS (SELECT Room_ID, TD_of_entrance, TD_of_departure FROM visit WHERE NFC_ID = '$id')";
				$r1 = mysqli_query($dbc, $q1); 
				$q2 = "SELECT Last_name, First_name FROM visit AS v JOIN client USING(NFC_ID) JOIN visited_rooms AS vr USING (Room_ID) 	WHERE NFC_ID != '$id' AND v.TD_of_entrance BETWEEN vr.TD_of_entrance AND
				DATE_ADD(vr.TD_of_departure, INTERVAL 1 DAY_HOUR)";   // find possible patients
				$r2 = mysqli_query($dbc, $q2);   // the results
				$num = mysqli_num_rows($r2);

				if ($num <= 0) echo "<h2>Nothing was found! No other clients were at the same space as the patient at the same time.</h2>";   // no results were found
	 			else {  // result were found
	 				echo '<table align="center" cellspacing="10" cellpadding="3" width="80%">
					<tr>
					<td align="left"><b>Last Name</b></td>
					<td align="left"><b>First Name</b></td>
					</tr>';

					while ($row = mysqli_fetch_array($r2, MYSQLI_ASSOC)) {
						echo '<tr>
						<td align="left">' . $row['Last_name'] . '</td>
						<td align="left">' . $row['First_name'] . '</td>
						</tr>';
					}

					echo '</table>';  // end of <table>
					mysqli_free_result($r2);

					$q3 = "DROP VIEW visited_rooms";
					$r3 = mysqli_query($dbc, $q3);
				}  
			}   // end of -if($c = space)-
		}
	}  // end of -if(isset(_POST['nfc_id']))-

	mysqli_close($dbc); // closing the connection with MySQL
} // end of -if(isset(_POST['submitted']))- 

include('includes/footer.html');
?> 
