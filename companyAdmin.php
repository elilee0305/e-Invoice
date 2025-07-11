<?php 
	session_start();
	if($_SESSION['userID']==""){
		//not logged in
		ob_start();
		header ("Location: index.php");
		ob_flush();
	}
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");	
	
	
	include ('makeSafe.php');
	//create new project
	if(isset($_POST['Submit'])){
		$companyName = makeSafe($_POST['companyName']);
		$companyAddress1 = makeSafe($_POST['companyAddress1']);
		$companyAddress2 = makeSafe($_POST['companyAddress2']);
		$companyTelFax = makeSafe($_POST['companyTelFax']);				
		$companyNo = makeSafe($_POST['companyNo']);				
		$companyTinNo = makeSafe($_POST['companyTinNo']);				
		$companySSTno = makeSafe($_POST['companySSTno']);				
		$companyEmail = makeSafe($_POST['companyEmail']);				
		$companyMSIC = makeSafe($_POST['companyMSIC']);				
		$companyMSICdescription = makeSafe($_POST['companyMSICdescription']);				
		$companyStateCode = makeSafe($_POST['companyStateCode']);				
		
		$companyQuotationTerms = $_POST['companyQuotationTerms'];
		$companyDOTerms = $_POST['companyDOTerms'];		
		$companyInvoiceTerms = $_POST['companyInvoiceTerms'];		
		$companyPOTerms = $_POST['companyPOTerms'];	
		$companyPVTerms = $_POST['companyPVTerms'];	
		
		$companyDueDate = makeSafe($_POST['companyDueDate']);	
		if(is_numeric($companyDueDate)){$companyDueDate = intval($companyDueDate);}else{$companyDueDate = 0;}		
		
		
		if($companyName !== ""){

			$target_dir = "logo/";
			$target_file = $target_dir . basename($_FILES["file"]["name"]);
			$uploadOK = 1;
			$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
			
			if((isset($_FILES["file"]["tmp_name"]))&&($_FILES["file"]["tmp_name"] !== "")){
				
				//check image is real image or fake
				$check = getimagesize($_FILES["file"]["tmp_name"]);
				if($check !== false){
					//file is a image, so proceed to save
					$uploadOK = 1;
					//check if file with this name exist
					if(file_exists($target_file)){
						//filename exist, so do nothing
						$uploadOK = 0;
					}else{
						//check file size, less than 400KB only allowed
						if($_FILES["file"]["size"] > 1000000){
							//file size too large, permitted only 400KB
							$uploadOK = 0;							
						}else{
							//check file type, only certain type of image format allowed JPG, JPEG, PNG
							if(($imageFileType !== "jpg") && ($imageFileType !== "jpeg") && ($imageFileType !== "png") && ($imageFileType !== "JPEG") && ($imageFileType !== "PNG") && ($imageFileType !== "JPG")){
								//wrong format, do nothing
								$uploadOK = 0;							
							}else{
								//all fine so proceed to save to uploads folder
								$temp = explode(".", $_FILES["file"]["name"]);								
								$randomNo = rand(0,10000);//get a random no for no reason
								$newFileName = "logo" . $randomNo . '.' . end($temp);
								$target_file2 = $target_dir . $newFileName;
								if(move_uploaded_file($_FILES["file"]["tmp_name"], $target_file2)){
									$uploadOK = 1;
									
								}else{
									//error uploading file
									$uploadOK = 0;
									$newFileName = "";									
								}								
							}							
						}						
					}				
				
				}else{
					//file is not a image, do nothing 
					$uploadOK = 0;					
				}				
			}else{
				//file upload not set or empty, do nothing 
				$uploadOK = 0;					
			}
			
			$sqlUpdateCompany = "UPDATE tbcompany SET company_name = '$companyName', company_address1 = '$companyAddress1', 
			company_address2 = '$companyAddress2',company_telFax = '$companyTelFax', company_quotationTerms = '$companyQuotationTerms', 
			company_deliveryOrderTerms = '$companyDOTerms', company_invoiceTerms = '$companyInvoiceTerms', 
			company_purchaseOrderTerms = '$companyPOTerms', company_paymentVoucherTerms = '$companyPVTerms', company_no = '$companyNo', company_dueDate = '$companyDueDate', 
			company_TINnumber = '$companyTinNo', company_SSTnumber	 = '$companySSTno', company_email = '$companyEmail', company_MSICcode ='$companyMSIC', company_MSICdescription = '$companyMSICdescription', company_stateCode = '$companyStateCode'";
			
			if($uploadOK == 1){
				$sqlUpdateCompany2 = ", company_logo = '$newFileName'";
			}else{
				$sqlUpdateCompany2 = "";
			}
			
			
			$sqlUpdateCompany = $sqlUpdateCompany.$sqlUpdateCompany2;
			
			mysqli_query($connection, $sqlUpdateCompany) or die("error in update company query");		
			header('Location: index.php');		
		
		
		
		
		
		}	
	
	
	}elseif(isset($_GET['idDeleteImage'])){
		
		//Delete the  employee image and update the database employee_picture
		$imageToDelete = $_GET['idDeleteImage'];
					
		
		$IPAddress = $_SERVER['SERVER_ADDR'];
		//iv4 = 127.0.0.1 iv6 = ::1
		if(($IPAddress == '127.0.0.1')||($IPAddress == '::1')){
			$deleteImage = getcwd() . "\logo\\" . $imageToDelete; //( LOCAL DEVELOPMENT COMPUTER)
		}else{
			$deleteImage = getcwd() . "/logo/" . $imageToDelete; //( ONLINE  SERVER COMPUTER )
		}		
		
		if(file_exists($deleteImage)){
			unlink($deleteImage); //delete the image			
		}		
		$sqlUpdateCompanyLogo = "UPDATE tbcompany SET company_logo = ''";
		mysqli_query($connection, $sqlUpdateCompanyLogo) or die("error in update company logo none query");
		
	}	
	
	//get the company name
	$sqlCompanyName = "SELECT * FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$rowCompanyName = mysqli_fetch_row($resultCompanyName);
?>

<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css">
<title>Online Payroll System</title>
<script src="js/jquery-3.2.1.min.js"></script>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<script>
function CheckAndSubmit(){
	var companyName = document.getElementById("companyName");
	if((companyName.value.length==0)||(companyName.value.trim() == "")){
		alert("Must enter Company Name!");
		companyName.focus();
		return false;
	}
	
	var r = confirm("Do you want to Update this Company?");
	if(r==false){
		return false;
	}
}

function CheckAndDelete(){
		var r = confirm("Do you want to DELETE this Logo Picture?");
		if(r==false){
			return false;
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
	font-size: 13px; /* Added font-size */
}
.mystyle td, .mystyle th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0
	border-style: solid;
	border-color: #CDD0D1;
}

.notfirst:hover
{
	background-color: #AFCCB0;
}
input:focus
{
	background-color: AFCCB0;
}
textarea:focus
{
	background-color: AFCCB0;
}
select:focus
{
	background-color: AFCCB0;
}




</style>
<?php 
	if($rowCompanyName[10] === ""){
		echo "<style type=\"text/css\">";
		echo "form{float:left;width:100%;}";
		echo "img{margin-top:-1000px;margin-left:100px;}";	
		echo "</style>";
	}
?>
</head>
<body>
<center>
<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>




<table border="0" cellpadding="0" width="500"><tr height="30"><td>&nbsp;</td></tr></table>
<table width="760" border="0" cellpadding="0"><tr height="40"><td><h1>Edit Company<h1></td></tr></table>


<table border="0" cellpadding="0" width="600"><tr height="20"><td>&nbsp;</td></tr></table>
<form id="uploadForm" action="companyAdmin.php" method="POST" enctype="multipart/form-data" onsubmit="return CheckAndSubmit()">
<table width="600" cellpadding="0" border="1" class="mystyle">
<tr bgcolor="9cc1c7"><td colspan="2">Company Information</td></tr>
<tr><td>Name</td><td><input type="text" name="companyName" id="companyName" maxLength="100" size="60" value="<?php if(is_null($rowCompanyName[1])==false){echo $rowCompanyName[1];}?>"><img src="images/einvoice.png" width="19"" height="19"></td></tr>
<tr><td>Address</td><td><input type="text" name="companyAddress1" id="companyAddress1" maxLength="100" size="60" value="<?php if(is_null($rowCompanyName[3])==false){echo $rowCompanyName[3];}?>"></td></tr>
<tr><td></td><td><input type="text" name="companyAddress2" id="companyAddress2" maxLength="100" size="60" value="<?php if(is_null($rowCompanyName[4])==false){echo $rowCompanyName[4];}?>"></td></tr>
<tr><td>Tel</td><td><input type="text" name="companyTelFax" id="companyTelFax" maxLength="30" size="15" value="<?php if(is_null($rowCompanyName[5])==false){echo $rowCompanyName[5];}?>"></td></tr>
<tr><td>State Code</td><td><input type="text" name="companyStateCode" id="companyStateCode" maxLength="2" size="4" value="<?php if(is_null($rowCompanyName[18])==false){echo $rowCompanyName[18];}?>"><img src="images/einvoice.png" width="19"" height="19"></td></tr>
<tr><td>Email</td><td><input type="text" name="companyEmail" id="companyEmail" maxLength="300" size="30" value="<?php if(is_null($rowCompanyName[15])==false){echo $rowCompanyName[15];}?>"></td></tr>
<tr><td>Company No</td><td><input type="text" name="companyNo" id="companyNo" maxLength="25" size="30" value="<?php if(is_null($rowCompanyName[2])==false){echo $rowCompanyName[2];}?>"><img src="images/einvoice.png" width="19"" height="19"></td></tr>
<tr><td>TIN No</td><td><input type="text" name="companyTinNo" id="companyTinNo" maxLength="20" size="30" value="<?php if(is_null($rowCompanyName[13])==false){echo $rowCompanyName[13];}?>"><img src="images/einvoice.png" width="19"" height="19"></td></tr>
<tr><td>SST No</td><td><input type="text" name="companySSTno" id="companySSTno" maxLength="40" size="30" value="<?php if(is_null($rowCompanyName[14])==false){echo $rowCompanyName[14];}?>"></td></tr>
<tr><td>MSIC Code</td><td><input type="text" name="companyMSIC" id="companyMSIC" maxLength="6" size="20" value="<?php if(is_null($rowCompanyName[16])==false){echo $rowCompanyName[16];}?>"><img src="images/einvoice.png" width="19"" height="19"></td></tr>
<tr><td>MSIC Description</td><td><textarea cols="55" rows="3" name="companyMSICdescription" id="companyMSICdescription" maxlength="300"><?php if(is_null($rowCompanyName[17])==false){echo $rowCompanyName[17];}?></textarea><img src="images/einvoice.png" width="19"" height="19"></td></tr>



<tr><td>Logo</td><td>
<?php 
	if($rowCompanyName[10] !== ""){
		echo "<img src='logo/$rowCompanyName[10]' width='142px' height='58px'><br><a href='companyAdmin.php?idDeleteImage=$rowCompanyName[10]'onclick=\"return CheckAndDelete()\" >delete Logo</a>";
	}else{
		echo "<input type=\"file\" name=\"file\" id=\"file\">";
	}	

?>




</td></tr>





<tr><td colspan="2" bgcolor="9cc1c7">Quotation Terms</td></tr>
<tr><td colspan="2"><textarea name="companyQuotationTerms" id="companyQuotationTerms"><?php if(is_null($rowCompanyName[6])==false){echo $rowCompanyName[6];}?></textarea></td></tr>

<tr><td colspan="2" bgcolor="9cc1c7">Delivery Order Terms</td></tr>
<tr><td colspan="2"><textarea name="companyDOTerms" id="companyDOTerms"><?php if(is_null($rowCompanyName[8])==false){echo $rowCompanyName[8];}?></textarea></td></tr>

<tr><td colspan="2" bgcolor="9cc1c7">Invoice Terms</td></tr>
<tr><td colspan="2"><textarea name="companyInvoiceTerms" id="companyInvoiceTerms"><?php if(is_null($rowCompanyName[9])==false){echo $rowCompanyName[9];}?></textarea></td></tr>
<tr><td>Due Date</td><td><input type="text" name="companyDueDate" id="companyDueDate" maxLength="3" size="4" value="<?php echo $rowCompanyName[11]?>"></td></tr>
<tr><td colspan="2" bgcolor="9cc1c7">Purchase Order Terms</td></tr>
<tr><td colspan="2"><textarea name="companyPOTerms" id="companyPOTerms"><?php if(is_null($rowCompanyName[7])==false){echo $rowCompanyName[7];}?></textarea></td></tr>
<tr><td colspan="2" bgcolor="9cc1c7">Payment Voucher Terms</td></tr>
<tr><td colspan="2"><textarea name="companyPVTerms" id="companyPVTerms"><?php if(is_null($rowCompanyName[12])==false){echo $rowCompanyName[12];}?></textarea></td></tr>
<tr><td colspan="2" align="right"><input type="submit" name="Submit" value="Edit Company"></td></tr>

</table>
</form>
<script>
function filePreview(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function (e) {
            $('#uploadForm + img').remove();
            $('#uploadForm').after('<img src="'+e.target.result+'" width="142px" height="58px"/>');
        }
        reader.readAsDataURL(input.files[0]);
    }
}

$("#file").change(function () {
    filePreview(this);
});

</script>

<table border="0" cellpadding="0" width="500"><tr height="20"><td>&nbsp;</td></tr></table>

</center>
<script src="ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replace('companyQuotationTerms');
	CKEDITOR.replace('companyDOTerms');
	CKEDITOR.replace('companyInvoiceTerms');
	CKEDITOR.replace('companyPOTerms');
	CKEDITOR.replace('companyPVTerms');
	
</script>
</body>

</html>