<?php
	session_start();
	include('connectionImes.php');
	
	//open connection
	$connection = mysqli_connect($mysql_host, $mysql_user, $mysql_password, $mysql_database) or die("unable to connect to database");
	$output = '';
	
	//search by date selected			
	$accountDate1Converted = convertMysqlDateFormat($_POST['accountDate1']);
	$accountDate2Converted = convertMysqlDateFormat($_POST['accountDate2']);
	
	$account3 = $_POST['account3s'];
	
	$sqlGetAccount4 = "SELECT account4_date, account4_reference, account4_description, account4_debit, account4_credit 
	FROM tbaccount4 WHERE (account4_account3ID = '$account3') AND (account4_date BETWEEN '$accountDate1Converted' AND '$accountDate2Converted') 
	ORDER BY account4_date ASC, account4_sort ASC, account4_id ASC";	
	$resultGetAccount4 = mysqli_query($connection, $sqlGetAccount4) or die("error in get account4 query");
	
	
	if(mysqli_num_rows($resultGetAccount4)>0){
		$output .= '<table width=\'800\' cellpadding=\'0\' border=\'1\' class=\'mystyle\'>
			<tr bgcolor=\'#EAEAEA\'>
			<td style=\'width:80\'><b>Date</b></td>
			<td style=\'width:520\'><b>Description</b></td>
			<td style=\'width:100\'><b>Debit</b></td>
			<td style=\'width:100\'><b>Credit</b></td>
			</tr>';
			
			while($rowGetAccount4 = mysqli_fetch_array($resultGetAccount4)){
				$output .= '
					<tr class=\'notfirst\'>';
						$dateLabel = date("d/m/Y",strtotime($rowGetAccount4[0]));
					
						$output .='<td><p style=\'font-size:13px\'>'.$dateLabel.'</p></td>';
						
						$descriptionData = $rowGetAccount4[1]."&nbsp;".$rowGetAccount4[2];
						
						$output .='
						<td><p style=\'font-size:13px\'>'.$descriptionData.'</p></td>						
						<td><p style=\'font-size:13px\'>'.$rowGetAccount4[3].'</p></td>						
						<td><p style=\'font-size:13px\'>'.$rowGetAccount4[4].'</p></td>						
					</tr>			
				';
				
				
			}
			$output .= '</table>'; 
			echo $output;



	}else{
		echo "Data not found!";
		
	}









?>