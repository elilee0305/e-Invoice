<?php
	
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	include ('makeSafe.php');
	
	
	if($_POST['transactionType'] == 1){
		//DOUBLE ENTRY TRANSACTION MANUAL
		$account3IDvalue = $_POST['account3IDname'];
		$account3cIDvalue = $_POST['account3cIDname'];
		$accountDate = convertMysqlDateFormat($_POST['doubleEntryDateName']);
		$doubleEntryDescriptionValue = makeSafe($_POST['doubleEntryDescriptionName']);
		
		$doubleEntryAmountValue = 0; 	
		if(is_numeric($_POST['doubleEntryAmountName'])){$doubleEntryAmountValue = $_POST['doubleEntryAmountName'];}


		//Create Debit Transaction, no need to insert into account4_selfPK
		 $sqlCreateDebitTransaction = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
		 account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort) 
		 VALUES(NULL, '$account3IDvalue', '$accountDate', 'DE', 'DET', 0, '$doubleEntryDescriptionValue', '$doubleEntryAmountValue', 0, 3)";
		
		mysqli_query($connection, $sqlCreateDebitTransaction) or die("error in create Debit query");

		$account3FK = mysqli_insert_id($connection);

		 
		 
		 //Create the Credit Transaction, enter FK from earlier transaction PK	
		$sqlCreateCreditTransaction = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
		account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort, account4_selfFK) 
		VALUES(NULL, '$account3cIDvalue', '$accountDate', 'DE', 'DET', 0, '$doubleEntryDescriptionValue', 0, '$doubleEntryAmountValue', 3, '$account3FK')";
		
		mysqli_query($connection, $sqlCreateCreditTransaction) or die("error in create Credit query");
		echo "1";

	}elseif($_POST['transactionType'] == 2){
		//ADJUSTMENT MANUAL
		$account3aIDvalue = $_POST['account3aIDname'];
		$adjustmentDate = convertMysqlDateFormat($_POST['adjustmentDateName']);
		$adjustmentDescriptionValue = makeSafe($_POST['adjustmentDescriptionName']);
		$adjustmentTypeValue = $_POST['adjustmentTypeName'];
		
		$adjustmentAmountValue = 0; 	
		if(is_numeric($_POST['adjustmentAmountName'])){$adjustmentAmountValue = $_POST['adjustmentAmountName'];}
		
		$debitAmount = 0.00; 
		$creditAmount = 0.00;
		
		if($adjustmentTypeValue=='d'){
			//debit
			$debitAmount = $adjustmentAmountValue;
		}else{
			//credit
			$creditAmount = $adjustmentAmountValue;
		}
		
		$sqlCreateAdjustmentTransaction = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
		 account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort) 
		 VALUES(NULL, '$account3aIDvalue', '$adjustmentDate', 'MA', 'MAT', 0, '$adjustmentDescriptionValue', '$debitAmount', '$creditAmount', 4)";
		
		mysqli_query($connection, $sqlCreateAdjustmentTransaction) or die("error in create Adjustment query");
		echo "1";
	}



















?>