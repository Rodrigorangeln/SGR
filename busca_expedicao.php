<?php
session_start();
$user = $_SESSION['user'];
require_once 'db_connect.php';

$acao = $_POST['acao'];

switch ($acao) {
    case "busca_nf":
        echo busca_nf($_POST['nf'], $connect);
        break;
    case "busca_caixa":
        echo busca_caixa($_POST['caixas'], $connect);
        break;
    case "grava_caixas":
        echo grava_caixas($_POST['nf_saida'],$_POST['caixas'], $user, $connect);
        break;
    case "grava_data_expedicao":
        echo grava_data_expedicao($_POST['nf_saida'],$_POST['date'], $connect);
        break;
}



function busca_nf($nf, $connect)
{
    $query = "SELECT nf_saida FROM expedicao WHERE nf_saida = '$nf'";
    $resultQuery = mysqli_query($connect, $query);
    if ($resultQuery->num_rows) {
        $retorno = '1';
    } else {
        $retorno = '0';
    }
    return json_encode($retorno);
}


function busca_caixa($caixas, $connect)
{
    foreach ($caixas as $cx) {
        $query = "SELECT n_caixa FROM embalagem WHERE n_caixa = '$cx'";
        $resultQuery = mysqli_query($connect, $query);
        if (!$resultQuery->num_rows) {
            $retorno = $cx;
        } 

    }
    return json_encode($retorno);
}

function grava_caixas($nf_saida, $caixas, $user, $connect)
{
    foreach ($caixas as $cx) {
        $query = "INSERT INTO expedicao (nf_saida, caixa, data_expedicao, user, data) values ('$nf_saida', '$cx', now(), '$user', null)";
        mysqli_query($connect, $query);

    }

}


function grava_data_expedicao($nf_saida, $date, $connect)
{
        $query = "UPDATE expedicao SET data = '$date' WHERE nf_saida = '$nf_saida'";
        mysqli_query($connect, $query);

}
