<?php	
	session_start();

	if($_SESSION['userID']==""){
		//not logged in
		ob_start();
		header ("Location: index.php");
		ob_flush();
	}

	include('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");	
	
	if(isset($_POST['Submit'])){
		
		$openingBalanceDate = $_POST['openingBalanceDate'];
		$accountingPeriodID = $_POST['accountingPeriodID'];
		
		$aAccountIDselected = $_POST['accountID'];
		if(empty($aAccountIDselected)){
			// no account  selected
			
		}else{
			$countAccountIDselected = count($aAccountIDselected);
			
			//AUTOCOMMIT OFF, START TRANSACTION
			mysqli_autocommit($connection, false);
			
			for($i=0; $i < $countAccountIDselected; $i++){
				
				$debitAamount = 0.00;
				$creditAamount = 0.00;
				
				$accountIDvalue = $aAccountIDselected[$i];
				$aAccountIDvalue = explode("|",$accountIDvalue);
				$account1Number = $aAccountIDvalue[0];
				$acccount3ID = $aAccountIDvalue[1];
				$contraAssetStatusValue = $aAccountIDvalue[2];
				
				if($account1Number==1000){
					
					if($contraAssetStatusValue=="c"){
						//credit side for contra asset account
						$creditBoxName = "credit|".$acccount3ID;
						$creditAamount = $_POST[$creditBoxName];
						if(is_numeric($creditAamount)){}else{$creditAamount=0.00;}
						
						
						
						
						if(($creditAamount <> 0.00) || ($creditAamount <> 0)){						
							$sqlCreateCreditAccountBalance = "INSERT INTO tbaccountingperioddetail(accountingPeriodDetail_id, accountingPeriodDetail_accountingPeriodID, 
							accountingPeriodDetail_openCreditBalance, accountingPeriodDetail_dateCreated, accountingPeriodDetail_generated, 
							accountingPeriodDetail_account3ID) VALUES(NULL, '$accountingPeriodID', '$creditAamount', '$openingBalanceDate', 
							'm', '$acccount3ID')";
													
							mysqli_query($connection, $sqlCreateCreditAccountBalance) or die("error in create account contra credit query");
							
							//get the accounting period detail ID
							$accountingPeriodDetailID = mysqli_insert_id($connection);
						
							$sqlCreateLedgerAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
							account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort) 
							VALUES(NULL, '$acccount3ID', '$openingBalanceDate', 'AP', 'APO', '$accountingPeriodDetailID', 'Opening Balance', 0, '$creditAamount', 0)";
							
							//to balance all accounts when start using Accounting System, 1 TIME ONLY, 
							//the temporary "OPENING BALANCE EQUITY ACCOUNT" is used for the credit side, hard coded = 15
							/* $sqlCreateTemporaryBalanceAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
							account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort) 
							VALUES(NULL, '15', '$openingBalanceDate', 'AP', 'APO', '$accountingPeriodDetailID', 'Opening Balance', 0, '$debitAamount', 0)"; */
							
							mysqli_query($connection, $sqlCreateLedgerAccount) or die("error in create ledger account query");
							//mysqli_query($connection, $sqlCreateTemporaryBalanceAccount) or die("error in create temporary account credit query");
						}
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
					}else{
						//debit side for asset accounts
						$debitBoxName = "debit|".$acccount3ID;
						$debitAamount = $_POST[$debitBoxName];
						if(is_numeric($debitAamount)){}else{$debitAamount=0.00;}
						
						if(($debitAamount <> 0.00) || ($debitAamount <> 0)){						
							$sqlCreateDebitAccountBalance = "INSERT INTO tbaccountingperioddetail(accountingPeriodDetail_id, accountingPeriodDetail_accountingPeriodID, 
							accountingPeriodDetail_openDebitBalance, accountingPeriodDetail_dateCreated, accountingPeriodDetail_generated, 
							accountingPeriodDetail_account3ID) VALUES(NULL, '$accountingPeriodID', '$debitAamount', '$openingBalanceDate', 
							'm', '$acccount3ID')";
													
							mysqli_query($connection, $sqlCreateDebitAccountBalance) or die("error in create account debit query");
							
							//get the accounting period detail ID
							$accountingPeriodDetailID = mysqli_insert_id($connection);
						
							$sqlCreateLedgerAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
							account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort) 
							VALUES(NULL, '$acccount3ID', '$openingBalanceDate', 'AP', 'APO', '$accountingPeriodDetailID', 'Opening Balance', '$debitAamount', 0, 0)";
							
							//to balance all accounts when start using Accounting System, 1 TIME ONLY, 
							//the temporary "OPENING BALANCE EQUITY ACCOUNT" is used for the credit side, hard coded = 15
							/* $sqlCreateTemporaryBalanceAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
							account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort) 
							VALUES(NULL, '15', '$openingBalanceDate', 'AP', 'APO', '$accountingPeriodDetailID', 'Opening Balance', 0, '$debitAamount', 0)"; */
							
							mysqli_query($connection, $sqlCreateLedgerAccount) or die("error in create ledger account query");
							//mysqli_query($connection, $sqlCreateTemporaryBalanceAccount) or die("error in create temporary account credit query");
						}
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
						
					}
					
					
				
					
				}elseif(($account1Number==2000)||($account1Number==3000)){
					//credit side for Liablity & Equity accounts
					$creditBoxName = "credit|".$acccount3ID;
					$creditAamount = $_POST[$creditBoxName];
					if(is_numeric($creditAamount)){}else{$creditAamount=0.00;}
					if(($creditAamount <> 0.00) || ($creditAamount <> 0)){
						$sqlCreateCreditAccountBalance = "INSERT INTO tbaccountingperioddetail(accountingPeriodDetail_id, accountingPeriodDetail_accountingPeriodID, 
						accountingPeriodDetail_openCreditBalance, accountingPeriodDetail_dateCreated, accountingPeriodDetail_generated, 
						accountingPeriodDetail_account3ID) VALUES(NULL, '$accountingPeriodID', '$creditAamount', '$openingBalanceDate', 
						'm', '$acccount3ID')";
					
						mysqli_query($connection, $sqlCreateCreditAccountBalance) or die("error in create account credit query");
					
						//get the accounting period detail ID
						$accountingPeriodDetailID = mysqli_insert_id($connection);
						
						$sqlCreateLedgerAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
						account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort) 
						VALUES(NULL, '$acccount3ID', '$openingBalanceDate', 'AP', 'APO', '$accountingPeriodDetailID', 'Opening Balance', 0, '$creditAamount', 0)";
						
						
						//to balance all accounts when start using Accounting System, 1 TIME ONLY, 
						//the temporary "OPENING BALANCE EQUITY ACCOUNT" is used for the debit side, hard coded = 15
						/* $sqlCreateTemporaryBalanceAccount = "INSERT INTO tbaccount4(account4_id, account4_account3ID, account4_date, account4_reference, 
						account4_documentType, account4_documentTypeID, account4_description, account4_debit, account4_credit, account4_sort) 
						VALUES(NULL, '15', '$openingBalanceDate', 'AP', 'APO', '$accountingPeriodDetailID', 'Opening Balance', '$creditAamount', 0,0)"; */
						
						mysqli_query($connection, $sqlCreateLedgerAccount) or die("error in create ledger account query");
						//mysqli_query($connection, $sqlCreateTemporaryBalanceAccount) or die("error in create temporary account debit query");
						
					}
				}
			}
			
			//COMMIT TRANSACTION
			mysqli_commit($connection);
		}
	}
	
	//get the accounting period 
	$sqlAccountingPeriod = "SELECT accountingPeriod_id, accountingPeriod_dateStart, accountingPeriod_dateEnd, accountingPeriod_status
	FROM tbaccountingperiod WHERE accountingPeriod_status = 'o'  ORDER BY accountingPeriod_dateStart ASC";
	
	$resultAccountingPeriod = mysqli_query($connection, $sqlAccountingPeriod) or die("error in accounting period query");

	if(mysqli_num_rows($resultAccountingPeriod) > 0){
		$leavePeriodTotal = mysqli_num_rows($resultAccountingPeriod);
		$counter = 1;		
		while($rowAccountingPeriod=mysqli_fetch_array($resultAccountingPeriod)){			
			$defaultStartDate = date('d/m/Y',strtotime($rowAccountingPeriod[2].'+ 1 day'));//get the next day
			$defaultEndDate = date('d/m/Y',strtotime($rowAccountingPeriod[2].'+ 1 year'));//get the next day
			if($counter==$leavePeriodTotal){$accountingPeriodIDvalue = $rowAccountingPeriod[0];}
			$counter = $counter + 1;
		}
	}
	
	//get the chart of accounts	
	$sqlBalanceSheetAccount = "SELECT account1_name, account1_number, account1_chartAccountID, account2_name, account2_number, 
	account3_name, account3_number, account3_id, account3_accountNumber 
	FROM tbaccount1, tbaccount2, tbaccount3 WHERE  (account1_id = account2_account1ID) 
	AND (account2_id = account3_account2ID)	AND (account1_chartAccountID = 1) ORDER BY account1_number ASC, account2_number ASC, account3_number ASC";
	
	$resultBalanceSheetAccount = mysqli_query($connection, $sqlBalanceSheetAccount) or die("error in balance sheet account query");
?>

<html>
<head>
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	
	function CheckAndSubmit(){
		if($('.select:checkbox:checked').length == 0){
			alert("Select a Account to create Opening Balance!!");
			return false;
		}
		var r = confirm("Do you want to Create Opening Balance for all Selected Accounts?");
		if(r==false){
			return false;
		}
	}
	
	function check(it) {
		tr = it.parentElement.parentElement;
		tr.style.backgroundColor = (it.checked) ? "FFCCCB" : "ffffff";
		//main checkbox unchecked if sub checkbox clicked for ease of use
		document.getElementById('select_master').checked = false;
		
		var checkboxes = document.getElementsByName('accountID[]');
		var rowDebitFinal = 0.00;
		var rowCreditFinal = 0.00;
		
		for(var i=0,n=checkboxes.length;i<n;i++){
			var rowDebitTotal = 0;
			var rowCreditTotal = 0;
			
			if(checkboxes[i].checked){
				var accountSelectedID =  checkboxes[i].value;
				var selectedAccount = String(accountSelectedID);
				var values = selectedAccount.split("|");
				var valueAccount = values[1];				
				var selectedAccountBox = "debit|" + valueAccount;				
				var selectedAccountBox2 = "credit|" + valueAccount;				
				//Debit
				if(isNaN(document.getElementById(selectedAccountBox).value)){		
					rowDebitTotal = 0*1;
				}else{
					if(document.getElementById(selectedAccountBox).value==""){			
						rowDebitTotal = 0*1;
					}else{			
						numPrice = document.getElementById(selectedAccountBox).value;			
						rowDebitTotal = numPrice*1;
					}		
				}	
				rowDebitFinal = rowDebitFinal + rowDebitTotal;	
				
				//Credit				
				if(isNaN(document.getElementById(selectedAccountBox2).value)){		
					rowCreditTotal = 0*1;
				}else{
					if(document.getElementById(selectedAccountBox2).value==""){			
						rowCreditTotal = 0*1;
					}else{			
						numPrice = document.getElementById(selectedAccountBox2).value;			
						rowCreditTotal = numPrice*1;
					}		
				}	
				rowCreditFinal = rowCreditFinal + rowCreditTotal;
			}			
		}  
		//grand total 	
		document.getElementById("debitTotal").value = (rowDebitFinal).toFixed(2);
		document.getElementById("creditTotal").value = (rowCreditFinal).toFixed(2);
	}
	
	function check2(){
		var checkboxes = document.getElementsByName('accountID[]');
		var rowDebitFinal = 0.00;
		var rowCreditFinal = 0.00;
		
		for(var i=0,n=checkboxes.length;i<n;i++){
			
			var rowDebitTotal = 0;
			var rowCreditTotal = 0;
			
			if(checkboxes[i].checked){
				var accountSelectedID =  checkboxes[i].value;
				var selectedAccount = String(accountSelectedID);
				var values = selectedAccount.split("|");
				var valueAccount = values[1];
				var selectedAccountBox = "debit|" + valueAccount;				
				var selectedAccountBox2 = "credit|" + valueAccount;				
				//Debit
				if(isNaN(document.getElementById(selectedAccountBox).value)){		
					rowDebitTotal = 0*1;
				}else{
					if(document.getElementById(selectedAccountBox).value==""){			
						rowDebitTotal = 0*1;
					}else{			
						numPrice = document.getElementById(selectedAccountBox).value;			
						rowDebitTotal = numPrice*1;
					}		
				}	
				rowDebitFinal = rowDebitFinal + rowDebitTotal;		
				
				//Credit
				if(isNaN(document.getElementById(selectedAccountBox2).value)){		
					rowCreditTotal = 0*1;
				}else{
					if(document.getElementById(selectedAccountBox2).value==""){			
						rowCreditTotal = 0*1;
					}else{			
						numPrice = document.getElementById(selectedAccountBox2).value;			
						rowCreditTotal = numPrice*1;
					}		
				}	
				rowCreditFinal = rowCreditFinal + rowCreditTotal;
			}			
		}  
		//grand total 	
		document.getElementById("debitTotal").value = (rowDebitFinal).toFixed(2);
		document.getElementById("creditTotal").value = (rowCreditFinal).toFixed(2);
	}
	
	
	function togglecheckboxes(master,cn) {
		var cbarray = document.getElementsByClassName(cn);
		for(var i = 0; i < cbarray.length; i++){
			var cb = document.getElementById(cbarray[i].id);
			cb.checked = master.checked;
			tr = cb.parentElement.parentElement;
			tr.style.backgroundColor = (cb.checked) ? "FFCCCB" : "ffffff";
		}
		
		
		var checkboxes = document.getElementsByName('accountID[]');
		var rowDebitFinal = 0.00;
		var rowCreditFinal = 0.00;
		
		for(var i=0,n=checkboxes.length;i<n;i++){
			
			var rowDebitTotal = 0;
			var rowCreditTotal = 0;
			
			if(checkboxes[i].checked){
				var accountSelectedID =  checkboxes[i].value;
				var selectedAccount = String(accountSelectedID);
				var values = selectedAccount.split("|");
				var valueAccount = values[1];
				var selectedAccountBox = "debit|" + valueAccount;				
				var selectedAccountBox2 = "credit|" + valueAccount;				
				//Debit
				if(isNaN(document.getElementById(selectedAccountBox).value)){		
					rowDebitTotal = 0*1;
				}else{
					if(document.getElementById(selectedAccountBox).value==""){			
						rowDebitTotal = 0*1;
					}else{			
						numPrice = document.getElementById(selectedAccountBox).value;			
						rowDebitTotal = numPrice*1;
					}		
				}	
				rowDebitFinal = rowDebitFinal + rowDebitTotal;	
				
				//Credit
				if(isNaN(document.getElementById(selectedAccountBox2).value)){		
					rowCreditTotal = 0*1;
				}else{
					if(document.getElementById(selectedAccountBox2).value==""){			
						rowCreditTotal = 0*1;
					}else{			
						numPrice = document.getElementById(selectedAccountBox2).value;			
						rowCreditTotal = numPrice*1;
					}		
				}	
				rowCreditFinal = rowCreditFinal + rowCreditTotal;
			}			
		}  
		//grand total 	
		document.getElementById("debitTotal").value = (rowDebitFinal).toFixed(2);
		document.getElementById("creditTotal").value = (rowCreditFinal).toFixed(2);
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
	background-color: #E1ECEE;
}
input:focus
{
	background-color: AFCCB0;
}
</style>

</head>

	<body>

	<center>
<div class="navbar">
	<?php include('menuPHPImes.php');?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>
<table border="0" cellpadding="0" width="800"><tr height="30"><td>&nbsp;</td></tr></table>
<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left"><h1>Accounting Period Opening Balance</h1></td></tr></table>

<table width="300" border="0" cellpadding="0">
<tr height="30"><td width="90"></td><td width="210" align="left"></td></tr>
<tr height="30"><td colspan="2"></td></tr>
<tr><td colspan="2"></td></tr>
</table>

<?php 
	
	if(mysqli_num_rows($resultAccountingPeriod)>0){
		//reuse the recordset
		mysqli_data_seek($resultAccountingPeriod, 0);
		
		echo "<table width='600' cellpadding='0' border='1' class='mystyle'>";
		echo "<tr><td></td><td><strong>Date Start</strong></td><td><strong>Date End</strong></td><td><strong>No Of Days</strong></td><td><strong>Status</strong></td></tr>";
		$rowNumber = 1;
		while($rowAccountingPeriod = mysqli_fetch_row($resultAccountingPeriod)){			
			echo "<tr class='notfirst'>";
			echo "<td>$rowNumber".".</td>";
			$dateOpeningBalance = $rowAccountingPeriod[1];
			$dateValue = strtotime($rowAccountingPeriod[1]);
			echo "<td>".date('d-m-Y', $dateValue)."</td>";
			$dateValue2 = strtotime($rowAccountingPeriod[2]);
			echo "<td>".date('d-m-Y', $dateValue2)."</td>";
			//use DateTime and DateInterval objects
			$date1 = new DateTime($rowAccountingPeriod[1]);
			$date2 = new DateTime($rowAccountingPeriod[2]);
			
			$interval = $date1->diff($date2);
			echo "<td>".$interval->days."</td>";
			if($rowAccountingPeriod[3]=='o'){
				echo "<td>open</td>";
			}elseif($rowAccountingPeriod[3]=='c'){
				echo "<td>close</td>";
			}elseif($rowAccountingPeriod[3]=='t'){
				echo "<td>T.close</td>";
			}
			
			echo "</tr>";
			$rowNumber = $rowNumber + 1;
		}
		
		echo "</table>";
	}
?>

<table width="300" border="0" cellpadding="0">
<tr height="30"><td width="90"></td><td width="210" align="left"></td></tr>
<tr height="30"><td colspan="2"></td></tr>
<tr><td colspan="2"></td></tr>
</table>

<form action="createAPmanualOpenBalance.php" id="createAPmanualOpenBalanceForm" method="post" onsubmit="return CheckAndSubmit()">

<?php 
		
	if(mysqli_num_rows($resultAccountingPeriod)>0){	
		if(mysqli_num_rows($resultBalanceSheetAccount) > 0){
			echo "<table width='900' cellpadding='0' border='1' class='mystyle'>";
			$openingBalanceLabel = "Opening Balance ".date('d-m-Y', $dateValue);
			echo "<tr><th colspan='5'></th><th colspan='2'>$openingBalanceLabel</th></tr>";
			echo "<tr><th><input type='checkbox' id='select_master' checked onchange=\"togglecheckboxes(this, 'select')\"></th><th>Acc Type</th><th>Sub Account</th><th>Number</th><th>Account</th><th>Debit</th><th>Credit</th></tr>";

			while($rowBalanceSheetAccount = mysqli_fetch_row($resultBalanceSheetAccount)){
				//capture contra asset account
				$contraAssetStatus = "n"; //no
				if($rowBalanceSheetAccount[8]=="ADCONT"){
					$contraAssetStatus = "c"; //yes
				}
				
				$accountSelectedID = $rowBalanceSheetAccount[1]."|".$rowBalanceSheetAccount[7]."|".$contraAssetStatus; //account1 number & account3 ID	& contra asset status		
				$accountSelectID = "account|".$rowBalanceSheetAccount[7]; 
				
				echo "<tr class='notfirst' bgcolor='FFCCCB'>";
				echo "<td align='center'><input type='checkbox' name='accountID[]' value=$accountSelectedID id='$accountSelectID' class='select' checked onclick='check(this)'></td>";			
				echo "<td><p style=\"font-size:13px\">$rowBalanceSheetAccount[0]</p></td>";
				echo "<td><p style=\"font-size:13px\">$rowBalanceSheetAccount[3]</p></td>";
				echo "<td><p style=\"font-size:13px\">$rowBalanceSheetAccount[6]</p></td>";
				echo "<td><p style=\"font-size:13px\">$rowBalanceSheetAccount[5]</p></td>";
				$debitValue = "debit|".$rowBalanceSheetAccount[7];
				
				
				if($rowBalanceSheetAccount[1]==1000){
					//Asset normally Debit Balance
					//Contra Asset accout Credit Balance
					
					if($rowBalanceSheetAccount[8]=="ADCONT"){
						echo "<td><input type='text' size='6' name='$debitValue' id='$debitValue' onblur='check2(this)' readonly></td>";
					}else{
						echo "<td><input type='text' size='6' name='$debitValue' id='$debitValue' onblur='check2(this)' STYLE=\"color: #000000; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #D3D3D3;\"></td>";
					}
				
				}else{
					echo "<td><input type='text' size='6' name='$debitValue' id='$debitValue' onblur='check2(this)' readonly></td>";
				}
				
				
				
				
				
				
				
				$creditValue = "credit|".$rowBalanceSheetAccount[7];
				if(($rowBalanceSheetAccount[1]==2000)||($rowBalanceSheetAccount[1]==3000)){
					//Liablity & Equity Credit Balance
					echo "<td><input type='text' size='6' name='$creditValue' id='$creditValue' onblur='check2(this)' STYLE=\"color: #000000; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #D3D3D3;\"></td>";
				}else{
					//Contra Asset accout Credit Balance
					if($rowBalanceSheetAccount[8]=="ADCONT"){
						echo "<td><input type='text' size='6' name='$creditValue' id='$creditValue' onblur='check2(this)' STYLE=\"color: #000000; font-family: Verdana; font-weight: bold; font-size: 12px; background-color: #D3D3D3;\"></td>";
					}else{
						
						echo "<td><input type='text' size='6' name='$creditValue' id='$creditValue' onblur='check2(this)' readonly></td>";
					
					}
					
					
					
					
					
					
					
				
				
				
				
				
				
				
				
				}
				echo "</tr>";
			}
			//bottom totals
			echo "<tr><td colspan='5' align='right'>Total</td>";
			echo "<td><input type='text' size='6' name='debitTotal' id='debitTotal' readonly></td>";
			echo "<td><input type='text' size='6' name='creditTotal' id='creditTotal' readonly></td></tr>";
			
			
			echo "<tr><td colspan='7' align='right'>";
			echo "<input type='hidden' name='openingBalanceDate' id='openingBalanceDate' value='$dateOpeningBalance'>";
			echo "<input type='hidden' name='accountingPeriodID' id='accountingPeriodID' value='$accountingPeriodIDvalue'>";
			
			echo "<input type='submit' name='Submit' id='Submit' value='Add Accounting Balance'>&nbsp;&nbsp;&nbsp;&nbsp;</td></tr>";
			echo "</table>";
		}
	}
?>
<table border="0" cellpadding="0" width="200">
<tr><td colspan="2"></td></tr>
<tr><td colspan="2"></td></tr>
</table>
</form>
</center>
</body>
</html>