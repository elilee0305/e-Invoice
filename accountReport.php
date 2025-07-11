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
	
	$sqlGetAccount1 = "SELECT account1_id, account1_name FROM tbaccount1 ORDER BY account1_number ASC";
	$resultGetAccount1 = mysqli_query($connection, $sqlGetAccount1) or die("error in get account1 query");
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$accountDate1Converted = convertMysqlDateFormat($_POST['accountDate1']);
		$accountDate2Converted = convertMysqlDateFormat($_POST['accountDate2']);
		
		$account1 = $_POST['account1'];
		$account2 = $_POST['account2'];
		$account3 = $_POST['account3'];
		
		$sqlGetAccount2 = "SELECT account2_id, account2_name FROM tbaccount2 WHERE account2_account1ID = '$account1' ORDER BY account2_number ASC";
		$resultGetAccount2 = mysqli_query($connection, $sqlGetAccount2) or die("error in get account2 query");
		
		$sqlGetAccount3 = "SELECT account3_id, account3_name FROM tbaccount3 WHERE account3_account2ID = '$account2' ORDER BY account3_number ASC";
		$resultGetAccount3 = mysqli_query($connection, $sqlGetAccount3) or die("error in get account3 query");
		
		$sqlGetAccount4 = "SELECT account4_date, account4_reference, account4_description, account4_debit, account4_credit 
		FROM tbaccount4 WHERE (account4_account3ID = '$account3') AND (account4_date BETWEEN '$accountDate1Converted' AND '$accountDate2Converted') 
		ORDER BY account4_date ASC, account4_sort ASC, account4_id ASC";	
		$resultGetAccount4 = mysqli_query($connection, $sqlGetAccount4) or die("error in get account4 query");
		
	}else{
		//get the ALL DEFAULT accounts
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$accountDate1Converted = date("Y-m-01", strtotime($dt));
		$accountDate2Converted = date("Y-m-t", strtotime($dt));	
		
		$sqlGetAccount2 = "SELECT account2_id, account2_name FROM tbaccount2 WHERE account2_account1ID = 1 ORDER BY account2_number ASC";
		$resultGetAccount2 = mysqli_query($connection, $sqlGetAccount2) or die("error in get account2 query");
		
		$sqlGetAccount3 = "SELECT account3_id, account3_name FROM tbaccount3 WHERE account3_account2ID = 1 ORDER BY account3_number ASC";
		$resultGetAccount3 = mysqli_query($connection, $sqlGetAccount3) or die("error in get account3 query");
		$firstAccount3value = mysqli_fetch_assoc($resultGetAccount3);
		$firtAccount3ColumnValue = $firstAccount3value['account3_id'];
		
		//reset the resultGetAccount3 
		mysqli_data_seek($resultGetAccount3, 0);
		
		$sqlGetAccount4 = "SELECT account4_date, account4_reference, account4_description, account4_debit, account4_credit 
		FROM tbaccount4 WHERE (account4_account3ID = '$firtAccount3ColumnValue') AND (account4_date BETWEEN '$accountDate1Converted' AND '$accountDate2Converted') 
		ORDER BY account4_date ASC, account4_sort ASC, account4_id ASC";	
		$resultGetAccount4 = mysqli_query($connection, $sqlGetAccount4) or die("error in get account4 query");
		
		
	}
?>

<html>
<head>
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	$( function() {
		$( "#demo1" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
	
	$( function() {
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
</script>
<script>
	function GetAccount1Name(x){
		document.getElementById("account1NameValue").value = x.options[x.selectedIndex].text;
		
		//if this change then second drop down and third drop down list must change			
		var data1 = "account1ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=3"; // no side
		data1 = data1 + data2;
		
		$.ajax({
			type : 'POST',
			url : 'checkAccount2.php',
			data : data1,
			dataType : 'text',
			success : function(r)
			{ 
				var response = r.split(",");
				
				if(response[0]=="0"){					
					document.getElementById("account2").disabled = true;
					document.getElementById("account3").disabled = true;
					document.getElementById("Submit").disabled = true;					
				}else{					
					
					if(response[1]==0){
						document.getElementById("account3").disabled = true;
						document.getElementById("Submit").disabled = true;
						$("#locationAccount2").html(response[0]);
					}else{
						document.getElementById("account2").disabled = false;
						document.getElementById("account3").disabled = false;
						document.getElementById("Submit").disabled = false;					
						$("#locationAccount2").html(response[0]);
						$("#locationAccount3").html(response[1]);
				
					}
				}
			}
		}
		)
	}

	function GetAccount2Name(x){		
		
		document.getElementById("account2NameValue").value = x.options[x.selectedIndex].text;
		//if this change then third drop down list must change			
		var data1 = "account2ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=3"; // no side
		data1 = data1 + data2;
		
		$.ajax({
			type : 'POST',
			url : 'checkAccount3.php',
			data : data1,
			dataType : 'text',
			success : function(t){
				if(t=="0"){
					document.getElementById("account3").disabled = true;
					document.getElementById("Submit").disabled = true;
				}else{
					//document.getElementById("account2").disabled = false;
					document.getElementById("account3").disabled = false;
					document.getElementById("Submit").disabled = false;					
					$("#locationAccount3").html(t);
					
				}
			}
			
		})
		
	}
	
	function GetAccount3Name(x){
		document.getElementById("account3NameValue").value = x.options[x.selectedIndex].text;
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
select:focus
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
<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left"><h1>Accounts Report</h1></td></tr></table>
<!--search row-->
<table width="900" border="0" cellpadding="0" align="center">
<tr><td></td></tr>
</table>

<form action="accountReport.php" method="post">
<table border="0" cellpadding="0" width="900">
<tr bgcolor="eff5b8"><td>
<?php 

	if(mysqli_num_rows($resultGetAccount1)>0){
		echo "<select name='account1' id='account1' size='1' onchange=\"GetAccount1Name(this)\">";	
		
		if(isset($_POST['Submit'])){
			$account1Name = $_POST['account1NameValue'];
			$account1Value = $_POST['account1'];
			echo "<option value='$account1Value'>$account1Name</option>";
		}
		$countAccount1 = 0;
		
		while($rowGetAccount1 = mysqli_fetch_array($resultGetAccount1)){
			echo "<option value='$rowGetAccount1[0]'>$rowGetAccount1[1]</option>";
			if(isset($_POST['Submit'])){
				//nothing
			}else{
				if($countAccount1==0){
					$account1Name = $rowGetAccount1[1];
				}
			}
			$countAccount1 = $countAccount1 + 1; 
		}		
		echo "</select>";
		echo "<input type='hidden' name='account1NameValue' id='account1NameValue' value='$account1Name'>";
	}
	
	
	echo "&nbsp;&nbsp;";
	echo "<span id='locationAccount2'>";
	if(mysqli_num_rows($resultGetAccount2)>0){
		
		echo "<select name='account2' id='account2' size='1' onchange=\"GetAccount2Name(this)\">";
		if(isset($_POST['Submit'])){
			$account2Name = $_POST['account2NameValue'];
			$account2Value = $_POST['account2'];
			echo "<option value='$account2Value'>$account2Name</option>";
		}
		$countAccount2 = 0;
		
		while($rowGetAccount2 = mysqli_fetch_array($resultGetAccount2)){
			echo "<option value='$rowGetAccount2[0]'>$rowGetAccount2[1]</option>";
			if(isset($_POST['Submit'])){
				//nothing
			}else{
				if($countAccount2==0){
					$account2Name = $rowGetAccount2[1];
				}
			}
			$countAccount2 = $countAccount2 + 1;
		}		
		echo "</select>";
		echo "<input type='hidden' name='account2NameValue' id='account2NameValue' value='$account2Name'>";
		
	}
	echo "</span>";
	echo "&nbsp;&nbsp;";
	echo "<span id='locationAccount3'>";
	if(mysqli_num_rows($resultGetAccount3)>0){
		echo "<select name='account3' id='account3' size='1' onchange=\"GetAccount3Name(this)\">";
		if(isset($_POST['Submit'])){
			$account3Name = $_POST['account3NameValue'];
			$account3Value = $_POST['account3'];
			echo "<option value='$account3Value'>$account3Name</option>";
		}
		$countAccount3 = 0;
		while($rowGetAccount3 = mysqli_fetch_array($resultGetAccount3)){
			echo "<option value='$rowGetAccount3[0]'>$rowGetAccount3[1]</option>";
			if(isset($_POST['Submit'])){
				//nothing
			}else{
				if($countAccount3==0){
					$account3Name = $rowGetAccount3[1];
				}
			}
			$countAccount3 = $countAccount3 + 1;
		}		
		echo "</select>";
	
		echo "<input type='hidden' name='account3NameValue' id='account3NameValue' value='$account3Name'>";
	
	}
	echo "</span>";
	echo "&nbsp;&nbsp;";

?>


<input id="demo1" type="text" name="accountDate1" size="7" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['accountDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
		
	}?>">&nbsp;

&nbsp;TO&nbsp;

<input id="demo2" type="text" name="accountDate2" size="7" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['accountDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;

&nbsp;&nbsp;
<input type="submit" name="Submit" id="Submit" value="Search Accounts">
</td><td></td></tr>

<tr><td></td><td></td></tr>

<tr><td></td><td></td></tr>

</table>

<table width="900" cellpadding="0" border="0"><tr><td><?php echo $account3Name;?></td></tr><table>

<?php 

	if(mysqli_num_rows($resultGetAccount4) > 0){
		
		echo "<table width='900' cellpadding='0' border='1' class='mystyle'>";		
		echo "<tr bgcolor='#EAEAEA'><td style='width:130'><b>Date</b></td><td style='width:520'><b>Description</b></td><td style='width:100'><b>Debit</b></td><td style='width:150'><b>Credit</b></td></tr>";
		while($rowGetAccount4 = mysqli_fetch_row($resultGetAccount4)){
			echo "<tr class='notfirst'>";
			echo "<td><p style=\"font-size:13px\">".date("d/m/Y",strtotime($rowGetAccount4[0]))."</p></td>";
			$descriptionData = $rowGetAccount4[1]."&nbsp;".$rowGetAccount4[2];
			echo "<td align='left'><p style=\"font-size:13px\">$descriptionData</p></td>";
			echo "<td><p style=\"font-size:13px\">$rowGetAccount4[3]</p></td>";			
			echo "<td><p style=\"font-size:13px\">$rowGetAccount4[4]</p></td>";	
			echo "</tr>";
		}		
		
		echo "</table>";
	}

?>

</form>
</center>
</body>
</html>