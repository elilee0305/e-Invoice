<?php	
	session_start();

	if($_SESSION['userID']==""){
		//not logged in
		ob_start();
		header ("Location: index.php");
		ob_flush();
	}

	include('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");	
	include ('makeSafe.php');
	
	//create payment record
	if(isset($_POST['Submit'])){
		//check again before insert record
		$customerID = $_POST['idCustomer'];
		$customerName = $_POST['customerName'];
		$paymentNo = makeSafe($_POST['paymentNo']);
		$paymentMethod = $_POST['paymentMethod'];
		$paymentChequeInfo = makeSafe($_POST['paymentChequeInfo']);
		$paymentTotalPay = makeSafe($_POST['paymentTotalPay']);
		$paymentRemark = makeSafe($_POST['paymentRemark']);
		$paymentAccount = $_POST['paymentAccount'];
		
		$userID = $_SESSION['userID'];	
		$datePayment = convertMysqlDateFormat($_POST['paymentDate']);	
		
		$sqlCheckExistingPayment = "SELECT payment_id FROM tbpayment WHERE payment_no = '$paymentNo'";
		$resultCheckExistingPayment = mysqli_query($connection, $sqlCheckExistingPayment) or die("error in check existing payment no");
		
		if(mysqli_num_rows($resultCheckExistingPayment)>0){
			//got existing payment no
			header ("Location: createPayment.php?idCustomer='$customerID'");
		}else{
			
			$aInvoiceIDselected = $_POST['invoiceID'];
			if(empty($aInvoiceIDselected)){
				// no invoice selected
			}else{
				$countInvoiceIDselected = count($aInvoiceIDselected);
				
				//Create the payment record 
				$sqlCreatePayment = "INSERT INTO tbpayment(payment_id, payment_no, payment_date, payment_paymentMethodID, payment_chequeInfo, 
				payment_amount, payment_userID, payment_remark, payment_status, payment_customerID) 
				VALUES(NULL, '$paymentNo', '$datePayment', '$paymentMethod', '$paymentChequeInfo', '$paymentTotalPay', '$userID', '$paymentRemark', 
				1, '$customerID')";
				
				mysqli_query($connection, $sqlCreatePayment) or die("error in create payment query");
				$paymentID = mysqli_insert_id($connection);
				
				//create the payment detail records
				for($i=0; $i < $countInvoiceIDselected; $i++){
					$invoiceAmount = 0.00;
					$invoicePaid = 0.00;
					$invoiceStatus = "NE"; //default Neutral, no status, not using this field but direct calculation
					
					$invoiceIDvalue = $aInvoiceIDselected[$i];
					$invoiceActualTotalName = "textAmount".$invoiceIDvalue;
					$invoicePaidName = "invoicePaid".$invoiceIDvalue;
					
					
					
					if(is_numeric($_POST[$invoiceActualTotalName])){$invoiceAmount = $_POST[$invoiceActualTotalName];}
					if(is_numeric($_POST[$invoicePaidName])){$invoicePaid = $_POST[$invoicePaidName];}
					
					//Get the invoice total and paid amount
					//maybe can get this info when we list down all unpaid and pending invoicies
					/* if($invoiceAmount == 0.00){
						$invoiceStatus = "NP"; //NOT PAID
					}else{
						if($invoiceAmount == $invoicePaid){
							$invoiceStatus = "PD"; //PAID
						}elseif($invoicePaid == 0.00){
							$invoiceStatus = "NP"; //NOT PAID
						}else{
							$invoiceStatus = "PP"; //PARTIAL PAID
						}
					} */
					
					
					
					
					
					
					if($invoiceAmount > 0.00){
						$sqlCreatePaymentDetail = "INSERT INTO tbpaymentdetail(paymentDetail_id, paymentDetail_paymentID, paymentDetail_invoiceID, 
						paymentDetail_amount) VALUES(NULL, '$paymentID', '$invoiceIDvalue', '$invoiceAmount')";
						
						mysqli_query($connection, $sqlCreatePaymentDetail) or die("error in create payment detail query");
						
						//Update Invoice Payment Info
						$sqlUpdateInvoice = "UPDATE tbinvoice SET invoice_paid = invoice_paid + '$invoiceAmount' 
						WHERE invoice_id = '$invoiceIDvalue'";
						
						mysqli_query($connection, $sqlUpdateInvoice) or die("error in update invoice query");
					}
				}
				
				//credit accounts receiveable and debit your cash account				
				 $sqlCreateAccountReceiveable = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
				 account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
				 VALUES(NULL, 2, '$datePayment', '$paymentNo', 'PAY', '$paymentID', '$customerName', 0, '$paymentTotalPay')";	
			
				 $sqlCreateCashAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
				 account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
				 VALUES(NULL, '$paymentAccount', '$datePayment', '$paymentNo', 'PAY', '$paymentID', '$customerName', '$paymentTotalPay', 0)";

				//Create the Customer account
				$sqlCreateCustomerAccount = "INSERT INTO tbcustomeraccount(customerAccount_id, customerAccount_customerID, customerAccount_date, 
				customerAccount_reference, customerAccount_documentType, customerAccount_documentTypeID, customerAccount_description, customerAccount_credit) 
				VALUES(NULL, '$customerID', '$datePayment', '$paymentNo', 'PAY', '$paymentID', 'PAYMENT','$paymentTotalPay')";
			
				mysqli_query($connection, $sqlCreateAccountReceiveable) or die("error in create account receiveable query");
				mysqli_query($connection, $sqlCreateCashAccount) or die("error in create cash account query");
				mysqli_query($connection, $sqlCreateCustomerAccount) or die("error in create customer account query");
			}
		}
	}else{
		//get customer details
		if(isset($_GET['idCustomer'])){$customerID = $_GET['idCustomer'];}
	}
	
	//get the MAX id from tbpayment
	$sqlMaxID = "SELECT payment_no FROM tbpayment ORDER BY payment_id DESC LIMIT 0,1";
	$resultMax = mysqli_query($connection, $sqlMaxID) or die("error in max ID query");
	$strLastPaymentNo = "";
	if(mysqli_num_rows($resultMax) > 0){
		$rowLastPaymentNo = mysqli_fetch_row($resultMax);
		$strLastPaymentNo = $rowLastPaymentNo[0];
	}	
	
	//payment method
	$sqlPaymentMode = "SELECT paymentMethod_id, paymentMethod_name FROM tbpaymentmethod ORDER BY paymentMethod_id ASC";
	$resultPaymentMode = mysqli_query($connection, $sqlPaymentMode) or die("error in payment method query");
	
	//get the current asset accounts
	$sqlCurrentAssetCash = "SELECT account3_id, account3_name FROM tbaccount3 WHERE (account3_account2ID = '1' ) 
	AND (account3_group = 'CA') ORDER BY account3_id ASC";
	$resultCurrentAssetCash = mysqli_query($connection, $sqlCurrentAssetCash) or die("error in current asset cash query");	
	
	$sqlCustomerInfo = "SELECT customer_name, customer_address, customer_tel, customer_email, customer_type FROM tbcustomer 
	WHERE customer_id = '$customerID'";
	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer info query");	
	$rowCustomerInfo = mysqli_fetch_row($resultCustomerInfo);		

	//get the list of pucrchase bill which not paid or got balance payment
	$sqlInvoicePaymentList = "SELECT invoice_id, invoice_no, invoice_date, invoice_grandTotalRound, 
	SUM(invoice_grandTotalRound - invoice_creditNote + invoice_debitNote) AS FinalTotal, invoice_paid, invoice_creditNote, invoice_debitNote 
	FROM tbcustomer, tbinvoice WHERE (customer_id = invoice_customerID) AND (invoice_customerID = '$customerID') 
	AND (invoice_status = 'a') AND ((invoice_grandTotalRound - invoice_creditNote + invoice_debitNote) <> invoice_paid) 
	GROUP BY invoice_id, invoice_no, invoice_date, invoice_paid ORDER BY invoice_date ASC ,invoice_id ASC";

	$resultInvoicePaymentList = mysqli_query($connection, $sqlInvoicePaymentList) or die("error in invoice payment list ");
	
?>

<html>
<head>
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	$( function() {		
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
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
	padding: 4px;
	border-width: 1px 1px 0 0
	border-style: solid;
	border-color: #CDD0D1;
}

.notfirst:hover
{
	background-color: #E1ECEE;
}

input:focus
{
	background-color: 92CBDE;
}
textarea:focus
{
	background-color: 92CBDE;
}
select:focus
{
	background-color: 92CBDE;
}

</style>
<script>
	function check(it) {
		tr = it.parentElement.parentElement;
		tr.style.backgroundColor = (it.checked) ? "FFCCCB" : "ffffff";
		//main checkbox unchecked if sub checkbox clicked for ease of use
		document.getElementById('select_master').checked = false;
  
		var checkboxes = document.getElementsByName('invoiceID[]');		
		$rowTotalFinal = 0.00;
		
		for(var i=0,n=checkboxes.length;i<n;i++){
			if(checkboxes[i].checked){
				$invoiceSelectedID =  checkboxes[i].value;
				$selectedOrder = String($invoiceSelectedID);
				$selectedOrder = "textAmount" + $selectedOrder;				
				
				if(isNaN(document.getElementById($selectedOrder).value)){		
					$rowTotal = 0*1;
				}else{
					if(document.getElementById($selectedOrder).value==""){			
						$rowTotal = 0*1;
					}else{			
						numPrice = document.getElementById($selectedOrder).value;			
						$rowTotal = numPrice*1;
					}		
				}	
				
				$rowTotalFinal = $rowTotalFinal + $rowTotal;				
			}			
		}  
		//grand total 	
		document.getElementById("paymentTotalPay").value = ($rowTotalFinal).toFixed(2);
	}

	function check2(it) {  
		var checkboxes = document.getElementsByName('invoiceID[]');		
		$rowTotalFinal = 0.00;
		
		for(var i=0,n=checkboxes.length;i<n;i++){
			if(checkboxes[i].checked){
				$invoiceSelectedID =  checkboxes[i].value;
				$selectedOrder = String($invoiceSelectedID);
				$selectedOrder = "textAmount" + $selectedOrder;				
				
				if(isNaN(document.getElementById($selectedOrder).value)){		
					$rowTotal = 0*1;
				}else{
					if(document.getElementById($selectedOrder).value==""){			
						$rowTotal = 0*1;
					}else{			
						numPrice = document.getElementById($selectedOrder).value;			
						$rowTotal = numPrice*1;
					}		
				}	
				
				$rowTotalFinal = $rowTotalFinal + $rowTotal;				
			}			
		}  
		//grand total 	
		document.getElementById("paymentTotalPay").value = ($rowTotalFinal).toFixed(2);
	}
	
	//==============================================
	function CheckPaymentNo(){		
		var checkEmptyPaymentNo = $("#paymentNo").val();
		if(checkEmptyPaymentNo===""){
			$("#info").html("<img border='0' src='images/Delete.ico'>");
			document.getElementById("Submit").disabled = true;
		}else{	
		
			var data = "paymentNo="+$("#paymentNo").val();		
			
			$.ajax({
				type : 'POST',
				url : 'checkExistingPayment.php',
				data : data,
				dataType : 'json',
				success : function(r)
				{
					if(r=="1"){
						//Exists
						   $("#info").html("<img border='0' src='images/Delete.ico'>");
						   document.getElementById("Submit").disabled = true;
					}else{
						$("#info").html("<img border='0' src='images/Yes.ico'>");
						document.getElementById("Submit").disabled = false;						
					}				
				}
				
				}	
			)	
		}
	}
	
	//=====================================================
	function DisableSubmitButton(){		
		document.getElementById("Submit").disabled = true;		
	}
	
	function CheckAndSubmit(){
		if($('.select:checkbox:checked').length == 0){
			alert("Select a Invoice to Pay!!");
			return false;
		}
		var r = confirm("Do you want to Pay this Payment?");
		if(r==false){
			return false;
		}
	}
	
	function togglecheckboxes(master,cn) {
		var cbarray = document.getElementsByClassName(cn);
		for(var i = 0; i < cbarray.length; i++){
			var cb = document.getElementById(cbarray[i].id);
			cb.checked = master.checked;
			tr = cb.parentElement.parentElement;
			tr.style.backgroundColor = (cb.checked) ? "FFCCCB" : "ffffff";
			
		}
		
		var checkboxes = document.getElementsByName('invoiceID[]');		
		$rowTotalFinal = 0.00;
		
		for(var i=0,n=checkboxes.length;i<n;i++){
			if(checkboxes[i].checked){
				$invoiceSelectedID =  checkboxes[i].value;
				$selectedOrder = String($invoiceSelectedID);
				$selectedOrder = "textAmount" + $selectedOrder;				
				
				if(isNaN(document.getElementById($selectedOrder).value)){		
					$rowTotal = 0*1;
				}else{
					if(document.getElementById($selectedOrder).value==""){			
						$rowTotal = 0*1;
					}else{			
						numPrice = document.getElementById($selectedOrder).value;			
						$rowTotal = numPrice*1;
					}		
				}	
				
				$rowTotalFinal = $rowTotalFinal + $rowTotal;				
			}			
		}  
		//grand total 	
		document.getElementById("paymentTotalPay").value = ($rowTotalFinal).toFixed(2);
		
	}
	

</script>
</head>

	<body onload="DisableSubmitButton()">

	<center>
<div class="navbar">
	<?php include('menuPHPImes.php');?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="20"><td>&nbsp;</td></tr></table>
<br><br>
<div>

</div>

<table width="300" border="0" cellpadding="0">
<tr height="30"><td width="90"></td><td width="210" align="left"></td></tr>
</table>

<form action="createPayment.php" id="createPayment" method="post" onsubmit="return CheckAndSubmit()">
<table border="0" cellpadding="0" width="200">
<tr><td colspan="2"></td></tr>
<tr><td colspan="2">
</td></tr>
</table>

<table width="800" cellpadding="0" border="1" class="mystyle">
<tr><td colspan="2" align="left"><h1>Create Payment</h1></td></tr>

<tr><td>Name</td><td><b>
<?php 
	echo $rowCustomerInfo[0];
	echo "<input type='hidden' name='customerName' id='customerName' value='$rowCustomerInfo[0]'>";
?>
</b></td></tr>
<tr><td>Address</td><td><?php echo $rowCustomerInfo[1];?></td></tr>
<tr><td>Tel</td><td><?php echo $rowCustomerInfo[2];?></td></tr>
<tr><td>Email</td><td><?php echo $rowCustomerInfo[3];?></td></tr>
<tr><td>Type</td><td>
<?php 
	if($rowCustomerInfo[4]=='1'){
		echo "Customer";
	}elseif($rowCustomerInfo[4]=='2'){
		echo "Supplier";
	}else{
		echo "Staff";
	}
?>
</td></tr>

<tr><td>Receipt No</td><td><input type="text" name="paymentNo" id="paymentNo" size="12" maxlength="15" value="<?php echo $strLastPaymentNo;?>" onchange="CheckPaymentNo()"><span id="info"><img border='0' src='images/Terminate.png'></span></td></tr>
<tr><td>Date</td><td><input id="demo2" type="text" name="paymentDate" size="10" value="<?php echo date('d/m/Y');?>" readonly >&nbsp;</td></tr>
<tr height="30"><td>Account</td>
<td bgcolor="eff5b8">
<?php 
	echo "<select name='paymentAccount'>";
	if(mysqli_num_rows($resultCurrentAssetCash) > 0){			
		while($rowCurrentAssetCash=mysqli_fetch_array($resultCurrentAssetCash)){
			echo"<option value=$rowCurrentAssetCash[0]>$rowCurrentAssetCash[1]</option>";
		}
	}
	echo "</select>&nbsp;";
?>
</td></tr>
<tr height="30"><td>Payment Type</td>
<td>
<?php 
	echo "<select name='paymentMethod'>";
	if(mysqli_num_rows($resultPaymentMode) > 0){			
		while($rowPaymentMethod=mysqli_fetch_array($resultPaymentMode)){
			echo"<option value=$rowPaymentMethod[0]>$rowPaymentMethod[1]</option>";
		}
	}
	echo "</select>&nbsp;";
?>
</td></tr>

<tr><td>Cheque Info</td><td><input type="text" name="paymentChequeInfo" id="paymentChequeInfo" size="50" maxlength="100"></td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultInvoicePaymentList) > 0){
		
		echo "<table cellpadding='0' border='1' width='800' class='mystyle'>";
		echo "<tr bgcolor='9cc1c7' height='30'>";
		echo "<td align='center'><b>Pay</b>&nbsp;";
		echo "<input type='checkbox' id='select_master' checked onchange=\"togglecheckboxes(this, 'select')\">";
		echo "</td>";
		echo "<td><b>Date</b></td>";
		echo "<td><b>Invoice No</b></td>";	
		echo "<td><b>Act Total</b></td>";
		echo "<td><b>Cr Note</b></td>";
		echo "<td><b>Dt Note</b></td>";
		echo "<td><b>Total</b></td>";
		echo "<td><b>Paid</b></td>";
		echo "<td><b>Balance</b></td>";	
		echo "<td><b>Amount</b></td>";
		echo "</tr>";
		
		//initialize
			$totalPayment = 0;
			$totalPaymentPaid = 0;
			$totalPaymentBalance = 0;
		//reuse the recordset
		mysqli_data_seek($resultInvoicePaymentList, 0);
		while($rowInvoicePaymentList = mysqli_fetch_row($resultInvoicePaymentList)){
			$invoiceSelectedID = $rowInvoicePaymentList[0]; //order form ID			
			$invoiceSelectID = "invoice|".$invoiceSelectedID; 
			echo "<tr class='notfirst' bgcolor='FFCCCB'>";
			echo "<td align='center'><input type='checkbox' name='invoiceID[]' value=$invoiceSelectedID id='$invoiceSelectID' class='select' checked onclick='check(this)'></td>";			
			echo "<td>".date('d/m/y',strtotime($rowInvoicePaymentList[2]))."</td>";
			$nameOrderFormNo = "textOrderFormNo".$invoiceSelectedID;
			echo "<td><input type='hidden' name='$nameOrderFormNo' id='$nameOrderFormNo' value='$rowInvoicePaymentList[1]'>$rowInvoicePaymentList[1]</td>";
			//actual total
			$nameInvoiceActualTotal = "invoiceActualTotal".$invoiceSelectedID;
			echo "<td><input type='text' name='$nameInvoiceActualTotal' id='$nameInvoiceActualTotal' size='6' value='$rowInvoicePaymentList[3]' readonly></td>";
			
			
			
			
			
			
			//echo "<td>$rowInvoicePaymentList[3]</td>";
			
			
			
			echo "<td>$rowInvoicePaymentList[6]</td>";
			echo "<td>$rowInvoicePaymentList[7]</td>";
			
			//invoice total
			$nameInvoiceTotal = "invoiceTotal".$invoiceSelectedID;
			echo "<td><input type='text' name='$nameInvoiceTotal' id='$nameInvoiceTotal' size='6' value='$rowInvoicePaymentList[4]' readonly></td>";
			//invoice paid
			$nameInvoicePaid = "invoicePaid".$invoiceSelectedID;
			echo "<td><input type='text' name='$nameInvoicePaid' id='$nameInvoicePaid' size='6' value='$rowInvoicePaymentList[5]' readonly></td>";
			
			
			$balancePayment = $rowInvoicePaymentList[4] - $rowInvoicePaymentList[5];
			
			
			
			echo "<td>$balancePayment</td>";
			
			
			$name = "textAmount".$invoiceSelectedID;			
			echo "<td><input type='text' name='$name' id='$name' size='6' value='$balancePayment' onblur='check2(this)'></td>";			
			
			
			
			
			echo "</tr>";
			$totalPayment = $totalPayment + $rowInvoicePaymentList[4];
			$totalPaymentPaid = $totalPaymentPaid + $rowInvoicePaymentList[5];
		}
		$totalPaymentBalance = $totalPayment - $totalPaymentPaid;		
		
		echo "<tr><td colspan='6' align='right'><b>Grand Total</b></td><td>$totalPayment</td><td>$totalPaymentPaid</td><td>$totalPaymentBalance</td>";
		echo "<td><input type='text' name='paymentTotalPay' id='paymentTotalPay' size='6' value='$totalPaymentBalance' readonly></td>";
		echo "</tr>";
		echo "<tr><td colspan='10' align='left'>Remark&nbsp;<input type='text' name='paymentRemark' id='paymentRemark' size='85' maxlength='100'></td></tr>";
		
		echo "<tr><td colspan='10' align='right'>";
		echo "<input type='hidden' name='idCustomer' id='idCustomer' value='$customerID'>";
		echo "<input type='submit' name='Submit' id='Submit' value='Create Payment'>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
		echo "</table>";
	}

?>



</form>

</center>
</body>
</html>