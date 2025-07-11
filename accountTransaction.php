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
	
	//get the ALL DEFAULT accounts
	//default day is today month begin & end
	$dt = date('Y-m-d');
	$accountDate1Converted = date("Y-m-01", strtotime($dt));
	$accountDate2Converted = date("Y-m-t", strtotime($dt));	
	
	$sqlGetAccount1 = "SELECT account1_id, account1_name FROM tbaccount1 ORDER BY account1_number ASC";
	$resultGetAccount1 = mysqli_query($connection, $sqlGetAccount1) or die("error in get account1 query");

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
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );

	$( function() {
		$( "#demo3" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
	
	$( function() {
		$( "#demo4" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );

	$( function() {
		$( "#demo5" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );

	function GetAccount1Name(x){
		document.getElementById("account1NameValue").value = x.options[x.selectedIndex].text;
		//if this change then second drop down and third drop down list must change			
		var data1 = "account1ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=1"; //debit side
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
	
	function GetAccount1cName(x){
		document.getElementById("account1cNameValue").value = x.options[x.selectedIndex].text;
		//if this change then second drop down and third drop down list must change			
		var data1 = "account1ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=2"; //credit side
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
					document.getElementById("account2c").disabled = true;
					document.getElementById("account3c").disabled = true;
					document.getElementById("Submit").disabled = true;					
				}else{					
					if(response[1]==0){
						document.getElementById("account3c").disabled = true;
						document.getElementById("Submit").disabled = true;
						$("#locationAccount2c").html(response[0]);
					}else{
						document.getElementById("account2c").disabled = false;
						document.getElementById("account3c").disabled = false;
						document.getElementById("Submit").disabled = false;					
						$("#locationAccount2c").html(response[0]);
						$("#locationAccount3c").html(response[1]);
					}
				}
			}
		}
		)
	}
	
	function GetAccount1aName(x){
		document.getElementById("account1aNameValue").value = x.options[x.selectedIndex].text;
		//if this change then second drop down and third drop down list must change			
		var data1 = "account1ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=4"; //one side
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
					document.getElementById("account2a").disabled = true;
					document.getElementById("account3a").disabled = true;
					document.getElementById("Submit2").disabled = true;					
				}else{					
					if(response[1]==0){
						document.getElementById("account3a").disabled = true;
						document.getElementById("Submit2").disabled = true;
						$("#locationAccount2a").html(response[0]);
					}else{
						document.getElementById("account2a").disabled = false;
						document.getElementById("account3a").disabled = false;
						document.getElementById("Submit2").disabled = false;					
						$("#locationAccount2a").html(response[0]);
						$("#locationAccount3a").html(response[1]);
					}
				}
			}
		}
		)
	}
	
	function GetAccount1sName(x){
		document.getElementById("account1sNameValue").value = x.options[x.selectedIndex].text;
		//if this change then second drop down and third drop down list must change			
		var data1 = "account1ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=5"; // search
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
					document.getElementById("account2s").disabled = true;
					document.getElementById("account3s").disabled = true;
					document.getElementById("Submit3").disabled = true;					
				}else{					
					if(response[1]==0){
						document.getElementById("account3s").disabled = true;
						document.getElementById("Submit3").disabled = true;
						$("#locationAccount2a").html(response[0]);
					}else{
						document.getElementById("account2s").disabled = false;
						document.getElementById("account3s").disabled = false;
						document.getElementById("Submit3").disabled = false;					
						$("#locationAccount2s").html(response[0]);
						$("#locationAccount3s").html(response[1]);
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
		var data2 = "&selectGroup=1"; //debit side
		data1 = data1 + data2;
		
		$.ajax({
			type : 'POST',
			url : 'checkAccount3.php',
			data : data1,
			dataType : 'text',
			success : function(t){
				if(t=="0"){
					document.getElementById("account3").disabled = true;
					//document.getElementById("Submit").disabled = true;
				}else{
					//document.getElementById("account2").disabled = false;
					document.getElementById("account3").disabled = false;
					//document.getElementById("Submit").disabled = false;					
					$("#locationAccount3").html(t);
				}
			}
		})
	}

	function GetAccount2cName(x){		
		
		document.getElementById("account2cNameValue").value = x.options[x.selectedIndex].text;
		//if this change then third drop down list must change			
		var data1 = "account2ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=2"; //debit side
		data1 = data1 + data2;
		
		$.ajax({
			type : 'POST',
			url : 'checkAccount3.php',
			data : data1,
			dataType : 'text',
			success : function(t){
				if(t=="0"){
					document.getElementById("account3c").disabled = true;
					//document.getElementById("Submit").disabled = true;
				}else{
					//document.getElementById("account2").disabled = false;
					document.getElementById("account3c").disabled = false;
					//document.getElementById("Submit").disabled = false;					
					$("#locationAccount3c").html(t);
				}
			}
		})
	}
	
	function GetAccount2aName(x){		
		
		document.getElementById("account2aNameValue").value = x.options[x.selectedIndex].text;
		//if this change then third drop down list must change			
		var data1 = "account2ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=4"; // adjustment
		data1 = data1 + data2;
		
		$.ajax({
			type : 'POST',
			url : 'checkAccount3.php',
			data : data1,
			dataType : 'text',
			success : function(t){
				if(t=="0"){
					document.getElementById("account3a").disabled = true;
					document.getElementById("Submit2").disabled = true;
				}else{
					//document.getElementById("account2").disabled = false;
					document.getElementById("account3a").disabled = false;
					document.getElementById("Submit2").disabled = false;					
					$("#locationAccount3a").html(t);
				}
			}
		})
	}

	function GetAccount2sName(x){		
		
		document.getElementById("account2sNameValue").value = x.options[x.selectedIndex].text;
		//if this change then third drop down list must change			
		var data1 = "account2ID="+x.options[x.selectedIndex].value;
		var data2 = "&selectGroup=5"; // Search
		data1 = data1 + data2;
		
		$.ajax({
			type : 'POST',
			url : 'checkAccount3.php',
			data : data1,
			dataType : 'text',
			success : function(t){
				if(t=="0"){
					document.getElementById("account3s").disabled = true;
					document.getElementById("Submit3").disabled = true;
				}else{
					//document.getElementById("account2").disabled = false;
					document.getElementById("account3s").disabled = false;
					document.getElementById("Submit3").disabled = false;					
					$("#locationAccount3s").html(t);
				}
			}
		})
	}
	
	function GetAccount3Name(x){
		document.getElementById("account3NameValue").value = x.options[x.selectedIndex].text;
	}
	
	function GetAccount3cName(x){
		document.getElementById("account3cNameValue").value = x.options[x.selectedIndex].text;
	}
	
	function GetAccount3aName(x){
		document.getElementById("account3aNameValue").value = x.options[x.selectedIndex].text;
	}
	
	function GetAccount3sName(x){
		document.getElementById("account3sNameValue").value = x.options[x.selectedIndex].text;
	}
	
	function CreateDoubleEntryTransaction(){
		var doubleEntryAmount = document.getElementById("doubleEntryAmount");
		var doubleEntryDescription = document.getElementById("doubleEntryDescription");
		
		if((doubleEntryAmount.value.trim()==="")||(isNaN(doubleEntryAmount.value))){
			alert("Invalid Amount!!");
			doubleEntryAmount.focus();
		}else{
			if(doubleEntryDescription.value.trim()===""){
				alert("Enter brief description!!");
				doubleEntryDescription.focus();
			}else{
				var account3ID = document.getElementById("account3");
				var account3cID = document.getElementById("account3c");		
				var account3IDvalue = account3ID.options[account3ID.selectedIndex].value;				
				var account3cIDvalue = account3cID.options[account3cID.selectedIndex].value;		
				if(document.getElementById("account3").disabled == true){
					alert("Invalid Debit Account!");					
				}else{
						if(document.getElementById("account3c").disabled == true){
							alert("Invalid Credit Account!");					
						}else{
							if(account3IDvalue==account3cIDvalue){
								alert("Debit & Credit same accounts!!");
							}else{
								var t = confirm("Do you want to create this Transaction?");
								if(t==true){
									CreateDoubleEntryTransaction2();
								}
							}
						}
				}
			}	
		}
	}
	
	function CreateDoubleEntryTransaction2(){
		
		var account3ID = document.getElementById("account3");
		var account3cID = document.getElementById("account3c");
		var account3IDvalue = account3ID.options[account3ID.selectedIndex].value;
		var account3cIDvalue = account3cID.options[account3cID.selectedIndex].value;		
		var doubleEntryDate = document.getElementById("demo2").value;
		var doubleEntryDescription = document.getElementById("doubleEntryDescription").value;
		var doubleEntryAmount = document.getElementById("doubleEntryAmount").value;
		
		$.ajax({
			type : 'POST',
			url : 'createTransaction.php',
			data : {transactionType: 1, account3IDname: account3IDvalue, account3cIDname: account3cIDvalue, 
			doubleEntryDateName: doubleEntryDate, doubleEntryDescriptionName: doubleEntryDescription, 
			doubleEntryAmountName: doubleEntryAmount},
			dataType : 'json',
			success: function(w){
				if(w=='1'){
					document.getElementById("doubleEntryAmount").value = "";	
					document.getElementById("doubleEntryDescription").value = "";
					setTimeout(function() {
						alert("New Double Entry Transaction Created!");
						document.getElementById('Submit3').click();
						
					  }, 100) //milliseconds delay
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
		})
	}
	
	function CreateAdjustmentTransaction(){
		var adjustmentAmount = document.getElementById("adjustmentAmount");
		var adjustmentDescription = document.getElementById("adjustmentDescription");
		
		if((adjustmentAmount.value.trim()==="")||(isNaN(adjustmentAmount.value))){
			alert("Invalid Amount!!");
			adjustmentAmount.focus();
		}else{
			if(adjustmentDescription.value.trim()===""){
				alert("Enter brief description!!");
				adjustmentDescription.focus();
			}else{			
				
				var t = confirm("Do you want to create this Adjustment?");
				if(t==true){
					CreateAdjustmentTransaction2();
				}
			}	
		}
	}
	
	function CreateAdjustmentTransaction2(){
		var account3aID = document.getElementById("account3a");
		var account3aIDvalue = account3aID.options[account3aID.selectedIndex].value;
		
		if(document.getElementById("adjustmentDebit").checked){
			var adjustmentType = "d"; //debit
		}else{
			var adjustmentType = "c"; //credit
		}

		var adjustmentDate = document.getElementById("demo3").value;
		var adjustmentDescription = document.getElementById("adjustmentDescription").value;
		var adjustmentAmount = document.getElementById("adjustmentAmount").value;
		
		$.ajax({
			
			type : 'POST',
			url : 'createTransaction.php',
			data : {transactionType: 2, account3aIDname: account3aIDvalue, 
			adjustmentDateName: adjustmentDate, adjustmentDescriptionName: adjustmentDescription, 
			adjustmentAmountName: adjustmentAmount, adjustmentTypeName: adjustmentType},
			dataType : 'json',
			
			success: function(w){
				if(w=='1'){
					document.getElementById("adjustmentAmount").value = "";	
					document.getElementById("adjustmentDescription").value = "";
					setTimeout(function() {
						alert("New Adjustment Transaction Created!");
						document.getElementById('Submit3').click();
						
					  }, 100) //milliseconds delay
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
		})
	}
	
	
	
	function SearchAccountTransaction(){
		var account3sID = document.getElementById("account3s");
		var account3sIDvalue = account3sID.options[account3sID.selectedIndex].value;
		
		var account3Label = account3sID.options[account3sID.selectedIndex].text;
		$("#accountName").html(account3Label);//span
		
		
		console.log(account3Label);
		
		var accountStartDate = document.getElementById("demo4").value;
		var accountEndDate = document.getElementById("demo5").value;
		
		$('#result').html('');
		$.ajax({
			type: 'POST',
			url: 'searchAccountTransactionSQL.php',
			data: {account3s: account3sIDvalue, accountDate1: accountStartDate, accountDate2: accountEndDate},
				
			dataType: 'text',
			success:function(data){
				$('#result').html(data);
				
			}
			
			
			
		});
		
		
		
		
		
		
		
		
		
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
	font-size: 12px; /* Added font-size */
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

.float-container{
    display: flex;
}
.float-child{
    width: 430px;
	margin-left: 20px;
}
.float-child2{
    flex-grow: 1;
}
</style>

</head>
	<body>
	<center>
<div class="navbar">
	<?php include('menuPHPImes.php');?>
</div>
<div class="float-container">
	<div class="float-child">
<table width="400" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>
<table border="0" cellpadding="0" width="800"><tr height="30"><td>&nbsp;</td></tr></table>
<table width="400" border="0" cellpadding="0" align="center"><tr height="40"><td align="left"><h1>Account Transaction</h1></td></tr></table>
<!--search row-->
<table width="400" border="0" cellpadding="0" align="center">
<tr><td></td></tr>
</table>

<table width="400px" cellpadding="0" border="1" class="mystyle">
<tr bgcolor="9cc1c7"><td colspan="2">Double Entry</td></tr>
<tr><td><strong>Debit</strong></td><td><strong>Credit</strong></td></tr>
<tr class="notfirst">
<td>
<?php 
	if(mysqli_num_rows($resultGetAccount1)>0){
		echo "<select name='account1' id='account1' size='1' onchange=\"GetAccount1Name(this)\">";	
		$countAccount1 = 0;
		while($rowGetAccount1 = mysqli_fetch_array($resultGetAccount1)){
			echo "<option value='$rowGetAccount1[0]'>$rowGetAccount1[1]</option>";
			if($countAccount1==0){
				$account1Name = $rowGetAccount1[1];
			}
			$countAccount1 = $countAccount1 + 1; 
		}		
		echo "</select>";
		echo "<input type='hidden' name='account1NameValue' id='account1NameValue' value='$account1Name'>";
	}
?>
</td>
<td>
<?php 
	if(mysqli_num_rows($resultGetAccount1)>0){
		//reset the resultGetAccount1 
		mysqli_data_seek($resultGetAccount1, 0);
		
		echo "<select name='account1c' id='account1c' size='1' onchange=\"GetAccount1cName(this)\">";	
		$countAccount1c = 0;
		
		while($rowGetAccount1c = mysqli_fetch_array($resultGetAccount1)){
			echo "<option value='$rowGetAccount1c[0]'>$rowGetAccount1c[1]</option>";
			
			if($countAccount1c==0){
				$account1cName = $rowGetAccount1c[1];
			}
			$countAccount1c = $countAccount1c + 1; 
		}		
		echo "</select>";
		echo "<input type='hidden' name='account1cNameValue' id='account1cNameValue' value='$account1cName'>";
	}
?>
</td>
</tr>
<tr class="notfirst">
<td>
<?php
	echo "<span id='locationAccount2'>";
	if(mysqli_num_rows($resultGetAccount2)>0){
		echo "<select name='account2' id='account2' size='1' onchange=\"GetAccount2Name(this)\">";
		$countAccount2 = 0;
		
		while($rowGetAccount2 = mysqli_fetch_array($resultGetAccount2)){
			echo "<option value='$rowGetAccount2[0]'>$rowGetAccount2[1]</option>";
			
			if($countAccount2==0){
				$account2Name = $rowGetAccount2[1];
			}
			$countAccount2 = $countAccount2 + 1;
		}		
		echo "</select>";
		echo "<input type='hidden' name='account2NameValue' id='account2NameValue' value='$account2Name'>";
	}
	echo "</span>";
?>
</td>
<td>

<?php
	echo "<span id='locationAccount2c'>";
	if(mysqli_num_rows($resultGetAccount2)>0){
		//reset the resultGetAccount2 
		mysqli_data_seek($resultGetAccount2, 0);
		echo "<select name='account2c' id='account2c' size='1' onchange=\"GetAccount2cName(this)\">";
		
		$countAccount2c = 0;
		
		while($rowGetAccount2c = mysqli_fetch_array($resultGetAccount2)){
			echo "<option value='$rowGetAccount2c[0]'>$rowGetAccount2c[1]</option>";
			
			if($countAccount2c==0){
				$account2cName = $rowGetAccount2c[1];
			}
			$countAccount2c = $countAccount2c + 1;
		}		
		echo "</select>";
		echo "<input type='hidden' name='account2cNameValue' id='account2cNameValue' value='$account2cName'>";
	}
	echo "</span>";
?>
</td>
</tr>
<tr class="notfirst">
<td>
<?php
	echo "<span id='locationAccount3'>";
	if(mysqli_num_rows($resultGetAccount3)>0){
		echo "<select name='account3' id='account3' size='1' onchange=\"GetAccount3Name(this)\">";
		
		$countAccount3 = 0;
		while($rowGetAccount3 = mysqli_fetch_array($resultGetAccount3)){
			echo "<option value='$rowGetAccount3[0]'>$rowGetAccount3[1]</option>";
			
			if($countAccount3==0){
				$account3Name = $rowGetAccount3[1];
			}
			$countAccount3 = $countAccount3 + 1;
		}		
		echo "</select>";
		echo "<input type='hidden' name='account3NameValue' id='account3NameValue' value='$account3Name'>";
	}
	echo "</span>";
?>
</td>
<td>

<?php
	echo "<span id='locationAccount3c'>";
	if(mysqli_num_rows($resultGetAccount3)>0){
		//reset the resultGetAccount3 
		mysqli_data_seek($resultGetAccount3, 0);
		echo "<select name='account3c' id='account3c' size='1' onchange=\"GetAccount3cName(this)\">";
		
		$countAccount3c = 0;
		while($rowGetAccount3c = mysqli_fetch_array($resultGetAccount3)){
			echo "<option value='$rowGetAccount3c[0]'>$rowGetAccount3c[1]</option>";
			
			if($countAccount3c==0){
				$account3cName = $rowGetAccount3c[1];
			}
			$countAccount3c = $countAccount3c + 1;
		}		
		echo "</select>";
		echo "<input type='hidden' name='account3cNameValue' id='account3cNameValue' value='$account3cName'>";
	}
	echo "</span>";
?>
</td>
</tr>
<tr class="notfirst">
<td colspan="2">
<input id="demo2" type="text" name="doubleEntryDate" size="10" value="<?php echo date('d/m/Y');?>" readonly>&nbsp;
</td>
</tr>
<tr class="notfirst">
<td colspan="2">
<input type="text" name="doubleEntryAmount" id="doubleEntryAmount" size="15" maxlength="15" value="" placeholder="amount">
</td>
</tr>

<tr class="notfirst">
<td colspan="2">
<input type="text" name="doubleEntryDescription" id="doubleEntryDescription" size="50" maxlength="100" value="" placeholder="description">
</td>
<tr class="notfirst">
<td colspan="2" align="right"><input type="submit" name="Submit" id="Submit" value="Create Transaction" onclick="CreateDoubleEntryTransaction()"></td>
</tr>

</table>

	<table width="400px" cellpadding="0" border="1" class="mystyle">
	 	<tr bgcolor="9cc1c7"><td>Adjustment</td></tr>
		<tr class="notfirst"><td>
		<?php 
			if(mysqli_num_rows($resultGetAccount1)>0){
				//reset the resultGetAccount1 
				mysqli_data_seek($resultGetAccount1, 0);
				
				echo "<select name='account1a' id='account1a' size='1' onchange=\"GetAccount1aName(this)\">";	
				$countAccount1a = 0;
				while($rowGetAccount1a = mysqli_fetch_array($resultGetAccount1)){
					echo "<option value='$rowGetAccount1a[0]'>$rowGetAccount1a[1]</option>";
					if($countAccount1a==0){
						$account1aName = $rowGetAccount1a[1];
					}
					$countAccount1a = $countAccount1a + 1; 
				}		
				echo "</select>";
				echo "<input type='hidden' name='account1aNameValue' id='account1aNameValue' value='$account1aName'>";
			}
		?>
		</td></tr>
		<tr class="notfirst"><td>
		<?php
			echo "<span id='locationAccount2a'>";
			if(mysqli_num_rows($resultGetAccount2)>0){
				//reset the resultGetAccount2 
				mysqli_data_seek($resultGetAccount2, 0);
				echo "<select name='account2a' id='account2a' size='1' onchange=\"GetAccount2aName(this)\">";
				
				$countAccount2a = 0;
				
				while($rowGetAccount2a = mysqli_fetch_array($resultGetAccount2)){
					echo "<option value='$rowGetAccount2a[0]'>$rowGetAccount2a[1]</option>";
					
					if($countAccount2a==0){
						$account2aName = $rowGetAccount2a[1];
					}
					$countAccount2a = $countAccount2a + 1;
				}		
				echo "</select>";
				echo "<input type='hidden' name='account2aNameValue' id='account2aNameValue' value='$account2aName'>";
			}
			echo "</span>";
		?>
		</td></tr>
		<tr class="notfirst"><td>
		<?php
			echo "<span id='locationAccount3a'>";
			if(mysqli_num_rows($resultGetAccount3)>0){
				//reset the resultGetAccount3 
				mysqli_data_seek($resultGetAccount3, 0);
				echo "<select name='account3a' id='account3a' size='1' onchange=\"GetAccount3aName(this)\">";
				
				$countAccount3a = 0;
				while($rowGetAccount3a = mysqli_fetch_array($resultGetAccount3)){
					echo "<option value='$rowGetAccount3a[0]'>$rowGetAccount3a[1]</option>";
					
					if($countAccount3a==0){
						$account3aName = $rowGetAccount3a[1];
					}
					$countAccount3a = $countAccount3a + 1;
				}		
				echo "</select>";
				echo "<input type='hidden' name='account3aNameValue' id='account3aNameValue' value='$account3aName'>";
			}
			echo "</span>";
		?>
		</td></tr>
		<tr class="notfirst"><td>
			<input type="radio" name="adjustmentType" id="adjustmentDebit" value="d" checked>Debit
			<input type="radio" name="adjustmentType" id="adjustmentCredit" value="c">Credit
		</td></tr>
		
		<tr class="notfirst"><td>
			<input id="demo3" type="text" name="adjustmentDate" size="10" value="<?php echo date('d/m/Y');?>" readonly>&nbsp;
		</td></tr>
		
		<tr class="notfirst"><td>
			<input type="text" name="adjustmentAmount" id="adjustmentAmount" size="15" maxlength="15" value="" placeholder="amount">
		</td></tr>
		
		<tr class="notfirst"><td>
			<input type="text" name="adjustmentDescription" id="adjustmentDescription" size="40" maxlength="100" value="" placeholder="description">
		</td></tr>
		
		<tr class="notfirst"><td align="right">
			<input type="submit" name="Submit2" id="Submit2" value="Create Adjustment" onclick="CreateAdjustmentTransaction()">
		</td></tr>
		</table>

	</div>
	
	<div class="float-child2">
		<table width="600" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>
		<table border="0" cellpadding="0" width="800"><tr height="30"><td>&nbsp;</td></tr></table>
		<table width="600" border="0" cellpadding="0" align="center"><tr height="40"><td align="left"><h1>&nbsp;</td></tr></table>
		<!--search row-->
		<table width="600" border="0" cellpadding="0" align="center">
		<tr><td></td></tr>
		</table>
		
		<table border="0" cellpadding="0" width="800px">
			<!--<tr bgcolor="eff5b8">
				<td>
				&nbsp;
				</td>
			</tr>-->
			<tr bgcolor="eff5b8">
				<td>			
					<?php 
						if(mysqli_num_rows($resultGetAccount1)>0){
							//reset the resultGetAccount1 
							mysqli_data_seek($resultGetAccount1, 0);
							
							echo "<select name='account1s' id='account1s' size='1' onchange=\"GetAccount1sName(this)\">";	
							$countAccount1s = 0;
							while($rowGetAccount1s = mysqli_fetch_array($resultGetAccount1)){
								echo "<option value='$rowGetAccount1s[0]'>$rowGetAccount1s[1]</option>";
								if($countAccount1s==0){
									$account1sName = $rowGetAccount1s[1];
								}
								$countAccount1s = $countAccount1s + 1; 
							}		
							echo "</select>";
							echo "<input type='hidden' name='account1sNameValue' id='account1sNameValue' value='$account1sName'>";
							echo "&nbsp;";
						}
						echo "<span id='locationAccount2s'>";
						if(mysqli_num_rows($resultGetAccount2)>0){
							//reset the resultGetAccount2 
							mysqli_data_seek($resultGetAccount2, 0);
							echo "<select name='account2s' id='account2s' size='1' onchange=\"GetAccount2sName(this)\">";
							
							$countAccount2s = 0;
							
							while($rowGetAccount2s = mysqli_fetch_array($resultGetAccount2)){
								echo "<option value='$rowGetAccount2s[0]'>$rowGetAccount2s[1]</option>";  
								
								if($countAccount2s==0){
									$account2sName = $rowGetAccount2s[1];
								}
								$countAccount2s = $countAccount2s + 1;
							}		
							echo "</select>";
							echo "<input type='hidden' name='account2sNameValue' id='account2sNameValue' value='$account2sName'>";
							echo "&nbsp;";
						}
						echo "</span>";
						
						echo "<span id='locationAccount3s'>";
						if(mysqli_num_rows($resultGetAccount3)>0){
							//reset the resultGetAccount3 
							mysqli_data_seek($resultGetAccount3, 0);
							echo "<select name='account3s' id='account3s' size='1' onchange=\"GetAccount3sName(this)\">";
							
							$countAccount3s = 0;
							while($rowGetAccount3s = mysqli_fetch_array($resultGetAccount3)){
								echo "<option value='$rowGetAccount3s[0]'>$rowGetAccount3s[1]</option>";
								
								if($countAccount3s==0){
									$account3sName = $rowGetAccount3s[1];
								}
								$countAccount3s = $countAccount3s + 1;
							}		
							echo "</select>";
							echo "<input type='hidden' name='account3sNameValue' id='account3sNameValue' value='$account3sName'>";
							echo "&nbsp;";
						}
						echo "</span>";
						echo "&nbsp;";
						$dateStart = date("01/m/Y", strtotime($dt));
						echo "<input id=\"demo4\" type=\"text\" name=\"accountDate1\" size=\"7\" value=\"$dateStart\">";					
						echo "&nbsp;TO&nbsp;";
						$dateEnd = date("t/m/Y", strtotime($dt));
						echo "<input id=\"demo5\" type=\"text\" name=\"accountDate1\" size=\"7\" value=\"$dateEnd\">";	
						echo "&nbsp;";
						echo "<input type=\"submit\" name=\"Submit3\" id=\"Submit3\" value=\"Search Accounts\" onclick=\"SearchAccountTransaction()\">";
			?>		
				</td>
			</tr>
			<tr><td><span id="accountName"><?php echo $account3Name;?></span></td></tr>
		</table>
		
		<!--<table width="800" cellpadding="0" border="0"><tr><td><span id="accountName"><?php echo $account3Name;?></span></td></tr><table>-->
		
		<div id="result">
		
			<?php 
				if(mysqli_num_rows($resultGetAccount4) > 0){
					
					echo "<table width='800' cellpadding='0' border='1' class='mystyle'>";		
					echo "<tr bgcolor='#EAEAEA'><td style='width:80'><b>Date</b></td><td style='width:520'><b>Description</b></td><td style='width:100'><b>Debit</b></td><td style='width:100'><b>Credit</b></td></tr>";
					while($rowGetAccount4 = mysqli_fetch_row($resultGetAccount4)){
						echo "<tr class='notfirst'>";
						echo "<td><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowGetAccount4[0]))."</p></td>";
						$descriptionData = $rowGetAccount4[1]."&nbsp;".$rowGetAccount4[2];
						echo "<td align='left'><p style=\"font-size:12px\">$descriptionData</p></td>";
						echo "<td><p style=\"font-size:12px\">$rowGetAccount4[3]</p></td>";			
						echo "<td><p style=\"font-size:12px\">$rowGetAccount4[4]</p></td>";	
						echo "</tr>";
					}		
					echo "</table>";
				}
			?>
		</div>
		
	</div>
</div>
</center>
</body>
</html>