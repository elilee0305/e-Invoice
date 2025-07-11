<?php
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$account1ID = $_POST['account1ID'];	 
	$selectGroup = $_POST['selectGroup'];	 
	
	$sqlCheckAccount2 = "SELECT account2_id, account2_name FROM tbaccount2 WHERE account2_account1ID = '$account1ID' ORDER BY account2_number ASC";
	$resultCheckAccount2 = mysqli_query($connection, $sqlCheckAccount2) or die("error in check tbaccount2 query");
	
	//if empty record then account 2, account 3 and search button is disabled
	if(mysqli_num_rows($resultCheckAccount2)>0){
		
		
		if($selectGroup==1 || $selectGroup==3){
			//Debit side or No side
			$account2Text = "<select name='account2' id='account2' size='1' onchange=\"GetAccount2Name(this)\">";
		}elseif($selectGroup==4){
			//Adjustment side
			$account2Text = "<select name='account2a' id='account2a' size='1' onchange=\"GetAccount2aName(this)\">";
		}elseif($selectGroup==2){
			//Credit side
			$account2Text = "<select name='account2c' id='account2c' size='1' onchange=\"GetAccount2cName(this)\">";
		}elseif($selectGroup==5){
			//Search
			$account2Text = "<select name='account2s' id='account2s' size='1' onchange=\"GetAccount2sName(this)\">";
			
		}
		
		$count = 0; 
		
		while($rowCheckAccount2 = mysqli_fetch_array($resultCheckAccount2)){			
			$account2Text = $account2Text."<option value=".$rowCheckAccount2[0].">".$rowCheckAccount2[1]."</option>";
			if($count==0){$idAccount2 = $rowCheckAccount2[0];$account2Name = $rowCheckAccount2[1];}			
			$count = $count + 1;
		}
		$account2Text = $account2Text."</select>";	
		
		if($selectGroup==1 || $selectGroup==3){
			//Debit side or No side
			$account2Text = $account2Text."<input type='hidden' name='account2NameValue' id='account2NameValue' value='$account2Name'>";
		}elseif($selectGroup==4){
			//Adjustment side
			$account2Text = $account2Text."<input type='hidden' name='account2aNameValue' id='account2aNameValue' value='$account2Name'>";
			
		}elseif($selectGroup==2){
			//Credit side
			$account2Text = $account2Text."<input type='hidden' name='account2cNameValue' id='account2cNameValue' value='$account2Name'>";
		}elseif($selectGroup==5){
			//Search
			$account2Text = $account2Text."<input type='hidden' name='account2sNameValue' id='account2sNameValue' value='$account2Name'>";
		}
		
		
		//get the Account 3 list
		$sqlCheckAccount3 = "SELECT account3_id, account3_name FROM tbaccount3 WHERE account3_account2ID = '$idAccount2' ORDER BY account3_number ASC";
		$resultCheckAccount3 = mysqli_query($connection, $sqlCheckAccount3) or die("error in check tbaccount3 query");
		
		if(mysqli_num_rows($resultCheckAccount3)){
			
			if($selectGroup==1 || $selectGroup==3){
				//Debit side
				$account3Text = "<select name='account3' id='account3' size='1' onchange=\"GetAccount3Name(this)\">";
			}elseif($selectGroup==4){
				//Adjustment side
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
				//Debit side
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
				
			
			echo $account2Text.",".$account3Text;
		}else{
			echo $account2Text.",0";
		}
	}else{
		echo "0,0";
	}
	

?>