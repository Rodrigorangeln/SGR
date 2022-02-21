<?php
session_start();
$user = $_SESSION['user'];
require_once 'db_connect.php';

$acao = $_POST['acao'];
//$cod_mod = $_POST['cod_mod'];

switch ($acao) {
	case "buscaSerial":
		echo busca_teste($_POST['s1'], $connect);
		break;
	case "buscaSintomas":
		echo busca_sintomas($_POST['cod_mod'], $connect);
		break;
	case "aprovar":
		aprovado($user, $_POST['s1'], $connect);
		break;
	case "reprovar":
		reprovado($user, $_POST['s1'], $_POST['rrm'], $_POST['def_eletrico'], $_POST['cosm0'], $_POST['cosm1'], $_POST['cosm2'], $_POST['cosm3'], $_POST['elet0'], $_POST['elet1'], $connect);
		break;
	case "semConserto":
		semConserto($user, $_POST['s1'], $_POST['rrm'], $connect);
		break;
}




function busca_teste($s1, $connect)
{
	$query = "SELECT s.serial1, s.serial2, s.rrm, a.cod, a.modelo from seriais s, cd_aparelhos a, rrm r
	where a.cod = s.cod_modelo and s.serial1 = '$s1' and r.aberta = '0' and s.local = '5'";

	$resultQuery = mysqli_query($connect, $query);
	if ($resultQuery->num_rows) {
		$row = mysqli_fetch_assoc($resultQuery);
		$retorno[0] = $row['serial2'];
		$retorno[1] = $row['rrm'];
		$retorno[2] = $row['modelo'];
		$retorno[3] = $row['cod'];

		$queryReprov = "SELECT * FROM reprov WHERE serial = '$s1' AND rrm = '$retorno[1]' ORDER BY id DESC LIMIT 1";
		$resultQueryReprov = mysqli_query($connect, $queryReprov);
		if ($resultQueryReprov->num_rows)
			$retorno['reprovado'] = 1;
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
				case "3":
					$retorno[1] = "Serial está na ELÉTRICA";
					break;
				case "4":
					$retorno[1] = "Serial está na COSMÉTICA";
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


function busca_sintomas($cod_mod, $connect)
{
	$query2 = "SELECT distinct sintoma from cd_eletrica where cod_mod = '$cod_mod' order by sintoma";
	mysqli_set_charset($connect, "utf8");
	$resultQuery = mysqli_query($connect, $query2);
	$return = array();
	while ($rows = mysqli_fetch_assoc($resultQuery)) {
		array_push($return, $rows['sintoma']);
	}
	return json_encode($return);
}

function aprovado($user, $s1, $connect)
{
	$query3 = "UPDATE seriais SET user_testefinal = '$user', dt_testefinal = now(), local = '6' WHERE serial1 = '$s1'";
	mysqli_query($connect, $query3);
}

function reprovado($user, $s1, $rrm, $def_eletrico, $cosm0, $cosm1, $cosm2, $cosm3, $elet0, $elet1, $connect)
{

	$queryReprov = "INSERT INTO reprov SET 
	posto = 'teste_final',
	serial = '$s1', 
	rrm = '$rrm',
	user = '$user', 
	data = now(), 
	cosm1 = '$cosm0', 
	cosm2 = '$cosm1', 
	cosm3 = '$cosm2', 
	cosm4 = '$cosm3', 
	eletr1 = '$elet0', 
	eletr2 = '$elet1'";

	mysqli_query($connect, $queryReprov);

	if ($def_eletrico == 1) {
		$query = "UPDATE seriais SET local = '3' WHERE serial1 = '$s1'";
		mysqli_query($connect, $query);
	} else {
		$query = "UPDATE seriais SET local = '4' WHERE serial1 = '$s1'";
		mysqli_query($connect, $query);
	}
}

function semconserto($user, $s1, $rrm, $connect)
{
	$query_semconserto = "UPDATE seriais SET local = '6', semconserto = 'teste final', user_semconserto = '$user', dt_semconserto = now() WHERE serial1 = '$s1' and rrm = '$rrm' ";
	mysqli_query($connect, $query_semconserto);
}
