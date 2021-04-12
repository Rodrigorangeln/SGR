<?php
require_once 'db_connect.php';

$acao = $_POST['acao'];


switch ($acao) {
    case "produtividade":
        echo produtividade($connect, $_POST['colab1'], $_POST['colab2'], $_POST['dtInicio'], $_POST['dtFinal']);
        break;
    case "serial":
        echo serial($connect, $_POST['serial']);
        break;
}



function produtividade($connect, $colab1, $colab2, $dtInicio, $dtFinal)
{

    $nome = Explode(" ", $colab1);
    $registration = $nome[0];

    $query_prod = "SELECT count(serial1) FROM seriais 
    WHERE user_entr = '$registration' AND dt_entr BETWEEN '$dtInicio' AND '$dtFinal';";

    $resultQuery = mysqli_query($connect, $query_prod);
    $row = mysqli_fetch_assoc($resultQuery);
    $retorno_prod[0] = $row['count(serial1)'];

    if ($colab2 <> "") {
        $nome = Explode(" ", $colab2);
        $registration = $nome[0];

        $query = "SELECT count(serial1) FROM seriais 
    WHERE user_entr = '$registration' AND dt_entr BETWEEN '$dtInicio' AND '$dtFinal';";

        $resultQuery = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($resultQuery);
        $retorno_prod[1] = $row['count(serial1)'];
    }

    return json_encode($retorno_prod);
}

function serial($connect, $serial)
{
    $query_serial = "SELECT * FROM seriais WHERE serial1 = '$serial';";

    $resultQuery = mysqli_query($connect, $query_serial);
    $row_serial = mysqli_fetch_assoc($resultQuery);

    $retorno_serial['rrm'] = $row_serial['rrm'];
    $retorno_serial['dt_input'] = $row_serial['dt_entr'];
    $retorno_serial['func_input'] = buscaColaborador($connect, $row_serial['user_entr']);
    $retorno_serial['dt_testeinicial'] = $row_serial['dt_testeinicial'];
    $retorno_serial['func_testeinicial'] = buscaColaborador($connect, $row_serial['user_testeinicial']);
    $retorno_serial['dt_eletrica'] = $row_serial['dt_eletrica'];
    $retorno_serial['func_eletrica'] = buscaColaborador($connect, $row_serial['user_eletrica']);
    $retorno_serial['dt_cosmetica'] = $row_serial['dt_cosmetica'];
    $retorno_serial['func_cosmetica'] = buscaColaborador($connect, $row_serial['user_cosmetica']);
    $retorno_serial['dt_testefinal'] = $row_serial['dt_testefinal'];
    $retorno_serial['func_testefinal'] = buscaColaborador($connect, $row_serial['user_testefinal']);

    return json_encode($retorno_serial);
}

function buscaColaborador($connect, $registration)
{
    $query_colab = "SELECT name FROM cd_usuarios WHERE registration = '$registration';";
    $resultQuery_colab = mysqli_query($connect, $query_colab);
    $row_colab = mysqli_fetch_assoc($resultQuery_colab);

    if ($row_colab <> ""){
        return ($row_colab['name']);
    } else {
        return ('-');
    }
}
