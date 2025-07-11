<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	include ('makeSafe.php');
		
	//create new customer
	
	$customerName = makeSafe($_POST['customerNameValue']);
	$customerAttention = makeSafe($_POST['customerAttentionValue']);
	$customerAddress = makeSafe($_POST['customerAddressValue']);
	$customerDeliveryAddress = makeSafe($_POST['customerDeliveryAddressValue']);
	$customerStateID = makeSafe($_POST['customerStateIDvalue']);
	$customerTel = makeSafe($_POST['customerTelValue']);
	$customerEmail = makeSafe($_POST['customerEmailValue']);
	$customerTINno = makeSafe($_POST['customerTINnoValue']);
	$customerROCno = makeSafe($_POST['customerROCnoValue']);
	$customerType = makeSafe($_POST['customerTypeValue']);
	
	if($_POST['customerAddToAccountValue']==1){
		$addReceiveablePayable = 1;
	}else{
		$addReceiveablePayable = 0;
	}
	
	
	
	$sqlCreateCustomer = "INSERT INTO tbcustomer(customer_id, customer_name, customer_address, customer_tel, customer_email, 
	customer_type, customer_attention, customer_deliveryAddress, customer_TINnumber, customer_ROCnumber, customer_stateID) 
	VALUES(NULL, '$customerName', '$customerAddress', '$customerTel', '$customerEmail', '$customerType', '$customerAttention', 
	'$customerDeliveryAddress', '$customerTINno', '$customerROCno', '$customerStateID')";
	
	$result = mysqli_query($connection, $sqlCreateCustomer) or die("error in insert customer query");	
	$customerID = 0; //initialize
	//create the quotation record
	$customerID = mysqli_insert_id($connection);
	if($customerType <> 3){
		//staff no need create accounts first
		//create customer account record only if amount keyed in
		$customerAccountDebit = makeSafe($_POST['customerAccountDebitValue']);
		$customerAccountCredit = makeSafe($_POST['customerAccountCreditValue']);
	
		if((is_numeric($customerAccountDebit))||(is_numeric($customerAccountCredit))){
			if((($customerAccountDebit == 0) ||( $customerAccountDebit == 0.00))&&(($customerAccountCredit == 0) ||( $customerAccountCredit == 0.00))){
				//both side is 0, no need to create account
		
			}else{
				
				$customerAccountDescription = makeSafe($_POST['customerAccountDescriptionValue']);
				$customerAccountDate = convertMysqlDateFormat($_POST['customerAccountDateValue']);
				
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
						$sqlCreateSalesAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
						account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
						VALUES(NULL, 4, '$customerAccountDate', '$customerAccountDescription', 'CA', '$customerAccountID', '$customerName', 0.00,  '$customerAccountDebit')";

						mysqli_query($connection, $sqlCreateAccountReceiveable) or die("error in create account receiveable query");
						mysqli_query($connection, $sqlCreateSalesAccount) or die("error in create sales account query");			
					
					}elseif($customerType == 2){
						$supplierAccount3 = $_POST['account3Value'];
						
						//Create the Account Payable for SUPPLIER
						$sqlCreateAccountPayable = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
						account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
						VALUES(NULL, 6, '$customerAccountDate', '$customerAccountDescription', 'CA', '$customerAccountID', 
						'$customerName', 0.00, '$customerAccountCredit')";

						//Create the Purchase & Expense Account		
						$sqlCreatePurchaseExpenseAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
						account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit) 
						VALUES(NULL, '$supplierAccount3', '$customerAccountDate', '$customerAccountDescription', 'CA', '$customerAccountID', 
						'$customerName', '$customerAccountCredit', 0)";
						
						mysqli_query($connection, $sqlCreateAccountPayable) or die("error in create account payable query");
						mysqli_query($connection, $sqlCreatePurchaseExpenseAccount) or die("error in create account purchase query");
						
					}
				
				}
				
				
					
				
				
					
			
			
			
			}
		}
	}
	echo $customerID;
		
?>
