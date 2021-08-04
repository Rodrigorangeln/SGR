<?php
session_start();
$user = $_SESSION['user'];
require_once 'db_connect.php';

$acao = $_POST['acao'];

switch ($acao) {
    case "busca_cliente":
        echo busca_cliente($_POST['cliente'], $connect);
        break;
    case "cria_caixa":
        cria_caixa($_POST['cliente'], $connect);
        break;
    case "numero_caixa":
        echo cria_caixa($connect);
        break;
    case "busca_serial":
        echo busca_serial($_POST['serial1'], $_POST['cliente'], $_POST['modelo'], $connect);
        break;
    case "busca_modelo":
        echo busca_modelo($_POST['cod'], $connect);
        break;
    case "atualiza_seriais":
        atualiza_seriais($user, $_POST['n_caixa'], $_POST['quant'], $_POST['seriais'], $_POST['smartcards'], $connect);
}



function busca_cliente($cliente, $connect)
{
    $query = "SELECT r.cod_cliente FROM recep_nf r, seriais s WHERE r.cod_cliente = '$cliente' AND r.rrm = s.rrm AND s.local = '6'";
    $resultQuery = mysqli_query($connect, $query);
    if ($resultQuery->num_rows) {

        $query = "SELECT DISTINCT s.cod_modelo, a.modelo FROM cd_aparelhos a, recep_nf r, seriais s WHERE s.cod_modelo = a.cod AND r.cod_cliente = '$cliente' AND r.rrm = s.rrm AND s.local = '6'";
        $resultQuery2 = mysqli_query($connect, $query);
        $retorno = array();
        while ($rows = mysqli_fetch_assoc($resultQuery2)) {
            //array_push ($retorno_mod, $rows['cod_modelo']." - ".$rows["modelo"]);
            $modelos = $rows['cod_modelo'] . " - " . $rows["modelo"];
            array_push($retorno, $modelos);
        }

        //$retorno = '1';
    } else {
        $retorno = '0';
    }
    return json_encode($retorno);
}



function cria_caixa($connect)
{
    $query = "select n_caixa from embalagem ORDER BY n_caixa DESC limit 1";

    $resultQuery3 = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($resultQuery3);
    $num_caixa = $row['n_caixa'];
    if ($num_caixa == '9999A') {    //Implementar série C em diante.
        $num_caixa = '0001B';
    }
    $serie = substr($num_caixa, 4, 1);
    $num_caixa = substr($num_caixa, 0, 4);
    ++$num_caixa;
    $num_caixa_final = str_pad($num_caixa, 4, "0", STR_PAD_LEFT) . $serie;
    return json_encode($num_caixa_final);
}

function busca_serial($serial1, $cliente, $modelo, $connect)
{
    $retorno = "";

    $query = "select serial2 from seriais where serial1 = '$serial1' and local = '6'";
    $resultQuery_embalagem = mysqli_query($connect, $query);
    $row_embalagem = mysqli_fetch_assoc($resultQuery_embalagem);

    if ($resultQuery_embalagem->num_rows) { //SE SERIAL ESTÁ NO SETOR EMBALAGEM
        $retorno = $row_embalagem['serial2'];

        $query = "select serial1 from seriais where serial1 = '$serial1' and rrm in(select rrm from recep_nf where cod_cliente = '$cliente')";
        $resultQuery_cliente = mysqli_query($connect, $query);
        if ($resultQuery_cliente->num_rows) { // SE SERIAL É DO CLIENTE

            $cod_modelo = substr($modelo, 0, 8);
            $query = "select serial1 from seriais where serial1 = '$serial1' and cod_modelo = '$cod_modelo'";
            $resultQuery_modelo = mysqli_query($connect, $query);
            if ($resultQuery_modelo->num_rows) { // SE SERIAL É DO MODELO

                $query = "select n_caixa from seriais where serial1 = '$serial1'";
                $resultQuery_jaembalado = mysqli_query($connect, $query);
                $row_jaembalado = mysqli_fetch_assoc($resultQuery_jaembalado);
                if ($row_jaembalado['n_caixa'] <> "") { // SE SERIAL JÁ FOI EMBALADO
                    $retorno = "erro-jaembalado";
                } else {
                }
            } else {
                $retorno = "erro-modelo";
            }
        } else {
            $retorno = "erro-cliente";
        }
    } else {
        $retorno = "erro-embalagem";
    }



    return json_encode($retorno);
}


function busca_modelo($cod, $connect)
{
    $query = "select cod_mod from cd_aparelhos where cod = '$cod'";
    $resultQuery_aparelho = mysqli_query($connect, $query);
    $row = mysqli_fetch_assoc($resultQuery_aparelho);
    $cod_mod = $row['cod_mod'];
    return json_encode($cod_mod);
}


function atualiza_seriais($user, $n_caixa, $quant, $seriais, $smartcards, $connect)
{
    $tamArray = count($seriais);

    for ($i = 0; $i < $tamArray; $i++) {
        $sqlUpdate = "UPDATE seriais SET n_caixa = '$n_caixa', smartcard = '$smartcards[$i]', local = '7' WHERE serial1 = '$seriais[$i]' ";
        mysqli_query($connect, $sqlUpdate);
    }

    if ($smartcards[0] <> null){
        $temSmart = 1;
    } else {
        $temSmart = 0;
    }

    $sqlEmbalagem = "INSERT INTO embalagem SET user = $user, n_caixa = '$n_caixa', quant = '$quant', smartcard = '$temSmart', data = now() ";
    mysqli_query($connect, $sqlEmbalagem);
}
