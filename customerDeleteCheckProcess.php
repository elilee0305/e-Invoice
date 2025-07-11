<?php
	session_start();
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$customerID = $_POST['customerID'];	
	
	//Check tbCustomerAccount
	$sqlCheckCustomerAccount = "SELECT customerAccount_id FROM tbcustomeraccount WHERE customerAccount_customerID = '$customerID'";
	$resultCheckCustomerAccount = mysqli_query($connection, $sqlCheckCustomerAccount) or die("error in check customer account query");
	
	if(mysqli_num_rows($resultCheckCustomerAccount) > 0){
		echo "2"; //cannot delete, tbCustomerAccount got records
	}else{
		//check tbInvoice
		$sqlCheckInvoice = "SELECT invoice_id FROM tbinvoice WHERE invoice_customerID = '$customerID'";
		$resultCheckInvoice = mysqli_query($connection, $sqlCheckInvoice) or die("error in check customer invoice query");
		if(mysqli_num_rows($resultCheckInvoice) > 0){
			echo "3"; //cannot delete, tbInvoice got records
		}else{
			//check tbPurchaseBill
			$sqlCheckPurchaseBill = "SELECT purchaseBill_id FROM tbpurchasebill WHERE purchaseBill_customerID = '$customerID'";
			$resultCheckPurchaseBill = mysqli_query($connection, $sqlCheckPurchaseBill) or die("error in check customer purchase bill query");
			if(mysqli_num_rows($resultCheckPurchaseBill) > 0){
				echo "4"; //cannot delete, tbPurchaseBill got records
			}else{
				//check tbPayment
				$sqlCheckPayment = "SELECT payment_id FROM tbpayment WHERE payment_customerID = '$customerID'";
				$resultCheckPayment = mysqli_query($connection, $sqlCheckPayment) or die("error in check customer payment query");
				if(mysqli_num_rows($resultCheckPayment) > 0){
					echo "5"; //cannot delete, tbPayment got records
				}else{
					//check tbPaymentVoucher
					$sqlCheckPaymentVoucher = "SELECT paymentVoucher_id FROM tbpaymentvoucher WHERE paymentVoucher_customerID = '$customerID'";
					$resultCheckPaymentVoucher = mysqli_query($connection, $sqlCheckPaymentVoucher) or die("error in check customer payment voucher query");
					if(mysqli_num_rows($resultCheckPaymentVoucher) > 0){
						echo "6"; //cannot delete, tbPaymentVoucher got records
					}else{
						//check tbPurchaseOrder
						$sqlCheckPurchaseOrder = "SELECT purchaseOrder_id FROM tbpurchaseorder WHERE purchaseOrder_customerID = '$customerID'";
						$resultCheckPurchaseOrder = mysqli_query($connection, $sqlCheckPurchaseOrder) or die("error in check customer purchase order query");
						if(mysqli_num_rows($resultCheckPurchaseOrder) > 0){
							echo "7"; //cannot delete, tbPurchaseOrder got records
						}else{
							//check tbQuotation
							$sqlCheckQuotation = "SELECT quotation_id FROM tbquotation WHERE quotation_customerID = '$customerID'";
							$resultCheckQuotation = mysqli_query($connection, $sqlCheckQuotation) or die("error in check customer quotation query");
							if(mysqli_num_rows($resultCheckQuotation) > 0){
								echo "8"; //cannot delete, tbQuotation got records
							}else{
								//check tbDeliveryOrder
								$sqlCheckDeliveryOrder = "SELECT deliveryOrder_id FROM tbdeliveryorder WHERE deliveryOrder_customerID = '$customerID'";
								$resultCheckDeliveryOrder = mysqli_query($connection, $sqlCheckDeliveryOrder) or die("error in check customer DO query");
								if(mysqli_num_rows($resultCheckDeliveryOrder) > 0){
									echo "9"; //cannot delete, tbDeliveryOrder got records
								}else{
									echo "1"; //success
								}
							}
						}
					}
				}
			}		
		}
	}
	
	/* try {
    if(mysqli_query($connection, $sqlDeleteProduct)) {
        echo "Product deleted successfully!";
    } else {
        throw new Exception("Error deleting product.");
    }
} catch(Exception $e) {
    echo "Error message: " . $e->getMessage();
    // Perform some action to handle the error, such as logging it or displaying a message to the user.
} */
?>