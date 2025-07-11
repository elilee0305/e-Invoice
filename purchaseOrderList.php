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
	if(isset($_GET['idPurchaseOrderDelete'])){
		$purchaseOrderID = $_GET['idPurchaseOrderDelete'];
		//delete quotation detail		
		
		$sqlDeletePurchaseOrder = "DELETE purchaseOrder, purchaseOrderDetail 
		FROM tbpurchaseorder purchaseOrder 
		JOIN tbpurchaseorderdetail purchaseOrderDetail 
		ON purchaseOrder.purchaseOrder_id = purchaseOrderDetail.purchaseOrderDetail_purchaseOrderID 
		WHERE purchaseOrder.purchaseOrder_id = '$purchaseOrderID '";

		$sqlUpdatePurchaseBill = "UPDATE tbpurchasebill SET purchaseBill_purchaseOrderID = 0, purchaseBill_purchaseOrderNo = '' 
		WHERE purchaseBill_purchaseOrderID = '$purchaseOrderID'";	
		
		mysqli_query($connection, $sqlDeletePurchaseOrder) or die("error in delete purchase order query");		
		mysqli_query($connection, $sqlUpdatePurchaseBill) or die("error in update purchase bill query");		
	}	
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$purchaseOrderDate1Converted = convertMysqlDateFormat($_POST['purchaseOrderDate1']);
		$purchaseOrderDate2Converted = convertMysqlDateFormat($_POST['purchaseOrderDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);
		
		$searchTypeName = $searchType[1];	
		
				
		$sqlPurchaseOrderList3 = "AND (purchaseOrder_date BETWEEN '$purchaseOrderDate1Converted' AND '$purchaseOrderDate2Converted') ";		
		
		if($searchType[0] == 1){
			//all
			$sqlPurchaseOrderList2 = "";			
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			$sqlPurchaseOrderList2 = "AND (customer_name LIKE '$searchName') "; 
		}else{
			//quotation no
			$sqlPurchaseOrderList2 = "AND (purchaseOrder_no = '$searchName') ";
			$sqlPurchaseOrderList3 = "";	
		}	
		
		$sqlPurchaseOrderList = "SELECT customer_id, customer_name, purchaseOrder_id, purchaseOrder_no, purchaseOrder_date, purchaseOrder_title, 
		purchaseOrder_grandTotalRound, purchaseOrder_purchaseBillNo 
		FROM tbcustomer, tbpurchaseorder WHERE (customer_id = purchaseOrder_customerID) ";
		
		$sqlPurchaseOrderList = $sqlPurchaseOrderList.$sqlPurchaseOrderList2.$sqlPurchaseOrderList3;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$purchaseOrderDate1Converted = date("Y-m-01", strtotime($dt));
		$purchaseOrderDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlPurchaseOrderList = "SELECT customer_id, customer_name, purchaseOrder_id, purchaseOrder_no, purchaseOrder_date, purchaseOrder_title, 
		purchaseOrder_grandTotalRound, purchaseOrder_purchaseBillNo 
		FROM tbcustomer, tbpurchaseorder WHERE (customer_id = purchaseOrder_customerID) ";
		
		$sqlPurchaseOrderList3 = "AND (purchaseOrder_date BETWEEN '$purchaseOrderDate1Converted' AND '$purchaseOrderDate2Converted') ";
		
		$sqlPurchaseOrderList = $sqlPurchaseOrderList.$sqlPurchaseOrderList3;
	
	}	
	
	$sqlPurchaseOrderList4 = "ORDER BY purchaseOrder_date DESC, purchaseOrder_id DESC";
	
	$sqlPurchaseOrderList = $sqlPurchaseOrderList.$sqlPurchaseOrderList4;
	
	//quotation list	
	$resultPurchaseOrderList = mysqli_query($connection, $sqlPurchaseOrderList) or die("error in quotation list query");
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

main2 {
    margin-bottom: 100%;
  }

  .floating-menu {
    font-family: sans-serif;
    background: yellowgreen;
    padding: 5px;;
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







.notfirst:hover
{
	background-color: #E1ECEE;
}
</style>
<script>
	function CheckAndDelete(){
		var r = confirm("Do you want to DELETE this Purchase Order?");
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
    <a href="createPurchaseOrder.php">Create PO</a>
    
  </nav>
</main2>



<table width="1000" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Purchase Order List</h1></td><td width="350"></td></tr></table>
<table width="1000" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<form action="purchaseOrderList.php" id="purchaseOrderList.phpForm" method="post">
<table border="0" cellpadding="0" width="1000">
<tr height="15">

<td><select name="searchType" id="searchType" size="1">
<?php if(isset($_POST['Submit'])){echo "<option value=".$searchTypeValue.">".$searchTypeName."</option>";}?>
<option value="1|All">All</option>
<option value="2|Customer Name">Customer Name</option>
<option value="3|Purchase Order No">Purchase Order No</option>
</select>


</td>
<td><input type="text" name="searchName" size="18" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<input id="demo1" type="text" name="purchaseOrderDate1" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['purchaseOrderDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;&nbsp;&nbsp;TO&nbsp;


</td>
<td>

<input id="demo2" type="text" name="purchaseOrderDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['purchaseOrderDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;


</td>
<td><input type="submit" name="Submit" value="Search Purchase Order"></td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultPurchaseOrderList) > 0){
		echo "<table width='1100' height='25' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultPurchaseOrderList)."&nbsp;records</td><td align='right'></td></tr></table>";
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";		
		
		echo "<thead><tr>";
		echo "<td style='width:105'><p style=\"font-size:12px\"><b>PO No</b></p></td>";
		echo "<td style='width:95'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:330'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:95'><p style=\"font-size:12px\"><b>Bill</b></p></td>";
		echo "<td style='width:290'><p style=\"font-size:12px\"><b>Title</b></p></td>";
		echo "<td style='width:50'><p style=\"font-size:12px\"><b>Total</b></p></td>";			
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "<td style='width:40'><p style=\"font-size:12px\"><b>Print</b></p></td>";			
		echo "<td style='width:65'><p style=\"font-size:12px\"><b>Del</b></p></td>";			
		echo "</tr></thead>";
		
		while($rowPurchaseOrderList = mysqli_fetch_row($resultPurchaseOrderList)){
			if(date('Y-m-d')==$rowPurchaseOrderList[4]){
				echo "<tr bgcolor='e1f7e7' height='30' class='notfirst'>";
			}else{	
				echo "<tr height='30' class='notfirst'>";
			}				
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowPurchaseOrderList[3]</p></td>";			
			echo "<td style='width:100'><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowPurchaseOrderList[4]))."</p></td>";
			echo "<td style='width:400'><p style=\"font-size:12px\">$rowPurchaseOrderList[1]</p></td>";
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowPurchaseOrderList[7]</p></td>";	
				
			
			$strPositionText = $rowPurchaseOrderList[5];
			if(strlen($strPositionText) > 30){
			$strPositionText = substr($strPositionText, 0, 30).'...';
				echo "<td style='width:350'><p style=\"font-size:12px\">$strPositionText</p></td>";
			}else{
				echo "<td style='width:350'><p style=\"font-size:12px\">$strPositionText</p></td>";
			}
			echo "<td style='width:70' align='right'><p style=\"font-size:12px\">$rowPurchaseOrderList[6]</p></td>";
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='editPurchaseOrder.php?idPurchaseOrder=$rowPurchaseOrderList[2]&idCustomer=$rowPurchaseOrderList[0]'>edit</a></p></td>";			
			echo "<td style='width:50' align='center'><p style=\"font-size:12px\"><a href='printPurchaseOrder.php?idPurchaseOrder=$rowPurchaseOrderList[2]&idCustomer=$rowPurchaseOrderList[0]' target='_blank'>print</a></p></td>";
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='purchaseOrderList.php?idPurchaseOrderDelete=$rowPurchaseOrderList[2]' onclick=\"return CheckAndDelete()\">del</a></p></td>";
			echo "</tr>";			
		}		
		echo "</table>";
	}else{
		
		echo "<table width=\"1100\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table width='1100' cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:105'><p style=\"font-size:12px\"><b>PO No</b></p></td>";
		echo "<td style='width:95'><p style=\"font-size:12px\"><b>Date</b></p></td>";
		echo "<td style='width:330'><p style=\"font-size:12px\"><b>Customer</b></p></td>";
		echo "<td style='width:95'><p style=\"font-size:12px\"><b>Bill</b></p></td>";
		
		echo "<td style='width:290'><p style=\"font-size:12px\"><b>Title</b></p></td>";
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
