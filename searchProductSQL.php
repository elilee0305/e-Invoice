<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");	
	$output = '';
	$searchProduct = $_POST['search'];
	$searchProduct = '%'.$searchProduct.'%';
	$focusRowID = $_POST['idRowFocus'];
	
	$sqlCheckGetProductInfo = "SELECT product_id, product_name, product_buyingPrice, product_sellingPrice, product_uom 
	FROM tbproduct WHERE (product_name LIKE '$searchProduct') ORDER BY product_name ASC"; 
	
	$resultGetProductInfo = mysqli_query($connection, $sqlCheckGetProductInfo) or die("error in get product info query");
	
	if(mysqli_num_rows($resultGetProductInfo)>0){
		//got product
		$output .= '<table width=\'750\' cellpadding=\'0\' border=\'1\' class=\'mystyle\'>
			<tr >
			<th>Item</th>
			<th>Product</th>
			<th>UOM</th>
			<th>Buy Price</th>
			<th>Sell Price</th>
			</tr>';	
		while($rowGetProductInfo = mysqli_fetch_array($resultGetProductInfo)){
			$idValue = $focusRowID."|".$rowGetProductInfo[0];			
			
			$output .= '
				<tr class=\'notfirst\'>					
					<td align=\'center\'><input type=\'checkbox\' class=\'select\' id='.$idValue.' onclick=\'check(this)\'></td>					
					<td>'.$rowGetProductInfo[1].'</td>
					<td>'.$rowGetProductInfo[4].'</td>						
					<td>'.$rowGetProductInfo[2].'</td>						
					<td>'.$rowGetProductInfo[3].'</td>						
				</tr>			
			';			
		}
		$output .= '</table>'; 
		echo $output;
	}else{
		echo "Data Not Found!";			
	}
?>