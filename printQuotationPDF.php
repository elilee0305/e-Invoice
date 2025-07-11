<?php

	// Include the TCPDF library
	require_once('TCPDF-main/tcpdf.php');
	
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");	

	//get the company name
	$sqlCompanyName = "SELECT company_name, company_address1, company_address2, company_telFax, company_logo, company_no FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$rowCompanyName = mysqli_fetch_row($resultCompanyName);

	if(isset($_POST['idQuotation'])){		
		$quotationID = $_POST['idQuotation'];
		$customerID = $_POST['idCustomer'];
	}
	
	
	//get the customer info	
	$sqlCustomerInfo = "SELECT customer_name, customer_tel, customer_address FROM tbcustomer WHERE customer_id = '$customerID'";	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer query");
	$resultCustomerInfo2 = mysqli_fetch_row($resultCustomerInfo);
	
	//get the quotation info	
	$sqlQuotationInfo = "SELECT quotation_no, quotation_date, quotation_title, quotation_from, quotation_terms, 
	quotation_attention, quotation_email, quotation_subTotal, quotation_discountTotal,
	quotation_totalAfterDiscount, quotation_taxTotal, quotation_grandTotal, quotation_roundAmount, quotation_grandTotalRound, 
	quotation_content FROM tbquotation WHERE quotation_id = '$quotationID' ORDER BY quotation_date ASC, quotation_id ASC";
	
	
	$resultQuotationInfo = mysqli_query($connection, $sqlQuotationInfo) or die("error in quotation query");
	$rowQuotationInfo = mysqli_fetch_row($resultQuotationInfo);	
	
	//get the quotation details
	$sqlQuotationDetailInfo = "SELECT quotationDetail_no1, quotationDetail_no2, quotationDetail_no3, quotationDetail_no4, quotationDetail_bold, 
	quotationDetail_no5, quotationDetail_discountAmount, quotationDetail_rowGrandTotal FROM tbquotationdetail 
	WHERE quotationDetail_quotationID = '$quotationID' ORDER BY quotationDetail_sortID ASC";
	
	
	$resultQuotationDetailInfo = mysqli_query($connection, $sqlQuotationDetailInfo) or die("error in quotation detail query");
	
	//Function to convert amount to wordwrap
	function convertNumber($number)
{
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer{0} == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer{0} == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer{0} == "0")
    {
        $output .= "";
    }
    else
    {
        $integer = str_pad($integer, 36, "0", STR_PAD_LEFT);
        $group   = rtrim(chunk_split($integer, 3, " "), " ");
        $groups  = explode(" ", $group);

        $groups2 = array();
        foreach ($groups as $g)
        {
            $groups2[] = convertThreeDigit($g{0}, $g{1}, $g{2});
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11]{0} == '0'
                            ? " "
                            : " "
                    );
            }
        }

        $output = rtrim($output, ", ");
		$output = "Ringgit ".$output;
    }

    if ($fraction > 0)
    {
        if($output == ""){
			$output .= "Cents";
		}else{
			$output .= " and Cents";
        }		
		
            $output .= " " . convertTwoDigit($fraction{0},$fraction{1});
    }

    return $output. " Only";
}

function convertGroup($index)
{
    switch ($index)
    {
        case 11:
            return " Decillion";
        case 10:
            return " Nonillion";
        case 9:
            return " Octillion";
        case 8:
            return " Septillion";
        case 7:
            return " Sextillion";
        case 6:
            return " Quintrillion";
        case 5:
            return " Quadrillion";
        case 4:
            return " Trillion";
        case 3:
            return " Billion";
        case 2:
            return " Million";
        case 1:
            return " Thousand";
        case 0:
            return "";
    }
}

function convertThreeDigit($digit1, $digit2, $digit3)
{
    $buffer = "";

    if ($digit1 == "0" && $digit2 == "0" && $digit3 == "0")
    {
        return "";
    }

    if ($digit1 != "0")
    {
        $buffer .= convertDigit($digit1) . " Hundred";
        if ($digit2 != "0" || $digit3 != "0")
        {
            $buffer .= " ";
        }
    }

    if ($digit2 != "0")
    {
        $buffer .= convertTwoDigit($digit2, $digit3);
    }
    else if ($digit3 != "0")
    {
        $buffer .= convertDigit($digit3);
    }

    return $buffer;
}

function convertTwoDigit($digit1, $digit2){

    if ($digit2 == "0"){
        switch ($digit1)
        {
            case "1":
                return "Ten";
            case "2":
                return "Twenty";
            case "3":
                return "Thirty";
            case "4":
                return "Forty";
            case "5":
                return "Fifty";
            case "6":
                return "Sixty";
            case "7":
                return "Seventy";
            case "8":
                return "Eighty";
            case "9":
                return "Ninety";
        }
    } else if ($digit1 == "1"){
        switch ($digit2)
        {
            case "1":
                return "Eleven";
            case "2":
                return "Twelve";
            case "3":
                return "Thirteen";
            case "4":
                return "Fourteen";
            case "5":
                return "Fifteen";
            case "6":
                return "Sixteen";
            case "7":
                return "Seventeen";
            case "8":
                return "Eighteen";
            case "9":
                return "Nineteen";
        }
    } else if($digit1 == "0"){
		switch($digit2){
			case "0":
				return "Zero";
			case "1":
				return "One";
			case "2":
				return "Two";
			case "3":
				return "Three";
			case "4":
				return "Four";
			case "5":
				return "Five";
			case "6":
				return "Six";
			case "7":
				return "Seven";
			case "8":
				return "Eight";
			case "9":
				return "Nine";
		}
		
	}else  {
        $temp = convertDigit($digit2);
        switch ($digit1)
        {
            case "2":
                return "Twenty-$temp";
            case "3":
                return "Thirty-$temp";
            case "4":
                return "Forty-$temp";
            case "5":
                return "Fifty-$temp";
            case "6":
                return "Sixty-$temp";
            case "7":
                return "Seventy-$temp";
            case "8":
                return "Eighty-$temp";
            case "9":
                return "Ninety-$temp";
        }
    }
}


function convertDigit($digit)
{
    switch ($digit)
    {
        case "0":
            return "Zero";
        case "1":
            return "One";
        case "2":
            return "Two";
        case "3":
            return "Three";
        case "4":
            return "Four";
        case "5":
            return "Five";
        case "6":
            return "Six";
        case "7":
            return "Seven";
        case "8":
            return "Eight";
        case "9":
            return "Nine";
    }
}
	
	$pdf = new TCPDF('P', 'pt', 'A4', true, 'UTF-8');
	
	// Set document information
	$pdf->SetCreator('Mel Systems');
	$pdf->SetAuthor('Mel Systems');
	$pdf->SetTitle('Quotation PDF');
	$pdf->setImageScale(1.66); //must set this value, if not image shows too large, blur 1.66
	$pdf->setPrintHeader(false);
	$pdf->setPrintFooter(false);
	
	
	// Set equal margins for all sides in pixels
	$marginPoints = 15 * 0.75; //15PIXELS
	$marginBottom = 10 * 0.25;
	$pdf->SetMargins($marginPoints, $marginPoints, $marginPoints, true);
	
	$pdf->SetAutoPageBreak(true, $marginBottom);

	// Add a page
	$pdf->AddPage();
	
	$logoImage = "";
	if($rowCompanyName[4] !== ""){
		$logoLocation = "logo/" . $rowCompanyName[4];
		$logoImage = "<img src=\"" . $logoLocation . "\">";
	}
	
	// Assuming you have the HTML content stored in a variable called $htmlPage
	$htmlPage = "		
		<html>		
		<head>
		<title>Imes Online System</title>
		
	</head>
	<body style=\"font-size: 9pt\">
			
		<table width=\"570pt\" style=\"border-collapse: collapse;\">
			<tr>
				<td style=\"width: 112.5pt; border: none;\">{$logoImage}</td>
				<td rowspan=\"4\" style=\"width: 457.5pt; border: none;  top: 8.25pt; left: 15pt;\">
				<span style=\"font-size: 12pt; font-weight: bold;\">{$rowCompanyName[0]}</span>&nbsp;&nbsp;&nbsp;
				<span style=\"font-size: 7pt; font-weight: bold;\">Com No:&nbsp;{$rowCompanyName[5]}</span><br>
				<span style=\"font-size: 9pt; font-weight: bold;\">{$rowCompanyName[1]}</span><br>
				<span style=\"font-size: 9pt; font-weight: bold;\">{$rowCompanyName[2]}</span><br>
				<span style=\"font-size: 9pt; font-weight: bold;\">{$rowCompanyName[3]}</span>
				</td>
			</tr>
		</table>
		
		<div style=\"width: 570pt; height: 5pt;\">	
			<hr style=\"margin-top: 1pt; margin-bottom: 1pt;\">
		</div>
		
		<table width=\"570pt\" style=\"border-collapse: collapse; page-break-inside: avoid;\">
		<tr><td colspan=\"5\" align=\"right\" style=\"font-size: 11.25pt;\">QUOTATION</td></tr>
		<tr><td style=\"width: 10%; border-top:0.75pt solid #cbcecb; border-left:0.75pt solid #cbcecb;\" bgcolor=\"#F2F1F0\"></td><td bgcolor=\"#F2F1F0\" style=\"width:50%;border-top:0.75pt solid #cbcecb;border-right:0.75pt solid #cbcecb;\"></td><td style=\"width:15%;border-right:0.75pt solid #cbcecb;\">&nbsp;</td><td bgcolor=\"#F2F1F0\" style=\"width:10%;border-top:0.75pt solid #cbcecb;\"></td><td bgcolor=\"#F2F1F0\" style=\"width:15%; border-top:0.75pt solid #cbcecb; border-right:0.75pt solid #cbcecb;\"></td></tr>
		<tr><td colspan=\"2\" style=\"border-top: 0.75pt solid #cbcecb; border-left:0.75pt solid #cbcecb; border-right: 0.75pt solid #cbcecb;\"><b>{$resultCustomerInfo2[0]}</b></td><td ></td><td style=\"border-top:0.75pt solid #cbcecb;border-left:0.75pt solid #cbcecb;\">Quote No</td><td style=\"border-top:0.75pt solid #cbcecb;border-right:0.75pt solid #cbcecb;\">{$rowQuotationInfo[0]}</td></tr>
		";
	
		$value1 = nl2br($resultCustomerInfo2[2]);
		$value2 = date("d/m/y",strtotime($rowQuotationInfo[1]));
	
		$htmlPage .= "<tr><td colspan=\"2\" style=\"border-left:0.75pt solid #cbcecb;border-right:0.75pt solid #cbcecb;\">{$value1}</td><td></td><td valign=\"top\" style=\"border-left:0.75pt solid #cbcecb;border-bottom:0.75pt solid #cbcecb;\">Date</td><td valign=\"top\" style=\"border-right:0.75pt solid #cbcecb;border-bottom:0.75pt solid #cbcecb;\">{$value2}</td></tr>
		<tr><td style=\"border-left: 0.75pt solid #cbcecb;\"><b>Tel</b></td><td  align=\"left\" style=\"border-right: 0.75pt solid #cbcecb;\">{$resultCustomerInfo2[1]}</td><td ></td><td></td><td>
		";
	
		$htmlPage .= "
		</td></tr>
		<tr><td style=\"border-bottom: 0.75pt solid #cbcecb; border-left:0.75pt solid #cbcecb;\"><b>Email</b></td><td style=\"border-bottom: 0.75pt solid #cbcecb;border-right: 0.75pt solid #cbcecb;\">{$rowQuotationInfo[6]}</td><td></td><td><b>From</b></td><td>{$rowQuotationInfo[3]}</td></tr>
		<tr height=\"3pt\"><td colspan=\"5\" align=\"left\">&nbsp;</td></tr>
		</table>
		
		<table width=\"570pt\" style=\"border-collapse: collapse; page-break-inside: avoid;\">
		<tr><td style=\"width: 57pt;\">Attention</td><td colspan=\"4\" style=\"width: 513pt;\">{$rowQuotationInfo[5]}</td></tr>
		<tr><td colspan=\"5\" align=\"left\">&nbsp;</td></tr>
		";
	
	
		//show only if title got value
		if($rowQuotationInfo[2] !== ""){
			$htmlPage .= "<tr><td colspan=\"5\" align=\"left\" style=\"min-height: 30pt;\"><u><b>{$rowQuotationInfo[2]}</b></u></td></tr>
			<tr><td colspan=\"5\" align=\"left\" style=\"min-height: 20pt;\">&nbsp;</td></tr>
			";
		}
		//show only if remark got value		
		if($rowQuotationInfo[14] !== ""){
			$htmlPage .= "<tr><td colspan=\"5\" align=\"left\" style=\"min-height: 30pt;\">{$rowQuotationInfo[14]}</td></tr>
			<tr><td colspan=\"5\" align=\"left\"></td></tr>";
		}
		
		$htmlPage .= "</table>";
	
	
	
		
		
		if(mysqli_num_rows($resultQuotationDetailInfo) > 0){
			$numOfRows = mysqli_num_rows($resultQuotationDetailInfo);
			$counter = 0;
		
			$htmlPage .= "
				<table width=\"570pt\">
				
				<thead>
				<tr>
				<th style=\"width: 25pt; text-align: left; background-color: #F2F1F0; vertical-align: top; font-weight: bold; height: 15pt; border-top: 0.75pt solid #cbcecb; border-left: 0.75pt solid #cbcecb;\">No</th>
				<th style=\"width: 320pt; text-align: left; background-color: #F2F1F0; vertical-align: top; font-weight: bold; border-top: 0.75pt solid #cbcecb\">Description</th>
				<th style=\"width: 40pt; text-align: left; background-color: #F2F1F0; vertical-align: top; font-weight: bold; border-top: 0.75pt solid #cbcecb\">Qty</th>
				<th style=\"width: 40pt; text-align: left; background-color: #F2F1F0; vertical-align: top; font-weight: bold; border-top: 0.75pt solid #cbcecb\">UOM</th>
				<th style=\"width: 55pt; text-align: left; background-color: #F2F1F0; vertical-align: top; font-weight: bold; border-top: 0.75pt solid #cbcecb\">U.Price</th>
				<th style=\"width: 35pt; text-align: left; background-color: #F2F1F0; vertical-align: top; font-weight: bold; border-top: 0.75pt solid #cbcecb\">Disc</th>
				<th style=\"width: 55pt; text-align: left; background-color: #F2F1F0; vertical-align: top; font-weight: bold; border-top: 0.75pt solid #cbcecb; border-right: 0.75pt solid #cbcecb;\">Amount</th>
				</tr>
				</thead>
				
			";
		
			while($rowQuotationDetailInfo = mysqli_fetch_row($resultQuotationDetailInfo)){
				$counter = $counter + 1;
				//modulo operator to check even or odd
				if($counter % 2 == 0){
					$htmlPage .= "<tr style=\"background-color: #F2F1F0;\">";
				}else{
					$htmlPage .= "<tr>";
				}
				
				
				
				if($rowQuotationDetailInfo[4] == 1){
					//Bold
					$value3 = nl2br($rowQuotationDetailInfo[0]);
					$value4 = nl2br($rowQuotationDetailInfo[1]);
					
					$htmlPage .= "<td style=\"width: 25pt; text-align: right; border-left: 0.75pt solid #cbcecb;\">					
						<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
							<tr>
								<td><b>{$value3}</b></td>
							</tr>
						</table>
						</td>
					<td style=\"width: 320pt; vertical-align: top;\">
						<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
							<tr>
								<td><b>{$value4}</b></td>
							</tr>
						</table>
					
					</td>";
					
					if($rowQuotationDetailInfo[2] == 0.00){
						$htmlPage .= "<td style=\"width: 40pt; text-align: right;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td><b>&nbsp;</b></td>
								</tr>
							</table>
						</td>";
					}else{
						$value5 = nl2br($rowQuotationDetailInfo[2]);
						$htmlPage .= "<td style=\"width: 40pt; text-align: right;\">
						
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td><b>{$value5}</b></td>
								</tr>
							</table>
						</td>";
					}
					$value6 = nl2br($rowQuotationDetailInfo[3]);
					$htmlPage .= "<td style=\"width: 40pt;\">
						<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
							<tr>
								<td><b>{$value6}</b></td>
							</tr>
						</table>
					</td>";				
					
					if($rowQuotationDetailInfo[5] == 0.00){
						$htmlPage .= "<td style=\"width: 55pt; text-align: right;\">
								<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td><b>&nbsp;</b></td>
								</tr>
							</table>
						</td>";
					}else{
						$value7 = nl2br($rowQuotationDetailInfo[5]);
						$htmlPage .= "<td style=\"width: 55pt; text-align: right;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td><b>{$value7}</b></td>
								</tr>
							</table>
						</td>";
					}
					
					if($rowQuotationDetailInfo[6] == 0.00){
						$htmlPage .= "<td style=\"width: 35pt; text-align: right;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td><b>&nbsp;</b></td>
								</tr>
							</table>
						</td>";
					}else{
						$value8 = nl2br($rowQuotationDetailInfo[6]);
						$htmlPage .= "<td style=\"width: 35pt; text-align: right;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td><b>{$value8}</b></td>
								</tr>
							</table>
						
						</td>";
					}
					if($rowQuotationDetailInfo[7] == 0.00){
						$htmlPage .= "<td style=\"width: 55pt; text-align: right; border-right: 0.75pt solid #cbcecb;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td><b>&nbsp;</b></td>
								</tr>
							</table>
						
						</td>";
					}else{
						$value9 = nl2br($rowQuotationDetailInfo[7]);
						$htmlPage .= "<td style=\"width: 55pt; text-align: right; border-right: 0.75pt solid #cbcecb\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td><b>{$value9}</b></td>
								</tr>
							</table>
						</td>";
					}
				
				}else{
					$value10 = nl2br($rowQuotationDetailInfo[0]);
					$value11 = nl2br($rowQuotationDetailInfo[1]);
					$htmlPage .= "<td style=\"width: 25pt; vertical-align: top; text-align: right; border-left: 0.75pt solid #cbcecb;\">					
					
					<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
						<tr>
							<td>{$value10}</td>
						</tr>
					</table>
					
					</td>
					<td style=\"width: 320pt;\">					
						<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
							<tr>
								<td>{$value11}</td>
							</tr>
						</table>
					</td>";
					
					if($rowQuotationDetailInfo[2] == 0.00){
						$htmlPage .= "<td style=\"width: 40pt; text-align: right;\">
						
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>";
					}else{
						$value12 = nl2br($rowQuotationDetailInfo[2]);
						$htmlPage .= "<td style=\"width: 40pt; text-align: right;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td>{$value12}</td>
								</tr>
							</table>
						</td>";
					}
					$value13 = nl2br($rowQuotationDetailInfo[3]);
					$htmlPage .= "<td style=\"width: 40pt;\">
								<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
									<tr>
										<td>{$value13}</td>
									</tr>
								</table>
							</td>";
					
					if($rowQuotationDetailInfo[5] == 0.00){
						$htmlPage .= "<td style=\"width: 55pt; text-align: right;\">
								<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
									<tr>
										<td>&nbsp;</td>
									</tr>
								</table>
							</td>";
					}else{
						$value14 = nl2br($rowQuotationDetailInfo[5]);
						$htmlPage .= "<td style=\"width: 55pt; text-align: right;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td>{$value14}</td>
								</tr>
							</table>
						</td>";
					}
					
					if($rowQuotationDetailInfo[6] == 0.00){
						$htmlPage .= "<td style=\"width: 35pt; text-align: right;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>";
					}else{
						$value15 = nl2br($rowQuotationDetailInfo[6]);
						$htmlPage .= "<td style=\"width: 35pt; text-align: right;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td>{$value15}</td>
								</tr>
							</table>
						</td>";
					}
					
					if($rowQuotationDetailInfo[7] == 0.00){
						$htmlPage .= "<td style=\"width: 55pt; text-align: right; border-right: 0.75pt solid #cbcecb;\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td>&nbsp;</td>
								</tr>
							</table>
						</td>";
					}else{
						$value16 = nl2br($rowQuotationDetailInfo[7]);
						$htmlPage .= "<td style=\"width: 55pt; text-align: right; border-right: 0.75pt solid #cbcecb\">
							<table width=\"100%\" height=\"100%\" cellpadding=\"3pt\">
								<tr>
									<td>{$value16}</td>
								</tr>
							</table>
						</td>";
					}
				}
				$htmlPage .= "</tr>";
			}
			
			$htmlPage .= "</table>
			
			<table width=\"570pt\" border=\"0pt\" style=\"border-collapse: collapse; page-break-inside: avoid;\">
			<tr><td style=\"width: 400pt; text-align: left; border-right: 0.75pt solid #cbcecb; border-top: 0.75pt solid #cbcecb\" colspan='4'></td><td style=\"width: 105pt; border-top: 0.75pt solid #cbcecb\" colspan='2' >Subtotal</td><td style=\"width: 65pt; text-align: right; border-right: 0.75pt solid #cbcecb; border-top: 0.75pt solid #cbcecb\">{$rowQuotationInfo[7]}</td></tr>
			<tr><td style=\"width: 400pt; text-align: left; border-right: 0.75pt solid #cbcecb\" colspan='4'></td><td style=\"width: 105pt\" colspan='2'>Disc Total</td><td  style=\"width: 65pt; text-align: right; border-right: 0.75pt solid #cbcecb\">{$rowQuotationInfo[8]}</td></tr>
			<tr><td style=\"width: 400pt; text-align: left; border-right: 0.75pt solid #cbcecb\" colspan='4'></td><td style=\"width: 105pt\" colspan='2'>Tax</td><td style=\"width: 65pt; text-align: right; border-right: 0.75pt solid #cbcecb\">{$rowQuotationInfo[10]}</td></tr>
			<tr><td style=\"width: 400pt; text-align: left; border-right: 0.75pt solid #cbcecb\" colspan='4'></td><td style=\"width: 105pt\" colspan='2'>Total</td><td style=\"width: 65pt; text-align: right; border-right: 0.75pt solid #cbcecb\">{$rowQuotationInfo[11]}</td></tr>
			<tr><td style=\"width: 400pt; text-align: left; border-right: 0.75pt solid #cbcecb\" colspan='4'></td><td style=\"width: 105pt\" colspan='2'>Round</td><td style=\"width: 65pt; text-align: right; border-right: 0.75pt solid #cbcecb\">{$rowQuotationInfo[12]}</td></tr>";
			
			$totalAmountInWords = "";
			if($rowQuotationInfo[11]<>0.00){$totalAmountInWords = convertNumber($rowQuotationInfo[13]);}
			
			$htmlPage .= "
			<tr><td style = \"width:400pt; border-right: 0.75pt solid #cbcecb\" colspan='4'>{$totalAmountInWords}</td><td style=\"width:105pt; border-bottom: 0.75pt solid #cbcecb\" colspan='2'>Grand Total</td><td align='right' style=\"width:65pt; border-bottom: 0.75pt solid #cbcecb; text-align: right; border-right: 0.75pt solid #cbcecb\">{$rowQuotationInfo[13]}</td></tr>		
			</table>			
			
			";
		}
		
		
		$htmlPage .= "
			
			<table width=\"570pt\" style=\"border-collapse: collapse; page-break-inside: avoid;\">
			<tr><td height=\"20\">&nbsp;</td></tr>
			<tr><td colspan=\"5\" align=\"left\">{$rowQuotationInfo[4]}</td></tr>
			<tr height=\"20\"><td colspan=\"5\">&nbsp;</td></tr>
			</table>
			<br>
			
			<table width=\"570pt\" style=\"border-collapse: collapse; page-break-inside: avoid;\">
			
			<tr><td width=\"45%\">Yours Faithfully<br>{$rowCompanyName[0]}</td><td width=\"10%\"></td><td width=\"45%\">We hereby confirmed & Accepted<br>{$resultCustomerInfo2[0]}</td></tr>
			
			<tr>
			<td><div id=\"signature\" style=\"width: 40%; border-bottom: 0.75pt solid black; height: 75px;\">
			<img src=\"logo/companysign.jpg\">
			</div></td>
			<td></td>
			<td><div id=\"signature\" style=\"width: 40%; border-bottom: 0.75pt solid black; height: 75px;\">
			<img src=\"logo/companyblank.jpg\">
			</div></td>
			</tr>
			<tr><td>{$rowQuotationInfo[3]}</td><td></td><td>Signed & Company's stamp</td></tr>
			</table>
			</body>	
			</html>	
		";
	
	// Output the HTML content to the PDF
	$pdf->writeHTML($htmlPage, true, false, true, false, '');

	// Save the PDF to a file
	$pdf->Output('sample.pdf', 'D');
	
	
	



?>