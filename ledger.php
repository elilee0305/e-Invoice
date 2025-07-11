<?php
	session_start();
	if ($_SESSION['userID'] == "") {
		// not logged in
		ob_start();
		header("Location: index.php");
		ob_flush();
	}
	include('connectionImes.php');

	/* set the proper error reporting mode */
	mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

	// open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect!");

	// Fetch ledger data
	$sqlLedger = "SELECT account_date, account_description, account_debit, account_credit, account_balance 
				  FROM tbledger ORDER BY account_date ASC";
	$resultLedger = mysqli_query($connection, $sqlLedger) or die("error in ledger query");
?>
<html>
<head>
<title>Ledger</title>
<link href="js/menuCSS.css" rel="stylesheet" type="text/css">
<link href="js/jquery-ui.css" rel="stylesheet" type="text/css">
<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/jquery-ui.min.js"></script>
<style type="text/css">
table.mystyle {
	overflow: auto;
	width: 100%;
	border-width: 0 0 1px 1px;
	border-spacing: 0;
	border-collapse: collapse;
	border-style: solid;
	border-color: #CDD0D1;
	font-size: 12px;
}
.mystyle thead {
	position: sticky;
	top: 0;
	background-color: #f2f2f2;
	z-index: 1;
}
.mystyle td, .mystyle th {
	margin: 0;
	padding: 8px;
	border-width: 1px 1px 0 0;
	border-style: solid;
	border-color: #CDD0D1;
	text-align: left;
}
.mystyle th {
	background-color: #e9ecef;
	font-weight: bold;
}
.notfirst:hover {
	background-color: #E1ECEE;
}
</style>
</head>
<body>
<center>
<div class="navbar">
	<?php include 'menuPHPImes.php'; ?>
</div>
<table width="800" border="0" cellpadding="0"><tr height="80"><td>&nbsp;</td></tr></table>

<h1 style="text-align: center; margin-bottom: 20px;">Accounting Ledger</h1>

<div style="margin: 20px;"> <!-- Added margin around the table -->
<?php
	if (mysqli_num_rows($resultLedger) > 0) {
		echo "<table class='mystyle'>";
		echo "<thead><tr>";
		echo "<th style='width:150px'>Date</th>";
		echo "<th style='width:300px'>Description</th>";
		echo "<th style='width:150px'>Debit</th>";
		echo "<th style='width:150px'>Credit</th>";
		echo "<th style='width:150px'>Balance</th>";
		echo "</tr></thead>";
		echo "<tbody>";

		while ($rowLedger = mysqli_fetch_row($resultLedger)) {
			echo "<tr class='notfirst'>";
			echo "<td>" . date("d/m/Y", strtotime($rowLedger[0])) . "</td>";
			echo "<td>" . htmlspecialchars($rowLedger[1]) . "</td>";
			echo "<td align='right'>" . number_format($rowLedger[2], 2) . "</td>";
			echo "<td align='right'>" . number_format($rowLedger[3], 2) . "</td>";
			echo "<td align='right'>" . number_format($rowLedger[4], 2) . "</td>";
			echo "</tr>";
		}

		echo "</tbody>";
		echo "</table>";
	} else {
		echo "<p>No ledger records found.</p>";
	}
?>
</div> <!-- End of margin wrapper -->
</center>
</body>
</html>
