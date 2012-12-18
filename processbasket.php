<?php

/*
	Title: processbasket.php
	Description: Contains functionality used to manage a user's basket. Includes functions to add, remove and display items.
	Author: Connor Goddard - 2012
*/

session_save_path("/berw/homes1/c/clg11/tmp"); //Set bespoke session save path (used to fix central.aber.ac.uk bug)
session_start(); //Begin the current PHP session
error_reporting(~E_ALL); //Set PHP error flag to allow bespoke error messages to be created

require_once('dbconn.php'); //Retrieve functionality to connect to PostgreSQL database


//Adds an new/existing item to the basket
function addItem($itemTitle, $itemPlatform) {

	$itemExists = false; //Boolean used to determine if product being added already exists in the basket

	$conn = dbConnect("db.dcs.aber.ac.uk", "5432", "teaching", "csguest", "rohishe"); //Connect to database
	
	//If the connection cannot be established, abort and display error message
	if (!$conn) {
		die ("Unfortuantly this database connection appears to have failed. Please try again later.");
	}
	
	//Prepare item data to be used in SQL query
	$decode_value = html_entity_decode($itemTitle); //Convert product title from HTML markup to plain text
	
	$escapeTitle = pg_escape_string($decode_value); //Convert parsed product title into SQL query format
	
	$escapePlatform = pg_escape_string($itemPlatform); //Convert product platform into SQL query format

	//Query database for record that matches selected title and platform (should only return one product)
	$basketQuery = pg_query ($conn, "SELECT refnumber FROM CSGames WHERE title = '{$escapeTitle}' AND platform = '{$escapePlatform}'");
	
	//If query does not return a result, abort and display error message
	if (!$basketQuery) {
		die ("Unfortuantly this database connection appears to have failed. Please try again later.");
	}

	//Access the result of the query
	while ($a = pg_fetch_array ($basketQuery)) {
	
		//If the user has not yet added any products
		if (! isset($_SESSION['basket'])) {
	
			//Create a 2-dimensional array used to represent the user's basket
			$_SESSION['basket'] = array("item" => array("id" => $a["refnumber"], "quantity" => $_POST['quantity']));
	
		} else { //Otherwise if the user already has items in their basket
		
			//Loop through every item in the basket
			foreach($_SESSION['basket'] as $item ) {
			
				//Check to see if a matching item has already been located in the basket
				if (!$itemExists) {

					//If not compare the ID of the current item in the basket, with the ID of the item to be added
					if ($item['id'] == $a['refnumber']) {
				
						//If the two ID's match, create handle to that item in the basket
						$keys = array_search($item, $_SESSION['basket']);
				
						//Increment the basket item quantity with the quantity of the matching added item
						$existingQuant = (int) $_SESSION['basket'][$keys]['quantity'];
						$newQuant = (int) $_POST['quantity'];
						$totalQuant = $existingQuant + $newQuant;
					
						$_SESSION['basket'][$keys]['quantity'] = $totalQuant;
					
						//Prevent the function looking for any more matching items in the basket
						$itemExists = true;

					} 
			
				}
			
			}
		
		//If no matching item has been located in the basket
		 if (!$itemExists) {

			//Add this item as a new entry in the basket
			array_push($_SESSION['basket'], array("id" => $a["refnumber"], "quantity" => $_POST['quantity']));

		}

		}
	}

}

//Remove a specified item from the basket
function removeItem($productID) {
 
	//Loop through every item in the basket
 	foreach($_SESSION['basket'] as $item ) {
		
		//If the current basket item ID matches the specified item ID
		if ($item['id'] == $productID) {

			//If the two ID's match, create handle to that item in the basket
			$keys = array_search($item, $_SESSION['basket']); 

			//Remove that item from the basket
			unset($_SESSION['basket'][$keys]);

			//Update the index of the basket array
			$_SESSION['basket'] = array_values($_SESSION['basket']);

		} 

	}
	
}

//Calculates the total price for a particular basket item
function calcItemPrice($quantity, $price) {

	//Multiply the individual price of an item by the selected quantity
	$result = $quantity * $price;

	//Return the result to display
	return $result;

}

//Calculates the grand total of all items in the basket
function calcTotalPrice() {

	$total_price = 0;
	
	//Connect to database to retrieve items and their prices
	$conn = dbConnect("db.dcs.aber.ac.uk", "5432", "teaching", "csguest", "rohishe");
	
	//If query does not return a result, abort and display error message
	if (!$conn) {
		die ("Unfortuantly this database connection appears to have failed. Please try again later.");
	}

	//Loop through every item in the basket array
	foreach($_SESSION['basket'] as $item ) {
		
		//Retrieve price of current item from database
		$res = pg_query ($conn, "SELECT price FROM CSGames WHERE refnumber = {$item['id']}");
		
		//If query does not return a result, abort and display error message
		if (!$res) {
			die ("Unfortuantly this database connection appears to have failed. Please try again later.");
		}
		
		//Access results of query
		while ($a = pg_fetch_array($res)) {
		
			//Retrieve the total price of an individual item
			$current_item_price = calcItemPrice($item["quantity"], $a["price"]);
		
			//Increment this individual item total price to grand total of entire basket
			$total_price = $total_price + $current_item_price;
		
		}
	}

	return $total_price;

}


//Retrieves information about a particular item from the database
function retrieveItem($productID) {

	$conn = dbConnect("db.dcs.aber.ac.uk", "5432", "teaching", "csguest", "rohishe");
	
	if (!$conn) {
		die ("Unfortuantly this database connection appears to have failed. Please try again later.");
	}
	
	//Retrieve title, description, platform and price of the specified item from database
	$queryResult = pg_query ($conn, "SELECT title, description, platform, price FROM CSGames WHERE refnumber = {$productID}");
	
	if (!$queryResult) {
		die ("Unfortuantly this database connection appears to have failed. Please try again later.");
	}
	
	//Return the result of the query
	return($queryResult);

}


//Generate and display the basket inventory on website
function generateBasketInventory() {

	echo "<table>";

	echo "<tr><th/><th>Price</th><th>Quantity</th></tr>";

		//Loop through every basket item displaying their title, platform, quantity and total price
		foreach($_SESSION['basket'] as $item ) {
		
			$res = retrieveItem($item['id']);
		
			while ($a = pg_fetch_array($res)) {
			
				//Convert product title retrieved from database to "HTML friendly" markup
				$converted_title = htmlentities($a["title"]);
        
        		echo "<tr>";
        		
        		echo "	<td>
        					<span class=\"baskettitle\">{$converted_title}</span> - {$a["description"]}
        					<hr class=\"table\"/>
        					Platform: {$a["platform"]}
        				</td>";
        		
				//Format item price to two decimal prices in case item price does not specify any pence
        		$item_price = number_format(calcItemPrice($item["quantity"], $a["price"]), 2, '.', '');
        		
        		echo "<td>&#163;{$item_price}</td>";
		
        		echo "<td>{$item["quantity"]}</td>";
        
				//Create form to allow user to remove the item from the basket
				echo '<td><form action="'. $_SERVER["PHP_SELF"]. '" method="post">
							<fieldset>
								<input type="hidden" name="prodid" value="'. $item['id'] .'" />
								<input type="submit" name="removeitem" value="Remove" /> 
							</fieldset>
						</form></td>';
        
				echo "</tr>\n";
       
			}

		}
	
		echo "</table>\n"; 

		//Format basket grand total to two decimal prices in case item price does not specify any pence
		$total = number_format(calcTotalPrice(), 2, '.', '');
		
		echo "<div id=\"totalprice\">Total: &#163;{$total}</div>";
		
				//Generate form to allow user to go to site checkout
				echo '<form action="'. $_SERVER["PHP_SELF"]. '" method="post" id="checkoutbuttonform">
				<fieldset>
					<input type="submit" name="checkout" value="Checkout" id="checkoutbutton" /> 
					</fieldset>
				</form>';
				
		echo "<hr />";

}

//Generates and displays website checkout form
function generateCheckout() {

	echo '<h1 class="title">Checkout</h1>';
	echo '<h2 class="checkout">Please enter your email address and card details to proceed:</h2>';
	echo '<h2 id="checkoutwarning" class="warning"></h2>';

	//Generate checkout form that contains user validation Javascript
	echo '<form action="'. $_SERVER['PHP_SELF'] .'" method="post" id="custdetailsform">
			<fieldset>
				Email: <input type="text" name="emailaddr" />
				Card Details: <input type="text" name="carddetails" size="16" />
				<input type="submit" name="custdetails" value="Submit" onclick="return validateCheckoutDetails(this.form.emailaddr.value, this.form.carddetails.value)" />
			</fieldset>
		  </form>';

	echo "<hr />";
}

/*Display PHP source code when button clicked.
	Only active between December - June */
	$viewmonth=date("n");
	if (($viewmonth==12)||($viewmonth<7)) {

		if (isset($_POST["viewsource"])) {
		
			echo "SOURCE CODE FOR: ". __FILE__;

			echo highlight_file(__FILE__);
		}
}

?>