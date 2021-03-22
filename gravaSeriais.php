<?php
header('Content-type: application/json');
require_once 'db_connect.php';


$rrm = $_POST['rrm'];
$cod_modelo = $_POST['cod_m'];
$s1 = $_POST['serial1'];
$s2 = $_POST['serial2'];
$loc = 1; // Posto Teste inicial

$query = "INSERT INTO seriais (rrm, cod_modelo, serial1, serial2, local) VALUES 
('$rrm','$cod_modelo', '$s1', '$s2', '$loc')";
mysqli_query($connect, $query);
	