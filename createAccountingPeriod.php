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
	
	if(isset($_POST['Submit1'])){
		$accountingYearPeriodStart = convertMysqlDateFormat($_POST['accountingYearPeriodStart']);
		$accountingYearPeriodEnd = convertMysqlDateFormat($_POST['accountingYearPeriodEnd']);
	
		//CREATE NEW ACCOUNTING YEAR PERIOD, default = o Open
		$sqlInsertAccountingYearPeriod = "INSERT INTO tbaccountingperiod(accountingPeriod_id, 
		accountingPeriod_dateStart, accountingPeriod_dateEnd) VALUES(NULL, '$accountingYearPeriodStart', '$accountingYearPeriodEnd')";
		mysqli_query($connection, $sqlInsertAccountingYearPeriod) or die("error in create tbaccountingperiod query");
		
		$_SESSION['accountingPeriodStart'] = $accountingYearPeriodStart;	
		$_SESSION['accountingPeriodEnd'] = $accountingYearPeriodEnd;	
		
	
	}
	
	
	//get the accounting period 
	$sqlAccountingPeriod = "SELECT accountingPeriod_id, accountingPeriod_dateStart, accountingPeriod_dateEnd, accountingPeriod_status
	FROM tbaccountingperiod ORDER BY accountingPeriod_dateStart ASC";
	
	$resultAccountingPeriod = mysqli_query($connection, $sqlAccountingPeriod) or die("error in accounting period query");

	if(mysqli_num_rows($resultAccountingPeriod) > 0){
		$leavePeriodTotal = mysqli_num_rows($resultAccountingPeriod);
		$counter = 1;		
		while($rowYear=mysqli_fetch_array($resultAccountingPeriod)){			
			$defaultStartDate = date('d/m/Y',strtotime($rowYear[2].'+ 1 day'));//get the next day
			$defaultEndDate = date('d/m/Y',strtotime($rowYear[2].'+ 1 year'));//get the next day
			if($counter==$leavePeriodTotal){$yearIDvalue = $rowYear[0];}
			$counter = $counter + 1;
		}
	}else{
		$yearIDvalue = 0;		
		$defaultStartDate = date('d/m/Y');		
		$todayDate = date('Y-m-d');
		$yesterdayDate = date('Y-m-d', strtotime($todayDate) - 1); //to get previous date since add one year gives exta 1 day in period range
		$defaultEndDate = date('d/m/Y',strtotime($yesterdayDate.'+ 1 year'));//get the next day
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
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
	
	$( function() {
		$( "#demo3" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
</script>




<script>
	function CalculateEndDate(){
		
		var convertDateToMDYformat = (document.getElementById('demo2').value).split("/");//convert Start Date to MDY format
		var MDYformat = convertDateToMDYformat[1] + "/" + convertDateToMDYformat[0] + "/" + convertDateToMDYformat[2];			
			
		const d = new Date(MDYformat); //create a date object
		
		d.setDate(d.getDate() - 1); //- 1 day because add 1 year gives one day extra in below code
		d.setFullYear(d.getFullYear() + 1); //get one year exactly
		
		var dateValue = d.getDate()
		var monthValue = d.getMonth()+1;//month index in 0 in javascript
		var yearValue = d.getFullYear();			
		
		if(dateValue<10){dateValue = "0"+dateValue};
		if(monthValue<10){monthValue = "0"+monthValue};			
		var finalDueDate = dateValue + "/" + monthValue + "/" + yearValue;
		
		document.getElementById('demo3').value = finalDueDate;	
	}
	
	
	function CheckAndSubmit(){
		//var clickedButton = document.getElementById("buttonClicked").value;
		console.log("ali");
		//if(clickedButton=='submitButton'){
			var i = document.getElementById("demo2");     
			var f = document.getElementById("demo3");
			
			
			var dateStart = i.value;		
			var dateEnd = f.value;
			
			
			//change string to date object DATE START
			const dataStartSplitArray = dateStart.split("/"); //split
			var dataStartFormat = dataStartSplitArray[2]+"-"+dataStartSplitArray[1]+"-"+dataStartSplitArray[0];//rearrange for date constructor format
			const dateStart1 = new Date(dataStartFormat);//date object
			
			//change string to date object DATE END
			const dataEndSplitArray = dateEnd.split("/"); //split
			var dataEndFormat = dataEndSplitArray[2]+"-"+dataEndSplitArray[1]+"-"+dataEndSplitArray[0];//rearrange for date constructor format
			const dateEnd1 = new Date(dataEndFormat);//date object
			
			if(dateStart1 >= dateEnd1){
				alert("Invalid Dates!");
				//demo2.focus();
				return false;
			
			}else{
					var differenceInTime = dateEnd1.getTime() - dateStart1.getTime(); //difference in Miliseconds
					var differenceInDay = differenceInTime / (1000 * 60 * 60 * 24); //difference in Days
					
					if(differenceInDay > 365){
						alert("Dates Range more than 365 days. Max allowed is one year!");
						//demo2.focus();
						return false;
					
					}else{
						//=============================================
						var data1 = "dateStart="+dateStart;
						var data2 = "&dateEnd="+dateEnd;
						
						
						data1 = data1 + data2;		
						
						$.ajax({
							type : 'POST',
							url : 'checkExistingAccountingPeriod.php',
							data : data1,
							dataType : 'json',
							success : function(w)
							{				
								ResubmitForm(w);			 
							}	
						})	
						return false;
						//=================================================
			
					}
			}
		
		//}
	}
	
	
	
	function ResubmitForm(g){
	//console.log("ali is the best");
	if(g==true){		
	
		var u = confirm("Create New Accounting Period?");
		
		
		if(u==true){
			$('#accountingPeriodFrom').attr('onsubmit', 'return true');
			jQuery("#submitButton").trigger('click'); //auto submit by clicking the submit button id
		}	
	
	}else{
		alert("This Accounting Year Period already created!");
		//demo2.focus();
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
<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left"><h1>Accounting Period</h1></td></tr></table>



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


<form action="createAccountingPeriod.php" id="accountingPeriodFrom" method="post" onsubmit="return CheckAndSubmit()">



<table width="600" cellpadding="0" border="1" class="mystyle">
<tr><td colspan="3">Create New Accounting Period</td></tr>

<tr><td colspan="2">Start&nbsp;
<input id="demo2" type="text" name="accountingYearPeriodStart" size="10" onchange="CalculateEndDate()" value="<?php echo $defaultStartDate;?>" readonly>&nbsp;&nbsp;&nbsp;
</td>
<td>End&nbsp;
<input id="demo3" type="text" name="accountingYearPeriodEnd" size="10" value="<?php echo $defaultEndDate;?>" readonly>&nbsp;&nbsp;&nbsp;

<!--store the button ID that was clicked because onClick button code is processed before FORM submit code-->
<input type='hidden' id='buttonClicked' value=''><input type='hidden' name="editClicked" id='editClicked' value="0">
<input type="hidden" name="dateNewStart" id="dateNewStart" value="<?php echo $defaultStartDate;?>">
<input type="hidden" name="dateNewEnd" id="dateNewEnd" value="<?php echo $defaultEndDate;?>">
</td>

</tr>
<tr><td colspan="3"><input type="submit" name="Submit1" id="submitButton" value="New Accounting Period" style="height:30px; width:200px"></td></tr>
</table>

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