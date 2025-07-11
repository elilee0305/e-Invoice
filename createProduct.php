<?php 
	 session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	include ('makeSafe.php');
	
	//create new product	
	$productName = makeSafe($_POST['productNameValue']);
	$productUOM = makeSafe($_POST['productUOMvalue']);
	$productClsCode = makeSafe($_POST['productClsCodeValue']);
	$productType = makeSafe($_POST['productTypeValue']);
			
	$productBuying = 0; 
	$productSelling = 0;
	
	if(is_numeric($_POST['productBuyValue'])){$productBuying = $_POST['productBuyValue'];}
	if(is_numeric($_POST['productSellValue'])){$productSelling = $_POST['productSellValue'];}	 		
	
	$sqlCreateProduct = "INSERT INTO tbproduct(product_id, product_name, product_uom, product_type, product_buyingPrice, product_sellingPrice, product_clsCode) 
	VALUES(NULL, '$productName', '$productUOM', '$productType', '$productBuying', '$productSelling', '$productClsCode')";
	
	mysqli_query($connection, $sqlCreateProduct) or die("error in create product query");
	echo "1";
?>