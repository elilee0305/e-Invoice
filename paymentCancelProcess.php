<?php

	session_start();
	include ('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$paymentID = $_POST['paymentID'];
	$aInvoiceID = json_decode($_POST['invoiceID']);
	
	if(empty($aInvoiceID)){
		//no invoice id, so no processing done
		echo "0";
	}else{ 
		//CANCEL process
		$countInvoiceID = count($aInvoiceID);
		for($i=0; $i < $countInvoiceID; $i++){
			$invoiceID = $aInvoiceID[$i][0];
			$paymentAmount = $aInvoiceID[$i][1];
			//update invoice payment
			$sqlUpdateInvoicePayment = "UPDATE tbinvoice SET invoice_paid = (invoice_paid - $paymentAmount) WHERE invoice_id = '$invoiceID'";
			mysqli_query($connection, $sqlUpdateInvoicePayment) or die("error in update invoice payment query");
		}
		
		//update payment status
		$sqlUpdatePaymentStatus = "UPDATE tbpayment SET payment_status = 0 WHERE payment_id = '$paymentID'";	
		
		//delete account receiveable and account cash together
		$sqlDeleteAccountReceiveable = "DELETE FROM tbaccount4 WHERE (account4_documentType = 'PAY') AND (account4_documentTypeID = '$paymentID')";
		
		
		//delete customer Account
		$sqlDeleteCustomerAccount = "DELETE FROM tbcustomeraccount WHERE (customerAccount_documentTypeID = '$paymentID') 
		AND (customerAccount_documentType = 'PAY')";
		
		mysqli_query($connection, $sqlUpdatePaymentStatus) or die("error in update payment status query");
		mysqli_query($connection, $sqlDeleteAccountReceiveable) or die("error in delete AR Cash query");
		mysqli_query($connection, $sqlDeleteCustomerAccount) or die("error in delete customer account query");
		
		echo "1";
		
	}
	







?>