<?php 
	session_start();
	include('connectionImes.php');	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");	
	
	$sqlGetTaxRate = "SELECT taxRate_id, taxRate_code, taxRate_rate FROM tbtaxrate ORDER BY taxRate_default DESC, taxRate_code ASC";	
	$resultGetTaxRate = mysqli_query($connection, $sqlGetTaxRate) or die("error in get tax rate query");	
	
	
	while($rowGetTaxRate = mysqli_fetch_array($resultGetTaxRate)){
		$id = $rowGetTaxRate['taxRate_id'];
		$taxRate = $rowGetTaxRate['taxRate_code'];
		$taxRateValue = $rowGetTaxRate['taxRate_rate'];
		$resultArray[] = array("id" => $id, "taxRate" => $taxRate, "taxRateValue" => $taxRateValue);	
	}	
	
	echo json_encode($resultArray);
	
?>