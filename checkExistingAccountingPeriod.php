<?php 
	session_start();
	include ('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$startDate1Converted = convertMysqlDateFormat($_POST['dateStart']);
	$endDate1Converted = convertMysqlDateFormat($_POST['dateEnd']);	
	
	$sqlCheckExistingAccountingPeriod = "SELECT accountingPeriod_id FROM tbaccountingperiod
	WHERE ((accountingPeriod_dateStart <= '$startDate1Converted' AND accountingPeriod_dateEnd >= '$startDate1Converted') 
	OR (accountingPeriod_dateStart <= '$endDate1Converted' AND accountingPeriod_dateEnd >= '$endDate1Converted'))";
	
	
	$resultCheckExistingAccountingPeriod = mysqli_query($connection, $sqlCheckExistingAccountingPeriod) or die("error in check tbleaveyearly");
	
	if(mysqli_num_rows($resultCheckExistingAccountingPeriod)>0){
		//got existing accounting period
		echo "false";		
	}else{
		echo "true";			
	}
?>