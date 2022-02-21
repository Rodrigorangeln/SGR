<?php
require_once 'db_connect.php';

  
function conta_seriais($rrm, $cod_m, $item, $connect){

    $query = "SELECT COUNT(rrm) FROM seriais WHERE rrm = '$rrm' and cod_modelo = '$cod_m' AND item = '$item'";
    $resultQuery = mysqli_query($connect, $query);
    $resultCount = mysqli_fetch_assoc($resultQuery);
    $result = $resultCount['COUNT(rrm)'];
    return json_encode($result); 
}

echo conta_seriais($_POST['rrm'], $_POST['cod_m'], $_POST['item'], $connect);




    





