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
		
		$sqlInvoiceList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, invoice_title, invoice_grandTotalRound,  
		invoice_quotationID, invoice_quotationNo, invoice_deliveryOrderID, invoice_deliveryOrderNo 
		FROM tbcustomer, tbinvoice WHERE (customer_id = invoice_customerID) ";
		
		$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList2.$sqlInvoiceList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$invoiceDate1Converted = date("Y-m-01", strtotime($dt));
		$invoiceDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlInvoiceList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, invoice_title, invoice_grandTotalRound, 
		invoice_quotationID, invoice_quotationNo, invoice_deliveryOrderID, invoice_deliveryOrderNo 
		FROM tbcustomer, tbinvoice WHERE (customer_id = invoice_customerID) ";
		
		$sqlInvoiceList3 = "AND (invoice_date BETWEEN '$invoiceDate1Converted' AND '$invoiceDate2Converted') ";
		
		$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList3;
	
	}	
	
	$sqlInvoiceList4 = "ORDER BY invoice_date DESC, invoice_id DESC";
	
	$sqlInvoiceList = $sqlInvoiceList.$sqlInvoiceList4;
	
	//invoice list	
	$resultInvoiceList = mysqli_query($connection, $sqlInvoiceList) or die("error in invoice list query");
?>
<html>
<head>
<title>Online Invoice System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>


<style type="text/css">
table.mystyle
{
	overflow: scroll;
	display: block;
	width: 1100px;
	height: 350px;
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
}
.mystyle thead>tr {
  position: absolute;
  display: block;
  padding: 0;
  margin: 0;
  top: 207;
  background-color: transperant;
  width: 1100px;
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
	function CheckAndDelete(){
		var r = confirm("Do you want to DELETE this Invoice?");
		if(r==false){
			return false;
		}	
	}
</script>
</head>
<body>
<center>

<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="80"><td>&nbsp;</td></tr></table>


<table width="1000" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Create Debit Note</h1></td><td width="350"></td></tr></table>
<table width="1000" border="0" cellpadding="0"><tr height="15"><td>&nbsp;</td></tr></table>

<main2>
  <nav class="floating-menu">
    <h3></h3>
    <a href="debitNoteList.php">Debit Note Database</a>
    
  </nav>
</main2>


<form action="invoiceListDebitNote.php" id="invoiceListDebitNote" method="post">
<table border="0" cellpadding="0" width="1000">
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
		
	}?>">&nbsp;
<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo1','ddMMyyyy')" style="cursor:pointer"/>

</td>
<td>

<input id="demo2" type="text" name="invoiceDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['invoiceDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;
<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo2','ddMMyyyy')" style="cursor:pointer"/>

</td>
<td><input type="submit" name="Submit" value="Search Invoice"></td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultInvoiceList) > 0){
		echo "<table width='1000' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultInvoiceList)."&nbsp;records</td><td align='right'></td></tr></table>";
		
		echo "<table width=\"1000\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1000' cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:150'><p style=\"font-size:13px\"><b>Invoice No</b></p></td>";
		echo "<td style='width:150'><p style=\"font-size:13px\"><b>Date</b></p></td>";
		echo "<td style='width:770'><p style=\"font-size:13px\"><b>Customer</b></p></td>";
		echo "<td style='width:70'><p style=\"font-size:13px\"><b>Total</b></p></td>";
		echo "<td style='width:150'><p style=\"font-size:13px\"><b>Debit Note</b></p></td>";
		echo "</tr></thead>";
		
		while($rowInvoiceList = mysqli_fetch_row($resultInvoiceList)){
			//echo "<tr class='notfirst'>";

			if(date('Y-m-d')==$rowInvoiceList[4]){
				echo "<tr bgcolor='e1f7e7' height='30' class='notfirst'>";
			}else{	
				echo "<tr height='30' class='notfirst'>";
			}
			echo "<td style='width:150'><p style=\"font-size:13px\">$rowInvoiceList[3]</p></td>";			
			echo "<td style='width:150'><p style=\"font-size:13px\">".date("d/m/Y",strtotime($rowInvoiceList[4]))."</p></td>";
			echo "<td style='width:770'><p style=\"font-size:13px\">$rowInvoiceList[1]</p></td>";	
			echo "<td style='width:70'><p style=\"font-size:13px\">$rowInvoiceList[6]</p></td>";
			echo "<td style='width:150'><p style=\"font-size:13px\"><a href='createDebitNote.php?idInvoiceDuplicate=$rowInvoiceList[2]&idCustomer=$rowInvoiceList[0]'>debit note</a></p></td>";			
			echo "</tr>";			
		}		
		echo "</table>";
	}

?>
</center>
</form>
</body>
</html>
