<?php
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");	
	$focusRowID = $_GET['idRowFocus'];
?>
<html>
<head>
<title>Online Imes System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<script>
function check(it) {
	tr = it.parentElement.parentElement;
	tr.style.backgroundColor = (it.checked) ? "74AFD4" : "ecf0e9";
	
	//get the ID of selected checkbox
	var  idCheckedValue = "";
	if(it.checked){
		idCheckedValue = it.id;
	}else {
		idCheckedValue = "0|0"; 
	}

	
	document.getElementById('selectedProduct').value = idCheckedValue;
	
	var cbarray = document.getElementsByClassName('select');
	for(var i = 0; i < cbarray.length; i++){
		var cb = document.getElementById(cbarray[i].id);
		
		if(idCheckedValue != cb.id){
			document.getElementById(cb.id).checked = false;
			
			tr = document.getElementById(cb.id).parentElement.parentElement;
			tr.style.backgroundColor = (document.getElementById(cb.id).checked) ? "74AFD4" : "ecf0e9";
			
			
			
			
		}
	
	}
	
	
	//check the number of checkboxes ticked, and if reach 1 then disable the all the unchecked ones
	/* if(document.querySelectorAll('input[type="checkbox"]:checked').length == 1){		
		$(":checkbox:not(:checked)").prop('disabled', true);
	}else{
		//enable all the checkboxes again less than 1
		$(":checkbox").prop('disabled', false);
	}   */
	
}
</script>
<style type="text/css">
table.mystyle
{
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 14px;
}
.mystyle td, mystyle th
{
	margin: 0;
	padding: 4px;
	border-width: 1px 1px 0 0
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 14px;
}
.notfirst:hover
{
	background-color: #AFCCB0;
}




</style>

</head>
<body bgcolor="#ecf0e9">
<div><input type="text" name="search_text" id="search_text" size="30" placeholder="Search Product Service" autofocus></div>
<div id="result">
<?php
	//product list 20 items start
	$sqlProductList = "SELECT product_id, product_name, product_buyingPrice, product_sellingPrice, product_uom FROM tbproduct ORDER BY product_name ASC";
	$resultProductList = mysqli_query($connection, $sqlProductList) or die("error in product list query");
	
	if(mysqli_num_rows($resultProductList)){
		echo "<table width='750px' cellpadding='0' border='1' class='mystyle'>";
		echo "<tr><th>Item</th><th>Product</th><th>UOM</th><th>Buy Price</th><th>Sell Price</th></tr>";
		while($rowProductList = mysqli_fetch_row($resultProductList)){
			$idValue = $focusRowID."|".$rowProductList[0];
			echo "<tr class='notfirst'>";
			echo "<td align='center'><input type='checkbox' id='$idValue' class='select' value=$idValue onclick='check(this)'></td>";
			echo "<td>$rowProductList[1]</td>";
			echo "<td align='center'>$rowProductList[4]</td>";
			echo "<td align='right'>$rowProductList[2]</td>";
			echo "<td align='right'>$rowProductList[3]</td>";
			echo "</tr>";
		}
		echo "</table>";
	}
?>
</div>
<div><input type='hidden' id='selectedProduct' value="0|0"></div>
<div><input type='hidden' id='idFocusRow' value="<?php echo $focusRowID;?>"></div>
</body>
</html>
<script>
	$(document).ready(function(){
		$('#search_text').keyup(function(){
			var txt = $(this).val();
			//if(txt != '')
			//{
					
			var idRowFocusNow = document.getElementById('idFocusRow').value;
			
			document.getElementById('selectedProduct').value = "0|0";
			$('#result').html('');
			$.ajax({
				type: "post",
				url: "searchProductSQL.php",
				data: {search: txt, idRowFocus: idRowFocusNow},
				
				dataType: "text",
				success:function(data){
					$('#result').html(data);
				}					
					
			});
			/* }
			else
			{
				//input value				
			} */
			
		});
	});
</script>