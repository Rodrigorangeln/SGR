<?php
require_once 'db_connect.php';

$serial1 = $_POST['serial1'];
$rrm = $_POST['rrm'];
$cosm1 = $_POST['cosm1'];
$cosm2 = $_POST['cosm2'];
$cosm3 = $_POST['cosm3'];
$cosm4 = $_POST['cosm4'];
$elet1 = $_POST['elet1'];
$elet2 = $_POST['elet2'];

if ($elet1 == "0000 - sem defeito")
    $elet1 = "";

if ($cosm1 == "0000 - sem defeito")
    $cosm1 = "";

// Se o primeiro combo box Defeito Elétrico for preenchido o local do serial será (3) elétrica.
// Se não for preenchido, o local será (4) cosmética. É regra o serial sempre passar no setor de cosmética.

if ($elet1 != ""){
    $query = "UPDATE seriais SET dt_testeinicial = now(), local = '3', t_cosm1 = '$cosm1', t_cosm2 = '$cosm2', t_cosm3 = '$cosm3', t_cosm4 = '$cosm4', t_eletr1 = '$elet1', t_eletr2 = '$elet2' 
    WHERE serial1 = '$serial1' and rrm = '$rrm'";
}else {
    $query = "UPDATE seriais SET dt_testeinicial = now(), local = '4', t_cosm1 = '$cosm1', t_cosm2 = '$cosm2', t_cosm3 = '$cosm3', t_cosm4 = '$cosm4', t_eletr1 = '$elet1', t_eletr2 = '$elet2' 
    WHERE serial1 = '$serial1' and rrm = '$rrm'";
}

mysqli_query($connect, $query);

/*
Status do serial:
0- Saiu
1- Recepção
2- Teste Inicial
3- Elétrica
4- Cosmética
5- Teste Final
6- Embalagem
7- Expedição
*/ 