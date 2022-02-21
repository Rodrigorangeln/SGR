<script type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript" src="./js/BrowserPrint-3.0.216.min.js"></script>
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

$query = "SELECT cod_cliente, razao_social FROM cd_clientes";
mysqli_set_charset($connect, "utf8");
$resultQuery = mysqli_query($connect, $query);

/* $queryAparelhos = "SELECT cod, modelo FROM db_sgr.cd_aparelhos";
$resultqueryAparelhos = mysqli_query($connect, $queryAparelhos); */

?>

<script src="./js/expedicao.js"></script>

<div class="alert alert-danger text-center" id="errosmartcard">
  <strong>INFORME Sim ou Não na opção SMART CARD.</strong>
</div>

<div class="alert alert-danger text-center" id="errocliente">
  <strong>CLIENTE NÃO POSSUI EQUIPAMENTO A SER EMBALADO.</strong>
</div>

<div class="alert alert-success text-center" id="embalagemOK">
  <strong>EMBALAGEM REALIZADA.</strong>
</div>


<div class="container-fluid mt-5 ml-4">
  <div class="row">
    <div class="col-sm-2">

      <div class="form-group mt-4">
        <label>Nota fiscal</label>
        <input class="form-control mt-2 col-sm-6" id="nf" maxlength="7" required data-toggle="tooltip" data-placement="right" title="INFORME A NF de SAÍDA">
      </div>
      <div class="form-group">
        <label hidden>Quant. de Caixas</label>
        <input class="form-control col-sm-6" id="quant" maxlength="5" required data-toggle="tooltip" data-placement="right" title="INFORME a QUANTIDADE de CAIXAS na NF" hidden>
        <button id="btn-OK" class="mt-4 btn btn-primary col-sm-6" type="button">OK</button>
      </div>
    </div>

    <div class="row col-md-2 mt-4 justify-content-center">
      <strong id="informe" hidden>Informe quais caixas irão nessa NF:</strong>
      <div>

      <select id="list" class="form-control mt-2" tabindex="-1" multiple hidden> 
            <?php
            $queryEmb = "SELECT n_caixa FROM embalagem";
            $queryExp = "SELECT caixa FROM expedicao";
            mysqli_set_charset($connect,"utf8");
            $caixasDisponiveis = array();
            $caixasEmb = array();
            $caixasExp = array();

            $resultQueryEmb = mysqli_query($connect, $queryEmb);
            $resultQueryExp = mysqli_query($connect, $queryExp);

            while ($row = mysqli_fetch_assoc($resultQueryEmb)) {
              array_push($caixasEmb, $row['n_caixa']);
            }
            while ($row = mysqli_fetch_assoc($resultQueryExp)) {
              array_push($caixasExp, $row['caixa']);
            }

            $caixasDisponiveis = array_diff($caixasEmb, $caixasExp);
            $caixasDisponiveis = array_values(array_filter($caixasDisponiveis));

            if(sizeof($caixasDisponiveis) != 0){
              for ($i = 0; $i <  sizeof($caixasDisponiveis); $i++) {
                ?>
                <option><?php echo $caixasDisponiveis[$i]?></option>;
                <?php
              }
            } else {
              ?>
              <option><?php echo "Não há caixas"?></option>;
              <?php
            }

            ?>
        </select>
        <small id="infoList" class="form-text text-muted" hidden>Para selecionar mais de uma caixa, mantanha a tecla CTRL pressionada enquanto clica.</small>


        <button id="btn_imp_etiquetas" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Uma etiqueta p cada CAIXA" hidden>Imp. Etiquetas da caixa</button>
      </div>
    </div>

    <div id="expedicao" class="row col-md-3 justify-content-center" hidden>
      <div class="form-group mt-4">
        <label>Data de expedição</label>
        <input type="date" class="form-control mt-2 " id="date" maxlength="10" data-toggle="tooltip" data-placement="right" title="Data de recolhimento pela transportadora">
        <small class="form-text text-muted">Pode ser informada posteriormente</small>
        <button id="btn-OK-expedicao" class="mt-4 btn btn-primary btn-block" type="button">OK</button>
      </div>

    </div>

  </div>

  </html>


  <div class="modal fade" id="ModalInputVazio" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><strong>Verifique !</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>EXISTE CAMPO VAZIO !!!</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
        </div>
      </div>
    </div>
  </div>


  <div class="modal fade" id="ModalCaixaErrada" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><strong>Se liga !</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>TEM CAIXA INEXISTENTE !</p>
          <p>Marquei p vc. 😉</p> 
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <!-- <button type="button" id="btn_Confirmo" class="btn btn-primary">Confirmo</button> -->
          <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
        </div>
      </div>
    </div>
  </div>



  <div class="modal fade" id="ModalCaixaDespachada" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><strong>Finalizado !</strong></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>CAIXAS DESPACHADAS ! 👍</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
          <!-- <button type="button" id="btn_Confirmo" class="btn btn-primary">Confirmo</button> -->
          <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
        </div>
      </div>
    </div>
  </div>