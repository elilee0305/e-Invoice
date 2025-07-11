<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$invoiceNo = $_POST['invoiceNo'];
	$sqlCheckExistingInvoice = "SELECT invoice_id FROM tbinvoice WHERE invoice_no = '$invoiceNo'";
	
	$resultCheckExistingInvoice = mysqli_query($connection, $sqlCheckExistingInvoice) or die("error in check existing invoice no");
	
	if(mysqli_num_rows($resultCheckExistingInvoice)>0){
		//got existing quotation no
		$rowCheckExistingInvoice = mysqli_fetch_row($resultCheckExistingInvoice);
		echo $rowCheckExistingInvoice[0];		
		
	}else{
		echo "0";			
	}
?>
