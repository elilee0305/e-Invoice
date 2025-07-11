<?php 
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	//get the company name
	$sqlCompanyName = "SELECT company_name FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$resultCompanyName2 = mysqli_fetch_row($resultCompanyName);	
	
	//==================Code for Paging================
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;	
	$productType = "a";
	//get the existing student list
	if(isset($_POST['Submit'])){
		//$searchName = makeSafe($_POST['searchValue']);
		$searchName = $_POST['searchValue'];
		$searchName = '%'.$searchName.'%'; 
		$productType = $_POST['productType'];		
		if($productType=="a"){
			if($_POST['searchValue']!=""){
				$query = "SELECT COUNT(*) as num FROM tbproduct WHERE (product_name LIKE '$searchName')";	
			}else{
				$query = "SELECT COUNT(*) as num FROM tbproduct ORDER BY product_name ASC";
			}				
		}else{
			if($_POST['searchValue']!=""){
				$query = "SELECT COUNT(*) as num FROM tbproduct WHERE (product_name LIKE '$searchName') AND (product_type = '$productType') ORDER BY product_name ASC";
			}else{
				$query = "SELECT COUNT(*) as num FROM tbproduct WHERE (product_type = '$productType') ORDER BY product_name ASC";
			}					
		}		
	
	}else{		
		if(isset($_GET['page'])){
			$productType = $_GET['productType'];
			if(isset($_GET['searchValue'])){
				//$searchName = makeSafe($_GET['searchValue']);
				$searchName = $_GET['searchValue'];
				$searchName = '%'.$searchName.'%'; 
				if($productType=="a"){
					$query = "SELECT COUNT(*) as num FROM tbproduct WHERE (product_name LIKE '$searchName')";
				}else{
					$query = "SELECT COUNT(*) as num FROM tbproduct WHERE (product_name LIKE '$searchName') AND (product_type = '$productType')";
				}				
				
			}else{
				if($productType=="a"){
					$query = "SELECT COUNT(*) as num FROM tbproduct";					
				}else{
					$query = "SELECT COUNT(*) as num FROM tbproduct WHERE (product_type = '$productType')";
				}				
			}
			
		}else{			
			$query = "SELECT COUNT(*) as num FROM tbproduct";					
		}				
	}
	
	$total_pages = mysqli_fetch_array(mysqli_query($connection, $query));
	$total_pages = $total_pages['num'];
	
	/* Setup vars for query. */
	$targetpage = "productList.php";
	$limit = 5; 
	
	if(isset($_GET['page'])){
		$page = $_GET['page'];
		$start = ($page - 1) * $limit;	//first item to display on this page		
	}else{
		$page = 0;
		$start = 0;		//if no page var is given, set start to 0
	}	
	
	if(isset($_POST['Submit'])){
		//$searchName = makeSafe($_POST['searchValue']);
		$searchName = $_POST['searchValue'];
		$searchName = '%'.$searchName.'%'; 
		$productType = $_POST['productType'];
		if($productType=="a"){
			if(isset($_POST['searchValue'])){
				$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
				FROM tbproduct WHERE (product_name LIKE '$searchName') ORDER BY product_name ASC LIMIT $start, $limit";				
			}else{
				$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
				FROM tbproduct ORDER BY product_name ASC LIMIT $start, $limit";
			}						
		}else{
			if(isset($_POST['searchValue'])){
				$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
				FROM tbproduct WHERE (product_name LIKE '$searchName') AND (product_type = '$productType') 
				ORDER BY product_name ASC LIMIT $start, $limit";			
			}else{
				$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom
				FROM tbproduct WHERE (product_type = '$productType') 
				ORDER BY product_name ASC LIMIT $start, $limit";				
			}			
		}		
		
	}else{
		
		if(isset($_GET['page'])){
			$productType = $_GET['productType'];							
			//$searchName = makeSafe($_GET['searchValue']);
			if(isset($_GET['searchValue'])){
				$searchName = $_GET['searchValue'];
				$searchName = '%'.$searchName.'%'; 				
			}			
			
			if($productType=="a"){
				
				if(isset($_GET['searchValue'])){
					$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
					FROM tbproduct WHERE product_name LIKE '$searchName' ORDER BY product_name ASC LIMIT $start, $limit";					
				}else{
					$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
					FROM tbproduct ORDER BY product_name ASC LIMIT $start, $limit";					
				}
			
			}else{
				if(isset($_GET['searchValue'])){
					$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
					FROM tbproduct WHERE (product_name LIKE '$searchName') AND (product_type = '$productType') 
					ORDER BY product_name ASC LIMIT $start, $limit";					
				}else{
					$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
					FROM tbproduct WHERE (product_type = '$productType') 
					ORDER BY product_name ASC LIMIT $start, $limit";					
				}				
			}			
						
		}else{

			if($productType=="a"){
				$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
				FROM tbproduct ORDER BY product_name ASC LIMIT $start, $limit";
				
			}else{
				$sqlCustomerList = "SELECT product_id, product_name, product_type, product_buyingPrice, product_sellingPrice, product_uom 
				FROM tbproduct WHERE (product_type = '$productType') ORDER BY product_name ASC LIMIT $start, $limit";
			}	
		}		
	}
	
	$resultCustomerList = mysqli_query($connection, $sqlCustomerList);		
	/* Setup page vars for display. */
	if($page == 0){$page = 1;} 					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;	
	
	//Now we apply our rules and draw the pagination object. 
	//We're actually saving the code to a variable in case we want to draw it more than once.
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			if(isset($_GET['searchValue'])){
				if($_GET['searchValue']!=""){
					$pagination.= "<a href=\"$targetpage?page=$prev&searchValue=$_GET[searchValue]&productType=$productType\">previous</a>";
				}else{
					$pagination.= "<a href=\"$targetpage?page=$prev&productType=$productType\">previous</a>";
				}				
			}else{
				$pagination.= "<a href=\"$targetpage?page=$prev&productType=$productType\">previous</a>";
			}
		else
			$pagination.= "<span class=\"disabled\">previous</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination.= "<span class=\"current\">$counter</span>";
				else
					if(isset($_GET['searchValue'])){
						if($_GET['searchValue']!=""){
							$pagination.= "<a href=\"$targetpage?page=$counter&searchValue=$_GET[searchValue]&productType=$productType\">$counter</a>";	
						}else{
							$pagination.= "<a href=\"$targetpage?page=$counter&productType=$productType\">$counter</a>";					
						}						
					}else{
						$pagination.= "<a href=\"$targetpage?page=$counter&productType=$productType\">$counter</a>";					
					}					
			}
		}
		elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 2))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						if(isset($_GET['searchValue'])){
							if($_GET['searchValue']!=""){
								$pagination.= "<a href=\"$targetpage?page=$counter&searchValue=$_GET[searchValue]&productType=$productType\">$counter</a>";					
							}else{
								$pagination.= "<a href=\"$targetpage?page=$counter&productType=$productType\">$counter</a>";					
							}							
						}else{
							$pagination.= "<a href=\"$targetpage?page=$counter&productType=$productType\">$counter</a>";					
						}						
				}
				$pagination.= "...";								
				if(isset($_GET['searchValue'])){
					if($_GET['searchValue']!=""){
						$pagination.= "<a href=\"$targetpage?page=$lpm1&searchValue=$_GET[searchValue]&productType=$productType\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage&searchValue=$_GET[searchValue]&productType=$productType\">$lastpage</a>";						
					}else{
						$pagination.= "<a href=\"$targetpage?page=$lpm1&productType=$productType\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage&productType=$productType\">$lastpage</a>";
					}
					
				}else{
					$pagination.= "<a href=\"$targetpage?page=$lpm1&productType=$productType\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage&productType=$productType\">$lastpage</a>";
				}
				
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{				
				if(isset($_GET['searchValue'])){
					if($_GET['searchValue']!=""){
						$pagination.= "<a href=\"$targetpage?page=1&searchValue=$_GET[searchValue]&productType=$productType\">1</a>";	
						$pagination.= "<a href=\"$targetpage?page=2&searchValue=$_GET[searchValue]&productType=$productType\">2</a>";
					}else{
						$pagination.= "<a href=\"$targetpage?page=1&productType=$productType\">1</a>";	
						$pagination.= "<a href=\"$targetpage?page=2&productType=$productType\">2</a>";
					}					
				}else{
					$pagination.= "<a href=\"$targetpage?page=1&productType=$productType\">1</a>";	
					$pagination.= "<a href=\"$targetpage?page=2&productType=$productType\">2</a>";					
				}				
								
				
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if($counter == $page){
						$pagination.= "<span class=\"current\">$counter</span>";
					}else{
						if(isset($_GET['searchValue'])){
							if($_GET['searchValue']!=""){
								$pagination.= "<a href=\"$targetpage?page=$counter&searchValue=$_GET[searchValue]&productType=$productType\">$counter</a>";					
							}else{
								$pagination.= "<a href=\"$targetpage?page=$counter&productType=$productType\">$counter</a>";					
							}
							
						}else{
							$pagination.= "<a href=\"$targetpage?page=$counter&productType=$productType\">$counter</a>";								
						}						
					}						
				}
				$pagination.= "...";
				if(isset($_GET['searchValue'])){
					if($_GET['searchValue']!=""){
						$pagination.= "<a href=\"$targetpage?page=$lpm1&searchValue=$_GET[searchValue]&productType=$productType\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage&searchValue=$_GET[searchValue]&productType=$productType\">$lastpage</a>";					
					}else{
						$pagination.= "<a href=\"$targetpage?page=$lpm1&productType=$productType\">$lpm1</a>";
						$pagination.= "<a href=\"$targetpage?page=$lastpage&productType=$productType\">$lastpage</a>";					
					}
					
				}else{
					$pagination.= "<a href=\"$targetpage?page=$lpm1&productType=$productType\">$lpm1</a>";
					$pagination.= "<a href=\"$targetpage?page=$lastpage&productType=$productType\">$lastpage</a>";					
				}				
			}
			//close to end; only hide early pages
			else
			{	
				if(isset($_GET['searchValue'])){
					if($_GET['searchValue']!=""){
						$pagination.= "<a href=\"$targetpage?page=1&searchValue=$_GET[searchValue]&productType=$productType\">1</a>";				
						$pagination.= "<a href=\"$targetpage?page=2&searchValue=$_GET[searchValue]&productType=$productType\">2</a>";				
					}else{
						$pagination.= "<a href=\"$targetpage?page=1&productType=$productType\">1</a>";				
						$pagination.= "<a href=\"$targetpage?page=2&productType=$productType\">2</a>";				
					}
				}else{
					$pagination.= "<a href=\"$targetpage?page=1&productType=$productType\">1</a>";				
					$pagination.= "<a href=\"$targetpage?page=2&productType=$productType\">2</a>";					
				}
				
				
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if($counter == $page){
						$pagination.= "<span class=\"current\">$counter</span>";
					}else{
						if(isset($_GET['searchValue'])){
							if($_GET['searchValue']!=""){
								$pagination.= "<a href=\"$targetpage?page=$counter&searchValue=$_GET[searchValue]&productType=$productType\">$counter</a>";					
							}else{
								$pagination.= "<a href=\"$targetpage?page=$counter&productType=$productType\">$counter</a>";					
							}							
						}else{
							$pagination.= "<a href=\"$targetpage?page=$counter&productType=$productType\">$counter</a>";
						}						
					}						
						
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			if(isset($_GET['searchValue'])){
				if($_GET['searchValue']!=""){
					$pagination.= "<a href=\"$targetpage?page=$next&searchValue=$_GET[searchValue]&productType=$productType\">next</a>";
				}else{
					$pagination.= "<a href=\"$targetpage?page=$next&productType=$productType\">next</a>";
				}
				
			}else{
				$pagination.= "<a href=\"$targetpage?page=$next&productType=$productType\">next</a>";
			}
		else
			$pagination.= "<span class=\"disabled\">next</span>";
		$pagination.= "</div>\n";		
	}
	
	
	
	
	
?>

<html>
<head>
<link href="styles.css" rel="stylesheet" type="text/css">
<title>Invoicing Billing System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
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
	background-color: #E1ECEE;
}



input:focus
{
	background-color: 92CBDE;
}

div.myborder
{
	border:1px solid #CFE2E8;
	padding:10px 10px; 
	background:#9cc1c7;
	width:300;
	border-radius:10px;
}



textarea:focus
{
	background-color: 92CBDE;
}
select:focus
{
	background-color: 92CBDE;
}

div.pagination {
	padding: 3px;
	margin: 3px;
}

div.pagination a {
	padding: 2px 5px 2px 5px;
	margin: 2px;
	border: 1px solid #AAAADD;
	
	text-decoration: none; /* no underline */
	color: #000099;
}
div.pagination a:hover, div.pagination a:active {
	border: 1px solid #000099;

	color: #000;
}
div.pagination span.current {
	padding: 2px 5px 2px 5px;
	margin: 2px;
		border: 1px solid #000099;
		
		font-weight: bold;
		background-color: #000099;
		color: #FFF;
	}
	div.pagination span.disabled {
		padding: 2px 5px 2px 5px;
		margin: 2px;
		border: 1px solid #EEE;
	
		color: #DDD;
	}

</style>


</head>
<body>
<center>

<div class="navbar">
	<?php include 'menuPHPImes.php';?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>


<form action="productList.php" method="post">
<p class="bigGap"></p>
<table width="900" border="0" cellpadding="0" align="center">
<tr>
<td align="left" width="350"><h1>Product & Service Database</h1></td>

<?php
	if(isset($_POST['Submit'])){
		echo "<td align='right'><div class='myborder'>";
		echo "<select name='productType' id='productType' size='1'>";
		if($_POST['productType']=="a"){
			echo "<option value='a'>All</option>";
		}elseif($_POST['productType']=="p"){
			echo "<option value='p'>Product</option>";
		}elseif($_POST['productType']=="s"){
			echo "<option value='s'>Service</option>";
		}		
		echo "<option value='a'>All</option>";
		echo "<option value='p'>Product</option>";
		echo "<option value='s'>Service</option>";
				
		echo "</select>";
		if($_POST['searchValue']!=""){
			echo "<input type='text' name='searchValue' size='20' value=$_POST[searchValue] style=\"font-size:9pt;\">";			
		}else{
			echo "<input type='text' name='searchValue' size='20' style=\"font-size:9pt;\">";
		}	
	
	}else{
		if(isset($_GET['page'])){			
			
			echo "<td align='right'><div class='myborder'>";
			echo "<select name='productType' id='productType' size='1'>";	
			if($_GET['productType']=="a"){
				echo "<option value='a'>All</option>";
			}elseif($_GET['productType']=="p"){
				echo "<option value='p'>Product</option>";
			}elseif($_GET['productType']=="s"){
				echo "<option value='s'>Service</option>";
			}					
			echo "<option value='a'>All</option>";
			echo "<option value='p'>Product</option>";
			echo "<option value='s'>Service</option>";
					
			echo "</select>";
			if(isset($_GET['searchValue'])){
				echo "<input type='text' name='searchValue' size='20' value=$_GET[searchValue] style=\"font-size:9pt;\">";	
			}else{
				echo "<input type='text' name='searchValue' size='20' style=\"font-size:9pt;\">";
			}				
			
		}else{
			echo "<td align='right'><div class='myborder'>";
			echo "<select name='productType' id='productType' size='1'>";		
			echo "<option value='a'>All</option>";
			echo "<option value='p'>Product</option>";
			echo "<option value='s'>Service</option>";
					
			echo "</select>";			
			echo "<input type='text' name='searchValue' size='20' style=\"font-size:9pt;\">";
		}		
	}
?>

<input type="submit" name="Submit" value="Search"></td></div>
</tr>
</table>




<?php 
	if(mysqli_num_rows($resultCustomerList) > 0){
		
		
		echo "<table cellpadding=0 border=0 width='900'><tr><td align='left'>Number Of Products ".$total_pages."</td><td></td></tr></table>";
		
		echo "<table cellpadding='0' border='1' width='900' class='mystyle'>";
		echo "<tr bgcolor='D8E0E3' height='30'>";
		echo "<td><b>Name</b></td>";
		echo "<td><b>Type</b></td>";
		echo "<td><b>UOM</b></td>";
		echo "<td><b>Buying Price</b></td>";
		echo "<td><b>Selling Price</b></td>";
		echo "<td><b>Edit</b></td>";			
		
		echo "</tr>";
		while($rowProductList = mysqli_fetch_row($resultCustomerList)){
			$productID = $rowProductList[0];
			
			echo "<tr bgcolor='FFFFFF' height='30' class='notfirst'>";
			echo "<td><p style=\"font-size:13px\">$rowProductList[1]</p></td>";
			if($rowProductList[2]=="p"){
				echo "<td><p style=\"font-size:13px\">Product</p></td>";	
			}elseif($rowProductList[2]=="s"){
				echo "<td><p style=\"font-size:13px\">Service</p></td>";	
			}
			echo "<td><p style=\"font-size:13px\">$rowProductList[5]</p></td>";		
			echo "<td><p style=\"font-size:13px\">$rowProductList[3]</p></td>";				
			echo "<td><p style=\"font-size:13px\">$rowProductList[4]</p></td>";				
			
			echo "<td><p style=\"font-size:13px\"><a href='editProduct.php?idProduct=$productID'>Edit</a></p></td>";
						
			echo "</tr>";
			
					
		}		
		
		echo "</table>";
		echo "<table cellpadding =0 border='0' width='80%' allign='center'><tr height='10'><td></td></tr></table>";
		echo $pagination;
		echo "<table cellpadding =0 border='0' width='80%' allign='center'><tr height='20'><td></td></tr></table>";	
	}
?>


</form>
</center>
</body>

</html>
