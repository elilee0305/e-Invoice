<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$creditNoteNo = $_POST['creditNoteNo'];
	$sqlCheckExistingCreditNote = "SELECT creditNote_id FROM tbcreditnote WHERE creditNote_no = '$creditNoteNo'";
	
	$resultCheckExistingCreditNote = mysqli_query($connection, $sqlCheckExistingCreditNote) or die("error in check existing credit note no");
	
	if(mysqli_num_rows($resultCheckExistingCreditNote)>0){
		//got existing credit note no
		$rowCheckExistingCreditNote = mysqli_fetch_row($resultCheckExistingCreditNote);
		echo $rowCheckExistingCreditNote[0];		
	}else{
		echo "0";			
	}
?>
