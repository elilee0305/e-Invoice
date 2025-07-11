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
		//put the user id into session variable if login correct
		$user = makeSafe($_POST['user']);
		$password = makeSafe($_POST['password']);			
		
		$sqlCheckLogin = "SELECT secret_id, secret_login, secret_password, secret_status, client_id, client_secret1, client_secret2 /*taxpayer_tin*/
		FROM tbsecret WHERE BINARY secret_login = '$user'";
		$resultLogin = mysqli_query($connection, $sqlCheckLogin) or die("error in search login query");		
		
		if(mysqli_num_rows($resultLogin) > 0){		
			
			while($rowLogin = mysqli_fetch_row($resultLogin)){				
				
				$hashedPasswordInDatabase = $rowLogin[2];
				if(password_verify($password, $hashedPasswordInDatabase)){
					//put into user id session variable
					$_SESSION['userID'] = $rowLogin[0];				
					$_SESSION['userName'] = $rowLogin[1];
					$_SESSION['userStatus'] = $rowLogin[3];
					$_SESSION['client_id'] = $rowLogin[4];
					$_SESSION['client_secret1'] = $rowLogin[5];
					$_SESSION['client_secret2'] = $rowLogin[6];

					//$_SESSION['taxpayer_tin'] = $rowLogin[7];
					$id=1;
					
					//get the open Accounting Period, means only one should be OPEN
					$sqlAccountingPeriod = "SELECT accountingPeriod_dateStart, accountingPeriod_dateEnd FROM tbaccountingperiod 
					WHERE accountingPeriod_status = 'o'";
					
					$resultAccountingPeriod = mysqli_query($connection, $sqlAccountingPeriod) or die("error in search accountingPeriod query");	
					if(mysqli_num_rows($resultAccountingPeriod) > 0){	
						$rowAccountingPeriod = mysqli_fetch_row($resultAccountingPeriod);
						$_SESSION['accountingPeriodStart'] = $rowAccountingPeriod[0];	
						$_SESSION['accountingPeriodEnd'] = $rowAccountingPeriod[1];	
					}else{
						//no accounting period with open status
						$_SESSION['accountingPeriodStart'] = NULL;	
						$_SESSION['accountingPeriodEnd'] = NULL;	
					}
					
					include('oauth2_token.php');
					header ("Location: home.php");		
				
				}else{
					$id = 2; //error in login	
				}	
			}	
					
		}else{
			$id = 2; //error in login			
		}
		
	
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
	background:#9cc1c7;
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
<tr><td align="center">Online Imes System ver1.00</td></tr>
<tr height="30"><td>&nbsp;</td></tr>
<tr><td align="center"></td></tr>
<tr height="15"><td>&nbsp;</td></tr>
</table>


<div class="myborder">
<table width="230" >
	<form id="loginFromID" action="index.php" method="post">		
		<tr>
			<td colspan="2" align="center"><?php if($id==2){echo "wrong password";}?></td>
		</tr>
		<tr>
			<td>Login</td><td><input type="text" name="user" id="user" size="12"></td>			
		</tr>
		<tr>
			<td>Password</td><td><input type="password" name="password" id="password" size="12"></td>
		</tr>
		
		<?php
				// Query to get the current SQL mode
				$query = "SELECT @@GLOBAL.sql_mode AS sql_mode";
				$result = $connection->query($query);
				
				if($result){
					$row = $result->fetch_assoc();
					$sqlMode = $row['sql_mode'];
					
					echo "<tr><td colspan=\"2\">".$sqlMode."</td></tr>";
					
					if(strpos($sqlMode, 'STRICT') !== false){
						//STRICT MODE ON
						
						echo "<tr><td align=\"right\" colspan=\"2\"><input type=\"submit\" name=\"Submit\" value=\"Login\" disabled></td></tr>";
					}else{
						//STRICT MODE OFF
						echo "<tr><td align=\"right\" colspan=\"2\"><input type=\"submit\" name=\"Submit\" value=\"Login\"></td></tr>";
					}
				}
			?>
			
	
	
	
	
	</form>
</table>
</div>


</center>
</body>
</html>