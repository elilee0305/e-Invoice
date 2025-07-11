<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	//get the company name
	$sqlCompanyName = "SELECT company_name FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$resultCompanyName2 = mysqli_fetch_row($resultCompanyName);	
	
	if(isset($_POST['Submit'])){		
		$searchName = $_POST['searchValue'];		
		$productType = $_POST['productType'];
		
		if($productType == "a"){
			
			if(trim($_POST['searchValue'])== ''){							
				$sqlProductList = "SELECT product_id,
				 product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom, product_clsCode
				FROM tbproduct ORDER BY product_name ASC";
			}else{
				$searchName = '%'.$searchName.'%'; 
				
				$sqlProductList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom, product_clsCode
				FROM tbproduct WHERE (product_name LIKE '$searchName') ORDER BY product_name";	
			}						
		}else{
			if(trim($_POST['searchValue'])== ''){
				$sqlProductList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom, product_clsCode
				FROM tbproduct WHERE (product_type = '$productType') ORDER BY product_name ASC";		
			}else{
				$searchName = '%'.$searchName.'%'; 
				$sqlProductList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom, product_clsCode
				FROM tbproduct WHERE (product_name LIKE '$searchName') AND (product_type = '$productType') 
				ORDER BY product_name ASC";				
			}			
		}		
		
	}else{
		$sqlProductList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom, product_clsCode 
		FROM tbproduct ORDER BY product_name ASC";
	}
	$resultProductList = mysqli_query($connection, $sqlProductList);		

	// Fetch all the classification data
	$sqlClassifications = "SELECT classification_id, classification_code, classification_desc FROM tbclassifications ORDER BY classification_code ASC";
	$resultClassifications = mysqli_query($connection, $sqlClassifications) or die("error in classification query");
?>

<html>
<head>
<title>Invoicing Billing System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<style type="text/css">
table.mystyle
{
	overflow: scroll;
	display: block;
	width: 910px;
	height: 350px;
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 12px; /* Added font-size */
}
.mystyle thead>tr {
  position: absolute;
  display: block;
  padding: 0;
  margin: 0;
  top: 154;
  background-color: transperant;
  width: 910px;
  z-index: -1;
}

.mystyle td, .mystyle th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0;
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
    width: 930px;
	margin-left: 20px;
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
.mystyle2 td, .mystyle2 th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0;
	border-style: solid;
	border-color: #CDD0D1;
}

input:focus
{
	background-color: AFCCB0;
}

div.myborder
{
	border:1px solid #CFE2E8;
	padding:10px 10px; 
	background:#9cc1c7;
	width:315;
	height: 25;
	border-radius:10px;
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
<script>
	
	function resetToCreateValues(){		
		//RESET ALL THE VALUES TO CREATE PRODUCT STATUS					
		document.getElementById("productProcessType").value = 1; //default CREATE
		document.getElementById("productEditID").value = 0; // product ID is 0
		document.getElementById("submitButton").value = "Create Product";
		document.getElementById("deleteButton").disabled = true; //delete button disables
		document.getElementById("addButtonLabel").disabled = true; //add + button disables
		
		$("#processTypeLabel").html("Create Product & Service"); //Title
		document.getElementById("productName").value = "";				
		document.getElementById("productUOM").value = "";				
		document.getElementById("productBuy").value = "";
		document.getElementById("productSell").value = ""; 
		document.getElementById("productClsCode").value = ""; 
		document.getElementById("productType4").checked = true; //SERVICE
	}
	
	
	
	
	function getButtonID(clickedID){
		//alert(clickedID);
		document.getElementById("buttonClicked").value = clickedID;
	}
	
	function CheckAndSubmit(){
		var clickedButton = document.getElementById("buttonClicked").value;
		//only submit form for SEARCH button click
		if(clickedButton=='submitButton'){
			
			var processType = document.getElementById("productProcessType").value;
			var classificationCode = document.getElementById("productClsCode").value;
			if(processType==1){
				//create product
				var productName = document.getElementById("productName").value;
				productName = productName.trimLeft();
				
				if(productName===""){
					alert("Must enter Product Service Name!");
					document.getElementById("productName").focus();
				}
				else if(classificationCode===""){
                alert("Must select a Classification Code!");
                document.getElementById("productClsCode").focus();
            	}else{
				
					var t = confirm("Do you want to Create this Product?");
					if(t==true){	
						CreateProduct();
					} 
				}
			
			}else{
				//edit product
				var productName = document.getElementById("productName").value;
				productName = productName.trimLeft();
				
				if(productName===""){
					alert("Must enter Product Service Name!");
					document.getElementById("productName").focus();
				}else if(classificationCode===""){
                alert("Must select a Classification Code!");
                document.getElementById("productClsCode").focus();
            	}else{				
					var t = confirm("Do you want to Edit this Product?");
					var editProductID = document.getElementById('productEditID').value;
					if(t==true){
						
						EditProduct(editProductID);
					} 
				}
			}		
			
			return false;
		}else if(clickedButton=='deleteButton') {
			var t = confirm("Do you want to Delete this Product?");
			if(t==true){
				DeleteProduct();
			} 
			return false;			
		}else if(clickedButton=='addButtonLabel') {			
			resetToCreateValues();			
			return false;			
		}	
		
	}

	function ShowProductDetail(x){
		var idProduct = x;	
		var data = "productID="+idProduct;
		
		//change label, product id
		$("#processTypeLabel").html("Edit Product & Service");
		document.getElementById("productEditID").value = idProduct;
		document.getElementById("submitButton").value = "Edit Product";
		document.getElementById("productProcessType").value = 2; //edit type
		document.getElementById("deleteButton").disabled = false; //delete button
		document.getElementById("addButtonLabel").disabled = false; //add + button
		
		 $.ajax({
			type : 'POST',
			url : 'getProductDetail.php',
			data : data,
			dataType : 'json',
			success : function(r){
			
				var js_array = r;
				
				for(var y = 0; y < js_array.length; y++){
					var productName = js_array[y][0]; 
					var productType = js_array[y][1]; 
					var productUOM = js_array[y][2]; 
					var productBuy = js_array[y][3]; 
					var productSell = js_array[y][4]; 	
					var productClsCode = js_array[y][5]; //Get the classification code		
				} 
				
				document.getElementById("productName").value = productName;	
				document.getElementById("productClsCode").value = productClsCode; // Set the classification code				
				document.getElementById("productUOM").value = productUOM;				
				document.getElementById("productBuy").value = productBuy;
				document.getElementById("productSell").value = productSell; 
				if(productType == 'p'){
					document.getElementById("productType3").checked = true; 
				}else{
					document.getElementById("productType4").checked = true; 
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}			
			
		})
		
		return false;
	}

	function DeleteProduct(){
		var deleteProductID = document.getElementById("productEditID").value;
		var data = "productID="+deleteProductID;
		
		$.ajax({
			type : 'POST',
			url : 'productDeleteProcess.php',
			data : data,
			dataType : 'json',
			success: function(r){
				if(r=='1'){
					//successfull delete
					//delete the row
					var rowID = "row"+deleteProductID;
					var row = document.getElementById(rowID);
					row.parentNode.removeChild(row);
					//number of records 					
					var originalNoOfRecords = document.getElementById("noOfRecordID").value;
					var newNoOfRecords = originalNoOfRecords - 1;
					var newNoOfRecordsText = newNoOfRecords+"&nbsp;records";				
					document.getElementById("noOfRecordID").value = newNoOfRecords;					
					$("#noOfRecordSpan").html(newNoOfRecordsText);
					//RESET ALL THE VALUES TO CREATE PRODUCT STATUS					
					resetToCreateValues();
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}	
		})
	}

	function CreateProduct(){
		var productName = document.getElementById("productName").value;
		var productClsCode = document.getElementById("productClsCode").value;
		var productUOM = document.getElementById("productUOM").value;
		var productBuy = document.getElementById("productBuy").value;
		var productSell = document.getElementById("productSell").value;
		var productClsCode = document.getElementById("productClsCode").value;

		if(document.getElementById("productType3").checked){
			var productType = "p";
		}else{
			var productType = "s";
		}
		
		$.ajax({
			type : 'POST',
			url : 'createProduct.php',
			data : {productNameValue: productName, productUOMvalue: productUOM, productClsCodeValue: productClsCode, productBuyValue: productBuy, productSellValue: productSell, productTypeValue: productType},
			dataType: 'json',
			success : function(w){
				if(w=='1'){
					resetToCreateValues();					
					 setTimeout(function() {
						alert("Product Created!");
						document.getElementById('searchButton').click();
					  },0) 
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
		})
	}

	function EditProduct(r){
		var productID = r;		
		var productName = document.getElementById("productName").value;
		var productUOM = document.getElementById("productUOM").value;
		var productBuy = document.getElementById("productBuy").value;
		var productSell = document.getElementById("productSell").value;
		var productClsCode = document.getElementById("productClsCode").value;

		if(document.getElementById("productType3").checked){
			var productType = "p";
		}else{
			var productType = "s";
		}
		
		$.ajax({
			type : 'POST',
			url : 'editProduct.php',
			data : {productIDvalue: productID, productNameValue: productName, productUOMvalue: productUOM, productClsCodeValue: productClsCode, productBuy, productSellValue: productSell, productTypeValue: productType},
			dataType: 'json',
			success : function(w){
				if(w=='1'){
					resetToCreateValues();					
					setTimeout(function() {
						alert("Product Edited!");
						//direct change the row values
						document.getElementById('searchButton').click();
					  },0)
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
		})
	}




</script>
</head>
<body>
<center>

<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>

<form action="productList.php" id="productListForm" method="post" autocomplete="off" onsubmit="return CheckAndSubmit()">
<div class="float-container">
	<div class="float-child">
	<table width="760" border="0" cellpadding="0"><tr height="50"><td>&nbsp;</td></tr></table>
<table width="900" border="0" cellpadding="0" align="center"><tr height="40"><td align="left" width="350"><h1>Product & Service Database</h1></td></table>
<table width="760" border="0" cellpadding="0"><tr height="15">
<?php
	if(isset($_POST['Submit'])){
		
		echo "<td align='right'>";
		echo "<select name='productType' id='productType' size='1'>";
		if($_POST['productType']=="a"){
			echo "<option value=\"a\">All</option>";
		}elseif($_POST['productType']=="p"){
			echo "<option value=\"p\">Product</option>";
		}elseif($_POST['productType']=="s"){
			echo "<option value=\"s\">Service</option>";
		}		
		echo "<option value=\"a\">All</option>";
		echo "<option value=\"p\">Product</option>";
		echo "<option value=\"s\">Service</option>";
		echo "</select>";
		if($_POST['searchValue']!=""){
			echo "<input type='text' name='searchValue' size='20' value=$_POST[searchValue]>";			
		}else{
			echo "<input type='text' name='searchValue' size='20'>";
		}	
	}else{
		echo "<td align='right'>";
		echo "<select name='productType' id='productType' size='1'>";		
		echo "<option value=\"a\">All</option>";
		echo "<option value=\"p\">Product</option>";
		echo "<option value=\"s\">Service</option>";
		echo "</select>";			
		echo "<input type='text' name='searchValue' size='20'>";
	}
?>
<input type="submit" name="Submit" id="searchButton" value="Search" onclick="getButtonID(this.id)">

</td>
</tr>
</table>
<?php 
	if(mysqli_num_rows($resultProductList) > 0){
		
		echo "<table cellpadding=0 border=0 height='25' width='900'><tr><td align='left'><span id='noOfRecordSpan'>".mysqli_num_rows($resultProductList)."&nbsp;records</span></td><td></td></tr></table>";
		echo "<table width=\"760\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		//to change the number records balance after delete
		$noOfRecordValue = mysqli_num_rows($resultProductList);
		echo "<input type='hidden' id='noOfRecordID' value='$noOfRecordValue'></td></tr></table>";
		
		echo "<table cellpadding='0' border='1' width='900' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:675'><p style=\"font-size:12px\"><b>Name</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Type</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>UOM</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>C.Code</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Buy</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Sell</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "</tr></thead>";
		while($rowProductList = mysqli_fetch_row($resultProductList)){
			$productID = $rowProductList[0];
			$idRowIDname = "row".$rowProductList[0];
			
			echo "<tr bgcolor='FFFFFF' id=$idRowIDname height='30' class='notfirst'>";
			echo "<td style='width:650'><p style=\"font-size:12px\">$rowProductList[1]</p></td>";
			if($rowProductList[2]=="p"){
				echo "<td><p style=\"font-size:12px\">Product</p></td>";	
			}elseif($rowProductList[2]=="s"){
				echo "<td><p style=\"font-size:12px\">Service</p></td>";	
			}
			echo "<td style= 'width:20'><p style=\"font-size:12px\">$rowProductList[5]</p></td>";	//UOM
			echo "<td style= 'width:30'><p style=\"font-size:12px\">$rowProductList[6]</p></td>";	//classification code
			echo "<td><p style=\"font-size:12px\">$rowProductList[3]</p></td>";	//buying price
			echo "<td><p style=\"font-size:12px\">$rowProductList[4]</p></td>";	//selling price		
			echo "<td><p style=\"font-size:12px\"><a href='' onclick=\" return ShowProductDetail($productID)\">edit</a></p></td>";
			echo "</tr>";
		}		
		echo "</table>";
			
	}else{
		echo "<table width=\"760\" border=\"0\" cellpadding=\"0\"><tr height=\"25\"><td>&nbsp;</td></tr></table>";
		echo "<table cellpadding='0' border='1' width='900' class='mystyle'>";
		echo "<thead><tr>";
		echo "<td style='width:675'><p style=\"font-size:12px\"><b>Name</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Type</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>UOM</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>C.Code</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Buy</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Sell</b></p></td>";
		echo "<td style='width:45'><p style=\"font-size:12px\"><b>Edit</b></p></td>";			
		echo "</tr></thead>";
		echo "</table>"; 
	}
?>
</div>
<div class="float-child2">	

<table width="50" border="0" cellpadding="0"><tr height="152"><td>&nbsp;</td></tr></table>	

<table cellpadding="0" border="1" class="mystyle2">
<tr bgcolor="#dfebd8"><th><span id="processTypeLabel">Create Product & Service</span></th></tr>

<tr><td><textarea cols="35" rows="3" name="productName" id="productName" maxlength="200" placeholder="Name"></textarea></td></tr>

<tr><td><input type="radio" name="productType2" id="productType3" value="p">Product
<input type="radio" name="productType2" id="productType4" value="s" checked>Service</td></tr>
<tr><td><input type="text" name="productUOM" id="productUOM" size="15" maxlength="15" value="" placeholder="UOM"></td></tr>
<tr><td><input type="text" name="productBuy" id="productBuy" size="15" value="" placeholder="Buying Price"></td></tr>
<tr><td><input type="text" name="productSell" id="productSell" size="15" value="" placeholder="Selling Price"></td></tr>
<tr>
    <td>
        <select name="productClsCode" id="productClsCode" value="" placeholder="Classification Codes" style="width: 50%; padding: 7px; border: 1px solid #ccc; border-radius: 4px; box-sizing: border-box;">
            <option value="" disabled selected style="color: black;">Classification Codes</option>
            <?php
            while ($row = mysqli_fetch_assoc($resultClassifications)) {
                echo "<option value='{$row['classification_id']}'>{$row['classification_code']} - {$row['classification_desc']}</option>";
            }
            ?>
        </select>
    </td>
</tr>
<tr><td>

<!--DEFAULT IS CREATE NEW PRODUCT SERVICE", 1 = create new product, 2 = edit existing product-->
<input type="hidden" name="productProcessType" id="productProcessType" value="1">
<input type="hidden" name="productEditID" id="productEditID" value="0">
<input type='hidden' id='buttonClicked' value=''>
<input type="submit" name="Submit" id="submitButton" value="Create Product" onclick="getButtonID(this.id)">
&nbsp;&nbsp;&nbsp;
<input type="submit" name="Submit" id="deleteButton" value="Delete Product" onclick="getButtonID(this.id)" disabled>
&nbsp;&nbsp;
<input type="submit" name="Submit" id="addButtonLabel" value="+" onclick="getButtonID(this.id)" disabled>


</td></tr>
</table>

</div>
</div>



</form>
</center>
</body>

</html>
