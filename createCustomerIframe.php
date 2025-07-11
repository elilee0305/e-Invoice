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
	
	
	//get the expenses accounts, HARD CODE, no rounding expense
	$sqlExpenseAccount = "SELECT account3_id, account3_name FROM tbaccount2, tbaccount3 WHERE (account2_id = account3_account2ID) 
	AND (account3_number <> 5190) AND (account3_number > 5000) ORDER BY account3_number ASC";
	$resultExpenseAccount = mysqli_query($connection, $sqlExpenseAccount) or die("error in expense account query");
	
	
?>
<html>
<head>
<title>Online Imes System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>

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
   });
});
	
	function getButtonID(clickedID){
		//alert(clickedID);
		document.getElementById("buttonClicked").value = clickedID;
	}
	
	function CheckAndSubmit(){
		var clickedButton = document.getElementById("buttonClicked").value;
		//only submit form for SEARCH button click
		if(clickedButton=='submitButton'){
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
			return false;
		}/* else if(clickedButton=='closeButton') {			
			//close this form		
			return false;			
		} */	
	}
	
	function CreateCustomer(){
		var customerName = document.getElementById("customerName").value;
		var customerAttention = document.getElementById("customerAttention").value;
		var customerAddress = document.getElementById("customerAddress").value;
		var customerDeliveryAddress = document.getElementById("customerDeliveryAddress").value;
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
			customerDeliveryAddressValue: customerDeliveryAddress, customerTelValue: customerTel, customerEmailValue: customerEmail, 
			customerTINnoValue: customerTINno, customerROCnoValue: customerROCno, customerTypeValue: customerType, customerAddToAccountValue: customerAddToAccount, customerAccountDateValue: customerAccountDate, 
			customerAccountDescriptionValue: customerAccountDescription, customerAccountDebitValue: customerAccountDebit, 
			customerAccountCreditValue: customerAccountCredit, account3Value: supplierAccount3},
			dataType: 'json',
			success : function(w){
				if(w !== '0'){
					document.getElementById("newCustomerID").value = w;
					parent.postMessage({ action: 'closeDialogBox' }, '*');
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
		})
	}
	
</script>

<style type="text/css">
.notfirst:hover
{
	background-color: #E1ECEE;
}

table.mystyle2
{
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 13px; /* Added font-size */
	
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
</style>

</head>
<body>
<form action="createCustomerIframe.php" id="createCustomerIframeForm" method="post" autocomplete="off" onsubmit="return CheckAndSubmit()">

<table width="50" border="0" cellpadding="0"><tr height="20"><td>&nbsp;</td></tr></table>	

<table cellpadding="0" border="1" class="mystyle2">
<tr bgcolor="#dfebd8"><th><span id="processTypeLabel">Create Customer & Supplier</span></th></tr>

<tr><td><input type="text" name="customerName" id="customerName" size="40" maxlength="150" value="" placeholder="Name"></td></tr>
<tr><td><input type="text" name="customerAttention" id="customerAttention" size="25" maxlength="50" value="" placeholder="Attention"></td></tr>
<tr><td><textarea cols="35" rows="3" name="customerAddress" id="customerAddress" maxlength="250" placeholder="Address"></textarea></td></tr>
<tr><td><textarea cols="35" rows="3" name="customerDeliveryAddress" id="customerDeliveryAddress" maxlength="250" placeholder="Delivery Address"></textarea></td></tr>

<tr><td><input type="text" name="customerTel" id="customerTel" size="15" maxlength="30" value="" placeholder="Telephone"></td></tr>
<tr><td><input type="text" name="customerEmail" id="customerEmail" size="25" maxlength="100" value="" placeholder="Email"></td></tr>


<tr><td><input type="text" name="customerTINno" id="customerTINno" size="15" maxlength="20" value="" placeholder="Tin No"></td></tr>
<tr><td><input type="text" name="customerROCno" id="customerROCno" size="15" maxlength="20" value="" placeholder="ROC No"></td></tr>


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

<tr><td align="right">
<input type='hidden' id='buttonClicked' value=''>
<input type='hidden' id='newCustomerID' value='0'>
<input type="submit" name="Submit" id="submitButton" value="Create Customer" onclick="getButtonID(this.id)">
&nbsp;&nbsp;&nbsp;
<!--<input type="submit" name="Submit" id="closeButton" value="Close" onclick="getButtonID(this.id)">-->
</td></tr>
</table>

</form>

</body>


</html>