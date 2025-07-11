<?php
	session_start();
	include('connectionImes.php');

	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$customerID = $_POST['customerID'];

	$sqlCustomerInfo = "SELECT customer_name, customer_address, customer_tel, customer_email, customer_attention FROM 
	tbcustomer WHERE (customer_id = '$customerID')"; 
	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in get customer info` query");
	
	//initialise the array
	$aCustomerInfo = array();
	
	if(mysqli_num_rows($resultCustomerInfo) > 0){ 
		$h = 0;
		while($rowCustomerInfo = mysqli_fetch_row($resultCustomerInfo)){
			$aCustomerInfo[$h][0] = $rowCustomerInfo[0];
			$aCustomerInfo[$h][1] = $rowCustomerInfo[1];			
			$aCustomerInfo[$h][2] = $rowCustomerInfo[2];			
			$aCustomerInfo[$h][3] = $rowCustomerInfo[3];			
			$aCustomerInfo[$h][4] = $rowCustomerInfo[4];			
			$h = $h + 1;
		}		
	}else{
		// NO EXISTING RECORDS, //initialize to to empty array
		$aCustomerInfo = array();
	}
	echo json_encode($aCustomerInfo);
?>