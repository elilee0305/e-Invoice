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

	if(isset($_GET['idInvoiceDelete'])){
		$invoiceID = $_GET['idInvoiceDelete'];
		//delete invoice detail
		$sqlDeleteInvoiceDetail = "DELETE FROM tbinvoicedetail WHERE invoiceDetail_invoiceID = '$invoiceID'";
		$sqlDeleteInvoice = "DELETE FROM tbinvoice WHERE invoice_id = '$invoiceID'";
		
		mysqli_query($connection, $sqlDeleteInvoiceDetail) or die("error in delete invoice detail query");
		mysqli_query($connection, $sqlDeleteInvoice) or die("error in delete invoice query");		
	}	
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$invoiceDate1Converted = convertMysqlDateFormat($_POST['invoiceDate1']);
		$invoiceDate2Converted = convertMysqlDateFormat($_POST['invoiceDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);
		
		$searchTypeName = $searchType[1];	
		
				
		$sqlInvoiceList3 = "AND (invoice_date BETWEEN '$invoiceDate1Converted' AND '$invoiceDate2Converted') ";		
		
		if($searchType[0] == 1){
			//all
			$sqlInvoiceList2 = "";			
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			$sqlInvoiceList2 = "AND (customer_name LIKE '$searchName') "; 
		}else{
			//invoice no
			$sqlInvoiceList2 = "AND (invoice_no = '$searchName') ";
			$sqlInvoiceList3 = "";	
		}	
		
		$sqlInvoiceList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, invoice_title, invoice_grandTotalRound 
		FROM tbcustomer, tbinvoice WHERE (customer_id = invoice_customerID) ";
		
		$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList2.$sqlInvoiceList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$invoiceDate1Converted = date("Y-m-01", strtotime($dt));
		$invoiceDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlInvoiceList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, invoice_title, invoice_grandTotalRound 
		FROM tbcustomer, tbinvoice WHERE (customer_id = invoice_customerID) ";
		
		$sqlInvoiceList3 = "AND (invoice_date BETWEEN '$invoiceDate1Converted' AND '$invoiceDate2Converted') ";
		
		$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList3;
	
	}	
	
	$sqlInvoiceList4 = "ORDER BY invoice_date ASC, invoice_id ASC";
	
	$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList4;
	
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
	border-width: 1px 1px 0 0;
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


<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><b><font size="4" color="#4d4e4f">Invoice Report</font></b></td><td width="350"></td></tr></table>
<table width="700" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="invoiceReport.php" id="invoiceReportForm" method="post">
<table border="0" cellpadding="0" width="800">
<tr height="30">

<td><select name="searchType" id="searchType" size="1">
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
<td><input type="submit" name="Submit" value="Search Invoice"></td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultInvoiceList) > 0){
		$intCounter = 1;
		$totalInvoice = 0.00;
		echo "<table width='900' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultInvoiceList)."&nbsp;records</td><td align='right'></td></tr></table>";
		
		echo "<table width='900' cellpadding='0' border='1' class='mystyle'>";		
		echo "<tr><td style='width:30'><b>No</b></td><td style='width:100'><b>Invoice No</b></td><td style='width:100'><b>Date</b></td><td style='width:570'><b>Customer</b></td><td style='width:100'><b>Total</b></td></tr>";
		while($rowInvoiceList = mysqli_fetch_row($resultInvoiceList)){
			echo "<tr class='notfirst'>";
			echo "<td align='center'>$intCounter</td>";
			echo "<td>$rowInvoiceList[3]</td>";			
			echo "<td>".date("d/m/Y",strtotime($rowInvoiceList[4]))."</td>";
			echo "<td>$rowInvoiceList[1]</td>";	
			
			
			echo "<td align='right'>".number_format($rowInvoiceList[6],2)."</td>";
			
			echo "</tr>";
			$totalInvoice = $totalInvoice + $rowInvoiceList[6];
			$intCounter = $intCounter + 1;
		}
		echo "<tr><td colspan='4' align='right'><b>Total</b></td><td align='right'>".number_format($totalInvoice,2)."</td></tr>";
		echo "</table>";
	}

?>
<br>
<table width="150"><tr><td><input type="button" class="noPrint" onclick="JavaScript:window.print();return false;" value="Print Invoice Report"></td></tr></table>
<br>
</center>
</form>
</body>
</html>
