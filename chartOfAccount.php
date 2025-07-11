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
	
	//get all the chartOfAccount list and put inside array
	$aChartOfAccountData = array();
	$aChartOfAccountDataDB = array();//hold the list to prevent multiple queries
	
	//get the chartOfAccount table data
	$sqlChartOfAccountData = "SELECT chartAccount_id, chartAccount_name FROM tbchartaccount ORDER BY chartAccount_id ASC";
	$resultChartOfAccountData =  mysqli_query($connection, $sqlChartOfAccountData) or die("error in chart of account data query");
	$r = 0;
	
	while($rowChartOfAccountData = mysqli_fetch_array($resultChartOfAccountData)){
		$aChartOfAccountData[] = $rowChartOfAccountData[0];
		$aChartOfAccountDataDB[$r][0] = $rowChartOfAccountData[0];
		$aChartOfAccountDataDB[$r][1] = $rowChartOfAccountData[1];
		$r = $r + 1;		
	}
	
	//get the chart of accounts	
	$sqlChartOfAccount = "SELECT account1_name, account1_number, account1_chartAccountID, account2_name, account2_number, 
	account3_name, account3_number FROM tbaccount1 LEFT JOIN tbaccount2 ON  (account1_id = account2_account1ID) 
	LEFT JOIN tbaccount3 ON (account2_id = account3_account2ID)
	ORDER BY account1_number ASC, account2_number ASC, account3_number ASC";
	
	$resultChartOfAccount = mysqli_query($connection, $sqlChartOfAccount) or die("error in chart of account query");

	// php function to search multi-dimensional array
	function searchArray($key, $st, $array) {
	   foreach ($array as $k => $v) {
		   if ($v[$key] === $st) {
			   return $k;
		   }
	   }
	   return null;
	}


?>

<html>
<head>
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
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
<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left"><h1>Chart Of Accounts</h1></td></tr></table>

<?php 
	
	
	if(mysqli_num_rows($resultChartOfAccount) > 0){
		echo "<table width='900' cellpadding='0' border='1' class='mystyle'>";
		echo "<tr><td><strong>Acc Type</strong></td><td><strong>Sub Account</strong></td><td><strong>Number</strong></td><td><strong>Account</strong></td><td><strong>Statement</strong></td></tr>";

		while($rowChartOfAccount = mysqli_fetch_row($resultChartOfAccount)){
			echo "<tr class='notfirst'>";
			echo "<td><p style=\"font-size:12px\">$rowChartOfAccount[0]</p></td>";
			echo "<td><p style=\"font-size:12px\">$rowChartOfAccount[3]</p></td>";
			echo "<td><p style=\"font-size:12px\">$rowChartOfAccount[6]</p></td>";
			
			echo "<td><p style=\"font-size:12px\">$rowChartOfAccount[5]</p></td>";
			//account document
			$chartOfAccountID = $rowChartOfAccount[2];
			$arrayTest = searchArray(0, $chartOfAccountID, $aChartOfAccountDataDB);
			$chartOfAccountName = $aChartOfAccountDataDB[$arrayTest][1];
			
			echo "<td><p style=\"font-size:12px\">$chartOfAccountName</p></td>";
						
			echo "</tr>";
		}

		echo "</table>";
	}

?>






<form action="home.php" method="post">
<table border="0" cellpadding="0" width="200">
<tr><td colspan="2"></td></tr>

<tr><td></td><td></td></tr>

<tr><td colspan="2">

</td></tr>

</table>

</form>





</center>

</body>

</html>