<?php
require_once 'db_connect.php';

$acao = $_POST['acao'];
//$cod_mod = $_POST['cod_mod'];

switch ($acao) {
	case "buscaSerial":
		echo busca_testeinicial($_POST['s1'], $connect);
		break;
	case "buscaSintomas":
		echo busca_sintomas($_POST['cod_mod'], $connect);
		break;
}




function busca_testeinicial($s1, $connect)
{
	$query = "SELECT s.serial1, s.serial2, s.rrm, a.cod, a.modelo from seriais s, cd_aparelhos a, rrm r
	where a.cod = s.cod_modelo and s.serial1 = '$s1' and r.aberta = '0' and s.local = '2'";

	$resultQuery = mysqli_query($connect, $query);
	if ($resultQuery->num_rows) {
		$row = mysqli_fetch_assoc($resultQuery);
		$retorno[0] = $row['serial2'];
		$retorno[1] = $row['rrm'];
		$retorno[2] = $row['modelo'];
		$retorno[3] = $row['cod'];
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
				case "3":
					$retorno[1] = "Serial está na ELÉTRICA";
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
