<?php 
	ini_set('display_errors', '1');
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

	/* if(isset($_GET['idInvoiceDelete'])){
		$invoiceID = $_GET['idInvoiceDelete'];
		//delete invoice detail
		$sqlDeleteInvoiceDetail = "DELETE FROM tbinvoicedetail WHERE invoiceDetail_invoiceID = '$invoiceID'";
		$sqlDeleteInvoice = "DELETE FROM tbpaymentvoucher WHERE paymentVoucher_id  = '$invoiceID'";
		
		mysqli_query($connection, $sqlDeleteInvoiceDetail) or die("error in delete invoice detail query");
		mysqli_query($connection, $sqlDeleteInvoice) or die("error in delete invoice query");		
	} */	
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$paymentVoucherDate1Converted = convertMysqlDateFormat($_POST['paymentVoucherDate1']);
		$paymentVoucherDate2Converted = convertMysqlDateFormat($_POST['paymentVoucherDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);
		
		$searchTypeName = $searchType[1];	
		
				
		$sqlPaymentVoucherList3 = "AND (paymentVoucher_date BETWEEN '$paymentVoucherDate1Converted' AND '$paymentVoucherDate2Converted') AND (paymentVoucher_status <> 0) ";		
		
		if($searchType[0] == 1){
			//all
			$sqlPaymentVoucherList2 = "";			
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			$sqlPaymentVoucherList2 = "AND (customer_name LIKE '$searchName') "; 
		}else{
			//invoice no
			$sqlPaymentVoucherList2 = "AND (paymentVoucher_no = '$searchName') ";
			$sqlPaymentVoucherList3 = "";	
		}	
		
		$sqlPaymentVoucherList = "SELECT customer_id, customer_name, paymentVoucher_id , paymentVoucher_no, paymentVoucher_date,  paymentVoucher_grandTotalRound 
		FROM tbcustomer, tbpaymentvoucher WHERE (customer_id = paymentVoucher_customerID) ";
		
		$sqlPaymentVoucherList = $sqlPaymentVoucherList.$sqlPaymentVoucherList2.$sqlPaymentVoucherList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$paymentVoucherDate1Converted = date("Y-m-01", strtotime($dt));
		$paymentVoucherDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlPaymentVoucherList = "SELECT customer_id, customer_name, paymentVoucher_id , paymentVoucher_no, paymentVoucher_date,  paymentVoucher_grandTotalRound 
		FROM tbcustomer, tbpaymentvoucher WHERE (customer_id = paymentVoucher_customerID) ";
		
		$sqlPaymentVoucherList3 = "AND (paymentVoucher_date BETWEEN '$paymentVoucherDate1Converted' AND '$paymentVoucherDate2Converted') AND (paymentVoucher_status <> 0) ";
		
		$sqlPaymentVoucherList = $sqlPaymentVoucherList.$sqlPaymentVoucherList3;
	
	}	
	
	$sqlPaymentVoucherList4 = "ORDER BY paymentVoucher_date ASC, paymentVoucher_id  ASC";
	
	$sqlPaymentVoucherList = $sqlPaymentVoucherList.$sqlPaymentVoucherList4;
	
	//payment voucher list	
	$resultPaymentVoucherList = mysqli_query($connection, $sqlPaymentVoucherList) or die("error in payment voucher list query");
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
	} );
	
	$( function() {
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
</script>


<style type="text/css">
@media print {
	.noPrint{
	display: none;
	}
}
table.mystyle
{
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 12px; /* Added font-size */
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
	background-color: #F4F4F4;
}
</style>

</head>
<body>
<center>

<div class="noPrint">
<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
</div>
<table width="800" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>


<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><b><font size="4" color="#4d4e4f">Payment Voucher Report</font></b></td><td width="350"></td></tr></table>
<table width="700" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="paymentVoucherReport.php" id="paymentVoucherReportForm" method="post">
<table border="0" cellpadding="0" width="800">
<tr height="30">

<td><select name="searchType" id="searchType" size="1">
<?php if(isset($_POST['Submit'])){echo "<option value=".$searchTypeValue.">".$searchTypeName."</option>";}?>
<option value="1|All">All</option>
<option value="2|Customer Name">Customer Name</option>
<option value="3|Payment Voucher No">Payment Voucher No</option>
</select>


</td>
<td><input type="text" name="searchName" size="18" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<input id="demo1" type="text" name="paymentVoucherDate1" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['paymentVoucherDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;TO&nbsp;


</td>
<td>

<input id="demo2" type="text" name="paymentVoucherDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['paymentVoucherDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;


</td>
<td><input type="submit" name="Submit" value="Search Payment Voucher"></td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultPaymentVoucherList) > 0){
		$intCounter = 1;
		$totalPaymentVoucher = 0.00;
		echo "<table width='900' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultPaymentVoucherList)."&nbsp;records</td><td align='right'></td></tr></table>";
		
		echo "<table width='900' cellpadding='0' border='1' class='mystyle'>";		
		echo "<tr><td style='width:30'><b>No</b></td><td style='width:100'><b>PV No</b></td><td style='width:100'><b>Date</b></td><td style='width:570'><b>Customer</b></td><td style='width:100'><b>Total</b></td></tr>";
		while($rowPaymentVoucherList = mysqli_fetch_row($resultPaymentVoucherList)){
			echo "<tr class='notfirst'>";
			echo "<td align='center'>$intCounter</td>";
			echo "<td>$rowPaymentVoucherList[3]</td>";			
			echo "<td>".date("d/m/Y",strtotime($rowPaymentVoucherList[4]))."</td>";
			echo "<td>$rowPaymentVoucherList[1]</td>";	
			
			
			echo "<td align='right'>".number_format($rowPaymentVoucherList[5],2)."</td>";
			
			echo "</tr>";
			$totalPaymentVoucher = $totalPaymentVoucher + $rowPaymentVoucherList[5];
			$intCounter = $intCounter + 1;
		}
		echo "<tr><td colspan='4' align='right'><b>Total</b></td><td align='right'>".number_format($totalPaymentVoucher,2)."</td></tr>";
		echo "</table>";
	}

?>
<br>
<table width="150"><tr><td><input type="button" class="noPrint" onclick="JavaScript:window.print();return false;" value="Print Payment Voucher Report"></td></tr></table>
<br>
</center>
</form>
</body>
</html>
