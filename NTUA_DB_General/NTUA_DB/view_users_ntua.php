<?php
# Created 26 May, 2021
# Created by Dimitris Liberopoulos
# Script that shows all the users (for ntua_databases project) 

$page_title = 'View the Current Clients';
include ('includes/header.html');

echo '<h1>Registered Clients</h1>';
require_once ('../mysqli_connect.php');   // connect to MySQL (database ntua_db)

// change table names and attributes so they match those from the database
$q = "SELECT c.NFC_ID AS NFC_ID, c.Last_name, c.First_name, DATE_FORMAT(c.Birth_Date, '%M %d, %Y') AS Birth_Date, c.ID_document_number, c.ID_document_kind, c.ID_document_authority,   
 	  p.Phone_number AS phone_number, e.Email FROM client AS c JOIN client_phone AS p USING (NFC_ID) JOIN client_email AS e USING (NFC_ID) ORDER BY c.Last_name";
$r = @mysqli_query($dbc, $q);
$num = mysqli_num_rows($r);

if ($num > 0) {
	echo "<p><big>There are currently $num registered clients.</big></p>\n ";

	//start of <table>
	echo '<table align="center" cellspacing="10" cellpadding="3" width="120%">
	<tr>
	<td align="left"><b>NFC ID</b></td>
	<td align="left"><b>Last Name</b></td>
	<td align="left"><b>First Name</b></td>
	<td align="left"><b>Date of Birth</b></td>
	<td align="left"><b>ID Number</b></td>
	<td align="left"><b>ID Kind</b></td>
	<td align="left"><b>ID Authority</b></td>
	<td align="left"><b>Phone Number</b></td>
	<td align="left"><b>Email</b></td>
	</tr>';

	while ($row = mysqli_fetch_array($r, MYSQLI_ASSOC)) {
			echo '<tr>
			<td align="left">' . $row['NFC_ID'] . '</td>
			<td align="left">' . $row['Last_name'] . '</td>
			<td align="left">' . $row['First_name'] . '</td>
			<td align="left">' . $row['Birth_Date'] . '</td>
			<td align="left">' . $row['ID_document_number'] . '</td>
			<td align="left">' . $row['ID_document_kind'] . '</td>
			<td align="left">' . $row['ID_document_authority'] . '</td>
			<td align="left">' . $row['phone_number'] . '</td>
			<td align="left">' . $row['Email'] . '</td>

			</tr>';
	}

	echo '</table>';  // end of <table>
	mysqli_free_result($r);

} else {   // if something went wrong
	echo '<p class="error">There are currently no registered users.</p>';
} // end of -if($num > 0)-

mysqli_close($dbc);

include ('includes/footer.html');
?>
