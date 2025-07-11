<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$purchaseBillID = $_POST['purchaseBillID'];
			
	//check got payment
	$sqlCheckExistingPaymentVoucher = "SELECT paymentVoucher_id FROM tbpaymentvoucher, tbpaymentvoucherdetail 
	WHERE (paymentVoucher_id = paymentVoucherDetail_paymentVoucherID) 
	AND (paymentVoucherDetail_purchaseBillID = '$purchaseBillID')";
	
	$resultCheckExistingPaymentVoucher = mysqli_query($connection, $sqlCheckExistingPaymentVoucher) or die("error in check existing payment voucher");
	if(mysqli_num_rows($resultCheckExistingPaymentVoucher)>0){
		
		//check if active or cancell payment
		$sqlCheckExistingActivePaymentVoucher = "SELECT paymentVoucher_id FROM tbpaymentvoucher, tbpaymentvoucherdetail WHERE (paymentVoucher_id = paymentVoucherDetail_paymentVoucherID) 
		AND (paymentVoucher_status > 0) AND (paymentVoucherDetail_purchaseBillID = '$purchaseBillID')";
		$resultCheckExistingActivePaymentVoucher = mysqli_query($connection, $sqlCheckExistingActivePaymentVoucher) or die("error in check existing active payment voucher");
		if(mysqli_num_rows($resultCheckExistingActivePaymentVoucher) > 0){
			//active payment voucher available
			echo "1"; //got existing payment voucher paid/postdated
		}else{
			//cancel payment voucher available
			echo "2"; //got existing payment voucher cancel
		}
	
	}else{			
		echo "0";	//no records		
	}	
	
	
	
	
?>