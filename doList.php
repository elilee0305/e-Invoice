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

	if(isset($_GET['idDoDelete'])){
		$doID = $_GET['idDoDelete'];
		//delete DO detail
		$sqlDeleteDOdetail = "DELETE FROM tbdeliveryorderdetail WHERE deliveryOrderDetail_deliveryOrderID = '$doID'";
		$sqlDeleteDO = "DELETE FROM tbdeliveryorder WHERE deliveryOrder_id = '$doID'";
		
		mysqli_query($connection, $sqlDeleteDOdetail) or die("error in delete DO  detail query");
		mysqli_query($connection, $sqlDeleteDO) or die("error in delete DO query");		
	}	
	

	
	//delivery order list
	$sqlDOlist = "SELECT customer_id, customer_name, deliveryOrder_id, deliveryOrder_no, deliveryOrder_date, deliveryOrder_title 
	FROM tbcustomer, tbdeliveryorder WHERE (customer_id = deliveryOrder_customerID) ORDER BY deliveryOrder_date ASC, deliveryOrder_id ASC";
	
	$resultDOlist = mysqli_query($connection, $sqlDOlist) or die("error in DO list query");
?>
<html>
<head>
<title>Online Payroll System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<style type="text/css">
table.mystyle
{
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
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
	background-color: #AFCCB0;
}
</style>
<script>
	function CheckAndDelete(){
		var r = confirm("Do you want to DELETE this DO?");
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
<table width="800" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>


<table width="50%" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><b><font size="5" color="046607">Delivery Order List</font></b></td><td width="350"></td></tr></table>
<table width="700" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultDOlist) > 0){
		echo "<table width='900' cellpadding='0' border='0'><tr><td align='left'>".mysqli_num_rows($resultDOlist)."&nbsp;records</td><td align='right'>Date:&nbsp;".Date('d/m/Y')."</td></tr></table>";
		
		echo "<table width='900' cellpadding='0' border='1' class='mystyle'>";		
		echo "<tr><td style='width:100'><b>Delivery Order No</b></td><td style='width:100'><b>Date</b></td><td style='width:350'><b>Customer</b></td><td style='width:350'><b>Title</b></td><td style='width:50'><b>Edit</b></td><td style='width:50'><b>Print</b></td><td style='width:50'><b>Del</b></td></tr>";
		while($rowDOlist = mysqli_fetch_row($resultDOlist)){
			echo "<tr class='notfirst'>";			
			echo "<td>$rowDOlist[3]</td>";			
			echo "<td>".date("d/m/Y",strtotime($rowDOlist[4]))."</td>";
			echo "<td>$rowDOlist[1]</td>";	
			
			$strPositionText = $rowDOlist[5];
			if(strlen($strPositionText) > 30){
			$strPositionText = substr($strPositionText, 0, 30).'...';
				echo "<td>$strPositionText</td>";
			}else{
				echo "<td>$strPositionText</td>";
			}
			echo "<td><a href='editDO.php?idDeliveryOrder=$rowDOlist[2]&idCustomer=$rowDOlist[0]'>edit</a></td>";			
			echo "<td align='center'><a href='printDO.php?idDeliveryOrder=$rowDOlist[2]&idCustomer=$rowDOlist[0]' target='blank'>print</a></td>";
			echo "<td><a href='doList.php?idDoDelete=$rowDOlist[2]' onclick=\"return CheckAndDelete()\">del</a></td>";
			echo "</tr>";			
		}		
		echo "</table>";
	}

?>








</center>
</body>

</html>
