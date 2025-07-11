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
	
	//create the quotation record
	if(isset($_POST['Submit'])){
		$customerID = $_POST['customerIDvalue'];
		$purchaseOrderNo = makeSafe($_POST['purchaseOrderNo']);
		$datePurchaseOrder = convertMysqlDateFormat($_POST['purchaseOrderDate']);		
		$purchaseOrderFrom = makeSafe($_POST['purchaseOrderFrom']);
		$purchaseOrderTitle = makeSafe($_POST['purchaseOrderTitle']);
		
		$purchaseOrderContent = $_POST['purchaseOrderContent'];		
		$purchaseOrderTerms = $_POST['purchaseOrderTerms'];		
			
		$customerAttentionValue = makeSafe($_POST['customerAttentionValue']);
		$customerEmailValue = makeSafe($_POST['customerEmailValue']);
		//check if the rows existing 
		
		$subTotal = 0.00;
		$taxTotal = 0.00;
		$grandTotal = 0.00;
		$discountTotal = 0.00;
		$totalAfterDiscount = 0.00;
		$roundAmount = 0.00;
		$groundTotalRound = 0.00;
		$roundStatus = 0;
		
		if(isset($_POST['noCol1'])){
			$subTotal = makeSafe($_POST['subTotal']);
			$taxTotal = makeSafe($_POST['taxTotal']);
			$grandTotal = makeSafe($_POST['grandTotal']);
			$discountTotal = makeSafe($_POST['discountTotal']);
			$totalAfterDiscount = makeSafe($_POST['totalAfterDiscount']);
			$roundAmount = makeSafe($_POST['roundAmount']);
			$groundTotalRound = makeSafe($_POST['groundTotalRound']);		
			
			if(is_numeric($subTotal)){					
			}else{
				$subTotal = 0.00;
			}
			if(is_numeric($taxTotal)){					
			}else{
				$taxTotal = 0.00;
			}
			if(is_numeric($grandTotal)){					
			}else{
				$grandTotal = 0.00;
			}			
			if(is_numeric($discountTotal)){					
			}else{
				$discountTotal = 0.00;
			}	
			if(is_numeric($totalAfterDiscount)){					
			}else{
				$totalAfterDiscount = 0.00;
			}
			if(is_numeric($roundAmount)){					
			}else{
				$roundAmount = 0.00;
			}	
			
			if(is_numeric($groundTotalRound)){					
			}else{
				$groundTotalRound = 0.00;
			}
			
			if(isset($_POST['roundStatus'])){
				$roundStatus = $_POST['roundStatus'];
			}else{
				$roundStatus = 0;
			}			
		}		
		
		$sqlCreatePurchaseOrder = "INSERT INTO tbpurchaseorder(purchaseOrder_id, purchaseOrder_no, purchaseOrder_date, purchaseOrder_customerID, 
		purchaseOrder_title, purchaseOrder_content, purchaseOrder_from	, purchaseOrder_terms, purchaseOrder_attention, purchaseOrder_email, 
		purchaseOrder_subTotal, purchaseOrder_taxTotal, purchaseOrder_grandTotal, purchaseOrder_discountTotal, purchaseOrder_totalAfterDiscount, 
		purchaseOrder_roundAmount, purchaseOrder_grandTotalRound, purchaseOrder_roundStatus) 
		VALUES(NULL, '$purchaseOrderNo', '$datePurchaseOrder', '$customerID', '$purchaseOrderTitle', '$purchaseOrderContent', '$purchaseOrderFrom', 
		'$purchaseOrderTerms', '$customerAttentionValue', '$customerEmailValue', '$subTotal', 
		'$taxTotal', '$grandTotal', '$discountTotal', '$totalAfterDiscount', '$roundAmount', '$groundTotalRound', '$roundStatus')";
		
		mysqli_query($connection, $sqlCreatePurchaseOrder) or die("error in create purchase order query");
		
		//create the quotation detail records
		$purchaseOrderID = mysqli_insert_id($connection);
		
		if(isset($_POST['noCol1'])){
			$aNoColumn1 = $_POST['noCol1'];			
			$aNoColumn2 = $_POST['noCol2'];
			$aNoColumn3 = $_POST['noCol3'];
			$aNoColumn4 = $_POST['noCol4'];
			$aNoColumn5 = $_POST['noCol5'];
			$aNoColumn6 = $_POST['noCol6'];
			$aNoColumn7 = $_POST['noCol7']; //select tax rate ID
			$aNoColumn8 = $_POST['noCol8']; //tax rate percent
			$aNoColumn9 = $_POST['noCol9']; //tax total
			$aNoColumn10 = $_POST['noCol10']; //grandtotal			
			$aNoColumn11 = $_POST['noCol11']; //discount Percent
			$aNoColumn12 = $_POST['noCol12']; //discount Total
			$aNoColumn13 = $_POST['noCol13']; //totalAfterDiscount			
			
			$aNoCheckbox = $_POST['purchaseOrderCheckbox'];//this is not an array but comma separated text because array cannot be hidden field
			//explode the values and put into an array
			$aNoCheckboxSplit = explode(',', $aNoCheckbox);
			
			//echo $aNoCheckbox;
			//var_dump($test);
			
			$countNo = count($aNoColumn1);
			$sortID = 0;
			for($i=0; $i < $countNo; $i++){
				$noValue1 = $aNoColumn1[$i];
				$noValue2 = $aNoColumn2[$i];
				$noValue3 = $aNoColumn3[$i];
				$noValue4 = $aNoColumn4[$i];
				$noValue5 = $aNoColumn5[$i];
				$noValue6 = $aNoColumn6[$i];
				$noValue7 = $aNoColumn7[$i];
				$noValue8 = $aNoColumn8[$i];
				$noValue9 = $aNoColumn9[$i];
				$noValue10 = $aNoColumn10[$i];				
				$noValue11 = $aNoColumn11[$i];
				$noValue12 = $aNoColumn12[$i];
				$noValue13 = $aNoColumn13[$i];
				
				$noValueCheckbox = $aNoCheckboxSplit[$i];
				$sortID = $sortID + 1;
				//qty
				if(is_numeric($noValue3)){					
				}else{
					$noValue3 = 0.00;
				}
				//@price
				if(is_numeric($noValue5)){					
				}else{
					$noValue5 = 0.00;
				}
				//row total
				if(is_numeric($noValue6)){					
				}else{
					$noValue6 = 0.00;
				}
				//discount percent
				if(is_numeric($noValue11)){					
				}else{
					$noValue11 = 0.00;
				}
				//discount amount
				if(is_numeric($noValue12)){					
				}else{
					$noValue12 = 0.00;
				}
				//total after discount
				if(is_numeric($noValue13)){					
				}else{
					$noValue13 = 0.00;
				}
				
				//do it here since earlier will cause error 
				$noValue1 = makeSafe($noValue1);
				$noValue2 = makeSafe($noValue2);
				$noValue4 = makeSafe($noValue4);							
				
				$sqlCreatePurchaseOrderDetail = "INSERT INTO tbpurchaseorderdetail(purchaseOrderDetail_id, purchaseOrderDetail_no1, purchaseOrderDetail_no2, 
				purchaseOrderDetail_no3, purchaseOrderDetail_no4, purchaseOrderDetail_no5, purchaseOrderDetail_rowTotal, purchaseOrderDetail_taxRateID, 
				purchaseOrderDetail_taxPercent, purchaseOrderDetail_taxTotal, purchaseOrderDetail_rowGrandTotal, 
				purchaseOrderDetail_purchaseOrderID, purchaseOrderDetail_bold, purchaseOrderDetail_sortID, purchaseOrderDetail_discountPercent, 
				purchaseOrderDetail_discountAmount, purchaseOrderDetail_rowTotalAfterDiscount) 
				VALUES(NULL, '$noValue1', '$noValue2', '$noValue3', '$noValue4', '$noValue5', '$noValue6', '$noValue7', '$noValue8', 
				'$noValue9', '$noValue10', '$purchaseOrderID', '$noValueCheckbox', '$sortID', '$noValue11', '$noValue12', '$noValue13')";
				
				mysqli_query($connection, $sqlCreatePurchaseOrderDetail) or die("error in create purchase order detail query");		 	
			}			
		}		
		
		header ("Location: editPurchaseorder.php?idPurchaseOrder=$purchaseOrderID&idCustomer=$customerID");		
	}	
	
	//get the company name
	$sqlCompanyName = "SELECT company_name, company_purchaseOrderTerms FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$rowCompanyName = mysqli_fetch_row($resultCompanyName);
	
	//get the MAX id from tbpurchaseorder
	$sqlMaxID = "SELECT purchaseOrder_no FROM tbpurchaseorder ORDER BY purchaseOrder_id DESC LIMIT 0,1";
	$resultMax = mysqli_query($connection, $sqlMaxID) or die("error in max ID query");
	$strLastPurchaseOrderNo = "";
	if(mysqli_num_rows($resultMax) > 0){
		$rowLastPurchaseOrderNo = mysqli_fetch_row($resultMax);
		$strLastPurchaseOrderNo = $rowLastPurchaseOrderNo[0];
	}	
	
	
	
	//get the duplicate Purchase Order info only if idPurchaseOrderDuplicate parameter set
	$duplicateStatus = 0; 
	$customerID = 0;
	if(isset($_GET['idPurchaseOrderDuplicate'])){
		$duplicateStatus = 1;
		$purchaseOrderDuplicateID = $_GET['idPurchaseOrderDuplicate'];
		
		//get the customer info
		$customerID = $_GET['idCustomer'];
		if($customerID <> 0){
			$sqlCustomerInfo = "SELECT customer_name, customer_tel, customer_email, customer_attention, customer_address FROM tbcustomer WHERE 
			customer_id = '$customerID'";
			
			$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer query");
			$rowCustomerInfo = mysqli_fetch_row($resultCustomerInfo);
		}
		
		
		
		//get the quotation info	
		$sqlPurchaseOrderInfo = "SELECT purchaseOrder_content, purchaseOrder_terms, purchaseOrder_subTotal, purchaseOrder_taxTotal, purchaseOrder_grandTotal,
		purchaseOrder_discountTotal, purchaseOrder_totalAfterDiscount, purchaseOrder_roundAmount, purchaseOrder_grandTotalRound, purchaseOrder_roundStatus 
		FROM tbpurchaseorder WHERE purchaseOrder_id = '$purchaseOrderDuplicateID'";
		
		//get the quotation details
		$sqlPurchaseOrderDetailInfo = "SELECT purchaseOrderDetail_no1, purchaseOrderDetail_no2, purchaseOrderDetail_no3, purchaseOrderDetail_no4, purchaseOrderDetail_no5, 
		purchaseOrderDetail_rowTotal, purchaseOrderDetail_taxRateID, purchaseOrderDetail_taxPercent, purchaseOrderDetail_taxTotal, purchaseOrderDetail_rowGrandTotal, 
		purchaseOrderDetail_bold, purchaseOrderDetail_sortID, purchaseOrderDetail_discountPercent, purchaseOrderDetail_discountAmount, 
		purchaseOrderDetail_rowTotalAfterDiscount FROM tbpurchaseorderdetail 
		WHERE purchaseOrderDetail_purchaseOrderID = '$purchaseOrderDuplicateID' ORDER BY purchaseOrderDetail_sortID ASC";
		
		$resultPurchaseOrderInfo = mysqli_query($connection, $sqlPurchaseOrderInfo) or die("error in purchase order query");
		$rowPurchaseOrderInfo = mysqli_fetch_row($resultPurchaseOrderInfo);		
		
		$resultPurchaseOrderDetailInfo = mysqli_query($connection, $sqlPurchaseOrderDetailInfo) or die("error in purchase order detail query");
	
		//-----------------------------------------------------
		//get all the tax rates list and put inside array
		$aTaxRateList = array();
		$aTaxRateListDB = array();//hold the list to prevent multiple queries		
		
		//get the tax rates
		$sqlGetTaxRate = "SELECT taxRate_id, taxRate_code FROM tbtaxrate ORDER BY taxRate_default DESC, taxRate_code ASC";	
		$resultGetTaxRate = mysqli_query($connection, $sqlGetTaxRate) or die("error in get tax rate query");
		
		$d = 0;
		
		while($rowTaxRateList = mysqli_fetch_array($resultGetTaxRate)){	
			$aTaxRateList[] = $rowTaxRateList[0];	
			$aTaxRateListDB[$d][0] = $rowTaxRateList[0];
			$aTaxRateListDB[$d][1] = $rowTaxRateList[1];
			$d = $d + 1;
		}
		
		// php function to search multi-dimensional array
		function searchArray($key, $st, $array) {
		   foreach ($array as $k => $v) {
			   if ($v[$key] === $st) {
				   return $k;
			   }
		   }
		   return null;
		}
	}	
?>
<html>
<head>
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">

<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>

<script>
	//output this values since src="js/globalJavascriptCode.js" js file cannot access session variable directly
	var dateAccountingStart = '<?php echo $_SESSION['accountingPeriodStart'];?>';
	var dateAccountingEnd = '<?php echo $_SESSION['accountingPeriodEnd'];?>';
	
	$( function() {
		$( "#demo2" ).datepicker({ dateFormat: "dd/mm/yy"});
	} );
</script>
<script src="js/globalJavascriptCode.js"></script>

<style type="text/css">
table.mystyle
{
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
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

.styled{
	min-height: 1em;
	max-height: 10vh;
	max-width: 505px;
	width: 505px;
	overflow: hidden;
}

.styled2{
	min-height: 1em;
	max-height: 10vh;
	max-width: 35px;
	width: 35px;
	overflow: hidden;
	resize: none; /*remove the resize handle on the bottom right*/
}

.styled3{
	min-height: 1em;
	max-height: 10vh;
	max-width: 50px;
	width: 50px;
	overflow: hidden;	
	resize: none; /*remove the resize handle on the bottom right*/
}

.styled4{
	min-height: 1em;
	max-height: 10vh;
	max-width: 80px;
	width: 80px;
	overflow: hidden;
	resize: none; /*remove the resize handle on the bottom right*/
}

.ui-widget.ui-widget-content {
  border: 1px solid #000000;
  padding: 0;
}




/* Formatting search box */
    .search-box{
        width: 300px;
        position: relative;
        display: inline-block;
        font-size: 14px;
    }
    .search-box input[type="text"]{
        height: 32px;
        padding: 5px 10px;
        border: 1px solid #CCCCCC;
        font-size: 14px;
    }
    .result{
        position: absolute;        
        z-index: 999;
        top: 100%;
        left: 0;
    }
    .search-box input[type="text"], .result{
        width: 100%;
        box-sizing: border-box;
    }
    /* Formatting result items */
    .result p{
        margin: 0;
        padding: 7px 10px;
        border: 1px solid #CCCCCC;
        border-top: none;
        cursor: pointer;
		background: #f3f3f2;
    }
    .result p:hover{
        background: #f233f2;
    }

</style>
<script>
var ajaxResult = []; //to store the array of objects
var namingValue = 1;

function GetTaxRateList(){	
	$.ajax({
		type : 'POST',
		url : 'getTaxRate.php',		
		dataType : 'json', //return value type
		async: false, //To be sure that nothing happens before the AJAX request is achieved, if not first click not working
		success : function(response)
		{			
			//array of objects
			ajaxResult = response;           
		}	
	})
}

function GetTaxRate(n){
	//console.log(n);
	var e = document.getElementById(n);
	var rateID = e.options[e.selectedIndex].value;
	
	var rowArray = SearchArray(rateID, ajaxResult);
	
	var selectName = n;
	var aSelectName = selectName.split("|");
	var aSelectNo = "";
	aSelectNo = aSelectName[1];
	
	var rateName = "";	
	rateName = "rate|" + aSelectNo;	
	document.getElementById(rateName).value = rowArray;
	CalculateRowTotal();
}

function SearchArray(nameKey, myArray){
	//search the array of objects and get the particular value by the correct field
	for(var i = 0; i < myArray.length; i++){
		if(myArray[i].id === nameKey){
			return myArray[i].taxRateValue;
		}		
	}	
}

function popupwindow(){	
	//loop through the table to see which rows has focus
	var myTab = document.getElementById('empTable');        
	var focusRow = 1;
	// LOOP THROUGH EACH ROW OF THE TABLE.
	for (row = 1; row < myTab.rows.length; row++) {				
			var element = myTab.rows.item(row).cells[3];
			var myElement = element.childNodes[0].id;				
			//ActiveElement is the element id with focus
			if(myElement === document.activeElement.id){
				//console.log(focusRow);
				break;					
			}            
		focusRow = focusRow + 1;
	}	
	var focusRowString = focusRow.toString(); //convert to string to attach to GET string
	var page = "searchProduct.php?idRowFocus=";	
	page = page + focusRowString;	
	
	
	var $dialog = $('<div></div>')
		.html('<iframe id ="productList" name ="productList" style="border: 0px; " src="' + page + '" width="100%" height="100%"></iframe>')
	   .dialog({		  
		   autoOpen: false,
		   modal: true,
		   closeText: 'Purchase Order',
		   height: 500,
		   width: 800,		   
		   title: "Product & Servis List",
		   close: function (dialogclose, ui) {			   
				$('body').css("overflow", "auto"); //body can scrol when modal close
				
				var list, index;
				list = document.getElementsByClassName("styled");	//gets a node list, not single element			
				for(index = 0; index < list.length; ++index){
					list[index].setAttribute('ondblclick', 'popupwindow()'); //NO USE SELECTOR TO CHOOSE ELEMENT, add the attribute back
				}		
				
				if(event.which == 27){
					//do nothing because ESCAPE KEY PRESSED					
					
				} else {
					//1 TO 3 means mouse button value pressed
					//send parameters back to main page					
					var selectedProduct = document.getElementById('productList').contentWindow.document.getElementById('selectedProduct').value;									
				
					//process the returned product id & row to get product name & price etc					
					var arraySelectedProduct = selectedProduct.split("|");
					var rowSelected = arraySelectedProduct[0];
					var productSelected = arraySelectedProduct[1];					
				
					//use a function					
					if(productSelected != 0){InsertProductList(rowSelected, productSelected);}					
				}				
				$dialog.dialog('destroy');				
		   }		   
	   });	
	
	$dialog.dialog('open');
	$('body').css("overflow", "hidden"); //body cannot scrol when modal open
	
	var x = document.getElementsByClassName("styled");//this method okay for removing attribute
	var i;
	for(i = 0; i < x.length; i++){
		//remove the dblclick attribute to prevent multi modal 		
		$(x[i]).removeAttr("ondblclick");	//SELECTOR TO CHOOSE ELEMENT	
	}	
}

function InsertProductList(x, y){
	var rowSelected = x;
	var productID = y;	
	var data = "productID="+productID;	
	
	$.ajax({
		type: 'POST',
		url: 'getProductInfo.php',
		data: data,
		dataType: 'text',
		success:function(f){
			
			var splitProductInfo = f.split('++++');
			
			var productName = splitProductInfo[0];
			var productPrice = splitProductInfo[2];
			var productUOM = splitProductInfo[3];
			
			//insert process
			var myTab = document.getElementById('empTable');
			var elementProductName = myTab.rows.item(rowSelected).cells[3];
			var elementProductUOM = myTab.rows.item(rowSelected).cells[5];
			var elementProductPrice = myTab.rows.item(rowSelected).cells[6];			
			
			elementProductName.childNodes[0].value = productName; 
			elementProductPrice.childNodes[0].value = productPrice;		
			elementProductUOM.childNodes[0].value = productUOM;		
			CalculateRowTotal();
		}		
	})		
}

function CalculateRowTotal(){	
	//loop through the table to see which rows are selected
	var myTab = document.getElementById('empTable');
	var subtotalValue = 0;
	var discountTotalValue = 0;
	var totalAfterDiscountValue = 0;
	var taxTotalValue = 0;
	var grandTotalValue = 0;
	
	document.getElementById('subTotal').value = "";
	document.getElementById('discountTotal').value = "";
	document.getElementById('totalAfterDiscount').value = "";	
	document.getElementById('taxTotal').value = "";
	document.getElementById('grandTotal').value = "";
	
	// LOOP THROUGH EACH ROW OF THE TABLE.
	for (row = 1; row < myTab.rows.length; row++) {
		 for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.
			if(c == 4){
				var element = myTab.rows.item(row).cells[c];				
				var actualQty = 0;		
				if((isNaN(element.childNodes[0].value)) ||(element.childNodes[0].value.trim() == "")){
					actualQty = 1;
				}else{
					if(element.childNodes[0].value==""){
						actualQty = 1;
					}else{
						actualQty = parseFloat(element.childNodes[0].value);	
					}		
				}						
			}
			
			if(c == 6){
				var element = myTab.rows.item(row).cells[c];
				var element2 = myTab.rows.item(row).cells[7];
				var rowTotal = 0;
				var actualPrice = 0;
				
				if((isNaN(element.childNodes[0].value)) ||(element.childNodes[0].value.trim() == "")){		
					element2.childNodes[0].value = "0.00";
					
				}else{
					if(element.childNodes[0].value==""){
						element2.childNodes[0].value = "0.00";
						
					}else{			
						var actualPrice = parseFloat(element.childNodes[0].value);
						rowTotal = actualQty * actualPrice;
						element2.childNodes[0].value = rowTotal.toFixed(2);
						subtotalValue = subtotalValue + (actualQty * actualPrice);
					}		
				}				
			}
			
			if(c == 8){
				var element = myTab.rows.item(row).cells[c];//discount %
				var element2 = myTab.rows.item(row).cells[9];
				var element3 = myTab.rows.item(row).cells[10];
				var element4 = myTab.rows.item(row).cells[7]; //subtotal	
				var rowTotalAfterDiscount = 0.00;
					
				if((isNaN(element.childNodes[0].value)) ||(element.childNodes[0].value.trim() == "")){
					element2.childNodes[0].value = "0.00";
					element3.childNodes[0].value = element4.childNodes[0].value;
					rowTotalAfterDiscount = parseFloat(element4.childNodes[0].value);
				}else{
					
					var rowSubtotal = element4.childNodes[0].value;
					var rowDiscountRate = element.childNodes[0].value;
					var rowDiscountAmount = (rowSubtotal * rowDiscountRate)/100;
					element2.childNodes[0].value = rowDiscountAmount.toFixed(2);
					//parseFloat function to change string to number
					rowTotalAfterDiscount = parseFloat(rowSubtotal) - parseFloat(rowDiscountAmount);
					element3.childNodes[0].value = rowTotalAfterDiscount.toFixed(2);
					discountTotalValue = discountTotalValue + parseFloat(rowDiscountAmount);
					
				}
				totalAfterDiscountValue = totalAfterDiscountValue + parseFloat(rowTotalAfterDiscount);
			}
			
			if(c == 12){
				var element = myTab.rows.item(row).cells[c];
				var element2 = myTab.rows.item(row).cells[13];
				var element3 = myTab.rows.item(row).cells[14];
				var element4 = myTab.rows.item(row).cells[10];				
				
				var rowRate = 0.00;
				var rowRateTotal = 0.00;
				var rowGrandTotal = 0.00;
				var rowTotalAfterDiscount = 0.00;
				rowTotalAfterDiscount = parseFloat(element4.childNodes[0].value);
				
				if(element.childNodes[0].value == "0.00"){
					element2.childNodes[0].value = "0.00";
					element3.childNodes[0].value = element4.childNodes[0].value;					
					rowGrandTotal = parseFloat(element4.childNodes[0].value);
					
				}else{
					
					if(element4.childNodes[0].value == "0.00"){
						element2.childNodes[0].value = "0.00";
						element3.childNodes[0].value = "0.00";
					}else{				
						rowRate = parseFloat(element.childNodes[0].value);
						rowRateTotal = (rowTotalAfterDiscount * rowRate)/100;
						//parseFloat function to change string to number
						rowGrandTotal = parseFloat(rowTotalAfterDiscount) + parseFloat(rowRateTotal);
						element2.childNodes[0].value = rowRateTotal.toFixed(2);		
						element3.childNodes[0].value = rowGrandTotal.toFixed(2);
						taxTotalValue = taxTotalValue + parseFloat(rowRateTotal);
					}				
				}				
				grandTotalValue = grandTotalValue + parseFloat(rowGrandTotal);	
			}		
		}	
	}	
	document.getElementById('subTotal').value = subtotalValue.toFixed(2);
	document.getElementById('discountTotal').value = discountTotalValue.toFixed(2);	
	document.getElementById('totalAfterDiscount').value = totalAfterDiscountValue.toFixed(2);
	document.getElementById('taxTotal').value = taxTotalValue.toFixed(2);					
	document.getElementById('grandTotal').value = grandTotalValue.toFixed(2);
	
	if(document.getElementById('roundStatus').checked == true){
		//the rounded Grand total
		var factor = 0.05 //nearest 0.05
		var valueGrandTotalRound =  Math.round(grandTotalValue/factor)*factor;
		var roundAmount = valueGrandTotalRound - grandTotalValue;
		document.getElementById('groundTotalRound').value = valueGrandTotalRound.toFixed(2);	
		document.getElementById('roundAmount').value = roundAmount.toFixed(2);
	}else{
		document.getElementById('roundAmount').value = "0.00";
		document.getElementById('groundTotalRound').value = grandTotalValue.toFixed(2);
	}
}

	function check(it) {
		tr = it.parentElement.parentElement;
		//tr.style.backgroundColor = (it.checked) ? "7C7C7C" : "ffffff";
		//ONLY PARTICULAR CELL BOLD
		//tr.cells[3].getElementsByTagName("textarea")[0].style.fontWeight = (it.checked) ? "bold" : "normal";
		var textareas = tr.getElementsByTagName("textarea");
		for (var i = 0; i < textareas.length; i++) {
		  textareas[i].style.fontWeight = (it.checked) ? "bold" : "normal";
		}
		
		//loop through the table to see which rows are selected
		var myTab = document.getElementById('empTable');
        var values = new Array();
		
		// LOOP THROUGH EACH ROW OF THE TABLE.
        for (row = 1; row < myTab.rows.length; row++) {
			 for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'checkbox') {
                    if(element.childNodes[0].checked == true){
						values.push(element.childNodes[0].value); 
						
					}else{
						values.push('0');
					}				
				}
            }
        }		
		document.getElementById('purchaseOrderCheckbox').value = values;
	}

	function CheckPurchaseOrderNo(){		
		var checkEmptyPurchaseOrderNo = $("#purchaseOrderNo").val();
		if(checkEmptyPurchaseOrderNo===""){
			$("#info").html("<img border='0' src='images/Delete.ico'>");
			document.getElementById("bt").disabled = true;
		}else{			
			var data = "purchaseOrderNo="+$("#purchaseOrderNo").val();
			
			$.ajax({			 
				type : 'POST',
				url : 'checkExistingPurchaseOrder.php',
				data : data,
				dataType : 'json',
				success : function(r)
				{
					if(r=="0"){
						$("#info").html("<img border='0' src='images/Yes.ico'>");
						document.getElementById("bt").disabled = false;	
					}else{									
						//Exists					
					   $("#info").html("<img border='0' src='images/Delete.ico'>");
					   document.getElementById("bt").disabled = true;					
					}				
				}
				
			}	
			)	
		}	
	}

	function GetDuplicateInfo(){
		var checkDuplicateQuotationNo = $("#purchaseOrderDuplicate").val();
		var customerID = $("#customerIDvalue").val();
		
		if(checkDuplicateQuotationNo===""){
			//do nothing				
			purchaseOrderDuplicate.focus();
		}else{
			
			var data = "purchaseOrderNo="+$("#purchaseOrderDuplicate").val();
			
			$.ajax({			 
				type : 'POST',
				url : 'checkExistingPurchaseOrder.php',
				data : data,
				dataType : 'json',
				success : function(r)
				{
					if(r=="0"){
						$("#duplicateInfo").html("No Purchase Order!");
						purchaseOrderDuplicate.focus();
						//console.log(customerID);
							
					}else{									
						//Exists
						var customerIDvalue = parseFloat(customerID);
						var quotationIDvalue = parseFloat(r);
						window.location.href = "createPurchaseOrder.php?idCustomer="+customerIDvalue+"&idPurchaseOrderDuplicate="+quotationIDvalue;
					   					
					}				
				}
			}	
			)			
			
		}		
	}	
	
	function DisableSubmitButton(){		
		document.getElementById("bt").disabled = true;		
	}	
	
	
	
	
	
	function CheckAndSubmit(){
		var checkEmptyPurchaseOrderNo = $("#purchaseOrderNo").val();
		
		
		var customerID = document.getElementById("customerIDvalue").value;
		
		if(checkEmptyPurchaseOrderNo===""){
			$("#info").html("<img border='0' src='images/Delete.ico'>");
			document.getElementById("bt").disabled = true;
			alert("Must enter Purchase Order No!");
			purchaseOrderNo.focus();
		
		}else if(customerID == 0){
			alert("Must enter Customer Name!");
			search.focus();
		
		
		}else{			
			
			var checkAccountingStatus = CheckAccountingPeriod();
			
			if(checkAccountingStatus==true){
				var data = "purchaseOrderNo="+$("#purchaseOrderNo").val();			
				$.ajax({			 
					type : 'POST',
					url : 'checkExistingPurchaseOrder.php',
					data : data,
					dataType : 'json',
					success : function(r)
					{
						if(r=="0"){
							$("#info").html("<img border='0' src='images/Yes.ico'>");
							document.getElementById("bt").disabled = false;						   
						}else{						

							//Exists					
						   $("#info").html("<img border='0' src='images/Delete.ico'>");
						   document.getElementById("bt").disabled = true;
						}
						ResubmitForm(r);
					}
				})	
			}else{
				alert("Accounting Period Closed for this date!");
			}
		}		
	
		return false;	
	}
	
	
	
	
	
	
	
	
	function ResubmitForm(g){
		if(g==0){					
			
			var u = confirm("Do you want to Create Purchase Order?");
			if(u==true){
				$('#purchaseOrderForm').attr('onsubmit', 'return true');
			jQuery("#bt").trigger('click'); //auto submit by clicking the submit button id
			}		
		
		}else{
			alert("This Purchase Order No already exist in Database!");
		}		
		
	}	

// ARRAY FOR HEADER.
    var arrHead = new Array();
    arrHead = ['', 'B', 'No', 'Description', 'Qty', 'Unit', 'Price', 'Total', 'Disc%', 'Disc', 'A.Disc', 'Code', 'Rate', 'Tax', 'Total'];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.

    // FIRST CREATE A TABLE STRUCTURE BY ADDING A FEW HEADERS AND
    // ADD THE TABLE TO YOUR WEB PAGE.
    function createTable() {
        GetTaxRateList();
		
		var empTable = document.createElement('table');
        empTable.setAttribute('id', 'empTable');            // SET THE TABLE ID.
		empTable.setAttribute('width', '1200px');
		empTable.setAttribute('border', '1px');
		empTable.setAttribute('cellpadding', '0px');

        var tr = empTable.insertRow(0);

         for (var h = 0; h < arrHead.length; h++) {
            var th = document.createElement('th');          // TABLE HEADER.
            th.innerHTML = arrHead[h];
            tr.appendChild(th);
        } 

        var div = document.getElementById('cont');
        div.appendChild(empTable);    // ADD THE TABLE TO YOUR WEB PAGE.
		document.getElementById("bt").disabled = true;
    }
	
	function createTableTotal() {
		var empTableTotal = document.createElement('table');
		empTableTotal.setAttribute('id', 'empTableTotal');            // SET THE TABLE ID.
		empTableTotal.setAttribute('width', '1200px');
		empTableTotal.setAttribute('border', '1px');
		empTableTotal.setAttribute('cellpadding', '1px');
		
		//subtotal
		var tr = empTableTotal.insertRow(0);		
		var td = document.createElement('td');		
		
		td = tr.insertCell(0);
		td.width = "76%";		
		
		td = tr.insertCell(1);
		td.width = "15%";		
		td.innerHTML = "Subtotal";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');		
		
		ele.setAttribute('id', 'subTotal');
		ele.setAttribute('name', 'subTotal');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		
		td.appendChild(ele);
		
		//discount amount total
		tr = empTableTotal.insertRow(1);
		td = document.createElement('td');
		
		td = tr.insertCell(0);
		td.width = "76%";
		
		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Discount Total";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		ele.setAttribute('id', 'discountTotal');
		ele.setAttribute('name', 'discountTotal');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);	
		
		//total after discount
		tr = empTableTotal.insertRow(2);
		td = document.createElement('td');
		
		td = tr.insertCell(0);
		td.width = "76%";
		
		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Total After Discount";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		ele.setAttribute('id', 'totalAfterDiscount');
		ele.setAttribute('name', 'totalAfterDiscount');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);
		
		//tax
		tr = empTableTotal.insertRow(3);
		td = document.createElement('td');
		
		td = tr.insertCell(0);
		td.width = "76%";
		
		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Tax";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		ele.setAttribute('id', 'taxTotal');
		ele.setAttribute('name', 'taxTotal');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);
		
		//grand total
		tr = empTableTotal.insertRow(4);
		td = document.createElement('td'); 
		
		td = tr.insertCell(0);
		td.width = "76%";
		
		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Total";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		ele.setAttribute('id', 'grandTotal');
		ele.setAttribute('name', 'grandTotal');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);

		//round amount
		tr = empTableTotal.insertRow(5);
		td = document.createElement('td'); 
		
		td = tr.insertCell(0);
		td.width = "76%";

		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Round";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		var ele2 = document.createElement('input');
		
		ele.setAttribute('id', 'roundAmount');
		ele.setAttribute('name', 'roundAmount');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		ele2.setAttribute('type', 'checkbox');
		ele2.setAttribute('id', 'roundStatus');
		ele2.setAttribute('name', 'roundStatus');
		ele2.setAttribute('value', '1');
		ele2.setAttribute('onclick', 'CalculateRowTotal()');
		
		td.appendChild(ele);
		td.appendChild(ele2);

		//rounded grand total
		tr = empTableTotal.insertRow(6);
		td = document.createElement('td'); 
		
		td = tr.insertCell(0);
		td.width = "76%";

		td = tr.insertCell(1);
		td.width = "15%";
		td.innerHTML = "Rounded Total";
		tr.appendChild(td);
		
		td = tr.insertCell(2);
		td.width = "9%";
		var ele = document.createElement('input');
		
		ele.setAttribute('id', 'groundTotalRound');
		ele.setAttribute('name', 'groundTotalRound');
		ele.setAttribute('readonly', 'true');
		ele.setAttribute('class', 'styled4');
		td.appendChild(ele);		
		
		var div = document.getElementById('cont2');
		div.appendChild(empTableTotal);
	}

    // ADD A NEW ROW TO THE TABLE.s
    function addRow2() {
        var empTab = document.getElementById('empTable');
        var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
        var tr = empTab.insertRow(rowCnt);      // TABLE ROW.
		
		var selectName = "";
		var rateName = "";        
		var rowCounter = 1;
		
        for (var c = 0; c < arrHead.length; c++) {
            var td = document.createElement('td');          // TABLE DEFINITION.
            td = tr.insertCell(c);

            if (c == 0) {           // FIRST COLUMN.
                // ADD A BUTTON.
                var button = document.createElement('input');

                // SET INPUT ATTRIBUTE.
                button.setAttribute('type', 'button');
                button.setAttribute('value', 'del');

                // ADD THE BUTTON's 'onclick' EVENT.
                button.setAttribute('onclick', 'removeRow(this)');
                td.appendChild(button);
            }
			else if (c == 1){
				//create Checkbox
				var ele = document.createElement('input');
                ele.setAttribute('type', 'checkbox');
                ele.setAttribute('value', '1');				
				ele.setAttribute('name', 'noCheckbox[this]');
				ele.setAttribute('onclick', 'check(this)');
				td.appendChild(ele);				
			}
            else {
                // CREATE AND ADD TEXTBOX IN EACH CELL.
                var ele = document.createElement('textarea');
                //ele.setAttribute('type', 'text');
               // ele.setAttribute('value', '');				
								
				if(c == 2){	
					//NO
					ele.setAttribute('id', 'noCol1[]');					
					ele.setAttribute('class', 'styled2');					
					ele.setAttribute('name', 'noCol1[]');
					ele.setAttribute('maxlength', '6');
					
					td.appendChild(ele);
				}
				if(c == 3){
					//DESCRIPTION
										
					var idName = "id" + Math.random().toString(16).slice(2);
					ele.setAttribute('id', idName);					
					//ele.setAttribute('id', 'noCol2[]');	
					ele.setAttribute('class', 'styled');					
					ele.setAttribute('name', 'noCol2[]');
					ele.setAttribute('maxlength', '200');
					ele.setAttribute('ondblclick', 'popupwindow()');					
					td.appendChild(ele);
					
				}
				if(c == 4){
					//QUANTITY
					ele.setAttribute('id', 'noCol3[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol3[]');
					ele.setAttribute('maxlength', '10');
					ele.setAttribute('onblur', 'CalculateRowTotal()');
					td.appendChild(ele);
				}
				if(c == 5){
					//UNIT
					ele.setAttribute('id', 'noCol4[]');
					ele.setAttribute('class', 'styled3');					
					ele.setAttribute('name', 'noCol4[]');
					ele.setAttribute('maxlength', '10');
					td.appendChild(ele);
				}
				if(c == 6){
					//PRICE
					ele.setAttribute('id', 'noCol5[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol5[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('onblur', 'CalculateRowTotal()');
					td.appendChild(ele);
				}  
				if(c == 7){
					//TOTAL 
					ele.setAttribute('id', 'noCol6[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol6[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
				}
				
				//Discount percent
				if(c == 8){
					//DISCOUNT PERCENT
					ele.setAttribute('id', 'noCol11[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol11[]');
					ele.setAttribute('maxlength', '10');
					ele.setAttribute('onblur', 'CalculateRowTotal()');
					td.appendChild(ele);
				} 
				//Discount amount
				if(c == 9){
					//DISCOUNT AMOUNT
					ele.setAttribute('id', 'noCol12[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol12[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
				}
				//Total after Discount
				if(c == 10){
					//TOTAL AFTER DISCOUNT
					ele.setAttribute('id', 'noCol13[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol13[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
				}
				
				if(c == 11){
					//TAX CODE
					var eleSelect = document.createElement('select');					
					//unique ID for select
					
					if($('#counterValue').length > 0){
						var selectName2 = namingValue + document.getElementById('counterValue').value;
					}else{
						var selectName2 = namingValue;
					}
					
					selectName = "select|" + selectName2.toString();
					//console.log(selectName);
					eleSelect.setAttribute('name', 'noCol7[]');
					eleSelect.setAttribute('id', selectName);
					eleSelect.setAttribute('onchange', 'GetTaxRate(id)');
					td.appendChild(eleSelect);		
					
					//GetTaxRateList();
					
					//iterating an array of Objects, using jQuery method
					$.each(ajaxResult, function(key, value){
						var taxRate = value.taxRate;
						var taxID = value.id;
						var eleOption = document.createElement('option');
						eleOption.appendChild(document.createTextNode(taxRate));
						eleOption.value = taxID;
						eleSelect.appendChild(eleOption);
					}
					);		
				}
				if(c == 12){
					//TAX RATE
					//unique ID for rate
					if($('#counterValue').length > 0){
						var rateName2 = namingValue + document.getElementById('counterValue').value;
					}else{
						var rateName2 = namingValue;
					}
					
					rateName = "rate|" + rateName2.toString();
					ele.setAttribute('id', rateName);
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol8[]');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
					//default value inside textarea
					var myTab = document.getElementById('empTable');					
					var element2 = myTab.rows.item(rowCnt).cells[12];
					element2.childNodes[0].value = "0.00";				
					namingValue = namingValue + 1;				
				}
				if(c == 13){
					//TAX TOTAL
					ele.setAttribute('id', 'noCol9[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol9[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
					//default value inside textarea
					var myTab = document.getElementById('empTable');					
					var element2 = myTab.rows.item(rowCnt).cells[13];
					element2.childNodes[0].value = "0.00";
				}
				if(c == 14){
					//GRAND TOTAL
					ele.setAttribute('id', 'noCol10[]');
					ele.setAttribute('class', 'styled3');
					ele.setAttribute('name', 'noCol10[]');
					ele.setAttribute('maxlength', '15');
					ele.setAttribute('readonly', 'true');
					td.appendChild(ele);
					//default value inside textarea
					var myTab = document.getElementById('empTable');					
					var element2 = myTab.rows.item(rowCnt).cells[14];
					element2.childNodes[0].value = "0.00";
				}
            }
			rowCounter = rowCounter + 1;
		}
    
		//loop through the table to see which rows are selected
		var myTab = document.getElementById('empTable');
        var values = new Array();
		
		// LOOP THROUGH EACH ROW OF THE TABLE.
        for (row = 1; row < myTab.rows.length; row++) {
			 for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'checkbox') {
                    if(element.childNodes[0].checked == true){
						values.push(element.childNodes[0].value);
					}else{
						values.push('0');
					}				
				}
            }
        }		
        
		document.getElementById('purchaseOrderCheckbox').value = values;
		
		//test create table row
		if(rowCnt == 1){createTableTotal()};
	}

    // DELETE TABLE ROW.
    function removeRow(oButton) {
		var r = confirm("Do you want to Remove this row?");
		if(r==false){
			return false;
		}else{		
		
			var empTab = document.getElementById('empTable');			
			empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);
			// BUTTON -> TD -> TR.
			
			//loop through the table to see which rows are selected
			var myTab = document.getElementById('empTable');
			var values = new Array();
			
			// LOOP THROUGH EACH ROW OF THE TABLE.
			for (row = 1; row < myTab.rows.length; row++) {
				 for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

					var element = myTab.rows.item(row).cells[c];
					if (element.childNodes[0].getAttribute('type') == 'checkbox') {
						if(element.childNodes[0].checked == true){
							values.push(element.childNodes[0].value);
						}else{
							values.push('0');
						}				
					}
				}
			}		
					
			document.getElementById('purchaseOrderCheckbox').value = values;
			
			var rowCnt = empTab.rows.length;        // GET TABLE ROW COUNT.
			if(rowCnt == 1){
				$("#empTableTotal").remove();
			}else{
				CalculateRowTotal();
			}
		}
	}	
	
	// EXTRACT AND SUBMIT TABLE DATA.//not using here because using PHP to create the quotation details
    function sumbit() {
        var myTab = document.getElementById('empTable');
        var values = new Array();
		
		// LOOP THROUGH EACH ROW OF THE TABLE.
        for (row = 1; row < myTab.rows.length - 1; row++) {
            for (c = 0; c < myTab.rows[row].cells.length; c++) {   // EACH CELL IN A ROW.

                var element = myTab.rows.item(row).cells[c];
                if (element.childNodes[0].getAttribute('type') == 'input') {
                    values.push("'" + element.childNodes[0].value + "'");
                }
            }
        }
        
    }
	
	//-----------------------------------------------------------
	
	var autoExpand = function (field) {
	// Reset field height
	field.style.height = 'inherit';

	// Get the computed styles for the element
	var computed = window.getComputedStyle(field);

	// Calculate the height
	var height = parseInt(computed.getPropertyValue('border-top-width'), 10)
	             + parseInt(computed.getPropertyValue('padding-top'), 10)
	             + field.scrollHeight
	             + parseInt(computed.getPropertyValue('padding-bottom'), 10)
	             + parseInt(computed.getPropertyValue('border-bottom-width'), 10);

	field.style.height = height + 'px';
};

document.addEventListener('input', function (event) {
	if (event.target.tagName.toLowerCase() !== 'textarea') return;
	autoExpand(event.target);
}, false);





//LIVE SEARCH FOR CUSTOMER SUPPLIER
$(document).ready(function(){
  $("#search").keyup(function(){
    var txt = $(this).val();
    var resultDropdown = $(".result");
    var person = "";
    if (txt !='')
    {
        $.ajax
        (
        {
            type:"post",    //submit method
            url: "searchCustomerSQL.php",  //url to sumitted data To
            data: {name : txt}, //Data to be submitted
            cache: false,
            dataType: 'json',
            //action on successful post request
            success: function(data)
            {
                //process JSON
                $.each(data.names, function(idx, name){
                    person += '<p data-id="'+ name.id +'">' + name.name +'</p>';
                });
                resultDropdown.html(person);

            },
        }
        )
    }
    else
    {
        resultDropdown.empty();
    }
  });
	
	
   // Get the id of the clicked person
        $(document).on("click", ".result p", function(){
          //assign the value of person name to search input 
        //$(this).parents(".search-box").find('#search').val($(this).text());
		
		var text = $(this).text();		
		document.getElementById("customerNameValue").value = text;

        //get the id 
        var id = $(this).attr('data-id');
        //set input id "id" value 
         $("#customerIDvalue").val(id);
        //clear search data
         $(this).parent(".result").empty();
		
		//get the customer info
		var data = id;
		
		showCustomerInfo(data);
	})
	
})

function showCustomerInfo(d){
	var data = d;
	data = "customerID="+data;
	
	$.ajax({
			type : 'POST',
			url : 'searchCustomerInfo.php',
			data : data,
			dataType : 'json',
			success : function(r)
			{
				var js_array = r;
				for(var y = 0; y < js_array.length; y++){
					var customerName = js_array[y][0];
					var customerAddress = js_array[y][1];
					var customerTel = js_array[y][2];
					var customerEmail = js_array[y][3];
					var customerAttention = js_array[y][4];	
				}
				
				document.getElementById("customerNameValue").value = customerName;
				document.getElementById("customerAddressValue").value = customerAddress;
				document.getElementById("customerTelValue").value = customerTel;
				document.getElementById("customerEmailValue").value = customerEmail;
				document.getElementById("customerAttentionValue").value = customerAttention;
			},
			error: function(jqXHR, textStatus, errorThrown) {
				// handle any errors
				console.log(textStatus, errorThrown);
			}
		})
		return false;
}

</script>
</head>
<?php 
	if($duplicateStatus==1){
	
		if(mysqli_num_rows($resultPurchaseOrderDetailInfo) == 0){
			echo "<body onload=\"createTable()\">";
		}else{
			echo "<body onload=\"GetTaxRateList()\">";
		}
	}else{
		//call the function 5 times, default page has 5 rows 
		echo "<body onload=\"createTable();addRow2();addRow2();addRow2();addRow2();addRow2();\">";
	}

?>
<center>
<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
<table width="1200px" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>
<p></p>
<form id="purchaseOrderForm" action="createPurchaseOrder.php" method="POST" onsubmit="return CheckAndSubmit()">
<table width="1200px" cellpadding="0" border="1" class="mystyle">
<tr><td colspan="4" align="center"><h1>Create Purchase Order</h1></td><td></td></tr>
<tr><td colspan="4" align="center">

<div class="search-box">

        <input type="text" id="search" autocomplete="off" name="spousename" placeholder="Search Supplier">
        <!--<input type="hidden" id="id" autocomplete="off" name="spouseid" placeholder="search spouse" />-->
        <!--<input class="w3-button w3-block w3-green w3-section w3-padding" type="submit" name="access"><b>Submit</b></button>-->
        <div class="result"></div>
    </div>



</td><td><input type="text" name="purchaseOrderDuplicate" id="purchaseOrderDuplicate" size="12" maxlength="30">&nbsp;<img src="images/duplicatefinal.png" onclick="GetDuplicateInfo()"><span id="duplicateInfo" style="color:blue;font-size:12px"></span></td></tr>


<tr><td>To</td><td><input type="customerNameValue" id="customerNameValue" size="60" value="<?php if(($duplicateStatus==1)&&($customerID <> 0)){echo $rowCustomerInfo[0];}?>" readonly></td><td></td><td>Purchase Order No</td><td><input type="text" name="purchaseOrderNo" id="purchaseOrderNo" size="12" maxlength="30" value="<?php echo $strLastPurchaseOrderNo;?>" onchange="CheckPurchaseOrderNo()" autofocus><span id="info"><img border="0" src="images/Terminate.png"></span></td></tr>

<tr>
	<td>Attention</td><td><input type="text" name="customerAttentionValue" id="customerAttentionValue" size="40" maxlength="100" value="<?php if(($duplicateStatus==1)&&($customerID <> 0)){echo $rowCustomerInfo[3];}?>"></td><td></td><td>Date</td>
	<?php 
		//red color if today date not within the open accounting Period dates range
		
		if($_SESSION['accountingPeriodStart']==NULL){
			echo "<td bgcolor=\"#CD5C5C\" id=\"dateTD\">";
		}else{
			$todayDate = date('Y-m-d');		
			if(($todayDate>=$_SESSION['accountingPeriodStart'])&&($todayDate<=$_SESSION['accountingPeriodEnd'])){
				echo "<td bgcolor=\"#90EE90\" id=\"dateTD\">";
			}else{
				echo "<td bgcolor=\"#CD5C5C\" id=\"dateTD\">";
			}
		}
	
	?>
	<input id="demo2" type="text" name="purchaseOrderDate" size="10" onchange="CheckAccountingPeriod()" value="<?php echo date('d/m/Y');?>" readonly>
	&nbsp;
</td>
</tr>

<tr><td>Address</td><td><input type="text" name="customerAddressValue" id="customerAddressValue" size="70" value="<?php if(($duplicateStatus==1)&&($customerID <> 0)){echo $rowCustomerInfo[4];}?>" readonly></td><td></td><td>From</td><td><input type="text" name="purchaseOrderFrom" size="20" maxlength="50"></td></tr>
<tr><td>Telephone</td><td><input type="text" name="customerTelValue" id="customerTelValue" value="<?php if(($duplicateStatus==1)&&($customerID <> 0)){echo $rowCustomerInfo[1];}?>" readonly></td><td></td><td></td><td></td></tr>

<tr><td>Email</td><td><input type="text" name="customerEmailValue" id="customerEmailValue" size="40" maxlength="100" value="<?php if(($duplicateStatus==1)&&($customerID <> 0)){echo $rowCustomerInfo[2];}?>"></td><td></td><td></td><td></td></tr>

<tr><td colspan="5" align="left"></td></tr>
<tr><td colspan="5" align="left">&nbsp;<input type="text" name="purchaseOrderTitle" maxlength="200" size="150" placeholder="Purchase Order Title"></td></tr>
<tr><td colspan="5" align="left"><textarea name="purchaseOrderContent" id="purchaseOrderContent"><?php if($duplicateStatus==1){echo $rowPurchaseOrderInfo[0];}?></textarea></td></tr>
</table>
<!--this area we put the quotation details-->

<!--<div id="dialog"></div>-->

<!--THE CONTAINER WHERE WE'll ADD THE DYNAMIC TABLE-->
<div id="cont">

<?php
	$strPurchaseOrderCheckbox = ""; //to store which line is bold
 
	if($duplicateStatus==1){		
		if(mysqli_num_rows($resultPurchaseOrderDetailInfo) > 0){
			
			$numOfRows = mysqli_num_rows($resultPurchaseOrderDetailInfo);
			$counter = 0;
			echo "<table width= '1200px'cellpadding='0px' border='1px' id='empTable'>";
			echo "<tr><th></th><th></th><th>No</th><th>Description</th><th>Qty</th><th>Unit</th><th>Price</th><th>Total</th><th>Disc%</th><th>Disc</th><th>A.Dis</th><th>Code</th><th>Rate</th><th>Tax</th><th>Total</th></tr>";
			
			$intUniqueNameID = 1; //to generate unique ID name for each name column text area
			
			while($rowPurchaseOrderDetailInfo = mysqli_fetch_row($resultPurchaseOrderDetailInfo)){
				
				$counter = $counter + 1;
				
				if($rowPurchaseOrderDetailInfo[10] == 1){
					echo "<tr bgcolor='D4E0D3'>";
				}else{
					echo "<tr>";
				}
				echo "<td><input type='button' value='del' onclick='removeRow(this)'></td>";
				echo "<td>";
				if($rowPurchaseOrderDetailInfo[10] == 1){
					echo "<input type='checkbox' name='noCheckbox' value='1' checked onclick='check(this)'>";
				}else{
					echo "<input type='checkbox' name='noCheckbox' value='1' onclick='check(this)'>";
				}
								
				echo "</td>";
				echo "<td><textarea class='styled2' id='noCol1[]' name='noCol1[]' maxlength='6'>$rowPurchaseOrderDetailInfo[0]</textarea></td>";
				
				//get a unique ID for name column				
				$idNamePHP = "id123456789".$intUniqueNameID;				
				echo "<td><textarea class='styled' id='$idNamePHP' name='noCol2[]' maxlength='200' ondblclick='popupwindow()'>$rowPurchaseOrderDetailInfo[1]</textarea></td>";
				
				if($rowPurchaseOrderDetailInfo[2]==0.00){
					echo "<td><textarea class='styled3' id='noCol3[]' name='noCol3[]' maxlength='10' onblur='CalculateRowTotal()'></textarea></td>";
				}else{
					echo "<td><textarea class='styled3' id='noCol3[]' name='noCol3[]' maxlength='10' onblur='CalculateRowTotal()'>$rowPurchaseOrderDetailInfo[2]</textarea></td>";
				}
				
				echo "<td><textarea class='styled3' id='noCol4[]' name='noCol4[]' maxlength='10'>$rowPurchaseOrderDetailInfo[3]</textarea></td>";
				echo "<td><textarea class='styled3' id='noCol5[]' name='noCol5[]' maxlength='15' onblur='CalculateRowTotal()'>$rowPurchaseOrderDetailInfo[4]</textarea></td>";
				echo "<td><textarea class='styled3' id='noCol6[]' name='noCol6[]' maxlength='15' readonly>$rowPurchaseOrderDetailInfo[5]</textarea></td>";
				//discount amount
				if($rowPurchaseOrderDetailInfo[12]==0.00){
					echo "<td><textarea class='styled3' id='noCol11[]' name='noCol11[]' maxlength='10' onblur='CalculateRowTotal()'></textarea></td>";
				}else{
					echo "<td><textarea class='styled3' id='noCol11[]' name='noCol11[]' maxlength='10' onblur='CalculateRowTotal()'>$rowPurchaseOrderDetailInfo[12]</textarea></td>";
				}
				//discount amount
				echo "<td><textarea class='styled3' id='noCol12[]' name='noCol12[]' maxlength='15' readonly>$rowPurchaseOrderDetailInfo[13]</textarea></td>";
				//total after discount
				echo "<td><textarea class='styled3' id='noCol13[]' name='noCol13[]' maxlength='15' readonly>$rowPurchaseOrderDetailInfo[14]</textarea></td>";
				
				echo "<td>";
				$idNameValue = "select|".$counter;
				echo "<select name='noCol7[]' id=$idNameValue onchange=\"GetTaxRate(id)\">";
				//reuse the recordset
				mysqli_data_seek($resultGetTaxRate, 0);
				if(mysqli_num_rows($resultGetTaxRate) > 0){
					$taxRateID = $rowPurchaseOrderDetailInfo[6];
					$arrayTest1 = searchArray(0, $taxRateID, $aTaxRateListDB);
					$taxRateCode = $aTaxRateListDB[$arrayTest1][1];
					echo "<option value=$taxRateID>$taxRateCode</option>";
					while($rowGetTaxRate=mysqli_fetch_array($resultGetTaxRate)){
						echo "<option value=$rowGetTaxRate[0]>$rowGetTaxRate[1]</option>";
					}
					
				}
				echo "</select></td>";
				
				$idNameValue2 = "rate|".$counter;
				
				echo "<td><textarea class='styled3' id=$idNameValue2 name='noCol8[]' readonly>$rowPurchaseOrderDetailInfo[7]</textarea></td>";
				echo "<td><textarea class='styled3' id='noCol9[]' name='noCol9[]' maxlength='15' readonly>$rowPurchaseOrderDetailInfo[8]</textarea></td>";
				echo "<td><textarea class='styled3' id='noCol10[]' name='noCol10[]' maxlength='15' readonly>$rowPurchaseOrderDetailInfo[9]</textarea></td>";

				$strPurchaseOrderCheckbox2 = $rowPurchaseOrderDetailInfo[10];			
				if($numOfRows > 1){
					if($counter == 1){
						$strPurchaseOrderCheckbox = $strPurchaseOrderCheckbox.$strPurchaseOrderCheckbox2;
					}else{					
						if($counter <= $numOfRows){						
							$strPurchaseOrderCheckbox = $strPurchaseOrderCheckbox.",".$strPurchaseOrderCheckbox2;
						}else{
							$strPurchaseOrderCheckbox = $strPurchaseOrderCheckbox.$strPurchaseOrderCheckbox2;
						}
					}				
				}else{
					$strPurchaseOrderCheckbox = $strPurchaseOrderCheckbox2;
				}			
				
				echo "</tr>";	

				$intUniqueNameID = $intUniqueNameID + 1; 
			}
			echo "</table>";
		}	
	}
?>

</div>
<!--THE CONTAINER WHERE WE'll ADD THE DYNAMIC TABLE TOTAL-->
<div id="cont2">
<?php
	if($duplicateStatus==1){	
		if(mysqli_num_rows($resultPurchaseOrderDetailInfo) > 0){
			echo "<table width='1200px' cellpadding='1px' border='1px' id='empTableTotal'>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Subtotal</td><td style='width:9%'><input type='text' id='subTotal' name='subTotal' class='styled4' value='$rowPurchaseOrderInfo[2]' readonly></td><tr>";
			
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Discount Total</td><td style='width:9%'><input type='text' id='discountTotal' name='discountTotal' class='styled4' value='$rowPurchaseOrderInfo[5]' readonly></td><tr>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Total After Discount</td><td style='width:9%'><input type='text' id='totalAfterDiscount' name='totalAfterDiscount' class='styled4' value='$rowPurchaseOrderInfo[6]' readonly></td><tr>";
			
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Tax</td><td style='width:9%'><input type='text' id='taxTotal' name='taxTotal' class='styled4' value='$rowPurchaseOrderInfo[3]' readonly></td><tr>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Total</td><td style='width:9%'><input type='text' id='grandTotal' name='grandTotal' class='styled4' value='$rowPurchaseOrderInfo[4]' readonly></td><tr>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Round</td><td style='width:9%'><input type='text' id='roundAmount' name='roundAmount' class='styled4' value='$rowPurchaseOrderInfo[7]' readonly>";
			
			if($rowPurchaseOrderInfo[9] == 1){
				echo "<input type='checkbox' id='roundStatus' name='roundStatus' value='1' checked onclick='CalculateRowTotal()'>";
			}else{
				echo "<input type='checkbox' id='roundStatus' name='roundStatus' value='1' onclick='CalculateRowTotal()'>";
			}
			echo "</td><tr>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Rounded Total</td style='width:9%'><td><input type='text' id='groundTotalRound' name='groundTotalRound' class='styled4' value='$rowPurchaseOrderInfo[8]' readonly><input type='hidden' id='counterValue' value='$counter'></td><tr>";
			echo "</table>";
		}
	}
?>
</div>
<p>
<input type="button" id="addRow" value="Add New Row" onClick="addRow2()" />
</p>

<table width="1200px" cellpadding="0" border="1" class="mystyle">
<tr>
<td colspan="5" align="left">
<textarea name="purchaseOrderTerms" id="purchaseOrderTerms">
<?php if($duplicateStatus==1){echo $rowPurchaseOrderInfo[1];}else{echo $rowCompanyName[1];} ?>
</textarea>
<input type="hidden" name="customerIDvalue" id="customerIDvalue" value="<?php if($duplicateStatus==1){echo $customerID;}else{echo "0";}?>">
<input type="hidden" name="purchaseOrderCheckbox" id="purchaseOrderCheckbox" value="<?php echo $strPurchaseOrderCheckbox;?>">
</td></tr>
</table>


<p><input type="submit" id="bt" name="Submit" value="Create Purchase Order" <?php if($duplicateStatus==1){echo "disabled";}?>></p>

</form>
</center>

<script src="ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replace('purchaseOrderTerms');
	CKEDITOR.replace('purchaseOrderContent');
</script>

</body>
</html>