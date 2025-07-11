<?php
	session_start();
	include('connectionImes.php');

	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$customerID = $_POST['customerID'];
	

	$sqlCustomerInfo = "SELECT customer_name, customer_address, customer_tel, customer_email, customer_attention, customer_deliveryAddress, 
	customer_type, customer_TINnumber, customer_ROCnumber, customer_stateID FROM tbcustomer WHERE (customer_id = '$customerID')";
	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in get product info query");
	
	//initialize the array
	$aCustomerInfo = array();

	if(mysqli_num_rows($resultCustomerInfo) > 0){
		$h = 0;
		while($rowProductInfo = mysqli_fetch_row($resultCustomerInfo)){
			$aCustomerInfo[$h][0] = $rowProductInfo[0];//name
			$aCustomerInfo[$h][1] = $rowProductInfo[1];//address		
			$aCustomerInfo[$h][2] = $rowProductInfo[2];//tel
			$aCustomerInfo[$h][3] = $rowProductInfo[3];//email
			$aCustomerInfo[$h][4] = $rowProductInfo[4];//attention		
			$aCustomerInfo[$h][5] = $rowProductInfo[5];//delivery address			
			$aCustomerInfo[$h][6] = $rowProductInfo[6];//customer type		
			$aCustomerInfo[$h][7] = $rowProductInfo[7];//customer TIN no		
			$aCustomerInfo[$h][8] = $rowProductInfo[8];//customer ROC no		
			$aCustomerInfo[$h][9] = $rowProductInfo[9];//customer state ID		
		}
		
	}else{
		//no product info, initialize to to empty array
		$aCustomerInfo = array();
	}
	echo json_encode($aCustomerInfo);
?>