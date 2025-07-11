<?php
	session_start();
	include('connectionImes.php');

	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$accountDate1Converted = convertMysqlDateFormat($_POST['dateStartValue']);
	$accountDate2Converted = convertMysqlDateFormat($_POST['dateEndValue']);		
	$customerID = $_POST['idCustomerValue'];
	$strStartDate = $_POST['dateStartValue'];
	
	//get the Opening Balance
	
	$openingBalance = 0.00;
	$getOpeningBalance = "SELECT COALESCE(SUM(customerAccount_debit - customerAccount_credit),0.00) AS openingBalance FROM tbcustomeraccount WHERE (customerAccount_customerID = '$customerID ') AND (customerAccount_date < '$accountDate1Converted')";
	
	$resultGetOpeningBalance = mysqli_query($connection, $getOpeningBalance) or die("error in getting opening balance query");
	
	$rowGetOpeningBalance = mysqli_fetch_row($resultGetOpeningBalance);
	$openingBalance = $rowGetOpeningBalance[0];

	$sqlGetCustomerAccount = "SELECT customerAccount_date, customerAccount_reference, customerAccount_description, customerAccount_debit, 
	customerAccount_credit FROM tbcustomeraccount WHERE (customerAccount_customerID = '$customerID ') AND 
	(customerAccount_date BETWEEN '$accountDate1Converted' AND '$accountDate2Converted') ORDER BY customerAccount_date ASC, customerAccount_id ASC";
	
	$resultGetCustomerAccount = mysqli_query($connection, $sqlGetCustomerAccount) or die("error in customer account query");
	
	//initialise the array
	$aCustomerAccountDetail = array();
	
	if(mysqli_num_rows($resultGetCustomerAccount) > 0){
		//insert opening balance info for the First row
		$aCustomerAccountDetail[0][0] = $strStartDate;			
		$aCustomerAccountDetail[0][1] = "";			
		$aCustomerAccountDetail[0][2] = "Opening Balance";			
		$aCustomerAccountDetail[0][3] = "";	// Debit		
		$aCustomerAccountDetail[0][4] = "";	// Credit		
		$aCustomerAccountDetail[0][5] = number_format($openingBalance,2); // Balance
		
		$rowBalance = 0.00;
		$h = 1;
		while($rowCustomerAccountDetail = mysqli_fetch_row($resultGetCustomerAccount)){
			if($h > 1){$openingBalance = $rowBalance;}
			$aCustomerAccountDetail[$h][0] = date("d/m/Y",strtotime($rowCustomerAccountDetail[0]));			
			$aCustomerAccountDetail[$h][1] = $rowCustomerAccountDetail[1];			
			$aCustomerAccountDetail[$h][2] = $rowCustomerAccountDetail[2];			
			$aCustomerAccountDetail[$h][3] = number_format($rowCustomerAccountDetail[3],2);			
			$aCustomerAccountDetail[$h][4] = number_format($rowCustomerAccountDetail[4],2);	
			$rowBalance = $openingBalance + $rowCustomerAccountDetail[3] - $rowCustomerAccountDetail[4];
			$aCustomerAccountDetail[$h][5] = number_format($rowBalance,2);			
			$h = $h + 1;
		}		
	}else{
		// NO EXISTING RECORDS, //initialize to to empty array
		$aCustomerAccountDetail = array();
	}
	echo json_encode($aCustomerAccountDetail);
?>