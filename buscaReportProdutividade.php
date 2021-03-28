<?php
require_once 'db_connect.php';

$acao = $_POST['acao'];


switch ($acao) {
    case "produtividade":
        echo produtividade($connect, $_POST['colab1'], $_POST['colab2'], $_POST['dtInicio'], $_POST['dtFinal']);
        break;
}



function produtividade($connect, $colab1, $colab2, $dtInicio, $dtFinal)
{

    $nome = Explode(" ", $colab1);
    $registration = $nome[0];

    $query = "SELECT count(serial1) FROM seriais 
    WHERE user_entr = '$registration' AND dt_entr BETWEEN '$dtInicio' AND '$dtFinal';";

    $resultQuery = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($resultQuery);
    $retorno[0] = $row['count(serial1)'];

    if ($colab2 <> "") {
        $nome = Explode(" ", $colab2);
        $registration = $nome[0];

        $query = "SELECT count(serial1) FROM seriais 
    WHERE user_entr = '$registration' AND dt_entr BETWEEN '$dtInicio' AND '$dtFinal';";

        $resultQuery = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($resultQuery);
        $retorno[1] = $row['count(serial1)'];
    }

    return json_encode($retorno);
}
