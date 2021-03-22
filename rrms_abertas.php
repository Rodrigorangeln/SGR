<?php

session_start();

if((!isset ($_SESSION['user']) == true) and (!isset ($_SESSION['pass']) == true))
{
  unset($_SESSION['user']);
  unset($_SESSION['pass']);
  header('location:index.php');
  }

//$logged = $_SESSION['name'];

include 'menu.php';
?>


<!-- <!DOCTYPE html>
<link rel="shortcut icon" href="./imagens/logo.ico" />

<script src="./js/jquery-3.5.1.min.js"></script>
<link href="./css/bootstrap.min.css" rel="stylesheet"> -->
<script src="./js/rrms_abertas.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->



<!-- <span class="d-block p-2 bg-primary text-white text-center">>>> RRMs Abertas <<<</span>
<br> -->
<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Cliente</th>
      <th scope="col">RRM</th>
      <th scope="col">NF</th>
      <th scope="col">Emissão</th>
    </tr>
  </thead>
  <tbody>

<?php
require_once 'db_connect.php';

$query = "SELECT num FROM rrm WHERE Aberta = 1";
$resultQuery = mysqli_query($connect, $query);

$i=1;
while($row = mysqli_fetch_assoc($resultQuery)) { 
  $sqlrrm = "SELECT cod_cliente, RRM, nf, nf_emissao FROM recep_nf WHERE RRM = $row[num] LIMIT 1";
  $resultsqlrrm = mysqli_query($connect, $sqlrrm);
  $rowrrm = mysqli_fetch_assoc($resultsqlrrm);
  $rrm = $row["num"];
  echo ("<tr onclick=linkSeriais($rrm)>");
  echo ("<th scope='row'>".$i."</th>");
  echo ("<td>").$rowrrm["cod_cliente"].("</td>");
  echo ("<td>").$rowrrm["RRM"].("</td>");
  echo ("<td>").$rowrrm["nf"].("</td>");
  echo ("<td>").$rowrrm["nf_emissao"].("</td>");
  echo ("</tr>");
  $i++;
};
mysqli_close($connect);
?>

  </tbody>
</table>
