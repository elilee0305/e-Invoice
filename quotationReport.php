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

	if(isset($_GET['idQuotationDelete'])){
		$quotationID = $_GET['idQuotationDelete'];
		//delete quotation detail
		$sqlDeleteQuotationDetail = "DELETE FROM tbquotationdetail WHERE quotationDetail_quotationID = '$quotationID'";
		$sqlDeleteQuotation = "DELETE FROM tbquotation WHERE quotation_id = '$quotationID'";
		
		mysqli_query($connection, $sqlDeleteQuotationDetail) or die("error in delete quotation detail query");
		mysqli_query($connection, $sqlDeleteQuotation) or die("error in delete quotation query");		
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
		
		$sqlQuotationList = "SELECT customer_id, customer_name, quotation_id, quotation_no, quotation_date, quotation_title, quotation_grandTotalRound 
		FROM tbcustomer, tbquotation WHERE (customer_id = quotation_customerID) ";
		
		$sqlQuotationList = $sqlQuotationList.$sqlQuotationList2.$sqlQuotationList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$quotationDate1Converted = date("Y-m-01", strtotime($dt));
		$quotationDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlQuotationList = "SELECT customer_id, customer_name, quotation_id, quotation_no, quotation_date, quotation_title, quotation_grandTotalRound 
		FROM tbcustomer, tbquotation WHERE (customer_id = quotation_customerID) ";
		
		$sqlQuotationList3 = "AND (quotation_date BETWEEN '$quotationDate1Converted' AND '$quotationDate2Converted') ";
		
		$sqlQuotationList = $sqlQuotationList.$sqlQuotationList3;
	
	}	
	
	$sqlQuotationList4 = "ORDER BY quotation_date ASC, quotation_id ASC";
	
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


<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><b><font size="4" color="#4d4e4f">Quotation Report</font></b></td><td width="350"></td></tr></table>
<table width="700" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="quotationReport.php" id="quotationReportForm" method="post">
<table border="0" cellpadding="0" width="800">
<tr height="30">

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
		$intCounter = 1;
		$totalQuotation = 0.00;
		echo "<table width='900' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultQuotationList)."&nbsp;records</td><td align='right'></td></tr></table>";
		
		echo "<table width='900' cellpadding='0' border='1' class='mystyle'>";		
		echo "<tr bgcolor='#EAEAEA'><td style='width:30'><b>No</b></td><td style='width:100'><b>Quote No</b></td><td style='width:100'><b>Date</b></td><td style='width:570'><b>Customer</b></td><td style='width:100'><b>Total</b></td></tr>";
		while($rowQuotationList = mysqli_fetch_row($resultQuotationList)){
			echo "<tr class='notfirst'>";
			echo "<td align='center'>$intCounter</td>";
			echo "<td>$rowQuotationList[3]</td>";			
			echo "<td>".date("d/m/Y",strtotime($rowQuotationList[4]))."</td>";
			echo "<td>$rowQuotationList[1]</td>";	
			
			
			echo "<td align='right'>".number_format($rowQuotationList[6],2)."</td>";			
			echo "</tr>";
			$totalQuotation = $totalQuotation + $rowQuotationList[6];
			$intCounter = $intCounter + 1;
		}		
		echo "<tr><td colspan='4' align='right'><b>Total</b></td><td align='right'>".number_format($totalQuotation,2)."</td></tr>";
		echo "</table>";
	}

?>
<br>
<table width="150"><tr><td><input type="button" class="noPrint" onclick="JavaScript:window.print();return false;" value="Print Quotation Report"></td></tr></table>
<br>
</center>
</form>
</body>
</html>
