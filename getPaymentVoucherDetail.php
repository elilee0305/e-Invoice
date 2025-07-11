<?php
	session_start();
	include('connectionImes.php');

	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$paymentVoucherID = $_POST['paymentVoucherID'];

	$sqlPaymentVoucherDetail = "SELECT purchaseBill_no, paymentVoucherDetail_rowTotalAfterDiscount, purchaseBill_id, purchaseBill_customerInvoiceNo 
	FROM tbpurchasebill, tbpaymentvoucherdetail WHERE (purchaseBill_id = paymentVoucherDetail_purchaseBillID) 
	AND (paymentVoucherDetail_paymentVoucherID = '$paymentVoucherID') ORDER BY paymentVoucherDetail_id ASC";
	
	$resultPaymentVoucherDetail = mysqli_query($connection, $sqlPaymentVoucherDetail) or die("error in get payment detail query");
	
	//initialise the array
	$aPaymentVoucherDetail = array();
	
	if(mysqli_num_rows($resultPaymentVoucherDetail) > 0){
		$h = 0;
		while($rowPaymentDetail = mysqli_fetch_row($resultPaymentVoucherDetail)){
			$aPaymentVoucherDetail[$h][0] = $rowPaymentDetail[3];
			$aPaymentVoucherDetail[$h][1] = $rowPaymentDetail[1];			
			$aPaymentVoucherDetail[$h][2] = $rowPaymentDetail[2];			
			$h = $h + 1;
		}		
	}else{
		// NO EXISTING RECORDS, //initialize to to empty array
		$aPaymentVoucherDetail = array();
	}
	echo json_encode($aPaymentVoucherDetail);
?>