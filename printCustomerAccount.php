<?php 

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
	
	if(isset($_GET['customerID'])){		
		$customerID = $_GET['customerID'];
		$accountDate1Converted = convertMysqlDateFormat($_GET['startDate']);
		$accountDate2Converted = convertMysqlDateFormat($_GET['endDate']);
		$strStartDate = $_GET['startDate'];
		$strEndDate = $_GET['endDate'];
	}

	//get the company name
	$sqlCompanyName = "SELECT company_name, company_address1, company_address2, company_telFax, company_logo, company_no FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$rowCompanyName = mysqli_fetch_row($resultCompanyName);

	//get the customer info	
	$sqlCustomerInfo = "SELECT customer_name, customer_tel, customer_address, customer_attention FROM tbcustomer WHERE customer_id = '$customerID'";	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer query");
	$resultCustomerInfo2 = mysqli_fetch_row($resultCustomerInfo);


	//get the Opening Balance
	
	$openingBalance = 0.00;
	$getOpeningBalance = "SELECT COALESCE(SUM(customerAccount_debit - customerAccount_credit),0.00) AS openingBalance FROM tbcustomeraccount WHERE (customerAccount_customerID = '$customerID ') AND (customerAccount_date < '$accountDate1Converted')";
	
	$resultGetOpeningBalance = mysqli_query($connection, $getOpeningBalance) or die("error in getting opening balance query");
	
	$rowGetOpeningBalance = mysqli_fetch_row($resultGetOpeningBalance);
	$openingBalance = $rowGetOpeningBalance[0];

	$sqlGetCustomerAccount = "SELECT customerAccount_date, customerAccount_reference, customerAccount_description, customerAccount_debit, 
	customerAccount_credit FROM tbcustomeraccount WHERE (customerAccount_customerID = '$customerID ') AND 
	(customerAccount_date BETWEEN '$accountDate1Converted' AND '$accountDate2Converted') ORDER BY customerAccount_date ASC, customerAccount_id ASC";
	
	$resultGetCustomerAccount = mysqli_query($connection, $sqlGetCustomerAccount) or die("error in customer account query");

	//initialise the array
	$aCustomerAccountDetail = array();
	
	if(mysqli_num_rows($resultGetCustomerAccount) > 0){
		//insert opening balance info for the First row
		$aCustomerAccountDetail[0][0] = $strStartDate;			
		$aCustomerAccountDetail[0][1] = "";			
		$aCustomerAccountDetail[0][2] = "Opening Balance";			
		$aCustomerAccountDetail[0][3] = "";	// Debit		
		$aCustomerAccountDetail[0][4] = "";	// Credit		
		$aCustomerAccountDetail[0][5] = number_format($openingBalance,2); // Balance
		
		$rowBalance = 0.00;
		$h = 1;
		while($rowCustomerAccountDetail = mysqli_fetch_row($resultGetCustomerAccount)){
			if($h > 1){$openingBalance = $rowBalance;}
			$aCustomerAccountDetail[$h][0] = date("d/m/Y",strtotime($rowCustomerAccountDetail[0]));			
			$aCustomerAccountDetail[$h][1] = $rowCustomerAccountDetail[1];			
			$aCustomerAccountDetail[$h][2] = $rowCustomerAccountDetail[2];			
			$aCustomerAccountDetail[$h][3] = number_format($rowCustomerAccountDetail[3],2);			
			$aCustomerAccountDetail[$h][4] = number_format($rowCustomerAccountDetail[4],2);	
			$rowBalance = $openingBalance + $rowCustomerAccountDetail[3] - $rowCustomerAccountDetail[4];
			$aCustomerAccountDetail[$h][5] = number_format($rowBalance,2);			
			$h = $h + 1;
		}		
	}else{
		// NO EXISTING RECORDS, //initialize to to empty array
		$aCustomerAccountDetail = array();
	}





?>

<html>
<head>
<title>Imes Online System</title>
<!--<script src="js/jquery-3.2.1.min.js"></script>-->
<style type="text/css">
@media print {
	.noPrint{
	display: none;
	}
}

table.mystyle2
{
	border-collapse: collapse;
	width: 950px;
	page-break-inside: avoid;		
}

table.mystyle
{
	border-collapse: collapse;
	width: 950px;
	border-top: 1px solid black;
	border-right: 1px solid black;
	border-bottom: 1px solid black;
	border-left: 1px solid black;
	border-color: #cbcecb;
}

.mystyle td
{
	 /*text-align: left;*/
	vertical-align: top;
	padding: 8px;
}

.mystyle tr:nth-child(even){background-color: #f2f2f2}

.mystyle th {
	text-align: left;
	background-color: #F2F1F0;
	color: black;
	vertical-align: top;
	padding: 8px;
}

.header img{           
	float: left;	
	width: 142px;
	height: 58px;
	/* border: thin solid #0000FF; */
}

.header h1 {
  position: relative;
  top: 11px;
  left: 20px;
  font-size: 24px;
  display: inline;
  /* border: thin solid #0000FF; */
}

.header h2 {
  position: relative;
  top: 14px;
  left: 162px;
  font-size: 13px;
  /* border: thin solid #0000FF; */
}

.header h3 {
  position: relative;
  top: 16px;
  left: 20px;
  font-size: 12px;
  display: inline;
  /* border: thin solid #0000FF; */
}

.row {
  line-height: 0.6;
  width: 750px;
}

.content {
  max-width: 950px;
  margin: auto;  
}

#signature {
  width: 50%;
  border-bottom: 1px solid black;
  height: 75px;
}
</style>




</head>
<body style="font-family: Helvetica;">
<div class="content">
<div class="header">

<?php 
	if($rowCompanyName[4] !== ""){
		$logoLocation = "logo/".$rowCompanyName[4];
		echo "<img src=".$logoLocation.">";
	}
?>
<h1><?php echo $rowCompanyName[0];?></h1>&nbsp;&nbsp;&nbsp;<h3><?php echo "Com No: ".$rowCompanyName[5];?></h3>
	
	<div class="row">
		<h2 style="left:20px;"><?php echo $rowCompanyName[1];?></h2>
		<h2 style="left:20px;"><?php echo $rowCompanyName[2];?></h2>
		<h2><?php echo $rowCompanyName[3];?></h2>
	</div>
</div>

<hr style="margin-top:30px;margin-bottom:15px;">

<table width="950px" border="0" class="mystyle2">
<tr><td colspan="5" align="right"></td></tr>
<tr><td style="width:10%;border-top:1px solid #cbcecb;border-left:1px solid #cbcecb;" bgcolor="#F2F1F0"></td><td bgcolor="#F2F1F0" style="width:50%;border-top:1px solid #cbcecb;border-right:1px solid #cbcecb;"></td><td style="width:15%;">&nbsp;</td><td style="width:15%;"></td><td></td></tr>
<tr><td colspan="2" style="border-top:1px solid #cbcecb;border-left:1px solid #cbcecb;border-right:1px solid #cbcecb;"><b><?php echo $resultCustomerInfo2[0]?></b></td><td ></td><td></td><td></td></tr>
<tr><td colspan="2" style="border-left:1px solid #cbcecb;border-right:1px solid #cbcecb;"><?php echo nl2br($resultCustomerInfo2[2]);?></td><td></td><td valign="top" style="width:15%;"><b>Statement Date</b></td><td valign="top"><?php echo date('d/m/Y');?></td></tr>


<tr><td style="border-left:1px solid #cbcecb;"><b>Tel</b></td><td  align="left" style="border-right:1px solid #cbcecb;"><?php echo $resultCustomerInfo2[1]?></td><td ></td><td><b></b></td><td>

</td></tr>

<tr><td style="border-bottom:1px solid #cbcecb;border-left:1px solid #cbcecb;"></td><td style="border-bottom:1px solid #cbcecb;border-right:1px solid #cbcecb;"></td><td></td><td></td><td></td></tr>
<tr height="10px"><td colspan="5" align="left">&nbsp;</td></tr>
</table>

<table width="950px" class="mystyle2" border="0">
<tr><td style="width:10%"><b>Attention</b></td><td><?php echo $resultCustomerInfo2[3]?></td><td></td><td></td><td></td></tr>
<tr height="5px"><td colspan="5" align="left">&nbsp;</td></tr>
<tr><td style="width:10%"><b>Period</b></td><td>

<?php
	$periodValue = $strStartDate." - ".$strEndDate;
	echo $periodValue;
?>
</td><td></td><td></td><td></td></tr>


<tr height="25"><td colspan="5" align="left"><div></div></td></tr>
<tr><td colspan="5" align="left"></td></tr>
</table>
<p></p>

<?php
	echo "<table width='900' cellpadding='0' border='1' class='mystyle'>";		
	echo "<tr><td style='width:100'><b>Date</b></td><td style='width:200'><b>Reference</b></td><td style='width:300'><b>Description</b></td><td style='width:100'><b>Debit</b></td><td style='width:100'><b>Credit</b></td><td style='width:100'><b>Balance</b></td></tr>";
	
	
	if(empty($aCustomerAccountDetail)){
		//No records 
		
		
	}else{
		
		for($i = 0; $i < count($aCustomerAccountDetail); $i++){
			echo "<tr>";
			
			for($j = 0; $j <= 5; $j++){
				if($j <= 2){
					echo "<td>".$aCustomerAccountDetail[$i][$j]."</td>";
				}else{
					echo "<td align='right'>".$aCustomerAccountDetail[$i][$j]."</td>";
				}
			}
			
			
			echo "</tr>";			
		}
		
		
		
		
		
		
		
	}

	echo "</table>";



?>













<table class="mystyle2">
<tr><td height="20">&nbsp;</td></tr>
<!--<tr><td colspan="5" align="left"><textarea style="border: none; font-family: Helvetica ; font-size: 16px;" cols="100" rows="8" name="quotationTerms" maxlength="1000"><?php //echo $rowInvoiceInfo[4]; ?></textarea></td></tr>-->
<td colspan="5" align="left"><div></div></td></tr>
<tr height="20"><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5"></td></tr>
<tr><td colspan="5" align="left"></td></tr>
<tr><td colspan="5" align="center">

<input type="hidden" name="customerID" value="<?php echo $customerID?>">
</table>
<br>

<p>
<input type="button" class="noPrint" onclick="JavaScript:window.print();return false;" value="Print Customer Account">
&nbsp;&nbsp;




</p>
</div>
</body>
</html>