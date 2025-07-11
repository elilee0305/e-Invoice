<?php
	session_start();
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	
	$customerID = $_POST['customerID'];	
	
	$sqlDeleteProduct = "DELETE FROM tbcustomer WHERE customer_id = '$customerID'";	
	mysqli_query($connection, $sqlDeleteProduct) or die("error in delete product query");
	echo "1"; //success delete
	
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