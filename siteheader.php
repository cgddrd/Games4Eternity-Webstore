<?php

/*
	Title: siteheader.php
	Description: Displays universal website header and contains user authentication/basket information
	Author: Connor Goddard - 2012
*/

session_save_path("/berw/homes1/c/clg11/tmp"); //Set bespoke session save path (used to fix central.aber.ac.uk bug)
session_start(); //Begin the current PHP session

require_once("login.php"); //Retrieve user authentication functionality


//Determines the total number of seperate basket items and displays on site
function checkBasket() {

	//Count the total number of items in the basket array (if empty will display 0)
	$result = count($_SESSION['basket']);
	  
	 echo "<h1>Basket: {$result} items</h1>";
}

echo '<?xml version="1.0" encoding="UTF-8"?>';

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

<!DOCTYPE html 
     PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
     "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
     
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	
	<head>
		<title>Games 4 &#8734; - CS25010 Assignment (clg11)</title>
		 <link rel="stylesheet" href="css/style.css" type="text/css" media="screen"/>
		 <script type="text/javascript" src="js/validate.js"></script>
		 <!--[if !IE 7]>
			<style type="text/css">
				#wrap {display:table;height:100%}
			</style>
		<![endif]-->
	</head>
	
	<body>
	
	<div id="wrap">

		<div id="main">
	
			<div id="betabar">
    	
    			<h1>Please note: This online store is not real. It has been created for a university assignment. Do not attempt to buy from this store or enter any real details. Thankyou.</h1>
    	
    		</div> 
	
	 		<div id="siteheader">
	 
	 			<div id="logo">
	 
	 				<a href="index.php">Games 4 &#8734;</a>
	 
	 			</div>
	 
	  			<div id="basketdisplay">
	  
	  				<?php checkBasket(); //Display the number of items in the current user's basket?>
	 
	 				<a href="basket.php">Visit Basket</a>
	 
	 			</div>
	 
	 
	 			<div id="logindisplay">
	 
	 				<?php checkLogin(); //Determine whether a user is currently logged in and displays required form?>
	 
	 			</div>
	 
	 		</div> 
	 
	 <div id="container">

		<a class="nav" href="./index.php">Catalog</a>
		<a class="nav" href="./about.php">About</a>
		<a class="nav" href="./index.php">Home</a>

		<hr />