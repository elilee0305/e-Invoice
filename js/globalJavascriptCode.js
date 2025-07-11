	function CheckAccountingPeriod(){
		//access the php session variable by javascript
		//var dateAccountingStart = '<?php echo $_SESSION['accountingPeriodStart'];?>';
		//var dateAccountingEnd = '<?php echo $_SESSION['accountingPeriodEnd'];?>';
		
		var i = document.getElementById("demo2");
		var dateDocument = i.value;
		
		//change string to date object DATE PO
		const dateDocumentSplitArray = dateDocument.split("/"); //split
		var dateDocumentFormat = dateDocumentSplitArray[2]+"-"+dateDocumentSplitArray[1]+"-"+dateDocumentSplitArray[0];//rearrange for date constructor format
		const dateDocumentObject = new Date(dateDocumentFormat);//date object
		
		//no need split since format already date constructor format
		const dateAccountingStartObject = new Date(dateAccountingStart);//date object
		const dateAccountingEndObject = new Date(dateAccountingEnd);//date object
		
		if((dateDocumentObject >= dateAccountingStartObject) && (dateDocumentObject <= dateAccountingEndObject)){
			//within the open accounting period
			document.getElementById("dateTD").style.backgroundColor = "#90EE90";
			return true;
		} else {
			//outside the open accounting period
			document.getElementById("dateTD").style.backgroundColor = "#CD5C5C";
			return false;
		}
		
	}
	
	
	