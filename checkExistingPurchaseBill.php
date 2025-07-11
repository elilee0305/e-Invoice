<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$purchaseBillNo = $_POST['purchaseBillNo'];
	$sqlCheckExistingPurchaseBill = "SELECT purchaseBill_id FROM tbpurchasebill WHERE purchaseBill_no = '$purchaseBillNo'";
	
	$resultCheckExistingPurchaseBill = mysqli_query($connection, $sqlCheckExistingPurchaseBill) or die("error in check existing purchase bill no");
	
	if(mysqli_num_rows($resultCheckExistingPurchaseBill)>0){
		//got existing quotation no
		$rowCheckExistingPurchaseBill = mysqli_fetch_row($resultCheckExistingPurchaseBill);
		echo $rowCheckExistingPurchaseBill[0];		
		
	}else{
		echo "0";			
	}
?>
