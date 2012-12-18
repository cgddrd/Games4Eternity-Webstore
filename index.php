<?php 

/*
	Title: index.php
	Description: Default website page that is loaded when user enters site web address. Either welcomes a guest user, or displays game catalog when user is logged in.
	Author: Connor Goddard - 2012
*/

require("siteheader.php");  //Retrieves universal website header (including session information)

?>

<?php

//Retrieve background table and basket PHP files to enable basket and table functionality
require("processbasket.php"); 
require("table.php"); 

//If a user attempts to add an item to their basket
if (isset($_POST['addtobasket'])) {

	//Run the addItem function contained within 'processbasket.php' passing selected item name and platform
	addItem($_POST["prodtitle"], $_POST['platform']);
	
	//Refresh the current page to update basket item total
	header("Location: {$_SERVER["PHP_SELF"]}");

}
 

?>
	
	
<?php

	//On page load…
	
	//If a user has not logged into the site
	if (! isset($_SESSION['userID'])) {

		//Display welcome information, asking them to login
		echo '<h1 class="title">Welcome to Games 4 Infinity</h1>';
	
		echo '<h2 class="index">Welcome to Games 4 &#8734;. Your one-stop shop for all video-game and general console awesomeness.</h2>';
	
		echo '<h2 class="index">To browse our large collection of games, please login above.</h2>';


	} else {

		//Otherwise display welcome message with user's name
		echo "<h1 class=\"title\">Welcome {$_SESSION['userID']}...</h1>";

		echo "<h2 class = \"checkout\">Please browse the catalog below:</h2>";

		//Display the complete game catalog table
		generateTable("SELECT * FROM CSGames ORDER BY price");
	
	}

?>

<hr />

<?php 

/*Display PHP source code when button clicked.
	Only active between December - June */
$viewmonth=date("n");

	if (($viewmonth==12)||($viewmonth<7)) {

		if (isset($_POST["viewsource"])) {
		
			echo "SOURCE CODE FOR: ". __FILE__;

			echo highlight_file(__FILE__);

		} else {

		echo('<form action="' . $_SERVER["PHP_SELF"] . '" method="post">
			<p><input type="submit" name="viewsource" value="View source"/></p></form>');

		}
	} 

require("sitefooter.php"); //Retrieves universal website footer  

?>