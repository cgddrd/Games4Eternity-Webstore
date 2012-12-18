<?php

/*
	Title: login.php
	Description: Contains functionality to log new user into site (create new session), and logout user (destroying any existing data)
	Author: Connor Goddard - 2012
*/

session_save_path("/berw/homes1/c/clg11/tmp"); //Set bespoke session save path (used to fix central.aber.ac.uk bug)
session_start(); //Begin the current PHP session

function checkLogin() { //Determine status of the user in current session

	//If a user is currently logged in
	if(isset($_SESSION['userID'])) {

		logout(); //Display components to allow user to logout

	} else {

		login(); //Otherwise display components to allow a guest to login

	}

}

function login() { //Displays HTML form to allow user to enter user name and log in

	echo '<h1 id="loginwarning">Welcome Guest</h1>
			<form action="'. $_SERVER['PHP_SELF'] .'" method="post">
				<fieldset>
					Username: <input type="text" name="login" />
					<input type="submit" value="Login" class="button" onclick="return validateLoginDetails(this.form.login.value)" />
				</fieldset>
			</form>';

}

function logout() { //Displays current user name and provides form to allow user to log out


	echo '<h1>Welcome ' . $_SESSION["userID"] . '</h1>
			<form action="'. $_SERVER['PHP_SELF'] .'" method="post">
				<fieldset>
					Sign out: <input type="submit" name="logout" value="Logout" class="button"/>
				</fieldset>
			</form>';

}

//If the user selects to logout
if(isset($_POST['logout'])) {

	//Remove all stored session data and destroy session
	unset($_SESSION['userID']);
	
	unset($_SESSION['basket']);
	
	session_destroy();
	
	//If the current site page is not 'index.php', re-direct to index.php
	if ($_SERVER["PHP_SELF"] != "index.php") {
	
		header("Location: index.php");
		
	}
}

//If the user selects to login
if (isset($_POST['login'])) {

	//Set the new session user variable to the value entered by the user
	$_SESSION['userID'] = $_POST['login']; 
	
	if ($_SERVER["PHP_SELF"] != "index.php") {
	
		header("Location: index.php");
	}
		
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