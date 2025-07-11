<?php 
	//ini_set('display_errors', '1');
	session_start();
	if($_SESSION['userID']==""){
		//not logged in
		ob_start();
		header ("Location: index.php");
		ob_flush();
	}
	include ('connectionImes.php');
	
	/* set the proper error reporting mode */ 
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //to use for Transaction rollback , catch exception
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");
	include ('makeSafe.php'); 
	
	$invoiceCancel = 0;
	$invoiceStatus = "ALL"; //default`
	
	if(isset($_GET['idInvoiceDelete'])){
		$invoiceID = $_GET['idInvoiceDelete'];
		$customerID = $_GET['idCustomer'];
		$deleteType = $_GET['idDeleteType'];
		//delete invoice detail	
		if($deleteType==1){
			// Delete the invoice details first (invoice details is a child table of invoice)
			$sqlDeleteInvoiceDetail = "DELETE FROM tbinvoicedetail WHERE invoiceDetail_invoiceID = '$invoiceID'";
			mysqli_query($connection, $sqlDeleteInvoiceDetail) or die("error in delete invoice detail query");
	
			// Delete the invoice (parent table)
			$sqlDeleteInvoice = "DELETE FROM tbinvoice WHERE invoice_id = '$invoiceID'";
			mysqli_query($connection, $sqlDeleteInvoice) or die("error in delete invoice query");
			//COMPLETE DELETE INVOICE
			/*
			$sqlDeleteInvoiceVoid = "DELETE invoice, invoiceDetail 
			FROM tbinvoice invoice 
			JOIN tbinvoicedetail invoiceDetail 
			ON invoice.invoice_id = invoiceDetail.invoiceDetail_invoiceID 
			WHERE invoice.invoice_id = '$invoiceID'";
			*/
		}elseif($deleteType==2){
			//VOID THE INVOICE
			$sqlDeleteInvoiceVoid = "UPDATE tbinvoice SET invoice_subTotal = 0.00, invoice_taxTotal = 0.00, invoice_grandTotal = 0.00, 
			invoice_discountTotal = 0.00, invoice_totalAfterDiscount = 0.00, invoice_roundAmount = 0.00, invoice_grandTotalRound = 0.00, 
			invoice_roundStatus = 0, invoice_quotationNo = '', invoice_quotationID = 0, invoice_deliveryOrderNo = '', 
			invoice_deliveryOrderID = 0, invoice_creditNote = 0.00, invoice_debitNote = 0.00, invoice_paid = 0.00, 
			invoice_status = 'c' WHERE invoice_id = '$invoiceID'";
		}
		
		$sqlUpdateQuotation = "UPDATE tbquotation SET quotation_invoiceID = 0, quotation_invoiceNo = '' 
		WHERE quotation_invoiceID = '$invoiceID'";		

		$updateDeliveryOrder = "UPDATE tbdeliveryorder SET deliveryOrder_invoiceID = 0, deliveryOrder_invoiceNo = '' 
		WHERE deliveryOrder_invoiceID = '$invoiceID'";
		
		//delete the customer account 
		$sqlDeleteCustomerAccount = "DELETE FROM tbcustomeraccount WHERE (customerAccount_customerID = '$customerID') AND 
		(customerAccount_documentTypeID = '$invoiceID') AND (customerAccount_documentType = 'INV')";
		
		// delete account receiveable, sales account, tax payable, rounding account together
		$sqlDeleteAccountReceiveableSales = "DELETE FROM tbaccount4 WHERE account4_account3ID IN (2, 4, 10, 11) AND 
		(account4_documentType = 'INV') AND (account4_documentTypeID = '$invoiceID')";

		//Begin transaaction										
		/* disable autocommit */	
		
		mysqli_query($connection, $sqlUpdateQuotation);	
		mysqli_query($connection, $updateDeliveryOrder);		
		if ($deleteType == 2) {
			mysqli_query($connection, $sqlDeleteInvoiceVoid);
		}
		mysqli_query($connection, $sqlDeleteCustomerAccount);
		mysqli_query($connection, $sqlDeleteAccountReceiveableSales);
		
		/* commit update & delete */
		mysqli_commit($connection);
	}	
	
	if(isset($_POST['Submit'])){
		//search by date selected
		$invoicePaymentStatus = $_POST['invoicePaymentStatus'];
		
		switch($invoicePaymentStatus){
			case 1:
				$invoiceStatus = "ALL";
				break;
			case 2:
				$invoiceStatus = "PD";
				break;
			case 3:
				$invoiceStatus = "PP";
				break;
			default:
				$invoiceStatus = "NP";
		}
		
		$invoiceDate1Converted = convertMysqlDateFormat($_POST['invoiceDate1']);
		$invoiceDate2Converted = convertMysqlDateFormat($_POST['invoiceDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);		
		$searchTypeName = $searchType[1];

		if(isset($_POST['chkPaymentCancel'])){
			$invoiceCancel = 1;
		}
				
		$sqlInvoiceList3 = "AND (invoice_date BETWEEN '$invoiceDate1Converted' AND '$invoiceDate2Converted') ";
		
		//Payment status
		if($invoiceStatus == 'ALL'){
			$sqlInvoiceList4 = ""; //no need check payment status
		}elseif($invoiceStatus == 'PD'){
			//PAID
			$sqlInvoiceList4 =  " AND ((invoice_grandTotalRound - invoice_creditNote + invoice_debitNote - invoice_paid) = 0)"; 
			
		}else{	
			if($invoiceStatus == 'NP'){
				//NOT PAID
				$sqlInvoiceList4 =  " AND (invoice_paid = 0)"; 
			}else{
				//PARTIAL PAID
				$sqlInvoiceList4 =  " AND (invoice_grandTotalRound - invoice_creditNote + invoice_debitNote <> invoice_paid) AND (invoice_paid <> 0)"; 
			}
			
		}
		
		
		if($searchType[0] == 1){
			//all
			if($invoiceCancel == 1){
				//CANCEL VOID INVOICES
				$sqlInvoiceList2 = "AND (invoice_status = 'c') ";
			}else{
				$sqlInvoiceList2 = "AND (invoice_status = 'a') ";	
			}
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			if($invoiceCancel == 1){
				$sqlInvoiceList2 = "AND (invoice_status = 'c')  AND (customer_name LIKE '$searchName') ";
			}else{
				$sqlInvoiceList2 = "AND (invoice_status = 'a')  AND (customer_name LIKE '$searchName') ";
			}
				
		}else{
			//invoice no
			if($invoiceCancel == 1){
				$sqlInvoiceList2 = "AND (invoice_status = 'c') AND (invoice_no = '$searchName') ";
			}else{
				$sqlInvoiceList2 = "AND (invoice_status = 'a') AND (invoice_no = '$searchName') ";
			}
			
			$sqlInvoiceList3 = "";
			$sqlInvoiceList4 = ""; //no need check payment status
				
		}	
		
		$sqlInvoiceList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, invoice_title, invoice_grandTotalRound,  
		invoice_quotationID, invoice_quotationNo, invoice_deliveryOrderID, invoice_deliveryOrderNo, SUM(invoice_grandTotalRound - invoice_creditNote + invoice_debitNote) AS FinalInvoice, 
		invoice_paid, SUM(invoice_grandTotalRound - invoice_creditNote + invoice_debitNote - invoice_paid) AS InvoiceBalance FROM tbcustomer, tbinvoice WHERE (customer_id = invoice_customerID) ";
		
		$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList2.$sqlInvoiceList3.$sqlInvoiceList4;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$invoiceDate1Converted = date("Y-m-01", strtotime($dt));
		$invoiceDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlInvoiceList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, invoice_title, invoice_grandTotalRound, 
		invoice_quotationID, invoice_quotationNo, invoice_deliveryOrderID, invoice_deliveryOrderNo, 
		SUM(invoice_grandTotalRound - invoice_creditNote + invoice_debitNote) AS FinalInvoice, invoice_paid, 
		SUM(invoice_grandTotalRound - invoice_creditNote + invoice_debitNote - invoice_paid)
		FROM tbcustomer, tbinvoice WHERE (customer_id = invoice_customerID) ";
		
		$sqlInvoiceList3 = "AND (invoice_status = 'a') AND (invoice_date BETWEEN '$invoiceDate1Converted' AND '$invoiceDate2Converted') ";
		
		$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList3;
	
	}	
	
	
	$sqlInvoiceList5 = "GROUP BY customer_id, customer_name, invoice_id, invoice_no, invoice_date, invoice_title, invoice_grandTotalRound, 
	invoice_quotationID, invoice_quotationNo, invoice_deliveryOrderID, invoice_deliveryOrderNo, invoice_paid
	ORDER BY invoice_date DESC, invoice_id DESC";
	
	$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList5;
	
	//invoice list	
	$resultInvoiceList = mysqli_query($connection, $sqlInvoiceList) or die("error in invoice list query");
?>
<html>
<head>
<title>Online Invoice System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	$( function() {
		$( "#demo1" ).datepicker({ dateFormat: "dd/mm/yy"});
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );	
</script>


<style type="text/css">
table.mystyle
{
	overflow: scroll;
	display: block;
	width: 1200px;
	height: 350px;
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 12px; /* Added font-size */
}
.mystyle thead>tr {
  position: absolute;
  display: block;
  padding: 0;
  margin: 0;
  top: 207;
  background-color: transperant;
  width: 1200px;
  z-index: -1;
}

.mystyle td, mystyle th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0;
	border-style: solid;
	border-color: #CDD0D1;
}
.notfirst:hover
{
	background-color: #E1ECEE;
}

main2 {
    margin-bottom: 100%;
  }

  .floating-menu {
    font-family: sans-serif;
    background: yellowgreen;
    padding: 5px;;
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





</style>
<script>
	function CheckAndDelete(x,t){
		var idInvoiceDeleteValue = x;
		var idCustomerDeleteValue = t;		
		
		var data = "invoiceID="+idInvoiceDeleteValue;
		//console.log(data);
		$.ajax({
			type : 'POST',
			url : 'checkInvoiceCreditNote.php',
			data : data,
			dataType : 'json',
			success : function(r)
			{
								
				ResubmitForm(r, idInvoiceDeleteValue, idCustomerDeleteValue);	
				
			}
		}
		)
		return false;
		
	}
	
	function ResubmitForm(g,y,z){
		if(g==0){					
			
			var t = confirm("Do you want to DELETE this Invoice?");
			if(t==true){
				var idLink = y;
				var idLink2 = z;
				//COMPLETE DELETE
				window.location = "invoiceList.php?idInvoiceDelete=" + idLink + "&idCustomer=" + idLink2 + "&idDeleteType=1";
			}	
		
		}else if(g==1){
			alert("This Invoice No has Credit Note attached!");
			return false;
		}else if(g==4){
			alert("This Invoice No has Debit Note attached!");
			return false;
		}else if(g==2){
			alert("This Invoice No has Active Payment! Cancel Payment first");
			return false;
		
		}else if(g==3){
			//cancel payment availabe, so VOID the invoice
			var f = confirm("Do you want to VOID this Invoice?");
			if(f==true){
				var idLink = y;
				var idLink2 = z;
				//VOID delete
				window.location = "invoiceList.php?idInvoiceDelete=" + idLink + "&idCustomer=" + idLink2 + "&idDeleteType=2";
			}
		}			
	}
	
	
	function CaptureSearchID(x){
		var idName = document.getElementById(x).value;
		document.getElementById("searchID").value = idName;		
	}

	function cancelLHDN(invoiceID) {
		var confirmation = confirm("Are you sure you want to cancel this invoice?");
		if (confirmation) {
			// Simulate successful cancellation
			alert("The cancellation for Invoice ID " + invoiceID + " has been made to the LHDN cloud.");
			
			// Update the status to "Cancelled"
			var statusCell = document.getElementById("status-" + invoiceID);
			if (statusCell) {
				statusCell.innerHTML = "Cancelled";
				statusCell.style.color = "red"; // Optional: Make the status visually distinct
			}
		}
		return false; // Prevent default link behavior
	}
	
</script>
</head>
<body>
<center>

<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="80"><td>&nbsp;</td></tr></table>



<main2>
  <nav class="floating-menu">
    <h3></h3>
    <a href="createInvoice.php">Create Invoice</a>
    
  </nav>
</main2>


<table width="1000" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Invoice List</h1></td><td width="350"></td></tr></table>
<table width="1000" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="invoiceList.php" id="invoiceListForm" method="post">
<table border="0" cellpadding="0" width="1000">
<tr height="15">
<?php 
	if(isset($_POST['Submit'])){
		if($_POST['searchID']==1){echo "<td bgcolor='#ADFF2F'>";}else{echo "<td>";}
	}else{
		echo "<td bgcolor='#ADFF2F'>";
	}
?>
	<input type="radio" name="invoicePaymentStatus" id="1" value="1" <?php if($invoiceStatus=='ALL'){echo "checked";}?> onClick="CaptureSearchID(this.id)">All
</td>
<?php 
	if(isset($_POST['Submit'])){
		if($_POST['searchID']==2){echo "<td bgcolor='#ADFF2F'>";}else{echo "<td>";}
	}else{
		echo "<td>";
	}
?>




	
	<input type="radio" name="invoicePaymentStatus" id="2" value="2" <?php if($invoiceStatus=='PD'){echo "checked";}?> onClick="CaptureSearchID(this.id)">Paid
</td>
<?php 
	if(isset($_POST['Submit'])){
		if($_POST['searchID']==3){echo "<td bgcolor='#ADFF2F'>";}else{echo "<td>";}
	}else{
		echo "<td>";
	}
?>	
	<input type="radio" name="invoicePaymentStatus" id="3" value="3" <?php if($invoiceStatus=='PP'){echo "checked";}?> onClick="CaptureSearchID(this.id)">Partial Paid
</td>
<?php 
	if(isset($_POST['Submit'])){
		if($_POST['searchID']==4){echo "<td bgcolor='#ADFF2F'>";}else{echo "<td>";}
	}else{
		echo "<td>";
	}
?>
	<input type="radio" name="invoicePaymentStatus" id="4" value="4" <?php if($invoiceStatus=='NP'){echo "checked";}?> onClick="CaptureSearchID(this.id)">Not Paid
</td>
<td>
	<select name="searchType" id="searchType" size="1">
	<?php if(isset($_POST['Submit'])){echo "<option value=".$searchTypeValue.">".$searchTypeName."</option>";}?>
	<option value="1|All">All</option>
	<option value="2|Customer Name">Customer Name</option>
	<option value="3|Invoice No">Invoice No</option>
	</select>
</td>
<td><input type="text" name="searchName" size="18" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<input id="demo1" type="text" name="invoiceDate1" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['invoiceDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;TO&nbsp;


</td>
<td>

<input id="demo2" type="text" name="invoiceDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['invoiceDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;


</td>
<td><input type="submit" name="Submit" value="Search Invoice">&nbsp;&nbsp;
<input type="checkbox" name="chkPaymentCancel" value="1" <?php if($invoiceCancel == 1){echo "checked";}?>><img src="images/deletemark.jpg" width="16"" height="16"> 
<input type='hidden' id='searchID' name="searchID" value="<?php if(isset($_POST['Submit'])){echo $_POST['searchID'];}else{echo "1";}?>">



</td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultInvoiceList) > 0){
		echo "<table width='1200px' height='25' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultInvoiceList)."&nbsp;records</td><td align='right'></td></tr></table>";
		echo "<table width=\"1200px\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1200px' cellpadding='0' border='1' class='mystyle'>";		
		
		
		echo "<thead><tr>";
		echo "<td style='width:125px'><p style=\"font-size:12px\"><b>Invoice No</b></p></td>";
		echo "<td style='width:85px'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:470px'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:110px'><p style=\"font-size:12px\"><b>Quote</b></p></td>";
		echo "<td style='width:110px'><p style=\"font-size:12px\"><b>DO</b></p></td>";
		
		echo "<td style='width:70px'><p style=\"font-size:12px\"><b>Total</b></p></td>";			
		echo "<td style='width:50px'><p style=\"font-size:12px\"><b>Paid</b></p></td>";			
		echo "<td style='width:50px'><p style=\"font-size:12px\"><b>Bal</b></p></td>";			
		echo "<td style='width:20px'><p style=\"font-size:12px\"><b>Pay</b></p></td>";			
		echo "<td style='width:25px'><p style=\"font-size:12px\"><b>Ed</b></p></td>";			
		echo "<td style='width:30px'><p style=\"font-size:12px\"><b>Prt</b></p></td>";			
		echo "<td style='width:45px'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "<td style='width:30px'><p style=\"font-size:12px\"><b>Exc</b></p></td>";			
		echo "<td style='width:50px; text-align:center;'><p style=\"font-size:12px\"><b>Cancel Invoice</b></p></td>";			
		echo "</tr></thead>";
		
		
		
		
		
		
		while($rowInvoiceList = mysqli_fetch_row($resultInvoiceList)){
			//echo "<tr class='notfirst'>";

			if(date('Y-m-d')==$rowInvoiceList[4]){
				echo "<tr bgcolor='e1f7e7' height='30' class='notfirst'>";
			}else{	
				echo "<tr height='30' class='notfirst'>";
			}


			
			echo "<td style='width:125px'><p style=\"font-size:12px\">$rowInvoiceList[3]</p></td>";			
			echo "<td style='width:85'><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowInvoiceList[4]))."</p></td>";
			
			echo "<td style='width:500'><p style=\"font-size:12px\">$rowInvoiceList[1]</p></td>";	
			
			if($rowInvoiceList[7]==0){
				echo "<td style='width:110' align='center'>&nbsp;</td>";
			}else{
				echo "<td style='width:110' align='left'><p style=\"font-size:12px\">".$rowInvoiceList[8]."</p></td>";
			}
			
			if($rowInvoiceList[9]==0){
				echo "<td style='width:110' align='center'>&nbsp;</td>";
			}else{
				echo "<td style='width:110' align='left'><p style=\"font-size:12px\">".$rowInvoiceList[10]."</p></td>";
			}
			
			
			
			
			
			/* $strPositionText = $rowInvoiceList[5];
			if(strlen($strPositionText) > 30){
			$strPositionText = substr($strPositionText, 0, 30).'...';
				echo "<td>$strPositionText</td>";
			}else{
				echo "<td>$strPositionText</td>";
			} */
			echo "<td align='right'><p style=\"font-size:12px\">$rowInvoiceList[11]</p></td>";
			echo "<td align='right'><p style=\"font-size:12px\">$rowInvoiceList[12]</p></td>";
			echo "<td align='right'><p style=\"font-size:12px\">$rowInvoiceList[13]</p></td>";
			//No balance only show payment image
			if($rowInvoiceList[13] == 0.00){
				echo "<td align='right'><p style=\"font-size:12px\"></p></td>";
			}else{
				echo "<td align='right'><p style=\"font-size:12px\"><a href='createPayment.php?idCustomer=$rowInvoiceList[0]'>Pay</a></p></td>";
			}
			
			
			
			
			
			echo "<td><p style=\"font-size:12px\"><a href='editInvoice.php?idInvoice=$rowInvoiceList[2]&idCustomer=$rowInvoiceList[0]'>ed</a></p></td>";			
			echo "<td align='center'><p style=\"font-size:12px\"><a href='printInvoice.php?idInvoice=$rowInvoiceList[2]&idCustomer=$rowInvoiceList[0]' target='_blank'>prt</a></p></td>";
			
			if($invoiceCancel == 1){
				echo "<td></td>";
			}else{
				$idInvoiceDeleteValue = $rowInvoiceList[2];
				$idCustomerDeleteValue = $rowInvoiceList[0];			
				$idName = "delete".$idInvoiceDeleteValue;
				echo "<td><p style=\"font-size:12px\"><a href='' id=$idName onclick=\"return CheckAndDelete($idInvoiceDeleteValue, $idCustomerDeleteValue)\">del</a></p></td>";
			}
			
			echo "<td><a href='createEinvoiceExcelFile.php?idInvoice=$rowInvoiceList[2]&idCustomer=$rowInvoiceList[0]'><img src=\"images/excel.png\" width=\"17\" height=\"20\"></a></td>";

			// Add X mark for LHDN cancellation
			$invoiceDate = strtotime($rowInvoiceList[4]);
			$currentDate = time();
			$hoursDifference = ($currentDate - $invoiceDate) / 3600;

			// Temporarily remove the condition for testing
			echo "<td style='width:50px; text-align:center; background-color:#f8d7da;'><p style=\"font-size:12px; margin:0;\"><a href='#' style='color:red; font-weight:bold; text-decoration:none;' onclick=\"return cancelLHDN($rowInvoiceList[2])\">X</a></p></td>";
			echo "</tr>";
		}		
		echo "</table>";
	}else{
		echo "<table width=\"1200px\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1200px' cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:125'><p style=\"font-size:12px\"><b>Invoice No</b></p></td>";
		echo "<td style='width:85'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:470'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:110'><p style=\"font-size:12px\"><b>Quote</b></p></td>";
		echo "<td style='width:110'><p style=\"font-size:12px\"><b>DO</b></p></td>";
		
		echo "<td style='width:70'><p style=\"font-size:12px\"><b>Total</b></p></td>";			
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Paid</b></p></td>";			
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Bal</b></p></td>";			
		echo "<td style='width:20'><p style=\"font-size:12px\"><b>Pay</b></p></td>";			
		echo "<td style='width:25'><p style=\"font-size:12px\"><b>Ed</b></p></td>";			
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Prt</b></p></td>";			
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Exc</b></p></td>";			
		echo "<td style='width:50px; text-align:center;'><p style=\"font-size:12px\"><b>Cancel Invoice</b></p></td>";			
		echo "</tr></thead>";
		echo "</table>";
		
	}

?>
</center>
</form>
</body>
</html>
