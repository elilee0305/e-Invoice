<?php
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");
	
	$paymentID = $_POST['paymentID'];
	$target_dir = "paymentreceived/";
	$target_file = $target_dir . basename($_FILES["file"]["name"]);
	$uploadOK = 1;
	$fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION)); // Convert to lowercase

	
	if((isset($_FILES["file"]["tmp_name"]))&&($_FILES["file"]["tmp_name"] !== "")){
	
		//allowed types
		$allowedTypes = array('jpg', 'jpeg', 'png', 'pdf');
		//check image is real image or fake
		$check = getimagesize($_FILES["file"]["tmp_name"]);
		
		
		if($check !== false || $fileType === 'pdf'){
			
			//file is a image, so proceed to save
			$uploadOK = 1;
			//check if file with this name exist
			if(file_exists($target_file)){
				//filename exist, so do nothing
				$uploadOK = 0;
				echo "0|nothing"; 
			}else{
				//check file size, less than 300KB for image type and 1MB for pdf only allowed
				if((($fileType !== 'pdf') && ($_FILES["file"]["size"] > 300000)) || (($fileType === 'pdf') && ($_FILES["file"]["size"] > 1000000))){
					//file size too large
					$uploadOK = 0;
					echo "1|nothing";
				}else{
					//check file type, only certain type of image format allowed JPG, JPEG, PNG
					if(!in_array($fileType, $allowedTypes)){
						//wrong format, do nothing
						$uploadOK = 0;
						echo "2|nothing";
					}else{
						//all fine so proceed to save to paymentreceived folder						
						$newFileName = "payment" . $paymentID . '.' . $fileType;
						$target_file2 = $target_dir . $newFileName;
						
						if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file2)){
							//Update the tbpayment payment_attachment
							$sqlUpdatePaymentAttachment = "UPDATE tbpayment SET payment_attachment = '$newFileName' WHERE payment_id  = '$paymentID'";
							mysqli_query($connection, $sqlUpdatePaymentAttachment) or die("error in update tbpayment attachment name");
							
							$uploadOK = 1;
							echo "3|".$newFileName;
							
						}else{
							//error uploading file
							$uploadOK = 0;
							$newFileName = "";
							echo "4|nothing";
						}								
					}							
				
				}						
			
			
			}				
		
		}else{
			//file is not a image of pdf, do nothing 
			$uploadOK = 0;					
		}				
	}else{
		//file upload not set or empty, do nothing 
		$uploadOK = 0;					
	}

?>