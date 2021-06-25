<script type="text/javascript" charset="UTF-8"></script>
<script type="text/javascript" src="./js/BrowserPrint-3.0.216.min.js"></script>
<?php

session_start();

if ((!isset($_SESSION['user']) == true) and (!isset($_SESSION['pass']) == true) or ($_SESSION['nivel'] <> '0')) {
    unset($_SESSION['user']);
    unset($_SESSION['pass']);
    header('location:index.php');
}

//$logged = $_SESSION['name'];

include 'menu.php';
require_once 'db_connect.php';

$query = "SELECT cod_cliente, fantasia FROM cd_clientes";
mysqli_set_charset($connect, "utf8");
$resultQuery = mysqli_query($connect, $query);

/* $queryAparelhos = "SELECT cod, modelo FROM db_sgr.cd_aparelhos";
$resultqueryAparelhos = mysqli_query($connect, $queryAparelhos); */

?>
<html>
<span class="d-block p-2 bg-primary text-white text-center">>>> REIMPRESSÃO de ETIQUETAS <<< </span>
        <script src="./js/etiquetas.js"></script>

        <div class="alert alert-danger text-center position-absolute" id="errocaixa">
            <strong>CAIXA NÃO ENCONTRADA.</strong>
        </div>

        <div class="container-fluid mt-4 ml-4">
            <div class="row">
                <div class="col-sm-2">

                    <!-- <div id="caixa"></div> -->
                    <!-- style='display: block' -->
                    <!-- none -->
                    <div class="form-group mt-4">
                        <label>Caixa</label>
                        <input class="form-control col-sm-5" id="caixa" maxlength="5" placeholder="5 dígitos" onkeyup="maiuscula(this)">
                    </div>
                    <button id="buscar_caixa" class="btn btn-outline-primary" type="button">Buscar</button>
                </div>


                <div class="col-sm-3 mt-4">

                    <div id="marca_todos" class="input-group" hidden>
                        <div class="input-group-text">
                            <input id="checkTodos" type="checkbox">
                        </div>
                        <small class="form-text text-muted ml-2">Marcar todos.</small>
                    </div>

                    <!-- <div class="input-group mt-3">
                            <div class="input-group-text">
                                <input type="checkbox">
                            </div>
                        <input type="text" class="form-control" disabled>
                    </div> -->

                </div>


                <div class="ml-5 col-md-4">
                    <!-- hidden -->
                    <div class="mt-5">
                        <button id="btn_imp_etiquetas" class="btn btn-outline-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Uma etiqueta p cada equipamento" hidden>Imp. Etiquetas</button>
                    </div>
                    <div class="mt-5">
                        <button id="btn_imp_etiqueta_caixa" class="btn btn-outline-primary" type="button" data-toggle="tooltip" data-placement="bottom" title="Etiqueta com Modelo e quantidade de equipamentos" hidden disabled>Imp. Etiqueta da Caixa</button>
                    </div>
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