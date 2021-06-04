<?php

session_start();

if ((!isset($_SESSION['user']) == true) and (!isset($_SESSION['pass']) == true)) {
  unset($_SESSION['user']);
  unset($_SESSION['pass']);
  header('location:index.php');
}

//$logged = $_SESSION['name'];

include 'menu.php';
require_once 'db_connect.php';

?>

<script src="./js/adm.js"></script>

<span class="d-block p-2 bg-primary text-white text-center">>>> ADMINISTRATIVO <<< </span>

    <div class="alert alert-danger text-center" id="erroserial">
      <strong>SERIAL NÃO ENCONTRADO.</strong>
    </div>

    <body>

      <div class="container mt-5 ml-4">
        <div class="row">
          <div class="col-sm-5">
            <div class="form-group">
              <label>Serial 1</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="1serial" maxlength="25" placeholder="Serial 1" onkeyup='maiuscula(this)'>
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" disabled type="button" id="btn-serial1">Alterar</button>
                </div>
              </div>

              <label>Serial 2</label>
              <div class="input-group mb-3">
                <input type="text" class="form-control" id="2serial" disabled maxlength="25" placeholder="Serial 2" onkeyup='maiuscula(this)'>
                <div class="input-group-append">
                  <button class="btn btn-outline-primary" disabled type="button" id="btn-serial2">Alterar</button>
                </div>
              </div>

              <div class="input-group mb-5">
                <button class="btn btn-outline-primary" disabled type="button" id="btn-inverte-seriais">Inverter Seriais</button>
              </div>
              <div class="form-group">
                <label>Código do Modelo</label>
                <input class="form-control col-sm-20" id="cod_mod" readonly tabindex="-1">
              </div>
              <div class="form-group">
                <label>Modelo</label>
                <input class="form-control col-sm-20" id="modelo" readonly tabindex="-1">
              </div>
            </div>
          </div>


        </div>
      </div>

    </body>

    </html>

    <div class="modal fade" id="ModalAlteraSerial" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="TituloModal"></h5>
          </div>
          <div class="modal-body">
            <!-- <label>Novo serial: </label> -->
            <input type="text" class="form-control" id="new-serial" maxlength="25" placeholder="Digite o novo serial" onkeyup='maiuscula(this)'>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_alterar" class="btn btn-primary">Alterar</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>


    <div class="modal fade" id="ModalInverteSeriais" tabindex="-1">
      <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="TituloModal">Confirma inversão entre Serial 1 e Serial 2 ?</h5>
          </div>
          <div class="modal-footer">
            <button type="button" id="btn_conf_inversao" class="btn btn-primary">Confirmo</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          </div>
        </div>
      </div>
    </div>