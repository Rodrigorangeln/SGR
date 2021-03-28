<?php

session_start();

if((!isset ($_SESSION['user']) == true) and (!isset ($_SESSION['pass']) == true))
{
  unset($_SESSION['user']);
  unset($_SESSION['pass']);
  header('location:index.php');
  }

include 'menu.php';

$cliente = $_GET['cliente'];
$nf = $_GET['nf'];
$rrm = $_GET['rrm'];

?>


<div class="text-primary">
Cliente: 
<span id="cliente"><strong><?php echo $cliente; ?></strong></span>
&nbsp &nbsp &nbsp &nbsp 
<span id="NF"><strong><?php echo $nf; ?></strong></span>
</div>


<table class="table table-striped">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Modelo</th>
      <th scope="col">Serial 1</th>
      <th scope="col">Serial 2</th>
    </tr>
  </thead>
  <tbody>
   
<?php
require_once 'db_connect.php';

$query = "SELECT s.cod_modelo, s.serial1, s.serial2, m.modelo FROM seriais s, cd_aparelhos m WHERE s.rrm = '$rrm' and s.cod_modelo = m.cod";
$resultQuery = mysqli_query($connect, $query);

$i=1;
while($row = mysqli_fetch_assoc($resultQuery)) { 
  echo ("<tr>");
  echo ("<th style='width: 3%'>".$i."</th>");
  echo ("<td class='col-sm-4'>").$row["cod_modelo"]." - ".$row["modelo"].("</td>");
  echo ("<td>").$row["serial1"].("</td>");
  echo ("<td>").$row["serial2"].("</td>");
  echo ("</tr>");
  $i++;
};
?>
  </tbody>
</table>