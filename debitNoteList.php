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

	if(isset($_GET['idDebitNoteDelete'])){ 
		$debitNoteID = $_GET['idDebitNoteDelete'];
		$invoiceID = $_GET['idInvoice'];
		$customerID = $_GET['idCustomer'];
		//get the credit note amount
		$sqlDebitNoteAmount = "SELECT debitNote_grandTotalRound FROM tbdebitnote WHERE debitNote_id = '$debitNoteID'";
		$resultDebitNoteAmount = mysqli_query($connection, $sqlDebitNoteAmount) or die("error in debit note amount query");
		$rowDebitNoteAmount = mysqli_fetch_row($resultDebitNoteAmount);
		$debitNoteAmount = $rowDebitNoteAmount[0];
		
		//update the invoice debit note amount		
		$sqlUpdateInvoiceDebitNote = "UPDATE tbinvoice SET invoice_debitNote = (invoice_debitNote - $debitNoteAmount) 
		WHERE invoice_id = '$invoiceID'";		
		
		$sqlDeleteDebitNote = "DELETE debitNote, debitNoteDetail 
		FROM tbdebitnote debitNote 
		JOIN tbdebitnotedetail debitNoteDetail 
		ON debitNote.debitNote_id = debitNoteDetail.debitNoteDetail_debitNoteID 
		WHERE debitNote.debitNote_id = '$debitNoteID'";
		
		//delete the customer account 
		$sqlDeleteCustomerAccount = "DELETE FROM tbcustomeraccount WHERE (customerAccount_customerID = '$customerID') AND 
		(customerAccount_documentTypeID = '$debitNoteID') AND (customerAccount_documentType = 'DN')";
		
		// delete account receiveable & sales & tax payable & Rounding account together, all hard coded from database
		$sqlDeleteAccountReceiveableSales = "DELETE FROM tbaccount4 WHERE  account4_account3ID IN (2, 4, 10, 11) AND 
		(account4_documentType = 'DN') AND (account4_documentTypeID = '$debitNoteID')";
		
		
		
		//Begin transaaction										
		/* disable autocommit */	
		mysqli_query($connection, $sqlUpdateInvoiceDebitNote);	
		mysqli_query($connection, $sqlDeleteDebitNote);
		mysqli_query($connection, $sqlDeleteCustomerAccount);
		mysqli_query($connection, $sqlDeleteAccountReceiveableSales);
		/* commit update & delete */
		mysqli_commit($connection);
	}	
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$debitNoteDate1Converted = convertMysqlDateFormat($_POST['debitNoteDate1']);
		$debitNoteDate2Converted = convertMysqlDateFormat($_POST['debitNoteDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);
		
		$searchTypeName = $searchType[1];	
		
				
		$sqlDebitNoteList3 = "AND (debitNote_date BETWEEN '$debitNoteDate1Converted' AND '$debitNoteDate2Converted') ";		
		
		if($searchType[0] == 1){
			//all
			$sqlDebitNoteList2 = "";			
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			$sqlDebitNoteList2 = "AND (customer_name LIKE '$searchName') "; 
		}else{
			//credit note no
			$sqlDebitNoteList2 = "AND (debitNote_no = '$searchName') ";
			$sqlDebitNoteList3 = "";	
		}	
		
		$sqlDebitNoteList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, debitNote_id, debitNote_no,  
		debitNote_date, debitNote_grandTotalRound	FROM tbcustomer, tbinvoice, tbdebitnote WHERE (customer_id = invoice_customerID) AND (invoice_id  = debitNote_invoiceID) ";
		
		$sqlDebitNoteList = $sqlDebitNoteList.$sqlDebitNoteList2.$sqlDebitNoteList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$debitNoteDate1Converted = date("Y-m-01", strtotime($dt));
		$debitNoteDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlDebitNoteList = "SELECT customer_id, customer_name, invoice_id, invoice_no, invoice_date, debitNote_id, debitNote_no, 
		debitNote_date, debitNote_grandTotalRound	FROM tbcustomer, tbinvoice, tbdebitnote WHERE (customer_id = invoice_customerID) AND (invoice_id  = debitNote_invoiceID)";
		
		$sqlDebitNoteList3 = "AND (debitNote_date BETWEEN '$debitNoteDate1Converted' AND '$debitNoteDate2Converted') ";
		
		$sqlDebitNoteList = $sqlDebitNoteList.$sqlDebitNoteList3;
	
	}	
	
	$sqlDebitNoteList4 = "ORDER BY debitNote_date DESC, debitNote_id DESC";
	
	$sqlDebitNoteList = $sqlDebitNoteList.$sqlDebitNoteList4;
	
	//credit note list	
	$resultDebitNoteList = mysqli_query($connection, $sqlDebitNoteList) or die("error in debit note list query");
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
		var r = confirm("Do you want to DELETE this Debit Note?");
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
    <a href="invoiceListDebitNote.php">Create Debit Note</a>
    
  </nav>
</main2>


<table width="1000" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Debit Note List</h1></td><td width="350"></td></tr></table>
<table width="1000" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="debitNoteList.php" id="debitNoteListForm" method="post">
<table border="0" cellpadding="0" width="1000">
<tr height="15">

<td><select name="searchType" id="searchType" size="1">
<?php if(isset($_POST['Submit'])){echo "<option value=".$searchTypeValue.">".$searchTypeName."</option>";}?>
<option value="1|All">All</option>
<option value="2|Customer Name">Customer Name</option>
<option value="3|Credit Note No">Debit Note No</option>
</select>


</td>
<td><input type="text" name="searchName" size="18" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<input id="demo1" type="text" name="debitNoteDate1" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['debitNoteDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;TO&nbsp;


</td>
<td>

<input id="demo2" type="text" name="debitNoteDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['debitNoteDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;


</td>
<td><input type="submit" name="Submit" value="Search Credit Note"></td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultDebitNoteList) > 0){
		echo "<table width='1100' height='25' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultDebitNoteList)."&nbsp;records</td><td align='right'></td></tr></table>";
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";		
		//echo "<tr><td style='width:100'><p style=\"font-size:12px\"><b>CN No</b></p></td><td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td><td style='width:100'><p style=\"font-size:12px\"><b>Invoice</b></p></td><td style='width:770'><p style=\"font-size:12px\"><b>Customer</b></p></td><td style='width:170'><p style=\"font-size:12px\"><b>Total</b></p></td><td style='width:50'><p style=\"font-size:12px\"><b>Edit</b></p></td><td style='width:50'><p style=\"font-size:12px\"><b>Print</b></p></td><td style='width:50'><p style=\"font-size:12px\"><b>Del</b></p></td></tr>";
		
		
		
		echo "<thead><tr>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>DN No</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Invoice</b></p></td>";
		echo "<td style='width:540'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Total</b></p></td>";					
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Print</b></p></td>";			
		echo "<td style='width:60'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "</tr></thead>";
		
		
		
		
		
		
		while($rowDebitNoteList = mysqli_fetch_row($resultDebitNoteList)){
			//echo "<tr class='notfirst'>";

			if(date('Y-m-d')==$rowDebitNoteList[7]){
				echo "<tr bgcolor='e1f7e7' height='30' class='notfirst'>";
			}else{	
				echo "<tr height='30' class='notfirst'>";
			}


			
			echo "<td style='width:93'><p style=\"font-size:12px\">$rowDebitNoteList[6]</p></td>";			
			echo "<td style='width:94'><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowDebitNoteList[7]))."</p></td>";
			
			echo "<td style='width:100' align='left'><p style=\"font-size:12px\">".$rowDebitNoteList[3]."</p></td>";
			/* 
			if($rowDebitNoteList[9]==0){
				echo "<td align='center'>&nbsp;</td>";
			}else{
				echo "<td align='left'>".$rowDebitNoteList[10]."</td>";
			} */
			
			
			
			echo "<td style='width:560'><p style=\"font-size:12px\">$rowDebitNoteList[1]</p></td>";	
			
			/* $strPositionText = $rowDebitNoteList[5];
			if(strlen($strPositionText) > 30){
			$strPositionText = substr($strPositionText, 0, 30).'...';
				echo "<td>$strPositionText</td>";
			}else{
				echo "<td>$strPositionText</td>";
			} */
			echo "<td style='width:100' align='right'><p style=\"font-size:12px\">$rowDebitNoteList[8]</p></td>";
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='editDebitNote.php?idDebitNote=$rowDebitNoteList[5]&idCustomer=$rowDebitNoteList[0]'>edit</a></p></td>";			
			echo "<td style='width:50' align='center'><p style=\"font-size:12px\"><a href='printDebitNote.php?idDebitNote=$rowDebitNoteList[5]&idCustomer=$rowDebitNoteList[0]' target='_blank'>print</a></p></td>";
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='debitNoteList.php?idDebitNoteDelete=$rowDebitNoteList[5]&idInvoice=$rowDebitNoteList[2]&idCustomer=$rowDebitNoteList[0]' onclick=\"return CheckAndDelete()\">del</a></p></td>";
			echo "</tr>";			
		}		
		echo "</table>";
	}else{
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";
		
		echo "<thead><tr>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>DN No</b></p></td>";
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
