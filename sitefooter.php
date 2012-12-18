<?php
/*
	Title: sitefooter.php
	Description: Displays universal website footer and generates last modified date
	Author: Connor Goddard - 2012
*/
?>				</div>
		
			</div>
		
		</div>
		
		<div id="sitefooter">
		
			<h1>Please be aware this website is not an actual shopping website.</h1>
			
			<p>It has been created as a university assignment. Any correspondence regarding this website should be sent to Connor Goddard (clg11@aber.ac.uk). 
			The information provided on this and other pages by me, Connor Goddard (clg11@aber.ac.uk), is under my own personal responsibility and 
			not that of Aberystwyth University. Similarly, any opinions expressed are my own and are in no way to be taken as those of A.U.</p>
			
			<p>&#169; Connor Goddard 2012 | All Rights Reserved</p>
			
			<p>
    
    			<a href="http://validator.w3.org/check?uri=referer"><img
     			 src="http://www.w3.org/Icons/valid-xhtml10" alt="Valid XHTML 1.0 Strict" height="31" width="88" /></a>
     			 
     			 <a href="http://jigsaw.w3.org/css-validator/check/referer">
    				<img style="border:0;width:88px;height:31px"
        				src="http://jigsaw.w3.org/css-validator/images/vcss-blue"
        				alt="Valid CSS!" /></a>
  			</p>
  
			<?php 
			
				//Display the last modified date of the current file.
				$current_file = $_SERVER["PHP_SELF"];
			
				$name = basename($current_file, "");
			
				echo "<p>Last modified: " . date("F d Y H:i:s.", fileatime($name)) . "</p>"; 
				
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
			
		</div>
		
	</body>

</html>