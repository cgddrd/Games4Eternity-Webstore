<?php 

/*
	Title: basket.php
	Description: Displays the contents of a user's basket and provides a means to "check out" products.
	Author: Connor Goddard - 2012
*/

require("siteheader.php"); //Retrieves universal website header (including session information) ?>

<?php

require_once('processbasket.php'); //Retrieves basket controller to enable basket functions (e.g add/remove) to be used

if (isset($_POST['removeitem'])) { //If the user wishes to remove an item

	removeItem($_POST['prodid']); //Remove the item represented by the current 'remove' button
	
	header("Location: {$_SERVER["PHP_SELF"]}"); //Refresh the page (updates the basket table)

}
?>
	
	<h1 class="title">Your Basket</h1>

<?php

	if (! isset($_SESSION['userID'])) { //Check if a user has logged in

		//If they have not, display message
		echo '<h2 class="checkout">No user logged in. Please login above to continue.</h2>';
		echo "<hr />";


	} else if (! isset($_SESSION['basket']) || empty($_SESSION['basket'])) { //Otherwise if they have logged in, but there are not items in the basket

		//Display message informing user
		echo '<h2 class="checkout">There are currently no items in your basket.</h2>';
		echo "<hr />";


	} else { //Otherwise if a user has logged in, and has items in there basket

		//Display the contents of their basket
		generateBasketInventory();
		
	}
	
//If the user has pressed the 'checkout' button, or have entered their customer details
if (isset($_POST["checkout"]) || isset($_POST["custdetails"])) {

	//If there is no user logged in, display error message
	if (! isset($_SESSION['userID'])) {

		echo '<h2 class="warning">Please sign in to proceed to checkout</h2>';

	} else { 
		//Otherwise display checkout form below basket display
		generateCheckout();
	
	}	
}	
?>

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