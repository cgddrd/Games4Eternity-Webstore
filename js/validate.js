
/*
	Title: validate.js
	Description: Performs client-side validation of user input forms on Games 4 Infinity website
	Author: Connor Goddard - 2012
*/

//Validates the values of the email and card detail textboxes entered by a user before being sent to server
function validateCheckoutDetails(emailValue, cardValue) {
	
	//Check if either textbox is empty
      if (emailValue == "" || cardValue == "") {
			
			//If they are, display warning message to user
			document.getElementById("checkoutwarning").innerHTML="Please ensure all fields are completed.";
			
			//Prevents data being sent to server and process PHP from executing
			return false;           
      
      } else { //Otherwise if they are not empty
      
		//Specify email and card detail validation regular expressions
      	var cardRegex=/^\d{16}$/
      	var emailRegex = /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/
      
		//If card value user input does not match specified regular expression
      	if (cardValue.search(cardRegex) == -1) {
		
      		//Display warning message to user and prevent input being sent to server
      		document.getElementById("checkoutwarning").innerHTML = "Please enter a valid 16-digit card number.";
      		return false;
      	
		//If email user input does not match specified regular expression
      	} else if (emailValue.search(emailRegex) == -1) {
      	
			//Display warning message to user and prevent input being sent to server
      		document.getElementById("checkoutwarning").innerHTML = "Please enter a valid email address."; 
      		return false;	
      	
      	} else {
      	
			//Otherwise if all input is correct, display message informing user of successful purchase
      		alert("Payment successful - Thanks for shopping with us today.");	
      	
      	}
     }
		
}

//Validates the user login input
function validateLoginDetails(userNameValue) {
		

	//Check if the textbox is empty
      if (userNameValue == "") {
     
			//If it is, display warning message to user and prevent input being sent to server
			document.getElementById("loginwarning").innerHTML="Please enter a valid username.";
			return false;               
      
      }
		
}

//Validates user input used to specify a search price range
function validatePriceSelect(minPrice, maxPrice) {

	//Check if either textbox is empty
    if (minPrice != "" && maxPrice == "" || minPrice == "" && maxPrice != "") {
	  
	  //Display warning message to user and prevent input being sent to server
		document.getElementById("searchwarning").innerHTML="Please ensure both price values are entered.";   
		return false;
	  
	} else {
	
	//Define regular expression for empty string or just numbers
	var priceRegex = /^$|^[0-9.]+$/; 
	
	//If either price input textbox does not conform to the regular expression
	if (minPrice.search(priceRegex) == -1 || maxPrice.search(priceRegex) == -1 ) {
		
		//Display warning message to user and prevent input being sent to server
		document.getElementById("searchwarning").innerHTML="Please ensure all values are entered as numbers.";   
		return false;
		
	} else { 
	
		//Otherwise convert price inputs to floats
		var min = parseFloat(minPrice);
		var max = parseFloat(maxPrice);
	
		//Compare values to check if value specified for minimum price is not greater than maximum price
		if (min > max) {
	
			//If it is, display warning message to user and prevent input being sent to server
			document.getElementById("searchwarning").innerHTML="Minimum price is greater than maximum price. Please try again.";   
			return false;
	
		}
	
	}
	
	}
	
}
