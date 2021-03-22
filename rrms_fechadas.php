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

<script src="./js/rrms_fechadas.js"></script>


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

$query = "SELECT num FROM rrm WHERE Aberta = 0";
$resultQuery = mysqli_query($connect, $query);

$i=1;
while($row = mysqli_fetch_assoc($resultQuery)) { 
  $sqlrrm = "SELECT cod_cliente, RRM, nf, nf_emissao FROM recep_nf WHERE RRM = $row[num] LIMIT 1";
  $resultsqlrrm = mysqli_query($connect, $sqlrrm);
  $rowrrm = mysqli_fetch_assoc($resultsqlrrm);
  $rrm = $row["num"];
  echo ("<tr onclick=ModalRRMFechada($rrm)>");
  /* echo ("<tr data-toggle='modal' data-target='#ModalRRMFechado'>") ; */
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

<div class="modal fade" id="ModalRRMFechado" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModal"></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="teste">
        <!-- <span id="cliente"></span><br>
        <span id="nf"></span><br> -->
        <!-- <span id="cod_mod"></span><br>
        <span id="quant"></span> -->
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_report_seriais" class="btn btn-primary">Relatório</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>


