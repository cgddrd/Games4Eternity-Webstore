<?php

/*
	Title: dbconn.php
	Description: Background database connection file used to connect to PostgreDQL database using supplied criteria.
	Author: Connor Goddard - 2012
*/

function dbConnect($hostname, $port, $table, $username, $password) {

//Return connection handle to PostgreSQL database using supplied connection information
  return pg_connect("host=" . $hostname . " port=" . $port." dbname=" . $table ." user=" . $username . " password=" . $password);
  
} 

/*Display PHP source code.
	Only active between December - June */
$viewmonth=date("n");
if (($viewmonth==12)||($viewmonth<7)) {

		if (isset($_POST["viewsource"])) {
		
			echo "SOURCE CODE FOR: ". __FILE__;

			echo highlight_file(__FILE__);
		}
}

?>
