<html lang="pt-br">

<?php

session_start();

if ((!isset($_SESSION['user']) == true) and (!isset($_SESSION['pass']) == true)) {
  unset($_SESSION['user']);
  unset($_SESSION['pass']);
  header('location:index.php');
}

include 'menu.php';

require_once 'db_connect.php';

?>

<script src="./js/reportAdmSeriais.js"></script>

<body>

  <div class="mt-5 ml-5">

    <b class="col-sm-2">Período de entrada dos seriais:</b>

    <div>

      <label for="dt_emissao" class="col-sm-1 col-form-label mt-3">De:</label>
      <div class="col-sm-2">
        <input type="date" class="form-control" id="de" required maxlength="10">
      </div>

      <label for="dt_entrada" class="col-sm-1 col-form-label">Até:</label>
      <div class="col-sm-2">
        <input type="date" class="form-control" id="ate" required maxlength="10">
      </div>
    </div>

    <div class="mt-5 col-sm-3">
      <button id="btn_excel" class="btn btn-outline-primary" type="button">Gerar Excel</button>
      <small class="mt-5 form-text text-muted">Obs.: Evite período superior a 7 dias.</small>
    </div>
  </di>
  
</div>
</body>

</html>