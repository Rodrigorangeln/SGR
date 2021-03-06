<?php
session_start();
$user = $_SESSION['user'];
require_once 'db_connect.php';
date_default_timezone_set('Brazil/East');

$acao = $_POST['acao'];
//$cod_mod = $_POST['cod_mod'];

switch ($acao) {
	case "buscaSerial":
		echo busca_eletrica($_POST['s1'], $connect);
		break;
	case "buscaComponentes":
		busca_componentes($_POST['cod_mod'], $_POST['cod_sintoma'], $connect);
		break;
	case "grava_eletrica":
		grava_eletrica($user, $_POST['s1'], $_POST['rrm'], $_POST['defeito1'], $_POST['defeito2'], $_POST['defeito3'], $_POST['componente1'], $_POST['componente2'], $_POST['componente3'], $_POST['radio1'], $_POST['radio2'], $_POST['radio3'], $_POST['reprovado'], $connect);
		break;
	case "semConserto":
		semConserto($user, $_POST['s1'], $_POST['rrm'], $connect);
		break;
}



function busca_eletrica($s1, $connect)
{
	$query = "SELECT s.serial1, s.serial2, s.rrm, s.t_eletr1, s.t_eletr2, a.cod, a.modelo from seriais s, cd_aparelhos a, rrm r
	where a.cod = s.cod_modelo and s.serial1 = '$s1' and r.aberta = '0' and s.local = '3'";
	mysqli_set_charset($connect, "utf8");
	$resultQuery = mysqli_query($connect, $query);
	if ($resultQuery->num_rows) {
		$row = mysqli_fetch_assoc($resultQuery);
		$retorno[0] = $row['serial2'];
		$retorno[1] = $row['rrm'];
		$retorno[2] = $row['modelo'];
		$retorno[3] = $row['cod'];
		$retorno[4] = $row['t_eletr1'];
		$retorno[5] = $row['t_eletr2'];

		$queryReprov = "SELECT * FROM reprov WHERE serial = '$s1' AND rrm = '$retorno[1]' AND eletr1 != '' ORDER BY id DESC LIMIT 1";
		$resultQueryReprov = mysqli_query($connect, $queryReprov);
		$rowreprov = mysqli_fetch_assoc($resultQueryReprov);
		if ($resultQueryReprov->num_rows) {
			$retorno['reprovado'] = 1;
			$retorno[4] = $rowreprov['eletr1'];
			$retorno[5] = $rowreprov['eletr2'];
		}
	} else {
		$retorno[0] = 'Serial não encontrado';
		$query = "SELECT rrm, local from seriais where serial1 = '$s1'";
		$resultQuery = mysqli_query($connect, $query);

		if ($resultQuery->num_rows) {
			$row = mysqli_fetch_assoc($resultQuery);
			switch ($row['local']) {
				case "1":
					$retorno[1] = "Serial está na RECEPÇÃO";
					break;
				case "2":
					$retorno[1] = "Serial está no TESTE INICIAL";
					break;
				case "4":
					$retorno[1] = "Serial está na COSMÉTICA";
					break;
				case "5":
					$retorno[1] = "Serial está no TESTE FINAL";
					break;
				case "6":
					$retorno[1] = "Serial está na EMBALAGEM";
					break;
				case "7":
					$retorno[1] = "Serial está na EXPEDIÇÃO";
					break;
			}
			$retorno[2] = "RRM " . $row['rrm'];
		} else {
			$retorno[1] = "Serial INEXISTENTE";
			$retorno[2] = "";
		}
	}
	return json_encode($retorno);
}


function busca_componentes($cod_mod, $cod_sintoma, $connect)
{
	$query2 = "SELECT CREF, componente from cd_eletrica where cod_mod = '$cod_mod' and cod_sintoma = '$cod_sintoma' order by componente";
	mysqli_set_charset($connect, "utf8");
	$resultQuery2 = mysqli_query($connect, $query2);
	$return = array();
	while ($rows = mysqli_fetch_assoc($resultQuery2)) {
		array_push($return, $rows['componente']);
	}

	echo json_encode($return);
}


function grava_eletrica($user, $s1, $rrm, $defeito1, $defeito2, $defeito3, $componente1, $componente2, $componente3, $radio1, $radio2, $radio3, $reprovado, $connect)
{
	if ($reprovado == 0) {
		/* $query3 = "UPDATE seriais SET user_eletrica = '$user', dt_eletrica = now(), t_eletr1 = '$defeito1', eletr1comp = '$componente1', eletr1interv = '$radio1', local = '4' WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $query3);

		if ($defeito2 <> "") {
			$query3 = "UPDATE seriais SET t_eletr2 = '$defeito2', eletr2comp = '$componente2', eletr2interv = '$radio2', local = '4' WHERE serial1 = '$s1' and rrm = '$rrm'";
			mysqli_query($connect, $query3);
		} else {
			$query3 = "UPDATE seriais SET t_eletr2 = '$defeito3', eletr2comp = '$componente3', eletr2interv = '$radio3', local = '4' WHERE serial1 = '$s1' and rrm = '$rrm'";
			mysqli_query($connect, $query3);
		} */
		$queryInsert = "INSERT INTO reparo_eletrico SET
		rrm = '$rrm',
		serial1 = '$s1',
		defeito = '$defeito1',
		componente = '$componente1',
		intervencao = '$radio1',
		date = now(),
		user = '$user'";
		mysqli_query($connect, $queryInsert);

		if ($defeito2 <> "") {
			$queryInsert = "INSERT INTO reparo_eletrico SET
		rrm = '$rrm',
		serial1 = '$s1',
		defeito = '$defeito2',
		componente = '$componente2',
		intervencao = '$radio2',
		date = now(),
		user = '$user'";
			mysqli_query($connect, $queryInsert);
		}

		if ($defeito3 <> "") {
			$queryInsert = "INSERT INTO reparo_eletrico SET
		rrm = '$rrm',
		serial1 = '$s1',
		defeito = '$defeito3',
		componente = '$componente3',
		intervencao = '$radio3',
		date = now(),
		user = '$user'";
		mysqli_query($connect, $queryInsert);
	}
	
	$queryLocal = "UPDATE seriais SET local = '4' WHERE serial1 = '$s1' and rrm = '$rrm'";
	mysqli_query($connect, $queryLocal);

	} else {
		$query = "INSERT INTO reprov SET 
		posto = 'eletrica', 
		serial = '$s1', 
		rrm = '$rrm', 
		user = '$user', 
		data = now(), 
		cosm1 = '', 
		cosm2 = '', 
		cosm3 = '', 
		cosm4 = '', 
		eletr1 = '$defeito1', 
		eletr1comp = '$componente1', 
		eletr1interv = '$radio1',
		eletr2 = '$defeito2', 
		eletr2comp = '$componente2', 
		eletr2interv = '$radio2', 
		eletr3 = '$defeito3', 
		eletr3comp = '$componente3', 
		eletr3interv = '$radio3'";

		$queryposto = "UPDATE seriais SET local = '4' WHERE serial1 = '$s1' and rrm = '$rrm'";
		mysqli_query($connect, $queryposto);

		mysqli_query($connect, $query);
	}
}

function semconserto($user, $s1, $rrm, $connect)
{
	$query_semconserto = "UPDATE seriais SET local = '6', semconserto = 'eletrica', user_semconserto = '$user', dt_semconserto = now() WHERE serial1 = '$s1' and rrm = '$rrm' ";
	mysqli_query($connect, $query_semconserto);
}
