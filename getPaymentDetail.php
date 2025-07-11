<?php
	session_start();
	include('connectionImes.php');

	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$paymentID = $_POST['paymentID'];

	$sqlPaymentDetail = "SELECT invoice_no, paymentDetail_amount, invoice_id FROM tbinvoice, tbpaymentdetail WHERE (invoice_id = paymentDetail_invoiceID) 
	AND (paymentDetail_paymentID = '$paymentID') ORDER BY paymentDetail_id ASC";
	
	$resultPaymentDetail = mysqli_query($connection, $sqlPaymentDetail) or die("error in get payment detail query");
	
	//initialise the array
	$aPaymentDetail = array();
	
	if(mysqli_num_rows($resultPaymentDetail) > 0){
		$h = 0;
		while($rowPaymentDetail = mysqli_fetch_row($resultPaymentDetail)){
			$aPaymentDetail[$h][0] = $rowPaymentDetail[0];
			$aPaymentDetail[$h][1] = $rowPaymentDetail[1];			
			$aPaymentDetail[$h][2] = $rowPaymentDetail[2];			
			$h = $h + 1;
		}		
	}else{
		// NO EXISTING RECORDS, //initialize to to empty array
		$aPaymentDetail = array();
	}
	echo json_encode($aPaymentDetail);
?>