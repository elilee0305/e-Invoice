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

	if(isset($_GET['idCreditNoteDelete'])){ 
		$creditNoteID = $_GET['idCreditNoteDelete'];
		$invoiceID = $_GET['idInvoice'];
		$customerID = $_GET['idCustomer'];
		//get the credit note amount
		$sqlCreditNoteAmount = "SELECT creditNote_grandTotalRound FROM tbcreditnote WHERE creditNote_id = '$creditNoteID'";
		$resultCreditNoteAmount = mysqli_query($connection, $sqlCreditNoteAmount) or die("error in credit note amount query");
		$rowCreditNoteAmount = mysqli_fetch_row($resultCreditNoteAmount);
		$creditNoteAmount = $rowCreditNoteAmount[0];
		
		//update the invoice credit note amount		
		$sqlUpdateInvoiceCreditNote = "UPDATE tbinvoice SET invoice_creditNote = (invoice_creditNote - $creditNoteAmount) 
		WHERE invoice_id = '$invoiceID'";		
		
		$sqlDeleteCreditNote = "DELETE creditNote, creditNoteDetail 
		FROM tbcreditnote creditNote 
		JOIN tbcreditnotedetail creditNoteDetail 
		ON creditNote.creditNote_id = creditNoteDetail.creditNoteDetail_creditNoteID 
		WHERE creditNote.creditNote_id = '$creditNoteID'";
		
		//delete the customer account 
		$sqlDeleteCustomerAccount = "DELETE FROM tbcustomeraccount WHERE (customerAccount_customerID = '$customerID') AND 
		(customerAccount_documentTypeID = '$creditNoteID') AND (customerAccount_documentType = 'CN')";
		
		// delete account receiveable & sales & tax payable & Rounding account together, all hard coded from database
		$sqlDeleteAccountReceiveableSales = "DELETE FROM tbaccount4 WHERE  account4_account3ID IN (2, 4, 10, 11) AND 
		(account4_documentType = 'CN') AND (account4_documentTypeID = '$creditNoteID')";
		
		
		
		//Begin transaaction										
		/* disable autocommit */	
		mysqli_query($connection, $sqlUpdateInvoiceCreditNote);	
		mysqli_query($connection, $sqlDeleteCreditNote);
		mysqli_query($connection, $sqlDeleteCustomerAccount);
		mysqli_query($connection, $sqlDeleteAccountReceiveableSales);
		/* commit update & delete */
		mysqli_commit($connection);
	}	
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$creditNoteDate1Converted = convertMysqlDateFormat($_POST['creditNoteDate1']);
		$creditNoteDate2Converted = convertMysqlDateFormat($_POST['creditNoteDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);
		
		$searchTypeName = $searchType[1];	
		
				
		$sqlCreditNoteList3 = "AND (creditNote_date BETWEEN '$creditNoteDate1Converted' AND '$creditNoteDate2Converted') ";		
		
		if($searchType[0] == 1){
			//all
			$sqlCreditNoteList2 = "";			
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			$sqlCreditNoteList2 = "AND (customer_name LIKE '$searchName') "; 
		}else{
			//credit note no
			$sqlCreditNoteList2 = "AND (creditNote_no = '$searchName') ";
			$sqlCreditNoteList3 = "";	
		}	
		
		$sqlCreditNoteList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, creditNote_id, creditNote_no,  
		creditNote_date, creditNote_grandTotalRound	FROM tbcustomer, tbinvoice, tbcreditnote WHERE (customer_id = invoice_customerID) AND (invoice_id  = creditNote_invoiceID) ";
		
		$sqlCreditNoteList = $sqlCreditNoteList.$sqlCreditNoteList2.$sqlCreditNoteList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$creditNoteDate1Converted = date("Y-m-01", strtotime($dt));
		$creditNoteDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlCreditNoteList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, creditNote_id, creditNote_no, 
		creditNote_date, creditNote_grandTotalRound	FROM tbcustomer, tbinvoice, tbcreditnote WHERE (customer_id = invoice_customerID) AND (invoice_id  = creditNote_invoiceID)";
		
		$sqlCreditNoteList3 = "AND (creditNote_date BETWEEN '$creditNoteDate1Converted' AND '$creditNoteDate2Converted') ";
		
		$sqlCreditNoteList = $sqlCreditNoteList.$sqlCreditNoteList3;
	
	}	
	
	$sqlCreditNoteList4 = "ORDER BY creditNote_date DESC, creditNote_id DESC";
	
	$sqlCreditNoteList = $sqlCreditNoteList.$sqlCreditNoteList4;
	
	//credit note list	
	$resultCreditNoteList = mysqli_query($connection, $sqlCreditNoteList) or die("error in credit note list query");
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
		var r = confirm("Do you want to DELETE this Credit Note?");
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
    <a href="invoiceListCreditNote.php">Create Credit Note</a>
    
  </nav>
</main2>


<table width="1000" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Credit Note List</h1></td><td width="350"></td></tr></table>
<table width="1000" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="creditNoteList.php" id="creditNoteListForm" method="post">
<table border="0" cellpadding="0" width="1000">
<tr height="15">

<td><select name="searchType" id="searchType" size="1">
<?php if(isset($_POST['Submit'])){echo "<option value=".$searchTypeValue.">".$searchTypeName."</option>";}?>
<option value="1|All">All</option>
<option value="2|Customer Name">Customer Name</option>
<option value="3|Credit Note No">Credit Note No</option>
</select>


</td>
<td><input type="text" name="searchName" size="18" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<input id="demo1" type="text" name="creditNoteDate1" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['creditNoteDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;TO&nbsp;


</td>
<td>

<input id="demo2" type="text" name="creditNoteDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['creditNoteDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;


</td>
<td><input type="submit" name="Submit" value="Search Credit Note"></td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultCreditNoteList) > 0){
		echo "<table width='1100' height='25' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultCreditNoteList)."&nbsp;records</td><td align='right'></td></tr></table>";
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";		
		//echo "<tr><td style='width:100'><p style=\"font-size:12px\"><b>CN No</b></p></td><td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td><td style='width:100'><p style=\"font-size:12px\"><b>Invoice</b></p></td><td style='width:770'><p style=\"font-size:12px\"><b>Customer</b></p></td><td style='width:170'><p style=\"font-size:12px\"><b>Total</b></p></td><td style='width:50'><p style=\"font-size:12px\"><b>Edit</b></p></td><td style='width:50'><p style=\"font-size:12px\"><b>Print</b></p></td><td style='width:50'><p style=\"font-size:12px\"><b>Del</b></p></td></tr>";
		
		
		
		echo "<thead><tr>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>CN No</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Invoice</b></p></td>";
		echo "<td style='width:540'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Total</b></p></td>";					
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Print</b></p></td>";			
		echo "<td style='width:60'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "</tr></thead>";
		
		
		
		
		
		
		while($rowCreditNoteList = mysqli_fetch_row($resultCreditNoteList)){
			//echo "<tr class='notfirst'>";

			if(date('Y-m-d')==$rowCreditNoteList[7]){
				echo "<tr bgcolor='e1f7e7' height='30' class='notfirst'>";
			}else{	
				echo "<tr height='30' class='notfirst'>";
			}


			
			echo "<td style='width:93'><p style=\"font-size:12px\">$rowCreditNoteList[6]</p></td>";			
			echo "<td style='width:94'><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowCreditNoteList[7]))."</p></td>";
			
			echo "<td style='width:100' align='left'><p style=\"font-size:12px\">".$rowCreditNoteList[3]."</p></td>";
			/* 
			if($rowCreditNoteList[9]==0){
				echo "<td align='center'>&nbsp;</td>";
			}else{
				echo "<td align='left'>".$rowCreditNoteList[10]."</td>";
			} */
			
			
			
			echo "<td style='width:560'><p style=\"font-size:12px\">$rowCreditNoteList[1]</p></td>";	
			
			/* $strPositionText = $rowCreditNoteList[5];
			if(strlen($strPositionText) > 30){
			$strPositionText = substr($strPositionText, 0, 30).'...';
				echo "<td>$strPositionText</td>";
			}else{
				echo "<td>$strPositionText</td>";
			} */
			echo "<td style='width:100' align='right'><p style=\"font-size:12px\">$rowCreditNoteList[8]</p></td>";
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='editCreditNote.php?idCreditNote=$rowCreditNoteList[5]&idCustomer=$rowCreditNoteList[0]'>edit</a></p></td>";			
			echo "<td style='width:50' align='center'><p style=\"font-size:12px\"><a href='printCreditNote.php?idCreditNote=$rowCreditNoteList[5]&idCustomer=$rowCreditNoteList[0]' target='_blank'>print</a></p></td>";
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='creditNoteList.php?idCreditNoteDelete=$rowCreditNoteList[5]&idInvoice=$rowCreditNoteList[2]&idCustomer=$rowCreditNoteList[0]' onclick=\"return CheckAndDelete()\">del</a></p></td>";
			echo "</tr>";			
		}		
		echo "</table>";
	}else{
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";
		
		echo "<thead><tr>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>CN No</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Invoice</b></p></td>";
		echo "<td style='width:540'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Total</b></p></td>";					
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Print</b></p></td>";			
		echo "<td style='width:60'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "</tr></thead>";
		
		echo "</table>";
		
		
	}

?>
</center>
</form>
</body>
</html>
