<?php 
	//function to make web input safe
	function makeSafe ($userInput){
		$IPAddress = $_SERVER['SERVER_ADDR'];
		//iv4 = 127.0.0.1 iv6 = ::1
		if(($IPAddress == '127.0.0.1')||($IPAddress == '::1')){
			//( LOCAL DEVELOPMENT COMPUTER)
			$mysql_host = "localhost";
			$mysql_user = "root";
			$mysql_password = "";
			$mysql_database = "imes";				
		}else{			
			//( ONLINE  SERVER COMPUTER )
			$mysql_host = "";
			$mysql_user = "cencmcom_suhu";
			$mysql_password = "1974#Melati";
			$mysql_database = "cencmcom_imes"; 			
		}
			
	
		$connection2 = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect2!");	
		$userInput = stripHTMLTags($userInput);		
		//as futher precaution, remove all special characters / ' $ % and # from string
		$bad = array("=","<", ">","\"","`","~","'","$","%","#");
		$userInput = str_replace($bad, "", $userInput);
		$userInput = trim($userInput);		 
		$userInput = mysqli_real_escape_string($connection2, $userInput);		
		return $userInput;	
		
	}

?>