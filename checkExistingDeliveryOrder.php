<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$deliveryOrderNo = $_POST['deliveryOrderNo'];
	$sqlCheckExistingDeliveryOrder = "SELECT deliveryOrder_id FROM tbdeliveryorder WHERE deliveryOrder_no = '$deliveryOrderNo'";
	
	$resultCheckExistingDeliveryOrder = mysqli_query($connection, $sqlCheckExistingDeliveryOrder) or die("error in check existing delivery order no");
	
	if(mysqli_num_rows($resultCheckExistingDeliveryOrder)>0){
		//got existing delivery order no
		$rowCheckExistingDeliveryOrder = mysqli_fetch_row($resultCheckExistingDeliveryOrder);
		echo $rowCheckExistingDeliveryOrder[0];		
		
	}else{
		echo "0";			
	}
?>
