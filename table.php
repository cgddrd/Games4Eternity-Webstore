<?php

/*
	Title: table.php
	Description: Generates product catalog table using either general or specifc search criteria
	Author: Connor Goddard - 2012
*/

require_once('dbconn.php'); //Retrieve functionality to connect to PostgreSQL database
error_reporting(~E_ALL); //Set PHP error flag to allow bespoke error messages to be created

//Generates the form used by the user to create bespoke searches
function generateSearchFields($conn) {

	//Retrieve all available game platforms from database
	$platformQuery = pg_query ($conn, "SELECT DISTINCT platform FROM CSGames");
	
	//If query does not return a result, abort and display error message
	if (!$platformQuery) {
		die ("Unfortunatly there are no results for this search. Please try again later.");
	} 
	
	//Generate the form with all search input fields
 	echo '<h2 id="searchwarning" class="warning rightalign"></h2>
 			<div id="tableselect">
		 		<form action="searchtable.php" method="get">
					<fieldset>
						Min price: <input type="text" name="min_price" size="3"/>
						Max price: <input type="text" name="max_price" size="3"/>
						Platform: <select name="platform">
						<option value="plat_all" selected="selected">Display all platforms</option>';
				
				//Create platform combo-box listing all available platforms obtained from database
				while ($a = pg_fetch_array ($platformQuery)) {
				
					echo "<option value=\"{$a["platform"]}\">{$a["platform"]}</option>";
				
				}
				
	echo '</select> Sort by: <select name="sort">
					<option value="p_low_high" selected="selected">Price: Low - High</option>
					<option value="p_high_low">Price: High - Low</option>
					<option value="t_a_z">Title: A-Z</option>
					<option value="t_z_a">Title: Z-A</option>
				</select>
				<input type="submit" name="pricesubmit" value="Search" onclick="return validatePriceSelect(this.form.min_price.value, this.form.max_price.value)" />
			</fieldset>
		</form>
		</div>';

}

//Obtains all the platforms of a particular game title listed in the database.
//Determines if any of these platforms are of a different price, and displays this price if neccessary.
function obtainGamePlatforms($conn, $a) {

	//Create temporary array of game title platforms
	$platforms = array(array());
	 
	//Converts game title to format accepted for use in SQL query
	$escapeString = pg_escape_string($a["title"]);
	
	//Return any games in the database that have the same title as the original (specified) title
	$desQuery = pg_query ($conn, "SELECT * FROM CSGames WHERE title = '{$escapeString}' AND refnumber <> {$a["refnumber"]}");
	
	//If query does not return any results, abort and display error message (should at least return original item that was specified)
	if (!$desQuery) {
		die ("Unfortuantly this database connection appears to have failed. Please try again later.");
	}
	
	//Add the original (specified) game platform to the temporary array
	array_push($platforms, array("name" => $a["platform"], "differ_price" => null));
	 
	//Loop through every matching game returned from the SQL query
	while ($b = pg_fetch_array ($desQuery)) {
		
		//If the original (specified) game platform price does not match the current game platform price
		if ($a["price"] != $b["price"]) {
			
			//This particular platform for the game must be more/less expensive
			
			//Therefore add this platform to the temporary array with the different price
			array_push($platforms, array("name" => $b["platform"], "differ_price" => $b["price"]));
			
		} else { //Otherwise if the prices match
			
   		//Add the platform to the temporary array with no difference in price
   		array_push($platforms, array("name" => $b["platform"], "differ_price" => null));
   			
   		}
   
   	}
   	
	//Return the array of all platforms (including any price differences) for a particular game title	
   	return $platforms;
}

//Generates the product catalog table using specified search criteria
function generateTable($query) {

	//Connect to database and retrieve information using the specfied SQL query
	$conn = dbConnect("db.dcs.aber.ac.uk", "5432", "teaching", "csguest", "rohishe");
	$res = pg_query ($conn, $query);
	
	//If query does not return any results, abort and display error message
	if (!$res) {
		die ("Unfortunatly there are no results for this search. Please try again later.");	
	} 

	//Create a temporary array used to hold once instance of every game (**prevents repeats of the same game**)
    $stack = array();
    
	//Generate the product catalog search form
    generateSearchFields($conn);
    
	//Loop through every product returned from the specified SQL query
	 while ($a = pg_fetch_array ($res)) {
	 
		//Check to see if the current game title has already been processed before
	 	if (in_array($a["title"], $stack) == false) {
	 
			//If no other game with the same title has been processed before..
			
			//Obtain all platforms (and any differences in price) for that title
			$platforms = obtainGamePlatforms($conn, $a);
	 
			//Populate site product list template with the current game information
	  		echo '<div class="smallcontainer">';
	
			echo '<div class="left">';
		
			//Convert game title to HTML markup to ensure it is displayed correctly on webpage (and to ensure webpage validates)
			$converted_title = htmlentities($a["title"]);
		
			echo "<h1>{$converted_title} // &#163;{$a["price"]}</h1>";
			
			echo "<p class=\"proddes\">{$a['description']}</p>";
			
			echo "<hr class=\"table\"/>";
			
			echo '<h2>Available Platforms: | ';
			
			//Loop through every obtained platform for the current game title
			foreach ($platforms as $value) {
			
				if ($value["name"] != null) {
				
					//If the current platform has a different price
					if ($value["differ_price"] != null) { 
				
						//Display that price with the platform
						echo "{$value["name"]} (&#163;{$value["differ_price"]}) | ";
						
					} else {
					
					//Otherwise just display the platform
					echo "{$value["name"]} | ";
					
					}
				}
  			}
  			
  			echo '</h2>';
  			
  			echo '</div>';
  		
  			echo '<div class="right">';
  		
  			echo '<form action="'. $_SERVER["PHP_SELF"] .'" method="post" class="addform">
        			<fieldset>Quantity: <select name="quantity">
						<option value="1" selected="selected">1</option>
						<option value="2">2</option>
						<option value="3">3</option>
						<option value="4">4</option>
						<option value="5">5</option>
						<option value="6">6</option>
						<option value="7">7</option>
						<option value="8">8</option>
						<option value="9">9</option>						
					</select>
					Platform: <select name="platform">';	
					
						//List every platform as an option in combo-box
						foreach ($platforms as $value) {
						
							if ($value["name"] != null) {
   
  								echo "<option value='{$value["name"]}'>{$value["name"]}</option>";
  							
  							} 
  	
  						}
  					
				echo '</select> <br />
					<input type="hidden" name="prodtitle" value="'. $converted_title .'" />
					<input type="submit" name="addtobasket" value="Add to Basket" class="addtobasket" /></fieldset>
				</form>';
			
  			echo '</div>';
  		
  		echo '</div>';	

		//Add the game title to the temporary collection to prevent multiple listings of the same game being displayed
	 	array_push($stack, $a["title"]);
	 
	 }
	 
	}
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
