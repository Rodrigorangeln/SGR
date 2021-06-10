<?php
require_once 'db_connect.php';

$acao = $_POST['acao'];


switch ($acao) {
    case "produtividade":
        echo produtividade($connect, $_POST['posto'], $_POST['colab1'], $_POST['colab2'], $_POST['dtInicio'], $_POST['dtFinal']);
        break;
    case "serial":
        echo serial($connect, $_POST['serial']);
        break;
}



function produtividade($connect, $posto, $colab1, $colab2, $dtInicio, $dtFinal)
{
    $retorno_prod[2] = $posto;

    $nome = Explode(" ", $colab1);
    $registration = $nome[0];

    $query_prod = posto($posto, $registration, $dtInicio, $dtFinal);


    $resultQuery = mysqli_query($connect, $query_prod);
    $row = mysqli_fetch_assoc($resultQuery);
    $retorno_prod[0] = $row['count(serial1)'];

    if ($colab2 <> "") {
        $nome = Explode(" ", $colab2);
        $registration = $nome[0];

        $query = posto($posto, $registration, $dtInicio, $dtFinal);

        $resultQuery = mysqli_query($connect, $query);
        $row = mysqli_fetch_assoc($resultQuery);
        $retorno_prod[1] = $row['count(serial1)'];
    }

    return json_encode($retorno_prod);
}

function posto($posto, $registration, $dtInicio, $dtFinal)
{
    if ($posto == "Recepção") {
        $sql = "SELECT count(serial1) FROM seriais 
        WHERE user_entr = '$registration' AND dt_entr BETWEEN '$dtInicio' AND '$dtFinal';";
    }
    if ($posto == "Teste Inicial") {
        $sql = "SELECT count(serial1) FROM seriais 
        WHERE user_testeinicial = '$registration' AND dt_testeinicial BETWEEN '$dtInicio' AND '$dtFinal';";
    }
    if ($posto == "Elétrica") {
        $sql = "SELECT count(serial1) FROM seriais 
        WHERE user_eletrica = '$registration' AND dt_eletrica BETWEEN '$dtInicio' AND '$dtFinal';";
    }
    if ($posto == "Cosmética") {
        $sql = "SELECT count(serial1) FROM seriais 
        WHERE user_cosmetica = '$registration' AND dt_cosmetica BETWEEN '$dtInicio' AND '$dtFinal';";
    }
    if ($posto == "Teste Final") {
        $sql = "SELECT count(serial1) FROM seriais 
        WHERE user_testefinal = '$registration' AND dt_testefinal BETWEEN '$dtInicio' AND '$dtFinal';";
    }
    if ($posto == "Embalagem") {
        $sql = "SELECT count(id) FROM embalagem 
        WHERE user = '$registration' AND data BETWEEN '$dtInicio' AND '$dtFinal';";
    }
    if ($posto == "Expedição") {
        $sql = "SELECT count(caixa) FROM expedicao 
        WHERE user = '$registration' AND data BETWEEN '$dtInicio' AND '$dtFinal';";
    }
    return ($sql);
}

function serial($connect, $serial)
{
    $query_serial = "SELECT * FROM seriais WHERE serial1 = '$serial';";
    $resultQuery = mysqli_query($connect, $query_serial);
    if ($resultQuery->num_rows) {
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
        $caixa = $row_serial['n_caixa'];
        
        $query_embalagem = "SELECT data, user FROM embalagem WHERE n_caixa = '$caixa';";
        $sqlEmbalagem = mysqli_query($connect, $query_embalagem);
        if ($sqlEmbalagem->num_rows) {
            $row_embalagem = mysqli_fetch_assoc($sqlEmbalagem);
            $retorno_serial['dt_embalagem'] = $row_embalagem['data'];
            $retorno_serial['func_embalagem'] = buscaColaborador($connect, $row_embalagem['user']);
        }
        
        $query_expedicao = "SELECT data_expedicao, user FROM expedicao WHERE caixa = '$caixa';";
        $sqlExpedicao = mysqli_query($connect, $query_expedicao);
        if ($sqlExpedicao->num_rows) {
            $row_expedicao = mysqli_fetch_assoc($sqlExpedicao);
            $retorno_serial['dt_expedicao'] = $row_expedicao['data_expedicao'];
            $retorno_serial['func_expedicao'] = buscaColaborador($connect, $row_expedicao['user']);
        }
        
        return json_encode($retorno_serial);
    } else {
        return json_encode('0');
    }
}



function buscaColaborador($connect, $registration)
{
    $query_colab = "SELECT name FROM cd_usuarios WHERE registration = '$registration';";
    $resultQuery_colab = mysqli_query($connect, $query_colab);
    $row_colab = mysqli_fetch_assoc($resultQuery_colab);

    if ($row_colab <> "") {
        return ($row_colab['name']);
    } else {
        return ('-');
    }
}
