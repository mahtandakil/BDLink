<?php

function elegirXML(){

	$dir = "../xml";
	$search = scandir($dir);

	echo "<ol>";

	foreach($search as $element){

		if(substr($element, -3, 3) == "xml" or substr($element, -3, 3) == "XML"){
			echo "<li><a href='?step=1&source=$element'>$element</a></li>";
		
		}
		
	}
	
	echo "</ol>";

}


?>
