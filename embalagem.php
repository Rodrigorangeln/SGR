<script type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript" src="./js/BrowserPrint-3.0.216.min.js"></script>
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

$query = "SELECT cod_cliente, fantasia FROM cd_clientes";
mysqli_set_charset($connect,"utf8");
$resultQuery = mysqli_query($connect, $query);

/* $queryAparelhos = "SELECT cod, modelo FROM db_sgr.cd_aparelhos";
$resultqueryAparelhos = mysqli_query($connect, $queryAparelhos); */

?>

<script src="./js/embalagem.js"></script>

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
            <div class="col-sm-3">

            <!-- <div id="caixa"></div> -->
            <!-- style='display: block' -->
                <!-- none -->
                <div class="form-group mt-4">
                    <label>Cliente</label>
                    <select id="cliente" class="form-control">
                        <option value = "0" disabled selected>Digite o código ou Selecione...</option>
                        <?php while ($row = mysqli_fetch_assoc($resultQuery)) { ?>
                            <option><?php echo $row["cod_cliente"] . " - " . $row["fantasia"] ?></option>
                        <?php }
                        mysqli_close($connect);
                        ?>
                    </select>
                </div>
                <div class="form-group">
                    <label>Modelo</label>
                    <select id="modelo" class="form-control">
                        <option value = "0" disabled selected>Digite o código ou Selecione...</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Quant. na caixa</label>
                    <input class="form-control col-sm-3" id="quant" maxlength="3">
                </div>
                <div class="form-group">
                    <label>Smart Card</label>
                    <div >
                        <input type="radio" name="radio" id="radio_s"><label class="ml-2">Sim</label></input>
                        <input type="radio" name="radio" id="radio_n" class="ml-3"><label class="ml-2">Não</label></input>
                    </div>
                </div>
                <button id="criar_caixa" class="btn btn-primary" type="button">Criar caixa</button>
            </div>

            <div class="ml-1 col-sm-3">
                <strong id = "serial1" hidden>Serial 1:</strong> 
                <div class="d-flex flex-row-reverse mt-5">
                    <button id="btn_imp_etiquetas" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Uma etiqueta p cada equipamento" hidden>Imp. Etiquetas</button>
                </div>
            </div>
            

            <div class="ml-2 col-sm-3">
                <strong id = "serial2" hidden>Serial 2:</strong>
                <div class="d-flex flex-row-reverse mt-5 justify-content-between">
                    <button id="finalizar" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Gera um nº de caixa" hidden>Finalizar</button>
                    <button id="btn_imp_etiqueta_caixa" class="btn btn-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Etiqueta com Modelo e quantidade de equipamentos" hidden>Imp. Etiqueta da Caixa</button>
                </div>
            </div>

            <div class="col-sm-2">
                <strong id = "smartcard" hidden>Smart Card:</strong>
            </div>

        </div>

</html>

<div class="modal fade" id="ModalSerialDuplicado" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>NÃO</strong> continue</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Existe serial duplicado!</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalSerialInvalido" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>ERRO !</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Existe serial inválido! Verifique.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalSerial2" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>Tente novamente !</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Existe "Serial 2" vazio! Verifique.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalSmartCard" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>ERRO Smart Card !</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Existe Smart Card não preenchido! Verifique.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="ModalFinalizar" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><strong>Atenção ⚠️</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p><strong>CONFIRMA QUE JÁ IMPRIMIU TODAS AS ETIQUETAS ?</strong></p>
      </div>
      <div class="modal-footer">
        <button type="button" id="btn_ModalNao" class="btn btn-secondary" data-dismiss="modal">Não</button>
        <button type="button" id="btn_Confirmo" class="btn btn-primary">Confirmo</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>