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
require_once 'db_connect.php';

$queryC = "SELECT cod, descr FROM cd_cosmetica where ativo = 1";
mysqli_set_charset($connect,"utf8");
$resultQueryCosm = mysqli_query($connect, $queryC);


?>

<script src="./js/eletrica.js"></script>


<!-- <span class="d-block p-2 bg-primary text-white text-center">>>> TESTE INICIAL <<<</span>
<br> -->

<div class="alert alert-danger text-center" id="erroserial">
    <strong>SERIAL NÃO ESTÁ NA ELÉTRICA.</strong>
</div>

<div class="alert alert-success text-center" id="eletricaok">
    <strong>ELÉTRICA REALIZADA.</strong>
</div>

<div class="alert alert-danger text-center" id="errocomponente">
    <strong>SELECIONE O COMPONENTE.</strong>
</div>

<div class="alert alert-danger text-center" id="erroradio">
    <strong>MARQUE SE COMPONENTE FOI SUBSTITUÍDO OU RESSOLDADO.</strong>
</div>

<body>

    <div class="container mt-5 ml-4">
        <div class="row">
            <div class="col-sm-5">
                <div class="form-group">
                    <label>Serial 1</label>
                    <input class="form-control col-sm-10" id="1serial" maxlength="25" placeholder="Serial 1" onkeyup='maiuscula(this)'>
                </div>
                <div class="form-group">
                    <label>Serial 2</label>
                    <input class="form-control col-sm-10" id="2serial" readonly tabindex="-1">
                </div>
                <div class="form-group">
                    <label>RRM</label>
                    <input class="form-control col-sm-10" id="rrm" readonly tabindex="-1">
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

            <div class="ml-1 col-sm-5">
                <strong>Defeito ELÉTRICO:</strong><br>

                <div class="input-group mt-2">
                    <input type="text" id="elet0" class="form-control" readonly tabindex="-1">
                </div>
                <select id="componente1" name="componente1" class="form-control ">
                    <option selected value="0">Selecione componente...</option>
                </select>
                <div class="input-group-prepend">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="radio1" id="radioelet0sub"><label class="ml-2">Substituído</label></input>
                        <input type="radio" name="radio1" id="radioelet0res" class="ml-3"><label class="ml-2">Ressoldado</label></input>
                    </div>

                </div>

                <div class="input-group mt-2">
                    <input type="text" id="elet1" class="form-control" readonly tabindex="-1">
                </div>
                <select id="componente2" name="componente2" class="form-control ">
                    <option selected value="0">Selecione componente...</option>
                </select>
                <div class="input-group-prepend">
                    <div class="form-check form-check-inline">
                        <input type="radio" name="radio2" id="radioelet1sub"><label class="ml-2">Substituído</label></input>
                        <input type="radio" name="radio2" id="radioelet1res" class="ml-3"><label class="ml-2">Ressoldado</label></input>
                    </div>

                </div>

                <div id="sintoma_extra" hidden>
                    <div class="input-group mt-2">
                        <select id="sintoma3" name="sintoma3" class="form-control">
                            <option selected value="0">Selecione se houver novo sintoma...</option>
                        </select>
                    </div>
                    <select id="componente3" name="componente3" class="form-control ">
                        <option selected value="0">Selecione componente...</option>
                    </select>
                    <div class="input-group-prepend">
                        <div class="form-check form-check-inline">
                            <input type="radio" name="radio3" id="radioelet2sub"><label class="ml-2">Substituído</label></input>
                            <input type="radio" name="radio3" id="radioelet2res" class="ml-3"><label class="ml-2">Ressoldado</label></input>
                        </div>
                    </div>
                </div>

                <!-- <div id="sintoma_extra2" hidden>
                    <div class="input-group mt-2">
                        <select id="sintoma4" name="sintoma4" class="form-control ">
                            <option selected value="0">Selecione se houver novo sintoma...</option>
                        </select>
                    </div>
                    <select id="componente4" name="componente4" class="form-control ">
                        <option selected value="0">Selecione componente...</option>
                    </select>
                    <div class="input-group-prepend">
                        <div class="form-check form-check-inline">
                            <input type="radio" name="radio4" id="radioelet3sub"><label class="ml-2">Substituído</label></input>
                            <input type="radio" name="radio4" id="radioelet3res" class="ml-3"><label class="ml-2">Ressoldado</label></input>
                        </div>
                    </div>
                </div> -->


                <div class="d-flex flex-row-reverse mt-4">
                    <button id="confirmar" class="btn btn-primary" type="button">Confirmar</button>
                </div>
                <div class="d-flex flex-row-reverse mt-4">
                    <button id="sconserto" class="btn btn-danger" type="button">Sem conserto</button>
                </div>
            </div>

        </div>

</body>

</html>

<div class="modal fade" id="ModalSemConserto" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="TituloModal">Sem conserto?</h5>
<!--         <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
        Confirma que serial <strong><span id="serial"></span></strong> não tem conserto?
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_confirmar" class="btn btn-primary">Confirmo</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
      </div>
    </div>
  </div>
</div>
