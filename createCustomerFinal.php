<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	include ('makeSafe.php');
		
	//create new customer
	if(isset($_POST['Submit'])){
		$customerName = makeSafe($_POST['customerName']);
		$customerAttention = makeSafe($_POST['customerAttention']);
		$customerAddress = makeSafe($_POST['customerAddress']);
		$customerDeliveryAddress = makeSafe($_POST['customerDeliveryAddress']);
		$customerTel = makeSafe($_POST['customerTel']);
		$customerEmail = makeSafe($_POST['customerEmail']);
		$customerType = makeSafe($_POST['customerType']);
		$customerType = makeSafe($_POST['customerType']);
		if(isset($_POST['addToAccount'])){
			$addReceiveablePayable = 1;
		}else{
			$addReceiveablePayable = 0;
		}
		
		
		
		$sqlCreateCustomer = "INSERT INTO tbcustomer(customer_id, customer_name, customer_address, customer_tel, customer_email, 
		customer_type, customer_attention, customer_deliveryAddress) 
		VALUES(NULL, '$customerName', '$customerAddress', '$customerTel', '$customerEmail', '$customerType', '$customerAttention', 
		'$customerDeliveryAddress')";
		
		$result = mysqli_query($connection, $sqlCreateCustomer) or die("error in insert customer query");	
		
		//create the quotation record
		$customerID = mysqli_insert_id($connection);
		if($customerType <> 3){
			//staff no need create accounts first
			//create customer account record only if amount keyed in
			$customerAccountDebit = makeSafe($_POST['customerAccountDebit']);
			$customerAccountCredit = makeSafe($_POST['customerAccountCredit']);
		
			if((is_numeric($customerAccountDebit))||(is_numeric($customerAccountCredit))){
				if((($customerAccountDebit == 0) ||( $customerAccountDebit == 0.00))&&(($customerAccountCredit == 0) ||( $customerAccountCredit == 0.00))){
					//both side is 0, no need to create account
			
				}else{
					
					$customerAccountDescription = makeSafe($_POST['customerAccountDescription']);
					$customerAccountDate = convertMysqlDateFormat($_POST['customerAccountDate']);
					
					if(is_numeric($customerAccountDebit)){}else{$customerAccountDebit = 0.00;}
					if(is_numeric($customerAccountCredit)){}else{$customerAccountCredit = 0.00;}
					//ensure only one side balance is inserted, Debit is main because normally B/F amount 
					if(($customerAccountDebit <> 0.00) || ($customerAccountDebit <> 0)){$customerAccountCredit = 0.00;}
					
					//customer & supplier account
					$sqlCreateCustomerAccount = "INSERT INTO tbcustomeraccount(customerAccount_id, customerAccount_customerID, customerAccount_date, 
					customerAccount_documentType, customerAccount_description, customerAccount_debit, customerAccount_credit) 
					VALUES(NULL, '$customerID', '$customerAccountDate', 'MAD', '$customerAccountDescription', '$customerAccountDebit', 
					'$customerAccountCredit')";
					
					$resultCustomerAccount = mysqli_query($connection, $sqlCreateCustomerAccount) or die("error in insert customer account query");
					$customerAccountID = mysqli_insert_id($connection);
					
					if($addReceiveablePayable == 1){
						//only if main acc account ticked
						if($customerType == 1){
							//Create the Account Receiveable for CUSTOMER
							$sqlCreateAccountReceiveable = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
							account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
							VALUES(NULL, 2, '$customerAccountDate', '$customerAccountDescription', 'CA', '$customerAccountID', 
							'$customerName', '$customerAccountDebit', 0.00)";
							
							//Create the Sales Account
							/* $sqlCreateSalesAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
							account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
							VALUES(NULL, 4, '$customerAccountDate', '$customerAccountDescription', 'CA', '$customerAccountID', '$customerName', 0.00,  '$customerAccountDebit')"; */
							
							mysqli_query($connection, $sqlCreateAccountReceiveable) or die("error in create account receiveable query");
							//mysqli_query($connection, $sqlCreateSalesAccount) or die("error in create sales account query");			
						
						}elseif($customerType == 2){
							//Create the Account Payable for SUPPLIER
							$sqlCreateAccountPayable = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
							account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
							VALUES(NULL, 6, '$customerAccountDate', '$customerAccountDescription', 'CA', '$customerAccountID', 
							'$customerName', 0.00, '$customerAccountCredit')";	
							
							mysqli_query($connection, $sqlCreateAccountPayable) or die("error in create account payable query");
						}
					
					}
					
					
						
					
					
						
				
				
				
				}
			}
		}
		header ("Location: createCustomerFinal.php");
	}	
?>
<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css">
<title>Invoicing Billing System</title>
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
</script>

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
	background-color: #FFB6C1;
}

input:focus
{
	background-color: AFCCB0;
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
	function CheckAndSubmit(){
		var customerName = document.getElementById("customerName");
		if(customerName.value.length==0){
			alert("Must enter Customer Name!");
			customerName.focus();
			return false;
		}	

		var r = confirm("Do you want to Create New Customer?");
		if(r==false){
			return false;
		}
	}

	function LockInput(x) {
		var customerType = x.options[x.selectedIndex].value;
		console.log(customerType);
		if(customerType==1){
			//customer 
			document.getElementById("customerAccountDebit").readOnly = false;
			document.getElementById("customerAccountCredit").readOnly = true;
			document.getElementById("customerAccountCredit").value = "";
			
		}else if(customerType==2){
			//supplier
			document.getElementById("customerAccountDebit").readOnly = true;
			document.getElementById("customerAccountDebit").value = "";
			document.getElementById("customerAccountCredit").readOnly = false;
			
		}else {
			//staff
			document.getElementById("customerAccountDebit").readOnly = true;
			document.getElementById("customerAccountCredit").readOnly = true;
			document.getElementById("customerAccountDebit").value = "";
			document.getElementById("customerAccountCredit").value = "";
			
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

<p class="bigGap"></p>
<form action="createCustomerFinal.php" id="createCustomerForm" method="post" onsubmit="return CheckAndSubmit()">
<table width="55%" cellpadding="0" border="1" class="mystyle">
<tr><td colspan="2" align="left"><h1>Create New Customer & Supplier</h1></td></tr>
<tr><td>Name</td><td><input type="text" name="customerName" id="customerName" size="45"><img src="images/redmark.png"></td></tr>
<tr><td>Attention</td><td><input type="text" name="customerAttention" id="customerAttention" size="45"></td></tr>
<tr><td>Address</td><td><textarea cols="30" rows="4" name="customerAddress" id="customerAddress" maxlength="250"></textarea></td></tr>
<tr><td>Delivery Address</td><td><textarea cols="30" rows="4" name="customerDeliveryAddress" id="customerDeliveryAddress" maxlength="250"></textarea></td></tr>
<tr><td>Tel</td><td><input type="text" name="customerTel" id="customerTel" size="20"></td></tr>
<tr><td>Email</td><td><input type="text" name="customerEmail" id="customerEmail" size="45"></td></tr>
<tr><td>Type</td><td><select name="customerType" id="customerType" size="1" onChange="LockInput(this)">
<option value="1">Customer</option>
<option value="2">Supplier</option>
<option value="3">Staff</option>
</select><img src="images/redmark.png"></td></tr>
<tr bgcolor="eff5b8"><td colspan="2" align="left">Account Status</td></tr>
<tr><td colspan="2" align="left"><input id="demo2" type="text" name="customerAccountDate" size="7" value="<?php echo date('d/m/Y');?>" readonly>&nbsp;
&nbsp;<input type="text" name="customerAccountDescription" size="30" maxlength="100" placeholder="Description" value="BALANCE C/F" readonly>
&nbsp;customer<input type="text" name="customerAccountDebit" id="customerAccountDebit" size="5" maxlength="10" placeholder="Debit">
&nbsp;supplier<input type="text" name="customerAccountCredit" id="customerAccountCredit" size="5" maxlength="10" placeholder="Credit" readonly>

</td></tr>
<tr><td colspan="2">
<input type="checkbox" name="addToAccount" id="addToAccount" onclick="check(this)">
&nbsp;&nbsp;Add total to Account Receiveable & Payable

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="submit" name="Submit" value="Create New Customer"></td></tr>
</table>
</form>

</center>
</body>

</html>