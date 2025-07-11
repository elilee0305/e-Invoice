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

	if(isset($_GET['idQuotationDelete'])){
		$quotationID = $_GET['idQuotationDelete'];	

		$sqlDeleteQuotation = "DELETE quotation, quotationDetail 
		FROM tbquotation quotation 
		JOIN tbquotationdetail quotationDetail ON quotation.quotation_id = quotationDetail.quotationDetail_quotationID 
		WHERE quotation.quotation_id = '$quotationID'";	
		
		
		//update delivery order
		$updateDeliveryOrder = "UPDATE tbdeliveryorder SET deliveryOrder_quotationID = 0, deliveryOrder_quotationNo = '' 
		WHERE deliveryOrder_quotationID = '$quotationID'";
		
		//update invoice
		$sqlUpdateInvoice = "UPDATE tbinvoice SET invoice_quotationID = 0, invoice_quotationNo = '' 
		WHERE invoice_quotationID = '$quotationID'";
		
		//Begin transaaction										
		/* disable autocommit */
		mysqli_autocommit($connection, FALSE);	
			
		mysqli_query($connection, $updateDeliveryOrder);
		mysqli_query($connection, $sqlUpdateInvoice);
		mysqli_query($connection, $sqlDeleteQuotation);
		/* commit update & delete */
		mysqli_commit($connection);
		
			
	}	
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$quotationDate1Converted = convertMysqlDateFormat($_POST['quotationDate1']);
		$quotationDate2Converted = convertMysqlDateFormat($_POST['quotationDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);
		
		$searchTypeName = $searchType[1];	
		
				
		$sqlQuotationList3 = "AND (quotation_date BETWEEN '$quotationDate1Converted' AND '$quotationDate2Converted') ";		
		
		if($searchType[0] == 1){
			//all
			$sqlQuotationList2 = "";			
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			$sqlQuotationList2 = "AND (customer_name LIKE '$searchName') "; 
		}else{
			//quotation no
			$sqlQuotationList2 = "AND (quotation_no = '$searchName') ";
			$sqlQuotationList3 = "";	
		}	
		
		$sqlQuotationList = "SELECT customer_id, customer_name, quotation_id, quotation_no, quotation_date, quotation_title, quotation_grandTotalRound,  
		quotation_invoiceID, quotation_invoiceNo, quotation_deliveryOrderID, quotation_deliveryOrderNo FROM tbcustomer, tbquotation WHERE (customer_id = quotation_customerID) ";
		
		$sqlQuotationList = $sqlQuotationList.$sqlQuotationList2.$sqlQuotationList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$quotationDate1Converted = date("Y-m-01", strtotime($dt));
		$quotationDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlQuotationList = "SELECT customer_id, customer_name, quotation_id, quotation_no, quotation_date, quotation_title, quotation_grandTotalRound, 
		quotation_invoiceID, quotation_invoiceNo, quotation_deliveryOrderID, quotation_deliveryOrderNo FROM tbcustomer, tbquotation WHERE (customer_id = quotation_customerID) ";
		
		$sqlQuotationList3 = "AND (quotation_date BETWEEN '$quotationDate1Converted' AND '$quotationDate2Converted') ";
		
		$sqlQuotationList = $sqlQuotationList.$sqlQuotationList3;
	
	}	
	
	$sqlQuotationList4 = "ORDER BY quotation_date DESC, quotation_id DESC";
	
	$sqlQuotationList = $sqlQuotationList.$sqlQuotationList4;
	
	//quotation list	
	$resultQuotationList = mysqli_query($connection, $sqlQuotationList) or die("error in quotation list query");
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
	border-width: 1px 1px 0 0
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
		var r = confirm("Do you want to DELETE this Quotation?");
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


<main2>
  <nav class="floating-menu">
    <h3></h3>
    <a href="createQuotation.php">Create Quotation</a>
    
  </nav>
</main2>


<table width="1000" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><H1>Quotation List</H1></td><td width="350"></td></tr></table>
<table width="700" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="quotationList.php" id="quotationListForm" method="post">
<table border="0" cellpadding="0" width="1000">
<tr height="15">

<td><select name="searchType" id="searchType" size="1">
<?php if(isset($_POST['Submit'])){echo "<option value=".$searchTypeValue.">".$searchTypeName."</option>";}?>
<option value="1|All">All</option>
<option value="2|Customer Name">Customer Name</option>
<option value="3|Quotation No">Quotation No</option>
</select>


</td>
<td><input type="text" name="searchName" size="18" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<input id="demo1" type="text" name="quotationDate1" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['quotationDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;TO&nbsp;


</td>
<td>

<input id="demo2" type="text" name="quotationDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['quotationDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;


</td>
<td><input type="submit" name="Submit" value="Search Quotation"></td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultQuotationList) > 0){
		echo "<table width='1100' height='25' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultQuotationList)."&nbsp;records</td><td align='right'></td></tr></table>";
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";		
		
		
		//echo "<tr><td style='width:100'><b>Quote No</b></td><td style='width:100'><b>Date</b></td><td style='width:100'><b>DO</b></td><td style='width:100'><b>Invoice</b></td><td style='width:670'><b>Customer</b></td><td style='width:70'><b>Total</b></td><td style='width:50'><b>Edit</b></td><td style='width:50'><b>Print</b></td><td style='width:50'><b>Del</b></td></tr>";
		
		echo "<thead><tr>";
		echo "<td style='width:105'><p style=\"font-size:12px\"><b>Quote No</b></p></td>";
		echo "<td style='width:85'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:530'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:95'><p style=\"font-size:12px\"><b>DO</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Invoice</b></p></td>";
		
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Total</b></p></td>";			
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "<td style='width:40'><p style=\"font-size:12px\"><b>Print</b></p></td>";			
		echo "<td style='width:65'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "</tr></thead>";
		
		
		
		
		
		
		while($rowQuotationList = mysqli_fetch_row($resultQuotationList)){
			if(date('Y-m-d')==$rowQuotationList[4]){
				echo "<tr bgcolor='e1f7e7' height='30' class='notfirst'>";
			}else{	
				echo "<tr height='30' class='notfirst'>";
			}		
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowQuotationList[3]</p></td>";			
			echo "<td style='width:100'><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowQuotationList[4]))."</p></td>";
			
			echo "<td style='width:750'><p style=\"font-size:12px\">$rowQuotationList[1]</p></td>";	
			
			if($rowQuotationList[9]==0){
				echo "<td style='width:100' align='center'>&nbsp;</td>";
			}else{
				echo "<td style='width:100' align='left'><p style=\"font-size:12px\">".$rowQuotationList[10]."</p></td>";
			}
			
			if($rowQuotationList[7]==0){
				echo "<td style='width:100' align='center'>&nbsp;</td>";
			}else{
				echo "<td style='width:100' align='left'><p style=\"font-size:12px\">".$rowQuotationList[8]."</p></td>";
			}
			
			
			
			/* $strPositionText = $rowQuotationList[5];
			if(strlen($strPositionText) > 30){
			$strPositionText = substr($strPositionText, 0, 30).'...';
				echo "<td>$strPositionText</td>";
			}else{
				echo "<td>$strPositionText</td>";
			} */
			echo "<td style='width:70' align='right'><p style=\"font-size:12px\">$rowQuotationList[6]</p></td>";
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='editQuotation.php?idQuotation=$rowQuotationList[2]&idCustomer=$rowQuotationList[0]'>edit</a></p></td>";			
			echo "<td style='width:50' align='center'><p style=\"font-size:12px\"><a href='printQuotation.php?idQuotation=$rowQuotationList[2]&idCustomer=$rowQuotationList[0]' target='_blank'>print</a></p></td>";
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='quotationList.php?idQuotationDelete=$rowQuotationList[2]' onclick=\"return CheckAndDelete()\">del</a></p></td>";
			echo "</tr>";			
		}		
		echo "</table>";
	}else{
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:105'><p style=\"font-size:12px\"><b>Quote No</b></p></td>";
		echo "<td style='width:85'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:530'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:95'><p style=\"font-size:12px\"><b>DO</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Invoice</b></p></td>";
		
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Total</b></p></td>";			
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "<td style='width:40'><p style=\"font-size:12px\"><b>Print</b></p></td>";			
		echo "<td style='width:65'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "</tr></thead>";
		echo "</table>";
		
		
		
		
		
	}

?>
</center>
</form>
</body>
</html>
