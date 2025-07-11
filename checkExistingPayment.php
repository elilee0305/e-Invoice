<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$paymentNo = $_POST['paymentNo'];
	$sqlCheckExistingPayment = "SELECT payment_id FROM tbpayment WHERE payment_no = '$paymentNo'";
	
	$resultCheckExistingPayment = mysqli_query($connection, $sqlCheckExistingPayment) or die("error in check existing payment no");
	
	if(mysqli_num_rows($resultCheckExistingPayment)>0){
		//got existing Payment no
		echo "1";		
		
	}else{
		echo "0";
			
	}

