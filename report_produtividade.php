<?php

session_start();

if ((!isset($_SESSION['user']) == true) and (!isset($_SESSION['pass']) == true) or ($_SESSION['nivel'] <> '0')) {
    unset($_SESSION['user']);
    unset($_SESSION['pass']);
    header('location:index.php');
}

include 'menu.php';
require_once 'db_connect.php';

$query = "SELECT registration, name FROM cd_usuarios where ativo = '1' order by name";
$resultQuery = mysqli_query($connect, $query);
$resultQuery2 = mysqli_query($connect, $query);

/* $queryAparelhos = "SELECT cod, modelo FROM db_sgr.cd_aparelhos";
$resultqueryAparelhos = mysqli_query($connect, $queryAparelhos); */

?>
<span class="d-block p-2 bg-primary text-white text-center">>>> PRODUTIVIDADE do COLABORADOR <<< </span>

        <script src="./js/report_produtividade.js"></script>

        <body>

            <div class="container-fluid mt-5 ml-4">
                <div class="row">
                    <div class="col-sm-3">

                        <!--   <div id="caixa"></div> -->
                        <!-- style='display: block' -->
                        <!-- none -->
                        <div class="form-group">
                            <label>Selecione o posto:</label>
                            <select id="posto" class="custom-select form-control">
                                <option value="Recepção">Recepção</option>
                                <option value="Teste Inicial">Teste Inicial</option>
                                <option value="Elétrica">Elétrica</option>
                                <option value="Cosmética">Cosmética</option>
                                <option value="Teste Final">Teste Final</option>
                                <option value="Embalagem">Embalagem</option> 
                                <!-- <option value="Expedição">Expedição</option> -->
                            </select>
                        </div>
                        <div class="form-group mt-5">
                            <label>Selecione 1 ou 2 colaboradores:</label>
                            <select id="colaborador1" class="custom-select form-control">
                                <option value="0" selected>Colaborador 1</option>
                                <?php while ($row = mysqli_fetch_assoc($resultQuery)) { ?>
                                    <option><?php echo $row["registration"] . " - " . $row["name"] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <select id="colaborador2" class="custom-select form-control">
                                <option value="0" selected>Colaborador 2</option>
                                <?php while ($row = mysqli_fetch_assoc($resultQuery2)) { ?>
                                    <option><?php echo $row["registration"] . " - " . $row["name"] ?></option>
                                <?php }  ?>
                            </select>
                        </div>

                        <div class="form-group mt-5">
                            <label>Selecione o período:</label>
                            <div class="form-inline">
                                <label>De:</label>
                                <input type="date" class="form-control col-sm-6 ml-3" id="dt_inicio">
                            </div>
                            <div class="form-inline">
                                <label>Até:</label>
                                <input type="date" class="form-control col-sm-6 mt-2 ml-3" id="dt_final">
                            </div>
                        </div>
                        <div class="mt-4 float-right">
                            <button id="consultar" class="btn btn-primary" type="button">Consultar</button>
                        </div>
                    </div>

                    <div class="form-group col-md-6 mt-4 ml-5">
                        <strong id="label" class="h1"></strong>
                        <div class="mt-5">
                            <strong id="report_colab1"></strong>
                            <strong class="h2" id="quant_colab1"></strong>
                        </div>
                        <div class="mt-5">
                            <strong id="report_colab2"></strong>
                            <strong class="h2" id="quant_colab2"></strong>
                        </div>
                    </div>

                </div>
            </div>

        </body>

        </html>