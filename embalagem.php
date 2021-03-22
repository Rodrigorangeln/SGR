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

$query = "SELECT cod_cliente, razao_social FROM cd_clientes";
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

<div class="alert alert-success text-center" id="embalagemok">
    <strong>EMBALAGEM REALIZADA.</strong>
</div>

<body>

    <div class="container-fluid mt-5 ml-4">
        <div class="row">
            <div class="col-sm-3">

            <div id="caixa"></div>
            <!-- style='display: block' -->
                <!-- none -->
                <div class="form-group mt-4">
                    <label>Cliente</label>
                    <select id="cliente" class="form-control">
                        <option value = "0" disabled selected>Digite o código ou Selecione...</option>
                        <?php while ($row = mysqli_fetch_assoc($resultQuery)) { ?>
                            <option><?php echo $row["cod_cliente"] . " - " . $row["razao_social"] ?></option>
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
            </div>
            

            <div class="ml-2 col-sm-3">
                <strong id = "serial2" hidden>Serial 2:</strong>
                <div class="d-flex flex-row-reverse mt-5">
                    <button id="finalizar" class="btn btn-primary" type="button" hidden>Finalizar</button>
                </div>
            </div>

            <div class="col-sm-2">
                <strong id = "smartcard" hidden>Smart Card:</strong>
            </div>

        </div>

</body>

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