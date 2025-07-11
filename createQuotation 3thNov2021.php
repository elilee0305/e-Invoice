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
		$customerID = $_POST['quotationCustomerID'];
		$quotationNo = makeSafe($_POST['quotationNo']);
		$dateQuotation = convertMysqlDateFormat($_POST['quotationDate']);		
		$quotationFrom = makeSafe($_POST['quotationFrom']);
		$quotationTitle = makeSafe($_POST['quotationTitle']);
		
		$quotationContent = $_POST['quotationContent'];		
		$quotationTerms = $_POST['quotationTerms'];		
			
		$quotationAttention = makeSafe($_POST['quotationAttention']);
		$quotationEmail = makeSafe($_POST['quotationEmail']);
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
		
		$sqlCreateQuotation = "INSERT INTO tbquotation(quotation_id, quotation_no, quotation_date, quotation_customerID, 
		quotation_title, quotation_content, quotation_from	, quotation_terms, quotation_attention, quotation_email, 
		quotation_subTotal, quotation_taxTotal, quotation_grandTotal, quotation_discountTotal, quotation_totalAfterDiscount, 
		quotation_roundAmount, quotation_grandTotalRound, quotation_roundStatus) 
		VALUES(NULL, '$quotationNo', '$dateQuotation', '$customerID', '$quotationTitle', '$quotationContent', '$quotationFrom', 
		'$quotationTerms', '$quotationAttention', '$quotationEmail', '$subTotal', 
		'$taxTotal', '$grandTotal', '$discountTotal', '$totalAfterDiscount', '$roundAmount', '$groundTotalRound', '$roundStatus')";
		
		mysqli_query($connection, $sqlCreateQuotation) or die("error in create quotation query");
		
		//create the quotation detail records
		$quotationID = mysqli_insert_id($connection);
		
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
			
			
			$aNoCheckbox = $_POST['quotationCheckbox'];//this is not an array but comma separated text because array cannot be hidden field
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
				
				/* echo "noValue1=".$noValue1;
				echo "noValue2=".$noValue2;
				echo "noValue3=".$noValue3;
				echo "noValue4=".$noValue4;
				echo "noValue5=".$noValue5;
				echo "quotationDetail_rowTotal=".$noValue6;
				echo "quotationDetail_taxRateID=".$noValue7;
				echo "quotationDetail_taxPercent=".$noValue8;
				echo "quotationDetail_taxTotal=".$noValue9;
				echo "quotationDetail_rowGrandTotal=".$noValue10;
				echo "quotationDetail_quotationID=".$quotationID;
				echo "quotationDetail_bold=".$noValueCheckbox;
				echo "quotationDetail_sortID=".$sortID;
				echo "quotationDetail_discountPercent=".$noValue11;
				echo "quotationDetail_discountAmount=".$noValue12;
				echo "quotationDetail_rowTotalAfterDiscount=".$noValue13; */				
				
				$sqlCreateQuotationDetail = "INSERT INTO tbquotationdetail(quotationDetail_id, quotationDetail_no1, quotationDetail_no2, 
				quotationDetail_no3, quotationDetail_no4, quotationDetail_no5, quotationDetail_rowTotal, quotationDetail_taxRateID, 
				quotationDetail_taxPercent, quotationDetail_taxTotal, quotationDetail_rowGrandTotal, 
				quotationDetail_quotationID, quotationDetail_bold, quotationDetail_sortID, quotationDetail_discountPercent, 
				quotationDetail_discountAmount, quotationDetail_rowTotalAfterDiscount) 
				VALUES(NULL, '$noValue1', '$noValue2', '$noValue3', '$noValue4', '$noValue5', '$noValue6', '$noValue7', '$noValue8', 
				'$noValue9', '$noValue10', '$quotationID', '$noValueCheckbox', '$sortID', '$noValue11', '$noValue12', '$noValue13')";
				
				mysqli_query($connection, $sqlCreateQuotationDetail) or die("error in create quotation detail query");		 	
				
			}			
		}		
		
		
		header ("Location: editQuotation.php?idQuotation=$quotationID&idCustomer=$customerID");		
	}	
	
	//get the company name
	$sqlCompanyName = "SELECT company_name, company_quotationTerms FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$rowCompanyName = mysqli_fetch_row($resultCompanyName);
	
	//get the MAX id from tbquotation
	$sqlMaxID = "SELECT quotation_no FROM tbquotation ORDER BY quotation_id DESC LIMIT 0,1";
	$resultMax = mysqli_query($connection, $sqlMaxID) or die("error in max ID query");
	$strLastQuotationNo = "";
	if(mysqli_num_rows($resultMax) > 0){
		$rowLastQuotationNo = mysqli_fetch_row($resultMax);
		$strLastQuotationNo = $rowLastQuotationNo[0];
	}	
	
	//get the customer info
	$customerID = $_GET['idCustomer'];
	$sqlCustomerInfo = "SELECT customer_name, customer_tel, customer_email, customer_attention, customer_address FROM tbcustomer WHERE 
	customer_id = '$customerID'";
	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer query");
	$rowCustomerInfo = mysqli_fetch_row($resultCustomerInfo);
	
	//get the duplicate Quotation info only if idQuotationDuplicate parameter set
	$duplicateStatus = 0;
	if(isset($_GET['idQuotationDuplicate'])){
		$duplicateStatus = 1;
		$quotationDuplicateID = $_GET['idQuotationDuplicate'];
		//get the quotation info	
		$sqlQuotationInfo = "SELECT quotation_content, quotation_terms, quotation_subTotal, quotation_taxTotal, quotation_grandTotal,
		quotation_discountTotal, quotation_totalAfterDiscount, quotation_roundAmount, quotation_grandTotalRound, quotation_roundStatus 
		FROM tbquotation WHERE quotation_id = '$quotationDuplicateID'";
		
		//get the quotation details
		$sqlQuotationDetailInfo = "SELECT quotationDetail_no1, quotationDetail_no2, quotationDetail_no3, quotationDetail_no4, quotationDetail_no5, 
		quotationDetail_rowTotal, quotationDetail_taxRateID, quotationDetail_taxPercent, quotationDetail_taxTotal, quotationDetail_rowGrandTotal, 
		quotationDetail_bold, quotationDetail_sortID, quotationDetail_discountPercent, quotationDetail_discountAmount, 
		quotationDetail_rowTotalAfterDiscount FROM tbquotationdetail 
		WHERE quotationDetail_quotationID = '$quotationDuplicateID' ORDER BY quotationDetail_sortID ASC";
		
		$resultQuotationInfo = mysqli_query($connection, $sqlQuotationInfo) or die("error in quotation query");
		$rowQuotationInfo = mysqli_fetch_row($resultQuotationInfo);
		
		
		$resultQuotationDetailInfo = mysqli_query($connection, $sqlQuotationDetailInfo) or die("error in quotation detail query");
		
		
	
	
	
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
<!--<link href="styles.css" rel="stylesheet" type="text/css">-->
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
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

.styled{
	min-height: 1em;
	max-height: 10vh;
	max-width: 425px;
	width: 425px;
	overflow: hidden;
}

.styled2{
	min-height: 1em;
	max-height: 5vh;
	max-width: 35px;
	width: 35px;
	overflow: hidden;
}

.styled3{
	min-height: 1em;
	max-height: 5vh;
	max-width: 50px;
	width: 50px;
	overflow: hidden;	
}

.styled4{
	min-height: 1em;
	max-height: 5vh;
	max-width: 80px;
	width: 80px;
	overflow: hidden;	
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


function popupwindow(url, title, w, h) {
    var y = window.outerHeight / 2 + window.screenY - ( h / 2)
    var x = window.outerWidth / 2 + window.screenX - ( w / 2)
    return window.open("searchProduct.php", title, 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=' + w + ', height=' + h + ', top=' + y + ', left=' + x);
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
		tr.style.backgroundColor = (it.checked) ? "D4E0D3" : "ffffff";
		
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
		document.getElementById('quotationCheckbox').value = values;
}

	function CheckQuotationNo(){		
		var checkEmptyQuotationNo = $("#quotationNo").val();
		if(checkEmptyQuotationNo===""){
			$("#info").html("<img border='0' src='images/Delete.ico'>");
			document.getElementById("bt").disabled = true;
		}else{			
			var data = "quotationNo="+$("#quotationNo").val();
			
			$.ajax({			 
				type : 'POST',
				url : 'checkExistingQuotation.php',
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
		var checkDuplicateQuotationNo = $("#quotationDuplicate").val();
		var customerID = $("#quotationCustomerID").val();
		
		if(checkDuplicateQuotationNo===""){
			//do nothing				
			quotationDuplicate.focus();
			
		}else{
			
			var data = "quotationNo="+$("#quotationDuplicate").val();
			
			$.ajax({			 
				type : 'POST',
				url : 'checkExistingQuotation.php',
				data : data,
				dataType : 'json',
				success : function(r)
				{
					if(r=="0"){
						$("#duplicateInfo").html("No Quotation!");
						quotationDuplicate.focus();
						//console.log(customerID);
							
					}else{									
						//Exists
						var customerIDvalue = parseFloat(customerID);
						var quotationIDvalue = parseFloat(r);
						window.location.href = "createQuotation.php?idCustomer="+customerIDvalue+"&idQuotationDuplicate="+quotationIDvalue;
					   					
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
		var checkEmptyQuotationNo = $("#quotationNo").val();
		if(checkEmptyQuotationNo===""){
			$("#info").html("<img border='0' src='images/Delete.ico'>");
			document.getElementById("bt").disabled = true;
			alert("Must enter Quotation No!");
			quotationNo.focus();
		}else{			
			var data = "quotationNo="+$("#quotationNo").val();
			
			$.ajax({			 
				type : 'POST',
				url : 'checkExistingQuotation.php',
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
				
				}	
			)	
		}	
	
	
		return false;
	
	}
	
	function ResubmitForm(g){
		if(g==0){
			
					
			
			var u = confirm("Do you want to Create Quotation?");
			if(u==true){
				$('#quotationForm').attr('onsubmit', 'return true');
			jQuery("#bt").trigger('click'); //auto submit by clicking the submit button id
			}
		
		
		
		}else{
			alert("This Quotation No already exist in Database!");
		}
		
		
		
		
	}
	
	
	
	
	

// ARRAY FOR HEADER.
    var arrHead = new Array();
    arrHead = ['', '', 'No', 'Description', 'Qty', 'Unit', '@Price', 'Total', 'Disc%', 'Disc', 'A.Disc', 'Tax Code', 'Rate', 'Tax Total', 'Total'];      // SIMPLY ADD OR REMOVE VALUES IN THE ARRAY FOR TABLE HEADERS.

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
					var eleImg = document.createElement('img');					
					
					ele.setAttribute('id', 'noCol2[]');
					ele.setAttribute('class', 'styled');					
					ele.setAttribute('name', 'noCol2[]');
					ele.setAttribute('maxlength', '200');
					
					eleImg.setAttribute('id', 'noColImg[]');
					eleImg.setAttribute('src', 'images/pencilplus2.jpg');
					eleImg.setAttribute('onclick', 'popupwindow()');
				
					
					
					td.appendChild(ele);
					td.appendChild(eleImg);
					
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
        
		document.getElementById('quotationCheckbox').value = values;
		
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
					
			document.getElementById('quotationCheckbox').value = values;
			
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
	
</script>
</head>
<?php 
	
	if($duplicateStatus==1){
	
		if(mysqli_num_rows($resultQuotationDetailInfo) == 0){
			echo "<body onload=\"createTable()\">";
		}else{
			echo "<body onload=\"GetTaxRateList()\">";
		}
	}else{
		echo "<body onload=\"createTable()\">";
	}


?>







<center>

<div class="navbar">
	<?php include 'menuPHPimes.php';?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>
<p class="bigGap"></p>
<form id="quotationForm" action="createQuotation.php" method="POST" onsubmit="return CheckAndSubmit()">
<table width="1200px" cellpadding="0" border="1" class="mystyle">
<tr bgcolor="AFCCB0"><td colspan="4" align="center"><h1>Create Quotation</h1></td><td><input type="text" name="quotationDuplicate" id="quotationDuplicate" size="12" maxlength="30">&nbsp;<img src="images/duplicatefinal.png" onclick="GetDuplicateInfo()"><span id="duplicateInfo" style="color:blue;font-size:12px"></span></td></tr>
<tr><td>Date</td><td><input id="demo2" type="text" name="quotationDate" size="10" value="<?php echo date('d/m/Y');?>" readonly>&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo2','ddMMyyyy')" style="cursor:pointer"/></td><td>&nbsp;</td><td>Our Reference No</td><td><input type="text" name="quotationNo" id="quotationNo" size="12" maxlength="30" value="<?php echo $strLastQuotationNo;?>" onchange="CheckQuotationNo()"><span id="info"><img border="0" src="images/Terminate.png"></span></td></tr>
<tr><td>To</td><td><?php echo $rowCustomerInfo[0]?></td><td></td><td>From</td><td><input type="text" name="quotationFrom" size="20" maxlength="50"></td></tr>



<tr><td>Attention</td><td><input type="text" name="quotationAttention" size="40" maxlength="100" value="<?php echo $rowCustomerInfo[3];?>"></td><td></td><td></td><td></td></tr>
<tr><td>Address</td><td><?php echo $rowCustomerInfo[4];?></td><td></td><td></td><td></td></tr>
<tr><td>Telephone</td><td><?php echo $rowCustomerInfo[1]?></td><td></td><td></td><td></td></tr>
<tr><td>Email</td><td><input type="text" name="quotationEmail" size="40" maxlength="100" value="<?php echo $rowCustomerInfo[2];?>"></td><td></td><td></td><td></td></tr>

<tr><td colspan="5" align="left"></td></tr>
<tr><td colspan="5" align="left">&nbsp;<input type="text" name="quotationTitle" maxlength="200" size="150" ></td></tr>
<tr><td colspan="5" align="left"><textarea name="quotationContent" id="quotationContent"><?php if($duplicateStatus==1){echo $rowQuotationInfo[0];}?></textarea></td></tr>
</table>
<!--this area we put the quotation details-->

<!--THE CONTAINER WHERE WE'll ADD THE DYNAMIC TABLE-->
<div id="cont">

<?php 
	if($duplicateStatus==1){
		
		$strQuotationCheckbox = ""; //to store which line is bold
	
		if(mysqli_num_rows($resultQuotationDetailInfo) > 0){
			
			$numOfRows = mysqli_num_rows($resultQuotationDetailInfo);
			$counter = 0;
			echo "<table width='800px' cellpadding='1px' border='1px' id='empTable'>";
			echo "<tr><th></th><th></th><th>No</th><th>Description</th><th>Qty</th><th>Unit</th><th>@Price</th><th>Total</th><th>Disc%</th><th>Disc</th><th>A.Dis</th><th>Tax Code</th><th>Rate</th><th>Tax Total</th><th>Total</th></tr>";
			
			
			while($rowQuotationDetailInfo = mysqli_fetch_row($resultQuotationDetailInfo)){
				
				$counter = $counter + 1;
				
				if($rowQuotationDetailInfo[10] == 1){
					echo "<tr bgcolor='D4E0D3'>";
				}else{
					echo "<tr>";
				}
				echo "<td><input type='button' value='del' onclick='removeRow(this)'></td>";
				echo "<td>";
				if($rowQuotationDetailInfo[10] == 1){
					echo "<input type='checkbox' name='noCheckbox' value='1' checked onclick='check(this)'>";
				}else{
					echo "<input type='checkbox' name='noCheckbox' value='1' onclick='check(this)'>";
				}
				echo "</td>";
				echo "<td><textarea class='styled2' id='noCol1[]' name='noCol1[]' maxlength='6'>$rowQuotationDetailInfo[0]</textarea></td>";
				echo "<td><textarea class='styled' id='noCol2[]' name='noCol2[]' maxlength='200'>$rowQuotationDetailInfo[1]</textarea></td>";
				
				if($rowQuotationDetailInfo[2]==0.00){
					echo "<td><textarea class='styled3' id='noCol3[]' name='noCol3[]' maxlength='10' onblur='CalculateRowTotal()'></textarea></td>";
				}else{
					echo "<td><textarea class='styled3' id='noCol3[]' name='noCol3[]' maxlength='10' onblur='CalculateRowTotal()'>$rowQuotationDetailInfo[2]</textarea></td>";
					
				}
				
				echo "<td><textarea class='styled3' id='noCol4[]' name='noCol4[]' maxlength='10'>$rowQuotationDetailInfo[3]</textarea></td>";
				echo "<td><textarea class='styled3' id='noCol5[]' name='noCol5[]' maxlength='15' onblur='CalculateRowTotal()'>$rowQuotationDetailInfo[4]</textarea></td>";
				echo "<td><textarea class='styled3' id='noCol6[]' name='noCol6[]' maxlength='15' readonly>$rowQuotationDetailInfo[5]</textarea></td>";
				//discount amount
				if($rowQuotationDetailInfo[12]==0.00){
					echo "<td><textarea class='styled3' id='noCol11[]' name='noCol11[]' maxlength='10' onblur='CalculateRowTotal()'></textarea></td>";
				}else{
					echo "<td><textarea class='styled3' id='noCol11[]' name='noCol11[]' maxlength='10' onblur='CalculateRowTotal()'>$rowQuotationDetailInfo[12]</textarea></td>";
				}
				//discount amount
				echo "<td><textarea class='styled3' id='noCol12[]' name='noCol12[]' maxlength='15' readonly>$rowQuotationDetailInfo[13]</textarea></td>";
				//total after discount
				echo "<td><textarea class='styled3' id='noCol13[]' name='noCol13[]' maxlength='15' readonly>$rowQuotationDetailInfo[14]</textarea></td>";
				
				echo "<td>";
				$idNameValue = "select|".$counter;
				echo "<select name='noCol7[]' id=$idNameValue onchange=\"GetTaxRate(id)\">";
				//reuse the recordset
				mysqli_data_seek($resultGetTaxRate, 0);
				if(mysqli_num_rows($resultGetTaxRate) > 0){
					$taxRateID = $rowQuotationDetailInfo[6];
					$arrayTest1 = searchArray(0, $taxRateID, $aTaxRateListDB);
					$taxRateCode = $aTaxRateListDB[$arrayTest1][1];
					echo "<option value=$taxRateID>$taxRateCode</option>";
					while($rowGetTaxRate=mysqli_fetch_array($resultGetTaxRate)){
						echo "<option value=$rowGetTaxRate[0]>$rowGetTaxRate[1]</option>";
					}
					
				}
				echo "</select></td>";
				
				$idNameValue2 = "rate|".$counter;
				
				echo "<td><textarea class='styled3' id=$idNameValue2 name='noCol8[]' readonly>$rowQuotationDetailInfo[7]</textarea></td>";
				echo "<td><textarea class='styled3' id='noCol9[]' name='noCol9[]' maxlength='15' readonly>$rowQuotationDetailInfo[8]</textarea></td>";
				echo "<td><textarea class='styled3' id='noCol10[]' name='noCol10[]' maxlength='15' readonly>$rowQuotationDetailInfo[9]</textarea></td>";
				
						

				$strQuotationCheckbox2 = $rowQuotationDetailInfo[10];			
				if($numOfRows > 1){
					if($counter == 1){
						$strQuotationCheckbox = $strQuotationCheckbox.$strQuotationCheckbox2;
					}else{					
						if($counter <= $numOfRows){						
							$strQuotationCheckbox = $strQuotationCheckbox.",".$strQuotationCheckbox2;
						}else{
							$strQuotationCheckbox = $strQuotationCheckbox.$strQuotationCheckbox2;
						}
					}				
				}else{
					$strQuotationCheckbox = $strQuotationCheckbox2;
				}			
				
				echo "</tr>";			
				
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
		if(mysqli_num_rows($resultQuotationDetailInfo) > 0){
			echo "<table width='1200px' cellpadding='1px' border='1px' id='empTableTotal'>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Subtotal</td><td style='width:9%'><input type='text' id='subTotal' name='subTotal' class='styled4' value='$rowQuotationInfo[2]' readonly></td><tr>";
			
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Discount Total</td><td style='width:9%'><input type='text' id='discountTotal' name='discountTotal' class='styled4' value='$rowQuotationInfo[5]' readonly></td><tr>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Total After Discount</td><td style='width:9%'><input type='text' id='totalAfterDiscount' name='totalAfterDiscount' class='styled4' value='$rowQuotationInfo[6]' readonly></td><tr>";
			
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Tax</td><td style='width:9%'><input type='text' id='taxTotal' name='taxTotal' class='styled4' value='$rowQuotationInfo[3]' readonly></td><tr>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Total</td><td style='width:9%'><input type='text' id='grandTotal' name='grandTotal' class='styled4' value='$rowQuotationInfo[4]' readonly></td><tr>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Round</td><td style='width:9%'><input type='text' id='roundAmount' name='roundAmount' class='styled4' value='$rowQuotationInfo[7]' readonly>";
			
			
			if($rowQuotationInfo[9] == 1){
				echo "<input type='checkbox' id='roundStatus' name='roundStatus' value='1' checked onclick='CalculateRowTotal()'>";
			}else{
				echo "<input type='checkbox' id='roundStatus' name='roundStatus' value='1' onclick='CalculateRowTotal()'>";
			}
			
			echo "</td><tr>";
			echo "<tr><td style='width:76%'></td><td style='width:15%'>Rounded Total</td style='width:9%'><td><input type='text' id='groundTotalRound' name='groundTotalRound' class='styled4' value='$rowQuotationInfo[8]' readonly><input type='hidden' id='counterValue' value='$counter'></td><tr>";


			
			echo "</table>";

		}
	}
?>

















</div>

<p>
<input type="button" id="addRow" value="Add New Row" onClick="addRow2()" />
</p>

<table width="1200px" cellpadding="0" border="1" class="mystyle">
<tr><td colspan="5" align="left"><textarea name="quotationTerms" id="quotationTerms"><?php if($duplicateStatus==1){echo $rowQuotationInfo[1];}else{echo $rowCompanyName[1];} ?></textarea></td></tr>

<tr><td colspan="5">
<input type="hidden" name="quotationCustomerID" id="quotationCustomerID" value="<?php echo $customerID?>">
<input type="hidden" name="quotationCheckbox" id="quotationCheckbox" value="">
</td></tr>

</table>
<p><input type="submit" id="bt" name="Submit" value="Create Quotation"></p>

</form>
</center>
<script src="ckeditor/ckeditor.js"></script>
<script>
	CKEDITOR.replace('quotationTerms');
	CKEDITOR.replace('quotationContent');
</script>

</body>
</html>