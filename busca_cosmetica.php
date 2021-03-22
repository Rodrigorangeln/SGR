<?php
require_once 'db_connect.php';

$acao = $_POST['acao'];
//$cod_mod = $_POST['cod_mod'];

switch ($acao) {
	case "buscaSerial":
		echo busca_cosmetica($_POST['s1'], $connect);
		break;
	case "grava_cosmetica":
		grava_cosmetica($connect, $_POST['rrm'], $_POST['s1'], $_POST['cosm0'], $_POST['cosm1'], $_POST['cosm2'], $_POST['cosm3'],	$_POST['selec_cosm0'], $_POST['selec_cosm1'], $_POST['selec_cosm2'], $_POST['selec_cosm3']);
		break;
	}


	

function busca_cosmetica($s1, $connect){
	$query = "SELECT s.serial1, s.serial2, s.rrm, s.t_cosm1, s.t_cosm2, s.t_cosm3, s.t_cosm4, a.cod, a.modelo from seriais s, cd_aparelhos a, rrm r
	where a.cod = s.cod_modelo and s.serial1 = '$s1' and r.aberta = '0' and s.local = '4'";

	$resultQuery = mysqli_query($connect, $query);
	if($resultQuery->num_rows){
		$row = mysqli_fetch_assoc($resultQuery);
		$retorno[0] = $row['serial2'];
		$retorno[1] = $row['rrm'];
		$retorno[2] = $row['modelo'];
        $retorno[3] = $row['cod'];
        $retorno[4] = $row['t_cosm1'];
		$retorno[5] = $row['t_cosm2'];
		$retorno[6] = $row['t_cosm3'];
		$retorno[7] = $row['t_cosm4'];

	}else{
		$retorno[0] = 'Serial não encontrado';
	}
	return json_encode($retorno);
}


function grava_cosmetica($connect, $rrm, $s1, $cosm0, $cosm1, $cosm2, $cosm3, $selec_cosm0, $selec_cosm1, $selec_cosm2, $selec_cosm3){
	if ($cosm0 <> ""){
		$query2 = "UPDATE seriais SET dt_cosmetica = now(), local = '5' WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query2);
	}
	if ($cosm1 <> ""){
		$query2 = "UPDATE seriais SET dt_cosmetica = now(), local = '5'  WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query2);
	}
	if ($cosm2 <> ""){
		$query2 = "UPDATE seriais SET dt_cosmetica = now(), local = '5'  WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query2);
	}
	if ($cosm3 <> ""){
		$query2 = "UPDATE seriais SET dt_cosmetica = now(), local = '5'  WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query2);
	}

	if ($selec_cosm0 <> ""){
		$query2 = "UPDATE seriais SET dt_cosmetica = now(), t_cosm1 = '$selec_cosm0', local = '5'  WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query2);
	}
	if ($selec_cosm1 <> ""){
		$query2 = "UPDATE seriais SET dt_cosmetica = now(), t_cosm2 = '$selec_cosm1', local = '5'  WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query2);
	}
	if ($selec_cosm2 <> ""){
		$query2 = "UPDATE seriais SET dt_cosmetica = now(), t_cosm3 = '$selec_cosm2', local = '5'  WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query2);
	}
	if ($selec_cosm3 <> ""){
		$query2 = "UPDATE seriais SET dt_cosmetica = now(), t_cosm4 = '$selec_cosm3', local = '5'  WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query2);
	}

}


