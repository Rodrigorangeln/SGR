<?php
require_once 'db_connect.php';

function retorna($cod_mod, $connect){
	$query = "SELECT cod, modelo from cd_aparelhos where cod = '$cod_mod' limit 1";
	$resultQuery = mysqli_query($connect, $query);
	if($resultQuery->num_rows){
		$row_modelo = mysqli_fetch_assoc($resultQuery);
		$modelo = $row_modelo['modelo'];
	}else{
		$modelo = 'Modelo não encontrado';
	}
	return json_encode($modelo);
}

if(isset($_POST['cod_mod'])){
	echo retorna($_POST['cod_mod'], $connect);
}
