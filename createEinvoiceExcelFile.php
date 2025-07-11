<?php
	
	// Set the default timezone to UTC
	date_default_timezone_set('UTC');

	// Get the current time in UTC
	$utcTime = new DateTime('now', new DateTimeZone('UTC'));

	// User's timezone for Malaysia
	$userTimezone = 'Asia/Kuala_Lumpur'; // Malaysia timezone

	// Create a DateTimeZone object for the user's timezone
	$userTZ = new DateTimeZone($userTimezone);

	// Convert the UTC time to the user's local time
	$localTime = $utcTime->setTimezone($userTZ);

	// Format the local time as dd-MM-yyyy h:i:s A
	$formattedLocalTime = $localTime->format('d-m-Y h:i:s A');

	// Output the local time
	//echo "Local time in Malaysia: " . $formattedLocalTime;
	
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");
	
	// Include the SimpleXLSX and SimpleXLSXGen libraries
	require 'excelcreate/SimpleXLSX.php';
	require 'excelcreate/SimpleXLSXGen.php';

	// Path to the Excel template
	$filePath = 'exceltemplate/batchupload.xlsx';

	$invoiceID = $_GET['idInvoice'];
	$customerID = $_GET['idCustomer'];	

	//get the invoice info	
	$sqlInvoiceInfo = "SELECT invoice_id, invoice_no, invoice_date, invoice_title, invoice_from, invoice_terms, 
	invoice_attention, invoice_email, invoice_subTotal, 
	invoice_taxTotal, invoice_grandTotal, invoice_discountTotal, invoice_totalAfterDiscount, 
	invoice_roundAmount, invoice_grandTotalRound, invoice_roundStatus, invoice_content, 
	invoice_quotationID, invoice_quotationNo, invoice_deliveryOrderID, invoice_deliveryOrderNo, invoice_dueDate, invoice_dueDateNo,
	invoice_status FROM tbinvoice WHERE invoice_id = '$invoiceID'";

	$resultInvoiceInfo = mysqli_query($connection, $sqlInvoiceInfo) or die("error in invoice query");
	$rowInvoiceInfo = mysqli_fetch_row($resultInvoiceInfo);

	$invoice_id = $rowInvoiceInfo[0]; //Invoice ID
	$invoiceNumber = $rowInvoiceInfo[1]; //Invoice No

	$invoiceGrandTotal = $rowInvoiceInfo[10]; //Grand Total
	$invoiceTaxTotal = $rowInvoiceInfo[9]; //Tax Total
	$invoiceSubTotal = $rowInvoiceInfo[8]; //Sub Total

	//get the invoice details
	$sqlInvoiceDetails = "SELECT invoiceDetail_id, invoiceDetail_invoiceID, invoiceDetail_no1, invoiceDetail_no2, invoiceDetail_no3, invoiceDetail_no4, invoiceDetail_no5,
	invoiceDetail_taxRateID, invoiceDetail_taxPercent, invoiceDetail_taxTotal, invoiceDetail_rowGrandTotal, invoiceDetail_discountPercent,
	invoiceDetail_discountAmount, invoiceDetail_rowTotalAfterDiscount FROM tbinvoicedetail WHERE  invoiceDetail_invoiceID = '$invoiceID'";

	$resultInvoiceDetails = mysqli_query($connection, $sqlInvoiceDetails) or die("error in invoice details query");
	$rowInvoiceDetails = mysqli_fetch_row($resultInvoiceDetails);

	// Assign the invoice details to variables
    $invoiceDetailID = $rowInvoiceDetails[0];
	$invoiceDetail_invoiceID = $rowInvoiceDetails[1];
	$invoiceDetailNo1 = $rowInvoiceDetails[2];
	$invoiceDetailNo2 = $rowInvoiceDetails[3];
    $invoiceDetailNo3 = $rowInvoiceDetails[4];
    $invoiceDetailNo4 = $rowInvoiceDetails[5];
    $invoiceDetailNo5 = $rowInvoiceDetails[6];
    $invoiceDetailTaxRateID = $rowInvoiceDetails[7];
    $invoiceDetailTaxPercent = $rowInvoiceDetails[8]; // Tax Rate ID
    $invoiceDetailTaxTotal = $rowInvoiceDetails[9];
    $invoiceDetailRowGrandTotal = $rowInvoiceDetails[10];
    $invoiceDetailDiscountPercent = $rowInvoiceDetails[11];
    $invoiceDetailDiscountAmount = $rowInvoiceDetails[12];
    $invoiceDetailRowTotalAfterDiscount = $rowInvoiceDetails[13];

	//get the tax details
	$sqlTaxRate = "SELECT taxRate_id, taxRate_code, taxRate_rate, taxRate_description, taxRate_default FROM tbtaxrate WHERE taxRate_id = '$invoiceDetailTaxRateID'";
	$resultTaxRate = mysqli_query($connection, $sqlTaxRate) or die("error in invoice details query");
	$rowTaxRate = mysqli_fetch_row($resultTaxRate);

	// Assign the tax details to variables
	$taxRate_id = $rowTaxRate[0];
	$taxRate_code = $rowTaxRate[1];
	$taxRate_rate = $rowTaxRate[2];
	$taxRate_description = $rowTaxRate[3];
	$taxRate_default = $rowTaxRate[4];

	// Retrieve the product details	
	$sqlProduct = "SELECT product_id, product_sellingPrice, product_uom, classification_id FROM tbproduct WHERE product_name = '$invoiceDetailNo2'";	
	$resultProduct = mysqli_query($connection, $sqlProduct) or die("error in product query");
	$rowProduct = mysqli_fetch_row($resultProduct);

	// Assign the product details to variables
	$productID = $rowProduct[0];
	$productSellingPrice = $rowProduct[1];
	$productUom = $rowProduct[2];
	$classification_id = $rowProduct[3];

	// Retrieve the classification details	
	// Note: classification_id is a foreign key to the tbproduct table. Hence, product_id is used to retrieve the classification details
	$sqlClassification = "SELECT classification_id, classification_code, classification_desc FROM tbclassifications WHERE classification_id = '$classification_id'";	
	$resultCls = mysqli_query($connection, $sqlClassification) or die("error in classification query");
	$rowCls = mysqli_fetch_row($resultCls);

	// Assign the classification details to variables
	$classification_id = $rowCls[0];
	$classification_code = $rowCls[1];
	$classification_desc = $rowCls[2];

	//get the company info
	$sqlCompanyInfo = "SELECT company_name, company_no, company_TINnumber, company_SSTnumber, company_email, company_MSICcode, company_MSICdescription, company_telFax, company_stateCode 
	FROM tbcompany WHERE company_id = 1";
	$resultCompanyInfo = mysqli_query($connection, $sqlCompanyInfo) or die("error in company info query");
	$rowCompanyInfo = mysqli_fetch_row($resultCompanyInfo);
	
	//get the customer info	
	$sqlCustomerInfo = "SELECT customer_name, customer_TINnumber, customer_ROCnumber, customer_email, customer_tel FROM tbcustomer WHERE customer_id = '$customerID'";	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer query");
	$rowCustomerInfo2 = mysqli_fetch_row($resultCustomerInfo);
	
	$supplierTINno = $rowCompanyInfo[2];
	$supplierName = $rowCompanyInfo[0];
	$supplierIDno = $rowCompanyInfo[1]; //ROC Number
	$supplierSSTno = $rowCompanyInfo[3]; //SST Number
	$supplierEmail = $rowCompanyInfo[4]; //Email
	$supplierMSIC = $rowCompanyInfo[5]; //MSIC
	$supplierMSICdescription = $rowCompanyInfo[6]; //MSIC description
	$supplierTelNo = $rowCompanyInfo[7]; 
	$supplirStateCode = $rowCompanyInfo[8]; 
	
	//customer details
	$customerTINno = $rowCustomerInfo2[1];
	$customerROCno = $rowCustomerInfo2[2];
	$customerName = $rowCustomerInfo2[0];
	$customerEmail = $rowCustomerInfo2[3];
	$customerTel = $rowCustomerInfo2[4];

	// Initialize arrays for each sheet
	$rowsDocuments = []; 					// Documents sheet
	$rowsDocumentLineItems = []; 			// DocumentLineItems sheet
	$rowsLineItemsAddClassifications = []; 	// LineItemsAddClassifications sheet
	$rowsLineItemsTaxes = []; 				// LineItemsTaxes sheet
	$rowsLineItemsDiscounts = []; 			// LineItemsDiscounts sheet
	$rowsDocumentTotalTax = []; 			// DocumentTotalTax sheet
	$rowsDocumentDiscounts = []; 			// DocumentDiscounts sheet
	$rowsDocumentCharges = []; 			// DocumentCharges sheet
	$debugRows = []; //for debugging purposes

	function logDebugInfo($variableName, $value) {
		global $debugRows; // Access debug rows array
		$debugRows[] = [$variableName, var_export($value, true)];
	}

	// Log all variables you want to debug
	logDebugInfo('$invoiceID', $invoiceID);
	logDebugInfo('$customerID', $customerID);
	logDebugInfo('$formattedLocalTime', $formattedLocalTime);
	logDebugInfo('$supplierTINno', $supplierTINno);
	logDebugInfo('$supplierName', $supplierName);
	logDebugInfo('$invoiceNumber', $invoiceNumber);

	logDebugInfo('$invoice_id', $invoice_id);
	//logDebugInfo('$classificationCode', $classificationCode);
	logDebugInfo('$productSellingPrice', $productSellingPrice);
	//logDebugInfo('$invoiceDetail_no3', $invoiceDetail_no3);
	logDebugInfo('$productUom', $productUom);
	logDebugInfo('$invoiceSubTotal', $invoiceSubTotal);
	logDebugInfo('$invoiceTaxTotal', $invoiceTaxTotal);
	logDebugInfo('$invoiceGrandTotal', $invoiceGrandTotal);
	//logDebugInfo('$product_name', $productName);
	//logDebugInfo('$product_id', $product_id);
	
	// Parse the template
	if ($xlsx = \Shuchkin\SimpleXLSX::parse($filePath)) {
		$newData = [];  // Array to store updated data

	   // Loop through each worksheet
		foreach ($xlsx->sheetNames() as $sheetIndex => $sheetName) {{
			$rows = $xlsx->rows($sheetIndex);  // Get rows from the current worksheet
			
			////////////////////////////////
			/*	1.	Document Sheet		*/
			////////////////////////////////

			// Update cell B6 in the "Documents" sheet
			if ($sheetName === "Documents") {
				// Ensure row 6 (index 5) exists with at least two columns
				if (!isset($rows[5])) {
					$rows[5] = array_fill(0, 2, '');  // Create row 6 with two empty columns
				} elseif (count($rows[5]) < 2) {
					$rows[5] = array_pad($rows[5], 2, '');  // Pad row to ensure two columns
				}
				
				// B6 is Invoice No
				$rows[5][1] = $invoiceNumber;
				//C6 is the document type code
				$rows[5][2] = "01"; //Invoice code
				//D6 Invoice version
				$rows[5][3] = "1.10"; 
				//E6 is time format
				$rows[5][4] = $formattedLocalTime; 
				//F6 Currency code
				$rows[5][5] = "MYR";
				//G6 Currency exchange code
				$rows[5][6] = "";
				//G6 Supplier TIN No
				$rows[5][7] = $supplierTINno;
				//I6 Supplier Name
				$rows[5][8] = $supplierName;
				//J6 Supplier ID Type
				$rows[5][9] = "BRN"; 
				//K6 Supplier ID No
				$rows[5][10] = $supplierIDno;
				//Sales tax / service tax (SST) registration number of the Supplier
				$rows[5][11] = $supplierSSTno;
				//Tourism tax registration number of the Supplier
				$rows[5][12] = "";
				//Supplier Email
				$rows[5][13] = $supplierEmail;
				//https://sdk.myinvois.hasil.gov.my/codes/msic-codes/ this is where to get code and Description
				//Supplier MSIC
				$rows[5][14] = $supplierMSIC;
				//MSIC description
				$rows[5][15] = $supplierMSICdescription;
				//Supplier Address leave blank first
				$rows[5][16] = "NA";
				$rows[5][17] = "";
				$rows[5][18] = "";
				$rows[5][19] = "";
				$rows[5][20] = "";
				
				//State code SELANGOR				
				$rows[5][21] = $supplirStateCode;
				
				//Country code
				$rows[5][22] = "MYS";
				$rows[5][23] = $supplierTelNo;
				//Customer Details
				$rows[5][24] = $customerTINno;
				$rows[5][25] = $customerName;
				$rows[5][26] = "BRN"; //Must be one of the values 'NRIC', 'BRN', 'PASSPORT', or 'ARMY'.
				$rows[5][27] = $customerROCno;
				$rows[5][28] = ""; //customer SST
				$rows[5][29] = $customerEmail; 
				
				//Customer address
				$rows[5][30] = "NA"; 
				$rows[5][31] = ""; 
				$rows[5][32] = ""; 
				$rows[5][33] = ""; 
				$rows[5][34] = ""; 
				$rows[5][35] = $supplirStateCode; //State code SELANGOR
				//Country code
				$rows[5][36] = "MYS";
				$rows[5][37] = $customerTel;
				
				//Invoice Amounts
				$rows[5][38] = $rowInvoiceInfo[7];//TotalExcludingTax
				$rows[5][39] = $rowInvoiceInfo[7];//TotalIncludingTax
				$rows[5][40] = $rowInvoiceInfo[7];//TotalPayableAmount
				
				$rows[5][41] = $rowInvoiceInfo[7];//TotalNetAmount
				$rows[5][42] = 0.00;//TotalDiscountValue
				$rows[5][43] = 0.00;//TotalChargeAmount
				$rows[5][44] = 0.00;//TotalRoundingAmount
				$rows[5][45] = 0.00;//TotalTaxAmount
				
				//optional
				$rows[5][46] = ""; //Frequency of the invoice 
				$rows[5][47] = ""; // BillingPeriod.StartDate
				$rows[5][48] = ""; // BillingPeriod.EndDate
				
				//mandotory
				$rows[5][49] = "01"; // Payment Mode
				
				//optional
				$rows[5][50] = "MYDF123456789009654321"; // SupplierBankAccountNumber 
				$rows[5][51] = ""; // PaymentTerms 
				$rows[5][52] = ""; // PrePaymentAmount 
				$rows[5][53] = ""; // PrePaymentDate 
				$rows[5][54] = ""; // PrePaymentTime 
				$rows[5][55] = ""; // PrePaymentReferenceNumber 
				$rows[5][56] = ""; // BillReferenceNumber 
				$rows[5][57] = ""; // ShippingRecipientName 
				$rows[5][58] = ""; // ShippingRecipientAddress.Address.AddressLine0 
				$rows[5][59] = ""; // ShippingRecipientAddress.Address.AddressLine1
				$rows[5][60] = ""; // ShippingRecipientAddress.Address.AddressLine2
				$rows[5][61] = ""; // ShippingRecipientAddress.Address.PostalZone
				$rows[5][62] = ""; // ShippingRecipientAddress.Address.CityName
				$rows[5][63] = ""; // ShippingRecipientAddress.Address.State
				$rows[5][64] = ""; // ShippingRecipientAddress.Address.CountryCode
				$rows[5][65] = ""; // ShippingRecipientTIN
				$rows[5][66] = ""; // ShippingRecipientRegistrationNumber.Type
				$rows[5][67] = ""; // ShippingRecipientRegistrationNumber.Number
				$rows[5][68] = ""; // Incoterms
				$rows[5][69] = ""; // FreeTradeAgreement
				$rows[5][70] = ""; // AuthorisationNumberCertifiedExporter
				$rows[5][71] = ""; // ReferenceNumberCustomsFormNo2
				$rows[5][72] = ""; // DetailsOtherCharges.eInvoiceNumber
				$rows[5][73] = ""; // DetailsOtherCharges.Amount
				$rows[5][74] = ""; // DetailsOtherCharges.Description
				
				$rowsDocuments = $rows; // Store updated data for Documents sheet
			}
			
//////////////////////////////////////////////////
/*	2.	Reference Number Customs Forms Sheet	*/
//////////////////////////////////////////////////

// ReferenceNumberCustomsForms -> only applicable for transaction that is related to transportaiton of goods.
// -> add an indicator in a database (?) ; include conditional statement 
// serialNo, eInvoiceNumber, ReferenceNumberofCustomsFormNo1or9


				// DocumentReferences Sheet -> omitted out as it is not required for e-invoice

				//////////////////////////////////////////
				/*	3.	Document Line Items Sheet		*/
				//////////////////////////////////////////

				//https://sdk.myinvois.hasil.gov.my/codes/classification-codes/ -> to get the classification codes
				
				if ($sheetName === "DocumentLineItems") {
					$sqlInvoiceItems = "SELECT 
											tbinvoicedetail.invoiceDetail_no3 AS quantity,
											tbinvoicedetail.invoiceDetail_rowGrandTotal AS subtotal,
											tbinvoicedetail.invoiceDetail_taxTotal AS totalTaxAmt,
											tbinvoicedetail.invoiceDetail_rowTotalAfterDiscount  AS totalExcTax,  
											tbproduct.product_id AS productID,
											tbproduct.product_sellingPrice AS unitPrice,
											tbproduct.product_name AS productName,
											tbproduct.product_uom AS unitOfMeasurement,
											tbclassifications.classification_code AS classificationCode
										FROM tbinvoicedetail
										JOIN tbproduct ON tbinvoicedetail.invoiceDetail_no2 = tbproduct.product_name
										LEFT JOIN tbclassifications ON tbproduct.classification_id = tbclassifications.classification_id
										WHERE tbinvoicedetail.invoiceDetail_invoiceID = '$invoiceID'";
					$resultInvoiceItems = mysqli_query($connection, $sqlInvoiceItems) or die("Error fetching invoice items");
		
					$rowIndex = 5; // Start from row 6 (index 5)
					while ($row = mysqli_fetch_assoc($resultInvoiceItems)) {
						// Ensure row exists with at least two columns
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 2, '');  // Create row with two empty columns
						} elseif (count($rows[$rowIndex]) < 2) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 2, '');  // Pad row to ensure two columns
						}

						$rows[$rowIndex][1] = $invoiceNumber;           	// eInvoiceNumber
						$rows[$rowIndex][2] = $row['productID'];            // Id 
						$rows[$rowIndex][3] = $row['classificationCode'];	// Classifications code
						$rows[$rowIndex][4] = $row['productName'];          // DescriptionProductService
						$rows[$rowIndex][5] = $row['unitPrice'];      		// UnitPrice
						$rows[$rowIndex][6] = $row['quantity'];       		// Quantity -- Optional 
						$rows[$rowIndex][7] = $row['unitOfMeasurement'];    // UnitOfMeasurement -- Optional 
						$rows[$rowIndex][8] = $row['subtotal'];       		// Subtotal
						$rows[$rowIndex][9] = $row['totalTaxAmt'];         	// TotalTaxAmount
						$rows[$rowIndex][10] = $row['totalExcTax'];      	// TotalExcludingTax
						$rows[$rowIndex][11] = "";                      	// ProductTariffCode -- Optional
						$rows[$rowIndex][12] = "";                      	// CountryofOrigin -- Optional
						
						$rowIndex++; // Move to the next row for the next product
					}
					$rowsDocumentLineItems = $rows; // Store updated data for DocumentLineItems sheet
				}

				//////////////////////////////////////////////
				/*	4. Line Items Add Classifications Sheet	*/
				/////////////////////////////////////////////
			
				if ($sheetName === "LineItemsAddClassifications") {
				$sqlClassification = "SELECT classification_id, classification_code, classification_desc FROM tbclassifications WHERE classification_id = '$classification_id'";
				$resultCls = mysqli_query($connection, $sqlClassification) or die("error in classification query");

				$rowIndex = 5; // Start from row 6 (index 5)
				// Purpose: Add Classification for products that ONLY requires more than 1 classification	
				// Check if the product has more than one classification
				if (mysqli_num_rows($resultCls) > 1) {
					while ($rowCls = mysqli_fetch_assoc($resultCls)) {
						// Ensure row exists with at least three columns
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 2, '');  // Create row with 2 empty columns
						} elseif (count($rows[$rowIndex]) < 2) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 2, '');  // Pad row to ensure 2 columns
						}
	
						$rows[$rowIndex][1] = $invoiceNumber;           // eInvoiceNumber
						$rows[$rowIndex][2] = $product_id;              // LineItem.ID
						$rows[$rowIndex][3] = $classification_code; 	// ClassificationCode
				
						$rowIndex++; // Move to the next row for the next classification
					} 
				} else {
						// If the item does not have more than one classification, add a default row
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 2, '');  // Create row with 2 empty columns
						} elseif (count($rows[$rowIndex]) < 2) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 2, '');  // Pad row to ensure three columns
						}
							$rows[$rowIndex][1] = "";           // eInvoiceNumber
							$rows[$rowIndex][2] = "";           // LineItem.ID
							$rows[$rowIndex][3] = ""; 			// Default message

							$rowIndex++; // Move to the next row
						}
					$rowsLineItemsAddClassifications = $rows; // Store updated data for LineItemsAddClassifications sheet
				}
			}

				//////////////////////////////////
				/*	5. Line Items Taxes Sheet	*/
				/////////////////////////////////

				// Loop through all the items in the invoice and print the tax related information for each item

				if ($sheetName === "LineItemsTaxes") {
					// Loop through all the items in the invoice and print the tax related information for each item
					$sqlInvoiceItems = "SELECT 
											tbinvoicedetail.invoiceDetail_taxTotal AS taxTotal,
											tbproduct.product_id AS productID,
											tbproduct.product_name AS productName,
											tbtaxrate.taxRate_code AS taxRateCode,
											tbtaxrate.taxRate_rate AS taxRateRate
										FROM tbinvoicedetail
										JOIN tbproduct ON tbinvoicedetail.invoiceDetail_no2 = tbproduct.product_name
										JOIN tbtaxrate ON tbinvoicedetail.invoiceDetail_taxRateID = tbtaxrate.taxRate_id
										WHERE tbinvoicedetail.invoiceDetail_invoiceID = '$invoiceID'";
					$resultInvoiceItems = mysqli_query($connection, $sqlInvoiceItems) or die("Error fetching invoice items");

					$rowIndex = 5; // Start from row 6 (index 5)
					while ($row = mysqli_fetch_assoc($resultInvoiceItems)) {
						// Log the variables for debugging purposes 
						logDebugInfo('$taxTotal', $row['taxTotal']);
						logDebugInfo('$taxRateCode', $row['taxRateCode']);
						logDebugInfo('$taxRateRate', $row['taxRateRate']);

						// Ensure row exists with at least two columns
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 2, '');  // Create row with 2 empty columns
						} elseif (count($rows[$rowIndex]) < 2) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 2, '');  // Pad row to ensure 2 columns
						}

						$rows[$rowIndex][1] = $invoiceNumber;           // eInvoiceNumber
						$rows[$rowIndex][2] = $row['productID'];         // LineItem.ID
						$rows[$rowIndex][3] = $row['taxRateCode'];       // TaxType
						$rows[$rowIndex][4] = $row['taxRateRate'];       // TaxRate
						$rows[$rowIndex][5] = $row['taxTotal'];          // TaxAmount

						// Conditional checks for PerUnitAmount, BaseUnitMeasure, AmountTaxExempted, and DetailsTaxExemption
						if ($row['taxRateCode'] === 'E') {
							$rows[$rowIndex][6] = "";                        // PerUnitAmount
							$rows[$rowIndex][7] = "";                        // BaseUnitMeasure
							$rows[$rowIndex][8] = $row['taxTotal'];          // AmountTaxExempted
							$rows[$rowIndex][9] = "Tax exempted";            // DetailsTaxExemption
						} else {
							$rows[$rowIndex][6] = "";                        // PerUnitAmount
							$rows[$rowIndex][7] = "";                        // BaseUnitMeasure
							$rows[$rowIndex][8] = "";                        // AmountTaxExempted
							$rows[$rowIndex][9] = "";                        // DetailsTaxExemption
						}
						$rowIndex++; // Move to the next row for the next product
					}
					$rowsLineItemsTaxes = $rows; // Store updated data 
				}

				//////////////////////////////////////
				/* 6. Line Items Discounts Sheet	*/
				//////////////////////////////////////

				// Loop through all the items in the invoice and print the discount related information for each item
				if ($sheetName === "LineItemsDiscounts") {
					// Loop through all the items in the invoice and print the discount related information for each item
					$sqlInvoiceItems = "SELECT 
											tbinvoicedetail.invoiceDetail_discountPercent AS discountPercent,
											tbinvoicedetail.invoiceDetail_discountAmount AS discountAmount,
											tbproduct.product_id AS productID,
											tbproduct.product_name AS productName,
											tbinvoicedetail.invoiceDetail_discountDesc AS discountDesc
										FROM tbinvoicedetail
										JOIN tbproduct ON tbinvoicedetail.invoiceDetail_no2 = tbproduct.product_name
										WHERE tbinvoicedetail.invoiceDetail_invoiceID = '$invoiceID'";
					$resultInvoiceItems = mysqli_query($connection, $sqlInvoiceItems) or die("Error fetching invoice items");
				
					$rowIndex = 5; // Start from row 6 (index 5)
					while ($row = mysqli_fetch_assoc($resultInvoiceItems)) {

						  // Log variables for debugging
						  logDebugInfo('$discountPercent', $row['discountPercent']);
						  logDebugInfo('$discountAmount', $row['discountAmount']);

						// Ensure row exists with at least two columns
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 2, '');  // Create row with 2 empty columns
						} elseif (count($rows[$rowIndex]) < 2) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 2, '');  // Pad row to ensure 2 columns
						}
				
						$rows[$rowIndex][1] = $invoiceNumber;           	// eInvoiceNumber
						$rows[$rowIndex][2] = $row['productID'];         	// LineItem.ID
						$rows[$rowIndex][3] = $row['discountPercent'];   	// DiscountRate
						$rows[$rowIndex][4] = $row['discountAmount'];    	// DiscountAmount
						$rows[$rowIndex][5] = "EMPTY"; //$row['discountDesc'];			// DiscountDescription
			
						$rowIndex++; // Move to the next row for the next product
					}
					$rowsLineItemsDiscounts = $rows; // Store updated data
				}
			
				//////////////////////////////////
				/* 7. Line Items Charges Sheet	*/
				//////////////////////////////////

							/*tbinvoicedetail.invoiceDetail_chargeRate AS chargeRate,
								tbinvoicedetail.invoiceDetail_chargeAmount AS chargeAmount,*/

				if ($sheetName === "LineItemsCharges") {
					$sqlInvoiceItems = "SELECT 
											tbproduct.product_id AS productID,
											tbproduct.product_name AS productName
										FROM tbinvoicedetail
										JOIN tbproduct ON tbinvoicedetail.invoiceDetail_no2 = tbproduct.product_name
										WHERE tbinvoicedetail.invoiceDetail_invoiceID = '$invoiceID'";
					$resultInvoiceItems = mysqli_query($connection, $sqlInvoiceItems) or die("error in invoice items query");

					$rowIndex = 5; // Start from row 6 (index 5)
					while ($row = mysqli_fetch_assoc($resultInvoiceItems)) {
						// Ensure row exists with at least two columns
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 2, '');  // Create row with 2 empty columns
						} elseif (count($rows[$rowIndex]) < 2) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 2, '');  // Pad row to ensure 2 columns
						}

 						$rows[$rowIndex][1] = $invoiceNumber;          	 // eInvoiceNumber
						$rows[$rowIndex][2] = $row['productID'];         // ProductID
						//$rows[$rowIndex][3] = $row['chargeRate'];        // ChargeRate
						//$rows[$rowIndex][4] = $row['chargeAmount'];      // chargeAmount
						//$rows[$rowIndex][5] = $row['chargeDesc'];       // chargeDesc

						$rowIndex++; // Move to the next row for the next product
					}
					$rowsLineItemsCharges = $rows; // Store updated data
				}

				//////////////////////////////////
				/*	8. Document Total Tax Sheet	*/
				//////////////////////////////////

				if ($sheetName === "DocumentTotalTax") {
					$sqlInvoiceItems = "SELECT 
											tbinvoice.invoice_no AS invoiceNo,
											tbinvoicedetail.invoiceDetail_taxTotal AS taxTotal,
											tbproduct.product_id AS productID,
											tbproduct.product_name AS productName,
											tbtaxrate.taxRate_code AS taxRateCode,
											tbtaxrate.taxRate_rate AS taxRateRate,
											tbtaxrate.taxRate_description AS taxDesc
										FROM tbinvoicedetail
										JOIN tbinvoice ON tbinvoicedetail.invoiceDetail_invoiceID = tbinvoice.invoice_id
										JOIN tbproduct ON tbinvoicedetail.invoiceDetail_no2 = tbproduct.product_name
										JOIN tbtaxrate ON tbinvoicedetail.invoiceDetail_taxRateID = tbtaxrate.taxRate_id
										WHERE tbinvoicedetail.invoiceDetail_invoiceID = '$invoiceID'";
					$resultInvoiceItems = mysqli_query($connection, $sqlInvoiceItems) or die("error in invoice items query");

					// eInvoiceNumber	TaxType	TotalTaxableAmount	TotalTaxAmount	AmountTaxExempted	DetailsTaxExemption

					$rowIndex = 5; // Start from row 6 (index 5)
					while ($row = mysqli_fetch_assoc($resultInvoiceItems)) {
						// Ensure row exists with at least six columns
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 6, '');  // Create row with 6 empty columns
						} elseif (count($rows[$rowIndex]) < 6) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 6, '');  // Pad row to ensure 6 columns
						}
						$rows[$rowIndex][1] = $row['invoiceNo'];        // eInvoiceNumber
						$rows[$rowIndex][2] = $row['taxRateCode'];      // TaxType
						$rows[$rowIndex][3] = $row['taxTotal'];			// TotalTaxableAmount
						$rows[$rowIndex][4] = $row['taxRateRate'];      // TotalTaxAmount
						$rows[$rowIndex][5] = "EMPTY"; //$row[''];      // AmountTaxExempted
						$rows[$rowIndex][6] = $row['taxDesc'];          // DetailsTaxExemption -- Optional

						$rowIndex++; // Move to the next row for the next product
					}
					$rowsDocumentTotalTax = $rows; // Store updated data
				}

				//////////////////////////////////////
				/*	9.	Document Discounts Sheet	*/
				//////////////////////////////////////
				
				if ($sheetName === "DocumentDiscounts") {
					$sqlInvoiceItems = "SELECT 
                            tbinvoice.invoice_discountTotal AS discountTotal,
                            tbinvoice.invoice_no AS invoiceNo,
                            GROUP_CONCAT(DISTINCT tbinvoicedetail.invoiceDetail_discountDesc SEPARATOR ', ') AS discountDesc
                        FROM tbinvoice
                        JOIN tbinvoicedetail ON tbinvoice.invoice_id = tbinvoicedetail.invoiceDetail_invoiceID
                        WHERE tbinvoice.invoice_id = '$invoiceID'
                        GROUP BY tbinvoice.invoice_no";
					    $resultInvoiceItems = mysqli_query($connection, $sqlInvoiceItems) or die("error in invoice items query");

					$rowIndex = 5; // Start from row 6 (index 5)
					while ($row = mysqli_fetch_assoc($resultInvoiceItems)) {
						// Ensure row exists with at least three columns
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 2, '');  // Create row with 3 empty columns
						} elseif (count($rows[$rowIndex]) < 2) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 2, '');  // Pad row to ensure 3 columns
						}
						$rows[$rowIndex][1] = $row['invoiceNo'];        // eInvoiceNumber
						$rows[$rowIndex][2] = $row['discountDesc'];     // DiscountDescription
						$rows[$rowIndex][3] = $row['discountTotal'];    // DiscountAmount
				
						$rowIndex++; // Move to the next row for the next product
					}
					$rowsDocumentDiscounts = $rows; // Store updated data
				}

				//////////////////////////////////
				/*	10. Document Charges Sheet	*/
				//////////////////////////////////

				if ($sheetName === "DocumentCharges") {
					$sqlInvoiceItems = "SELECT 
											tbinvoice.invoice_no AS invoiceNo,
											tbcharge.charge_id AS chargeID,
											tbcharge.charge_desc AS chargeDesc,
											tbcharge.charge_rate AS chargeRate
										FROM tbinvoice
										JOIN tbinvoicedetail ON tbinvoice.invoice_id = tbinvoicedetail.invoiceDetail_invoiceID
										JOIN tbcharge ON tbinvoicedetail.invoiceDetail_chargeID = tbcharge.charge_id
										WHERE tbinvoice.invoice_id = '$invoiceID'";
					$resultInvoiceItems = mysqli_query($connection, $sqlInvoiceItems) or die("error in invoice items query");
				
					$rowIndex = 5; // Start from row 6 (index 5)
					while ($row = mysqli_fetch_assoc($resultInvoiceItems)) {
						    // Log the fetched row for debugging
							logDebugInfo('Fetched Row', $row);
						// Ensure row exists with at least 2 columns
						if (!isset($rows[$rowIndex])) {
							$rows[$rowIndex] = array_fill(0, 2, '');  // Create row with 2 empty columns
						} elseif (count($rows[$rowIndex]) < 2) {
							$rows[$rowIndex] = array_pad($rows[$rowIndex], 2, '');  // Pad row to ensure 2 columns
						}
						$rows[$rowIndex][1] = $row['invoiceNo'];          // eInvoiceNumber
						//$rows[$rowIndex][2] = $row['chargeDesc'];         // ChargeDescription
 						//$rows[$rowIndex][4] = $row['chargeTotal'];        // ChargeAmount -> sum of chargeAmount
				
						$rowIndex++; // Move to the next row for the next product
					}
					$rowsDocumentCharges = $rows; // Store updated data
				}
			
					$newData[] = $rows;  // Store updated data
			}

		// Create a new Excel file
		$gen = new \Shuchkin\SimpleXLSXGen();
		$gen->addSheet($rowsDocuments, 'Documents');
		//$gen->addSheet($rowsReferenceNumberCustomsForms, 'ReferenceNumberCustomsForms');
		//$gen->addSheet($rowsDocumentReferences, 'DocumentReferences');
		$gen->addSheet($rowsDocumentLineItems, 'DocumentLineItems');
		$gen->addSheet($rowsLineItemsAddClassifications, 'LineItemsAddClassifications');
		$gen->addSheet($rowsLineItemsTaxes, 'LineItemsTaxes');
		$gen->addSheet($rowsLineItemsDiscounts, 'LineItemsDiscounts');
		$gen->addSheet($rowsLineItemsCharges, 'LineItemsCharges');
		$gen->addSheet($rowsDocumentTotalTax, 'DocumentTotalTax');
		$gen->addSheet($rowsDocumentDiscounts, 'DocumentDiscounts');
		$gen->addSheet($rowsDocumentCharges, '	DocumentCharges');
		$gen->addSheet($debugRows, 'Debug Info');
		$gen->saveAs('output/batchupload_debugged.xlsx');
		
		// Add worksheets to the new Excel file
		/*foreach ($newData as $index => $rows) {
			$gen->addSheet($rows, $xlsx->sheetNames()[$index]);
		}
*/
		// Save the new Excel file to a temporary location
		$newFileName = 'lhdnInvoice.xlsx';
		$tempPath = sys_get_temp_dir() . '/' . $newFileName;
		$gen->saveAs($tempPath);

		// Ensure proper headers for Excel download
		header('Content-Description: File Transfer');
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="' . $newFileName . '"');
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		header('Content-Length: ' . filesize($tempPath));
		
		ob_clean();
		flush();

		// Send the file for download and delete it after
		readfile($tempPath);
		unlink($tempPath);
	} else {
		echo "Error reading Excel file: " . \Shuchkin\SimpleXLSX::parseError();
	}
?>