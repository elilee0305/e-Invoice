<?php
	session_start();
	include ('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$productID = $_POST['productID'];
	
	$sqlDeleteProduct = "DELETE FROM tbproduct WHERE product_id = '$productID'";
	
	mysqli_query($connection, $sqlDeleteProduct) or die("error in delete product query");
	
	
	if(mysqli_query($connection, $sqlDeleteProduct)){
		echo "1"; //success delete
	}else{
		echo "2"; //error delete
	}
	
	/* try {
    if(mysqli_query($connection, $sqlDeleteProduct)) {
        echo "Product deleted successfully!";
    } else {
        throw new Exception("Error deleting product.");
    }
} catch(Exception $e) {
    echo "Error message: " . $e->getMessage();
    // Perform some action to handle the error, such as logging it or displaying a message to the user.
} */

?>