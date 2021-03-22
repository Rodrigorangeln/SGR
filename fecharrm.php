<?php
require_once 'db_connect.php';


$rrm = $_POST['rrm'];

//Local 2: Teste Inicial
// ALTERAR STATUS RRM p FECHADO
// ALTERAR LOCAL DO SERIAL p "2". Teste Inicial

$query = "UPDATE rrm set Aberta = '0', dt_fechamento = now() where num = $rrm";
$query2 = "UPDATE seriais set local = '2' where rrm = $rrm";
mysqli_query($connect, $query);
mysqli_query($connect, $query2);

