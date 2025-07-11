<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	include ('makeSafe.php');
		
	//update product	
	$productID = $_POST['productIDvalue'];
	$productName = makeSafe($_POST['productNameValue']);
	$productUOM = makeSafe($_POST['productUOMvalue']);
	$productClsCode = makeSafe($_POST['productClsCodeValue']);
	$productType = makeSafe($_POST['productTypeValue']);
			
	$productBuying = 0; 
	$productSelling = 0;
	
	if(is_numeric($_POST['productBuyValue'])){$productBuying = $_POST['productBuyValue'];}
	if(is_numeric($_POST['productSellValue'])){$productSelling = $_POST['productSellValue'];}	 
	
	
	$sqlUpdateProduct = "UPDATE tbproduct SET product_name = '$productName', product_uom = '$productUOM', product_type = '$productType', 
	product_buyingPrice = '$productBuying', product_sellingPrice = '$productSelling', product_clsCode = '$productClsCode' WHERE product_id = '$productID'"; 	
	
	mysqli_query($connection, $sqlUpdateProduct) or die("error in update product query");
	echo "1";
		
?>
