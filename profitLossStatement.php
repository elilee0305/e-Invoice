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
			$totalRevenue = 0.00;
			$totalCOGS = 0.00;
			$totalOperatingExpense = 0.00;
			$totalNonOperatingExpense = 0.00;
			
			//initialize array
			$aProfitLossStatement = array();
			$h = 0;
			
			//get the REVENUE accounts
			$sqlRevenueAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_account1ID = 4)";
			
			$resultRevenueAccounts = mysqli_query($connection, $sqlRevenueAccounts) or die("error in revenue accounts query");
			
			if(mysqli_num_rows($resultRevenueAccounts) > 0){
				
				while($rowRevenueAccounts = mysqli_fetch_row($resultRevenueAccounts)){ 
				
					$revenueAccountName2 = $rowRevenueAccounts[0];
					$revenueAccountName3 = $rowRevenueAccounts[1];
					$revenueAccountID =  $rowRevenueAccounts[2];
					
					$aProfitLossStatement[$h][0] = $revenueAccountName2;
					$aProfitLossStatement[$h][1] = $revenueAccountName3;
					
					//REVENUE have CREDIT BALANCE
					$sqlCalculateRevenue = "SELECT SUM(account4_credit - account4_debit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$revenueAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$revenueAccountID'";
					
					$resultCalculateRevenue = mysqli_query($connection, $sqlCalculateRevenue) or die("error in calculate revenue query");
					$rowCalculateRevenue = mysqli_fetch_row($resultCalculateRevenue);
					
					if($rowCalculateRevenue === null){
						$aProfitLossStatement[$h][2] = 0.00;
					}else{
						$aProfitLossStatement[$h][2] = $rowCalculateRevenue[0];
						$totalRevenue = $totalRevenue + $rowCalculateRevenue[0];
					}
					
					$h = $h + 1;
				}
				
			}
			
			//Revenue totals
			$aProfitLossStatement[$h][0] = "Total Revenue";
			$aProfitLossStatement[$h][1] = "";
			$aProfitLossStatement[$h][2] = $totalRevenue;
			
			//get the COGS Account, HARD CODED = 5101
			$sqlCOGSaccount = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account3_number = 5101)";
			
			$resultCOGSaccount = mysqli_query($connection, $sqlCOGSaccount) or die("error in COGS accounts query");		
			$h = $h + 1;
			
			if(mysqli_num_rows($resultCOGSaccount) > 0){
				while($rowCOGSaccount = mysqli_fetch_row($resultCOGSaccount)){
					
					$cogsAccountName2 = $rowCOGSaccount[0];
					$cogsAccountName3 = $rowCOGSaccount[1];
					$cogsAccountID =  $rowCOGSaccount[2];
					
					$aProfitLossStatement[$h][0] = $cogsAccountName2;
					$aProfitLossStatement[$h][1] = $cogsAccountName3;
					
					//COGS has DEBIT balance, its under EXPENSE category
					$sqlCalculateCOGS = "SELECT SUM(account4_debit - account4_credit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$cogsAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$cogsAccountID'";
					
					$resultCalculateCOGS = mysqli_query($connection, $sqlCalculateCOGS) or die("error in calculate cogs query");
					$rowCalculateCOGS = mysqli_fetch_row($resultCalculateCOGS);
					
					if($rowCalculateCOGS === null){
						$aProfitLossStatement[$h][2] = 0.00;
					}else{
						$aProfitLossStatement[$h][2] = $rowCalculateCOGS[0];
						$totalCOGS = $totalCOGS + $rowCalculateCOGS[0];
					}
					
					$h = $h + 1;
					
				}
			}
			
			//COGS totals
			$aProfitLossStatement[$h][0] = "Total COGS";
			$aProfitLossStatement[$h][1] = "";
			$aProfitLossStatement[$h][2] = $totalCOGS;
			
			$h = $h + 1;
			//get the GROSS PROFIT
			//Revenue - COGS  = Gross Profit
			$grossProfit = $totalRevenue - $totalCOGS;
			
			$aProfitLossStatement[$h][0] = "Gross Profit";
			$aProfitLossStatement[$h][1] = "";
			$aProfitLossStatement[$h][2] = $grossProfit;
		
			//get the OPERATING EXPENSE Account, HARD CODE account2_number = 5200
			$sqlOperatingExpenseAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_number = 5200) ORDER BY account3_number ASC";
			
			
			$resultOperatingExpenseAccounts = mysqli_query($connection, $sqlOperatingExpenseAccounts) or die("error in operating expense accounts query");		
			$h = $h + 1;
			
			
			if(mysqli_num_rows($resultOperatingExpenseAccounts) > 0){
			
				while($rowOperatingExpenseAccount = mysqli_fetch_row($resultOperatingExpenseAccounts)){
					$operatingExpenseAccountName2 = $rowOperatingExpenseAccount[0];
					$operatingExpenseAccountName3 = $rowOperatingExpenseAccount[1];
					$operatingExpenseAccountID =  $rowOperatingExpenseAccount[2];
					
					$aProfitLossStatement[$h][0] = $operatingExpenseAccountName2;
					$aProfitLossStatement[$h][1] = $operatingExpenseAccountName3;
					
					//Operating Expense has DEBIT balance, its under EXPENSE category
					$sqlCalculateOperatingExpense = "SELECT SUM(account4_debit - account4_credit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$operatingExpenseAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$operatingExpenseAccountID'";
					
					$resultOperatingExpense = mysqli_query($connection, $sqlCalculateOperatingExpense) or die("error in calculate Operating Expense query");
					$rowCalculateOperatingExpense = mysqli_fetch_row($resultOperatingExpense);
					
					if($rowCalculateOperatingExpense === null){
						$aProfitLossStatement[$h][2] = 0.00;
					}else{
						$aProfitLossStatement[$h][2] = $rowCalculateOperatingExpense[0];
						$totalOperatingExpense = $totalOperatingExpense + $rowCalculateOperatingExpense[0];
					}
					
					$h = $h + 1;
					
				}
			}
		
			//OPERATING INCOME = GROSS PROFIT - OPERATING EXPENSE
			$operatingIncome = $grossProfit - $totalOperatingExpense;
			
			$aProfitLossStatement[$h][0] = "Operating Income";
			$aProfitLossStatement[$h][1] = "";
			$aProfitLossStatement[$h][2] = $operatingIncome;
			
			//get the NON OPERATING EXPENSE Account, HARD CODE account2_number = 5300
			$sqlNonOperatingExpenseAccounts = "SELECT account2_name, account3_name, account3_id FROM tbaccount2, tbaccount3 
			WHERE (account2_id = account3_account2ID) AND (account2_number = 5300) ORDER BY account3_number ASC";
			
			
			$resultNonOperatingExpenseAccounts = mysqli_query($connection, $sqlNonOperatingExpenseAccounts) or die("error in non operating expense accounts query");
			$h = $h + 1;
			
			if(mysqli_num_rows($resultNonOperatingExpenseAccounts) > 0){
				while($rowNonOperatingExpenseAccount = mysqli_fetch_row($resultNonOperatingExpenseAccounts)){
					$nonOperatingExpenseAccountName2 = $rowNonOperatingExpenseAccount[0];
					$nonOperatingExpenseAccountName3 = $rowNonOperatingExpenseAccount[1];
					$nonOperatingExpenseAccountID =  $rowNonOperatingExpenseAccount[2];
					
					$aProfitLossStatement[$h][0] = $nonOperatingExpenseAccountName2;
					$aProfitLossStatement[$h][1] = $nonOperatingExpenseAccountName3;
					
					//Non Operating Expense has DEBIT balance, its under EXPENSE category
					$sqlCalculateNonOperatingExpense = "SELECT SUM(account4_debit - account4_credit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$nonOperatingExpenseAccountID') AND (account4_date BETWEEN '$startDate' AND '$profitLossDateConverted') 
					GROUP BY '$nonOperatingExpenseAccountID'";
					
					$resultNonOperatingExpense = mysqli_query($connection, $sqlCalculateNonOperatingExpense) or die("error in calculate Non Operating Expense query");
					$rowCalculateNonOperatingExpense = mysqli_fetch_row($resultNonOperatingExpense);
					
					if($rowCalculateNonOperatingExpense === null){
						$aProfitLossStatement[$h][2] = 0.00;
					}else{
						$aProfitLossStatement[$h][2] = $rowCalculateNonOperatingExpense[0];
						$totalNonOperatingExpense = $totalNonOperatingExpense + $rowCalculateNonOperatingExpense[0];
					}
					
					$h = $h + 1;
					
				}
			}
			
			
			//NETT PROFIT = GROSS PROFIT - OPERATING EXPENSE
			$nettProfit = $grossProfit - $totalOperatingExpense - $totalNonOperatingExpense;
			
			$aProfitLossStatement[$h][0] = "Nett Profit";
			$aProfitLossStatement[$h][1] = "";
			$aProfitLossStatement[$h][2] = $nettProfit;
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
	font-size: 12px; /* Added font-size */
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
<tr height="40"><td align="left" colspan="2"><h1>Profit & Loss Statement</h1></td></tr>

<form action="profitLossStatement.php" method="post" >


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
	<input type="submit" name="Submit" id="Submit" value="Generate Profit & Loss">



</td></tr>
</table>

<?php 
	
	if(isset($_POST['Submit'])){
		
		if($dateStatus==2){
			echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";
			echo "<tr><td><strong>Account2</strong></td><td><strong>Account 3</strong></td><td><strong>Amount</strong></td></tr>";	
			$numOfRows = count($aProfitLossStatement);
			
			for($i = 0; $i < $numOfRows; $i++){
				echo "<tr class='notfirst'>";
				//loop through columns, get number of cols current row
				$numOfCols = count($aProfitLossStatement[$i]);
				
				for($j = 0; $j < $numOfCols; $j++){
					
					if($j==0||$j==1){
						echo "<td>";
						echo $aProfitLossStatement[$i][$j];
					}elseif($j==2){
						echo "<td align='right'>";
						echo number_format($aProfitLossStatement[$i][$j],2);
					}
					echo "</td>";
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