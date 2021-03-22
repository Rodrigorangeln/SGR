<?php
require_once 'db_connect.php';
include 'buscaModelo.php';

$acao = $_POST['acao'];
//$cod_mod = $_POST['cod_mod'];

switch ($acao) {
	case "modalRRM":
		modalRRM($_POST['rrm'], $connect);
		break;
	}


function modalRRM($rrm, $connect){
  $query = "SELECT * FROM recep_nf WHERE RRM = $rrm";

	$resultQuery = mysqli_query($connect, $query);
  //if($resultQuery->num_rows){
    //$row = mysqli_fetch_assoc($resultQuery);
  $i = 0;
  while ($row = mysqli_fetch_assoc($resultQuery)){

    $modelo = $row['cod_modelo'];
    $query2 = "SELECT COUNT(rrm) FROM seriais WHERE rrm = '$rrm' and cod_modelo = '$modelo'";
    $resultQuery2 = mysqli_query($connect, $query2);
    $resultCount = mysqli_fetch_assoc($resultQuery2);
    $retorno['quantDigitada'][$i] = $resultCount['COUNT(rrm)'];

    
    $retorno['cod_cliente'] = $row['cod_cliente'];
    $retorno['nf'] = $row['nf'];

    $retorno['cod_mod'][$i] = $row['cod_modelo'];
    $retorno['mod'][$i] = retorna($row['cod_modelo'], $connect);
    $retorno['quant'][$i] = $row['quant'];
    $i++;
	}
	return json_encode($retorno);
}

echo modalRRM($_POST['rrm'], $connect);


//mysqli_close($connect);

?>



