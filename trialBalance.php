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
		$trialBalanceDateConverted = convertMysqlDateFormat($_POST['trialBalanceDate']);
		$sqlStartDate = "SELECT accountingPeriod_dateStart FROM tbaccountingperiod 
		WHERE (accountingPeriod_dateStart <= '$trialBalanceDateConverted') AND (accountingPeriod_dateEnd >= '$trialBalanceDateConverted')";
		
		$resultStartDate = mysqli_query($connection, $sqlStartDate) or die("error in start date query");
		
		if(mysqli_num_rows($resultStartDate) > 0){
			$dateStatus = 2; //valid accounting period
			$rowStartDate = mysqli_fetch_row($resultStartDate);
			$startDate = $rowStartDate[0];
		
			//get the list of accounts	
			$sqlChartOfAccount = "SELECT account1_number, account2_name, account3_name, account3_number, account3_id, account3_accountNumber
			FROM tbaccount1, tbaccount2, tbaccount3  WHERE  (account1_id = account2_account1ID) 
			AND (account2_id = account3_account2ID)	ORDER BY account1_number ASC, account2_number ASC, account3_number ASC";
			
			$resultChartOfAccount = mysqli_query($connection, $sqlChartOfAccount) or die("error in chart of account query");

			//initialize array
			$aTrialBalanceCalculate = array();
			$h = 0;
			while($rowChartOfAccount = mysqli_fetch_row($resultChartOfAccount)){
				$account3ID = $rowChartOfAccount[4];
				$accountMainType = $rowChartOfAccount[0]; //to check balance type credit or debit
				$accountName = $rowChartOfAccount[2];
				$accountContraAsset = $rowChartOfAccount[5];
				//check for contra asset account
				
				
				
				
				
				if(($accountMainType == 1000) || ($accountMainType == 5000)){
					//asset & expense have debit balance
					//contra asset account have credit balance account3_accountNumber = ADCONT
					
					if($accountContraAsset=="ADCONT"){
						//CONTRA ASSET
						$sqlTrialBalanceCalculate = "SELECT SUM(account4_credit - account4_debit) AS BalanceNow FROM tbaccount4 
						WHERE (account4_account3ID = '$account3ID') AND (account4_date BETWEEN '$startDate' AND '$trialBalanceDateConverted') 
						GROUP BY '$account3ID'";	
					
					
					}else{
						$sqlTrialBalanceCalculate = "SELECT SUM(account4_debit - account4_credit) AS BalanceNow FROM tbaccount4 
						WHERE (account4_account3ID = '$account3ID') AND (account4_date BETWEEN '$startDate' AND '$trialBalanceDateConverted') 
						GROUP BY '$account3ID'";						
					}
				
				}else{
					//liability, capital & revenue have credit balance
					$sqlTrialBalanceCalculate = "SELECT SUM(account4_credit - account4_debit) AS BalanceNow FROM tbaccount4 
					WHERE (account4_account3ID = '$account3ID') AND (account4_date BETWEEN '$startDate' AND '$trialBalanceDateConverted') 
					GROUP BY '$account3ID'";
				}
				
				$resultTrialBalanceCalculate = mysqli_query($connection, $sqlTrialBalanceCalculate) or die("error in trial balance calculate query");
				
				if(($accountMainType == 1000) || ($accountMainType == 5000)){				
					//asset & expense have debit balance
					//contra asset account have credit balance account3_accountNumber = ADCONT							
					$rowTrialBalanceCalculate = mysqli_fetch_row($resultTrialBalanceCalculate);
					$aTrialBalanceCalculate[$h][0] = $accountName;
						
					if($rowTrialBalanceCalculate === null){
						$aTrialBalanceCalculate[$h][1] = 0.00;	//debit		
						$aTrialBalanceCalculate[$h][2] = 0.00;	//credit	
					}elseif($rowTrialBalanceCalculate[0] >= 0){
						//positive						
						if($accountContraAsset=="ADCONT"){
							$aTrialBalanceCalculate[$h][1] = 0.00;//debit
							$aTrialBalanceCalculate[$h][2] = $rowTrialBalanceCalculate[0];	//credit
						}else{
							$aTrialBalanceCalculate[$h][1] = $rowTrialBalanceCalculate[0];	//debit		
							$aTrialBalanceCalculate[$h][2] = 0.00;//credit
						}
					
					}elseif($rowTrialBalanceCalculate[0] < 0){
						//negative
						if($accountContraAsset=="ADCONT"){
							$aTrialBalanceCalculate[$h][1] = abs($rowTrialBalanceCalculate[0]);//debit
							$aTrialBalanceCalculate[$h][2] = 0.00;	//credit
						
						}else{
						
							$aTrialBalanceCalculate[$h][1] = 0.00;	//debit		
							$aTrialBalanceCalculate[$h][2] = abs($rowTrialBalanceCalculate[0]);//credit
						}
					}
					
				}else{
					//liability, capital & revenue have credit balance
					$rowTrialBalanceCalculate = mysqli_fetch_row($resultTrialBalanceCalculate);
					$aTrialBalanceCalculate[$h][0] = $accountName;
					
					if($rowTrialBalanceCalculate === null){
						$aTrialBalanceCalculate[$h][1] = 0.00;	//debit		
						$aTrialBalanceCalculate[$h][2] = 0.00;	//credit	
					}elseif($rowTrialBalanceCalculate[0] >= 0){
						//positive
						$aTrialBalanceCalculate[$h][1] = 0.00;	//debit		
						$aTrialBalanceCalculate[$h][2] = $rowTrialBalanceCalculate[0];//credit
						
					}elseif($rowTrialBalanceCalculate[0] < 0){
						//negative
						$aTrialBalanceCalculate[$h][1] = abs($rowTrialBalanceCalculate[0]);	//debit		
						$aTrialBalanceCalculate[$h][2] = 0.00;//credit
					}
				}
				
				$h = $h + 1;
			}
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
<tr height="40"><td align="left" colspan="2"><h1>Trial Balance</h1></td></tr>

<form action="trialBalance.php" method="post" >


<tr height="30px"><td align="right">
<?php if($dateStatus==1){
	echo "<font style=\"color:red;\">Invalid Accounting Period</font>";
	
}?>

</td><td align="right" valign="top">


	<input id="demo2" type="text" name="trialBalanceDate" size="10" readonly value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['trialBalanceDate'];
	}else{
		echo date('d/m/Y');
	
		
	}?>">
	&nbsp;
	&nbsp;&nbsp;
	<input type="submit" name="Submit" id="Submit" value="Generate Trial Balance">



</td></tr>
</table>

<?php 
	
	if(isset($_POST['Submit'])){
		if($dateStatus==2){
				if(mysqli_num_rows($resultChartOfAccount) > 0){
					echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";
					echo "<tr><td><strong>Account</strong></td><td><strong>Debit</strong></td><td><strong>Credit</strong></td></tr>";
					
					//echo json_encode($aTrialBalanceCalculate);
					$numOfRows = count($aTrialBalanceCalculate);
					$totalDebit = 0.00;
					$totalCredit = 0.00;
					//loop through rows
					for($i = 0; $i < $numOfRows; $i++){
						echo "<tr class='notfirst'>";
						//loop through columns, get number of cols current row
						$numOfCols = count($aTrialBalanceCalculate[$i]);
						for($j = 0; $j < $numOfCols; $j++){
							
							
							if($j==0){
								echo "<td>";
								echo $aTrialBalanceCalculate[$i][$j];
							}elseif($j==1||$j==2){
								echo "<td align='right'>";
								echo number_format($aTrialBalanceCalculate[$i][$j],2);
							}
							echo "</td>";
						}
						$totalDebit = $totalDebit + $aTrialBalanceCalculate[$i][1];
						$totalCredit = $totalCredit + $aTrialBalanceCalculate[$i][2];
						echo "</tr>";
					}
					echo "<tr bgcolor='#cbcecb'>";
					echo "<td>Total</td>";
					echo "<td align='right'>".number_format($totalDebit,2)."</td>";
					echo "<td align='right'>".number_format($totalCredit,2)."</td>";
					echo "</tr>";
					echo "</table>";
				
				}else{
					echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";
					echo "<tr><td><strong>Account</strong></td><td><strong>Debit</strong></td><td><strong>Credit</strong></td></tr>";
					echo "</table>";
				}
	
		}else{
			echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";
			echo "<tr><td><strong>Account</strong></td><td><strong>Debit</strong></td><td><strong>Credit</strong></td></tr>";
			echo "</table>";
			
		}
		
	
	}else{
		echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";
		echo "<tr><td><strong>Account</strong></td><td><strong>Debit</strong></td><td><strong>Credit</strong></td></tr>";
		echo "</table>";
	}

?>
<br><br>
</form>




</center>

</body>

</html>