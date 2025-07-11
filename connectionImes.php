<?php
	
	// use the SQL operation for all the tables
	//default online engine is MyISAM
	// code ALTER TABLE my_table ENGINE = MyISAM;
	
	//set database variables

	/*
	$mysql_host = "";
	$mysql_user = "unifo_sugusmart";
	$mysql_password = "FjSkZb8cnVtcBu3UAP9Z";
	$mysql_database = "unifo_sugusmart"; 
	*/

	$mysql_host = "localhost";
	$mysql_user = "root";
	$mysql_password = "";
	$mysql_database = "imes"; 	 

	//online database for live simen site www.hothram.com/imesonline
	/* $mysql_host = "";
	$mysql_user = "cencmcom_suhu";
	$mysql_password = "1974#Melati";
	$mysql_database = "cencmcom_imes";  */
	
	
	function convertMonthName($monthNumber){
		switch($monthNumber){
			case 1:
				$monthName = "Jan";
				break;
			case 2:
				$monthName = "Feb";
				break;
			case 3:
				$monthName = "Mar";
				break;
			case 4:
				$monthName = "Apr";
				break;
			case 5:
				$monthName = "May";
				break;
			case 6:
				$monthName = "Jun";
				break;
			case 7:
				$monthName = "Jul";
				break;
			case 8:
				$monthName = "Aug";
				break;
			case 9:
				$monthName = "Sep";
				break;
			case 10:
				$monthName = "Oct";
				break;
			case 11:
				$monthName = "Nov";
				break;
			case 12:
				$monthName = "Dec";
				break;		
		}
		return $monthName;	
	}
	
	//convert date into mysql format function 
	function convertMysqlDateFormat($dateEntered){
		$dateExplode = explode("/",$dateEntered); 			
		$strYear = $dateExplode[2];		
		$strMonth = $dateExplode[1];		
		$strDay = $dateExplode[0];					
		$changedDateFormat = $strYear."-".$strMonth."-".$strDay;
		return $changedDateFormat;
	}

	//get day name
	function getDayName($dayNumber){
		$dayNumber = $dayNumber; //first day start 1 but array its 0
			switch($dayNumber){
			case 1:
				$dayName = "Mon";
				break;
			case 2:
				$dayName = "Tue";
				break;
			case 3:
				$dayName = "Wed";
				break;
			case 4:
				$dayName = "Thu";
				break;
			case 5:
				$dayName = "Fri";
				break;
			case 6:
				$dayName = "Sat";
				break;
			case 7:
				$dayName = "Sun";
				break;					
		}	
		return $dayName;
	}	
	
	//to prevent cross script attacks, we remove all html tags and other types of tags using regular expression
	function stripHTMLTags($text){
		$text = preg_replace(array(		
		 // Remove invisible content
            '@<head[^>]*?>.*?</head>@siu',
            '@<style[^>]*?>.*?</style>@siu',
            '@<script[^>]*?.*?</script>@siu',
            '@<object[^>]*?.*?</object>@siu',
            '@<embed[^>]*?.*?</embed>@siu',
            '@<applet[^>]*?.*?</applet>@siu',
            '@<noframes[^>]*?.*?</noframes>@siu',
            '@<noscript[^>]*?.*?</noscript>@siu',
            '@<noembed[^>]*?.*?</noembed>@siu'		
		),array('', '', '', '', '', '', '', '', ''),$text);
		return strip_tags($text);	
	}	
	
		
	
	//function to make web input safe
	//function makeSafe ($userInput){		
		//$userInput = stripHTMLTags($userInput);
		//as futher precaution, remove all special characters / ' $ % and # from string
		//$bad = array("=","<", ">", "/","\"","`","~","'","$","%","#");
		//$userInput = str_replace($bad, "", $userInput);		
		//$userInput = mysqli_real_escape_string(trim($userInput));
		//return $userInput;	
	//}	
?>