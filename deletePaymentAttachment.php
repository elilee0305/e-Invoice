<?php

	include('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database);
	
	//get the error message if cannot connect to database
	if(!$connection){
		die("Connection failed:" . mysqli_connect_error());
	}	

	//delete employee image if exist
	$imageToDelete = $_POST['pictureFileName'];
	$idPayment = intval($_POST['paymentID']);
	
	if($imageToDelete !== ""){				
		$IPAddress = $_SERVER['SERVER_ADDR']; 
		//iv4 = 127.0.0.1 iv6 = ::1
		if(($IPAddress == '127.0.0.1')||($IPAddress == '::1')){
			$deleteImage = getcwd() . "\\paymentreceived\\" . $imageToDelete; //( LOCAL DEVELOPMENT COMPUTER)
		}else{
			//for LINUX server
			$deleteImage = getcwd() . "/paymentreceived/" . $imageToDelete; //( ONLINE  SERVER COMPUTER )
			//for WINDOWS server
			//$deleteImage = getcwd() . "\paymentreceived\\" . $imageToDelete;
		}
		if(file_exists($deleteImage)){
			//delete the image
			if(unlink($deleteImage)){
				//Update tbpayment file
				$sqlUpdatePaymentAttachment = "UPDATE tbpayment SET payment_attachment = '' WHERE payment_id  = '$idPayment'";
				if(!mysqli_query($connection, $sqlUpdatePaymentAttachment)){
					die("Error updating tbpayment: ". mysqli_error($connection));
				}
				echo "2"; //successful deletion & update
			}else{
				die("Error deleting image file");
			}
		}else{
			//no such file name in folder
			echo "1";
		}			
	}else{
		//no file name sent
		echo "0";
	}
?>