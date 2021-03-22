<?php
require_once 'db_connect.php';
header('Content-type: application/json charset=utf-8');


function serial_duplicado($s1, $connect){
	$serial = null;
	//$s1 = (string) TRUE; 
	/* $query = "SELECT rrm, serial1, serial2 from seriais where rrm = $rrm and serial1 = $s1 or serial2 = $s1"; */
	$query = "SELECT rrm, serial1, serial2 from seriais where local <> '0' and serial1 = '$s1' or serial2 = '$s1'";
	$resultQuery = mysqli_query($connect, $query);
	if($resultQuery->num_rows){
		$row = mysqli_fetch_assoc($resultQuery);
		$serial = $row['serial1'];
		//$serial = '1'; 
	}
	else{
		$serial = '0';
		//var_export($serial);
		//print_r($serial);
		//var_dump ($serial);
	}
	return json_encode($serial);

}

	echo serial_duplicado($_POST['s1'], $connect);
