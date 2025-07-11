<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$purchaseOrderNo = $_POST['purchaseOrderNo'];
	$sqlCheckExistingPurchaseOrder = "SELECT purchaseOrder_id FROM tbpurchaseorder WHERE purchaseOrder_no = '$purchaseOrderNo'";
	
	$resultCheckExistingPurchaseOrder = mysqli_query($connection, $sqlCheckExistingPurchaseOrder) or die("error in check existing purchase order no");
	
	if(mysqli_num_rows($resultCheckExistingPurchaseOrder)>0){
		//got existing quotation no
		$rowCheckExistingPurchaseOrder = mysqli_fetch_row($resultCheckExistingPurchaseOrder);
		echo $rowCheckExistingPurchaseOrder[0];		
		
	}else{
		echo "0";			
	}
?>
