<?php
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$account2ID = $_POST['account2ID'];
	$selectGroup = $_POST['selectGroup'];	
	
	$sqlCheckAccount3 = "SELECT account3_id, account3_name FROM tbaccount3 WHERE account3_account2ID = '$account2ID' ORDER BY account3_number ASC";
	$resultCheckAccount3 = mysqli_query($connection, $sqlCheckAccount3) or die("error in check tbaccount3 query");
	
	//if empty record then account 3 and search button is disabled
	if(mysqli_num_rows($resultCheckAccount3)>0){
		
		if($selectGroup==1 || $selectGroup==3){
			//Debit side or No side
			$account3Text = "<select name='account3' id='account3' size='1' onchange=\"GetAccount3Name(this)\">";
		}elseif($selectGroup==4){
			//Adjustment
			$account3Text = "<select name='account3a' id='account3a' size='1' onchange=\"GetAccount3aName(this)\">";
		}elseif($selectGroup==2){
			//Credit side
			$account3Text = "<select name='account3c' id='account3c' size='1' onchange=\"GetAccount3cName(this)\">";
		}elseif($selectGroup==5){
			//Search
			$account3Text = "<select name='account3s' id='account3s' size='1' onchange=\"GetAccount3sName(this)\">";
		}
		
		
		
		$count2 = 0;
		
		while($rowCheckAccount3 = mysqli_fetch_array($resultCheckAccount3)){			
			$account3Text = $account3Text."<option value=".$rowCheckAccount3[0].">".$rowCheckAccount3[1]."</option>";
			if($count2==0){$account3Name = $rowCheckAccount3[1];}
			$count2 = $count2 + 1;
		}
		$account3Text = $account3Text."</select>";		
		if($selectGroup==1 || $selectGroup==3){
			//Debit side or No side
			$account3Text = $account3Text."<input type='hidden' name='account3NameValue' id='account3NameValue' value='$account3Name'>";
		}elseif($selectGroup==4){
			//Adjustment
			$account3Text = $account3Text."<input type='hidden' name='account3aNameValue' id='account3aNameValue' value='$account3Name'>";
		}elseif($selectGroup==2){
			//Credit side
			$account3Text = $account3Text."<input type='hidden' name='account3cNameValue' id='account3cNameValue' value='$account3Name'>";
		}elseif($selectGroup==5){
			//Search
			$account3Text = $account3Text."<input type='hidden' name='account3sNameValue' id='account3sNameValue' value='$account3Name'>";
		}
		
		
		
		
		
		echo $account3Text;
		
	}else{
		echo "0";
	}
?>