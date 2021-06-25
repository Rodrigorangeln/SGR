<?php
session_start();
$user = $_SESSION['user'];
require_once 'db_connect.php';

$acao = $_POST['acao'];
//$cod_mod = $_POST['cod_mod'];

switch ($acao) {
	case "buscaSerial":
		echo busca_serial($_POST['s1'], $connect);
		break;
	case "verifica-duplicidade":
		echo verificaDuplicidade($_POST['newSerial'], $connect);
		break;
	case "alteraSerial":
		alteraSerial($user, $_POST['oldSerial'], $_POST['newSerial'], $connect);
		break;
	case "inverteSeriais":
		inverteSeriais($user, $_POST['s1'], $_POST['s2'], $connect);
		break;
	case "buscaCaixa":
		echo buscaCaixa($_POST['caixa'], $connect);
		break;
}



function busca_serial($s1, $connect)
{
	$query = "SELECT s.serial1, s.serial2, s.rrm, s.t_eletr1, a.cod, a.modelo from seriais s, cd_aparelhos a
	where a.cod = s.cod_modelo and s.serial1 = '$s1'";
	mysqli_set_charset($connect, "utf8");
	$resultQuery = mysqli_query($connect, $query);
	if ($resultQuery->num_rows) {
		$row = mysqli_fetch_assoc($resultQuery);
		$retorno[0] = $row['serial2'];
		$retorno[1] = $row['modelo'];
		$retorno[2] = $row['cod'];
	} else {
		$retorno[0] = 'Serial não encontrado';
	}
	return json_encode($retorno);
}


function verificaDuplicidade($newSerial, $connect)
{
	$query = "SELECT serial1, serial2 from seriais
	where serial1 = '$newSerial' or serial2 = '$newSerial'";
	//mysqli_set_charset($connect,"utf8");
	$resultQuery = mysqli_query($connect, $query);
	if ($resultQuery->num_rows) {
		$retorno = 1;
	}

	return ($retorno);
}


function alteraSerial($user, $oldSerial, $newSerial, $connect)
{

	$query = "UPDATE seriais SET serial1 = '$newSerial' WHERE serial1 = '$oldSerial'";
	mysqli_query($connect, $query);

	$query2 = "UPDATE seriais SET serial2 = '$newSerial' WHERE serial2 = '$oldSerial'";
	mysqli_query($connect, $query2);

	$query3 = "INSERT INTO log_seriais VALUES ('$oldSerial', '$newSerial', now(), '$user')";
	mysqli_query($connect, $query3);
}

function inverteSeriais($user, $s1, $s2, $connect)
{
	$queryInverte1 = "UPDATE seriais SET serial1 = '$s2' WHERE serial1 = '$s1'";
	$queryLog1 = "INSERT INTO log_seriais VALUES ('$s1', '$s2', now(), '$user')";
	$queryInverte2 = "UPDATE seriais SET serial2 = '$s1' WHERE serial1 = '$s1'";
	$queryLog2 = "INSERT INTO log_seriais VALUES ('$s2', '$s1', now(), '$user')";
	mysqli_query($connect, $queryInverte2);
	mysqli_query($connect, $queryInverte1);
	mysqli_query($connect, $queryLog1);
	mysqli_query($connect, $queryLog2);
}

function buscaCaixa($caixa, $connect)
{
	$query = "SELECT serial1, serial2, cod_modelo FROM seriais WHERE n_caixa = '$caixa'";
	$resultQuery = mysqli_query($connect, $query);
	$retorno['s1'] = array();
	$retorno['s2'] = array();
	$retorno['cod_mod'] = array();
	$cod = 0;

	while ($rows = mysqli_fetch_assoc($resultQuery)) {
		array_push($retorno['s1'], $rows['serial1']);
		array_push($retorno['s2'], $rows['serial2']);
		$cod = $rows['cod_modelo'];
	}

	$query = "SELECT cod_mod FROM cd_aparelhos WHERE cod = '$cod'";
    $resultQuery_aparelho = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($resultQuery_aparelho);
	array_push($retorno['cod_mod'], $row['cod_mod']);

	return json_encode($retorno);
}
