<?php
require_once 'db_connect.php';
header('Content-type: application/json');

$s1 = $_POST['s1'];
$rrm = $_POST['rrm'];

$query = "DELETE FROM seriais WHERE rrm = $rrm and serial1 = '$s1';";
$resultQuery = mysqli_query($connect, $query);