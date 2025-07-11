<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$invoiceID = $_POST['invoiceID'];
	$sqlCheckExistingCreditNote = "SELECT creditNote_id FROM tbcreditnote WHERE creditNote_invoiceID = '$invoiceID'";
	
	$resultCheckExistingCreditNote = mysqli_query($connection, $sqlCheckExistingCreditNote) or die("error in check existing credit note");
	
	if(mysqli_num_rows($resultCheckExistingCreditNote)>0){		
		echo "1";	//got existing credit note	
	}else{		
				
		$sqlCheckExistingDebitNote = "SELECT debitNote_id FROM tbdebitnote WHERE debitNote_invoiceID = '$invoiceID'";
	
		$resultCheckExistingDebitNote = mysqli_query($connection, $sqlCheckExistingDebitNote) or die("error in check existing debit note");	
				
		if(mysqli_num_rows($resultCheckExistingDebitNote)>0){		
			echo "4";	//got existing debit note	
		}else{		

				//check got payment
				$sqlCheckExistingPayment = "SELECT payment_id FROM tbpayment, tbpaymentdetail WHERE (payment_id = paymentDetail_paymentID) 
				AND (paymentDetail_invoiceID = '$invoiceID')";
				
				$resultCheckExistingPayment = mysqli_query($connection, $sqlCheckExistingPayment) or die("error in check existing payment");
				if(mysqli_num_rows($resultCheckExistingPayment)>0){
					
					//check if active or cancell payment
					$sqlCheckExistingActivePayment = "SELECT payment_id FROM tbpayment, tbpaymentdetail WHERE (payment_id = paymentDetail_paymentID) 
					AND (payment_status > 0) AND (paymentDetail_invoiceID = '$invoiceID')";
					$resultCheckExistingActivePayment = mysqli_query($connection, $sqlCheckExistingActivePayment) or die("error in check existing active payment");
					if(mysqli_num_rows($resultCheckExistingActivePayment) > 0){
						//active payment available
						echo "2"; //got existing payment paid/postdated
					}else{
						//cancel payment available
						echo "3"; //got existing payment cancel
					}
				}else{			
					echo "0";	//no records		
				}	
		}
	}
?>