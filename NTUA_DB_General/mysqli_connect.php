<?php 
# Created 26 May, 2021
# Created by Dimitris Lymperopoulos
# Script mysqli_connect 
 
DEFINE ('DB_USER', '');            // fil with your username
DEFINE ('DB_PASSWORD', '');   //  password, fill it with your password for the database you are using
DEFINE ('DB_HOST', 'localhost');      // leave it as such if you want to run it locally
DEFINE ('DB_NAME', 'hotel');    // replace <hotel> with the name of the database you are using.
				// In your database you have to run hotel.sql to create tables and
				// some sample entries.

$dbc = @mysqli_connect (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) OR die ('Could not connect to MySQL: ' . mysqli_connect_error() );

?>
