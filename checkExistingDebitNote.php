<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$debitNoteNo = $_POST['debitNoteNo'];
	$sqlCheckExistingDebitNote = "SELECT debitNote_id FROM tbdebitnote WHERE debitNote_no = '$debitNoteNo'";
	
	$sqlCheckExistingDebitNote = mysqli_query($connection, $sqlCheckExistingDebitNote) or die("error in check existing debit note no");
	
	if(mysqli_num_rows($sqlCheckExistingDebitNote)>0){
		//got existing credit note no
		$rowCheckExistingDebitNote = mysqli_fetch_row($sqlCheckExistingDebitNote);
		echo $rowCheckExistingDebitNote[0];		
	}else{
		echo "0";			
	}
?>
