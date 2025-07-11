<?php	
	session_start();

	if($_SESSION['userID']==""){
		//not logged in
		ob_start();
		header ("Location: index.php");
		ob_flush();
	}

	include('connectionImes.php');
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die ("unable to connect!");	
?>

<html>
<head>
<title>Imes Online System</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="notifications.css" rel="stylesheet" type="text/css"> <!-- Include notifications CSS -->
</head>

<body>
<div class="navbar">
	<?php include('menuPHPImes.php');?>
</div>

<!-- Notification Button -->
<div class="container" style="position: absolute; top: 20px; right: 20px;">
	<input type="checkbox" id="toggle" />
	<label class="button" for="toggle"></label>
	<nav class="nav">
		<h2>Notifications</h2>
		<div class="timeline">
			<div class="timeline__event animated fadeInUp delay-3s timeline__event--type1">
				<div class="timeline__event__icon">
					<i class="lni-cake"></i>
				</div>
				<div class="timeline__event__date">1-5-2025</div>
				<div class="timeline__event__content">
					<div class="timeline__event__title"></div>
					<div class="timeline__event__description">
						<p>Invoice was succesfully validated.</p>
					</div>
				</div>
			</div>
			<!-- Add more timeline events as needed -->
		</div>
	</nav>
</div>

<center>
<table width="800" border="0" cellpadding="0"><tr height="40"><td>&nbsp;</td></tr></table>
<br><br><br><br><br>
<div>
<img src="images/mainpicture1.jpg" width="400" height="266">
</div>

<table width="300" border="0" cellpadding="0">
<tr height="30"><td width="90">Ver 1.00</td><td width="210" align="left"><?php echo "Login:&nbsp;".$_SESSION['userName']?></td></tr>
<tr height="30"><td colspan="2"></td></tr>
<tr><td colspan="2"></td></tr>
</table>

<form action="home.php" method="post">
<table border="0" cellpadding="0" width="200">
<tr><td colspan="2"></td></tr>
<tr><td></td><td></td></tr>
<tr><td colspan="2"></td></tr>
</table>
</form>
</center>
</body>
</html>