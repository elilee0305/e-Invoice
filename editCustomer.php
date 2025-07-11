<?php
	session_start();
	
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");	
	include ('makeSafe.php');

	//create new customer record 
	$customerID = $_POST['customerIDvalue'];
	$customerName = makeSafe($_POST['customerNameValue']);
	$customerAddress = makeSafe($_POST['customerAddressValue']);
	$customerDeliveryAddress = makeSafe($_POST['customerDeliveryAddressValue']);
	$customerStateID = makeSafe($_POST['customerStateIDvalue']);
	$customerTelephone = makeSafe($_POST['customerTelValue']);
	$customerEmail = makeSafe($_POST['customerEmailValue']);
	$customerTINno = makeSafe($_POST['customerTINnoValue']);
	$customerROCno = makeSafe($_POST['customerROCnoValue']);
	$customerAttention = makeSafe($_POST['customerAttentionValue']);			
	$customerType = $_POST['customerTypeValue'];
	
	if(empty($customerName)){$customerName = "";}
	if(empty($customerAddress)){$customerAddress = "";}			
	if(empty($customerDeliveryAddress)){$customerDeliveryAddress = "";}		
	if(empty($customerStateID)){$customerStateID = "";}
	if(empty($customerTelephone)){$customerTelephone = "";}
	if(empty($customerEmail)){$customerEmail = "";}
	if(empty($customerTINno)){$customerTINno = "";}
	if(empty($customerROCno)){$customerROCno = "";}
	
	if(empty($customerAttention)){$customerAttention = "";}
	
	$sqlUpdateCustomer = "UPDATE tbcustomer SET customer_name = '$customerName', customer_address = '$customerAddress', 
	customer_tel = '$customerTelephone', customer_email	= '$customerEmail', customer_attention = '$customerAttention', 
	customer_deliveryAddress = '$customerDeliveryAddress', customer_type = '$customerType', customer_TINnumber = '$customerTINno', customer_ROCnumber = '$customerROCno', customer_stateID = '$customerStateID' WHERE customer_id = '$customerID'";
	
	mysqli_query($connection, $sqlUpdateCustomer) or die("error in update customer query");
	
	echo "1";
	
	
	




?>
