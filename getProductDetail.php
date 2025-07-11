<?php
	session_start();
	include('connectionImes.php');

	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$productID = $_POST['productID'];
	
  
	$sqlProductInfo = "SELECT product_name, product_type, product_uom, product_buyingPrice, product_sellingPrice, product_clsCode
	FROM tbproduct WHERE (product_id = '$productID')";
	
	$resultProductInfo = mysqli_query($connection, $sqlProductInfo) or die("error in get product info query");
	
	//initialize the array	
	$aProductInfo = array();

	if(mysqli_num_rows($resultProductInfo) > 0){
		$h = 0;
		while($rowProductInfo = mysqli_fetch_row($resultProductInfo)){
			$aProductInfo[$h][0] = $rowProductInfo[0];	// product name
			$aProductInfo[$h][1] = $rowProductInfo[1];	// product type
			$aProductInfo[$h][2] = $rowProductInfo[2];	// product uom
			$aProductInfo[$h][3] = $rowProductInfo[3];	// product buying price
			$aProductInfo[$h][4] = $rowProductInfo[4];	// product selling price
			$aProductInfo[$h][5] = $rowProductInfo[5];	// product classification code		
		}
		
	}else{
		//no product info, initialize to to empty array
		$aProductInfo = array();
	}
	echo json_encode($aProductInfo);
?>