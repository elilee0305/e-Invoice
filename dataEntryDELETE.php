<?php 
	session_start();
	if($_SESSION['userID']==""){
		//not logged in
		ob_start();
		header ("Location: index.php");
		ob_flush();
	}
	include ('connectionLitloSimen.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");	
	include ('makeSafe.php');
	
	//-----------------------------------------------------
	//get all the driver list and put inside array
	$aDriverList = array();
	$aDriverListDB = array();//hold the list to prevent multiple queries
	
	$sqlDriverList = "SELECT driver_id, driver_name FROM tbdriver ORDER BY driver_name ASC";
	$resultDriverList = mysqli_query($connection, $sqlDriverList) or die("error in driver list query");
	$d = 0;
	
	while($rowDriverList = mysqli_fetch_array($resultDriverList)){	
		$aDriverList[] = $rowDriverList[0];	
		$aDriverListDB[$d][0] = $rowDriverList[0];
		$aDriverListDB[$d][1] = $rowDriverList[1];
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
	
	
	

	//create simen transaction record
	if(isset($_POST['Submit'])){

		//double check if Data Entry no exist in database		
		$simenOrderNo = $_POST['simenOrderNo'];
		$sqlCheckExistingDataEntry = "SELECT dataEntry_id FROM tbdataentry WHERE dataEntry_no = '$simenOrderNo'";
		$resultCheckExistingDataEntry = mysqli_query($connection, $sqlCheckExistingDataEntry) or die("error in check existing data entry no");

		if(mysqli_num_rows($resultCheckExistingDataEntry)>0){
			//got existing order form no
		}else{
			$userID = $_SESSION['userID'];
			$simenInitialOrderNo = $_POST['simenInitialOrderNo'];
			$simenDate = convertMysqlDateFormat($_POST['simenDate']);		
			$simenSupplierID = $_POST['simenSupplierID'];
			$simenSupplierOwnerID = $_POST['simenSupplierOwnerID'];			
			$simenSupplierCode = $_POST['simenSupplierCode'];//test
			$simenSupplierOriginalCode = $_POST['simenSupplierOriginalCode'];//test
			$simenSupplierCommissionCode = $_POST['simenSupplierCommissionCode'];//test			
			$simenSupplierPayment = $_POST['simenSupplierPayment'];//test			
			$simenSupplierAdvance = $_POST['simenSupplierAdvance'];//test
			//$simenSupplierCommission = $_POST['simenSupplierCommission'];//test
			//$simenSupplierCommissionID = $_POST['simenSupplierCommissionID'];
			
			$simenPlantID = $_POST['simenPlantID'];	
			$simenPlantCode = $_POST['simenPlantCode'];//test			
			
			$simenActMT = $_POST['simenActMT'];//test
			$simenCalMT = $_POST['simenCalMT'];//test
			//$simenPlantReceive = $_POST['simenPlantReceive'];//test	
			$simenSellingPrice =$_POST['simenSellingPrice'];//test
			$simenDOno =$_POST['simenDOno'];		
			
			if((empty($simenSupplierCode))||(is_numeric($simenSupplierCode)==false)){$simenSupplierCode = 0;}			
			if((empty($simenSupplierOriginalCode))||(is_numeric($simenSupplierOriginalCode)==false)){$simenSupplierOriginalCode = 0;}
			if((empty($simenSupplierCommissionCode))||(is_numeric($simenSupplierCommissionCode)==false)){$simenSupplierCommissionCode = 0;}			
			if((empty($simenSupplierPayment))||(is_numeric($simenSupplierPayment)==false)){$simenSupplierPayment = 0;}
			if((empty($simenSupplierAdvance))||(is_numeric($simenSupplierAdvance)==false)){$simenSupplierAdvance = 0;}
			//if((empty($simenSupplierCommission))||(is_numeric($simenSupplierCommission)==false)){$simenSupplierCommission = 0;}			
			if((empty($simenActMT))||(is_numeric($simenActMT)==false)){$simenActMT = 0;}		
			if((empty($simenCalMT))||(is_numeric($simenCalMT)==false)){$simenCalMT = 0;}
			if((empty($simenPlantCode))||(is_numeric($simenPlantCode)==false)){$simenPlantCode = 0;}			
			//if((empty($simenPlantReceive))||(is_numeric($simenPlantReceive)==false)){$simenPlantReceive = 0;}
			if((empty($simenSellingPrice))||(is_numeric($simenSellingPrice)==false)){$simenSellingPrice = 0;}			

			//supplier advance date
			$simenSupplierAdvanceDate = $_POST['simenSupplierAdvanceDate'];	
			if(empty($simenSupplierAdvanceDate)){			
				$sqlCreateSimenTransaction2 = "NULL, ";
			}else{
				$simenSupplierAdvanceDate = convertMysqlDateFormat($simenSupplierAdvanceDate);
				$sqlCreateSimenTransaction2 = "'$simenSupplierAdvanceDate', ";
			}
			
			
			//supplier paid date
			$simenSupplierDate = $_POST['simenSupplierDate'];					
			
			if(empty($simenSupplierDate)){			
				$sqlCreateSimenTransaction3 = "NULL)";
			}else{
				$simenSupplierDate = convertMysqlDateFormat($simenSupplierDate);
				$sqlCreateSimenTransaction3 = "'$simenSupplierDate')";
			}

			//create the 3 drivers info together			
			/* $driverName1 = ""; 
			$driverName2 = ""; 
			$driverName3 = ""; */
			$driverCode1 = 0;
			$driverCode2 = 0;
			$driverCode3 = 0;
			$driverPayment1 = 0;
			$driverPayment2 = 0;
			$driverPayment3 = 0;
			$driverCommission1 = 0;
			$driverCommission2 = 0;
			$driverCommission3 = 0;
			$supplierCommision1 = 0;
			$supplierCommision2 = 0;
			$supplierCommision3 = 0;		
			
			if($_POST['simenSupplierCommissionID1'] > 0){
				$supplierCommision1 = $_POST['simenSupplierCommission1'];//test
				if((empty($supplierCommision1))||(is_numeric($supplierCommision1)==false)){$supplierCommision1 = 0;}			
			}
			
			if($_POST['simenSupplierCommissionID2'] > 0){
				$supplierCommision2 = $_POST['simenSupplierCommission2'];//test
				if((empty($supplierCommision2))||(is_numeric($supplierCommision2)==false)){$supplierCommision2 = 0;}			
			}
			
			if($_POST['simenSupplierCommissionID3'] > 0){
				$supplierCommision3 = $_POST['simenSupplierCommission3'];//test
				if((empty($supplierCommision3))||(is_numeric($supplierCommision3)==false)){$supplierCommision3 = 0;}			
			}			
			
			
			if($_POST['simenDriver1ID']>0){
				$driverID1 = $_POST['simenDriver1ID'];
				$arrayTest1 = searchArray(0, $driverID1, $aDriverListDB);
				//$driverName1 = $aDriverListDB[$arrayTest1][1];
				
				$driverCode1 = $_POST['simenDriver1Code'];
				if((empty($driverCode1))||(is_numeric($driverCode1)==false)){$driverCode1 = 0;}	
				
				$driverPayment1 = $_POST['simenDriver1Payment'];
				if((empty($driverPayment1))||(is_numeric($driverPayment1)==false)){$driverPayment1 = 0;}				
				
				$driverCommission1 = $_POST['simenDriver1Commission'];//test
				if((empty($driverCommission1))||(is_numeric($driverCommission1)==false)){$driverCommission1 = 0;}				
			}
			
			if($_POST['simenDriver2ID']>0){
				$driverID2 = $_POST['simenDriver2ID'];
				$arrayTest2 = searchArray(0, $driverID2, $aDriverListDB);
				//$driverName2 = "/".$aDriverListDB[$arrayTest2][1];

				$driverCode2 = $_POST['simenDriver2Code'];
				if((empty($driverCode2))||(is_numeric($driverCode2)==false)){$driverCode2 = 0;}	
				
				$driverPayment2 = $_POST['simenDriver2Payment'];
				if((empty($driverPayment2))||(is_numeric($driverPayment2)==false)){$driverPayment2 = 0;}
				
				$driverCommission2 = $_POST['simenDriver2Commission'];//test
				if((empty($driverCommission2))||(is_numeric($driverCommission2)==false)){$driverCommission2 = 0;}
			}
			
			if($_POST['simenDriver3ID']>0){
				$driverID3 = $_POST['simenDriver3ID'];
				$arrayTest3 = searchArray(0, $driverID3, $aDriverListDB);
				//$driverName3 = "/".$aDriverListDB[$arrayTest3][1];

				$driverCode3 = $_POST['simenDriver3Code'];
				if((empty($driverCode3))||(is_numeric($driverCode3)==false)){$driverCode3 = 0;}

				$driverPayment3 = $_POST['simenDriver3Payment'];
				if((empty($driverPayment3))||(is_numeric($driverPayment3)==false)){$driverPayment3 = 0;}

				$driverCommission3 = $_POST['simenDriver3Commission'];//test
				if((empty($driverCommission3))||(is_numeric($driverCommission3)==false)){$driverCommission3 = 0;}				
				
			}
			
			//$driverCompleteNames = $driverName1.$driverName2.$driverName3;
			$driverCodeTotal = $driverCode1 + $driverCode2 + $driverCode3;
			$driverPaymentTotal = $driverPayment1 + $driverPayment2 + $driverPayment3;
			$driverSupplierCommissionTotal = $supplierCommision1 + $supplierCommision2 + $supplierCommision3 + $driverCommission1 + $driverCommission2 + $driverCommission3;
			
			
			
			
			$sqlCreateSimenTransaction = "INSERT INTO tbdataentry(dataEntry_id, dataEntry_noInitial, dataEntry_no, dataEntry_date, dataEntry_supplierID, 
			dataEntry_supplierOwnerID, dataEntry_supplierCode, dataEntry_supplierPayment, dataEntry_plantID, dataEntry_actualMT, 
			dataEntry_calculatedMT, dataEntry_plantReceive, dataEntry_sellingPrice, dataEntry_doNo, dataEntry_supplierAdvance, 
			dataEntry_plantCode, dataEntry_supplierOriginalCode, dataEntry_supplierCommissionCode, 
			dataEntry_createID, dataEntry_driver3Code, dataEntry_driver3Payment, dataEntry_driverSupplierCommission, 
			dataEntry_supplierAdvanceDate, dataEntry_supplierPaid) 
			VALUES(NULL, '$simenInitialOrderNo', '$simenOrderNo', '$simenDate', '$simenSupplierID', '$simenSupplierOwnerID', '$simenSupplierCode', 
			'$simenSupplierPayment', '$simenPlantID', '$simenActMT', '$simenCalMT', 0, '$simenSellingPrice', '$simenDOno', '$simenSupplierAdvance', 
			'$simenPlantCode', '$simenSupplierOriginalCode', '$simenSupplierCommissionCode', '$userID', '$driverCodeTotal', 
			'$driverPaymentTotal', '$driverSupplierCommissionTotal', ";
			
			$sqlCreateSimenTransaction = $sqlCreateSimenTransaction.$sqlCreateSimenTransaction2.$sqlCreateSimenTransaction3;		
			
			$result = mysqli_query($connection, $sqlCreateSimenTransaction) or die("error in insert simen transaction query");
			
			//get ID of inserted Data Entry record
			$dataEntryID = mysqli_insert_id($connection);			
			
			
			//create the suppliers commission info only for selected suppliers commission 1 dataEntry			
			$simenSupplierCommissionID1 = $_POST['simenSupplierCommissionID1'];
			
			if($simenSupplierCommissionID1 > 0){				
				//commission paid date
				$simenSupplierCommissionDate1 = $_POST['simenSupplierCommissionDate1'];				
				
				if(empty($simenSupplierCommissionDate1)){			
					$sqlCreateSupplierCommission2 = "NULL)";
				}else{
					$simenSupplierCommissionDate1 = convertMysqlDateFormat($simenSupplierCommissionDate1);
					$sqlCreateSupplierCommission2 = "'$simenSupplierCommissionDate1')";
				}				
				$simenSupplierCommissionCode1 = $_POST['simenSupplierCommissionCode1'];//test
				$simenSupplierCommission1 = $_POST['simenSupplierCommission1'];//test				
				
				if((empty($simenSupplierCommissionCode1))||(is_numeric($simenSupplierCommissionCode1)==false)){$simenSupplierCommissionCode1 = 0;}
				if((empty($simenSupplierCommission1))||(is_numeric($simenSupplierCommission1)==false)){$simenSupplierCommission1 = 0;}
				
				$sqlCreateSupplierCommission = "INSERT INTO tbsuppliercommissiondataentry(supplierCommissionDataEntry_id, 
				supplierCommissionDataEntry_dataEntryID, supplierCommissionDataEntry_commissionID, supplierCommissionDataEntry_commissionCode, 
				supplierCommissionDataEntry_commission, supplierCommissionDataEntry_date) VALUES(NULL, '$dataEntryID', '$simenSupplierCommissionID1', 
				'$simenSupplierCommissionCode1', '$simenSupplierCommission1', ";
				
				$sqlCreateSupplierCommission = $sqlCreateSupplierCommission.$sqlCreateSupplierCommission2;				
				$result = mysqli_query($connection, $sqlCreateSupplierCommission) or die("error in insert supplier commission 1 query");				
			}			
			
			
			//create the suppliers commission info only for selected suppliers commission 2 dataEntry			
			$simenSupplierCommissionID2 = $_POST['simenSupplierCommissionID2'];
			
			if($simenSupplierCommissionID2 > 0){				
				//commission paid date
				$simenSupplierCommissionDate2 = $_POST['simenSupplierCommissionDate2'];				
				
				if(empty($simenSupplierCommissionDate2)){			
					$sqlCreateSupplierCommission2 = "NULL)";
				}else{
					$simenSupplierCommissionDate2 = convertMysqlDateFormat($simenSupplierCommissionDate2);
					$sqlCreateSupplierCommission2 = "'$simenSupplierCommissionDate2')";
				}				
				$simenSupplierCommissionCode2 = $_POST['simenSupplierCommissionCode2'];//test
				$simenSupplierCommission2 = $_POST['simenSupplierCommission2'];//test				
				
				if((empty($simenSupplierCommissionCode2))||(is_numeric($simenSupplierCommissionCode2)==false)){$simenSupplierCommissionCode2 = 0;}
				if((empty($simenSupplierCommission2))||(is_numeric($simenSupplierCommission2)==false)){$simenSupplierCommission2 = 0;}
				
				$sqlCreateSupplierCommission = "INSERT INTO tbsuppliercommissiondataentry(supplierCommissionDataEntry_id, 
				supplierCommissionDataEntry_dataEntryID, supplierCommissionDataEntry_commissionID, supplierCommissionDataEntry_commissionCode, 
				supplierCommissionDataEntry_commission, supplierCommissionDataEntry_date) VALUES(NULL, '$dataEntryID', '$simenSupplierCommissionID2', 
				'$simenSupplierCommissionCode2', '$simenSupplierCommission2', ";
				
				$sqlCreateSupplierCommission = $sqlCreateSupplierCommission.$sqlCreateSupplierCommission2;				
				$result = mysqli_query($connection, $sqlCreateSupplierCommission) or die("error in insert supplier commission 2 query");				
			}
			
			
			
			//create the suppliers commission info only for selected suppliers commission 3 dataEntry			
			$simenSupplierCommissionID3 = $_POST['simenSupplierCommissionID3'];
			
			if($simenSupplierCommissionID3 > 0){				
				//commission paid date
				$simenSupplierCommissionDate3 = $_POST['simenSupplierCommissionDate3'];				
				
				if(empty($simenSupplierCommissionDate3)){			
					$sqlCreateSupplierCommission2 = "NULL)";
				}else{
					$simenSupplierCommissionDate3 = convertMysqlDateFormat($simenSupplierCommissionDate3);
					$sqlCreateSupplierCommission2 = "'$simenSupplierCommissionDate3')";
				}				
				$simenSupplierCommissionCode3 = $_POST['simenSupplierCommissionCode3'];//test
				$simenSupplierCommission3 = $_POST['simenSupplierCommission3'];//test				
				
				if((empty($simenSupplierCommissionCode3))||(is_numeric($simenSupplierCommissionCode3)==false)){$simenSupplierCommissionCode3 = 0;}
				if((empty($simenSupplierCommission3))||(is_numeric($simenSupplierCommission3)==false)){$simenSupplierCommission3 = 0;}
				
				$sqlCreateSupplierCommission = "INSERT INTO tbsuppliercommissiondataentry(supplierCommissionDataEntry_id, 
				supplierCommissionDataEntry_dataEntryID, supplierCommissionDataEntry_commissionID, supplierCommissionDataEntry_commissionCode, 
				supplierCommissionDataEntry_commission, supplierCommissionDataEntry_date) VALUES(NULL, '$dataEntryID', '$simenSupplierCommissionID3', 
				'$simenSupplierCommissionCode3', '$simenSupplierCommission3', ";
				
				$sqlCreateSupplierCommission = $sqlCreateSupplierCommission.$sqlCreateSupplierCommission2;				
				$result = mysqli_query($connection, $sqlCreateSupplierCommission) or die("error in insert supplier commission 3 query");				
			}
			
			
			//create the drivers info only for selected drivers tbdriverdataentry
			$simenDriver1ID = $_POST['simenDriver1ID'];
			$simenDriverInitialOrderNo = $_POST['simenDriverInitialOrderNo'];
						
			if($simenDriver1ID <> 0){
				$endLabel = 1;
				$simenDriver1Code = $_POST['simenDriver1Code'];//test
				$simenDriver1OriginalCode = $_POST['simenDriver1OriginalCode'];//test
				$simenDriver1CommissionCode = $_POST['simenDriver1CommissionCode'];//test				
				$simenDriver1Payment = $_POST['simenDriver1Payment'];//test
				$simenDriver1Advance = $_POST['simenDriver1Advance'];//test
				$simenDriver1AdvanceDate = $_POST['simenDriver1AdvanceDate'];
				$simenDriver1Commission = $_POST['simenDriver1Commission'];//test		
				
				//driver paid date
				$simenDriver1Date = $_POST['simenDriver1Date'];
				
				//driver commission & date paid
				$simenDriverCommission1ID = $_POST['simenDriverCommission1ID'];
				$simenDriverCommission1Date = $_POST['simenDriverCommission1Date'];		
				
				if(empty($simenDriver1Date)){			
					$sqlCreateDriverTransaction2 = "NULL, ";
				}else{
					$simenDriver1Date = convertMysqlDateFormat($simenDriver1Date);
					$sqlCreateDriverTransaction2 = "'$simenDriver1Date', ";
				}
				//advance date
				if(empty($simenDriver1AdvanceDate)){			
					$sqlCreateDriverTransaction3 = "NULL, ";
				}else{
					$simenDriver1AdvanceDate = convertMysqlDateFormat($simenDriver1AdvanceDate);
					$sqlCreateDriverTransaction3 = "'$simenDriver1AdvanceDate', ";
				}				
				
				//commission date only captured if commission person selected
				if($simenDriverCommission1ID<>0){
					if(empty($simenDriverCommission1Date)){			
						$sqlCreateDriverTransaction4 = "NULL)";
					}else{
						$simenDriverCommission1Date = convertMysqlDateFormat($simenDriverCommission1Date);
						$sqlCreateDriverTransaction4 = "'$simenDriverCommission1Date')";
					}				
				}else{
					$sqlCreateDriverTransaction4 = "NULL)";
				}				
				
				if((empty($simenDriver1Code))||(is_numeric($simenDriver1Code)==false)){$simenDriver1Code = 0;}				
				if((empty($simenDriver1OriginalCode))||(is_numeric($simenDriver1OriginalCode)==false)){$simenDriver1OriginalCode = 0;}
				if((empty($simenDriver1CommissionCode))||(is_numeric($simenDriver1CommissionCode)==false)){$simenDriver1CommissionCode = 0;}				
				if((empty($simenDriver1Payment))||(is_numeric($simenDriver1Payment)==false)){$simenDriver1Payment = 0;}
				if((empty($simenDriver1Advance))||(is_numeric($simenDriver1Advance)==false)){$simenDriver1Advance = 0;}
				if((empty($simenDriver1Commission))||(is_numeric($simenDriver1Commission)==false)){$simenDriver1Commission = 0;}
				
				$sqlCreateDriverTransaction = "INSERT INTO tbdriverdataentry(driverDataEntry_id, driverDataEntry_noInitial, 
				driverDataEntry_noEnd, driverDataEntry_dataEntryID, driverDataEntry_driverID, driverDataEntry_driverCode, 
				driverDataEntry_driverPayment, driverDataEntry_advance, driverDataEntry_commission, driverDataEntry_driverOriginalCode, 
				driverDataEntry_driverCommissionCode, driverDataEntry_driverCommissionID, driverDataEntry_driverPaid, 
				driverDataEntry_driverAdvanceDate, driverDataEntry_driverCommissionDate) 
				VALUES(NULL, '$simenDriverInitialOrderNo', '$endLabel', '$dataEntryID', '$simenDriver1ID', '$simenDriver1Code', 
				'$simenDriver1Payment', '$simenDriver1Advance', '$simenDriver1Commission', '$simenDriver1OriginalCode', 
				'$simenDriver1CommissionCode', '$simenDriverCommission1ID', ";
			
				$sqlCreateDriverTransaction = $sqlCreateDriverTransaction.$sqlCreateDriverTransaction2.$sqlCreateDriverTransaction3.$sqlCreateDriverTransaction4;
			
				$result = mysqli_query($connection, $sqlCreateDriverTransaction) or die("error in insert driver 1 transaction query");
			}

			//create the drivers info only for selected drivers tbdriverdataentry
			$simenDriver2ID = $_POST['simenDriver2ID'];
			if($simenDriver2ID <> 0){
				
				if($simenDriver1ID <> 0){
					$endLabel = 2;
				}else{
					$endLabel = 1;
				}				
				
				$simenDriver2Code = $_POST['simenDriver2Code'];//test				
				$simenDriver2OriginalCode = $_POST['simenDriver2OriginalCode'];//test
				$simenDriver2CommissionCode = $_POST['simenDriver2CommissionCode'];//test	
				
				$simenDriver2Payment = $_POST['simenDriver2Payment'];//test
				$simenDriver2Advance = $_POST['simenDriver2Advance'];//test
				$simenDriver2AdvanceDate = $_POST['simenDriver2AdvanceDate'];
				$simenDriver2Commission = $_POST['simenDriver2Commission'];//test				
				
				//driver paid date
				$simenDriver2Date = $_POST['simenDriver2Date'];
				//driver commission & date paid
				$simenDriverCommission2ID = $_POST['simenDriverCommission2ID'];
				$simenDriverCommission2Date = $_POST['simenDriverCommission2Date'];				
				
				if(empty($simenDriver2Date)){			
					$sqlCreateDriverTransaction2 = "NULL, ";
				}else{
					$simenDriver2Date = convertMysqlDateFormat($simenDriver2Date);
					$sqlCreateDriverTransaction2 = "'$simenDriver2Date', ";
				}

				//advance date
				if(empty($simenDriver2AdvanceDate)){			
					$sqlCreateDriverTransaction3 = "NULL, ";
				}else{
					$simenDriver2AdvanceDate = convertMysqlDateFormat($simenDriver2AdvanceDate);
					$sqlCreateDriverTransaction3 = "'$simenDriver2AdvanceDate', ";
				}				
				
				//commission date only captured if commission person selected
				if($simenDriverCommission2ID<>0){
					if(empty($simenDriverCommission2Date)){			
						$sqlCreateDriverTransaction4 = "NULL)";
					}else{
						$simenDriverCommission2Date = convertMysqlDateFormat($simenDriverCommission2Date);
						$sqlCreateDriverTransaction4 = "'$simenDriverCommission2Date')";
					}				
				}else{
					$sqlCreateDriverTransaction4 = "NULL)";
				}
				
				if((empty($simenDriver2Code))||(is_numeric($simenDriver2Code)==false)){$simenDriver2Code = 0;}
				if((empty($simenDriver2OriginalCode))||(is_numeric($simenDriver2OriginalCode)==false)){$simenDriver2OriginalCode = 0;}
				if((empty($simenDriver2CommissionCode))||(is_numeric($simenDriver2CommissionCode)==false)){$simenDriver2CommissionCode = 0;}	
				
				if((empty($simenDriver2Payment))||(is_numeric($simenDriver2Payment)==false)){$simenDriver2Payment = 0;}
				if((empty($simenDriver2Advance))||(is_numeric($simenDriver2Advance)==false)){$simenDriver2Advance = 0;}
				if((empty($simenDriver2Commission))||(is_numeric($simenDriver2Commission)==false)){$simenDriver2Commission = 0;}
				
				$sqlCreateDriverTransaction = "INSERT INTO tbdriverdataentry(driverDataEntry_id, driverDataEntry_noInitial, 
				driverDataEntry_noEnd, driverDataEntry_dataEntryID, driverDataEntry_driverID, driverDataEntry_driverCode, driverDataEntry_driverPayment, driverDataEntry_advance, 
				driverDataEntry_commission, driverDataEntry_driverOriginalCode, driverDataEntry_driverCommissionCode,
				driverDataEntry_driverCommissionID, driverDataEntry_driverPaid, driverDataEntry_driverAdvanceDate, 
				driverDataEntry_driverCommissionDate) 
				VALUES(NULL, '$simenDriverInitialOrderNo', '$endLabel', '$dataEntryID', '$simenDriver2ID', 
				'$simenDriver2Code', '$simenDriver2Payment', '$simenDriver2Advance', '$simenDriver2Commission', '$simenDriver2OriginalCode', 
				'$simenDriver2CommissionCode', '$simenDriverCommission2ID', ";
			
				$sqlCreateDriverTransaction = $sqlCreateDriverTransaction.$sqlCreateDriverTransaction2.$sqlCreateDriverTransaction3.$sqlCreateDriverTransaction4;
			
				$result = mysqli_query($connection, $sqlCreateDriverTransaction) or die("error in insert driver transaction query");
			}
						
			//create the drivers info only for selected drivers tbdriverdataentry
			$simenDriver3ID = $_POST['simenDriver3ID'];
			if($simenDriver3ID <> 0){
				
				if(($simenDriver1ID <> 0)&&($simenDriver2ID <> 0)){
					$endLabel = 3;
				}elseif(($simenDriver1ID == 0)&&($simenDriver2ID <> 0)){
					$endLabel = 2;
				}elseif(($simenDriver1ID <> 0)&&($simenDriver2ID == 0)){
					$endLabel = 2;
				}elseif(($simenDriver1ID == 0)&&($simenDriver2ID == 0)){
					$endLabel = 1;
				}
			
				$simenDriver3Code = $_POST['simenDriver3Code'];//test
				$simenDriver3OriginalCode = $_POST['simenDriver3OriginalCode'];//test
				$simenDriver3CommissionCode = $_POST['simenDriver3CommissionCode'];//test				
				$simenDriver3Payment = $_POST['simenDriver3Payment'];//test
				$simenDriver3Advance = $_POST['simenDriver3Advance'];//test
				$simenDriver3AdvanceDate = $_POST['simenDriver3AdvanceDate'];
				$simenDriver3Commission = $_POST['simenDriver3Commission'];//test				
				
				//driver paid date
				$simenDriver3Date = $_POST['simenDriver3Date'];
				//driver commission & date paid
				$simenDriverCommission3ID = $_POST['simenDriverCommission3ID'];
				$simenDriverCommission3Date = $_POST['simenDriverCommission3Date'];	
				
				if(empty($simenDriver3Date)){			
					$sqlCreateDriverTransaction2 = "NULL, ";
				}else{
					$simenDriver3Date = convertMysqlDateFormat($simenDriver3Date);
					$sqlCreateDriverTransaction2 = "'$simenDriver3Date', ";
				}
				
				//advance date
				if(empty($simenDriver3AdvanceDate)){			
					$sqlCreateDriverTransaction3 = "NULL, ";
				}else{
					$simenDriver3AdvanceDate = convertMysqlDateFormat($simenDriver3AdvanceDate);
					$sqlCreateDriverTransaction3 = "'$simenDriver3AdvanceDate', ";
				}
				
				

				//commission date only captured if commission person selected
				if($simenDriverCommission3ID<>0){
					if(empty($simenDriverCommission3Date)){			
						$sqlCreateDriverTransaction4 = "NULL)";
					}else{
						$simenDriverCommission3Date = convertMysqlDateFormat($simenDriverCommission3Date);
						$sqlCreateDriverTransaction4 = "'$simenDriverCommission3Date')";
					}				
				}else{
					$sqlCreateDriverTransaction4 = "NULL)";
				}				
				
				if((empty($simenDriver3Code))||(is_numeric($simenDriver3Code)==false)){$simenDriver3Code = 0;}
				if((empty($simenDriver3OriginalCode))||(is_numeric($simenDriver3OriginalCode)==false)){$simenDriver3OriginalCode = 0;}
				if((empty($simenDriver3CommissionCode))||(is_numeric($simenDriver3CommissionCode)==false)){$simenDriver3CommissionCode = 0;}				
				if((empty($simenDriver3Payment))||(is_numeric($simenDriver3Payment)==false)){$simenDriver3Payment = 0;}
				if((empty($simenDriver3Advance))||(is_numeric($simenDriver3Advance)==false)){$simenDriver3Advance = 0;}
				if((empty($simenDriver3Commission))||(is_numeric($simenDriver3Commission)==false)){$simenDriver3Commission = 0;}
				
				$sqlCreateDriverTransaction = "INSERT INTO tbdriverdataentry(driverDataEntry_id, driverDataEntry_noInitial, 
				driverDataEntry_noEnd, driverDataEntry_dataEntryID, 
				driverDataEntry_driverID, driverDataEntry_driverCode, driverDataEntry_driverPayment, driverDataEntry_advance, 
				driverDataEntry_commission, driverDataEntry_driverOriginalCode, driverDataEntry_driverCommissionCode, 
				driverDataEntry_driverCommissionID, driverDataEntry_driverPaid, driverDataEntry_driverAdvanceDate, 
				driverDataEntry_driverCommissionDate) 
				VALUES(NULL, '$simenDriverInitialOrderNo', '$endLabel', '$dataEntryID', '$simenDriver3ID', '$simenDriver3Code', 
				'$simenDriver3Payment', '$simenDriver3Advance', '$simenDriver3Commission', '$simenDriver3OriginalCode', 
				'$simenDriver3CommissionCode', $simenDriverCommission3ID, ";
			
				$sqlCreateDriverTransaction = $sqlCreateDriverTransaction.$sqlCreateDriverTransaction2.$sqlCreateDriverTransaction3.$sqlCreateDriverTransaction4;
			
				$result = mysqli_query($connection, $sqlCreateDriverTransaction) or die("error in insert driver transaction query");
			}
			header ("Location: simenTransaction.php");	
		}	
	}	
	
	//get the MAX id no from tbdataentry
	$sqlMaxID = "SELECT dataEntry_no FROM tbdataentry ORDER BY dataEntry_id DESC LIMIT 0,1";
	$resultMaxID = mysqli_query($connection, $sqlMaxID) or die("error in max ID query");
	$rowLastDataEntryNo = mysqli_fetch_row($resultMaxID);	
	
	//get the suppliers
	$sqlSupplier = "SELECT supplier_id, supplier_name FROM tbsupplier WHERE supplier_status = 1 ORDER BY supplier_name ASC";
	$resultSupplier = mysqli_query($connection, $sqlSupplier) or die("error in supplier query");
	//get the plants
	$sqlPlant = "SELECT plant_id, plant_name FROM tbplant WHERE plant_status = 1 ORDER BY plant_name ASC";
	$resultPlant = mysqli_query($connection, $sqlPlant) or die("error in plant query");
	//get the drivers
	$sqlDriver = "SELECT driver_id, driver_name FROM tbdriver WHERE driver_status = 1 ORDER BY driver_name ASC";
	$resultDriver = mysqli_query($connection, $sqlDriver) or die("error in driver query");
	//get the driver commission name
	$sqlDriverCommission = "SELECT driverCommission_id, driverCommission_name FROM tbdrivercommission 
	WHERE (driverCommission_status = 1) AND (driverCommission_type = 'd') ORDER BY driverCommission_name ASC";
	$resultDriverCommission = mysqli_query($connection, $sqlDriverCommission) or die("error in driver commission query");
	//get the supplier commission name
	$sqlSupplierCommission = "SELECT driverCommission_id, driverCommission_name FROM tbdrivercommission 
	WHERE (driverCommission_status = 1) AND (driverCommission_type = 's') ORDER BY driverCommission_name ASC";
	$resultSupplierCommission = mysqli_query($connection, $sqlSupplierCommission) or die("error in driver commission query");
	
	
	
	
	
?>

<html>
<head>
<!--<link href="styles.css" rel="stylesheet" type="text/css">-->
<title>Online Simen System</title>

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
	background-color: #F5F5F5;
}
input:focus
{
	background-color: cce6ff;
}

input:read-only
{
	background-color: #e6e6e6;
}
</style>
<script src="js/datetimepicker_css.js"></script>
<script src="js/jquery-3.2.1.min.js"></script>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<script>
function CalculateCalculatedWeight() {
	if(document.getElementById("simenActMT") !== null){
		if(isNaN(document.getElementById("simenActMT").value)){
			document.getElementById("simenCalMT").value = "";
			document.getElementById("simenDriverPayment") = "";
			document.getElementById("simenSupplierPayment").value = "";
			document.getElementById("simenSellingPrice").value = "";
			
			document.getElementById("simenSupplierCommission1").value = "";
			document.getElementById("simenSupplierCommission2").value = "";
			document.getElementById("simenSupplierCommission3").value = "";
			
			
			
			document.getElementById("simenDriver1Commission").value = "";
			document.getElementById("simenDriver2Commission").value = "";
			document.getElementById("simenDriver3Commission").value = "";			
			
		}else{
			var actualWeight = document.getElementById("simenActMT").value;
			var calculatedWeight = Math.floor(actualWeight);			
			document.getElementById("simenCalMT").value = calculatedWeight;		
			
			//==================================================================================
			//calculate simenDriver1OriginalCode + simenDriver1CommissionCode = simenDriver1Code			
			
			if(document.getElementById("simenDriver1OriginalCode") !== null){
				if(isNaN(document.getElementById("simenDriver1OriginalCode").value)){
					var driver1OriginalCode = 0;
				}else{
					var driver1OriginalCode = Number(document.getElementById("simenDriver1OriginalCode").value);
				}
			}else{
				var driver1OriginalCode = 0;
			}
			
			if(document.getElementById("simenDriver1CommissionCode") !== null){
				if(isNaN(document.getElementById("simenDriver1CommissionCode").value)){
					var driver1CommissionCode = 0;
				}else{
					var driver1CommissionCode = Number(document.getElementById("simenDriver1CommissionCode").value);
				}
			}else{
				var driver1CommissionCode = 0;
			}
			
			var driver1FinalCode = driver1OriginalCode+driver1CommissionCode;			
			document.getElementById("simenDriver1Code").value = driver1FinalCode;			
			
			//calculate the driver1 payment
			if(document.getElementById("simenDriver1Code") !== null){
				if(isNaN(document.getElementById("simenDriver1Code").value)){
					document.getElementById("simenDriver1Payment").value = "";
				}else{
					//calculation for driver payment
					var driver1Code = document.getElementById("simenDriver1Code").value;
					var driver1Payment = calculatedWeight * driver1Code;
					document.getElementById("simenDriver1Payment").value = driver1Payment;			
				}			
			}else{
				document.getElementById("simenDriver1Payment").value = "";
			}

			//calculate the driver1 commission
			if(document.getElementById("simenDriver1CommissionCode") !== null){
				if(isNaN(document.getElementById("simenDriver1CommissionCode").value)){
					document.getElementById("simenDriver1Commission").value = "";
				}else{
										
				var autoDriver1Commission = document.getElementById('simenDriver1CommissionAuto');
				if(autoDriver1Commission.checked){	
					//calculation for supplier payment
					var driver1CommissionCode = Number(document.getElementById("simenDriver1CommissionCode").value);
					var driver1CommisionPayment = calculatedWeight * driver1CommissionCode;
					document.getElementById("simenDriver1Commission").value = driver1CommisionPayment;
								
				}				
				
				}			
			}else{
				document.getElementById("simenDriver1Commission").value = "";
			}
		//===========================================================================	
		//calculate simenDriver2OriginalCode + simenDriver2CommissionCode = simenDriver2Code

			if(document.getElementById("simenDriver2OriginalCode") !== null){
				if(isNaN(document.getElementById("simenDriver2OriginalCode").value)){
					var driver2OriginalCode = 0;
				}else{
					var driver2OriginalCode = Number(document.getElementById("simenDriver2OriginalCode").value);
				}
			}else{
				var driver2OriginalCode = 0;
			}


			if(document.getElementById("simenDriver2CommissionCode") !== null){
				if(isNaN(document.getElementById("simenDriver2CommissionCode").value)){
					var driver2CommissionCode = 0;
				}else{
					var driver2CommissionCode = Number(document.getElementById("simenDriver2CommissionCode").value);
				}
			}else{
				var driver2CommissionCode = 0;
			}
			
			var driver2FinalCode = driver2OriginalCode+driver2CommissionCode;			
			document.getElementById("simenDriver2Code").value = driver2FinalCode;		
			
			//calculate the driver2 payment
			if(document.getElementById("simenDriver2Code") !== null){
				if(isNaN(document.getElementById("simenDriver2Code").value)){
					document.getElementById("simenDriver2Payment").value = "";
				}else{
					//calculation for driver payment
					var driver2Code = document.getElementById("simenDriver2Code").value;
					var driver2Payment = calculatedWeight * driver2Code;
					document.getElementById("simenDriver2Payment").value = driver2Payment;			
				}			
			}else{
				document.getElementById("simenDriver2Payment").value = "";
			}
			
			//calculate the driver2 commission
			if(document.getElementById("simenDriver2CommissionCode") !== null){
				if(isNaN(document.getElementById("simenDriver2CommissionCode").value)){
					document.getElementById("simenDriver2Commission").value = "";
				}else{					
					var autoDriver2Commission = document.getElementById('simenDriver2CommissionAuto');
					if(autoDriver2Commission.checked){					
						//calculation for supplier payment
						var driver2CommissionCode = Number(document.getElementById("simenDriver2CommissionCode").value);
						var driver2CommisionPayment = calculatedWeight * driver2CommissionCode;
						document.getElementById("simenDriver2Commission").value = driver2CommisionPayment;				
					}			
				
				}			
			}else{
				document.getElementById("simenDriver2Commission").value = "";
			}		
			
		//===========================================================================	
		//calculate simenDriver3OriginalCode + simenDriver3CommissionCode = simenDriver3Code
		
			if(document.getElementById("simenDriver3OriginalCode") !== null){
				if(isNaN(document.getElementById("simenDriver3OriginalCode").value)){
					var driver3OriginalCode = 0;
				}else{
					var driver3OriginalCode = Number(document.getElementById("simenDriver3OriginalCode").value);
				}
			}else{
				var driver3OriginalCode = 0;
			}

			if(document.getElementById("simenDriver3CommissionCode") !== null){
				if(isNaN(document.getElementById("simenDriver3CommissionCode").value)){
					var driver3CommissionCode = 0;
				}else{
					var driver3CommissionCode = Number(document.getElementById("simenDriver3CommissionCode").value);
				}
			}else{
				var driver3CommissionCode = 0;
			}
			
			var driver3FinalCode = driver3OriginalCode+driver3CommissionCode;			
			document.getElementById("simenDriver3Code").value = driver3FinalCode;			
			
			//calculate the driver3 payment
			if(document.getElementById("simenDriver3Code") !== null){
				if(isNaN(document.getElementById("simenDriver3Code").value)){
					document.getElementById("simenDriver3Payment").value = "";
				}else{
					//calculation for driver payment
					var driver3Code = document.getElementById("simenDriver3Code").value;
					var driver3Payment = calculatedWeight * driver3Code;
					document.getElementById("simenDriver3Payment").value = driver3Payment;			
				}			
			}else{
				document.getElementById("simenDriver3Payment").value = "";
			}					
			
			//calculate the driver3 commission
			if(document.getElementById("simenDriver3CommissionCode") !== null){
				if(isNaN(document.getElementById("simenDriver3CommissionCode").value)){
					document.getElementById("simenDriver3Commission").value = "";
				}else{					
					
					var autoDriver3Commission = document.getElementById('simenDriver3CommissionAuto');
					if(autoDriver3Commission.checked){
					
						//calculation for supplier payment
						var driver3CommissionCode = Number(document.getElementById("simenDriver3CommissionCode").value);
						var driver3CommisionPayment = calculatedWeight * driver3CommissionCode;
						document.getElementById("simenDriver3Commission").value = driver3CommisionPayment;			
					}				
				
				}			
			}else{
				document.getElementById("simenDriver3Commission").value = "";
			}			
			
			//calculate simenSupplierOriginalCode + simenSupplierCommissionCode = simenSupplierCode
			if(document.getElementById("simenSupplierOriginalCode") !== null){
				if(isNaN(document.getElementById("simenSupplierOriginalCode").value)){
					var supplierOriginalCode = 0;
				}else{
					var supplierOriginalCode = Number(document.getElementById("simenSupplierOriginalCode").value);
				}
			}else{
				var supplierOriginalCode = 0;
			}
			
			if(document.getElementById("simenSupplierCommissionCode") !== null){
				if(isNaN(document.getElementById("simenSupplierCommissionCode").value)){
					var supplierCommissionCode = 0;
				}else{
					var supplierCommissionCode = Number(document.getElementById("simenSupplierCommissionCode").value);
				}
			}else{
				var supplierCommissionCode = 0;
			}
			
			var supplierFinalCode = supplierOriginalCode+supplierCommissionCode;			
			document.getElementById("simenSupplierCode").value = supplierFinalCode;			
			
			//calculate the supplier payment			
			if(document.getElementById("simenSupplierCode") !== null){
				if(isNaN(document.getElementById("simenSupplierCode").value)){
					document.getElementById("simenSupplierPayment").value = "";
				}else{
					//calculation for supplier payment
					var supplierCode = document.getElementById("simenSupplierCode").value;
					var supplierPayment = calculatedWeight * supplierCode;
					document.getElementById("simenSupplierPayment").value = supplierPayment;			
				}			
			}else{
				document.getElementById("simenSupplierPayment").value = "";
			}			
			
			
			
			
			
			
			//calculate the supplier commission 1
			var autoSupplierCommission1 = document.getElementById('supplierCommisionAuto1');
			if(autoSupplierCommission1.checked){
				if(document.getElementById("simenSupplierCommissionCode1") !== null){
					if(isNaN(document.getElementById("simenSupplierCommissionCode1").value)){
						document.getElementById("simenSupplierCommission1").value = "";
					}else{					
											
						//calculation for supplier payment
						var supplierCommissionCode1 = Number(document.getElementById("simenSupplierCommissionCode1").value);
						var supplierCommisionPayment = calculatedWeight * supplierCommissionCode1;
						document.getElementById("simenSupplierCommission1").value = supplierCommisionPayment;
						
					}			
				}else{
					document.getElementById("simenSupplierCommission1").value = "";
				}			
			}			
			
			//calculate the supplier commission 2
			var autoSupplierCommission2 = document.getElementById('supplierCommisionAuto2');
			if(autoSupplierCommission2.checked){
				if(document.getElementById("simenSupplierCommissionCode2") !== null){
					if(isNaN(document.getElementById("simenSupplierCommissionCode2").value)){
						document.getElementById("simenSupplierCommission2").value = "";
					}else{					
											
						//calculation for supplier payment
						var supplierCommissionCode2 = Number(document.getElementById("simenSupplierCommissionCode2").value);
						var supplierCommisionPayment2 = calculatedWeight * supplierCommissionCode2;
						document.getElementById("simenSupplierCommission2").value = supplierCommisionPayment2;
						
					}			
				}else{
					document.getElementById("simenSupplierCommission2").value = "";
				}			
			}			
			
			//calculate the supplier commission 3
			var autoSupplierCommission3 = document.getElementById('supplierCommisionAuto3');
			if(autoSupplierCommission3.checked){
				if(document.getElementById("simenSupplierCommissionCode3") !== null){
					if(isNaN(document.getElementById("simenSupplierCommissionCode3").value)){
						document.getElementById("simenSupplierCommission3").value = "";
					}else{					
											
						//calculation for supplier payment
						var supplierCommissionCode3 = Number(document.getElementById("simenSupplierCommissionCode3").value);
						var supplierCommisionPayment3 = calculatedWeight * supplierCommissionCode3;
						document.getElementById("simenSupplierCommission3").value = supplierCommisionPayment3;
						
					}			
				}else{
					document.getElementById("simenSupplierCommission3").value = "";
				}			
			}
			
			
			
			
			
			
			
			
			
			
			//calculate the Selling price
			if(document.getElementById("simenPlantCode") !== null){
				if(isNaN(document.getElementById("simenPlantCode").value)){
					document.getElementById("simenSellingPrice").value = "";
				}else{
					//calculation for selling price
					var plantCode = document.getElementById("simenPlantCode").value;
					var plantPayment = actualWeight * plantCode;
					document.getElementById("simenSellingPrice").value = plantPayment;			
				}			
			}else{
				document.getElementById("simenSellingPrice").value = "";
			}		
		
		}		
	}else{
		document.getElementById("simenCalMT").value = "";
		document.getElementById("simenDriverPayment").value = "";
		document.getElementById("simenSupplierPayment").value = "";
		document.getElementById("simenSellingPrice").value = "";		
		
		document.getElementById("simenDriver1Commission").value = "";
		document.getElementById("simenDriver2Commission").value = "";
		document.getElementById("simenDriver3Commission").value = "";
		document.getElementById("simenSupplierCommission1").value = "";
		document.getElementById("simenSupplierCommission2").value = "";
		document.getElementById("simenSupplierCommission3").value = "";
		
	}	
}

function CheckAndSubmit(){	
	
	var itemName = document.getElementById("simenOrderNo");
	if(itemName.value.length==0){
		alert("Must enter Data Entry No!");
		simenOrderNo.focus();
		return false;
	}	
	
	var supplierName = document.getElementById("simenSupplierID");
	if(supplierName.options[supplierName.selectedIndex].value==0){
		alert("Must select Supplier!");
		simenSupplierID.focus();
		return false;
	}
	
	var plantName = document.getElementById("simenPlantID");
	if(plantName.options[plantName.selectedIndex].value==0){
		alert("Must select Delivery Plant!");
		simenPlantID.focus();
		return false;		
	}
	
	var r = confirm("Do you want to Create Simen Transaction?");
	if(r==false){
		return false;
	}
}

function ClearDate(){
	document.getElementById("demo4").value = "";
}

function ClearDate1(){
	document.getElementById("demo3").value = "";
}

function ClearDate2(){
	document.getElementById("demo5").value = "";
}

function ClearDate3(){
	document.getElementById("demo6").value = "";
}
function ClearDate4(){
	document.getElementById("demo7").value = "";
}
function ClearDate5(){
	document.getElementById("demo8").value = "";
}
function ClearDate6(){
	document.getElementById("demo9").value = "";
}

function ClearDate7(){
	document.getElementById("demo10").value = "";
}

function ClearDate8(){
	document.getElementById("demo11").value = "";
}

function ClearDate9(){
	document.getElementById("demo12").value = "";
}

function ClearDate13(){
	document.getElementById("demo13").value = "";
}

function ClearDate14(){
	document.getElementById("demo14").value = "";
}

function ClearDate15(){
	document.getElementById("demo15").value = "";
}

function ClearDate16(){
	document.getElementById("demo16").value = "";
}


function CheckDataEntryNo(){		
		var data = "simenOrderNo="+$("#simenOrderNo").val();		
		
		$.ajax({
			type : 'POST',
			url : 'checkExistingDataEntry.php',
			data : data,
			dataType : 'json',			
			success : function(r)
			{
				if(r=="1"){
					//Exists
                       $("#info").html("<img border='0' src='images/Delete.ico'>");
					   document.getElementById("Submit").disabled = true;
				}else{
					$("#info").html("<img border='0' src='images/Yes.ico'>");
					document.getElementById("Submit").disabled = false;						
				}				
				document.getElementById("simenDriverOrderNo").value = document.getElementById("simenOrderNo").value;				
			
			}
			
			}	
		)	
	}

function DisableSubmitButton(){		
	document.getElementById("Submit").disabled = true;		
}

function GetSupplierCode(){
	var e = document.getElementById("simenSupplierID");
	var supplierID = e.options[e.selectedIndex].value;	
	var data = 	"supplierID="+supplierID;
	
	$.ajax({		
		type : 'POST',
		url : 'checkSupplierCode.php',
		data : data,
		dataType : 'text', //return value type
		success : function(n)
		{			
			document.getElementById("SupplierCodeInfo").innerHTML = n;
		}
	}	
	
	)	
}

function GetOwnerNameList(){
	var e = document.getElementById("simenSupplierID");
	var supplierID = e.options[e.selectedIndex].value;	
	var data = 	"supplierID="+supplierID;
	
	$.ajax({
		type : 'POST',
		url : 'getSupplierOwner.php',
		data : data,
		dataType : 'text', //return value type
		success : function(n)
		{
			console.log("test");
			document.getElementById("owner").innerHTML = n;
		}	
	}
	)	
}

function TwoFunctions(){	
	GetSupplierCode();
	GetOwnerNameList();
}

function GetPlantCode(){
	var e = document.getElementById("simenPlantID");
	var plantID = e.options[e.selectedIndex].value;	
	var data = 	"plantID="+plantID;
	
	$.ajax({		
		type : 'POST',
		url : 'checkPlantCode.php',
		data : data,
		dataType : 'text', //return value type
		success : function(n)
		{			
			document.getElementById("PlantCodeInfo").innerHTML = n;
		}
	}	
	
	)	
}

function GetDriverCode(s){
	var w = s.id; //select name
	var e = s[s.selectedIndex].id;
	var driverID = s[s.selectedIndex].value;	
	var data = 	"driverID="+driverID;
	
	if(w == 'simenDriver1ID'){		
		var driver2Value = document.getElementById("simenDriver2ID").value;
		var driver3Value = document.getElementById("simenDriver3ID").value;
		
		if(((driverID==driver2Value)||(driverID==driver3Value))&&(driverID>0)){			
			alert("Driver already selected!");
			document.getElementById("simenDriver1ID").value = 0;
			document.getElementById("simenDriver1ID").text = "";
			document.getElementById("Driver1Info").innerHTML = "";
			simenDriver1ID.focus();
			return
		}
	
	}else if(w == 'simenDriver2ID'){		
		var driver1Value = document.getElementById("simenDriver1ID").value;
		var driver3Value = document.getElementById("simenDriver3ID").value;
		
		if(((driverID==driver1Value)||(driverID==driver3Value))&&(driverID>0)){			
			alert("Driver already selected!");
			document.getElementById("simenDriver2ID").value = 0;
			document.getElementById("simenDriver2ID").text = "";
			document.getElementById("Driver2Info").innerHTML = "";
			simenDriver2ID.focus();
			return
		}	
	}else if(w == 'simenDriver3ID'){
		var driver1Value = document.getElementById("simenDriver1ID").value;
		var driver2Value = document.getElementById("simenDriver2ID").value;
		
		if(((driverID==driver1Value)||(driverID==driver2Value))&&(driverID>0)){			
			alert("Driver already selected!");
			document.getElementById("simenDriver3ID").value = 0;
			document.getElementById("simenDriver3ID").text = "";
			document.getElementById("Driver3Info").innerHTML = "";
			simenDriver3ID.focus();
			return
		}	
		
	}
	
				$.ajax({		
					type : 'POST',
					url : 'checkDriverCode.php',
					data : data,
					dataType : 'text', //return value type
					success : function(n)
					{			
						switch(w){				
							
							case 'simenDriver1ID':
								document.getElementById("Driver1Info").innerHTML = n;
								break;
							case 'simenDriver2ID':
								document.getElementById("Driver2Info").innerHTML = n;
								break;
							case 'simenDriver3ID':
								document.getElementById("Driver3Info").innerHTML = n;
								break;
						}		
					}
				}	
				
				)

}
</script>
</head>
<body onload="DisableSubmitButton()">
<div class="navbar">
	<?php include 'menuPHP.php';?>
</div>
<center>
<table width="80%">	
	<tr height="40">		
		<td align="center"><font size="5" color="#DE2F43" face="arial"></font></td>		
	</tr>		
</table>
</center>

<center>
<table border="0" cellpadding="0" width="800"><tr height="30"><td>&nbsp;</td></tr></table>
<table width="600" border="0" cellpadding="0" align="center"><tr height="40"><td align="left"><b><font size="5" color="3e66a8">Simen Transaction</font></b></td></tr></table>

<form action="dataEntry.php" id="createDataEntryForm" method="post" onsubmit="return CheckAndSubmit()">

<table width="80%" cellpadding="0" border="1" class="mystyle">
<tr bgcolor="a4bade"><td colspan="4" align="left"><strong>Create New Simen Transaction</strong></td></tr>
<tr class="notfirst"><td>Order No</td><td colspan="3"><input type="text" name="simenInitialOrderNo" maxLength="1" size="1" value="A" readonly>&nbsp;<input type="text" name="simenOrderNo" id="simenOrderNo" maxLength="10" size="15" value="<?php echo $rowLastDataEntryNo[0];?>" onchange="CheckDataEntryNo()"><span id="info"><img border='0' src='images/Terminate.png'></span></td></tr>
<tr class="notfirst"><td>Date</td><td colspan="3"><input id="demo2" type="text" name="simenDate" size="10" value="<?php echo date('d/m/Y');?>">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo2','ddMMyyyy')" style="cursor:pointer"/></td></tr>
<tr bgcolor="a4bade"><td colspan="4"><strong>Supplier Info</strong></td></tr>
<tr class="notfirst">
<td>Supplier Name</td>
<td colspan="3">
<select name="simenSupplierID" id="simenSupplierID" onchange="TwoFunctions()">
<?php
	
	if(mysqli_num_rows($resultSupplier) > 0){
		echo "<option value=0></option>";
		while($rowSupplierList=mysqli_fetch_array($resultSupplier)){
			echo "<option value=$rowSupplierList[0]>$rowSupplierList[1]</option>";
		}
	}
?>
</select>
&nbsp;&nbsp;
Owner
&nbsp;&nbsp;
<span id="owner">
<select name="simenSupplierOwnerID" id="simenSupplierOwnerID">
<option value=0>SELECT</option>
</select>
</span>
</td>
</tr>

<tr class="notfirst"><td>Supplier Code</td><td colspan="3"><input type="text" name="simenSupplierOriginalCode" id="simenSupplierOriginalCode" maxLength="10" size="3" onblur="CalculateCalculatedWeight()">&nbsp;<input type="text" name="simenSupplierCommissionCode" id="simenSupplierCommissionCode" maxLength="10" size="3" onblur="CalculateCalculatedWeight()">&nbsp;<input type="text" name="simenSupplierCode" id="simenSupplierCode" maxLength="10" size="3" readonly><span id="SupplierCodeInfo"></span></td></tr>
<tr class="notfirst"><td>Supplier Payment</td><td colspan="3"><input type="text" name="simenSupplierPayment" id="simenSupplierPayment" maxLength="10" size="15" readonly></td></tr>
<tr class="notfirst"><td>Supplier Paid</td><td colspan="3"><input id="demo4" type="text" name="simenSupplierDate" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo4','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear1" type="button" value="x" onclick="ClearDate()"></td></tr>
<tr class="notfirst"><td>Supplier Advance</td><td colspan="3">
<input type="text" name="simenSupplierAdvance" id="simenSupplierAdvance" maxLength="10" size="10" onblur="CalculateCalculatedWeight()">&nbsp;&nbsp;
<input id="demo16" type="text" name="simenSupplierAdvanceDate" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo16','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear16" type="button" value="x" onclick="ClearDate16()">
</td></tr>
<tr class="notfirst"><td>Supplier Commision 1</td><td colspan="3">

<select name="simenSupplierCommissionID1" id="simenSupplierCommissionID1">
<?php
	//reuse the recordset
	mysqli_data_seek($resultSupplierCommission, 0);
	if(mysqli_num_rows($resultSupplierCommission) > 0){
		echo "<option value=0></option>";
		while($rowSupplierCommissionList=mysqli_fetch_array($resultSupplierCommission)){
			echo "<option value=$rowSupplierCommissionList[0]>$rowSupplierCommissionList[1]</option>";
		}
	}
?>
</select>
&nbsp;&nbsp;Code
<input type="text" name="simenSupplierCommissionCode1" id="simenSupplierCommissionCode1" maxLength="5" size="5" onblur="CalculateCalculatedWeight()">
&nbsp;&nbsp;
<input type="text" name="simenSupplierCommission1" id="simenSupplierCommission1" maxLength="10" size="10"><input type="checkbox" name="supplierCommisionAuto1" id="supplierCommisionAuto1" value="1" checked onclick="CalculateCalculatedWeight()">Auto
&nbsp;&nbsp;


<input id="demo13" type="text" name="simenSupplierCommissionDate1" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo13','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear13" type="button" value="x" onclick="ClearDate13()">

</td></tr>





<tr class="notfirst"><td>Supplier Commision 2</td><td colspan="3">

<select name="simenSupplierCommissionID2" id="simenSupplierCommissionID2">
<?php
	mysqli_data_seek($resultSupplierCommission, 0);
	if(mysqli_num_rows($resultSupplierCommission) > 0){
		echo "<option value=0></option>";
		while($rowSupplierCommissionList=mysqli_fetch_array($resultSupplierCommission)){
			echo "<option value=$rowSupplierCommissionList[0]>$rowSupplierCommissionList[1]</option>";
		}
	}
?>
</select>
&nbsp;&nbsp;Code
<input type="text" name="simenSupplierCommissionCode2" id="simenSupplierCommissionCode2" maxLength="5" size="5" onblur="CalculateCalculatedWeight()">

&nbsp;&nbsp;

<input type="text" name="simenSupplierCommission2" id="simenSupplierCommission2" maxLength="10" size="10"><input type="checkbox" name="supplierCommisionAuto2" id="supplierCommisionAuto2" value="1" checked onclick="CalculateCalculatedWeight()">Auto
&nbsp;&nbsp;

<input id="demo14" type="text" name="simenSupplierCommissionDate2" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo14','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear14" type="button" value="x" onclick="ClearDate14()">

</td></tr>





<tr class="notfirst"><td>Supplier Commision 3</td><td colspan="3">

<select name="simenSupplierCommissionID3" id="simenSupplierCommissionID3">
<?php
	mysqli_data_seek($resultSupplierCommission, 0);
	if(mysqli_num_rows($resultSupplierCommission) > 0){
		echo "<option value=0></option>";
		while($rowSupplierCommissionList=mysqli_fetch_array($resultSupplierCommission)){
			echo "<option value=$rowSupplierCommissionList[0]>$rowSupplierCommissionList[1]</option>";
		}
	}
?>
</select>

&nbsp;&nbsp;Code
<input type="text" name="simenSupplierCommissionCode3" id="simenSupplierCommissionCode3" maxLength="5" size="5" onblur="CalculateCalculatedWeight()">

&nbsp;&nbsp;

<input type="text" name="simenSupplierCommission3" id="simenSupplierCommission3" maxLength="10" size="10"><input type="checkbox" name="supplierCommisionAuto3" id="supplierCommisionAuto3" value="1" checked onclick="CalculateCalculatedWeight()">Auto
&nbsp;&nbsp;

<input id="demo15" type="text" name="simenSupplierCommissionDate3" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo15','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear15" type="button" value="x" onclick="ClearDate15()">

</td></tr>



















<tr bgcolor="a4bade"><td colspan="4"><strong>Weight Info</strong></td></tr>
<tr bgcolor="ffcccc" class="notfirst"><td>Act M/T</td><td colspan="3"><input type="text" name="simenActMT" id="simenActMT" maxLength="10" size="15" onblur="CalculateCalculatedWeight()"></td></tr>
<tr class="notfirst"><td>Cal M/T</td><td colspan="3"><input type="text" name="simenCalMT" id="simenCalMT" maxLength="10" size="15" readonly></td></tr>
<!--<tr><td>Plant Receive</td><td colspan="3"><input type="text" name="simenPlantReceive" id="simenPlantReceive" maxLength="10" size="15"></td></tr>-->
<tr bgcolor="a4bade"><td colspan="4"><strong>Plant Info</strong></td></tr>
<tr class="notfirst">
<td>Plant</td>
<td colspan="3">
<select name="simenPlantID" id="simenPlantID" onchange="GetPlantCode()">
<?php
	
	if(mysqli_num_rows($resultPlant) > 0){
		echo "<option value=0></option>";
		while($rowPlantList=mysqli_fetch_array($resultPlant)){
			echo "<option value=$rowPlantList[0]>$rowPlantList[1]</option>";
		}
	}
?>
</select>
</td>
</tr>
<tr class="notfirst"><td>Plant Code</td><td colspan="3"><input type="text" name="simenPlantCode" id="simenPlantCode" maxLength="10" size="15" onblur="CalculateCalculatedWeight()"><span id="PlantCodeInfo"></span></td></tr>
<tr class="notfirst"><td>Selling Price</td><td colspan="3"><input type="text" name="simenSellingPrice" id="simenSellingPrice" maxLength="10" size="15" readonly></td></tr>
<tr bgcolor="a4bade"><td colspan="4"><strong>Driver Info</strong></td></tr>
<tr><td>Driver Order No</td><td colspan="3"><input type="text" name="simenDriverInitialOrderNo" maxLength="1" size="1" value="D" readonly>&nbsp;<input type="text" name="simenDriverOrderNo" id="simenDriverOrderNo" maxLength="10" size="15" value="<?php echo $rowLastDataEntryNo[0];?>" readonly></td></tr>
<tr class="notfirst">
<td>Driver Name</td>
<td>
<select name="simenDriver1ID" id="simenDriver1ID" onchange="GetDriverCode(this)">
<?php
	//reuse the recordset
	mysqli_data_seek($resultDriver, 0);
	if(mysqli_num_rows($resultDriver) > 0){
		echo "<option value=0></option>";
		while($rowDriverList=mysqli_fetch_array($resultDriver)){
			echo "<option value=$rowDriverList[0]>$rowDriverList[1]</option>";
		}
	}
?>
</select>
</td>
<td>
<select name="simenDriver2ID" id="simenDriver2ID" onchange="GetDriverCode(this)">
<?php
	//reuse the recordset
	mysqli_data_seek($resultDriver, 0);
	if(mysqli_num_rows($resultDriver) > 0){
		echo "<option value=0></option>";
		while($rowDriverList=mysqli_fetch_array($resultDriver)){
			echo "<option value=$rowDriverList[0]>$rowDriverList[1]</option>";
		}
	}
?>
</select>
</td>
<td>
<select name="simenDriver3ID" id="simenDriver3ID" onchange="GetDriverCode(this)">
<?php
	//reuse the recordset
	mysqli_data_seek($resultDriver, 0);
	if(mysqli_num_rows($resultDriver) > 0){
		echo "<option value=0></option>";
		while($rowDriverList=mysqli_fetch_array($resultDriver)){
			echo "<option value=$rowDriverList[0]>$rowDriverList[1]</option>";
		}
	}
?>
</select>
</td>
</tr>
<tr class="notfirst">
<td>Driver Code</td>
<td><input type="text" name="simenDriver1OriginalCode" id="simenDriver1OriginalCode" maxLength="10" size="3" onblur="CalculateCalculatedWeight()"><input type="text" name="simenDriver1CommissionCode" id="simenDriver1CommissionCode" maxLength="10" size="3" onblur="CalculateCalculatedWeight()"><input type="text" name="simenDriver1Code" id="simenDriver1Code" maxLength="10" size="3" readonly><span id="Driver1Info"></span></td>
<td><input type="text" name="simenDriver2OriginalCode" id="simenDriver2OriginalCode" maxLength="10" size="3" onblur="CalculateCalculatedWeight()"><input type="text" name="simenDriver2CommissionCode" id="simenDriver2CommissionCode" maxLength="10" size="3" onblur="CalculateCalculatedWeight()"><input type="text" name="simenDriver2Code" id="simenDriver2Code" maxLength="10" size="3" readonly><span id="Driver2Info"></span></td>
<td><input type="text" name="simenDriver3OriginalCode" id="simenDriver3OriginalCode" maxLength="10" size="3" onblur="CalculateCalculatedWeight()"><input type="text" name="simenDriver3CommissionCode" id="simenDriver3CommissionCode" maxLength="10" size="3" onblur="CalculateCalculatedWeight()"><input type="text" name="simenDriver3Code" id="simenDriver3Code" maxLength="10" size="3" readonly><span id="Driver3Info"></span></td>
</tr>
<tr class="notfirst">
<td>Driver Payment</td>
<td><input type="text" name="simenDriver1Payment" id="simenDriver1Payment" maxLength="10" size="10" readonly></td>
<td><input type="text" name="simenDriver2Payment" id="simenDriver2Payment" maxLength="10" size="10" readonly></td>
<td><input type="text" name="simenDriver3Payment" id="simenDriver3Payment" maxLength="10" size="10" readonly></td>
</tr>

<tr class="notfirst">
<td>Driver Paid</td>
<td><input id="demo3" type="text" name="simenDriver1Date" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo3','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear2" type="button" value="x" onclick="ClearDate1()"></td>
<td><input id="demo5" type="text" name="simenDriver2Date" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo5','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear3" type="button" value="x" onclick="ClearDate2()"></td>
<td><input id="demo6" type="text" name="simenDriver3Date" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo6','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear4" type="button" value="x" onclick="ClearDate3()"></td>
</tr>
<tr class="notfirst">
<td>Driver Advance</td>
<td><input type="text" name="simenDriver1Advance" id="simenDriver1Advance" maxLength="10" size="5" onblur="CalculateCalculatedWeight()"></td>
<td><input type="text" name="simenDriver2Advance" id="simenDriver2Advance" maxLength="10" size="5" onblur="CalculateCalculatedWeight()"></td>
<td><input type="text" name="simenDriver3Advance" id="simenDriver3Advance" maxLength="10" size="5" onblur="CalculateCalculatedWeight()"></td>
</tr>
<tr class="notfirst">
<td>Advance Date</td>
<td><input id="demo10" type="text" name="simenDriver1AdvanceDate" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo10','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear5" type="button" value="x" onclick="ClearDate7()"></td>
<td><input id="demo11" type="text" name="simenDriver2AdvanceDate" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo11','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear6" type="button" value="x" onclick="ClearDate8()"></td>
<td><input id="demo12" type="text" name="simenDriver3AdvanceDate" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo12','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear7" type="button" value="x" onclick="ClearDate9()"></td>
</tr>




<tr class="notfirst">
<td>Driver Commission</td>
<td><input type="text" name="simenDriver1Commission" id="simenDriver1Commission" maxLength="10" size="5"><input type="checkbox" name="simenDriver1CommissionAuto" id="simenDriver1CommissionAuto" value="1" checked onclick="CalculateCalculatedWeight()">Auto</td>
<td><input type="text" name="simenDriver2Commission" id="simenDriver2Commission" maxLength="10" size="5"><input type="checkbox" name="simenDriver2CommissionAuto" id="simenDriver2CommissionAuto" value="1" checked onclick="CalculateCalculatedWeight()">Auto</td>
<td><input type="text" name="simenDriver3Commission" id="simenDriver3Commission" maxLength="10" size="5"><input type="checkbox" name="simenDriver3CommissionAuto" id="simenDriver3CommissionAuto" value="1" checked onclick="CalculateCalculatedWeight()">Auto</td>
</tr>
<tr class="notfirst">
<td>Commission Person</td>
<td>
<select name="simenDriverCommission1ID" id="simenDriverCommission1ID">
<?php
	//reuse the recordset
	mysqli_data_seek($resultDriverCommission, 0);
	if(mysqli_num_rows($resultDriverCommission) > 0){
		echo "<option value=0></option>";
		while($rowDriverCommissionList=mysqli_fetch_array($resultDriverCommission)){
			echo "<option value=$rowDriverCommissionList[0]>$rowDriverCommissionList[1]</option>";
		}
	}
?>
</select>
</td>
<td>
<select name="simenDriverCommission2ID" id="simenDriverCommission2ID">
<?php
	//reuse the recordset
	mysqli_data_seek($resultDriverCommission, 0);
	if(mysqli_num_rows($resultDriverCommission) > 0){
		echo "<option value=0></option>";
		while($rowDriverCommissionList=mysqli_fetch_array($resultDriverCommission)){
			echo "<option value=$rowDriverCommissionList[0]>$rowDriverCommissionList[1]</option>";
		}
	}
?>
</select>
</td>
<td>
<select name="simenDriverCommission3ID" id="simenDriverCommission3ID">
<?php
	//reuse the recordset
	mysqli_data_seek($resultDriverCommission, 0);
	if(mysqli_num_rows($resultDriverCommission) > 0){
		echo "<option value=0></option>";
		while($rowDriverCommissionList=mysqli_fetch_array($resultDriverCommission)){
			echo "<option value=$rowDriverCommissionList[0]>$rowDriverCommissionList[1]</option>";
		}
	}
?>
</select>
</td>
</tr>
<tr class="notfirst">
<td>Commission Date</td>
<td><input id="demo7" type="text" name="simenDriverCommission1Date" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo7','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear8" type="button" value="x" onclick="ClearDate4()"></td>
<td><input id="demo8" type="text" name="simenDriverCommission2Date" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo8','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear9" type="button" value="x" onclick="ClearDate5()"></td>
<td><input id="demo9" type="text" name="simenDriverCommission3Date" size="10" value="">&nbsp;<img src="images2/cal.gif" onclick="javascript:NewCssCal('demo9','ddMMyyyy')" style="cursor:pointer"/>&nbsp;&nbsp;&nbsp;<input id="clear10" type="button" value="x" onclick="ClearDate6()"></td>
</tr>




<tr bgcolor="a4bade"><td colspan="4"><strong>Others Info</strong></td></tr>

<tr class="notfirst"><td>DO No</td><td colspan="3"><input type="text" name="simenDOno" id="simenDOno" maxLength="10" size="15"></td></tr>
<tr><td colspan="4" align="right" ><input type="submit" name="Submit" id="Submit" value="Create Simen Transaction"></td></tr>

</table>
</form>
</center>
</body>

</html>