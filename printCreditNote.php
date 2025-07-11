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

	//get the company name
	$sqlCompanyName = "SELECT company_name, company_address1, company_address2, company_telFax, company_logo, company_no FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$rowCompanyName = mysqli_fetch_row($resultCompanyName);
	
	if(isset($_GET['idCreditNote'])){		
		$creditNoteID = $_GET['idCreditNote'];
		$customerID = $_GET['idCustomer'];
	}
	
	//get the customer info	
	$sqlCustomerInfo = "SELECT customer_name, customer_tel, customer_address FROM tbcustomer WHERE customer_id = '$customerID'";	
	$resultCustomerInfo = mysqli_query($connection, $sqlCustomerInfo) or die("error in customer query");
	$resultCustomerInfo2 = mysqli_fetch_row($resultCustomerInfo);
	
	//get the credit note info	
	$sqlCreditNoteInfo = "SELECT creditNote_no, creditNote_date, creditNote_title, creditNote_from, creditNote_terms, 
	creditNote_attention, creditNote_email, creditNote_subTotal, creditNote_discountTotal,
	creditNote_totalAfterDiscount, creditNote_taxTotal, creditNote_grandTotal, creditNote_roundAmount, creditNote_grandTotalRound, 
	creditNote_content, invoice_no FROM tbinvoice, tbcreditnote WHERE (invoice_id = creditNote_invoiceID) AND (creditNote_id = '$creditNoteID')";
	
	$resultCreditNoteInfo = mysqli_query($connection, $sqlCreditNoteInfo) or die("error in credit note query");
	$rowCreditNoteInfo = mysqli_fetch_row($resultCreditNoteInfo);	
	
	//get the credit note details
	$sqlCreditNoteDetailInfo = "SELECT creditNoteDetail_no1, creditNoteDetail_no2, creditNoteDetail_no3, creditNoteDetail_no4, creditNoteDetail_bold, 
	creditNoteDetail_no5, creditNoteDetail_discountAmount, creditNoteDetail_rowGrandTotal FROM tbcreditnotedetail 
	WHERE creditNoteDetail_creditNoteID = '$creditNoteID' ORDER BY creditNoteDetail_sortID ASC";
	
	$resultCreditNoteDetailInfo = mysqli_query($connection, $sqlCreditNoteDetailInfo) or die("error in credit note detail query");
	
	//Function to convert amount to wordwrap
	function convertNumber($number)
{
    list($integer, $fraction) = explode(".", (string) $number);

    $output = "";

    if ($integer[0] == "-")
    {
        $output = "negative ";
        $integer    = ltrim($integer, "-");
    }
    else if ($integer[0] == "+")
    {
        $output = "positive ";
        $integer    = ltrim($integer, "+");
    }

    if ($integer[0] == "0")
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
            $groups2[] = convertThreeDigit($g[0], $g[1], $g[2]);
        }

        for ($z = 0; $z < count($groups2); $z++)
        {
            if ($groups2[$z] != "")
            {
                $output .= $groups2[$z] . convertGroup(11 - $z) . (
                        $z < 11
                        && !array_search('', array_slice($groups2, $z + 1, -1))
                        && $groups2[11] != ''
                        && $groups[11][0] == '0'
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
		
		//for ($i = 0; $i < strlen($fraction); $i++)
        //{
            $output .= " " . convertTwoDigit($fraction[0],$fraction[1]);
        //}
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

function convertTwoDigit($digit1, $digit2)
{
    if ($digit2 == "0")
    {
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
    } else if ($digit1 == "1")
    {
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
    } else
    {
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
 
	
?>
<html>
<head>

<title>Imes Online System</title>

<!--<script src="js/jquery-3.2.1.min.js"></script>-->
<style type="text/css">
@media print {
	.noPrint{
	display: none;
	}
}

table.mystyle2
{
	border-collapse: collapse;
	width: 950px;
	page-break-inside: avoid;	
}

table.mystyle
{
	border-collapse: collapse;
	width: 950px;
	border-top: 1px solid black;
	border-right: 1px solid black;
	border-bottom: 1px solid black;
	border-left: 1px solid black;
	border-color: #cbcecb;
		

}

.mystyle td, mystyle th
{
	 /*text-align: left;*/
	vertical-align: top;
	padding: 8px;
	
}

.mystyle tr:nth-child(even){background-color: #f2f2f2}

.mystyle th {
	text-align: left;
	background-color: #F2F1F0;
	color: black;
}

.header img{           
	float: left;	
	width: 142px;
	height: 58px;
	/* border: thin solid #0000FF; */
}

.header h1 {
  position: relative;
  top: 11px;
  left: 20px;
  font-size: 24px;
  display: inline;
  /* border: thin solid #0000FF; */
}

.header h2 {
  position: relative;
  top: 14px;
  left: 162px;
  font-size: 13px;
  /* border: thin solid #0000FF; */
}

.header h3 {
  position: relative;
  top: 16px;
  left: 20px;
  font-size: 12px;
  display: inline;
  /* border: thin solid #0000FF; */
}

.row {
  line-height: 0.6;
  width: 750px;
}



.content {
  max-width: 950px;
  margin: auto;  
}

#signature {
  width: 50%;
  border-bottom: 1px solid black;
  height: 75px;
}
</style>

</head>
<body style="font-family: Helvetica ;">
<div class="content">
<div class="header">

<?php 
	if($rowCompanyName[4] ==! ""){
		$logoLocation = "logo/".$rowCompanyName[4];
		echo "<img src=".$logoLocation.">";
	}
?>
<h1><?php echo $rowCompanyName[0];?></h1>&nbsp;&nbsp;&nbsp;<h3><?php echo "Com No: ".$rowCompanyName[5];?></h3>
	
	<div class="row">
		<h2 style="left:20px;"><?php echo $rowCompanyName[1];?></h2>
		<h2 style="left:20px;"><?php echo $rowCompanyName[2];?></h2>
		<h2><?php echo $rowCompanyName[3];?></h2>
	</div>
</div>

<hr style="margin-top:30px;margin-bottom:15px;">

<table width="950px" border="0" class="mystyle2">
<tr><td colspan="5" align="right"><b>CREDIT NOTE</b></td></tr>
<tr><td style="width:10%;border-top:1px solid #cbcecb;border-left:1px solid #cbcecb;" bgcolor="#F2F1F0"></td><td bgcolor="#F2F1F0" style="width:50%;border-top:1px solid #cbcecb;border-right:1px solid #cbcecb;"></td><td style="width:15%;border-right:1px solid #cbcecb;">&nbsp;</td><td bgcolor="#F2F1F0" style="width:10%px;border-top:1px solid #cbcecb;"></td><td bgcolor="#F2F1F0" style="width:15%;border-top:1px solid #cbcecb;border-right:1px solid #cbcecb;"></td></tr>
<tr><td colspan="2" style="border-top:1px solid #cbcecb;border-left:1px solid #cbcecb;border-right:1px solid #cbcecb;"><b><?php echo $resultCustomerInfo2[0]?></b></td><td></td><td style="border-top:1px solid #cbcecb;border-left:1px solid #cbcecb;"><b>CN No</b></td><td style="border-top:1px solid #cbcecb;border-right:1px solid #cbcecb;"><?php echo $rowCreditNoteInfo[0];?></td></tr>
<tr><td colspan="2" style="border-left:1px solid #cbcecb;border-right:1px solid #cbcecb;"><?php echo nl2br($resultCustomerInfo2[2]);?></td><td></td><td valign="top" style="border-left:1px solid #cbcecb;"><b>Date</b></td><td valign="top" style="border-right:1px solid #cbcecb;"><?php echo date("d/m/y",strtotime($rowCreditNoteInfo[1]))?></td></tr>


<tr><td style="border-left:1px solid #cbcecb;">Tel</td><td align="left" style="border-right:1px solid #cbcecb;"><?php echo $resultCustomerInfo2[1]?></td><td ></td><td valign="top" style="border-left:1px solid #cbcecb;border-bottom:1px solid #cbcecb;">Invoice No</td><td valign="top" style="border-right:1px solid #cbcecb;border-bottom:1px solid #cbcecb;"><?php echo $rowCreditNoteInfo[15];?></td></tr>

<tr><td style="border-bottom:1px solid #cbcecb;border-left:1px solid #cbcecb;">Email</td><td style="border-bottom:1px solid #cbcecb;border-right:1px solid #cbcecb;"><?php echo $rowCreditNoteInfo[6];?></td><td></td><td><b>From</b></td><td><?php echo $rowCreditNoteInfo[3];?></td></tr>
<tr height="10px"><td colspan="5" align="left">&nbsp;</td></tr>
</table>

<table width="950px" class="mystyle2" border="0">
<tr><td style="width:10%"><b>Attention</b></td><td><?php echo $rowCreditNoteInfo[5];?></td><td></td><td></td><td></td></tr>

<tr height="10px"><td colspan="5" align="left">&nbsp;</td></tr>

<tr><td colspan="5" align="left"><u><b><?php echo $rowCreditNoteInfo[2];?></b></u></td></tr>
<tr height="5px"><td colspan="5" align="left">&nbsp;</td></tr>
<tr height="25"><td colspan="5" align="left"><div><?php echo $rowCreditNoteInfo[14]; ?></div></td></tr>
<tr><td colspan="5" align="left"></td></tr>
</table>

<p></p>

<?php 
	$strQuotationCheckbox = ""; //to store which line is bold
	
	if(mysqli_num_rows($resultCreditNoteDetailInfo) > 0){
		
		$numOfRows = mysqli_num_rows($resultCreditNoteDetailInfo);
		$counter = 0;
		echo "<table class='mystyle'>";
		echo "<thead><tr><th>No</th><th>Description</th><th>Qty</th><th>UOM</th><th>U.Price</th><th>Disc</th><th>Amount</th></tr></thead>";
		while($rowInvoiceDetailInfo = mysqli_fetch_row($resultCreditNoteDetailInfo)){
			$counter = $counter + 1;
			echo "<tr height='25'>";			
			if($rowInvoiceDetailInfo[4] == 1){
				//Bold
				echo "<td style='width:50px'><b>".nl2br($rowInvoiceDetailInfo[0])."</b></td>";			
				echo "<td style='width:620px'><b>".nl2br($rowInvoiceDetailInfo[1])."</b></td>";
				
				if($rowInvoiceDetailInfo[2] == 0.00){
					echo "<td style='width:70px' align='right'>&nbsp;</td>";
				}else{
					echo "<td style='width:70px' align='right'><b>".nl2br($rowInvoiceDetailInfo[2])."</b></td>";
				}
				
				echo "<td style='width:70px'><b>".nl2br($rowInvoiceDetailInfo[3])."</b></td>";				
				
				if($rowInvoiceDetailInfo[5] == 0.00){
					echo "<td style='width:70px' align='right'>&nbsp;</td>";
				}else{
					echo "<td style='width:70px' align='right'><b>".nl2br($rowInvoiceDetailInfo[5])."</b></td>";
				}
				
				if($rowInvoiceDetailInfo[6] == 0.00){
					echo "<td style='width:70px' align='right'>&nbsp;</td>";
				}else{
					echo "<td style='width:70px' align='right'><b>".nl2br($rowInvoiceDetailInfo[6])."</b></td>";
				}
				if($rowInvoiceDetailInfo[7] == 0.00){
					echo "<td style='width:70px' align='right'>&nbsp;</td>";
				}else{
					echo "<td style='width:70px' align='right'><b>".nl2br($rowInvoiceDetailInfo[7])."</b></td>";
				}
			
			}else{
				echo "<td style='width:50px'>".nl2br($rowInvoiceDetailInfo[0])."</td>";			
				echo "<td style='width:620px'>".nl2br($rowInvoiceDetailInfo[1])."</td>";
				
				if($rowInvoiceDetailInfo[2] == 0.00){
					echo "<td style='width:70px' align='right'>&nbsp;</td>";
				}else{
					echo "<td style='width:70px'align='right'>".nl2br($rowInvoiceDetailInfo[2])."</td>";
				}
				
				echo "<td style='width:70px'>".nl2br($rowInvoiceDetailInfo[3])."</td>";
				
				if($rowInvoiceDetailInfo[5] == 0.00){
					echo "<td style='width:70px' align='right'>&nbsp;</td>";
				}else{
					echo "<td style='width:70px'align='right'>".nl2br($rowInvoiceDetailInfo[5])."</td>";
				}
				
				if($rowInvoiceDetailInfo[6] == 0.00){
					echo "<td style='width:70px' align='right'>&nbsp;</td>";
				}else{
					echo "<td style='width:70px'align='right'>".nl2br($rowInvoiceDetailInfo[6])."</td>";
				}
				
				if($rowInvoiceDetailInfo[7] == 0.00){
					echo "<td style='width:70px' align='right'>&nbsp;</td>";
				}else{
					echo "<td style='width:70px' align='right'>".nl2br($rowInvoiceDetailInfo[7])."</td>";
				}
			
			}	
			echo "</tr>";
			
		}
		echo "</table>";
		//total values
			echo "<table class='mystyle2'>";
			echo "<tr><td style='width:740px; border-right: 1px solid #cbcecb' colspan='4'></td><td style='width:140px' colspan='2' >Subtotal</td><td align='right' style='width:70px; border-right: 1px solid #cbcecb'>$rowCreditNoteInfo[7]</td></tr>";
			echo "<tr><td style='width:740px; border-right: 1px solid #cbcecb' colspan='4'></td><td style='width:140px' colspan='2'>Disc Total</td><td align='right' style='width:70px; border-right: 1px solid #cbcecb'>$rowCreditNoteInfo[8]</td></tr>";
			echo "<tr><td style='width:740px; border-right: 1px solid #cbcecb' colspan='4'></td><td style='width:140px' colspan='2'>Tax</td><td align='right' style='width:70px; border-right: 1px solid #cbcecb'>$rowCreditNoteInfo[10]</td></tr>";
			echo "<tr><td style='width:740px; border-right: 1px solid #cbcecb' colspan='4'></td><td style='width:140px' colspan='2'>Total</td><td align='right' style='width:70px; border-right: 1px solid #cbcecb'>$rowCreditNoteInfo[11]</td></tr>";
			echo "<tr><td style='width:740px; border-right: 1px solid #cbcecb' colspan='4'></td><td style='width:140px' colspan='2'>Round</td><td align='right' style='width:70px; border-right: 1px solid #cbcecb'>$rowCreditNoteInfo[12]</td></tr>";
			$totalAmountInWords = "";			
			if($rowCreditNoteInfo[11]<>0.00){$totalAmountInWords = convertNumber($rowCreditNoteInfo[13]);}			
			echo "<tr><td style='width:740px; border-right: 1px solid #cbcecb' colspan='4'>$totalAmountInWords</td><td style='width:140px; border-bottom: 1px solid #cbcecb' colspan='2'>Grand Total</td><td align='right' style='width:70px; border-bottom: 1px solid #cbcecb; ; border-right: 1px solid #cbcecb'>$rowCreditNoteInfo[13]</td></tr>";
		echo "</table>";
	}
	
?>
<table class="mystyle2">
<tr><td height="20">&nbsp;</td></tr>
<!--<tr><td colspan="5" align="left"><textarea style="border: none; font-family: Helvetica ; font-size: 16px;" cols="100" rows="8" name="quotationTerms" maxlength="1000"><?php echo $rowCreditNoteInfo[4]; ?></textarea></td></tr>-->
<td colspan="5" align="left"><div><?php echo $rowCreditNoteInfo[4]; ?></div></td></tr>
<tr height="20"><td colspan="5">&nbsp;</td></tr>
<tr><td colspan="5"></td></tr>
<tr><td colspan="5" align="left"></td></tr>
<tr><td colspan="5" align="center">
<!--<input type="hidden" name="invoiceID" value="<?php echo $invoiceID?>">-->
<input type="hidden" name="customerID" value="<?php echo $customerID?>">
</table>
<br>

<table class="mystyle2">
<tr>
<td width="45%">Yours Faithfully<br>
<?php echo $rowCompanyName[0];?>


</td>
<td width="10%"></td>
<td width="45%">We hereby confirmed & Accepted<br>
<?php echo $resultCustomerInfo2[0]?>

</td>
</tr>
<tr><td><div id="signature"></div></td><td></td><td><div id="signature"></div></td></tr>
<tr><td><?php echo $rowCreditNoteInfo[3];?></td><td></td><td>Signed & Company's stamp</td></tr>
</table>

<p><input type="button" class="noPrint" onclick="JavaScript:window.print();return false;" value="Print Credit Note"></p>


</div>
</body>
</html>