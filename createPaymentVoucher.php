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
		$paymentVoucherNo = makeSafe($_POST['paymentVoucherNo']);
		$paymentVoucherMethod = $_POST['paymentVoucherMethod'];
		$paymentVoucherChequeInfo = makeSafe($_POST['paymentVoucherChequeInfo']);
		$paymentVoucherTotalPay = makeSafe($_POST['paymentVoucherTotalPay']);
		$paymentVoucherRemark = makeSafe($_POST['paymentVoucherRemark']);
		$paymentVoucherAccount = $_POST['paymentVoucherAccount'];
		
		$userID = $_SESSION['userID'];	
		$datePayment = convertMysqlDateFormat($_POST['paymentVoucherDate']);	
		
		$sqlCheckExistingPaymentVoucher = "SELECT paymentVoucher_id FROM tbpaymentvoucher WHERE paymentVoucher_no = '$paymentVoucherNo'";
		$resultCheckExistingPaymentVoucher = mysqli_query($connection, $sqlCheckExistingPaymentVoucher) or die("error in check existing payment voucher no");
		
		if(mysqli_num_rows($resultCheckExistingPaymentVoucher)>0){
			//got existing payment no
			header ("Location: createPaymentVoucher.php?idCustomer='$customerID'");
		}else{
			$aPurchaseBillIDselected = $_POST['invoiceID'];
			if(empty($aPurchaseBillIDselected)){
				// no purchase bill selected
			}else{
				$countPurchaseBillIDselected = count($aPurchaseBillIDselected);
				
				//Create the payment voucher record 
				$sqlCreatePaymentVoucher = "INSERT INTO tbpaymentvoucher(paymentVoucher_id, paymentVoucher_no, paymentVoucher_date, paymentVoucher_paymentMethodID, paymentVoucher_chequeInfo, 
				paymentVoucher_grandTotalRound, paymentVoucher_userID, paymentVoucher_remark, paymentVoucher_status, paymentVoucher_customerID, paymentVoucher_type) 
				VALUES(NULL, '$paymentVoucherNo', '$datePayment', '$paymentVoucherMethod', '$paymentVoucherChequeInfo', '$paymentVoucherTotalPay', '$userID', '$paymentVoucherRemark', 
				1, '$customerID', 'p')";
				
				mysqli_query($connection, $sqlCreatePaymentVoucher) or die("error in create payment voucher query");
				$paymentVoucherID = mysqli_insert_id($connection);
				
				//create the payment voucher detail records
				for($i=0; $i < $countPurchaseBillIDselected; $i++){
					$purchaseBillAmount = 0.00; 
					$purchaseBillIDvalue = $aPurchaseBillIDselected[$i];
					
					$purchaseBillAmountName = "textAmount".$purchaseBillIDvalue;
					if(is_numeric($_POST[$purchaseBillAmountName])){$purchaseBillAmount = $_POST[$purchaseBillAmountName];}
					if($purchaseBillAmount > 0.00){
						$sqlCreatePaymentVoucherDetail = "INSERT INTO tbpaymentvoucherdetail(paymentVoucherDetail_id, paymentVoucherDetail_paymentVoucherID, paymentVoucherDetail_purchaseBillID, 
						paymentVoucherDetail_rowTotalAfterDiscount) VALUES(NULL, '$paymentVoucherID', '$purchaseBillIDvalue', '$purchaseBillAmount')";
						
						mysqli_query($connection, $sqlCreatePaymentVoucherDetail) or die("error in create payment voucher detail query");
						
						//Update Purchase Bill Payment Info
						$sqlUpdatePurchaseBill = "UPDATE tbpurchasebill SET purchaseBill_paid = purchaseBill_paid + '$purchaseBillAmount' 
						WHERE purchaseBill_id = '$purchaseBillIDvalue'";
						
						mysqli_query($connection, $sqlUpdatePurchaseBill) or die("error in update purchase bill query");
					}
				}
				
				//debit accounts payable and credit your cash account				
				 $sqlCreateAccountPayable = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
				 account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
				 VALUES(NULL, 6, '$datePayment', '$paymentVoucherNo', 'PAYV', '$paymentVoucherID', '$customerName', '$paymentVoucherTotalPay', 0)";	
			
				 $sqlCreateCashAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
				 account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
				 VALUES(NULL, '$paymentVoucherAccount', '$datePayment', '$paymentVoucherNo', 'PAYV', '$paymentVoucherID', '$customerName', 0,'$paymentVoucherTotalPay')";

				//Create the Supplier account
				$sqlCreateSupplierAccount = "INSERT INTO tbcustomeraccount(customerAccount_id, customerAccount_customerID, customerAccount_date, 
				customerAccount_reference, customerAccount_documentType, customerAccount_documentTypeID, customerAccount_description, customerAccount_debit) 
				VALUES(NULL, '$customerID', '$datePayment', '$paymentVoucherNo', 'PAYV', '$paymentVoucherID', 'PAYMENT VOUCHER','$paymentVoucherTotalPay')";
			
				mysqli_query($connection, $sqlCreateAccountPayable) or die("error in create account receiveable query");
				mysqli_query($connection, $sqlCreateCashAccount) or die("error in create cash account query");
				mysqli_query($connection, $sqlCreateSupplierAccount) or die("error in create supplier account query");
			
			}
		}
	}else{
		//get customer details
		if(isset($_GET['idCustomer'])){$customerID = $_GET['idCustomer'];}
	}
	
	
	//get the MAX id from tbpaymentvoucher
	$sqlMaxID = "SELECT paymentVoucher_no FROM tbpaymentvoucher ORDER BY paymentVoucher_id DESC LIMIT 0,1";
	$resultMax = mysqli_query($connection, $sqlMaxID) or die("error in max ID query");
	$strLastPaymentVoucherNo = "";
	if(mysqli_num_rows($resultMax) > 0){
		$rowLastPaymentVoucherNo = mysqli_fetch_row($resultMax);
		$strLastPaymentVoucherNo = $rowLastPaymentVoucherNo[0];
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

	//get the list of purchase bills which not paid or got balance payment
	$sqlPurchaseBillPaymentList = "SELECT purchaseBill_id, purchaseBill_no, purchaseBill_date, 
	purchaseBill_grandTotalRound, purchaseBill_paid 
	FROM tbcustomer, tbpurchasebill WHERE (customer_id = purchaseBill_customerID) AND (purchaseBill_customerID = '$customerID') 
	AND (purchaseBill_grandTotalRound <> purchaseBill_paid) 
	GROUP BY purchaseBill_id, purchaseBill_no, purchaseBill_date, purchaseBill_paid ORDER BY purchaseBill_date ASC ,purchaseBill_id ASC";

	$resultPurchaseBillPaymentList = mysqli_query($connection, $sqlPurchaseBillPaymentList) or die("error in purchase bill payment list ");
	
	
	
	
	
	
	
	
	
	
	
	
	

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
}
.mystyle td, mystyle th
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
		document.getElementById("paymentVoucherTotalPay").value = ($rowTotalFinal).toFixed(2);
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
		document.getElementById("paymentVoucherTotalPay").value = ($rowTotalFinal).toFixed(2);
	}
	
	//==============================================
	function CheckPaymentVoucherNo(){		
		var checkEmptyPaymentVoucherNo = $("#paymentVoucherNo").val();
		if(checkEmptyPaymentVoucherNo===""){
			$("#info").html("<img border='0' src='images/Delete.ico'>");
			document.getElementById("Submit").disabled = true;
		}else{	
		
			var data = "paymentVoucherNo="+$("#paymentVoucherNo").val();		
			
			$.ajax({
				type : 'POST',
				url : 'checkExistingPaymentVoucher.php',
				data : data,
				dataType : 'json',
				success : function(r)
				{
					if(r=="0"){
						$("#info").html("<img border='0' src='images/Yes.ico'>");
						document.getElementById("Submit").disabled = false;	
					}else{
						//Exists
						$("#info").html("<img border='0' src='images/Delete.ico'>");
						document.getElementById("Submit").disabled = true;
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
			alert("Select a Purchase Bill to Pay!!");
			return false;
		}
		var r = confirm("Do you want to Pay this Payment Voucher?");
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
		document.getElementById("paymentVoucherTotalPay").value = ($rowTotalFinal).toFixed(2);
		
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


<form action="createPaymentVoucher.php" id="createPaymentVoucher" method="post" onsubmit="return CheckAndSubmit()">
<table border="0" cellpadding="0" width="200">
<tr><td colspan="2"></td></tr>
<tr><td colspan="2">
</td></tr>
</table>


<table width="700" cellpadding="0" border="1" class="mystyle">
<tr><td colspan="2" align="left"><h1>Create Payment Voucher</h1></td></tr>

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

<tr><td>Voucher No</td><td><input type="text" name="paymentVoucherNo" id="paymentVoucherNo" size="12" maxlength="15" value="<?php echo $strLastPaymentVoucherNo;?>" onchange="CheckPaymentVoucherNo()"><span id="info"><img border='0' src='images/Terminate.png'></span></td></tr>
<tr><td>Date</td><td><input id="demo2" type="text" name="paymentVoucherDate" size="10" value="<?php echo date('d/m/Y');?>" readonly >&nbsp;</td></tr>
<tr height="30"><td>Account</td>
<td bgcolor="eff5b8">
<?php 
	echo "<select name='paymentVoucherAccount'>";
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
	echo "<select name='paymentVoucherMethod'>";
	if(mysqli_num_rows($resultPaymentMode) > 0){			
		while($rowPaymentMethod=mysqli_fetch_array($resultPaymentMode)){
			echo"<option value=$rowPaymentMethod[0]>$rowPaymentMethod[1]</option>";
		}
	}
	echo "</select>&nbsp;";
?>
</td></tr>

<tr><td>Cheque Info</td><td><input type="text" name="paymentVoucherChequeInfo" id="paymentVoucherChequeInfo" size="50" maxlength="100"></td></tr>
</table>





<?php 
	if(mysqli_num_rows($resultPurchaseBillPaymentList) > 0){
		
		echo "<table cellpadding='0' border='1' width='700' class='mystyle'>";
		echo "<tr bgcolor='9cc1c7' height='30'>";
		echo "<td align='center'><b>Pay</b>&nbsp;";
		echo "<input type='checkbox' id='select_master' checked onchange=\"togglecheckboxes(this, 'select')\">";
		echo "</td>";
		echo "<td><b>Date</b></td>";
		echo "<td><b>Bill No</b></td>";				
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
		mysqli_data_seek($resultPurchaseBillPaymentList, 0);
		while($rowInvoicePaymentList = mysqli_fetch_row($resultPurchaseBillPaymentList)){
			$invoiceSelectedID = $rowInvoicePaymentList[0]; //order form ID			
			$invoiceSelectID = "purchase bill|".$invoiceSelectedID; 
			echo "<tr class='notfirst' bgcolor='FFCCCB'>";
			
			
			
			echo "<td align='center'><input type='checkbox' name='invoiceID[]' value=$invoiceSelectedID id='$invoiceSelectID' class='select' checked onclick='check(this)'></td>";			
			
			
			
			echo "<td>".date('d/m/y',strtotime($rowInvoicePaymentList[2]))."</td>";
			$nameOrderFormNo = "textOrderFormNo".$invoiceSelectedID;
			echo "<td><input type='hidden' name='$nameOrderFormNo' id='$nameOrderFormNo' value='$rowInvoicePaymentList[1]'>$rowInvoicePaymentList[1]</td>";
			echo "<td>$rowInvoicePaymentList[3]</td>";
			echo "<td>$rowInvoicePaymentList[4]</td>";
			$balancePayment = $rowInvoicePaymentList[3] - $rowInvoicePaymentList[4];
			echo "<td>$balancePayment</td>";
			$name = "textAmount".$invoiceSelectedID;			
			echo "<td><input type='text' name='$name' id='$name' size='6' value='$balancePayment' onblur='check2(this)'></td>";			
			echo "</tr>";
			$totalPayment = $totalPayment + $rowInvoicePaymentList[3];
			$totalPaymentPaid = $totalPaymentPaid + $rowInvoicePaymentList[4];
			
		}
		$totalPaymentBalance = $totalPayment - $totalPaymentPaid;		
		
		echo "<tr><td colspan='3' align='right'><b>Grand Total</b></td><td>$totalPayment</td><td>$totalPaymentPaid</td><td>$totalPaymentBalance</td>";
		echo "<td><input type='text' name='paymentVoucherTotalPay' id='paymentVoucherTotalPay' size='6' value='$totalPaymentBalance' readonly></td>";
		echo "</tr>";
		echo "<tr><td colspan='7' align='left'>Remark&nbsp;<input type='text' name='paymentVoucherRemark' id='paymentVoucherRemark' size='85' maxlength='100'></td></tr>";
		
		echo "<tr><td colspan='7' align='right'>";
		echo "<input type='hidden' name='idCustomer' id='idCustomer' value='$customerID'>";
		echo "<input type='submit' name='Submit' id='Submit' value='Create Payment Voucher'>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
		echo "</table>";
	}

?>







































</form>

</center>
</body>
</html>