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

	//get the company name
	$sqlCompanyName = "SELECT company_name, company_address1, company_address2, company_telFax, company_logo, company_no
	FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$rowCompanyName = mysqli_fetch_row($resultCompanyName);
	
	if(isset($_GET['idPaymentVoucher'])){		
		$paymentVoucherID = $_GET['idPaymentVoucher'];
		$customerID = $_GET['idCustomer'];
	}
	
	//get the customer info	
	$sqlCustomerInfo = "SELECT customer_name, customer_tel, customer_address, customer_email FROM tbcustomer WHERE customer_id = '$customerID'";	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer query");
	$resultCustomerInfo2 = mysqli_fetch_row($resultCustomerInfo);
	
	//get payment voucher info
	$sqlPaymentInfo = "SELECT paymentMethod_name, paymentVoucher_no, paymentVoucher_date, paymentVoucher_chequeInfo, paymentVoucher_remark, 
	paymentVoucher_grandTotalRound, paymentVoucher_email FROM tbpaymentmethod, tbpaymentvoucher 
	WHERE (paymentMethod_id = paymentVoucher_paymentMethodID) AND (paymentVoucher_id = '$paymentVoucherID')";
	
	$resultPaymentInfo = mysqli_query($connection, $sqlPaymentInfo) or die("error in payment info query");
	$resultPaymentInfo2 = mysqli_fetch_row($resultPaymentInfo);
	
	
	
	$sqlPaymentDetail = "SELECT purchaseBill_customerInvoiceNo, paymentVoucherDetail_rowTotalAfterDiscount, purchaseBill_id FROM tbpurchasebill, tbpaymentvoucherdetail 
	WHERE (purchaseBill_id = paymentVoucherDetail_purchaseBillID) AND (paymentVoucherDetail_paymentVoucherID = '$paymentVoucherID') 
	ORDER BY paymentVoucherDetail_id ASC";
	
	$resultPaymentDetail = mysqli_query($connection, $sqlPaymentDetail) or die("error in get payment detail query");
	
	






	
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

.mystyle td, mystyle th
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
<body style="font-family: Helvetica ;">
<div class="content">
<div class="header">
<?php 
	if($rowCompanyName[4] ==! ""){
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

<table width="950px" class="mystyle2" border="0">
<tr><td colspan="5" align="right"><b>PAYMENT VOUCHER</b></td></tr>
<tr><td style="width:10%;border-top:1px solid #cbcecb;border-left:1px solid #cbcecb;" bgcolor="#F2F1F0"></td><td bgcolor="#F2F1F0" style="width:50%;border-top:1px solid #cbcecb;border-right:1px solid #cbcecb;"></td><td style="width:15%;border-right:1px solid #cbcecb;">&nbsp;</td><td bgcolor="#F2F1F0" style="width:10%px;border-top:1px solid #cbcecb;"></td><td bgcolor="#F2F1F0" style="width:15%;border-top:1px solid #cbcecb;border-right:1px solid #cbcecb;"></td></tr>
<tr><td colspan="2" style="border-top:1px solid #cbcecb;border-left:1px solid #cbcecb;border-right:1px solid #cbcecb;"><b><?php echo $resultCustomerInfo2[0]?></b></td><td></td><td style="border-top:1px solid #cbcecb;border-left:1px solid #cbcecb;"><b>PV No</b></td><td style="border-top:1px solid #cbcecb;border-right:1px solid #cbcecb;"><?php echo $resultPaymentInfo2[1];?></td></tr>
<tr><td colspan="2" style="border-left:1px solid #cbcecb;border-right:1px solid #cbcecb;"><?php echo nl2br($resultCustomerInfo2[2]);?></td><td></td><td valign="top" style="border-left:1px solid #cbcecb;border-bottom:1px solid #cbcecb;"><b>Date</b></td><td valign="top" style="border-right:1px solid #cbcecb;border-bottom:1px solid #cbcecb;"><?php echo date("d/m/y",strtotime($resultPaymentInfo2[2]))?></td></tr>

<tr><td style="border-left:1px solid #cbcecb;"><b>Tel</b></td><td align="left" style="border-right:1px solid #cbcecb;"><?php echo $resultCustomerInfo2[1]?></td><td></td><td></td><td></td></tr>

<tr><td style="border-bottom:1px solid #cbcecb;border-left:1px solid #cbcecb;"><b>Email</b></td><td style="border-bottom:1px solid #cbcecb;border-right:1px solid #cbcecb;"><?php echo $resultPaymentInfo2[6];?></td><td></td><td></td><td></td></tr>
<tr height="10px"><td colspan="5" align="left">&nbsp;</td></tr>
</table>

<table width="950px" class="mystyle2" border="0">
<tr><td style="width:15%"><b>Payment Type</b></td><td><?php echo $resultPaymentInfo2[0];?></td><td></td><td></td><td></td></tr>
<tr><td style="width:15%"><b>Payment Info</b></td><td><?php echo $resultPaymentInfo2[3];?></td><td></td><td></td><td></td></tr>
<tr><td style="width:15%"><b>Remark</b></td><td><?php echo $resultPaymentInfo2[4];?></td><td></td><td></td><td></td></tr>
<!--<tr height="10px"><td colspan="5" align="left">&nbsp;</td></tr>-->
<!--<tr><td colspan="5" align="left"><u><b><?php //echo $rowQuotationInfo[2];?></b></u></td></tr>-->
<tr height="5px"><td colspan="5" align="left">&nbsp;</td></tr>
<!--<tr height="25"><td colspan="5" align="left"><div><?php //echo $rowQuotationInfo[14]; ?></div></td></tr>-->
<tr><td colspan="5" align="left"></td></tr>
</table>
<p></p>

<?php 
	if(mysqli_num_rows($resultPaymentDetail) > 0){
		echo "<table class='mystyle'>";
		echo "<thead><tr><th>Invoice No</th><th>Amount</th></tr></thead>";
		while($rowPaymentDetailInfo = mysqli_fetch_row($resultPaymentDetail)){
			echo "<tr height='25'>";			
				echo "<td style='width:50px'>".nl2br($rowPaymentDetailInfo[0])."</td>";			
				echo "<td style='width:620px'>".nl2br($rowPaymentDetailInfo[1])."</td>";
			echo "</tr>";
		}
		echo "<tr height='25'>";			
				echo "<td style='width:50px'>Total</td>";			
				echo "<td style='width:620px'>".$resultPaymentInfo2[5]."</td>";
			echo "</tr>";
		echo "</table>";
		
	}
?>
<table class="mystyle2">
<tr><td height="20">&nbsp;</td></tr>
<!--<tr><td colspan="5" align="left"><textarea style="border: none; font-family: Helvetica ; font-size: 16px;" cols="100" rows="8" name="quotationTerms" maxlength="1000"><?php echo $rowQuotationInfo[4]; ?></textarea></td></tr>-->
<td colspan="5" align="left"><div><?php echo $resultPaymentInfo2[4]; ?></div></td></tr>
<tr height="20"><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5"></td></tr>
<tr><td colspan="5" align="left"></td></tr>
<tr><td colspan="5" align="center">
<input type="hidden" name="customerID" value="<?php echo $customerID?>">
</table>
<br>

<table class="mystyle2">
<tr>
<td width="45%">Chop & Sign<br>
<?php echo $rowCompanyName[0];?>

</td>
<td width="10%"></td>
<td width="45%">We hereby confirmed & Accepted<br>
<?php echo $resultCustomerInfo2[0]?>

</td>
</tr>
<tr><td><div id="signature"></div></td><td></td><td><div id="signature"></div></td></tr>
<tr><td><?php //echo $rowQuotationInfo[3];?></td><td></td><td>Signed & Company's stamp</td></tr>
</table>

<p><input type="button" class="noPrint" onclick="JavaScript:window.print();return false;" value="Print Payment Voucher"></p>

</div>
</body>
</html>