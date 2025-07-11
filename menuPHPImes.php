<a href="home.php">Home</a>

  <div class="dropdown">
    <button class="dropbtn">Admin 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
	<?php  
		echo "<a href=\"companyAdmin.php\">Setting</a>";
		echo "<a href=\"createTaxRate.php\">Tax Rate</a>";
		//echo "<a href=\"test.php\">Test Captcha</a>";
	?>
    </div>
  </div>





 
<div class="dropdown">
<button class="dropbtn">Customers 
  <i class="fa fa-caret-down"></i>
</button>
<div class="dropdown-content">  
  
  <a href="customerList.php">Customers Database</a>  
  <a href="customerAccount.php">Customers Account</a>  
    
</div>
</div> 

<div class="dropdown">
<button class="dropbtn">Product & Service List 
  <i class="fa fa-caret-down"></i>
</button>
<div class="dropdown-content">  
  
  <a href="productList.php">Product & Service Database</a>  
</div>
</div> 

<div class="dropdown">
<button class="dropbtn">Purchase Order 
  <i class="fa fa-caret-down"></i>
</button>
<div class="dropdown-content">
  <a href="createPurchaseOrder.php">Create Purchase Order</a>
  <a href="purchaseOrderList.php">Purchase Order List</a>  
  <a href="createPurchaseBill.php">Create Purchase Bill</a>  
   <a href="purchaseBillList.php">Purchase Bill List</a>  
</div>
</div> 

<div class="dropdown">
<button class="dropbtn">Quotation 
  <i class="fa fa-caret-down"></i>
</button>
<div class="dropdown-content">
	 <a href="createQuotation.php">Create Quotation</a>
	<a href="quotationList.php">Quotation List</a>
    
</div>
</div> 

<div class="dropdown">
    <button class="dropbtn">Delivery Order 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="createDeliveryOrder.php">Create Delivery Order</a>	  
      <a href="deliveryOrderList.php">Delivery Order List</a>	
	
	</div>
  </div>
  
  <div class="dropdown">
    <button class="dropbtn">Invoice 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="createInvoice.php">Create Invoice</a>
		<a href="invoiceList.php">Invoice List</a>
		<a href="paymentList.php">Payment List</a>  
    </div>
  </div>
  
  
  
  
  
  <div class="dropdown">
    <button class="dropbtn">DN & CN 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
		<a href="invoiceListDebitNote.php">Create Debit Note</a>
		<a href="invoiceListCreditNote.php">Create Credit Note</a>
		<a href="debitNoteList.php">Debit Note List</a> 
		<a href="creditNoteList.php">Credit Note List</a> 
    </div>
  </div>
  
  
  
  
  
  
  
  
  
   <div class="dropdown">
    <button class="dropbtn">Payment Voucher 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
      <a href="createPaymentVoucherSeparate.php">Create Payment Voucher</a>	  
      <a href="paymentVoucherList.php">Payment Voucher List</a>
    </div>
  </div>
  
  <div class="dropdown">
    <button class="dropbtn">Accounts 
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">
       <a href="chartOfAccount.php">Chart of Accounts</a>
       <a href="accountTransaction.php">Account Ledger Transaction</a>
       <!--<a href="accountReport.php">Account Ledger Report</a>-->
       
       <a href="createAccountingPeriod.php">Create Accounting Period</a>
       <a href="createAPmanualOpenBalance.php">Accounting Period Open Balance</a>
       <a href="trialBalance.php">Trial Balance</a>
       <a href="profitLossStatement.php">Profit & Loss Statement</a>
       <a href="balanceSheet.php">Balance Sheet</a>
    </div>
  </div>



  <div class="dropdown">
    <button class="dropbtn">Reports
      <i class="fa fa-caret-down"></i>
    </button>
    <div class="dropdown-content">      
      <a href="purchaseOrderReport.php">Purchase Order</a>
      <a href="quotationReport.php">Quotation</a>
	  <a href="">Delivery Order</a>
      <a href="invoiceReport.php">Invoice</a>
	  <a href="paymentVoucherReport.php">Payment Voucher</a>
    </div>
  </div>
  <a href="index.php">Exit</a>
  