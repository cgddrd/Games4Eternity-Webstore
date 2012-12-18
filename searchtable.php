<?php 

/*
	Title: searchtable.php
	Description: Contains results of a product catalog search specified by user.
	Author: Connor Goddard - 2012
*/

require("siteheader.php"); //Retrieves universal website header (including session information)

?>

<?php 

//Retrieve background table and basket PHP files to enable basket and table functionality
require_once("processbasket.php");
require_once("table.php"); 

//If a user attempts to add an item to their basket
if (isset($_POST['addtobasket'])) {

	//Run the addItem function contained within 'processbasket.php' passing selected item name and platform
	addItem($_POST["prodtitle"], $_POST['platform']);
	
	header("Location: index.php");

}

//Creates bespoke SQL query based search criteria specified by user using on-site form
function createSearchQuery() {

	//Create initial query (always required)
	$query="SELECT * FROM CSGAMES";
	
	
	//If the user has specified a particular platform
	if ($_GET["platform"] != "plat_all") {
	
		//Add that platform to the search criteria
		$query.=" WHERE platform = '{$_GET["platform"]}'";
	
	}
	
	//If the user has specified a price range
	if ($_GET["min_price"] != "" || $_GET["max_price"] != "") {
	
		//If the user has also specified a platform
		if ($_GET["platform"] != "plat_all") {
		
			// "AND" keyword is required as two criterion (platform and price range) are being set
			$query.=" AND price BETWEEN {$_GET["min_price"]} AND {$_GET["max_price"]}";
		
		} else {
		
			//Otherwise "WHERE" keyword can be used
			$query.=" WHERE price BETWEEN {$_GET["min_price"]} AND {$_GET["max_price"]}";
		
		}
	}
	
	//Determine the selected sorting criteria and add to SQL query
	switch ($_GET["sort"]) {
	
    	case "p_low_high":
    
        	$query.=" ORDER by price";
        	break;
        
    	case "p_high_low":
    
        	$query.=" ORDER by price DESC";
        	break;
        
   	 	case "t_a_z":
    
        	$query.=" ORDER by title";
        	break;
        
    	case "t_z_a":
    
        	$query.=" ORDER by title DESC";
        	break;   
      
    }  
    
	//Return the complete bespoke SQL query
    return $query;
    
}


?>
	
	<h1 class="title">Search results</h1>
	 
		<?php generateTable(createSearchQuery()); //Generate and display the product catalog table using the bespoke SQL query ?>

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

require("sitefooter.php"); 

?>