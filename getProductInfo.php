<?php

	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$productID = $_POST['productID'];
	
	$sqlProductList = "SELECT product_id, product_name, product_sellingPrice, product_buyingPrice, product_uom FROM tbproduct WHERE product_id = '$productID'";
	$resultProductList = mysqli_query($connection, $sqlProductList) or die("error in product list query");

	if(mysqli_num_rows($resultProductList)>0){
		//got existing quotation no
		$rowProductList = mysqli_fetch_row($resultProductList);
		$productName = $rowProductList[1];
		$productSellingPrice = $rowProductList[2];
		$productBuyingPrice = $rowProductList[3];
		$productUOM = $rowProductList[4];

		$returnProductInfo = $productName."++++".$productSellingPrice."++++".$productBuyingPrice."++++".$productUOM;		
		
		echo $returnProductInfo;		
		
	}



?>