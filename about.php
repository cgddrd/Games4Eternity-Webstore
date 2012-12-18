<?php 

/*
	Title: about.php
	Description: Simple webpage that contains my writeup about my approach to the assignment
	Author: Connor Goddard - 2012
*/
require("siteheader.php");  //Retrieves universal website header (including session information) 

?>

	<!-- About page that details my approach to this assignment and justification of my design/implementaion actions -->

	<h1 class="title">About</h1>
	
	<a class="source "href="./srcclg11/"><span class="bold">PHP &amp; Javascript source code (.txt format)</span></a>
	
	<h2 class="about">Declaration of Originality</h2>
	
	<p>This submission is my own work, except where clearly indicated. I understand that there are severe penalties for plagiarism and other unfair practice, which can lead to loss of marks or even the withholding of a degree. I have read the sections on unfair practice in the Students' Examinations Handbook and the relevant sections of the current Student Handbook of the Department of Computer Science. I understand and agree to abide by the University's regulations governing these issues.</p>
	
	<h2 class="about">Introduction</h2>
	
	<p>In this assignment I was set the task of designing and implementing a basic e-commerce website utilising PHP and PostgreSQL technologies. The purpose of the assignment was to allow me to demonstrate my ability to utilise server-side concepts and technologies (including PostgreSQL database manipulation and PHP) and client-side technologies (Javascript) to produce a fully functional e-commerce web store.</p> 
	
	<p>I feel I have accomplished this and have produced a well designed, aesthetically pleasing site that portrays a professional image, that also is fully compliant with the W3C standards for XHTML 1.0 Strict &amp; CSS 3.</p>

	<h2 class="about">System Implementation</h2>
	
	<p>To ensure I fully understood the new technologies and concepts I was learning as part of the assignment, I decided to break the task down into three key stages:</p>
	
	<ol>
		<li>Research, design and implement a basic site using PHP, PostgreSQL and Javascript that contained all the functionality specified in the project brief (including product listings and shopping basket). This site would contain no bespoke formatting.</li>
		<li>Design a template for the website in XHTML/CSS formatted to incorporate the branding of the fake video game company</li>
		<li>Merge the website formatting with the PHP functionality to produce the final e-commerce website.</li>
	</ol>
	
	<h2 class="about">Server-Side Implementation</h2>
	
	<p>I began the implementation of the server-side functionality by researching and writing various PostgreSQL statements that would be useful when generating and displaying product information to the website user. This included researching the &#34;WHERE&#34; and &#34;BETWEEN&#34; keywords, used to return data that meets specified criteria, along with the &#34;ORDER BY&#34; and &#34;ASC/DESC&#34; keywords, which can be used to change the order and criteria of which returned data is sorted.</p>
	
	<p>Once I was able to retrieve the data from the PostgreSQL database, I began implementing the &lsquo;user login/shopping basket&rsquo; functionality by using PHP sessions. I found creating the sessions to be straightforward, and was able to easily retrieve and display a username stored as a session variable. I was also able to create an array stored as a session variable which would be used to contain the reference number, and quantity of an item that had been &#34;added to the basket&#34; by a user. By having this array, all items selected by the user on the product listing page could then be retrieved from the database (using the stored reference number) and displayed alongside the selected quantity on the webpage detailing the contents of the user&rsquo;s basket.</p>
	
	<p>Initially I did run into some trouble with sessions when a user &lsquo;logged out&rsquo;. It appeared that the session variables were not removed upon a user logging out, and so this meant that a particular user&rsquo;s login credentials and basket would remain when another user tried to log in. After some debugging (using the &#34;print_R($_SESSION)&#34; command) I discovered that the cause of the problem was that session variables were not being unset (&#34;unset($_SESSION[&lsquo;userID&rsquo;])&#34;) and the session was not being destroyed using the &#34;session_destroy()&#34; command.</p>
	
	<p>Throughout the implementation of PHP, I modularised the code in an attempt to ease debugging and future development. This meant that common or similar functions and behaviour were grouped together, and placed inside a separate PHP file that was then accessed using the &#34;INCLUDE&#34; and &#34;REQUIRE&#34; functions as needed.  PHP files for the site header and footer are example of this, as they are required for every page, and so can simply be included into any page  without having to re-write all the code every time.</p>
	
	<h2 class="about">Client-Side Implementation</h2>
	
	<p>One requirement of the assignment brief specified that client-side validation checking using JavaScript should be performed on input forms before the data is sent to the server. In my implementation of this, I produced a single JavaScript file that contained three functions for validating the three input forms used on the site.</p>
	
	<p>The first function determined if the username text field at the top of the website was empty when a user submitted, and if it was, prevented the PHP used to process that username from executing. A dialog was then displayed to the user informing them of this.</p>
	
	<p>The second function checked whether the minimum search price entered by a user, was greater than the maximum price, and if so displayed a dialog and prevented the page from executing. A check to see if the fields were empty was not required, as the PHP would simply request all records from the database to be returned in this instance.
</p>
	
	<p>Finally the third function was slightly more complex as it incorporated regular expressions to help determine what had been entered as an email address and card number by the user when checking out their basket. [1] The function first checked to see if either field was empty, at which point the fields would not pass validation. If they were populated, both fields were then searched using specific regular expressions (one unique to the email address, the other to the 16-digit card number) that checked the user input matched those expressions. If either did not, then again the fields did not pass validation, and the page was not processed.</p>

	<h2 class="about">Aesthetic Design</h2>
	
	<p>For the website design, I wanted to create a clean, modern and professional-looking website that would be easy to maintain and change as required.  I have used a definitive colour scheme throughout the site, along with a small selection of well-known and more creative fonts to give a sense of company branding and identity. To in-keep with the rest of the site design, I chose to apply CSS to form elements such as buttons, and tables used to display product information. </p>
	
	<h2 class="about">Changes to the Specification</h2>
	
	<p>I identified an area of my website that I felt could be changed slightly from what was initially specified in the assignment brief regarding selecting items to go into the user&rsquo;s basket. It is stated that checkboxes could be used to select products that a user wishes  to add to their basket [2], with a single &#34;add to basket&#34; button being placed somewhere on the page to commit those items to the basket. </p>
	
	<p>After performing research on established e-commerce sites (Amazon, Tesco), I decided that a more intuitive method of adding items to a basket would be to have an &#34;add to basket&#34; button for all products displayed on the site. This method I feel is easier for the user to interact with, and would work in a similar way to that of using checkboxes, meaning that implementing the code for this system would not require significantly more effort than if checkboxes were used. </p>
	
	<h2 class="about">Additions to the Specification</h2>
	
	<p>While testing that my website was able to retrieve data from the PostgreSQL table, I realised that multiple listings of the same game were being displayed in the table, with the only difference in the items being their platform.  This to me seemed like an in-efficient use of screen real-estate, and from a user interface point of view could confuse a customer trying to find a particular platform of a particular game.</p>
	
	<p>I therefore decided to modify my code so that before it generates listings of the available games, as it processes a particular game title the system then checks the rest of the database for any other instances of that title, and adds the platform of that other title to the existing one.  It then prevents that other title being displayed on the webpage using a system of arrays. This results in one listing of a particular game being displayed with potentially multiple platforms. I have ensured also, that when a user selects a particular platform of game, the reference number of the title with <span class="bold">that platform</span> is added to the basket, to account for any future changes in price based on platform. </p>
	
	<p>An example would be the game &#34;Assassin&rsquo;s Creed&#34;. This game is available on three platforms: PC, Xbox 360 and Playstation 3. The site will only display a one listing for Assassin&rsquo;s Creed, however this listing will have the option for the user to choose either PC, Xbox, or Playstation as the platform. When the user visits their basket, the platform of Assassin&rsquo;s Creed that they chose will be displayed with its own price information.</p>
	
	<p><span class="bold">Update:</span> In addition to this, I have recently improved the algorithm to allow it to any differences in price between game platforms. This means that a user can quickly and easily view all the available
	platforms for a particular game, and any difference in prices between those platforms. For example, if the Playstation 3 version of a game was more expensive than the Xbox 360 platform, 
	then this will now be displayed next to the platform.</p>
	
	<p>Following on from the &#34;add to basket&#34; button described in <span class="bold">Changes to the Specification</span>, I have now written code that allows the system to determine if a particular platform of game is already been added to the basket
	when a user adds another item. If the system detects that the unique identifier of a game and it&rsquo;s platform is the same, it automatically updates the quantity of the existing item in the basket, as opposed to creating another record
	of that item.</p>
	
	<h2 class="about">Testing</h2>
	
	<p>At every major stage of development I would test the site to ensure it was working as expected. This was especially the case during the server-side development, and I frequently tested that each portion of code that added new functionality (e.g. sessions, SQL statements etc) was working fully as expected before progressing to the next stage.  For this assignment, I did not use any specific debuggers, and instead used a variety of &#34;PRINT&#34; statements to check the outcome of functions and variables.  I did however utilise the Web Developer Tools available in Google Chrome, which allowed me to check exactly what GET/POST data was being sent and received, as well as the time taken for web pages to load to check for inefficient PHP code.</p>
	
	<p>The website was tested across a variety of web browsers (including Chrome, Firefox, IE8, and Safari) and platforms (including Windows, OSX, Ubuntu, Android, iOS), which all appear to render the site the same. I also tested the site using different screen resolutions, and apart from some minor aesthetic changes, again the site appears to cope well</p>
	
	<h2 class="about">Evaluation</h2>
	
	<p>Overall, I am pleased with the website I have produced and have thoroughly enjoyed the assignment. I feel my website fulfils the specified functional requirements, but also presents itself to look as close as possible to a real e-commerce business website. I have taken great care to add features that I feel enable to site to be more intuitive to its users, while ensuring that the initial requirements in the assignment brief are upheld.</p>
	
	<p>I have very much enjoyed using PHP and PostgreSQL to create a dynamic website. I have realised while researching for this assignment that there really does appear to be a function for everything in PHP, and I now appreciate how what appear to be &#34;simple&#34; SQL statements, can be so powerful when working with collections of data. I have enjoyed writing PHP code along with SQL statements, and even though I found some topics (such as sessions) hard to understand at first, I feel by working through the problems I have learnt more than I could simply by reading material.</p>
	
	<p>If I was to do this assignment again, I would probably attempt to implement AJAX when updating the producing listing table based on user&rsquo;s search criteria. By using AJAX, there would be no need for a separate PHP file used when displaying a bespoke results table, which would cut down on code, and loading/processing times. This could also be utilised to allow the user&rsquo;s basket to be dynamically updated &#34;there and then&#34; without the need to re-load the page and transfer session variables between these pages</p>
	
	<p>With more time, I could improve the website by perhaps integrating a &#34;product description&#34; page into the site. This page would use PHP and SQL statements to give more detailed information about a particular game, and could be implemented relatively easily by using a page template, that was then populated with data specific to the product selected by a user. From performing research it appears most e-commerce sites (e.g. Amazon, Game, Tesco etc) have some kind of system like this in place. </p>
	
	<p>Throughout the assignment, I used the &lsquo;Coda&rsquo; IDE for Mac OSX and Notepad++ for Windows. I found these to be extremely useful when attempting to debug code and especially useful when attempting to place variables inside strings &lsquo;echoed&rsquo; by PHP and used in SQL statements, as the variable were displayed in a  different colour to the strings themselves and so it was easy to differentiate between the two.</p>
	
	<p>With regards to testing, I found using print statements very useful. In all debugging for this assignment, print statements have been enough to allow me to discover and rectify problems with my code. However, I can very much appreciate how when designing large and more complex systems, a debugger such as XDebug would be more useful and efficient than simply print statements. Surprisingly, I found the client-side JavaScript harder to debug than PHP, and so I would most certainly use a JavaScript debugging tool (such as the plugin for Firefox) next time.</p>
	
	<p>Overall I feel I have learnt a great deal in utilising server-side technologies, and integrating these with client-side scripting to produce fully-functional, well designed web sites.  I am very much looking forward to using my new skills and experience in the future.</p>
	
	<h2 class="about">References</h2>
	
	<ol>
		<li>S. Smith, Email Regex Pattern, RegExLib.com, http://regexlib.com/REDetails.aspx?regexp_id=21</li>
		<li>A. D. Shaw, CS25010 Assignment PHP, 2012: Abersytwyth University, Aberystwyth</li>
	</ol>
	
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
