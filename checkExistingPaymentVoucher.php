<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$paymentVoucherNo = $_POST['paymentVoucherNo'];
	$sqlCheckExistingPaymentVoucher = "SELECT paymentVoucher_id FROM tbpaymentvoucher WHERE paymentVoucher_no = '$paymentVoucherNo'";
	
	$resultCheckExistingPaymentVoucher = mysqli_query($connection, $sqlCheckExistingPaymentVoucher) or die("error in check existing payment voucher no");
	
	if(mysqli_num_rows($resultCheckExistingPaymentVoucher)>0){
		//got existing payment voucher no
		$rowCheckExistingPaymentVoucher = mysqli_fetch_row($resultCheckExistingPaymentVoucher);
		echo $rowCheckExistingPaymentVoucher[0];		
		
	}else{
		echo "0";			
	}
?>
