<?php 	
	session_start();	
	if($_SESSION['userID']==""){
		//not logged in
		ob_start();
		header ("Location: index.php");
		ob_flush();
	}
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");
	include ('makeSafe.php');	
	
	//update the invoice record
	if(isset($_POST['Submit'])){
		$buttonValue = $_POST['Submit'];
		$invoiceID = $_POST['invoiceID'];
		$customerID = $_POST['customerID'];	
		$invoiceNo = $_POST['invoiceNo'];
		$invoiceCustomer =  $_POST['invoiceCustomer'];
		if($buttonValue == "Edit Invoice"){
			//delete invoice details
			$sqlDeleteInvoiceDetail = "DELETE FROM tbinvoicedetail WHERE invoiceDetail_invoiceID = '$invoiceID'";
			mysqli_query($connection, $sqlDeleteInvoiceDetail) or die("error in delete invoice detail query");		
			
			$dateInvoice = convertMysqlDateFormat($_POST['invoiceDate']);
			
			$dateInvoiceDue = convertMysqlDateFormat($_POST['invoiceDueDate']);
			$invoiceNoDay  = makeSafe($_POST['invoiceNoDay']);
			if(is_numeric($invoiceNoDay)){$invoiceNoDay = intval($invoiceNoDay);}else{$invoiceNoDay = 0;}
			
			$invoiceFrom = makeSafe($_POST['invoiceFrom']);
			$invoiceTitle = makeSafe($_POST['invoiceTitle']);
			$invoiceTerms = $_POST['invoiceTerms'];			
			$invoiceContent = $_POST['invoiceContent'];			
				
			$invoiceAttention = makeSafe($_POST['invoiceAttention']);
			$invoiceEmail = makeSafe($_POST['invoiceEmail']);
			$invoiceTaxRate = 0;
			
			$subTotal = 0.00;
			$taxTotal = 0.00;
			$grandTotal = 0.00;
			$discountTotal = 0.00;
			$totalAfterDiscount = 0.00;
			$roundAmount = 0.00;
			$groundTotalRound = 0.00;
			$roundStatus = 0;
			
			//if detail exist only got all the totals
			if(isset($_POST['noCol1'])){
				$subTotal = makeSafe($_POST['subTotal']);
				$taxTotal = makeSafe($_POST['taxTotal']);
				$grandTotal = makeSafe($_POST['grandTotal']);
				$discountTotal = makeSafe($_POST['discountTotal']);
				$totalAfterDiscount = makeSafe($_POST['totalAfterDiscount']);
				$roundAmount = makeSafe($_POST['roundAmount']);
				$groundTotalRound = makeSafe($_POST['groundTotalRound']);			
				
				if(is_numeric($subTotal)){					
				}else{
					$subTotal = 0.00;
				}
				if(is_numeric($taxTotal)){					
				}else{
					$taxTotal = 0.00;
				}
				if(is_numeric($grandTotal)){					
				}else{
					$grandTotal = 0.00;
				}			
				if(is_numeric($discountTotal)){					
				}else{
					$discountTotal = 0.00;
				}	
				if(is_numeric($totalAfterDiscount)){					
				}else{
					$totalAfterDiscount = 0.00;
				}
				if(is_numeric($roundAmount)){					
				}else{
					$roundAmount = 0.00;
				}	
				
				if(is_numeric($groundTotalRound)){					
				}else{
					$groundTotalRound = 0.00;
				}
				if(isset($_POST['roundStatus'])){
					$roundStatus = $_POST['roundStatus'];
				}else{
					$roundStatus = 0;
				}
			}
			
			$sqlUpdateInvoice = "UPDATE tbinvoice SET invoice_date = '$dateInvoice', invoice_title = '$invoiceTitle', 
			invoice_from = '$invoiceFrom', invoice_terms = '$invoiceTerms',	invoice_content = '$invoiceContent', 
			invoice_attention = '$invoiceAttention', invoice_email = '$invoiceEmail',
			invoice_subTotal = '$subTotal', invoice_taxTotal = '$taxTotal', invoice_grandTotal = '$grandTotal', 
			invoice_discountTotal = '$discountTotal', invoice_totalAfterDiscount = '$totalAfterDiscount',
			invoice_roundAmount = '$roundAmount', invoice_grandTotalRound = '$groundTotalRound', invoice_roundStatus = '$roundStatus', 
			invoice_dueDate = '$dateInvoiceDue', invoice_dueDateNo = '$invoiceNoDay'
			WHERE invoice_id = '$invoiceID'";		
			
			mysqli_query($connection, $sqlUpdateInvoice) or die("error in update invoice query");		
			
			if(isset($_POST['noCol1'])){
				$aNoColumn1 = $_POST['noCol1'];			
				$aNoColumn2 = $_POST['noCol2'];
				$aNoColumn3 = $_POST['noCol3'];
				$aNoColumn4 = $_POST['noCol4'];
				$aNoColumn5 = $_POST['noCol5'];
				$aNoColumn6 = $_POST['noCol6'];
				$aNoColumn7 = $_POST['noCol7']; //select tax rate ID
				$aNoColumn8 = $_POST['noCol8']; //tax rate percent
				$aNoColumn9 = $_POST['noCol9']; //tax total
				$aNoColumn10 = $_POST['noCol10']; //grandtotal	
				$aNoColumn11 = $_POST['noCol11']; //discount Percent
				$aNoColumn12 = $_POST['noCol12']; //discount Total
				$aNoColumn13 = $_POST['noCol13']; //totalAfterDiscount			
				
				$aNoCheckbox = $_POST['invoiceCheckbox'];//this is not an array but comma separated text because array cannot be hidden field
				//explode the values and put into an array
				$aNoCheckboxSplit = explode(',', $aNoCheckbox);
				
				$countNo = count($aNoColumn1);
				$sortID = 0;
				for($i=0; $i < $countNo; $i++){
					$noValue1 = $aNoColumn1[$i];
					$noValue2 = $aNoColumn2[$i];
					$noValue3 = $aNoColumn3[$i];
					$noValue4 = $aNoColumn4[$i];
					$noValue5 = $aNoColumn5[$i];
					$noValue6 = $aNoColumn6[$i];
					$noValue7 = $aNoColumn7[$i];
					$noValue8 = $aNoColumn8[$i];
					$noValue9 = $aNoColumn9[$i];
					$noValue10 = $aNoColumn10[$i];
					$noValue11 = $aNoColumn11[$i];
					$noValue12 = $aNoColumn12[$i];
					$noValue13 = $aNoColumn13[$i];
					
					$noValueCheckbox = $aNoCheckboxSplit[$i];
					$sortID = $sortID + 1;
					
					//qty
					if(is_numeric($noValue3)){					
					}else{
						$noValue3 = 0.00;
					}
					//@price
					if(is_numeric($noValue5)){					
					}else{
						$noValue5 = 0.00;
					}
					//row total
					if(is_numeric($noValue6)){					
					}else{
						$noValue6 = 0.00;
					}
					//discount percent
					if(is_numeric($noValue11)){					
					}else{
						$noValue11 = 0.00;
					}
					//discount amount
					if(is_numeric($noValue12)){					
					}else{
						$noValue12 = 0.00;
					}
					//total after discount
					if(is_numeric($noValue13)){					
					}else{
						$noValue13 = 0.00;
					}
					
					//do it here since earlier will cause error 
					$noValue1 = makeSafe($noValue1);
					$noValue2 = makeSafe($noValue2);
					$noValue4 = makeSafe($noValue4);
					
					$sqlCreateInvoiceDetail = "INSERT INTO tbinvoicedetail(invoiceDetail_id, invoiceDetail_no1, invoiceDetail_no2, 
					invoiceDetail_no3, invoiceDetail_no4, invoiceDetail_no5, invoiceDetail_rowTotal, invoiceDetail_taxRateID,
					invoiceDetail_taxPercent, invoiceDetail_taxTotal, invoiceDetail_rowGrandTotal,
					invoiceDetail_invoiceID, invoiceDetail_bold, invoiceDetail_sortID, invoiceDetail_discountPercent, 
					invoiceDetail_discountAmount, invoiceDetail_rowTotalAfterDiscount)
					VALUES(NULL, '$noValue1', '$noValue2', '$noValue3', '$noValue4', '$noValue5', '$noValue6', '$noValue7', '$noValue8',
					'$noValue9', '$noValue10', '$invoiceID', '$noValueCheckbox', '$sortID', '$noValue11', '$noValue12', '$noValue13')";
					
					mysqli_query($connection, $sqlCreateInvoiceDetail) or die("error in create invoice detail query");				
				}			
			}	
			//Update Customer account
			$sqlUpdateCustomerAccount = "UPDATE tbcustomeraccount SET customerAccount_date = '$dateInvoice', 
			customerAccount_debit = '$groundTotalRound' WHERE (customerAccount_customerID = '$customerID') AND 
			(customerAccount_documentType = 'INV') AND (customerAccount_documentTypeID = '$invoiceID')";
			
			//Update Account Receiveable
			$sqlUpdateAccountReceiveable = "UPDATE tbaccount4 SET account4_date = '$dateInvoice', account4_debit = '$groundTotalRound' 
			WHERE (account4_account3ID = 2) AND (account4_documentType = 'INV') AND (account4_documentTypeID = '$invoiceID')";
			
			//Update Sales Account
			$sqlUpdateSalesAccount = "UPDATE tbaccount4 SET account4_date = '$dateInvoice', account4_credit = '$totalAfterDiscount'
			WHERE (account4_account3ID = 4) AND (account4_documentType = 'INV') AND (account4_documentTypeID = '$invoiceID')";
			
			mysqli_query($connection, $sqlUpdateCustomerAccount) or die("error in update customer account query");
			mysqli_query($connection, $sqlUpdateAccountReceiveable) or die("error in update account receiveable query");
			mysqli_query($connection, $sqlUpdateSalesAccount) or die("error in update sales account query");
			
			//Create Sales Tax Payable but before that delete first test since it might not created earlier
			$sqlDeleteSalesTaxPayable = "DELETE FROM tbaccount4 WHERE (account4_account3ID = 10) AND (account4_documentType = 'INV') 
			AND (account4_documentTypeID = '$invoiceID')";
			mysqli_query($connection, $sqlDeleteSalesTaxPayable) or die("error in delete sales tax payable query");
			
			if($taxTotal <> 0.00){
				$sqlCreateSalesTaxPayable = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
				account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
				VALUES(NULL, 10, '$dateInvoice', '$invoiceNo', 'INV', '$invoiceID', '$invoiceCustomer', 0, '$taxTotal')";
			
				mysqli_query($connection, $sqlCreateSalesTaxPayable) or die("error in create sales tax payable query");
			}
			
			//Create Expenses Rounded but before that delete first test since it might not created earlier, HARD CODED = 11
			$sqlDeleteRoundAccount = "DELETE FROM tbaccount4 WHERE (account4_account3ID = 11) AND (account4_documentType = 'INV') 
			AND (account4_documentTypeID = '$invoiceID')";
			mysqli_query($connection, $sqlDeleteRoundAccount) or die("error in delete account round query");	
			
			//Rounded amount if exist, store into Expenses Round Account 
			if($roundAmount == 0.00){	
				//do nothing
			}elseif($roundAmount > 0.00){
				//positive, Credit Expense account, gain to company
				$sqlCreateRoundAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
				account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
				VALUES(NULL, 11, '$dateInvoice', '$invoiceNo', 'INV', '$invoiceID', '$invoiceCustomer', 0, '$roundAmount')";
				
				mysqli_query($connection, $sqlCreateRoundAccount) or die("error in create account round credit query");	
			
			}elseif($roundAmount < 0.00){
				//negative, Debit Expense account, loss to company
				$absRoundAmount = abs($roundAmount); //remove negative sign
				$sqlCreateRoundAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
				account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
				VALUES(NULL, 11, '$dateInvoice', '$invoiceNo', 'INV', '$invoiceID', '$invoiceCustomer', '$absRoundAmount', 0)";
				
				mysqli_query($connection, $sqlCreateRoundAccount) or die("error in create account round debit query");	
			}
			
			
			
			
			
			
			
			
			
			
			
			
			
			//redirect to editInvoice.php form
			header("Location: editInvoice.php?idInvoice=$invoiceID&idCustomer=$customerID");
	
		}elseif($buttonValue == "Convert Delivery Order"){
			
			$deliveryOrderNo = makeSafe($_POST['deliveryOrderNo']);
			$dateDeliveryOrder = convertMysqlDateFormat($_POST['deliveryOrderDate']);			
			$deliveryOrderFrom = makeSafe($_POST['invoiceFrom']);
			$deliveryOrderTitle = makeSafe($_POST['invoiceTitle']);

			
			$deliveryOrderContent = $_POST['invoiceContent'];
			$deliveryOrderAttention = makeSafe($_POST['invoiceAttention']);
			$deliveryOrderEmail = makeSafe($_POST['invoiceEmail']);	

			// delivery order terms need to get from tbcompany			
			$sqlDeliveryOrderTerms = "SELECT company_deliveryOrderTerms FROM tbcompany WHERE company_id = 1";
			$resultDeliveryOrderTerms = mysqli_query($connection, $sqlDeliveryOrderTerms) or die("error in company delivery order terms query");
			$rowDeliveryOrderTerms = mysqli_fetch_row($resultDeliveryOrderTerms);
			$deliveryOrderTerms = $rowDeliveryOrderTerms[0];
			
			$quotationID = $_POST['idQuotation'];
			$quotationNo = "";
			if($quotationID<>0){$quotationNo = $_POST['quotationNo'];}
			
	
			$subTotal = 0.00;
			$taxTotal = 0.00;
			$grandTotal = 0.00;
			$discountTotal = 0.00;
			$totalAfterDiscount = 0.00;
			$roundAmount = 0.00;
			$groundTotalRound = 0.00;
			$roundStatus = 0;
			
			if(isset($_POST['noCol1'])){
				$subTotal = makeSafe($_POST['subTotal']);
				$taxTotal = makeSafe($_POST['taxTotal']);
				$grandTotal = makeSafe($_POST['grandTotal']);
				$discountTotal = makeSafe($_POST['discountTotal']);
				$totalAfterDiscount = makeSafe($_POST['totalAfterDiscount']);
				$roundAmount = makeSafe($_POST['roundAmount']);
				$groundTotalRound = makeSafe($_POST['groundTotalRound']);		
				
				if(is_numeric($subTotal)){					
				}else{
					$subTotal = 0.00;
				}
				if(is_numeric($taxTotal)){					
				}else{
					$taxTotal = 0.00;
				}
				if(is_numeric($grandTotal)){					
				}else{
					$grandTotal = 0.00;
				}			
				if(is_numeric($discountTotal)){					
				}else{
					$discountTotal = 0.00;
				}	
				if(is_numeric($totalAfterDiscount)){					
				}else{
					$totalAfterDiscount = 0.00;
				}
				if(is_numeric($roundAmount)){					
				}else{
					$roundAmount = 0.00;
				}	
				
				if(is_numeric($groundTotalRound)){					
				}else{
					$groundTotalRound = 0.00;
				}
				
				if(isset($_POST['roundStatus'])){
					$roundStatus = $_POST['roundStatus'];
				}else{
					$roundStatus = 0;
				}			
			}
			
			$sqlCreateDeliveryOrder = "INSERT INTO tbdeliveryorder(deliveryOrder_id, deliveryOrder_no, deliveryOrder_date, deliveryOrder_customerID, 
			deliveryOrder_title, deliveryOrder_content, deliveryOrder_from, deliveryOrder_terms, deliveryOrder_attention, deliveryOrder_email, 
			deliveryOrder_subTotal, deliveryOrder_taxTotal, deliveryOrder_grandTotal, deliveryOrder_discountTotal, deliveryOrder_totalAfterDiscount, 
			deliveryOrder_roundAmount, deliveryOrder_grandTotalRound, deliveryOrder_roundStatus, deliveryOrder_invoiceID, deliveryOrder_invoiceNo, 
			deliveryOrder_quotationID, deliveryOrder_quotationNo) 
			VALUES(NULL, '$deliveryOrderNo', '$dateDeliveryOrder', '$customerID', '$deliveryOrderTitle', '$deliveryOrderContent', '$deliveryOrderFrom', 
			'$deliveryOrderTerms', '$deliveryOrderAttention', '$deliveryOrderEmail', '$subTotal', 
			'$taxTotal', '$grandTotal', '$discountTotal', '$totalAfterDiscount', '$roundAmount', '$groundTotalRound', '$roundStatus',
			'$invoiceID', '$invoiceNo', '$quotationID', '$quotationNo')";
			
			mysqli_query($connection, $sqlCreateDeliveryOrder) or die("error in create delivery order query");
			
			//create the delivery order detail records
			$deliveryOrderID = mysqli_insert_id($connection);
			
			if(isset($_POST['noCol1'])){
				$aNoColumn1 = $_POST['noCol1'];			
				$aNoColumn2 = $_POST['noCol2'];
				$aNoColumn3 = $_POST['noCol3'];
				$aNoColumn4 = $_POST['noCol4'];
				$aNoColumn5 = $_POST['noCol5'];
				$aNoColumn6 = $_POST['noCol6'];
				$aNoColumn7 = $_POST['noCol7']; //select tax rate ID
				$aNoColumn8 = $_POST['noCol8']; //tax rate percent
				$aNoColumn9 = $_POST['noCol9']; //tax total
				$aNoColumn10 = $_POST['noCol10']; //grandtotal			
				$aNoColumn11 = $_POST['noCol11']; //discount Percent
				$aNoColumn12 = $_POST['noCol12']; //discount Total
				$aNoColumn13 = $_POST['noCol13']; //totalAfterDiscount			
				
				$aNoCheckbox = $_POST['deliveryOrderCheckbox'];//this is not an array but comma separated text because array cannot be hidden field
				//explode the values and put into an array
				$aNoCheckboxSplit = explode(',', $aNoCheckbox);				
				
				$countNo = count($aNoColumn1);
				$sortID = 0;
				for($i=0; $i < $countNo; $i++){
					$noValue1 = $aNoColumn1[$i];
					$noValue2 = $aNoColumn2[$i];
					$noValue3 = $aNoColumn3[$i];
					$noValue4 = $aNoColumn4[$i];
					$noValue5 = $aNoColumn5[$i];
					$noValue6 = $aNoColumn6[$i];
					$noValue7 = $aNoColumn7[$i];
					$noValue8 = $aNoColumn8[$i];
					$noValue9 = $aNoColumn9[$i];
					$noValue10 = $aNoColumn10[$i];				
					$noValue11 = $aNoColumn11[$i];
					$noValue12 = $aNoColumn12[$i];
					$noValue13 = $aNoColumn13[$i];
					
					$noValueCheckbox = $aNoCheckboxSplit[$i];
					$sortID = $sortID + 1;
					//qty
					if(is_numeric($noValue3)){					
					}else{
						$noValue3 = 0.00;
					}
					//@price
					if(is_numeric($noValue5)){					
					}else{
						$noValue5 = 0.00;
					}
					//row total
					if(is_numeric($noValue6)){					
					}else{
						$noValue6 = 0.00;
					}					
					//discount percent
					if(is_numeric($noValue11)){					
					}else{
						$noValue11 = 0.00;
					}
					//discount amount
					if(is_numeric($noValue12)){					
					}else{
						$noValue12 = 0.00;
					}
					//total after discount
					if(is_numeric($noValue13)){					
					}else{
						$noValue13 = 0.00;
					}
					
					//do it here since earlier will cause error 
					$noValue1 = makeSafe($noValue1);
					$noValue2 = makeSafe($noValue2);
					$noValue4 = makeSafe($noValue4);							
					
					$sqlCreateDeliveryOrderDetail = "INSERT INTO tbdeliveryorderdetail(deliveryOrderDetail_id, deliveryOrderDetail_no1, deliveryOrderDetail_no2, 
					deliveryOrderDetail_no3, deliveryOrderDetail_no4, deliveryOrderDetail_no5, deliveryOrderDetail_rowTotal, deliveryOrderDetail_taxRateID, 
					deliveryOrderDetail_taxPercent, deliveryOrderDetail_taxTotal, deliveryOrderDetail_rowGrandTotal, 
					deliveryOrderDetail_deliveryOrderID, deliveryOrderDetail_bold, deliveryOrderDetail_sortID, deliveryOrderDetail_discountPercent, 
					deliveryOrderDetail_discountAmount, deliveryOrderDetail_rowTotalAfterDiscount) 
					VALUES(NULL, '$noValue1', '$noValue2', '$noValue3', '$noValue4', '$noValue5', '$noValue6', '$noValue7', '$noValue8', 
					'$noValue9', '$noValue10', '$deliveryOrderID', '$noValueCheckbox', '$sortID', '$noValue11', '$noValue12', '$noValue13')";
					
					mysqli_query($connection, $sqlCreateDeliveryOrderDetail) or die("error in create delivery order detail query");					
				}			
			}
			
			//update tbinvoice with Delivery Order No			
			$sqlUpdateInvoiceDeliveryOrderNo = "UPDATE tbinvoice SET invoice_deliveryOrderNo = '$deliveryOrderNo', invoice_deliveryOrderID = '$deliveryOrderID' 
			WHERE invoice_id = '$invoiceID'";			
			mysqli_query($connection, $sqlUpdateInvoiceDeliveryOrderNo) or die("error in update invoice delivery order no query");
		
		
			//update tbquotation with Delivery Order No if Invoice convert from Quotation
			if($quotationID <> 0){				
				$sqlUpdateQuotationDeliveryOrderNo = "UPDATE tbquotation SET quotation_deliveryOrderNo = '$deliveryOrderNo', quotation_deliveryOrderID = '$deliveryOrderID' 
				WHERE quotation_id = '$quotationID'";	
				mysqli_query($connection, $sqlUpdateQuotationDeliveryOrderNo) or die("error in update quotation delivery order no query");				
			}
			
			header ("Location: editDeliveryOrder.php?idDeliveryOrder=$deliveryOrderID&idCustomer=$customerID");	
		
		
		}
	}else{
		$invoiceID = $_GET['idInvoice'];
		$customerID = $_GET['idCustomer'];		
	}
	
	//get the customer info	
	$sqlCustomerInfo = "SELECT customer_name, customer_tel, customer_address FROM tbcustomer WHERE customer_id = '$customerID'";	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer query");
	$resultCustomerInfo2 = mysqli_fetch_row($resultCustomerInfo);
	
	//get the invoice info	
	$sqlInvoiceInfo = "SELECT invoice_no, invoice_date, invoice_title, invoice_from, invoice_terms, 
	invoice_attention, invoice_email, invoice_subTotal, 
	invoice_taxTotal, invoice_grandTotal, invoice_discountTotal, invoice_totalAfterDiscount, 
	invoice_roundAmount, invoice_grandTotalRound, invoice_roundStatus, invoice_content, 
	invoice_quotationID, invoice_quotationNo, invoice_deliveryOrderID, invoice_deliveryOrderNo, invoice_dueDate, invoice_dueDateNo,
	invoice_status FROM tbinvoice WHERE invoice_id = '$invoiceID'";
	
	$resultInvoiceInfo = mysqli_query($connection, $sqlInvoiceInfo) or die("error in invoice query");
	$rowInvoiceInfo = mysqli_fetch_row($resultInvoiceInfo);
	$invoiceStatus = $rowInvoiceInfo[22];
	
	//show DO number only if Active Invoice	
	if($invoiceStatus == 'a'){	
		$strLastDeliveryOrderNo = "";	
		if($rowInvoiceInfo[18] <> 0){
		
		}else{
			//get the MAX id from tbdeliveryorder
			$sqlMaxIDdeliveryOrder = "SELECT deliveryOrder_no FROM tbdeliveryorder ORDER BY deliveryOrder_id DESC LIMIT 0,1";
			$resultMaxDeliveryOrder = mysqli_query($connection, $sqlMaxIDdeliveryOrder) or die("error in max ID delivery order query");
			
			if(mysqli_num_rows($resultMaxDeliveryOrder) > 0){
				$rowLastDeliveryOrderNo = mysqli_fetch_row($resultMaxDeliveryOrder);
				$strLastDeliveryOrderNo = $rowLastDeliveryOrderNo[0];
			}
		}
	}else{
		$strLastDeliveryOrderNo = "";
	}
	
	//get the invoice details
	$sqlInvoiceDetailInfo = "SELECT invoiceDetail_no1, invoiceDetail_no2, invoiceDetail_no3, invoiceDetail_no4, invoiceDetail_no5, 
	invoiceDetail_rowTotal, invoiceDetail_taxRateID, invoiceDetail_taxPercent, invoiceDetail_taxTotal, invoiceDetail_rowGrandTotal, 
	invoiceDetail_bold, invoiceDetail_sortID, invoiceDetail_discountPercent, invoiceDetail_discountAmount, 
	invoiceDetail_rowTotalAfterDiscount FROM tbinvoicedetail 
	WHERE invoiceDetail_invoiceID = '$invoiceID' ORDER BY invoiceDetail_sortID ASC";
	
	$resultInvoiceDetailInfo = mysqli_query($connection, $sqlInvoiceDetailInfo) or die("error in invoice detail query");	
	
	//-----------------------------------------------------
	//get all the tax rates list and put inside array
	$aTaxRateList = array();
	$aTaxRateListDB = array();//hold the list to prevent multiple queries
	
	
	//get the tax rates
	$sqlGetTaxRate = "SELECT taxRate_id, taxRate_code FROM tbtaxrate ORDER BY taxRate_default DESC, taxRate_code ASC";	
	$resultGetTaxRate = mysqli_query($connection, $sqlGetTaxRate) or die("error in get tax rate query");
	
	$d = 0;
	
	while($rowTaxRateList = mysqli_fetch_array($resultGetTaxRate)){	
		$aTaxRateList[] = $rowTaxRateList[0];	
		$aTaxRateListDB[$d][0] = $rowTaxRateList[0];
		$aTaxRateListDB[$d][1] = $rowTaxRateList[1];
		$d = $d + 1;
	}
	
	// php function to search multi-dimensional array
	function searchArray($key, $st, $array) {
	   foreach ($array as $k => $v) {
		   if ($v[$key] === $st) {
			   return $k;
		   }
	   }
	   return null;
	}
	
	
?>
<html>
<head>
<title>Invoice Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="js/textAreaStyle.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	$( function() {
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
		//$( "#demo3" ).datepicker({ dateFormat: "dd/mm/yy"});
		$( "#demo4" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
</script>
<style type="text/css">
table.mystyle
{
	
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 13px; /* Added font-size */
}
.mystyle td, .mystyle th
{
	margin: 0;
	padding: 2px;
	border-width: 1px 1px 0 0;
	border-style: solid;
	border-color: #CDD0D1;
}

.notfirst:hover
{
	background-color: #AFCCB0;
}
input:focus
{
	background-color: AFCCB0;
}
textarea:focus
{
	background-color: AFCCB0;
}
select:focus
{
	background-color: AFCCB0;
}

textarea {
    border: none;
    outline: none;
}


.ui-widget.ui-widget-content {
  border: 1px solid #000000;
  padding: 0;
}

/* show the INVOICE WORD ON CLOSE BUTTON*/
	 .ui-button-icon-only {
        width: 3em;
        box-sizing: border-box;
        text-indent: -75px;
        white-space: nowrap;
    }
	
	
	
	
	main2 {
		margin-bottom: 100%;
	}

  .floating-menu {
    font-family: sans-serif;
    background: yellowgreen;
    padding: 5px;
    width: 130px;
    z-index: 100;
    position: fixed;
    bottom: 500px;
    right: 0px;
  }

  .floating-menu a, 
  .floating-menu h3 {
    font-size: 0.9em;
    display: block;
    margin: 0 0.5em;
    color: white;
  }
</style>
<script>
var ajaxResult = []; //to store the array of objects
var namingValue = 1;

function GetTaxRateList(){
	
	$.ajax({
		type : 'POST',
		url : 'getTaxRate.php',		
		dataType : 'json', //return value type
		async: false, //To be sure that nothing happens before the AJAX request is achieved, if not first click not working
		success : function(response)
		{			
			//array of objects
			ajaxResult = response;           
		}	
	})
}

function CalculateDueDate(){
		
		if(isNaN(document.getElementById('invoiceNoDay').value)){
			document.getElementById('invoiceDueDate').value = document.getElementById('demo2').value;
		}else{		
			
			var dueDate = Number(document.getElementById('invoiceNoDay').value);			
			var convertDateToMDYformat = (document.getElementById('demo2').value).split("/");//convert Date to MDY format
			var MDYformat = convertDateToMDYformat[1] + "/" + convertDateToMDYformat[0] + "/" + convertDateToMDYformat[2];			
			
			const d = new Date(MDYformat); //create a date object
			
			d.setDate(d.getDate() + dueDate);			
			var dateValue = d.getDate()
			var monthValue = d.getMonth()+1;//month index in 0 in javascript
			var yearValue = d.getFullYear();			
			
			if(dateValue<10){dateValue = "0"+dateValue};
			if(monthValue<10){monthValue = "0"+monthValue};			
			var finalDueDate = dateValue + "/" + monthValue + "/" + yearValue;
			
			document.getElementById('invoiceDueDate').value = finalDueDate;			
		}		
	}





function GetTaxRate(n){
	//console.log(n);
	var e = document.getElementById(n);
	var rateID = e.options[e.selectedIndex].value;
	//console.log(rateID);	
	var rowArray = SearchArray(rateID, ajaxResult);	
	var selectName = n;
	var aSelectName = selectName.split("|");
	var aSelectNo = "";
	aSelectNo = aSelectName[1];
	
	var rateName = "";	
	rateName = "rate|" + aSelectNo;	
	document.getElementById(rateName).value = rowArray;
	CalculateRowTotal();
}

function SearchArray(nameKey, myArray){
	//search the array of objects and get the particular value by the correct field
	for(var i = 0; i < myArray.length; i++){
		if(myArray[i].id === nameKey){
			return myArray[i].taxRateValue;
		}		
	}	
}


function popupwindow(){	
	//loop through the table to see which rows has focus
	var myTab = document.getElementById('empTable');        
	var focusRow = 1;
	// LOOP THROUGH EACH ROW OF THE TABLE.
	for (row = 1; row < myTab.rows.length; row++) {				
			var element = myTab.rows.item(row).cells[3];
			var myElement = element.childNodes[0].id;				
			//ActiveElement is the element id with focus
			if(myElement === document.activeElement.id){
				//console.log(focusRow);
				break;					
			}            
		focusRow = focusRow + 1;
	}	
	var focusRowString = focusRow.toString(); //convert to string to attach to GET string
	var page = "searchProduct.php?idRowFocus=";	
	page = page + focusRowString;	
	
	
	var $dialog = $('<div></div>')
		.html('<iframe id ="productList" name ="productList" style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
	   .dialog({		  
		   autoOpen: false,
		   modal: true,
		   closeText: 'INVOICE',
		   height: 500,
		   width: 800,		   
		   title: "Product & Servis List",
		   close: function (dialogclose, ui) {			   
				$('body').css("overflow", "auto"); //body can scrol when modal close
				
				var list, index;
				list = document.getElementsByClassName("styled");	//gets a node list, not single element			
				for(index = 0; index < list.length; ++index){
					list[index].setAttribute('ondblclick', 'popupwindow()'); //NO USE SELECTOR TO CHOOSE ELEMENT, add the attribute back
				}		
				
				if(event.which == 27){
					//do nothing because ESCAPE KEY PRESSED					
					
				} else {
					//1 TO 3 means mouse button value pressed
					//send parameters back to main page					
					var selectedProduct = document.getElementById('productList').contentWindow.document.getElementById('selectedProduct').value;									
				
					//process the returned product id & row to get product name & price etc					
					var arraySelectedProduct = selectedProduct.split("|");
					var rowSelected = arraySelectedProduct[0];
					var productSelected = arraySelectedProduct[1];					
				
					//use a function					
					if(productSelected != 0){InsertProductList(rowSelected, productSelected);}					
				}				
				$dialog.dialog('destroy');				
		   }		   
	   });	
	
	$dialog.dialog('open');
	$('body').css("overflow", "hidden"); //body cannot scrol when modal open
	
	var x = document.getElementsByClassName("styled");//this method okay for removing attribute
	var i;
	for(i = 0; i < x.length; i++){
		//remove the dblclick attribute to prevent multi modal 		
		$(x[i]).removeAttr("ondblclick");	//SELECTOR TO CHOOSE ELEMENT	
	}	

}

function InsertProductList(x, y){
	var rowSelected = x;
	var productID = y;	
	var data = "productID="+productID;	
	
	$.ajax({
		type: 'POST',
		url: 'getProductInfo.php',
		data: data,
		dataType: 'text',
		success:function(f){
			
			var splitProductInfo = f.split('++++');
			
			var productName = splitProductInfo[0];
			var productPrice = splitProductInfo[1];
			var productUOM = splitProductInfo[3];
			
			//insert process
			var myTab = document.getElementById('empTable');
			var elementProductName = myTab.rows.item(rowSelected).cells[3];
			var elementProductUOM = myTab.rows.item(rowSelected).cells[5];
			var elementProductPrice = myTab.rows.item(rowSelected).cells[6];			
			
			elementProductName.childNodes[0].value = productName; 
			elementProductPrice.childNodes[0].value = productPrice;
			elementProductUOM.childNodes[0].value = productUOM;
			CalculateRowTotal();
		}		
	})		
}


	function CheckDeliveryOrderNo(){		
		var checkEmptyDeliveryOrderNo = $("#deliveryOrderNo").val();
		if(checkEmptyDeliveryOrderNo===""){
			$("#infoDO").html("<img border='0' src='images/Delete.ico'>");
			document.getElementById("convertDeliveryOrder").disabled = true;
		}else{			
			var data = "deliveryOrderNo="+$("#deliveryOrderNo").val();
			
			$.ajax({			 
				type : 'POST',
				url : 'checkExistingDeliveryOrder.php',
				data : data,
				dataType : 'json',
				success : function(r)
				{
					if(r=="0"){
						$("#infoDO").html("<img border='0' src='images/Yes.ico'>");
						document.getElementById("convertDeliveryOrder").disabled = false;	
					}else{									
						//Exists					
					   $("#infoDO").html("<img border='0' src='images/Delete.ico'>");
					   document.getElementById("convertDeliveryOrder").disabled = true;					
					}				
				}
				
			}	
			)	
		}	
	}







function CalculateRowTotal(){	
	//loop through the table to see which rows are selected
	var myTab = document.getElementById('empTable');
	var subtotalValue = 0;
	var discountTotalValue = 0;
	var totalAfterDiscountValue = 0;
	var taxTotalValue = 0;
	var grandTotalValue = 0;
	
	document.getElementById('subTotal').value = "";
	document.getElementById('discountTotal').value = "";
	document.getElementById('totalAfterDiscount').value = "";
	document.getElementById('taxTotal').value = "";
	document.getElementById('grandTotal').value = "";
	
	// LOOP THROUGH EACH ROW OF THE TABLE.
	for (row = 1; row < myTab.rows.length; row++) {
		 for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.
			if(c == 4){
				var element = myTab.rows.item(row).cells[c];				
						
				if((isNaN(element.childNodes[0].value)) ||(element.childNodes[0].value.trim() == "")){
					actualQty = 1;
				}else{
					if(element.childNodes[0].value==""){
						actualQty = 1;
					}else{
						actualQty = element.childNodes[0].value;	
					}		
				}						
			}
			
			if(c == 6){
				var element = myTab.rows.item(row).cells[c];
				var element2 = myTab.rows.item(row).cells[7];
				var rowTotal = 0;
				var actualPrice = 0;
				
				if((isNaN(element.childNodes[0].value)) ||(element.childNodes[0].value.trim() == "")){		
					element2.childNodes[0].value = "0.00";
					
				}else{
					if(element.childNodes[0].value==""){
						element2.childNodes[0].value = "0.00";
						
					}else{			
						var actualPrice = parseFloat(element.childNodes[0].value);
						rowTotal = actualQty * actualPrice;
						element2.childNodes[0].value = rowTotal.toFixed(2);
						subtotalValue = subtotalValue + (actualQty * actualPrice);
					}		
				}				
			}		
		
			
				if(c == 8){
				var element = myTab.rows.item(row).cells[c];//discount %
				var element2 = myTab.rows.item(row).cells[9];
				var element3 = myTab.rows.item(row).cells[10];
				var element4 = myTab.rows.item(row).cells[7]; //subtotal	
				var rowTotalAfterDiscount = 0.00;
					
				if((isNaN(element.childNodes[0].value)) ||(element.childNodes[0].value.trim() == "")){
					element2.childNodes[0].value = "0.00";
					element3.childNodes[0].value = element4.childNodes[0].value;
					rowTotalAfterDiscount = parseFloat(element4.childNodes[0].value);
				}else{
					
					var rowSubtotal = element4.childNodes[0].value;
					var rowDiscountRate = element.childNodes[0].value;
					var rowDiscountAmount = (rowSubtotal * rowDiscountRate)/100;
					element2.childNodes[0].value = rowDiscountAmount.toFixed(2);
					//parseFloat function to change string to number
					rowTotalAfterDiscount = parseFloat(rowSubtotal) - parseFloat(rowDiscountAmount);
					element3.childNodes[0].value = rowTotalAfterDiscount.toFixed(2);
					discountTotalValue = discountTotalValue + parseFloat(rowDiscountAmount);
					
				}
				totalAfterDiscountValue = totalAfterDiscountValue + parseFloat(rowTotalAfterDiscount);
			}		
		
			if(c == 12){
				var element = myTab.rows.item(row).cells[c];
				var element2 = myTab.rows.item(row).cells[13];
				var element3 = myTab.rows.item(row).cells[14];
				var element4 = myTab.rows.item(row).cells[10];				
				
				var rowRate = 0.00;
				var rowRateTotal = 0.00;
				var rowGrandTotal = 0.00;
				var rowTotalAfterDiscount = 0.00;
				rowTotalAfterDiscount = parseFloat(element4.childNodes[0].value);
				
				if(element.childNodes[0].value == "0.00"){
					element2.childNodes[0].value = "0.00";
					element3.childNodes[0].value = element4.childNodes[0].value;					
					rowGrandTotal = parseFloat(element4.childNodes[0].value);
					
				}else{
					
					if(element4.childNodes[0].value == "0.00"){
						element2.childNodes[0].value = "0.00";
						element3.childNodes[0].value = "0.00";
					}else{				
						rowRate = parseFloat(element.childNodes[0].value);
						rowRateTotal = (rowTotalAfterDiscount * rowRate)/100;
						//parseFloat function to change string to number
						rowGrandTotal = parseFloat(rowTotalAfterDiscount) + parseFloat(rowRateTotal);
						element2.childNodes[0].value = rowRateTotal.toFixed(2);		
						element3.childNodes[0].value = rowGrandTotal.toFixed(2);
						taxTotalValue = taxTotalValue + parseFloat(rowRateTotal);
					}				
				}				
				grandTotalValue = grandTotalValue + parseFloat(rowGrandTotal);	
			}		
		
		}	
	}	
	document.getElementById('subTotal').value = subtotalValue.toFixed(2);
	document.getElementById('discountTotal').value = discountTotalValue.toFixed(2);	
	document.getElementById('totalAfterDiscount').value = totalAfterDiscountValue.toFixed(2);
	document.getElementById('taxTotal').value = taxTotalValue.toFixed(2);					
	document.getElementById('grandTotal').value = grandTotalValue.toFixed(2);
	
	if(document.getElementById('roundStatus').checked == true){
		//the rounded Grand total
		var factor = 0.05 //nearest 0.05
		var valueGrandTotalRound =  Math.round(grandTotalValue/factor)*factor;
		var roundAmount = valueGrandTotalRound - grandTotalValue;
		document.getElementById('groundTotalRound').value = valueGrandTotalRound.toFixed(2);	
		document.getElementById('roundAmount').value = roundAmount.toFixed(2);
	}else{
		document.getElementById('roundAmount').value = "0.00";
		document.getElementById('groundTotalRound').value = grandTotalValue.toFixed(2);
	}
	
}

function check(it) {
		tr = it.parentElement.parentElement;
		var textareas = tr.getElementsByTagName("textarea");
		for (var i = 0; i < textareas.length; i++) {
		  textareas[i].style.fontWeight = (it.checked) ? "bold" : "normal";
		}
		
		//loop through the table to see which rows are selected
		var myTab = document.getElementById('empTable');
        var values = new Array();
		
		// LOOP THROUGH EACH ROW OF THE TABLE.
        for (row = 1; row < myTab.rows.length; row++) {
			 for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'checkbox') {
                    if(element.childNodes[0].checked == true){
						values.push(element.childNodes[0].value);
					}else{
						values.push('0');
					}				
				}
            }
        }		
        //console.log(values);
		document.getElementById('invoiceCheckbox').value = values;
}
	
	function DisableSubmitButton(){		
		document.getElementById("bt").disabled = true;		
	}
	
	function getButtonID(clickedID){
		console.log(clickedID);
		document.getElementById("buttonClicked").value = clickedID;
	}
	
	function CheckAndSubmit(){
		//check which button clicked
		var clickedButton = document.getElementById("buttonClicked").value;
		
		if(clickedButton=='bt'){
			//EDIT INVOICE
			var itemName = document.getElementById("invoiceNo");
			if(itemName.value.length==0){
				alert("Must enter Invoice No!");
				invoiceNo.focus();
				return false;
			}	
			var itemName = document.getElementById("demo2");
			if(itemName.value.length==0){
				alert("Must enter Invoice date!");
				demo2.focus();
				return false;
			}		
			var r = confirm("Do you want to Edit Invoice?");
			if(r==false){
				return false;
			}
	
		}else if(clickedButton=='convertDeliveryOrder'){
			console.log("ice cream soda");
			//CREATE DELIVERY ORDER		
			var checkEmptyDeliveryOrderNo = $("#deliveryOrderNo").val();
			if(checkEmptyDeliveryOrderNo===""){
				$("#infoDO").html("<img border='0' src='images/Delete.ico'>");
				document.getElementById("convertDeliveryOrder").disabled = true;
				alert("Must enter Delivery Order No!");
				deliveryOrderNo.focus();
			}else{			
				var data = "deliveryOrderNo="+$("#deliveryOrderNo").val();
				
				$.ajax({			 
					type : 'POST',
					url : 'checkExistingDeliveryOrder.php',
					data : data,
					dataType : 'json',
					success : function(r)
					{
						if(r=="0"){
							$("#infoDO").html("<img border='0' src='images/Yes.ico'>");
							document.getElementById("convertDeliveryOrder").disabled = false;						   
						}else{
							//Exists					
						   $("#infoDO").html("<img border='0' src='images/Delete.ico'>");
						   document.getElementById("convertDeliveryOrder").disabled = true;							
						}
						ResubmitForm(r);
					}
					
					}	
				)	
			}		
	
			return false;
	
		}	
	}	
	
	
	function ResubmitForm(g){		
		if(g==0){			
			var u = confirm("Do you want to Convert this INVOICE to DELIVERY ORDER?");
			if(u==true){
				$('#invoiceForm').attr('onsubmit', 'return true');
			jQuery("#convertDeliveryOrder").trigger('click'); //auto submit by clicking the submit button id
			}		
		
		}else{
			alert("This Delivery Order No already exist in Database!");			
		}	
	}	
	
	
	
	
	
	
	
	

// ARRAY FOR HEADER.
    var arrHead = new Array();
    arrHead = ['', 'B', 'No', 'Description', 'Qty', 'Unit', 'Price', 'Total', 'Disc%', 'Disc', 'A.Disc', 'Code', 'Rate', 'Tax', 'Total'];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.
	
    // FIRST CREATE A TABLE STRUCTURE BY ADDING A FEW HEADERS AND
    // ADD THE TABLE TO YOUR WEB PAGE.
    function createTable() {
        GetTaxRateList();		
		
		var empTable = document.createElement('table');
        empTable.setAttribute('id', 'empTable');            // SET THE TABLE ID.
		empTable.setAttribute('width', '1200px');
		empTable.setAttribute('border', '1px');
		empTable.setAttribute('cellpadding', '0px');
		empTable.setAttribute('class', 'mystyle');

        var tr = empTable.insertRow(0);

         for (var h = 0; h < arrHead.length; h++) {
            var th = document.createElement('th');          // TABLE HEADER.
            th.innerHTML = arrHead[h];
            tr.appendChild(th);
        } 

        var div = document.getElementById('cont');
        div.appendChild(empTable);    // ADD THE TABLE TO YOUR WEB PAGE.
		//document.getElementById("bt").disabled = true;  Not sure why this was disabled earlier.
    }
	
	
	function createTableTotal() {
		var empTableTotal = document.createElement('table');
		empTableTotal.setAttribute('id', 'empTableTotal');            // SET THE TABLE ID.
		empTableTotal.setAttribute('width', '1200px');
		empTableTotal.setAttribute('border', '1px');
		empTableTotal.setAttribute('cellpadding', '0px');
		empTableTotal.setAttribute('class', 'mystyle');
		
		//subtotal
		var tr = empTableTotal.insertRow(0);		
		var td = document.createElement('td');		
		
		td = tr.insertCell(0);
		td.width = "76%";		
		
		td = tr.insertCell(1);
		td.width = "15%";		
		td.innerHTML = "Subtotal";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');		
		
		ele.setAttribute('id', 'subTotal');
		ele.setAttribute('name', 'subTotal');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		
		td.appendChild(ele);
		
		//discount amount total
		tr = empTableTotal.insertRow(1);
		td = document.createElement('td');
		
		td = tr.insertCell(0);
		td.width = "76%";
		
		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Discount Total";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		ele.setAttribute('id', 'discountTotal');
		ele.setAttribute('name', 'discountTotal');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);		
		
		//total after discount
		tr = empTableTotal.insertRow(2);
		td = document.createElement('td');
		
		td = tr.insertCell(0);
		td.width = "76%";
		
		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Total After Discount";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		ele.setAttribute('id', 'totalAfterDiscount');
		ele.setAttribute('name', 'totalAfterDiscount');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);
		
		//tax
		tr = empTableTotal.insertRow(3);
		td = document.createElement('td');
		
		td = tr.insertCell(0);
		td.width = "76%";
		
		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Tax";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		ele.setAttribute('id', 'taxTotal');
		ele.setAttribute('name', 'taxTotal');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);
		
		//grand total
		tr = empTableTotal.insertRow(4);
		td = document.createElement('td'); 
		
		td = tr.insertCell(0);
		td.width = "76%";
		
		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Total";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		ele.setAttribute('id', 'grandTotal');
		ele.setAttribute('name', 'grandTotal');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);

		//round amount
		tr = empTableTotal.insertRow(5);
		td = document.createElement('td'); 
		
		td = tr.insertCell(0);
		td.width = "76%";

		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Round";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		var ele2 = document.createElement('input');
		
		ele.setAttribute('id', 'roundAmount');
		ele.setAttribute('name', 'roundAmount');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		ele2.setAttribute('type', 'checkbox');
		ele2.setAttribute('id', 'roundStatus');
		ele2.setAttribute('name', 'roundStatus');
		ele2.setAttribute('value', '1');
		ele2.setAttribute('onclick', 'CalculateRowTotal()');
		
		td.appendChild(ele);
		td.appendChild(ele2);

		//rounded grand total
		tr = empTableTotal.insertRow(6);
		td = document.createElement('td'); 
		
		td = tr.insertCell(0);
		td.width = "76%";

		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Rounded Total";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');		
		
		ele.setAttribute('id', 'groundTotalRound');
		ele.setAttribute('name', 'groundTotalRound');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);		
		
		var div = document.getElementById('cont2');
		div.appendChild(empTableTotal);
	
	}
	

    // ADD A NEW ROW TO THE TABLE.s
    function addRow2() {
        var empTab = document.getElementById('empTable');
        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
		
		var selectName = "";
		var rateName = "";        
		var rowCounter = 1;
		
        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                // ADD A BUTTON.
                var button = document.createElement('input');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('value', 'del');

                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('onclick', 'removeRow(this)');
                td.appendChild(button);
            }
			else if (c == 1){
				//create Checkbox
				var ele = document.createElement('input');
                ele.setAttribute('type', 'checkbox');
                ele.setAttribute('value', '1');				
				ele.setAttribute('name', 'noCheckbox[this]');
				ele.setAttribute('onclick', 'check(this)');
				td.appendChild(ele);				
			}
            else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
                var ele = document.createElement('textarea');
                //ele.setAttribute('type', 'text');
               // ele.setAttribute('value', '');				
								
				if(c == 2){	
					//NO
					ele.setAttribute('id', 'noCol1[]');					
					ele.setAttribute('class', 'styled2');					
					ele.setAttribute('name', 'noCol1[]');
					ele.setAttribute('maxlength', '6');
					td.appendChild(ele);
				}
				if(c == 3){
					//DESCRIPTION
					var idName = "id" + Math.random().toString(16).slice(2);
					ele.setAttribute('id', idName);	
					//ele.setAttribute('id', 'noCol2[]');
					ele.setAttribute('class', 'styled');					
					ele.setAttribute('name', 'noCol2[]');
					ele.setAttribute('maxlength', '200');
					ele.setAttribute('ondblclick', 'popupwindow()');
					ele.style.width = '480px';
					td.appendChild(ele);
				}
				if(c == 4){
					//QUANTITY
					ele.setAttribute('id', 'noCol3[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol3[]');
					ele.setAttribute('maxlength', '10');
					ele.setAttribute('onblur', 'CalculateRowTotal()');
					td.appendChild(ele);					
					
				}
				if(c == 5){
					//UNIT
					ele.setAttribute('id', 'noCol4[]');
					ele.setAttribute('class', 'styled3');					
					ele.setAttribute('name', 'noCol4[]');
					ele.setAttribute('maxlength', '10');
					td.appendChild(ele);
				}
				if(c == 6){
					//PRICE
					ele.setAttribute('id', 'noCol5[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol5[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('onblur', 'CalculateRowTotal()');
					td.appendChild(ele);
				}  
				if(c == 7){
					//TOTAL
					ele.setAttribute('id', 'noCol6[]');
					ele.setAttribute('class', 'styled3Total');
					ele.setAttribute('name', 'noCol6[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
				}
				//Discount percent
				if(c == 8){
					//DISCOUNT PERCENT
					ele.setAttribute('id', 'noCol11[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol11[]');
					ele.setAttribute('maxlength', '10');
					ele.setAttribute('onblur', 'CalculateRowTotal()');
					td.appendChild(ele);
				} 
				//Discount amount
				if(c == 9){
					//DISCOUNT AMOUNT
					ele.setAttribute('id', 'noCol12[]');
					ele.setAttribute('class', 'styled3Total');
					ele.setAttribute('name', 'noCol12[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
				}
				//Total after Discount
				if(c == 10){
					//TOTAL AFTER DISCOUNT
					ele.setAttribute('id', 'noCol13[]');
					ele.setAttribute('class', 'styled3Total');
					ele.setAttribute('name', 'noCol13[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
				}
				
				if(c == 11){
					//TAX CODE
					var eleSelect = document.createElement('select');				
					//unique ID for select
					
					if($('#counterValue').length > 0){
						var selectName2 = namingValue + document.getElementById('counterValue').value;
					}else{
						var selectName2 = namingValue;
					}					
					
					selectName = "select|" + selectName2.toString();
					//console.log(selectName);
					eleSelect.setAttribute('name', 'noCol7[]');
					eleSelect.setAttribute('id', selectName);
					eleSelect.setAttribute('onchange', 'GetTaxRate(id)');
					td.appendChild(eleSelect);		
					
					//GetTaxRateList();
					
					//iterating an array of Objects, using jQuery method
					$.each(ajaxResult, function(key, value){
						var taxRate = value.taxRate;
						var taxID = value.id;
						var eleOption = document.createElement('option');
						eleOption.appendChild(document.createTextNode(taxRate));
						eleOption.value = taxID;
						eleSelect.appendChild(eleOption);
					}
					);		
				}
				if(c == 12){
					//TAX RATE
					//unique ID for rate
					
					if($('#counterValue').length > 0){
						var rateName2 = namingValue + document.getElementById('counterValue').value;
					}else{
						var rateName2 = namingValue;
					}	

					
					rateName = "rate|" + rateName2.toString();
					ele.setAttribute('id', rateName);
					ele.setAttribute('class', 'styled3Total');
					ele.setAttribute('name', 'noCol8[]');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
					//default value inside textarea
					var myTab = document.getElementById('empTable');					
					var element2 = myTab.rows.item(rowCnt).cells[12];
					element2.childNodes[0].value = "0.00";				
					namingValue = namingValue + 1;				
				}
				if(c == 13){
					//TAX TOTAL
					ele.setAttribute('id', 'noCol9[]');
					ele.setAttribute('class', 'styled3Total');
					ele.setAttribute('name', 'noCol9[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
					//default value inside textarea
					var myTab = document.getElementById('empTable');					
					var element2 = myTab.rows.item(rowCnt).cells[13];
					element2.childNodes[0].value = "0.00";
					
				}
				if(c == 14){
					//GRAND TOTAL
					ele.setAttribute('id', 'noCol10[]');
					ele.setAttribute('class', 'styled3Total');
					ele.setAttribute('name', 'noCol10[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
					//default value inside textarea
					var myTab = document.getElementById('empTable');					
					var element2 = myTab.rows.item(rowCnt).cells[14];
					element2.childNodes[0].value = "0.00";
				}
				
            }
			rowCounter = rowCounter + 1;
			
		}
    
		//loop through the table to see which rows are selected
		var myTab = document.getElementById('empTable');
        var values = new Array();
		
		// LOOP THROUGH EACH ROW OF THE TABLE.
        for (row = 1; row < myTab.rows.length; row++) {
			 for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'checkbox') {
                    if(element.childNodes[0].checked == true){
						values.push(element.childNodes[0].value);
					}else{
						values.push('0');
					}				
				}
            }
        }		
        
		document.getElementById('invoiceCheckbox').value = values;
		
		//test create table row
		if(rowCnt == 1){createTableTotal()};
		
	}	
	

    // DELETE TABLE ROW.
    function removeRow(oButton) {
		
		var r = confirm("Do you want to Remove this row?");
		if(r==false){
			return false;
		}else{		
		
			var empTab = document.getElementById('empTable');
			empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);       // BUTTON -> TD -> TR.
		
					//loop through the table to see which rows are selected
			var myTab = document.getElementById('empTable');
			var values = new Array();
			
			// LOOP THROUGH EACH ROW OF THE TABLE.
			for (row = 1; row < myTab.rows.length; row++) {
				 for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

					var element = myTab.rows.item(row).cells[c];
					if (element.childNodes[0].getAttribute('type') == 'checkbox') {
						if(element.childNodes[0].checked == true){
							values.push(element.childNodes[0].value);
						}else{
							values.push('0');
						}				
					}
				}
			}		
			//console.log(values);		
			document.getElementById('invoiceCheckbox').value = values;
	
			var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
			if(rowCnt == 1){
				$("#empTableTotal").remove();
			}else{
				CalculateRowTotal();
			}	
	
		}
	}	
	
	//-----------------------------------------------------------
	
	
	var autoExpand = function (field) {

	// Reset field height
	field.style.height = 'inherit';

	// Get the computed styles for the element
	var computed = window.getComputedStyle(field);

	// Calculate the height
	var height = parseInt(computed.getPropertyValue('border-top-width'), 10)
	             + parseInt(computed.getPropertyValue('padding-top'), 10)
	             + field.scrollHeight
	             + parseInt(computed.getPropertyValue('padding-bottom'), 10)
	             + parseInt(computed.getPropertyValue('border-bottom-width'), 10);

	field.style.height = height + 'px';

};

document.addEventListener('input', function (event) {
	if (event.target.tagName.toLowerCase() !== 'textarea') return;
	autoExpand(event.target);
}, false);
    
</script>
</head>

<?php 
	if(mysqli_num_rows($resultInvoiceDetailInfo) == 0){
		echo "<body onload=\"createTable()\">";
	}else{
		echo "<body onload=\"GetTaxRateList()\">";
	}
?>

<center>
<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
<table width="1200px" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>

<main2>
  <nav class="floating-menu">
    <h3></h3>
    <a href="invoiceList.php">Invoice Database</a>
    
  </nav>
</main2>





<p></p>
<form id="invoiceForm" action="editInvoice.php" method="POST" onsubmit="return CheckAndSubmit()">
<table width="1200px" cellpadding="0" border="1" class="mystyle">
<tr><td colspan="5" align="center"><h1>Edit Invoice</h1></td></tr>




<tr><td>To</td><td><input type="text" name="invoiceCustomer" size="45" maxlength="100" value="<?php echo $resultCustomerInfo2[0];?>" readonly></td><td>&nbsp;</td><td>Invoice No</td><td><input type="text" name="invoiceNo" id="invoiceNo" size="12" value="<?php echo $rowInvoiceInfo[0];?>" readonly></td></tr>
<tr><td>Attention</td><td><input type="text" name="invoiceAttention" size="40" maxlength="100" value="<?php echo $rowInvoiceInfo[5];?>"></td><td></td><td>Date</td><td><input id="demo2" type="text" name="invoiceDate" size="10" onchange="CalculateDueDate()" readonly value="<?php echo date("d/m/Y",strtotime($rowInvoiceInfo[1]))?>" readonly >&nbsp;</td></tr>
<tr><td>Address</td><td><?php echo $resultCustomerInfo2[2];?></td><td></td><td>Due Date</td><td>
<input type="text" size="10" name="invoiceDueDate" id="invoiceDueDate" value="<?php echo date("d/m/Y",strtotime($rowInvoiceInfo[20]))?>" readonly>
&nbsp;<input type="text" size="3" name="invoiceNoDay" id="invoiceNoDay" maxlength="3" value="<?php echo $rowInvoiceInfo[21];?>" onblur="CalculateDueDate()">&nbsp;Days
<input type='hidden' name="idQuotation" value="<?php echo $rowInvoiceInfo[16];?>">
</td></tr>
<tr><td>Telephone</td><td><?php echo $resultCustomerInfo2[1]?></td><td></td><td>Quote No</td><td><input type="text" name="quotationNo" size="12" value="<?php echo $rowInvoiceInfo[17];?>" readonly>




</td></tr>
<tr><td>Email</td><td><input type="text" name="invoiceEmail" size="40" maxlength="100" value="<?php echo $rowInvoiceInfo[6];?>"></td><td></td><td>DO No</td><td>
<?php 
	if($rowInvoiceInfo[18] <> 0){
		
		echo $rowInvoiceInfo[19];
	}else{
		if($invoiceStatus == 'a'){
			echo "<input type=\"text\" name=\"deliveryOrderNo\" id=\"deliveryOrderNo\" size=\"12\" maxlength=\"30\" value=\"$strLastDeliveryOrderNo\" onchange=\"CheckDeliveryOrderNo()\" autofocus>";
		}else{
			echo "<input type=\"text\" name=\"deliveryOrderNo\" id=\"deliveryOrderNo\" size=\"12\" maxlength=\"30\" value=\"$strLastDeliveryOrderNo\" onchange=\"CheckDeliveryOrderNo()\" autofocus readonly>";
		}
		echo "<span id=\"infoDO\"><img border=\"0\" src=\"images/Terminate.png\"></span>";
		$dateToday = date('d/m/Y');
		echo "<input id=\"demo4\" type=\"text\" name=\"deliveryOrderDate\" size=\"6\" value=$dateToday readonly>&nbsp;";
			
	}
?>









</td></tr>
<tr><td></td><td></td><td></td><td></td><td>

<?php 
		if($rowInvoiceInfo[18] <> 0){
			//DO no created by convert invoice
		}else{
			echo "<input type=\"submit\" name=\"Submit\" id=\"convertDeliveryOrder\" value=\"Convert Delivery Order\" disabled onclick=\"getButtonID(this.id)\">";
		}
	?>




</td></tr>
<tr><td></td><td></td><td></td><td>From</td><td><input type="text" name="invoiceFrom" size="20" maxlength="50" value="<?php echo $rowInvoiceInfo[3];?>"></td></tr>

<?php 
	if($invoiceStatus == 'a'){
		echo "<tr>";
	}else{
		echo "<tr bgcolor=\"#e3c8cd\">";
	}
?>



<td colspan="5" align="right">
<a href="printInvoice.php?idInvoice=<?php echo $invoiceID;?>&idCustomer=<?php echo $customerID;?>" target="_blank">
<img src="images/printerBlue.png" width="32" height="32"></a>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
	if($invoiceStatus == 'a'){
		echo "<a href='createPayment.php?idCustomer=$customerID'><img src=\"images/moneyblue.png\" width=\"24\" height=\"24\"></a>";
	}else{
		echo "<b>INVOICE VOID!!!</b>";
	}
?>
</td>
</tr>


<tr><td colspan="5" align="left"></td></tr>
<tr><td colspan="5" align="left">&nbsp;<input type="text" name="invoiceTitle" maxlength="200" size="150" value="<?php echo $rowInvoiceInfo[2];?>"></td></tr>
<tr><td colspan="5" align="left"><textarea name="invoiceContent" id="invoiceContent"><?php echo $rowInvoiceInfo[15];?></textarea></td></tr>
</table>
<!--this area we put the invoice details-->

<!--THE CONTAINER WHERE WE'll ADD THE DYNAMIC TABLE-->
<div id="cont">
<?php 
	$strInvoiceCheckbox = ""; //to store which line is bold
	
	if(mysqli_num_rows($resultInvoiceDetailInfo) > 0){
		
		$numOfRows = mysqli_num_rows($resultInvoiceDetailInfo);
		$counter = 0;
		echo "<table width='1200px' cellpadding='0px' border='1px' id='empTable' class='mystyle'>";
		
		echo "<tr><th></th><th>B</th><th>No</th><th>Description</th><th>Qty</th><th>Unit</th><th>Price</th><th>Total</th><th>Disc%</th><th>Disc</th><th>A.Disc</th><th>Code</th><th>Rate</th><th>Tax</th><th>Total</th></tr>";
		
		$intUniqueNameID = 1; //to generate unique ID name for each name column text area
		
		while($rowInvoiceDetailInfo = mysqli_fetch_row($resultInvoiceDetailInfo)){
			
			$counter = $counter + 1;
			echo "<tr>";
			
			echo "<td><input type='button' value='del' onclick='removeRow(this)'></td>";
			echo "<td>";
			if($rowInvoiceDetailInfo[10] == 1){
				echo "<input type='checkbox' name='noCheckbox' value='1' checked onclick='check(this)'>";
				$style3name = "styled3B";
				$style3nameTotal = "styled3BTotal";
				$style2name = "styled2B";
			}else{
				echo "<input type='checkbox' name='noCheckbox' value='1' onclick='check(this)'>";
				$style3name = "styled3";
				$style3nameTotal = "styled3Total";
				$style2name = "styled2";
			}
			echo "</td>";
			echo "<td><textarea class=$style2name id='noCol1[]' name='noCol1[]' maxlength='6'>$rowInvoiceDetailInfo[0]</textarea></td>";
			
			
			//get a unique ID for name column				
			$idNamePHP = "id123456789".$intUniqueNameID;
			
			
			//echo "<td><textarea class='styled' id='$idNamePHP' name='noCol2[]' maxlength='200' ondblclick='popupwindow()'>$rowInvoiceDetailInfo[1]</textarea></td>";
			
			
			if($rowInvoiceDetailInfo[10] == 1){			
				echo "<td><textarea class='styled' style=\"font-weight: bold; width: 480px;\" id='$idNamePHP' name='noCol2[]' maxlength='200' ondblclick='popupwindow()'>$rowInvoiceDetailInfo[1]</textarea></td>";
			}else{
				echo "<td><textarea class='styled' style='width: 480px;' id='$idNamePHP' name='noCol2[]' maxlength='200' ondblclick='popupwindow()'>$rowInvoiceDetailInfo[1]</textarea></td>";
			}
			
			
			
			if($rowInvoiceDetailInfo[2]==0.00){
				echo "<td><textarea class=$style3name id='noCol3[]' name='noCol3[]' maxlength='10' onblur='CalculateRowTotal()'></textarea></td>";
			}else{
				echo "<td><textarea class=$style3name id='noCol3[]' name='noCol3[]' maxlength='10' onblur='CalculateRowTotal()'>$rowInvoiceDetailInfo[2]</textarea></td>";
			}
			
			echo "<td><textarea class=$style3name id='noCol4[]' name='noCol4[]' maxlength='10'>$rowInvoiceDetailInfo[3]</textarea></td>";
			echo "<td><textarea class=$style3name id='noCol5[]' name='noCol5[]' maxlength='15' onblur='CalculateRowTotal()'>$rowInvoiceDetailInfo[4]</textarea></td>";
			echo "<td><textarea class=$style3nameTotal id='noCol6[]' name='noCol6[]' maxlength='15' readonly>$rowInvoiceDetailInfo[5]</textarea></td>";
			//discount amount
			if($rowInvoiceDetailInfo[12]==0.00){
				echo "<td><textarea class=$style3name id='noCol11[]' name='noCol11[]' maxlength='10' onblur='CalculateRowTotal()'></textarea></td>";
			}else{
				echo "<td><textarea class=$style3name id='noCol11[]' name='noCol11[]' maxlength='10' onblur='CalculateRowTotal()'>$rowInvoiceDetailInfo[12]</textarea></td>";
			}
			//discount amount
			echo "<td><textarea class=$style3nameTotal id='noCol12[]' name='noCol12[]' maxlength='15' readonly>$rowInvoiceDetailInfo[13]</textarea></td>";
			//total after discount
			echo "<td><textarea class=$style3nameTotal id='noCol13[]' name='noCol13[]' maxlength='15' readonly>$rowInvoiceDetailInfo[14]</textarea></td>";
			
			echo "<td>";
			$idNameValue = "select|".$counter;
			echo "<select name='noCol7[]' id=$idNameValue onchange=\"GetTaxRate(id)\">";
			//reuse the recordset
			mysqli_data_seek($resultGetTaxRate, 0);
			if(mysqli_num_rows($resultGetTaxRate) > 0){
				$taxRateID = $rowInvoiceDetailInfo[6];
				$arrayTest1 = searchArray(0, $taxRateID, $aTaxRateListDB);
				$taxRateCode = $aTaxRateListDB[$arrayTest1][1];
				echo "<option value=$taxRateID>$taxRateCode</option>";
				while($rowGetTaxRate=mysqli_fetch_array($resultGetTaxRate)){
					echo "<option value=$rowGetTaxRate[0]>$rowGetTaxRate[1]</option>";
				}
				
			}
			echo "</select></td>";
			
			$idNameValue2 = "rate|".$counter;
			
			echo "<td><textarea class=$style3nameTotal id=$idNameValue2 name='noCol8[]' readonly>$rowInvoiceDetailInfo[7]</textarea></td>";
			echo "<td><textarea class=$style3nameTotal id='noCol9[]' name='noCol9[]' maxlength='15' readonly>$rowInvoiceDetailInfo[8]</textarea></td>";
			echo "<td><textarea class=$style3nameTotal id='noCol10[]' name='noCol10[]' maxlength='15' readonly>$rowInvoiceDetailInfo[9]</textarea></td>";

			$strQuotationCheckbox2 = $rowInvoiceDetailInfo[10];			
			if($numOfRows > 1){
				if($counter == 1){
					$strInvoiceCheckbox = $strInvoiceCheckbox.$strQuotationCheckbox2;
				}else{					
					if($counter <= $numOfRows){						
						$strInvoiceCheckbox = $strInvoiceCheckbox.",".$strQuotationCheckbox2;
					}else{
						$strInvoiceCheckbox = $strInvoiceCheckbox.$strQuotationCheckbox2;
					}
				}				
			}else{
				$strInvoiceCheckbox = $strQuotationCheckbox2;
			}			
			
			echo "</tr>";
			$intUniqueNameID = $intUniqueNameID + 1;
		}
		echo "</table>";
	}
	
?>
</div>
<!--THE CONTAINER WHERE WE'll ADD THE DYNAMIC TABLE TOTAL-->
<div id="cont2">
<?php
	if(mysqli_num_rows($resultInvoiceDetailInfo) > 0){
		echo "<table width='1200px' cellpadding='0px' border='1px' class='mystyle' id='empTableTotal'>";
		echo "<tr><td style='width:76%'></td><td style='width:15%'>Subtotal</td><td style='width:9%'><input type='text' id='subTotal' name='subTotal' class='styled4' value='$rowInvoiceInfo[7]' readonly></td><tr>";
		
		echo "<tr><td style='width:76%'></td><td style='width:15%'>Discount Total</td><td style='width:9%'><input type='text' id='discountTotal' name='discountTotal' class='styled4' value='$rowInvoiceInfo[10]' readonly></td><tr>";
		echo "<tr><td style='width:76%'></td><td style='width:15%'>Total After Discount</td><td style='width:9%'><input type='text' id='totalAfterDiscount' name='totalAfterDiscount' class='styled4' value='$rowInvoiceInfo[11]' readonly></td><tr>";
		
		echo "<tr><td style='width:76%'></td><td style='width:15%'>Tax</td><td style='width:9%'><input type='text' id='taxTotal' name='taxTotal' class='styled4' value='$rowInvoiceInfo[8]' readonly></td><tr>";
		echo "<tr><td style='width:76%'></td><td style='width:15%'>Total</td><td style='width:9%'><input type='text' id='grandTotal' name='grandTotal' class='styled4' value='$rowInvoiceInfo[9]' readonly></td><tr>";
		echo "<tr><td style='width:76%'></td><td style='width:15%'>Round</td><td style='width:9%'><input type='text' id='roundAmount' name='roundAmount' class='styled4' value='$rowInvoiceInfo[12]' readonly>";
		
		if($invoiceStatus == 'c'){
			echo "<input type='checkbox' id='roundStatus' name='roundStatus' value='1' disabled>";
		}else{		
			if($rowInvoiceInfo[14] == 1){
				echo "<input type='checkbox' id='roundStatus' name='roundStatus' value='1' checked onclick='CalculateRowTotal()'>";
			}else{
				echo "<input type='checkbox' id='roundStatus' name='roundStatus' value='1' onclick='CalculateRowTotal()'>";
			}
		}
		echo "</td><tr>";
		echo "<tr><td style='width:76%'></td><td style='width:15%'>Rounded Total</td style='width:9%'><td><input type='text' id='groundTotalRound' name='groundTotalRound' class='styled4' value='$rowInvoiceInfo[13]' readonly><input type='hidden' id='counterValue' value='$counter'></td><tr>";
		echo "</table>";
	}
?>
</div>
<p>
<input type="button" id="addRow" value="Add New Row" onClick="addRow2()" <?php if($invoiceStatus == 'c'){echo "disabled";}?>>
</p>
<table width="1200px" cellpadding="0" border="1" class="mystyle">
<tr><td colspan="5" align="left"><textarea name="invoiceTerms" id="invoiceTerms"><?php echo $rowInvoiceInfo[4];?></textarea>
<input type="hidden" name="invoiceID" value="<?php echo $invoiceID?>">
<input type="hidden" name="customerID" value="<?php echo $customerID?>">
<input type="hidden" name="invoiceCheckbox" id="invoiceCheckbox" value="<?php echo $strInvoiceCheckbox?>">
<!--store the button ID that was clicked because onClick button code is processed before FORM submit code-->
<input type='hidden' id='buttonClicked' value=''>

</td></tr>


</table>

<p><input type="submit" id="bt" name="Submit" value="Edit Invoice" onclick="getButtonID(this.id)" <?php if($invoiceStatus == 'c'){echo "disabled";}?>></p>



</form>
</center>
<script src="ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replace('invoiceTerms');
	CKEDITOR.replace('invoiceContent');
</script>
</body>


</html>