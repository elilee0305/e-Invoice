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
	
	$purchaseBillCancel = 0;
	
	if(isset($_GET['idPurchaseBillDelete'])){
		$purchaseBillID = $_GET['idPurchaseBillDelete'];
		$customerID = $_GET['idCustomer'];
		$deleteType = $_GET['idDeleteType'];
		$accountID = $_GET['idAccount'];
		
		if($deleteType==1){
			//COMPLETE DELETE PURCHASE BILL
			$sqlDeletePurchaseBillVoid = "DELETE purchaseBill, purchaseBillDetail 
			FROM tbpurchasebill purchaseBill 
			JOIN tbpurchasebilldetail purchaseBillDetail 
			ON purchaseBill.purchaseBill_id = purchaseBillDetail.purchaseBillDetail_purchaseBillID 
			WHERE purchaseBill.purchaseBill_id = '$purchaseBillID '";		
		
		}elseif($deleteType==2){
			//VOID THE PURCHASE Bill
			$sqlDeletePurchaseBillVoid = "UPDATE tbpurchasebill SET purchaseBill_subTotal = 0.00, purchaseBill_taxTotal = 0.00, purchaseBill_grandTotal = 0.00, 
			purchaseBill_discountTotal = 0.00, purchaseBill_totalAfterDiscount = 0.00, purchaseBill_roundAmount = 0.00, purchaseBill_grandTotalRound = 0.00, 
			purchaseBill_roundStatus = 0, purchaseBill_purchaseOrderNo = '', purchaseBill_purchaseOrderID = 0, purchaseBill_paid = 0.00, 
			purchaseBill_status = 'c' WHERE purchaseBill_id = '$purchaseBillID'";
		}
		
		$sqlUpdatePurchaseOrder = "UPDATE tbpurchaseorder SET purchaseOrder_purchaseBillID = 0, purchaseOrder_purchaseBillNo = '' 
		WHERE purchaseOrder_purchaseBillID = '$purchaseBillID'";	
		
		//delete the customer account 
		$sqlDeleteCustomerAccount = "DELETE FROM tbcustomeraccount WHERE (customerAccount_customerID = '$customerID') AND 
		(customerAccount_documentTypeID = '$purchaseBillID') AND (customerAccount_documentType = 'PB')";
		
		// delete account payable, cash account together
		$sqlDeleteAccountPayableCash = "DELETE FROM tbaccount4 WHERE account4_account3ID IN (6, '$accountID') AND 
		(account4_documentType = 'INV') AND (account4_documentTypeID = '$invoiceID')";
		
		
		
		mysqli_query($connection, $sqlUpdatePurchaseOrder) or die("error in update PO query");		
		mysqli_query($connection, $sqlDeletePurchaseBillVoid) or die("error in delete or void purchase bill query");
		mysqli_query($connection, $sqlDeleteCustomerAccount) or die("error in delete customer account query");		
		mysqli_query($connection, $sqlDeleteAccountPayableCash) or die("error in delete AP & Cash query");		
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	}	
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$purchaseBillDate1Converted = convertMysqlDateFormat($_POST['purchaseBillDate1']);
		$purchaseBillDate2Converted = convertMysqlDateFormat($_POST['purchaseBillDate2']);
		$searchName = makeSafe($_POST['searchName']);
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);
		$searchTypeName = $searchType[1];	
		
		if(isset($_POST['chkPurchaseBillCancel'])){
			$purchaseBillCancel = 1;
		}
				
		$sqlPurchaseBillList3 = "AND (purchaseBill_date BETWEEN '$purchaseBillDate1Converted' AND '$purchaseBillDate2Converted') ";		
		
		if($searchType[0] == 1){
			//all					
		
			if($purchaseBillCancel == 1){
				//CANCEL VOID PURCHASE BILL
				$sqlPurchaseBillList2 = "AND (purchaseBill_status = 'c') ";
			}else{
				$sqlPurchaseBillList2 = "AND (purchaseBill_status = 'a') ";	
			}
		
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			if($purchaseBillCancel == 1){
				$sqlPurchaseBillList2 = "AND (purchaseBill_status = 'c')  AND (customer_name LIKE '$searchName') ";
			}else{
				$sqlPurchaseBillList2 = "AND (purchaseBill_status = 'a')  AND (customer_name LIKE '$searchName') ";
			}		
			
		}else{
			//purchase bill no
			
			if($purchaseBillCancel == 1){
				$sqlPurchaseBillList2 = "AND (purchaseBill_status = 'c') AND (purchaseBill_no = '$searchName') ";
			}else{
				$sqlPurchaseBillList2 = "AND (purchaseBill_status = 'a') AND (purchaseBill_no = '$searchName') ";
			}
			
			$sqlPurchaseBillList3 = "";	
		}	
		
		$sqlPurchaseBillList = "SELECT customer_id, customer_name, purchaseBill_id, purchaseBill_no, purchaseBill_date,  
		purchaseBill_grandTotalRound, purchaseBill_purchaseOrderNo, purchaseBill_paid, purchaseBill_account3ID, 
		SUM(purchaseBill_grandTotalRound - purchaseBill_paid) AS BalancePurchaseBill
		FROM tbcustomer, tbpurchasebill WHERE (customer_id = purchaseBill_customerID) ";
		
		$sqlPurchaseBillList = $sqlPurchaseBillList.$sqlPurchaseBillList2.$sqlPurchaseBillList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$purchaseBillDate1Converted = date("Y-m-01", strtotime($dt));
		$purchaseBillDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlPurchaseBillList = "SELECT customer_id, customer_name, purchaseBill_id, purchaseBill_no, purchaseBill_date, 
		purchaseBill_grandTotalRound, purchaseBill_purchaseOrderNo, purchaseBill_paid, purchaseBill_account3ID, 
		SUM(purchaseBill_grandTotalRound - purchaseBill_paid) AS BalancePurchaseBill 
		FROM tbcustomer, tbpurchasebill WHERE (customer_id = purchaseBill_customerID) ";
		
		$sqlPurchaseBillList3 = "AND (purchaseBill_status = 'a') AND (purchaseBill_date BETWEEN '$purchaseBillDate1Converted' AND '$purchaseBillDate2Converted') ";
		
		$sqlPurchaseBillList = $sqlPurchaseBillList.$sqlPurchaseBillList3;
	}	
	
	$sqlPurchaseOrderList4 = "GROUP BY customer_id, customer_name, purchaseBill_id, purchaseBill_no, purchaseBill_date,  
	purchaseBill_grandTotalRound, purchaseBill_purchaseOrderNo, purchaseBill_paid ORDER BY purchaseBill_date DESC, purchaseBill_id DESC";
	
	$sqlPurchaseBillList = $sqlPurchaseBillList.$sqlPurchaseOrderList4;
	
	$resultPurchaseBillList = mysqli_query($connection, $sqlPurchaseBillList) or die("error in purchase bill list query");
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
	function CheckAndDelete(x,t,a){
		var idPurchaseBillDeleteValue = x;
		var idCustomerDeleteValue = t;
		var idAccountDeleteValue = a;
		
		var data = "purchaseBillID="+idPurchaseBillDeleteValue;
		
		$.ajax({
			type : 'POST',
			url : 'checkPurchaseBillPayment.php',
			data : data,
			dataType : 'json',
			success : function(r)
			{
				ResubmitForm(r, idPurchaseBillDeleteValue, idCustomerDeleteValue, idAccountDeleteValue);
			}
		})
		return false;
	}
	
	function ResubmitForm(g,y,z,a){
		if(g==0){					
			
			var t = confirm("Do you want to DELETE this Purchase Bill?");
			if(t==true){
				var idLink = y;
				var idLink2 = z;
				var idLink3 = a;
				//COMPLETE DELETE
				window.location = "purchaseBillList.php?idPurchaseBillDelete=" + idLink + "&idCustomer=" + idLink2 + "&idDeleteType=1" + "&idAccount=" + idLink3;
			}	
		
		}else if(g==1){
			alert("This Purchase Bill No has Active Payment Voucher! Cancel Payment Voucher first");
			return false;
		}else if(g==2){
			//cancel payment voucher availabe, so VOID the Purchase Bill
			var f = confirm("Do you want to VOID this Purchase Bill?");
			if(f==true){
				var idLink = y;
				var idLink2 = z;
				var idLink3 = a;
				//VOID delete
				window.location = "purchaseBillList.php?idPurchaseBillDelete=" + idLink + "&idCustomer=" + idLink2 + "&idDeleteType=2" + "&idAccount=" + idLink3;
			}
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
    <a href="createPurchaseBill.php">Create Purchase Bill</a>
    
  </nav>
</main2>


<table width="950" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Purchase Bill List</h1></td><td width="350"></td></tr></table>
<table width="950" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="purchaseBillList.php" id="purchaseBillList.phpForm" method="post">
<table border="0" cellpadding="0" width="950">
<tr height="15">

<td><select name="searchType" id="searchType" size="1">
<?php if(isset($_POST['Submit'])){echo "<option value=".$searchTypeValue.">".$searchTypeName."</option>";}?>
<option value="1|All">All</option>
<option value="2|Customer Name">Customer Name</option>
<option value="3|Purchase Order No">Purchase Bill No</option>
</select>

</td>
<td><input type="text" name="searchName" size="18" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<input id="demo1" type="text" name="purchaseBillDate1" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['purchaseBillDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
	}?>">&nbsp;&nbsp;&nbsp;TO&nbsp;

</td>
<td>

<input id="demo2" type="text" name="purchaseBillDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['purchaseBillDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;

</td>
<td><input type="submit" name="Submit" value="Search Purchase Bill">&nbsp;&nbsp;
<input type="checkbox" name="chkPurchaseBillCancel" value="1" <?php if($purchaseBillCancel == 1){echo "checked";}?>><img src="images/deletemark.jpg" width="16"" height="16"> 
</td></tr>
</table>
<?php 
	if(mysqli_num_rows($resultPurchaseBillList) > 0){
		echo "<table width='1050' height='25' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultPurchaseBillList)."&nbsp;records</td><td align='right'></td></tr></table>";
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1050' cellpadding='0' border='1' class='mystyle'>";		
		//echo "<tr><td style='width:100'><b>Purchase Bill No</b></td><td style='width:100'><b>Date</b></td><td style='width:100'><b>PO</b></td><td style='width:420'><b>Customer</b></td><td style='width:150'><b>Total</b></td><td style='width:70'><b>Paid</b></td><td style='width:100'><b>Balance</b></td><td style='width:50'><b>Edit</b></td><td style='width:50'><b>Del</b></td><td style='width:100'><b>Pay</b></td></tr>";
		
		
		
		
		echo "<thead><tr>";
		echo "<td style='width:120'><p style=\"font-size:12px\"><b>PB No</b></p></td>";
		echo "<td style='width:105'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:105'><p style=\"font-size:12px\"><b>PO</b></p></td>";
		echo "<td style='width:420'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Total</b></p></td>";
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Paid</b></p></td>";
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Bal</b></p></td>";
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "<td style='width:40'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Pay</b></p></td>";			
		echo "</tr></thead>";
		
		
		
		
		
		
		
		
		
		while($rowPurchaseBillList = mysqli_fetch_row($resultPurchaseBillList)){
			if(date('Y-m-d')==$rowPurchaseBillList[4]){
				echo "<tr bgcolor='e1f7e7' height='30' class='notfirst'>";
			}else{	
				echo "<tr height='30' class='notfirst'>";
			}				
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowPurchaseBillList[3]</p></td>";			
			echo "<td style='width:100'><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowPurchaseBillList[4]))."</p></td>";
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowPurchaseBillList[6]</p></td>";	
			echo "<td style='width:450'><p style=\"font-size:12px\">$rowPurchaseBillList[1]</p></td>";	
			//$strPositionText = $rowPurchaseBillList[5];
			/* if(strlen($strPositionText) > 30){
			$strPositionText = substr($strPositionText, 0, 30).'...';
				echo "<td><p style=\"font-size:12px\">$strPositionText</p></td>";
			}else{
				echo "<td><p style=\"font-size:12px\">$strPositionText</p></td>";
			} */
			echo "<td style='width:50' align='right'><p style=\"font-size:12px\">$rowPurchaseBillList[5]</p></td>";
			echo "<td style='width:50' align='right'><p style=\"font-size:12px\">$rowPurchaseBillList[7]</p></td>";
			echo "<td style='width:50' align='right'><p style=\"font-size:12px\">$rowPurchaseBillList[9]</p></td>";
			
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='editPurchaseBill.php?idPurchaseBill=$rowPurchaseBillList[2]&idCustomer=$rowPurchaseBillList[0]'>edit</a></p></td>";			
			//echo "<td align='center'><p style=\"font-size:12px\"><a href='printPurchaseOrder.php?idPurchaseBill=$rowPurchaseBillList[2]&idCustomer=$rowPurchaseBillList[0]' target='blank'>print</a></p></td>";
			
			//echo "<td><p style=\"font-size:12px\"><a href='purchaseBillList.php?idPurchaseBillDelete=$rowPurchaseBillList[2]' onclick=\"return CheckAndDelete()\">del</a></p></td>";
			
			
			$idPurchaseBillDeleteValue = $rowPurchaseBillList[2];
			$idCustomerDeleteValue = $rowPurchaseBillList[0];
			$idAccountDeleteValue = $rowPurchaseBillList[8];
			
			$idName = "delete".$idPurchaseBillDeleteValue;
			if($purchaseBillCancel == 1){
				echo "<td style='width:35'></td><td style='width:100'></td>";
				
			}else{
				echo "<td style='width:35'><p style=\"font-size:12px\"><a href='' id=$idName onclick=\"return CheckAndDelete($idPurchaseBillDeleteValue, $idCustomerDeleteValue, $idAccountDeleteValue)\">del</a></p></td>";
				echo "<td style='width:35'><p style=\"font-size:12px\"><a href='createPaymentVoucher.php?idCustomer=$rowPurchaseBillList[0]'>pay</a></p></td>";
			}
			
			echo "</tr>";			
		}		
		echo "</table>";
	}else{
		
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:120'><p style=\"font-size:12px\"><b>PB No</b></p></td>";
		echo "<td style='width:105'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:105'><p style=\"font-size:12px\"><b>PO</b></p></td>";
		echo "<td style='width:420'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Total</b></p></td>";
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Paid</b></p></td>";
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Bal</b></p></td>";
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "<td style='width:40'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Pay</b></p></td>";			
		echo "</tr></thead>";
		echo "</table>";
		
		
	}
?>
</center>
</form>
</body>
</html>
