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
	
	$paymentVoucherCancel = 0;
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$paymentDate1Converted = convertMysqlDateFormat($_POST['paymentVoucherDate1']);
		$paymentDate2Converted = convertMysqlDateFormat($_POST['paymentVoucherDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);		
		$searchTypeNameValue = $searchType[0]."|".$searchType[1];
		$searchTypeName = $searchType[1];

		$paymentMethodValue = $_POST['paymentMethod'];
		$paymentMethod = explode('|',$paymentMethodValue);		
		$paymentMethodNameValue = $paymentMethod[0]."|".$paymentMethod[1];
		$paymentMethodName = $paymentMethod[1];
		
		if(isset($_POST['chkPaymentVoucherCancel'])){
			$paymentVoucherCancel = 1;
		}
		
		if($searchType[0] == 1){
			//all
			$sqlPaymentVoucherList2 = "";						
			if($paymentVoucherCancel == 1){
				$sqlPaymentVoucherList3 = "AND (paymentVoucher_status = 0) AND (paymentVoucher_date BETWEEN '$paymentDate1Converted' AND '$paymentDate2Converted') ";
			}else{
				$sqlPaymentVoucherList3 = "AND (paymentVoucher_status <> 0) AND (paymentVoucher_date BETWEEN '$paymentDate1Converted' AND '$paymentDate2Converted') ";	
			}
			
			if($paymentMethod[0]==0){
				$sqlPaymentVoucherList4 = "";
			}else{
				$sqlPaymentVoucherList4 = "AND (paymentVoucher_paymentMethodID = '$paymentMethod[0]') ";
			}
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			
			if($paymentVoucherCancel == 1){
				$sqlPaymentVoucherList2 = "AND (paymentVoucher_status = 0) AND (customer_name LIKE '$searchName') ";
			}else{
				$sqlPaymentVoucherList2 = "AND (paymentVoucher_status <> 0) AND (customer_name LIKE '$searchName') ";
			}
			
			$sqlPaymentVoucherList3 = "AND (paymentVoucher_date BETWEEN '$paymentDate1Converted' AND '$paymentDate2Converted') ";
			if($paymentMethod[0]==0){
				$sqlPaymentVoucherList4 = "";
			}else{
				$sqlPaymentVoucherList4 = "AND (paymentVoucher_paymentMethodID = '$paymentMethod[0]') ";
			}
			
		}else{
			//payment no
			if($paymentVoucherCancel == 1){
				$sqlPaymentVoucherList2 = "AND (paymentVoucher_status = 0) AND (paymentVoucher_no = '$searchName') ";
			}else{
				$sqlPaymentVoucherList2 = "AND (paymentVoucher_status <> 0) AND (paymentVoucher_no = '$searchName') ";
			}
			$sqlPaymentVoucherList3 = "";
			$sqlPaymentVoucherList4 = "";
		}	
		
		$sqlPaymentVoucherList = "SELECT customer_id, customer_name, paymentVoucher_id, paymentVoucher_no, paymentVoucher_date, paymentVoucher_grandTotalRound, paymentVoucher_type, paymentVoucher_accountID, paymentVoucher_account3ID  
		FROM tbcustomer, tbpaymentvoucher WHERE (customer_id = paymentVoucher_customerID) ";
		
		$sqlPaymentVoucherList = $sqlPaymentVoucherList.$sqlPaymentVoucherList2.$sqlPaymentVoucherList3.$sqlPaymentVoucherList4;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$paymentDate1Converted = date("Y-m-01", strtotime($dt));
		$paymentDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlPaymentVoucherList = "SELECT customer_id, customer_name, paymentVoucher_id, paymentVoucher_no, paymentVoucher_date, paymentVoucher_grandTotalRound, paymentVoucher_type, paymentVoucher_accountID, paymentVoucher_account3ID
		FROM tbcustomer, tbpaymentvoucher WHERE (customer_id = paymentVoucher_customerID) ";
		
		$sqlPaymentVoucherList3 = "AND (paymentVoucher_status <> 0) AND (paymentVoucher_date BETWEEN '$paymentDate1Converted' AND '$paymentDate2Converted') ";
		
		$sqlPaymentVoucherList = $sqlPaymentVoucherList.$sqlPaymentVoucherList3;
	}	
	
	$sqlPaymentVoucherList5 = "ORDER BY paymentVoucher_date DESC, paymentVoucher_id DESC";	
	$sqlPaymentVoucherList = $sqlPaymentVoucherList.$sqlPaymentVoucherList5;
	
	//payment voucher list	
	$resultPaymentVoucherList = mysqli_query($connection, $sqlPaymentVoucherList) or die("error in payment voucher list query");
	
	//payment method
	$sqlPaymentMode = "SELECT paymentMethod_id, paymentMethod_name FROM tbpaymentmethod ORDER BY paymentMethod_id ASC";
	$resultPaymentMode = mysqli_query($connection, $sqlPaymentMode) or die("error in payment method query");
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
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
		$( "#demo1" ).datepicker({ dateFormat: "dd/mm/yy"});
	
	} );	
</script>

<style type="text/css">
table.mystyle
{
	overflow: scroll;
	display: block;
	width: 820px;
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
  top: 176;
  background-color: transperant;
  width: 820px;
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

.float-container{
    display: flex;
}
.float-child{
    width: 880px;
	margin-left: 50px;
}
.float-child2{
    flex-grow: 1;
}

table.mystyle2
{
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 12px; /* Added font-size */
}
.mystyle2 td, mystyle2 th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0
	border-style: solid;
	border-color: #CDD0D1;
}
</style>
<script>
	function getButtonID(clickedID){
		//alert(clickedID);
		document.getElementById("buttonClicked").value = clickedID;
	}
	
	function CheckAndSubmit(){
		var clickedButton = document.getElementById("buttonClicked").value;
		//only submit form for SEARCH button click
		if(clickedButton=='cAN'){
			var t = confirm("Do you want to Cancel this Voucher?");
			if(t==true){
				ProcessPaymentVoucherCancel();
			}
			return false;
		}else if(clickedButton=='pRT') {
			var idPaymentVoucherPrint = document.getElementById("idPaymentVoucherStore").value;
			var voucherTypeValue = document.getElementById("voucherType").value;
			var idCustomerPrint = document.getElementById("idCustomerStore").value;
			
			
			if(voucherTypeValue == 'p') {
				var url = 'printPaymentVoucher.php?idCustomer=' + idCustomerPrint + '&idPaymentVoucher=' + idPaymentVoucherPrint;
			}else{
				var url = 'printPaymentVoucherSeparate.php?idCustomer=' + idCustomerPrint + '&idPaymentVoucher=' + idPaymentVoucherPrint;
				
			}
			
			
			window.open(url, '_blank');
			
			
			
			
			
			return false;			
		}	
	}

	function ProcessPaymentVoucherCancel(){		
		
		var aPurchaseBillIDcancel = JSON.parse(localStorage.getItem("PurchaseBillIDstorage"));		
		var idPaymentVoucherCancel = document.getElementById("idPaymentVoucherStore").value;
		var voucherTypeValue = document.getElementById("voucherType").value;
		var idCustomerPrint = document.getElementById("idCustomerStore").value;
		
		$.ajax({
			type : 'POST',
			url : 'paymentVoucherCancelProcess.php',
			data : {paymentVoucherID: idPaymentVoucherCancel, paymentVoucherType: voucherTypeValue, idCustomer: idCustomerPrint, purchaseBillID: JSON.stringify(aPurchaseBillIDcancel)},
			dataType : 'json',
			success : function(w)
			{
				if(w=="1"){					
					localStorage.clear();
					//remove all existing tbody tr rows
					$("#myTable").find("tbody tr").remove();
					//disable the Print & Cancel buttons
					document.getElementById("pRT").disabled = true;
					document.getElementById("cAN").disabled = true;
					
					//delete the row
					var rowID = "row"+idPaymentVoucherCancel;
					var row = document.getElementById(rowID);
					row.parentNode.removeChild(row);
					
					//number of records 
					
					var originalNoOfRecords = document.getElementById("noOfRecordID").value;
					var newNoOfRecords = originalNoOfRecords - 1;
					var newNoOfRecordsText = newNoOfRecords+"&nbsp;records";				
					document.getElementById("noOfRecordID").value = newNoOfRecords;
					
					 $("#noOfRecordSpan").html(newNoOfRecordsText);
					 document.getElementById("spanPaymentVoucherAmount").innerHTML = "";
					
				}else if(w=="0"){
					alert("Error in Processing Payment Voucher Cancel");
				}
			}
			
		})
	}

	function ShowPaymentVoucherDetail(x,y,z,g,t,n){
		var idPaymentVoucher = x;
		var idCustomer = t;
		
		document.getElementById("customerPaymentName").innerHTML = y;
		document.getElementById("customerPaymentNo").innerHTML = z;
		document.getElementById("spanPaymentVoucherAmount").innerHTML = g;
		var data = "paymentVoucherID="+idPaymentVoucher;
		//alert(data);
		document.getElementById("idPaymentVoucherStore").value = idPaymentVoucher;
		document.getElementById("idCustomerStore").value = t;
		document.getElementById("voucherType").value = n;
		
		$.ajax({
			type : 'POST',
			url : 'getPaymentVoucherDetail.php',
			data : data,
			dataType : 'json',
			success : function(r)
			{
				var js_array = r;
				//remove all existing tbody tr rows
				$("#myTable").find("tbody tr").remove();
				
				//enable the Print & Cancel buttons if the payment not cancel
				var idPaymentCancelValue = document.getElementById("idPaymentVoucherCancelStore").value
				if(idPaymentCancelValue == 1){
					//nothing, leave both disabled
				}else{
					document.getElementById("pRT").disabled = false;
					document.getElementById("cAN").disabled = false;
				}
				
				
				
				//get a reference to the table tbody
				var tbodyRef = document.getElementById('myTable').getElementsByTagName('tbody')[0];
				
				//declare an empty array to store invoice id
				const aInvoiceID = [];
				
				for(var y = 0; y < js_array.length; y++){
					var invoiceNo = js_array[y][0];
					var invoiceAmount = js_array[y][1];					
					//aInvoiceID[y] = js_array[y][2]; //SINGLE VALUES ASSIGN
					//PUSH FUNCTION to assign multiple values to array
					aInvoiceID.push([js_array[y][2], js_array[y][1]]);	
					
					// Insert a row at the end of table
					var newRow = tbodyRef.insertRow();
					
					// Insert a cell at the end of the row
					var newCell = newRow.insertCell(0);
					var newCell2 = newRow.insertCell(1);
					
					newCell.innerHTML = invoiceNo;
					newCell2.innerHTML = invoiceAmount;
				}				
				
				//store the invoice id array inside local storage after making it into string 
				localStorage.setItem("PurchaseBillIDstorage", JSON.stringify(aInvoiceID));
			
			}
		}
		)
		return false;
	}
	
</script>
</head>
<body>
<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
<form action="paymentVoucherList.php" id="paymentVoucherListForm" method="post" onsubmit="return CheckAndSubmit()">
<div class="float-container">
	<div class="float-child">
		
<table width="790" border="0" cellpadding="0"><tr height="50"><td>&nbsp;</td></tr></table>
<table width="790" border="0" cellpadding="0"><tr height="40"><td align="left" width="350"><h1>Payment Voucher List</h1></td><td width="350"></td></tr></table>
<table width="790" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<table border="0" cellpadding="0" width="790">
<tr height="20">

<td><select name="searchType" id="searchType" size="1">
<?php if(isset($_POST['Submit'])){echo "<option value=\"$searchTypeNameValue\">$searchTypeName</option>";}?>
<option value="1|All">All</option>
<option value="2|Customer Name">Customer Name</option>
<option value="3|Voucher No">Voucher No</option>
</select>

</td>
<td><input type="text" name="searchName" size="15" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<?php 
	echo "<select name='paymentMethod' id='paymentMethod'>";
	if(isset($_POST['Submit'])){echo "<option value=\"$paymentMethodNameValue\">$paymentMethodName</option>";}
	echo "<option value=\"0|All\">All</option>";
	if(mysqli_num_rows($resultPaymentMode) > 0){		
		
		while($rowPaymentMethod=mysqli_fetch_array($resultPaymentMode)){
			$valueText = $rowPaymentMethod[0]."|".$rowPaymentMethod[1];
			echo"<option value=\"$valueText\">$rowPaymentMethod[1]</option>";
		}
	}
	echo "</select>&nbsp;";
?>
</td>
	
<td>
<input id="demo1" type="text" name="paymentVoucherDate1" size="7" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['paymentVoucherDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;&nbsp;TO

</td>
<td>
<input id="demo2" type="text" name="paymentVoucherDate2" size="7" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['paymentVoucherDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;


</td>
<td><input id="sEARCH" type="submit" name="Submit" value="Search" onclick="getButtonID(this.id)">&nbsp;&nbsp;
<input type="checkbox" name="chkPaymentVoucherCancel" value="1" <?php if($paymentVoucherCancel == 1){echo "checked";}?>>
<img src="images/deletemark.jpg" width="16"" height="16">
</td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultPaymentVoucherList) > 0){
		echo "<table width='790' cellpadding='0' border='0'><tr><td align='left'><span id='noOfRecordSpan'>".mysqli_num_rows($resultPaymentVoucherList)."&nbsp;records</span></td><td align='right'></td></tr></table>";
		echo "<table width=\"790\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;";
		//to change the number records balance after cancel
		$noOfRecordValue = mysqli_num_rows($resultPaymentVoucherList);
		echo "<input type='hidden' id='noOfRecordID' value='$noOfRecordValue'></td></tr></table>";
			
		echo "<table cellpadding='0' border='1' class='mystyle'>";		
		echo "<thead><tr><td style='width:95'><p style=\"font-size:12px\"><b>Voucher No</b></p></td><td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td><td style='width:425'><p style=\"font-size:12px\"><b>Customer</b></p></td><td style='width:90'><p style=\"font-size:12px\"><b>Amount</b></p></td><td style='width:60'><p style=\"font-size:12px\"><b>View</b></p></td><td style='width:30'><p style=\"font-size:12px\"><b>E</b></p></td></tr></thead>";
		while($rowPaymentVoucherList = mysqli_fetch_row($resultPaymentVoucherList)){
			$idPaymentVoucher = $rowPaymentVoucherList[2];
			$idRowIDname = "row".$rowPaymentVoucherList[2];
			$paymentNo = $rowPaymentVoucherList[3];
			$customerName = $rowPaymentVoucherList[1];
			$customerID = $rowPaymentVoucherList[0];
			$paymentVoucherAmount = $rowPaymentVoucherList[5];
			$paymentVoucherType = $rowPaymentVoucherList[6];
			
			//get the accounts id
			$accountID = $rowPaymentVoucherList[7];
			$account3ID = $rowPaymentVoucherList[8];
			
			if(date('Y-m-d')==$rowPaymentVoucherList[4]){
				echo "<tr bgcolor='e1f7e7' id=$idRowIDname height='30' class='notfirst'>";
			}else{	
				echo "<tr id=$idRowIDname height='30' class='notfirst'>";
			}
			
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowPaymentVoucherList[3]</p></td>";			
			echo "<td style='width:100'><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowPaymentVoucherList[4]))."</p></td>";
			echo "<td style='width:470'><p style=\"font-size:12px\">$rowPaymentVoucherList[1]</p></td>";
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowPaymentVoucherList[5]</p></td>";	
			
			//RETURN VERY IMPORTANT TO PREVENT FORM FROM SUBMITTING
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='' onclick=\" return ShowPaymentVoucherDetail($idPaymentVoucher, '$customerName', '$paymentNo', $paymentVoucherAmount, $customerID, '$paymentVoucherType')\">view</a></p></td>";

			
			
			if($rowPaymentVoucherList[6]=='s'){
				echo "<td style='width:30'><p style=\"font-size:12px\"><a href='editPaymentVoucherSeparate.php?idPaymentVoucher=$idPaymentVoucher&idCustomer=$customerID'>E</a></p></td>";
			}else{
				echo "<td style='width:30'><p style=\"font-size:12px\"></td>";
			}
			
			
			echo "</tr>";			
		
		
		}		
		echo "</table>";
	}else{
		echo "<table width=\"790\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table cellpadding='0' border='1' class='mystyle'>";		
		echo "<thead><tr><td style='width:95'><p style=\"font-size:12px\"><b>Payment No</b></p></td><td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td><td style='width:425'><p style=\"font-size:12px\"><b>Customer</b></p></td><td style='width:90'><p style=\"font-size:12px\"><b>Amount</b></p></td><td style='width:60'><p style=\"font-size:12px\"><b>View</b></p></td><td style='width:30'><p style=\"font-size:12px\"><b>E</b></p></td></tr></thead>";
		echo "</table>";
	}
?>
	</div>
	<div class="float-child2">		
		
		<table width="350" border="0" cellpadding="0">
		<tr height="172" valign="bottom"><td>
		<span id="customerPaymentName"></span>
		<br>
		<span id="customerPaymentNo"></span>
		</td></tr>
		
		</table>	

		<div id="temporaryTable">
		
		<table width="200" id="myTable" cellpadding='0' border='1' class='mystyle2'>
			<thead>
				<tr bgcolor="#dfebd8">
					<th>Bill No</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
				<!--<td></td><td></td>-->
			</tbody>
			<tfoot>
				<tr bgcolor="#dfebd8">
					<th>Total</th>
					<td><span id="spanPaymentVoucherAmount"><span></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type='hidden' id='buttonClicked' value=''>
						<input type='hidden' id='idPaymentVoucherStore' value=''>
						<input type='hidden' id='idCustomerStore' value=''>
						<input type='hidden' id='voucherType' value=''>
						<input type='hidden' id='idPaymentVoucherCancelStore' value='<?php echo $paymentVoucherCancel;?>'>
						<input id="pRT" type="submit" name="Submit" value="Print" disabled onclick="getButtonID(this.id)">&nbsp;&nbsp;
						<input id="cAN" type="submit" name="Submit" value="Cancel Voucher" disabled onclick="getButtonID(this.id)">
					</td>
					
				</tr>
			<tfoot>
		</table>
		
		</div>
		
	</div>
</div>
</form>
</body>
</html>
