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
	$dateStatus = 0; //
	
	if(isset($_POST['Submit'])){
		
		$dateStatus = 1; //no accounting period
		//get the start date of this patricular accounting period range
		$profitLossDateConverted = convertMysqlDateFormat($_POST['profitLossDate']);
		$sqlStartDate = "SELECT accountingPeriod_dateStart FROM tbaccountingperiod 
		WHERE (accountingPeriod_dateStart <= '$profitLossDateConverted') AND (accountingPeriod_dateEnd >= '$profitLossDateConverted')";
		
		$resultStartDate = mysqli_query($connection, $sqlStartDate) or die("error in start date query");
		
		if(mysqli_num_rows($resultStartDate) > 0){
			$dateStatus = 2; //valid accounting period
			$rowStartDate = mysqli_fetch_row($resultStartDate);
			$startDate = $rowStartDate[0];
			$totalCurrentAsset = 0.00;
			$totalFixedAsset = 0.00;
			$totalFixedContraAsset = 0.00;
			$totalActualFixedAsset = 0.00;
			$totalAssets = 0.00;
			
			$totalCurrentLiabilities = 0.00;
			$totalNonCurrentLiabilities = 0.00;
			$totalLiabilities = 0.00;
			
			$totalEquity = 0.00;

			//initialize array
			$aBalanceSheet = array();
			$h = 0;
			
			//get the CURRENT ASSETS accounts
			$sqlCurrentAssetAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_number = 1100)";
			
			$resultCurrentAssetAccounts = mysqli_query($connection, $sqlCurrentAssetAccounts) or die("error in current asset accounts query");
			
			if(mysqli_num_rows($resultCurrentAssetAccounts) > 0){
				
				while($rowCurrentAssetAccounts = mysqli_fetch_row($resultCurrentAssetAccounts)){ 
				
					$currentAssetAccountName2 = $rowCurrentAssetAccounts[0];
					$currentAssetAccountName3 = $rowCurrentAssetAccounts[1];
					$currentAssetAccountID =  $rowCurrentAssetAccounts[2];
					
					$aBalanceSheet[$h][0] = $currentAssetAccountName2;
					$aBalanceSheet[$h][1] = $currentAssetAccountName3;
					
					//CURRENT ASSET have DEBIT BALANCE
					$sqlCalculateCurrentAsset = "SELECT SUM(account4_debit - account4_credit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$currentAssetAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$currentAssetAccountID'";
					
					$resultCalculateCurrentAsset = mysqli_query($connection, $sqlCalculateCurrentAsset) or die("error in calculate current asset query");
					$rowCalculateCurrentAsset = mysqli_fetch_row($resultCalculateCurrentAsset);
					
					if($rowCalculateCurrentAsset === null){
						$aBalanceSheet[$h][2] = 0.00;
					}else{
						$aBalanceSheet[$h][2] = $rowCalculateCurrentAsset[0];
						$totalCurrentAsset = $totalCurrentAsset + $rowCalculateCurrentAsset[0];
					}
					$aBalanceSheet[$h][3] = 0; //normal row
					$h = $h + 1;
				}
			}
			
			// Current Asset totals
			$aBalanceSheet[$h][0] = "Total Current Asset";
			$aBalanceSheet[$h][1] = "";
			$aBalanceSheet[$h][2] = $totalCurrentAsset;
			$aBalanceSheet[$h][3] = 1; //header
			
			
			//get the FIXED ASSETS accounts
			$sqlFixedAssetAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_number = 1200) AND (account3_accountNumber <> 'ADCONT')";
			
			$resultFixedAssetAccounts = mysqli_query($connection, $sqlFixedAssetAccounts) or die("error in fixed asset accounts query");
			$h = $h + 1;
			
			if(mysqli_num_rows($resultFixedAssetAccounts) > 0){
				
				while($rowFixedAssetAccounts = mysqli_fetch_row($resultFixedAssetAccounts)){ 
				
					$fixedAssetAccountName2 = $rowFixedAssetAccounts[0];
					$fixedAssetAccountName3 = $rowFixedAssetAccounts[1];
					$fixedAssetAccountID =  $rowFixedAssetAccounts[2];
					
					$aBalanceSheet[$h][0] = $fixedAssetAccountName2;
					$aBalanceSheet[$h][1] = $fixedAssetAccountName3;
					
					//FIXED ASSET have DEBIT BALANCE
					$sqlCalculateFixedAsset = "SELECT SUM(account4_debit - account4_credit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$fixedAssetAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$fixedAssetAccountID'";
					
					$resultCalculateFixedAsset = mysqli_query($connection, $sqlCalculateFixedAsset) or die("error in calculate fixed asset query");
					$rowCalculateFixedAsset = mysqli_fetch_row($resultCalculateFixedAsset);
					
					if($rowCalculateFixedAsset === null){
						$aBalanceSheet[$h][2] = 0.00;
					}else{
						$aBalanceSheet[$h][2] = $rowCalculateFixedAsset[0];
						$totalFixedAsset = $totalFixedAsset + $rowCalculateFixedAsset[0];
					}
					$aBalanceSheet[$h][3] = 0; //normal row
					$h = $h + 1;
				}
			}
			
			
			//get the FIXED ASSETS CONTRA accounts
			$sqlFixedContraAssetAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_number = 1200) AND (account3_accountNumber = 'ADCONT')";
			
			$resultFixedContraAssetAccounts = mysqli_query($connection, $sqlFixedContraAssetAccounts) or die("error in contra fixed asset accounts query");
			
			if(mysqli_num_rows($resultFixedContraAssetAccounts) > 0){
				
				while($rowFixedContraAssetAccounts = mysqli_fetch_row($resultFixedContraAssetAccounts)){ 
				
					$fixedContraAssetAccountName2 = $rowFixedContraAssetAccounts[0];
					$fixedContraAssetAccountName3 = $rowFixedContraAssetAccounts[1];
					$fixedContraAssetAccountID =  $rowFixedContraAssetAccounts[2];
					
					$aBalanceSheet[$h][0] = $fixedContraAssetAccountName2;
					$aBalanceSheet[$h][1] = $fixedContraAssetAccountName3;
					
					//CONTRA ASSET have CREDIT BALANCE
					$sqlCalculateFixedContraAsset = "SELECT SUM(account4_credit - account4_debit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$fixedContraAssetAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$fixedContraAssetAccountID'";
					
					$resultCalculateFixedContraAsset = mysqli_query($connection, $sqlCalculateFixedContraAsset) or die("error in calculate fixed contra asset query");
					$rowCalculateFixedContraAsset = mysqli_fetch_row($resultCalculateFixedContraAsset);
					
					if($rowCalculateFixedContraAsset === null){
						$aBalanceSheet[$h][2] = 0.00;
					}else{
						$aBalanceSheet[$h][2] = $rowCalculateFixedContraAsset[0];
						$totalFixedContraAsset = $totalFixedContraAsset + $rowCalculateFixedContraAsset[0];
					}
					$aBalanceSheet[$h][3] = 0; //normal row
					$h = $h + 1;
				}
			}
			
			$totalActualFixedAsset = $totalFixedAsset - $totalFixedContraAsset;
			
			// Fixed Asset totals
			$aBalanceSheet[$h][0] = "Total Fixed Asset";
			$aBalanceSheet[$h][1] = "";
			$aBalanceSheet[$h][2] = $totalActualFixedAsset;
			$aBalanceSheet[$h][3] = 1; //header
			
			$h = $h + 1;
			
			//TOTAL ASSETS
			$totalAssets = $totalCurrentAsset + $totalActualFixedAsset;
			$aBalanceSheet[$h][0] = "Total Assets";
			$aBalanceSheet[$h][1] = "";
			$aBalanceSheet[$h][2] = $totalAssets;
			$aBalanceSheet[$h][3] = 1; //header
			
			//get the CURRENT LIABILITIES accounts
			$sqlCurrentLiabilitiesAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_number = 2100)";
			
			$resultCurrentLiabilitiesAccounts = mysqli_query($connection, $sqlCurrentLiabilitiesAccounts) or die("error in current liability accounts query");
			$h = $h + 1;
			
			if(mysqli_num_rows($resultCurrentLiabilitiesAccounts) > 0){
				
				while($rowCurrentLiabilitiesAccounts = mysqli_fetch_row($resultCurrentLiabilitiesAccounts)){ 
				
					$currentLiabilitiesAccountName2 = $rowCurrentLiabilitiesAccounts[0];
					$currentLiabilitiesAccountName3 = $rowCurrentLiabilitiesAccounts[1];
					$currentLiabilitiesAccountID =  $rowCurrentLiabilitiesAccounts[2];
					
					$aBalanceSheet[$h][0] = $currentLiabilitiesAccountName2;
					$aBalanceSheet[$h][1] = $currentLiabilitiesAccountName3;
					
					//LIABILITIES have CREDIT BALANCE
					$sqlCalculateCurrentLiabilities = "SELECT SUM(account4_credit - account4_debit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$currentLiabilitiesAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$currentLiabilitiesAccountID'";
					
					$resultCalculateCurrentLiabilities = mysqli_query($connection, $sqlCalculateCurrentLiabilities) or die("error in calculate current liabilities query");
					$rowCalculateCurrentLiabilities = mysqli_fetch_row($resultCalculateCurrentLiabilities);
					
					if($rowCalculateCurrentLiabilities === null){
						$aBalanceSheet[$h][2] = 0.00;
					}else{
						$aBalanceSheet[$h][2] = $rowCalculateCurrentLiabilities[0];
						$totalCurrentLiabilities = $totalCurrentLiabilities + $rowCalculateCurrentLiabilities[0];
					}
					$aBalanceSheet[$h][3] = 0; //normal row
					$h = $h + 1;
				}
			}
			
			// Current LIABILITIES totals
			$aBalanceSheet[$h][0] = "Total Current Liabilities";
			$aBalanceSheet[$h][1] = "";
			$aBalanceSheet[$h][2] = $totalCurrentLiabilities;
			$aBalanceSheet[$h][3] = 1; //header
			$h = $h + 1;
			
			//get the NON-CURRENT LIABILITIES accounts
			$sqlNonCurrentLiabilitiesAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_number = 2200)";
			
			$resultNonCurrentLiabilitiesAccounts = mysqli_query($connection, $sqlNonCurrentLiabilitiesAccounts) or die("error in non current liability accounts query");
			
			if(mysqli_num_rows($resultNonCurrentLiabilitiesAccounts) > 0){
				//THIS ACCOUNT MIGHT NOT EXIST FOR MOST CUSTOMERS
				
				
				while($rowNonCurrentLiabilitiesAccounts = mysqli_fetch_row($resultNonCurrentLiabilitiesAccounts)){
					
					$currentNonLiabilitiesAccountName2 = $rowNonCurrentLiabilitiesAccounts[0];
					$currentNonLiabilitiesAccountName3 = $rowNonCurrentLiabilitiesAccounts[1];
					$currentNonLiabilitiesAccountID =  $rowNonCurrentLiabilitiesAccounts[2];
					
					$aBalanceSheet[$h][0] = $currentNonLiabilitiesAccountName2;
					$aBalanceSheet[$h][1] = $currentNonLiabilitiesAccountName3;
					
					//LIABILITIES have CREDIT BALANCE
					$sqlCalculateNonCurrentLiabilities = "SELECT SUM(account4_credit - account4_debit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$currentNonLiabilitiesAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$currentNonLiabilitiesAccountID'";
					
					$resultCalculateNonCurrentLiabilities = mysqli_query($connection, $sqlCalculateNonCurrentLiabilities) or die("error in calculate current liabilities query");
					$rowCalculateNonCurrentLiabilities = mysqli_fetch_row($resultCalculateNonCurrentLiabilities);
					
					if($rowCalculateNonCurrentLiabilities === null){
						$aBalanceSheet[$h][2] = 0.00;
					}else{
						$aBalanceSheet[$h][2] = $rowCalculateNonCurrentLiabilities[0];
						$totalNonCurrentLiabilities = $totalNonCurrentLiabilities + $rowCalculateNonCurrentLiabilities[0];
					}
					$aBalanceSheet[$h][3] = 0; //normal row
					$h = $h + 1;
				}
				
				// Non Current LIABILITIES totals
				$aBalanceSheet[$h][0] = "Total Non Current Liabilities";
				$aBalanceSheet[$h][1] = "";
				$aBalanceSheet[$h][2] = $totalNonCurrentLiabilities;
				$aBalanceSheet[$h][3] = 1; //header
				$h = $h + 1;
				
			}
			
			//TOTAL LIABILITIES
			$totalLiabilities = $totalCurrentLiabilities + $totalNonCurrentLiabilities;
			$aBalanceSheet[$h][0] = "Total Liabilities";
			$aBalanceSheet[$h][1] = "";
			$aBalanceSheet[$h][2] = $totalLiabilities;
			$aBalanceSheet[$h][3] = 1; //header
			$h = $h + 1;
			
			
			//get the EQUITY accounts
			$sqlEquityAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_number = 3100)";
			
			$resultEquityAccounts = mysqli_query($connection, $sqlEquityAccounts) or die("error in equity accounts query");
			
			if(mysqli_num_rows($resultEquityAccounts) > 0){
				
				while($rowEquityAccounts = mysqli_fetch_row($resultEquityAccounts)){ 
				
					$equityAccountName2 = $rowEquityAccounts[0];
					$equityAccountName3 = $rowEquityAccounts[1];
					$equityAccountID =  $rowEquityAccounts[2];
					
					$aBalanceSheet[$h][0] = $equityAccountName2;
					$aBalanceSheet[$h][1] = $equityAccountName3;
					
					//EQUITY have CREDIT BALANCE
					$sqlCalculateEquity = "SELECT SUM(account4_credit - account4_debit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$equityAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$equityAccountID'";
					
					$resultCalculateEquity = mysqli_query($connection, $sqlCalculateEquity) or die("error in calculate equity query");
					$rowCalculateEquity = mysqli_fetch_row($resultCalculateEquity);
					
					if($rowCalculateEquity === null){
						$aBalanceSheet[$h][2] = 0.00;
					}else{
						$aBalanceSheet[$h][2] = $rowCalculateEquity[0];
						$totalEquity = $totalEquity + $rowCalculateEquity[0];
					}
					$aBalanceSheet[$h][3] = 0; //normal row
					$h = $h + 1;
				}
			}
			
			// EQUITY totals
			$aBalanceSheet[$h][0] = "Total Equities";
			$aBalanceSheet[$h][1] = "";
			$aBalanceSheet[$h][2] = $totalEquity;
			$aBalanceSheet[$h][3] = 1; //header
			$h = $h + 1;
		
		}
	}
?>

<html>
<head>
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<link href="js/textAreaStyle.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>


<script>
	
	
	$( function() {
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
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
	background-color: DE99A1;
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
<table width="800" border="0" cellpadding="0" align="center">
<tr height="40"><td align="left" colspan="2"><h1>Balance Sheet</h1></td></tr>

<form action="balanceSheet.php" method="post" >

<tr height="30px"><td align="right">
<?php if($dateStatus==1){
	echo "<font style=\"color:red;\">Invalid Accounting Period</font>";
	
}?>

</td><td align="right" valign="top">


	<input id="demo2" type="text" name="profitLossDate" size="10" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['profitLossDate'];
	}else{
		echo date('d/m/Y');
	
		
	}?>">
	&nbsp;    
	&nbsp;&nbsp;
	<input type="submit" name="Submit" id="Submit" value="Generate Balance Sheet">

</td></tr>
</table>

<?php 
	
	if(isset($_POST['Submit'])){
		
		if($dateStatus==2){
			echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";
			echo "<tr><td><strong>Account2</strong></td><td><strong>Account 3</strong></td><td><strong>Amount</strong></td></tr>";	
			$numOfRows = count($aBalanceSheet);
			
			for($i = 0; $i < $numOfRows; $i++){
				echo "<tr class='notfirst'>";
				//loop through columns, get number of cols current row
				$numOfCols = count($aBalanceSheet[$i]);
				
				for($j = 0; $j < $numOfCols - 1; $j++){
					if($aBalanceSheet[$i][3]==1){
						if($j==0||$j==1){
							echo "<td bgcolor='#b6deb4'><p style=\"font-size:12px\">";
							echo $aBalanceSheet[$i][$j];					
						}elseif($j==2){
							echo "<td bgcolor='#b6deb4' align='right'><p style=\"font-size:12px\">";
							echo number_format($aBalanceSheet[$i][$j],2);
						}
						echo "</p></td>";
					}else{
						
						if($j==0||$j==1){
							echo "<td><p style=\"font-size:12px\">";
							echo $aBalanceSheet[$i][$j];					
						}elseif($j==2){
							echo "<td align='right'><p style=\"font-size:12px\">";
							echo number_format($aBalanceSheet[$i][$j],2);
						
						}
						
						
						
						
						
						echo "</p></td>";
					}					
					
				}
				
				echo "</tr>";
			}
			
			echo "</table>";	
	
		}else{
			echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";
			echo "<tr><td><strong>Account2</strong></td><td><strong>Account 3</strong></td><td><strong>Amount</strong></td></tr>";
			echo "</table>";
		}
	}else{
		echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";
		echo "<tr><td><strong>Account 2</strong></td><td><strong>Account 3</strong></td><td><strong>Amount</strong></td></tr>";
		echo "</table>";
	}
?>

</form>
</center>
</body>
</html>