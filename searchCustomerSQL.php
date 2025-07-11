<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");	
	
	$searchCustomer = $_POST['name'];
	$searchCustomer = '%'.$searchCustomer.'%';
	
	$sqlGetCustomerInfo = "SELECT customer_id, customer_name FROM tbcustomer  WHERE (customer_name LIKE '$searchCustomer') 
	ORDER BY customer_name ASC LIMIT 20"; 
	
	$resultGetCustomerInfo = mysqli_query($connection, $sqlGetCustomerInfo) or die("error in get customer info query");
	//initialise the array
	$names = array();
	
	if(mysqli_num_rows($resultGetCustomerInfo)>0){
		//got customer					
		//CHAT GPT CODE
		while($rowGetCustomerInfo = mysqli_fetch_row($resultGetCustomerInfo)){
			$names[] = array(
			"id" => $rowGetCustomerInfo[0],
			"name" => $rowGetCustomerInfo[1]
			);
		}		
				 
		$response = array("names" => $names);
		echo json_encode($response);
	}
?>