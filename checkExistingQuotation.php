<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$quotationNo = $_POST['quotationNo'];
	$sqlCheckExistingQuotation = "SELECT quotation_id FROM tbquotation WHERE quotation_no = '$quotationNo'";
	
	$resultCheckExistingQuotation = mysqli_query($connection, $sqlCheckExistingQuotation) or die("error in check existing quotation no");
	
	if(mysqli_num_rows($resultCheckExistingQuotation)>0){
		//got existing quotation no
		$rowCheckExistingQuotation = mysqli_fetch_row($resultCheckExistingQuotation);
		echo $rowCheckExistingQuotation[0];		
		
	}else{
		echo "0";			
	}
?>
