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
	include ('makeSafe.php');
	//create new tax rate
	if(isset($_POST['Submit'])){
		$taxCode = makeSafe($_POST['taxCode']);
		$taxDescription = makeSafe($_POST['taxDescription']);
		$taxRate = makeSafe($_POST['taxRate']);
		$taxDefault = 0;		
		
		$sqlCreateTaxCode = "INSERT INTO tbtaxrate(taxRate_id, taxRate_code, taxRate_rate, taxRate_description, taxRate_default) 
		VALUES(NULL, '$taxCode', '$taxRate', '$taxDescription', '$taxDefault')";
		$result = mysqli_query($connection, $sqlCreateTaxCode) or die("error in create tax code"); 
		
		
		
	}	
	
	
	
	//get the projects
	$sqlTaxRate = "SELECT taxRate_code, taxRate_description, taxRate_rate FROM tbtaxrate ORDER BY taxRate_default DESC";
	$resultTaxRate = mysqli_query($connection, $sqlTaxRate) or die("error in tax rate query");

?>

<html>
<head>

<title>Online Imes System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script>
function CheckAndSubmit(){
	var taxCode = document.getElementById("taxCode");
	if(taxCode.value.length==0){
		alert("Must enter Tax Code!");
		taxCode.focus();
		return false;
	}
	
	
	if(isNaN(document.getElementById('taxRate').value)){
		alert("Must enter Numeric Tax Rate!");
		taxRate.focus();
		return false;
	}else{
		if(document.getElementById('taxRate').value == ""){
			alert("Must enter Tax Rate!");
			taxRate.focus();
			return false;
		}
		
	}	
	
	var r = confirm("Do you want to create this Tax Rate?");
	if(r==false){
		return false;
	}
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
	font-size: 13px; /* Added font-size */
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
	<?php include 'menuPHPImes.php';?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>



<table border="0" cellpadding="0" width="800"><tr height="30"><td>&nbsp;</td></tr></table>
<table width="600" border="0" cellpadding="0" align="center"><tr height="40"><td align="left"><h1>Tax Rate Database</h1></td></tr></table>

<?php 
	if(mysqli_num_rows($resultTaxRate) > 0){
		$numOfTaxRate = mysqli_num_rows($resultTaxRate);
		
		echo "<table width='500' cellpadding='0' border='1' class='mystyle'>";
		echo "<tr bgcolor='9cc1c7'><td colspan='3'>Tax Rate List [".$numOfTaxRate."] records</td></tr>";
		echo "<tr><td><strong>Tax Code</strong></td><td><strong>Descsition</strong></td><td><strong>Tax Rate</strong></td></tr>";
		while($rowTaxRate = mysqli_fetch_row($resultTaxRate)){
			echo "<tr class='notfirst'>";
			echo "<td>$rowTaxRate[0]</td>";
			echo "<td>$rowTaxRate[1]</td>";
			echo "<td>$rowTaxRate[2]</td>";
						
			echo "</tr>";
		}

		echo "</table>";
	}
?>
<table border="0" cellpadding="0" width="500"><tr height="20"><td>&nbsp;</td></tr></table>
<form id="projectForm" action="createTaxRate.php" method="POST" onsubmit="return CheckAndSubmit()">
<table width="500" cellpadding="0" border="1" class="mystyle">
<tr bgcolor="9cc1c7"><td colspan="2">Create New Tax Rate</td></tr>
<tr><td>Tax Code</td><td><input type="text" name="taxCode" id="taxCode" maxLength="10" size="15"><img src="images/redmark.png"></td></tr>
<tr><td>Tax Description</td><td><input type="text" name="taxDescription" id="taxDescription" maxLength="100" size="40"></td></tr>
<tr><td>Tax Rate</td><td><input type="text" name="taxRate" id="taxRate" maxLength="10" size="15"></td></tr>
<tr><td colspan="2" align="right"><input type="submit" name="Submit" value="New Tax Rate"></td></tr>

</table>
</form>


<table border="0" cellpadding="0" width="500"><tr height="20"><td>&nbsp;</td></tr></table>

</center>
</body>

</html>