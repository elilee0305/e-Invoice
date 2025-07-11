<?php 
	session_start();
	
	include ('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");	
	
	include ('makeSafe.php');
	
	//get the company name
	$sqlCompanyName = "SELECT company_name FROM tbcompany WHERE company_id = 1";
	$resultCompanyName = mysqli_query($connection, $sqlCompanyName) or die("error in company name query");
	$resultCompanyName2 = mysqli_fetch_row($resultCompanyName);	
	
	
	$id=0;
	//check to see if login is valid user
	if(isset($_POST['Submit'])){
		//create new login and hashed password
		$login = $_POST['user'];
		$password = $_POST['password'];
		
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		
		$sqlInsertLoginPassword = "INSERT INTO tbsecret(secret_login, secret_password, secret_status) VALUES('$login', '$hashedPassword', 1)";
		
		mysqli_query($connection, $sqlInsertLoginPassword) or die("error in creating hashed password query");
				
		
	}
	

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">


<style type="text/css">
div.myborder
{
	border:1px solid #CFE2E8;
	padding:10px 10px; 
	background:#AFCCB0;
	width:230;
	border-radius:10px;
}

</style>



</head>
<body>
<center>
<table width="80%"><tr height="40"><td>&nbsp;</td></tr></table>

<table width="80%">	
	<tr height="40"><td>&nbsp;</td></tr>
	<tr height="40">		
		<td align="center"><?php echo $resultCompanyName2[0] ?></td>		
	</tr>		
</table>



<table width="80%">	
	<tr height="20">		
		<td align="center"></td>		
	</tr>		
</table>

<table width="500" border="0" cellpadding="0">
<tr height="5"><td></td></tr>
<tr><td align="center">Online Imes System</td></tr>
<tr height="30"><td>&nbsp;</td></tr>
<tr><td align="center"></td></tr>
<tr height="15"><td>&nbsp;</td></tr>
</table>


<div class="myborder">
<table width="230" >
	<form id="loginFromID" action="createPassword.php" method="post">		
		<tr>
			<td colspan="2" align="center"></td>
		</tr>
		<tr>
			<td>Online</td><td><input type="text" name="user" id="user" size="12"></td>			
		</tr>
		<tr>
			<td>Password</td><td><input type="password" name="password" id="password" size="12"></td>
		</tr>
		
		<tr>
			<td></td><td align="right"><input type="submit" name="Submit" value="Login"></td>
		</tr>		
	
	
	
	
	</form>
</table>
</div>


</center>
</body>
</html>