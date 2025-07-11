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
				$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel, customer_email 
				FROM tbcustomer ORDER BY customer_name ASC";
			}else{
				$searchName = '%'.$searchName.'%'; 
				$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel, customer_email
				FROM tbcustomer WHERE (customer_name LIKE '$searchName') ORDER BY customer_name";	
			}						
		}else{
			if(trim($_POST['searchValue'])== ''){
				$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel, customer_email
				FROM tbcustomer WHERE (customer_type = '$customerType') ORDER BY customer_name ASC";		
			}else{
				$searchName = '%'.$searchName.'%'; 
				$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel, customer_email 
				FROM tbcustomer WHERE (customer_name LIKE '$searchName') AND (customer_type = '$customerType') 
				ORDER BY customer_name ASC";				
			}			
		}		
	}else{
		$sqlCustomerList = "SELECT customer_id, customer_name, customer_tel, customer_email 
		FROM tbcustomer ORDER BY customer_name ASC";
	}
	$resultCustomerList = mysqli_query($connection, $sqlCustomerList);

	//get the expenses accounts, HARD CODE, no rounding expense
	$sqlExpenseAccount = "SELECT account3_id, account3_name FROM tbaccount2, tbaccount3 WHERE (account2_id = account3_account2ID) 
	AND (account3_number <> 5190) AND (account3_number > 5000) ORDER BY account3_number ASC";
	$resultExpenseAccount = mysqli_query($connection, $sqlExpenseAccount) or die("error in expense account query");
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
	width: 860px;
	height: 350px;
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 12px; /* Added font-size */
}
.mystyle thead>tr {
  position: absolute;
  display: block;
  padding: 0;
  margin: 0;
  top: 154;
  background-color: transperant;
  width: 860px;
  z-index: -1;
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
	background-color: #E1ECEE;
}

.float-container{
    display: flex;
}
.float-child{
    width: 870px;
	margin-left: 20px;
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
.mystyle2 td, .mystyle2 th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0
	border-style: solid;
	border-color: #CDD0D1;
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


 /* Container for input and icon */
    .input-container {
      position: relative;
      display: inline-flex;
      align-items: center;
    }



</style>
<script>
	
	$( function() {
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
	
	function check(it) {		
		tr = it.parentElement.parentElement;
		tr.style.backgroundColor = (it.checked) ? "FFCCCB" : "ffffff";
	}
	
	
	//LOCK THE INPUT BOXES BASED ON TYPE OF CUSTOMER, SUPPLIER, STAFF
	$(function(){
   $('input[type=radio]').click(function(){
      let id = this.id;
      var customerEditID = document.getElementById("customerEditID").value;
	  //only work for CREATE CUSTOMER STATUS
	  if(customerEditID==0){
			if (id === 'customerType3'){
			   //customer 
					document.getElementById("customerAccountDebit").disabled = false;
					document.getElementById("customerAccountCredit").disabled = true;
					document.getElementById("customerAccountCredit").value = "";
					document.getElementById("addToAccount").disabled = false;
					document.getElementById("supplierAccount3").disabled = true;
					
					
					
			  }else if (id === 'customerType4'){
				//supplier
					document.getElementById("customerAccountDebit").disabled = true;
					document.getElementById("customerAccountDebit").value = "";
					document.getElementById("customerAccountCredit").disabled = false;
					document.getElementById("addToAccount").disabled = false;
					document.getElementById("supplierAccount3").disabled = false;
			  }else if(id === 'customerType5'){
				  //staff
					document.getElementById("customerAccountDebit").disabled = true;
					document.getElementById("customerAccountCredit").disabled = true;
					document.getElementById("customerAccountDebit").value = "";
					document.getElementById("customerAccountCredit").value = "";
					document.getElementById("supplierAccount3").disabled = true;
					
					var rowColor = document.getElementById("addToAccountRow");
					rowColor.style.backgroundColor = "white";					
					document.getElementById("addToAccount").checked = false;//checkbox add to account					
					document.getElementById("addToAccount").disabled = true;//checkbox add to account
			  }
	  }
	  
   });
});
	
	
	function resetToCreateValues(){		
		//RESET ALL THE VALUES TO CREATE CUSTOMER STATUS					
		document.getElementById("customerProcessType").value = 1; //default CREATE
		document.getElementById("customerEditID").value = 0; // product ID is 0
		document.getElementById("submitButton").value = "Create Product";
		document.getElementById("deleteButton").disabled = true; //delete button disables
		document.getElementById("addButtonLabel").disabled = true; //add + button disables
		
		$("#processTypeLabel").html("Create Customer & Supplier"); //Title
		document.getElementById("customerName").value = "";				
		document.getElementById("customerAttention").value = "";				
		document.getElementById("customerAddress").value = "";
		document.getElementById("customerDeliveryAddress").value = ""; 
		document.getElementById("customerType3").checked = true; //CUSTOMER
		document.getElementById("customerTel").value = "";
		document.getElementById("customerEmail").value = "";
		
		//Enable all Account info
		document.getElementById("demo2").disabled = false;//date
		document.getElementById("customerAccountDescription").disabled = false;//balance C/F
		document.getElementById("customerAccountDebit").value = "";
		document.getElementById("customerAccountCredit").value = "";
		document.getElementById("customerAccountDebit").disabled = false;//debit
		document.getElementById("customerAccountCredit").disabled = true;//credit
		document.getElementById("supplierAccount3").disabled = true;//account3
		document.getElementById("addToAccount").disabled = false;//checkbox add to account
		var rowColor = document.getElementById("addToAccountRow");
		rowColor.style.backgroundColor = "white";		
		
		
	}
	
	function getButtonID(clickedID){
		//alert(clickedID);
		document.getElementById("buttonClicked").value = clickedID;
	}
	
	function CheckAndSubmit(){
		var clickedButton = document.getElementById("buttonClicked").value;
		//only submit form for SEARCH button click
		if(clickedButton=='submitButton'){
			
			var processType = document.getElementById("customerProcessType").value;
			if(processType==1){
				//create customer
				var customerName = document.getElementById("customerName").value;
				customerName = customerName.trimLeft();
				
				if(customerName===""){
					alert("Must enter Customer Name!");
					document.getElementById("customerName").focus();
				}else{
				
					var t = confirm("Do you want to Create this Customer?");
					if(t==true){	
						CreateCustomer();
					} 
				}
			
			}else{
				//edit product
				var customerName = document.getElementById("customerName").value;
				customerName = customerName.trimLeft();
				
				if(customerName===""){
					alert("Must enter Customer Supplier Name!");
					document.getElementById("customerName").focus();
				}else{
				
					var t = confirm("Do you want to Edit this Customer?");
					var customerEditID = document.getElementById('customerEditID').value;
					if(t==true){
						
						EditCustomer(customerEditID);
					} 
				}
			}		
			
			return false;
		}else if(clickedButton=='deleteButton') {
			var customerEditID = document.getElementById('customerEditID').value;
			DeleteCustomer(customerEditID);
			
			return false;			
		}else if(clickedButton=='addButtonLabel') {			
			resetToCreateValues();			
			return false;			
		}	
		
	}
	
	


	function ShowCustomerDetail(x){
		var idCustomer = x;	
		var data = "customerID="+idCustomer;
		
		//change label, product id
		$("#processTypeLabel").html("Edit Customer & Supplier");
		document.getElementById("customerEditID").value = idCustomer;
		document.getElementById("submitButton").value = "Edit Customer";
		document.getElementById("customerProcessType").value = 2; //edit type
		document.getElementById("deleteButton").disabled = false; //delete button
		document.getElementById("addButtonLabel").disabled = false; //add + button
		//disabled all Account info
		document.getElementById("demo2").disabled = true;//date
		document.getElementById("customerAccountDescription").disabled = true;//balance C/F
		document.getElementById("customerAccountDebit").value = "";//debit
		document.getElementById("customerAccountCredit").value = "";//debit
		document.getElementById("customerAccountDebit").disabled = true;//debit
		document.getElementById("customerAccountCredit").disabled = true;//credit
		document.getElementById("supplierAccount3").disabled = true;//credit
		
		document.getElementById("addToAccount").checked = false;//checkbox add to account
		document.getElementById("addToAccount").disabled = true;//checkbox add to account
		var rowColor = document.getElementById("addToAccountRow");
		rowColor.style.backgroundColor = "white";		
		
		 $.ajax({
			type : 'POST',
			url : 'getCustomerDetail.php',
			data : data,
			dataType : 'json',
			success : function(r){
			
				var js_array = r;
				
				for(var y = 0; y < js_array.length; y++){
					var customerName = js_array[y][0]; 
					var customerAddress = js_array[y][1]; 
					var customerTel = js_array[y][2]; 
					var customerEmail = js_array[y][3]; 
					var customerAttention = js_array[y][4]; 					
					var customerDeliveryAddress = js_array[y][5]; 					
					var customerType = js_array[y][6]; 					
					var customerTINno = js_array[y][7]; 					
					var customerROCno = js_array[y][8]; 					
					var customerStateID = js_array[y][9]; 					
				} 
				
				document.getElementById("customerName").value = customerName;				
				document.getElementById("customerAddress").value = customerAddress;				
				document.getElementById("customerTel").value = customerTel;				
				document.getElementById("customerEmail").value = customerEmail;
				document.getElementById("customerTINno").value = customerTINno;
				document.getElementById("customerROCno").value = customerROCno;
				document.getElementById("customerStateID").value = customerStateID;
				document.getElementById("customerAttention").value = customerAttention; 
				document.getElementById("customerDeliveryAddress").value = customerDeliveryAddress; 
				
				if(customerType == 1){
					document.getElementById("customerType3").checked = true; 
				}else if(customerType == 2) {
					document.getElementById("customerType4").checked = true; 
				}else{
					document.getElementById("customerType5").checked = true; 
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}			
			
		})
		
		return false;
	}

	function DeleteCustomer(x){
		var deleteCustomerID = x;
		var data = "customerID="+deleteCustomerID;
		
		$.ajax({
			type : 'POST',
			url : 'customerDeleteCheckProcess.php',
			data : data,
			dataType : 'json',
			success: function(r){
				
			
				switch(r){
					case 1:
						var t = confirm("Do you want to Delete this Customer?");
						if(t==true){
							DeleteCustomerProcess(deleteCustomerID);
						}
						break;
					case 2:
						alert("Cannot delete customer. Got customer account records!");
						break;
					case 3:
						alert("Cannot delete customer. Got customer invoice records!");
						break;
					case 4:
						alert("Cannot delete customer. Got customer purchase bill records!");
						break;
					case 5:
						alert("Cannot delete customer. Got customer payment records!");
						break;
					case 6:
						alert("Cannot delete customer. Got customer payment voucher records!");
						break;
					case 7:
						alert("Cannot delete customer. Got customer purchase order records!");
						break;
					case 8:
						alert("Cannot delete customer. Got customer quotation records!");
						break;						
					case 9:
						alert("Cannot delete customer. Got customer delivery order records!");
						break;						
				}
			
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}	
		})
	}

	function DeleteCustomerProcess(y){
		var deleteCustomerID = y;
		var data = "customerID="+deleteCustomerID;
		
		$.ajax({
			type : 'POST',
			url : 'customerDeleteProcess.php',
			data : data,
			dataType : 'json',
			success: function(r){
				if(r=='1'){
					//successfull delete
					//delete the row
					var rowID = "row"+deleteCustomerID;
					var row = document.getElementById(rowID);
					row.parentNode.removeChild(row);
					//number of records 					
					var originalNoOfRecords = document.getElementById("noOfRecordID").value;
					var newNoOfRecords = originalNoOfRecords - 1;
					var newNoOfRecordsText = newNoOfRecords+"&nbsp;records";				
					document.getElementById("noOfRecordID").value = newNoOfRecords;					
					$("#noOfRecordSpan").html(newNoOfRecordsText);
					//RESET ALL THE VALUES TO CREATE PRODUCT STATUS					
					resetToCreateValues();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}	
		})
	}

	function CreateCustomer(){
		var customerName = document.getElementById("customerName").value;
		var customerAttention = document.getElementById("customerAttention").value;
		var customerAddress = document.getElementById("customerAddress").value;
		var customerDeliveryAddress = document.getElementById("customerDeliveryAddress").value;
		var customerStateID = document.getElementById("customerStateID").value;
		var customerTel = document.getElementById("customerTel").value;
		var customerEmail = document.getElementById("customerEmail").value;		
		var customerTINno = document.getElementById("customerTINno").value;		
		var customerROCno = document.getElementById("customerROCno").value;		
		var customerType = $("input[type='radio'][name='cusomerType2']:checked").val();
		//Account Info
		var customerAccountDate = document.getElementById("demo2").value;	
		var customerAccountDescription = document.getElementById("customerAccountDescription").value;	
		var customerAccountDebit = document.getElementById("customerAccountDebit").value;	
		var customerAccountCredit = document.getElementById("customerAccountCredit").value;
		var supplierAccount3 = document.getElementById("supplierAccount3").value;
		
		if(document.getElementById("addToAccount").checked){
			var customerAddToAccount = 1;
		}else{
			var customerAddToAccount = 0;
		}
		
		$.ajax({
			type : 'POST',
			url : 'createCustomer.php',
			data : {customerNameValue: customerName, customerAttentionValue: customerAttention, customerAddressValue: customerAddress, 
			customerDeliveryAddressValue: customerDeliveryAddress, customerStateIDvalue: customerStateID, customerTelValue: customerTel, customerEmailValue: customerEmail, 
			customerTypeValue: customerType, customerAddToAccountValue: customerAddToAccount, customerAccountDateValue: customerAccountDate, 
			customerAccountDescriptionValue: customerAccountDescription, customerAccountDebitValue: customerAccountDebit, 
			customerAccountCreditValue: customerAccountCredit, account3Value: supplierAccount3, customerTINnoValue: customerTINno, customerROCnoValue: customerROCno},
			dataType: 'json',
			success : function(w){
				if(w !== '0'){
					resetToCreateValues();					
					setTimeout(function() {
						
						document.getElementById('searchButton').click();
					  },0)
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
		})
	}
	
	function EditCustomer(r){
		var customerID = r;		
		var customerName = document.getElementById("customerName").value;
		var customerAttention = document.getElementById("customerAttention").value;
		var customerAddress = document.getElementById("customerAddress").value;
		var customerDeliveryAddress = document.getElementById("customerDeliveryAddress").value;
		var customerStateID = document.getElementById("customerStateID").value;
		var customerTel = document.getElementById("customerTel").value;
		var customerEmail = document.getElementById("customerEmail").value;		
		var customerTINno = document.getElementById("customerTINno").value;		
		var customerROCno = document.getElementById("customerROCno").value;		
		var customerType = $("input[type='radio'][name='cusomerType2']:checked").val();
		
		$.ajax({
			type : 'POST',
			url : 'editCustomer.php',
			data : {customerIDvalue: customerID, customerNameValue: customerName, customerAttentionValue: customerAttention, 
			customerAddressValue: customerAddress, customerDeliveryAddressValue: customerDeliveryAddress, customerStateIDvalue: customerStateID,customerTelValue: customerTel, 
			customerEmailValue: customerEmail, customerTypeValue: customerType, customerTINnoValue: customerTINno, customerROCnoValue: customerROCno},
			dataType: 'json',
			success : function(w){
				if(w=='1'){
					resetToCreateValues();					
					setTimeout(function() {						
						//direct change the row values
						document.getElementById('searchButton').click();
					  },0)
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
		})
	}

</script>
</head>
<body>
<center>

<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>

<form action="customerList.php" id="customerListForm" method="post" autocomplete="off" onsubmit="return CheckAndSubmit()">
<div class="float-container">
	<div class="float-child">
	<table width="760" border="0" cellpadding="0"><tr height="50"><td>&nbsp;</td></tr></table>
<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Customer & Supplier Database</h1></td></table>
<table width="760" border="0" cellpadding="0"><tr height="15">
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
<input type="submit" name="Submit" id="searchButton" value="Search" onclick="getButtonID(this.id)">
</td>
</tr>
</table>
<?php 
	if(mysqli_num_rows($resultCustomerList) > 0){
		
		echo "<table cellpadding=0 border=0 height='25' width='900'><tr><td align='left'><span id='noOfRecordSpan'>".mysqli_num_rows($resultCustomerList)."&nbsp;records</span></td><td></td></tr></table>";
		echo "<table width=\"760\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		//to change the number records balance after delete
		$noOfRecordValue = mysqli_num_rows($resultCustomerList);
		echo "<input type='hidden' id='noOfRecordID' value='$noOfRecordValue'></td></tr></table>";
		
		echo "<table cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:480'><p style=\"font-size:12px\"><b>Name</b></p></td>";
		echo "<td style='width:95'><p style=\"font-size:12px\"><b>Tel</b></p></td>";
		echo "<td style='width:205'><p style=\"font-size:12px\"><b>Email</b></p></td>";
		echo "<td style='width:40'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "</tr></thead>";
		while($rowCustomerList = mysqli_fetch_row($resultCustomerList)){
			$customerID = $rowCustomerList[0];
			$idRowIDname = "row".$rowCustomerList[0];
			
			echo "<tr bgcolor='FFFFFF' id=$idRowIDname height='30' class='notfirst'>";
			echo "<td style='width:580'><p style=\"font-size:12px\">$rowCustomerList[1]</p></td>";
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowCustomerList[2]</p></td>";	
			echo "<td style='width:150'><p style=\"font-size:12px\">$rowCustomerList[3]</p></td>";		
						
			echo "<td style='width:30'><p style=\"font-size:12px\"><a href='' onclick=\" return ShowCustomerDetail($customerID)\">edit</a></p></td>";
			echo "</tr>";
		}		
		echo "</table>";
			
	}else{
		echo "<table width=\"760\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table cellpadding='0' border='1' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:580'><p style=\"font-size:12px\"><b>Name</b></p></td>";
		echo "<td style='width:100'><p style=\"font-size:12px\"><b>Tel</b></p></td>";
		echo "<td style='width:150'><p style=\"font-size:12px\"><b>Email</b></p></td>";
		
		echo "<td style='width:30'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "</tr></thead>";
		echo "</table>"; 
	}
?>
</div>
<div class="float-child2">	

<table width="50" border="0" cellpadding="0"><tr height="152"><td>&nbsp;</td></tr></table>	

<table cellpadding="0" border="1" class="mystyle2">
<tr bgcolor="#dfebd8"><th><span id="processTypeLabel">Create Customer & Supplier</span></th></tr>

<tr><td><input type="text" name="customerName" id="customerName" size="40" maxlength="150" value="" placeholder="Name"><img src="images/einvoice.png" width="19"" height="19"></td></tr>
<tr><td><input type="text" name="customerAttention" id="customerAttention" size="25" maxlength="50" value="" placeholder="Attention"></td></tr>
<tr><td><textarea cols="35" rows="3" name="customerAddress" id="customerAddress" maxlength="250" placeholder="Address"></textarea></td></tr>
<tr><td><textarea cols="35" rows="3" name="customerDeliveryAddress" id="customerDeliveryAddress" maxlength="250" placeholder="Delivery Address"></textarea></td></tr>

<tr><td><div class="input-container"><input type="text" name="customerStateID" id="customerStateID" size="5" maxlength="2" value=""  placeholder="State"><img src="images/einvoice.png" alt="Info Icon" class="info-icon" id="infoIcon" width="19"" height="19"></div></td></tr>

<tr><td><input type="text" name="customerTel" id="customerTel" size="15" maxlength="30" value="" placeholder="Telephone"></td></tr>
<tr><td><input type="text" name="customerEmail" id="customerEmail" size="25" maxlength="100" value="" placeholder="Email"></td></tr>
<tr><td><input type="text" name="customerTINno" id="customerTINno" size="15" maxlength="20" value="" placeholder="Tin No"><img src="images/einvoice.png" width="19"" height="19"></td></tr>
<tr><td><input type="text" name="customerROCno" id="customerROCno" size="15" maxlength="20" value="" placeholder="ROC No"><img src="images/einvoice.png" width="19"" height="19"></td></tr>



<tr><td>
<input type="radio" name="cusomerType2" id="customerType3" value="1" checked>Customer
<input type="radio" name="cusomerType2" id="customerType4" value="2">Supplier
<input type="radio" name="cusomerType2" id="customerType5" value="3">Staff
</td></tr>

<tr bgcolor="eff5b8"><td>Account Status</td></tr>
<tr><td><input id="demo2" type="text" name="customerAccountDate" size="7" value="<?php echo date('d/m/Y');?>" readonly>
&nbsp;
<input type="text" name="customerAccountDescription" id="customerAccountDescription" size="25" maxlength="100" placeholder="Description" value="BALANCE C/F" readonly>
</td></tr>

<tr><td>customer&nbsp;<input type="text" name="customerAccountDebit" id="customerAccountDebit" size="5" maxlength="10" placeholder="Debit">
&nbsp;
supplier&nbsp;<input type="text" name="customerAccountCredit" id="customerAccountCredit" size="5" maxlength="10" placeholder="Credit" disabled>
</td></tr>

<tr id="addToAccountRow"><td>
<input type="checkbox" name="addToAccount" id="addToAccount" onclick="check(this)">&nbsp;Add total to Account Receiveable & Payable
</td></tr>

<tr><td>
<?php
	if(mysqli_num_rows($resultExpenseAccount)>0){
		echo "<select name='supplierAccount3' id='supplierAccount3' size='1' disabled>";	
		while($rowExpenseAccount = mysqli_fetch_array($resultExpenseAccount)){
			echo "<option value='$rowExpenseAccount[0]'>$rowExpenseAccount[1]</option>";
			 
		}		
		echo "</select>";
	}
?>


</td></tr>

<tr><td>

<!--DEFAULT IS CREATE NEW CUSTOMER", 1 = create new customer, 2 = edit existing customer-->
<input type="hidden" name="customerProcessType" id="customerProcessType" value="1">
<input type="hidden" name="customerEditID" id="customerEditID" value="0">
<input type='hidden' id='buttonClicked' value=''>
<input type="submit" name="Submit" id="submitButton" value="Create Customer" onclick="getButtonID(this.id)">
&nbsp;&nbsp;&nbsp;
<input type="submit" name="Submit" id="deleteButton" value="Delete Customer" onclick="getButtonID(this.id)" disabled>
&nbsp;&nbsp;
<input type="submit" name="Submit" id="addButtonLabel" value="+" onclick="getButtonID(this.id)" disabled>
</td></tr>
</table>

</div>
</form>
</center>


<script>
    // Get the icon element
    const infoIcon = document.getElementById('infoIcon');

    // Add click event to show an alert
    infoIcon.addEventListener('click', function() {
      alert('title="Johor(01), Kedah(02), Kelantan(03), Melaka(04), Negeri Sembilan(05), Pahang(06), Pulau Pinang(07), Perak(08), Perlis(09), Selangor(10), Terengganu(11), Sabah(12), Sarawak(13), Wilayah Persekutuan Kuala Lumpur(14), Wilayah Persekutuan Labuan(15), Wilayah Persekutuan Putrajaya(16), Not Applicable(17)"');
    });
  </script>



</body>

</html>
