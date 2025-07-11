<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	//get the company name
	$sqlCompanyName = "SELECT company_name FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$resultCompanyName2 = mysqli_fetch_row($resultCompanyName);	
	
	if(isset($_POST['Submit'])){		
		$searchName = $_POST['searchValue'];
		$searchName = '%'.$searchName.'%'; 
		$customerType = $_POST['customerType'];
		
		if($customerType == 0){
			if(trim($_POST['searchValue'])== ''){							
				$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel 
				FROM tbcustomer ORDER BY customer_name ASC";
			}else{
				$searchName = '%'.$searchName.'%'; 
				$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel
				FROM tbcustomer WHERE (customer_name LIKE '$searchName') ORDER BY customer_name";	
			}						
		}else{
			if(trim($_POST['searchValue'])== ''){
				$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel
				FROM tbcustomer WHERE (customer_type = '$customerType') ORDER BY customer_name ASC";		
			}else{
				$searchName = '%'.$searchName.'%'; 
				$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel 
				FROM tbcustomer WHERE (customer_name LIKE '$searchName') AND (customer_type = '$customerType') 
				ORDER BY customer_name ASC";				
			}			
		}		
	}else{
		$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel 
		FROM tbcustomer ORDER BY customer_name ASC";
	}
	$resultCustomerList = mysqli_query($connection, $sqlCustomerList);


	$dt = date('Y-m-d');

	
				
	

	




	
?>
<html>
<head>
<title>Invoicing Billing System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<style type="text/css">
table.mystyle
{
	overflow: scroll;
	display: block;
	width: 580;
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
  top: 154;
  background-color: transperant;
  width: 580;
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
    width: 570px;
	margin-left: 20px;
}
.float-child2{
    flex-grow: 1;
}

table.mystyle2
{
	overflow: scroll;
	display: block;
	width: 680;
	height: 350px;
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
}

.mystyle2 thead>tr {
  position: absolute;
  display: block;
  padding: 0;
  margin: 0;
  top: 154;
  background-color: transperant;
  width: 680;
  z-index: -1;
}




.mystyle2 td, mystyle2 th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0
	border-style: solid;
	border-color: #CDD0D1;
	font-size : 12px;
	
	
	
	
}

input:focus
{
	background-color: AFCCB0;
}

div.myborder
{
	border:1px solid #CFE2E8;
	padding:10px 10px; 
	background:#9cc1c7;
	width:315;
	height: 25;
	border-radius:10px;
}

textarea:focus
{
	background-color: AFCCB0;
}
select:focus
{
	background-color: AFCCB0;
}



</style>
<script>
	
	$( function() {
		$( "#demo1" ).datepicker({ dateFormat: "dd/mm/yy"});
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
	
	function check(it) {		
		tr = it.parentElement.parentElement;
		tr.style.backgroundColor = (it.checked) ? "FFCCCB" : "ffffff";
	}
	
	

	
	
	
	
	
	
	
	function getButtonID(clickedID){
		//alert(clickedID);
		document.getElementById("buttonClicked").value = clickedID;
	}
	
	function CheckAndSubmit(){
		var clickedButton = document.getElementById("buttonClicked").value;
		//only submit form for SEARCH button click
		if(clickedButton=='searchCustomer'){
			
					
			
			//return false;
		}else if(clickedButton=='searchAccount') {
			GetAccountInfo();
			return false;			
		}else if(clickedButton=='printAccount'){
			//print out in another table
			var idCustomer = document.getElementById("idCustomer").value;
			var dateStart = document.getElementById("demo1").value;
			var dateEnd = document.getElementById("demo2").value;
			
			const url = `printCustomerAccount.php?customerID=${encodeURIComponent(idCustomer)}&startDate=${encodeURIComponent(dateStart)}&endDate=${encodeURIComponent(dateEnd)}`;
			
			window.open(url,'_blank');
			return false;
		}
		
	}
	
	
	function GetAccountInfo(){
		var idCustomer = document.getElementById("idCustomer").value;
		var dateStart = document.getElementById("demo1").value;
		var dateEnd = document.getElementById("demo2").value;
		
		$.ajax({
			type : 'POST',
			url : 'getAccountInfo.php',
			data : {idCustomerValue: idCustomer, dateStartValue : dateStart, dateEndValue : dateEnd},
			dataType : 'json',
			success : function(r){
				var js_array = r;
				//remove all existing tbody tr rows
				$("#myTable").find("tbody tr").remove();
				
				//get a reference to the table tbody
				var tbodyRef = document.getElementById('myTable').getElementsByTagName('tbody')[0];
				
				for(var y = 0; y < js_array.length; y++){
					var accountDate = js_array[y][0];
					var accountReference = js_array[y][1];
					var accountDescription = js_array[y][2];
					var accountDebit = js_array[y][3];
					var accountCredit = js_array[y][4];
					var accountBalance = js_array[y][5];
					
					// Insert a row at the end of table
					var newRow = tbodyRef.insertRow();					
					newRow.classList.add("notfirst"); //ADD CLASS TO THE NEW ROW
					
					// Insert a cell at the end of the row
					var newCell = newRow.insertCell(0);
					var newCell2 = newRow.insertCell(1);
					var newCell3 = newRow.insertCell(2);
					var newCell4 = newRow.insertCell(3);
					var newCell5 = newRow.insertCell(4);
					var newCell6 = newRow.insertCell(5);
					//specify the width of each cell
					newCell.style.width = "70px";
					newCell2.style.width = "80px";
					newCell3.style.width = "320px";
					newCell4.style.width = "70px";
					newCell5.style.width = "70px";
					newCell6.style.width = "70px";
					
					newCell.innerHTML = accountDate;
					newCell2.innerHTML = accountReference;
					newCell3.innerHTML = accountDescription;
					newCell4.innerHTML = accountDebit;
					newCell5.innerHTML = accountCredit;
					newCell6.innerHTML = accountBalance;
					
					
				
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
			
			
			
			
		})
		
		return false;
	}

	

	function ShowCustomerDetail(x,y){
		document.getElementById("customerNameSpan").innerHTML = y;
		document.getElementById("idCustomer").value = x;
		document.getElementById("searchAccount").disabled = false;
		document.getElementById("printAccount").disabled = false;
		GetAccountInfo();
		return false;
	}

	
	
	
	
	
	
	

</script>
</head>
<body>
<center>

<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>

<form action="customerAccount.php" id="customerAccountForm" method="post" autocomplete="off" onsubmit="return CheckAndSubmit()">
<div class="float-container">
	<div class="float-child">
	<table width="510" border="0" cellpadding="0"><tr height="50"><td>&nbsp;</td></tr></table>
<table width="650" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Customer Account</h1></td></table>
<table width="510" border="0" cellpadding="0"><tr height="15">
<?php
	if(isset($_POST['Submit'])){
		echo "<td align='right'>";
		echo "<select name='customerType' id='customerType' size='1'>";
		if($_POST['customerType']==0){
			echo "<option value='0'>All</option>";
		}elseif($_POST['customerType']==1){
			echo "<option value='1'>Customer</option>";
		}elseif($_POST['customerType']==2){
			echo "<option value='2'>Supplier</option>";
		}else{
			echo "<option value='3'>Staff</option>";
		}		
		echo "<option value='0'>All</option>";
		echo "<option value='1'>Customer</option>";
		echo "<option value='2'>Supplier</option>";
		echo "<option value='3'>Staff</option>";		
		echo "</select>";
		if($_POST['searchValue']!=""){
			echo "<input type='text' name='searchValue' size='20' value=$_POST[searchValue]>";			
		}else{
			echo "<input type='text' name='searchValue' size='20'>";
		}	
	
	}else{
		
			echo "<td align='right'>";
			echo "<select name='customerType' id='customerType' size='1'>";		
			echo "<option value='0'>All</option>";
			echo "<option value='1'>Customer</option>";
			echo "<option value='2'>Supplier</option>";
			echo "<option value='3'>Staff</option>";		
			echo "</select>";			
			echo "<input type='text' name='searchValue' size='20'>";
				
	}
?>
<input type="submit" name="Submit" id="searchCustomer" value="Search" onclick="getButtonID(this.id)">

</td>
</tr>
</table>
<?php 
	if(mysqli_num_rows($resultCustomerList) > 0){
		
		echo "<table cellpadding=0 border=0 height='25' width='580'><tr><td align='left'><span id='noOfRecordSpan'>".mysqli_num_rows($resultCustomerList)."&nbsp;records</span></td><td></td></tr></table>";
		echo "<table width=\"510\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		//to change the number records balance after delete
		$noOfRecordValue = mysqli_num_rows($resultCustomerList);
		echo "<input type='hidden' id='noOfRecordID' value='$noOfRecordValue'></td></tr></table>";
		echo "<table cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:510'><p style=\"font-size:12px\"><b>Name</b></p></td>";		
		echo "<td style='width:40'><p style=\"font-size:12px\"><b>Acc</b></p></td>";			
		echo "</tr></thead>";
		while($rowCustomerList = mysqli_fetch_row($resultCustomerList)){
			$customerID = $rowCustomerList[0];
			$customerName = $rowCustomerList[1];
			$idRowIDname = "row".$rowCustomerList[0];
			echo "<tr bgcolor='FFFFFF' id=$idRowIDname height='30' class='notfirst'>";
			echo "<td style='width:510'><p style=\"font-size:12px\">$rowCustomerList[1]</p></td>";
			//customer ID is integer, customer name is string so need '' in below function
			echo "<td style='width:30'><p style=\"font-size:12px\"><a href='' onclick=\" return ShowCustomerDetail($customerID, '$customerName')\">Acc</a></p></td>";
			echo "</tr>";
		}		
		echo "</table>";
			
	}else{
		echo "<table width=\"540\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:510'><p style=\"font-size:12px\"><b>Name</b></p></td>";		
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Acc</b></p></td>";			
		echo "</tr></thead>";
		echo "</table>"; 
	}
?>
</div>
<div class="float-child2">	

<table width="50" border="0" cellpadding="0"><tr height="90"><td>&nbsp;</td></tr></table>	


<table width="500px" cellpadding="0" border="0">
<tr height="15"><td>
<input style="font-size:12px" id="demo1" type="text" name="accountDate1" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['accountDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;TO&nbsp;


<input style="font-size:12px" id="demo2" type="text" name="accountDate2" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['accountDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;




<input type="hidden" id="idCustomer" name="idCustomer" value="0">
<input type='hidden' id='buttonClicked' value=''>
<input type="submit" name="Submit" id="searchAccount" value="Search Account" disabled onclick="getButtonID(this.id)"></td></tr>
<tr height="57"><td><span id="customerNameSpan"></span></td></tr>
</table>
	
 <table width="610" cellpadding="0" border="1" id="myTable" class='mystyle2'>
	<thead><tr><td style='width:73'><b>Date</b></td><td style='width:85'><b>Reference</b></td><td style='width:255'><b>Description</b></td><td style='width:70'><b>Debit</b></td><td style='width:70'><b>Credit</b></td><td style='width:70'><b>Balance</b></td></thead></tr>
	<tbody>
			<!--<td></td><td></td>-->
	</tbody>

 </table>
<br>
<table width="500px" cellpadding="0" border="0">
<tr height="15"><td align="center"><input type="submit" name="Submit" id="printAccount" value="Print Account" disabled onclick="getButtonID(this.id)"></td></tr>
</table>

</div>
</form>
</center>
</body>

</html>
