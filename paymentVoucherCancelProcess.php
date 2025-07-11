<?php

	session_start();
	include ('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$paymentVoucherID = $_POST['paymentVoucherID'];
	$paymentVoucherType = $_POST['paymentVoucherType'];
	$idCustomer = $_POST['idCustomer'];
	$aPurchaseBillID = json_decode($_POST['purchaseBillID']);
	
	if($paymentVoucherType == 'p'){
		if(empty($aPurchaseBillID)){
			//no purchase bill id, so no processing done
			echo "0";
		}else{ 
			//CANCEL process
			$countPurchaseBillID = count($aPurchaseBillID);
			for($i=0; $i < $countPurchaseBillID; $i++){
				$purchaseBillID = $aPurchaseBillID[$i][0];
				$paymentVoucherAmount = $aPurchaseBillID[$i][1];
				//update purchase bill payment
				$sqlUpdatePurchaseBillPayment = "UPDATE tbpurchasebill SET purchaseBill_paid = (purchaseBill_paid - $paymentVoucherAmount) WHERE purchaseBill_id = '$purchaseBillID'";
				mysqli_query($connection, $sqlUpdatePurchaseBillPayment) or die("error in update purchase bill payment query");
			}
			
			//update payment voucher status
			$sqlUpdatePaymentVoucherStatus = "UPDATE tbpaymentvoucher SET paymentVoucher_status = 0 WHERE paymentVoucher_id = '$paymentVoucherID'";	
			
			//delete account payable and account cash together
			$sqlDeleteAccountPayable = "DELETE FROM tbaccount4 WHERE (account4_documentType = 'PAYV') AND (account4_documentTypeID = '$paymentVoucherID')";
			
			//delete customer Account
			$sqlDeleteCustomerAccount = "DELETE FROM tbcustomeraccount WHERE (customerAccount_documentTypeID = '$paymentVoucherID') 
			AND (customerAccount_documentType = 'PAYV') AND (customerAccount_customerID = '$idCustomer')";
			
			mysqli_query($connection, $sqlUpdatePaymentVoucherStatus) or die("error in update payment voucher status query");
			mysqli_query($connection, $sqlDeleteAccountPayable) or die("error in delete AP Cash query");
			mysqli_query($connection, $sqlDeleteCustomerAccount) or die("error in delete customer account query");
			
			echo "1";
			
		}
	}else{
		//SEPARATE PAYMENT VOUCHER
		//update payment voucher status
		$sqlUpdatePaymentVoucherStatus = "UPDATE tbpaymentvoucher SET paymentVoucher_status = 0 WHERE paymentVoucher_id = '$paymentVoucherID'";
		
		//delete account purchase/expense and account cash/bank together
		$sqlDeleteAccountPayable = "DELETE FROM tbaccount4 WHERE (account4_documentType = 'PV') AND (account4_documentTypeID = '$paymentVoucherID')";
			
		//delete customer Account
		$sqlDeleteCustomerAccount = "DELETE FROM tbcustomeraccount WHERE (customerAccount_documentTypeID = '$paymentVoucherID') AND (customerAccount_documentType = 'PV') AND (customerAccount_customerID = '$idCustomer')";
		
		mysqli_query($connection, $sqlUpdatePaymentVoucherStatus) or die("error in update payment voucher status query");
		mysqli_query($connection, $sqlDeleteAccountPayable) or die("error in delete AP Cash query");
		mysqli_query($connection, $sqlDeleteCustomerAccount) or die("error in delete customer account query");
			
		echo "1";
	}
?>