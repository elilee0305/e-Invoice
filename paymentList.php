<?php 
	//ini_set('display_errors', '1');
	session_start();
	if($_SESSION['userID']==""){
		//not logged in
		ob_start();
		header ("Location: index.php");
		ob_flush();
	}
	include ('connectionImes.php');
	
	/* set the proper error reporting mode */ 
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT); //to use for Transaction rollback , catch exception
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");
	include ('makeSafe.php'); 
	
	$paymentCancel = 0;
	
	if(isset($_POST['Submit'])){
		//search by date selected			
		$paymentDate1Converted = convertMysqlDateFormat($_POST['paymentDate1']);
		$paymentDate2Converted = convertMysqlDateFormat($_POST['paymentDate2']);
		$searchName = makeSafe($_POST['searchName']);
		
		$searchTypeValue = $_POST['searchType'];
		$searchType = explode('|',$searchTypeValue);		
		$searchTypeNameValue = $searchType[0]."|".$searchType[1];
		$searchTypeName = $searchType[1];

		$paymentMethodValue = $_POST['paymentMethod'];
		$paymentMethod = explode('|',$paymentMethodValue);		
		$paymentMethodNameValue = $paymentMethod[0]."|".$paymentMethod[1];
		$paymentMethodName = $paymentMethod[1];
		
		if(isset($_POST['chkPaymentCancel'])){
			$paymentCancel = 1;
		}
		
		if($searchType[0] == 1){
			//all
			$sqlPaymentList2 = "";						
			if($paymentCancel == 1){
				$sqlPaymentList3 = "AND (payment_status = 0) AND (payment_date BETWEEN '$paymentDate1Converted' AND '$paymentDate2Converted') ";
			}else{
				$sqlPaymentList3 = "AND (payment_status <> 0) AND (payment_date BETWEEN '$paymentDate1Converted' AND '$paymentDate2Converted') ";	
			}
			
			if($paymentMethod[0]==0){
				$sqlPaymentList4 = "";
			}else{
				$sqlPaymentList4 = "AND (payment_paymentMethodID = '$paymentMethod[0]') ";
			}
		}elseif($searchType[0] == 2){
			//name
			$searchName = '%'.$searchName.'%';
			
			if($paymentCancel == 1){
				$sqlPaymentList2 = "AND (payment_status = 0) AND (customer_name LIKE '$searchName') ";
			}else{
				$sqlPaymentList2 = "AND (payment_status <> 0) AND (customer_name LIKE '$searchName') ";
			}
			
			$sqlPaymentList3 = "AND (payment_date BETWEEN '$paymentDate1Converted' AND '$paymentDate2Converted') ";
			if($paymentMethod[0]==0){
				$sqlPaymentList4 = "";
			}else{
				$sqlPaymentList4 = "AND (payment_paymentMethodID = '$paymentMethod[0]') ";
			}
			
		}else{
			//payment no
			if($paymentCancel == 1){
				$sqlPaymentList2 = "AND (payment_status = 0) AND (payment_no = '$searchName') ";
			}else{
				$sqlPaymentList2 = "AND (payment_status <> 0) AND (payment_no = '$searchName') ";
			}
			
			$sqlPaymentList3 = "";
			$sqlPaymentList4 = "";
		}	
		
		$sqlPaymentList = "SELECT customer_id, customer_name, payment_id, payment_no, payment_date, payment_amount, payment_attachment  
		FROM tbcustomer, tbpayment WHERE (customer_id = payment_customerID) ";
		
		$sqlPaymentList = $sqlPaymentList.$sqlPaymentList2.$sqlPaymentList3.$sqlPaymentList4;		
		
	}else{
		//default day is today month begin & end
		$dt = date('Y-m-d');
		$paymentDate1Converted = date("Y-m-01", strtotime($dt));
		$paymentDate2Converted = date("Y-m-t", strtotime($dt));
		
		$sqlPaymentList = "SELECT customer_id, customer_name, payment_id, payment_no, payment_date, payment_amount, payment_attachment
		FROM tbcustomer, tbpayment WHERE (customer_id = payment_customerID) ";
		
		$sqlPaymentList3 = "AND (payment_status <> 0) AND (payment_date BETWEEN '$paymentDate1Converted' AND '$paymentDate2Converted') ";
		
		$sqlPaymentList = $sqlPaymentList.$sqlPaymentList3;
	}	
	
	$sqlPaymentList5 = "ORDER BY payment_date DESC, payment_id DESC";	
	$sqlPaymentList = $sqlPaymentList.$sqlPaymentList5;
	
	//invoice list	
	$resultPaymentList = mysqli_query($connection, $sqlPaymentList) or die("error in invoice list query");
	
	//payment method
	$sqlPaymentMode = "SELECT paymentMethod_id, paymentMethod_name FROM tbpaymentmethod ORDER BY paymentMethod_id ASC";
	$resultPaymentMode = mysqli_query($connection, $sqlPaymentMode) or die("error in payment method query");
?>
<html>
<head>
<title>Online Invoice System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
	$( function() {
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
		$( "#demo1" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );	
</script>

<style type="text/css">
table.mystyle
{
	overflow: scroll;
	display: block;
	width: 820px;
	height: 350px;
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
}

.mystyle thead>tr {
  position: absolute;
  display: block;
  padding: 0;
  margin: 0;
  top: 176;
  background-color: transperant;
  width: 820px;
  z-index: -1
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

.float-container{
    display: flex;
}
.float-child{
    width: 850px;
	margin-left: 50px;
}
.float-child2{
    flex-grow: 1;
}

table.mystyle2
{
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 12px; /* Added font-size */
}
.mystyle2 td, mystyle2 th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0
	border-style: solid;
	border-color: #CDD0D1;
}

</style>
<script>
	function getButtonID(clickedID){
		//alert(clickedID);
		document.getElementById("buttonClicked").value = clickedID;
	}
	
	function CheckAndSubmit(){
		var clickedButton = document.getElementById("buttonClicked").value;
		//only submit form for SEARCH button click
		if(clickedButton=='cAN'){
			var t = confirm("Do you want to Cancel this Payment?");
			if(t==true){
				ProcessPaymentCancel();
			}
			return false;
		}else if(clickedButton=='pRT') {
			var idPaymentPrint = document.getElementById("idPaymentStore").value;
			var idCustomerPrint = document.getElementById("idCustomerStore").value;
			
			//console.log(idCustomerPrint);
			var url = 'printPayment.php?idCustomer=' + idCustomerPrint + '&idPayment=' + idPaymentPrint;
			window.open(url, '_blank');
			
			
			return false;			
		}else if(clickedButton=='aTT') {
			var y = confirm("Do you want to Attach image to Payment?");
			if(y==true){
				ProcessPaymentAttach();
			}
			
			return false;
		}	
	}

	function ProcessPaymentCancel(){		
		
		var aInvoiceIDcancel = JSON.parse(localStorage.getItem("InvoiceIDstorage"));		
		var idPaymentCancel = document.getElementById("idPaymentStore").value;
		
		$.ajax({
			type : 'POST',
			url : 'paymentCancelProcess.php',
			data : {paymentID: idPaymentCancel, invoiceID: JSON.stringify(aInvoiceIDcancel)},
			dataType : 'json',
			success : function(w)
			{
				if(w=="1"){					
					localStorage.clear();
					//remove all existing tbody tr rows
					$("#myTable").find("tbody tr").remove();
					//disable the Print & Cancel buttons
					document.getElementById("pRT").disabled = true;
					document.getElementById("cAN").disabled = true;
					
					//delete the row
					var rowID = "row"+idPaymentCancel;
					var row = document.getElementById(rowID);
					row.parentNode.removeChild(row);
					
					//number of records 
					
					var originalNoOfRecords = document.getElementById("noOfRecordID").value;
					var newNoOfRecords = originalNoOfRecords - 1;
					var newNoOfRecordsText = newNoOfRecords+"&nbsp;records";				
					document.getElementById("noOfRecordID").value = newNoOfRecords;
					
					$("#noOfRecordSpan").html(newNoOfRecordsText);
					document.getElementById("spanPaymentAmount").innerHTML = "";
					document.getElementById("customerPaymentName").innerHTML = "";
					document.getElementById("customerPaymentNo").innerHTML = "";
				 
					document.getElementById("pictureFileName").value = "";
					
					
					// Clear existing image preview inside the <td>
					$('#imagePreview').html('');
					$('#imagePreview').html('<img id="imageDisplay" src="" width="200" height="200"/>');
					
					var imgElement = document.getElementById("imageDisplay");
					imgElement.src = "logo/companyblank.jpg";
					
					var imgElementLink = document.getElementById("deleteImageLink");	
					imgElementLink.innerHTML = "";
					 
				}else if(w=="0"){
					alert("Error in Processing Payment Cancel");
				}
			}
			
		})
	}

	function ShowPaymentDetail(x,y,z,t,g,p){
		var idPayment = x;
		var idCustomer = t;
		var pictureFile = p;
		//console.log(pictureFile);
		
		pictureFile = pictureFile.trim();
		displayPicture(pictureFile);
		
		// Clear existing attach button inside the <td>
		$('#attachButton').html('');
		
		document.getElementById("customerPaymentName").innerHTML = y;
		document.getElementById("customerPaymentNo").innerHTML = z;
		document.getElementById("spanPaymentAmount").innerHTML = g;
		
		var data = "paymentID="+idPayment;
		//alert(data);
		document.getElementById("idPaymentStore").value = idPayment;
		document.getElementById("idCustomerStore").value = idCustomer;
		document.getElementById("pictureFileName").value = pictureFile;
		
		$.ajax({
			type : 'POST',
			url : 'getPaymentDetail.php',
			data : data,
			dataType : 'json',
			success : function(r)
			{
				var js_array = r;
				//remove all existing tbody tr rows
				$("#myTable").find("tbody tr").remove();
				
				//enable the Print & Cancel buttons if the payment not cancel
				var idPaymentCancelValue = document.getElementById("idPaymentCancelStore").value
				if(idPaymentCancelValue == 1){
					//nothing, leave both disabled
				}else{
					document.getElementById("pRT").disabled = false;
					document.getElementById("cAN").disabled = false;
				}
				
				//get a reference to the table tbody
				var tbodyRef = document.getElementById('myTable').getElementsByTagName('tbody')[0];
				
				//declare an empty array to store invoice id
				const aInvoiceID = [];
				
				for(var y = 0; y < js_array.length; y++){
					var invoiceNo = js_array[y][0];
					var invoiceAmount = js_array[y][1];					
					//aInvoiceID[y] = js_array[y][2]; //SINGLE VALUES ASSIGN
					//PUSH FUNCTION to assign multiple values to array
					aInvoiceID.push([js_array[y][2], js_array[y][1]]);	
					
					// Insert a row at the end of table
					var newRow = tbodyRef.insertRow();
					
					// Insert a cell at the end of the row
					var newCell = newRow.insertCell(0);
					var newCell2 = newRow.insertCell(1);
					
					newCell.innerHTML = invoiceNo;
					newCell2.innerHTML = invoiceAmount;
				}				
				
				//store the invoice id array inside local storage after making it into string 
				localStorage.setItem("InvoiceIDstorage", JSON.stringify(aInvoiceID));
			
			}
		}
		)
		return false;
	}
	
	function displayPicture(pictureFile){
		var x = pictureFile;
		
		if(x){
			
			 // Add a cache-busting query parameter to ensure the browser doesn't use a cached version of the image
			var timestamp = new Date().getTime();
			
			
			
			if(x.split('.').pop().toLowerCase()==='pdf'){
				$('#imagePreview').html('<embed id="pdfDisplay" src="" width="200" height="200" type="application/pdf" />');
				var pdfElement = document.getElementById("pdfDisplay");
				x = "paymentreceived/" + x + "?" + timestamp;
				//pdf file, hide the image and show pdf
				
				
				pdfElement.src = x;
				pdfElement.style.display = 'block';
				
				
			}else{
				$('#imagePreview').html('<img id="imageDisplay" src="" width="200" height="200"/>');
				var imgElement = document.getElementById("imageDisplay");
				x = "paymentreceived/" + x + "?" + timestamp;
				//image file
				
				
				imgElement.src = x;
				imgElement.style.display = 'block';
			}
			
			//display delete link			
			var imgElementLink = document.getElementById("deleteImageLink");	
			imgElementLink.innerHTML = '<a href="#" onclick="return deleteImage()">delete attachment</a>';
		
		}else {
				$('#imagePreview').html('<img id="imageDisplay" src="" width="200" height="200"/>');
				
				var imgElement = document.getElementById("imageDisplay");
				imgElement.src = "logo/companyblank.jpg";
				//create the FILE button
				var imgElementLink = document.getElementById("deleteImageLink");	
				imgElementLink.innerHTML = '<input type="file" name="file" id="fileInput">';
		}
		
	}

		function deleteImage(){
			
			var t = confirm("Do you want to DELETE this Attachment?");
			if(t==true){
				var idPayment = document.getElementById("idPaymentStore").value;
				var pictureFile = document.getElementById("pictureFileName").value;
				var customerName = document.getElementById("customerPaymentName").innerHTML;
				var paymentNo = document.getElementById("customerPaymentNo").innerHTML;
				var customerID = document.getElementById("idCustomerStore").value;
				var paymentAmount = document.getElementById("spanPaymentAmount").innerHTML;
		
				$.ajax({
					type : 'POST',
					url : 'deletePaymentAttachment.php',
					data : {paymentID: idPayment, pictureFileName: pictureFile},
					dataType : 'json',
					success : function(r){
						if(r=="2"){
							document.getElementById("pictureFileName").value = "";
							
							// Clear existing image preview inside the <td>
							$('#imagePreview').html('');
							$('#imagePreview').html('<img id="imageDisplay" src="" width="200" height="200"/>');
							
							var imgElement = document.getElementById("imageDisplay");
							imgElement.src = "logo/companyblank.jpg";
							
							//create the FILE button
							var imgElementLink = document.getElementById("deleteImageLink");	
							imgElementLink.innerHTML = '<input type="file" name="file" id="fileInput">';
							
							//remove the image icon from the row
							var rowID = "row"+idPayment;
							var row = document.getElementById(rowID);
							if(row){
								var imageColumn = row.cells[4];
								var viewLink = row.cells[5];
								if(imageColumn){
									imageColumn.innerHTML = "";
								}
								
								if(viewLink){
									//empty file name string, you should use backticks (`) instead of single quotes (')
									var emptyFileName = "";
									viewLink.innerHTML = `<p style="font-size:12px"><a href="javascript:void(0)" onclick="return ShowPaymentDetail('${idPayment}', '${customerName}', '${paymentNo}', '${customerID}', '${paymentAmount}', '${emptyFileName}')">view</a></p>`;
								}
							}
						}
					}
				})
			}else{	
				return false;
			}
		}
		
		function ProcessPaymentAttach(){
			var idPayment = document.getElementById("idPaymentStore").value;
			var customerName = document.getElementById("customerPaymentName").innerHTML;
			var paymentNo = document.getElementById("customerPaymentNo").innerHTML;
			var customerID = document.getElementById("idCustomerStore").value;
			var paymentAmount = document.getElementById("spanPaymentAmount").innerHTML;
			
			//create FormData object to store the file and payment id
			var formData = new FormData();
			formData.append('file', $('#fileInput')[0].files[0]); // add the file to FormData
			formData.append('paymentID', idPayment)
			
			$.ajax({
				type : 'POST',
				url : 'attachPaymentAttachment.php',
				data : formData,
				contentType : false,
				processData : false,
				dataType : 'text',
				success : function(r)
				{
					
					let uploadStatus = r;
					let totalStatus = uploadStatus.split('|');
					let statusFile = totalStatus[0];
					let pictureFile = totalStatus[1];
					
					if(statusFile=="3"){	
						//Uploaded file and named attachment
						displayPicture(pictureFile);
						
						// Clear existing attach button inside the <td>
						$('#attachButton').html('');
						document.getElementById("pictureFileName").value = pictureFile;
						
						//show the image icon from the row
						var rowID = "row"+idPayment;
						var row = document.getElementById(rowID);
						
						if(row){
							var imageColumn = row.cells[4];
							var viewLink = row.cells[5];
							if(imageColumn){
								imageColumn.innerHTML = "<img src=\"images/attachment.png\" width=\"16\" height=\"16\">";
							}
							
							if(viewLink){
								//empty file name string, you should use backticks (`) instead of single quotes (')
								
								viewLink.innerHTML = `<p style="font-size:12px"><a href="javascript:void(0)" onclick="return ShowPaymentDetail('${idPayment}', '${customerName}', '${paymentNo}', '${customerID}', '${paymentAmount}', '${pictureFile}')">view</a></p>`;
							}

						}
					}else if(statusFile=="0"){
						alert("filename exist");
					}else if(statusFile=="4"){
						alert("error uploading file");
					}
				}
			})
			return false;
		}
</script>
</head>
<body>
<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
<form action="paymentList.php" id="paymentListForm" method="post" enctype="multipart/form-data" onsubmit="return CheckAndSubmit()">
<div class="float-container">
	<div class="float-child">
		
<table width="760" border="0" cellpadding="0"><tr height="50"><td>&nbsp;</td></tr></table>
<table width="760" border="0" cellpadding="0"><tr height="40"><td align="left" width="350"><h1>Payment List</h1></td><td width="350"></td></tr></table>
<table width="760" border="0" cellpadding="0">
<tr height="15"><td>&nbsp;</td></tr>
</table>

<table border="0" cellpadding="0" width="760">
<tr height="20">

<td><select name="searchType" id="searchType" size="1">
<?php if(isset($_POST['Submit'])){echo "<option value=\"$searchTypeNameValue\">$searchTypeName</option>";}?>
<option value="1|All">All</option>
<option value="2|Customer Name">Customer Name</option>
<option value="3|Payment No">Payment No</option>
</select>

</td>
<td><input type="text" name="searchName" size="15" maxlength="30" value="<?php 
	if(isset($_POST['Submit'])){echo $_POST['searchName'];}?>"></td>
<td>
<?php 
	echo "<select name='paymentMethod' id='paymentMethod'>";
	if(isset($_POST['Submit'])){echo "<option value=\"$paymentMethodNameValue\">$paymentMethodName</option>";}
	echo "<option value=\"0|All\">All</option>";
	if(mysqli_num_rows($resultPaymentMode) > 0){		
		
		while($rowPaymentMethod=mysqli_fetch_array($resultPaymentMode)){
			$valueText = $rowPaymentMethod[0]."|".$rowPaymentMethod[1];
			echo"<option value=\"$valueText\">$rowPaymentMethod[1]</option>";
		}
	}
	echo "</select>&nbsp;";
?>
</td>
<td>
<input id="demo1" type="text" name="paymentDate1" size="7" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['paymentDate1'];
	}else{
		//echo date('d/m/Y');
		echo date("01/m/Y", strtotime($dt));
	}?>">&nbsp;&nbsp;TO

</td>
<td>
<input id="demo2" type="text" name="paymentDate2" size="7" value="<?php 
	if(isset($_POST['Submit'])){
		echo $_POST['paymentDate2'];
	}else{
		//echo date('d/m/Y');
		echo date("t/m/Y", strtotime($dt));
	}?>">&nbsp;

</td>
<td><input id="sEARCH" type="submit" name="Submit" value="Search" onclick="getButtonID(this.id)">&nbsp;&nbsp;
<input type="checkbox" name="chkPaymentCancel" value="1" <?php if($paymentCancel == 1){echo "checked";}?>>
<img src="images/deletemark.jpg" width="16"" height="16">
</td></tr>
</table>

<?php 
	if(mysqli_num_rows($resultPaymentList) > 0){
		echo "<table width='760' cellpadding='0' border='0'><tr><td align='left'><span id='noOfRecordSpan'>".mysqli_num_rows($resultPaymentList)."&nbsp;records</span></td><td align='right'></td></tr></table>";
		echo "<table width=\"760\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;";
		//to change the number records balance after cancel
		$noOfRecordValue = mysqli_num_rows($resultPaymentList);
		echo "<input type='hidden' id='noOfRecordID' value='$noOfRecordValue'></td></tr></table>";
			
		echo "<table cellpadding='0' border='1' class='mystyle'>";		
		echo "<thead><tr><td style='width:95'><p style=\"font-size:12px\"><b>Payment No</b></p></td><td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td><td style='width:400'><p style=\"font-size:12px\"><b>Customer</b></p></td><td style='width:90'><p style=\"font-size:12px\"><b>Amount</b></p></td><td style='width:25'><p style=\"font-size:12px\"><b>A</b></p></td><td style='width:60'><p style=\"font-size:12px\"><b>View</b></p></td></tr></thead>";
		while($rowPaymentList = mysqli_fetch_row($resultPaymentList)){
			$idPayment = $rowPaymentList[2];
			$idRowIDname = "row".$rowPaymentList[2];
			$paymentNo = $rowPaymentList[3];
			$customerName = $rowPaymentList[1];
			$paymentAmount = $rowPaymentList[5];
			$attachmentName = $rowPaymentList[6];
			
			$customerID = $rowPaymentList[0];
			
			
			if(date('Y-m-d')==$rowPaymentList[4]){
				echo "<tr bgcolor='e1f7e7' id=$idRowIDname height='30' class='notfirst'>";
			}else{	
				echo "<tr id=$idRowIDname height='30' class='notfirst'>";
			}
			
			echo "<td style='width:100'><p style=\"font-size:12px\">$rowPaymentList[3]</p></td>";			
			echo "<td style='width:100'><p style=\"font-size:12px\">".date("d/m/Y",strtotime($rowPaymentList[4]))."</p></td>";
			echo "<td style='width:470'><p style=\"font-size:12px\">$rowPaymentList[1]</p></td>";
			echo "<td style='width:100' align='right'><p style=\"font-size:12px\">$rowPaymentList[5]</p></td>";	
			
			//show icon only if attachment exist
			if($rowPaymentList[6]==""){
				echo "<td style='width:25'><p style=\"font-size:12px\"></p></td>";	
			}else{
				echo "<td style='width:25'><img src=\"images/attachment.png\" width=\"16\" height=\"16\"></td>";	
			}
			//<img src="images/mainpicture1.jpg" width="400"" height="266">
			
			//RETURN VERY IMPORTANT TO PREVENT FORM FROM SUBMITTING
			echo "<td style='width:50'><p style=\"font-size:12px\"><a href='' onclick=\" return ShowPaymentDetail($idPayment, '$customerName', '$paymentNo', $customerID, $paymentAmount, '$attachmentName')\">view</a></p></td>";			
			echo "</tr>";			
		}		
		echo "</table>";
	}else{
		echo "<table width=\"760\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table cellpadding='0' border='1' class='mystyle'>";		
		echo "<thead><tr><td style='width:95'><p style=\"font-size:12px\"><b>Payment No</b></p></td><td style='width:100'><p style=\"font-size:12px\"><b>Date</b></p></td><td style='width:400'><p style=\"font-size:12px\"><b>Customer</b></p></td><td style='width:90'><p style=\"font-size:12px\"><b>Amount</b></p></td><td style='width:25'><p style=\"font-size:12px\"><b>A</b></p></td><td style='width:60'><p style=\"font-size:12px\"><b>View</b></p></td></tr></thead>";
		echo "</table>";
	}
?>
	</div>
	<div class="float-child2">		
		
		<table width="350" border="0" cellpadding="0">
		<tr height="172" valign="bottom"><td>
		<span id="customerPaymentName"></span>
		<br>
		<span id="customerPaymentNo"></span>
		</td></tr>
		
		</table>	

		<div id="temporaryTable">
		
		<table width="250" id="myTable" cellpadding='0' border='1' class='mystyle2'>
			<thead>
				<tr bgcolor="#dfebd8">
					<th>Invoice No</th>
					<th>Amount</th>
				</tr>
			</thead>
			<tbody>
				<!--<td></td><td></td>-->
			</tbody>
			<tfoot>
				<tr bgcolor="#dfebd8">
					<th>Total</th>
					<td><span id="spanPaymentAmount"><span></td>
				</tr>
				<tr>
					<td colspan="2">
						<input type='hidden' id='buttonClicked' value=''>
						<input type='hidden' id='idPaymentStore' value=''>
						<input type='hidden' id='idCustomerStore' value=''>
						<input type='hidden' id='pictureFileName' value=''>
						<input type='hidden' id='customerName' value=''>
						
						<input type='hidden' id='idPaymentCancelStore' value='<?php echo $paymentCancel;?>'>
						
						<input id="pRT" type="submit" name="Submit" value="Print" disabled onclick="getButtonID(this.id)">&nbsp;&nbsp;
						<input id="cAN" type="submit" name="Submit" value="Cancel Payment" disabled onclick="getButtonID(this.id)">
					</td>
					
				</tr>
			<tfoot>
		</table>
		</div>
		<br>
		<div id="temporaryImageTable">
			<table width="250" id="myTable2" cellpadding='0' border='1' class='mystyle2'>
			<tr>
				<td id="imagePreview">
					<!--default show this-->
					<img id="imageDisplay" src="logo/companyblank.jpg" alt="" width="200" height="200">
					<!--hide this pdf-->
					<embed id="pdfDisplay" src="" width="200" height="200" type="application/pdf" style="display:none;">
					
				</td>
			</tr>
			
			
			
			
			<tr><td id="deleteImageLink"></td></tr>
			<tr><td id="attachButton"></td></tr>
			</table>
		</div>
		
	</div>
</div>
</form>

<script>
function filePreview(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
		var reader = new FileReader();
        var fileTpe = file.type;
		
		
		reader.onload = function (e) {
            // Clear existing image preview inside the <td>
            $('#imagePreview').html('');
            
			//check if file is image or pdf
			if(fileTpe.match('image.*')){
				
				// Insert the new image preview inside the specific <td>
				$('#imagePreview').html('<img id="imageDisplay" src="'+e.target.result+'" width="200" height="200"/>');
				
			}else if(fileTpe === 'application/pdf'){
				// Insert the new pdf preview inside the specific <td>
				$('#imagePreview').html('<embed id="pdfDisplay" src="'+e.target.result+'" width="200" height="200" type="application/pdf" />');
				
			}
			
			// Clear existing attach button inside the <td>
			$('#attachButton').html('');
			//create the Attach button
			$('#attachButton').html('<input id="aTT" type="submit" name="Submit" value="Attach" onclick="getButtonID(this.id)">');
			
		}
        reader.readAsDataURL(input.files[0]);
    }
}

// Use event delegation: bind the event to a parent element (e.g., the document or a form element)
$(document).on('change', '#fileInput', function () {
    filePreview(this); // Call file preview when file input changes
});

</script>
</body>
</html>
