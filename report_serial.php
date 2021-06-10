<?php

session_start();

if ((!isset($_SESSION['user']) == true) and (!isset($_SESSION['pass']) == true)) {
    unset($_SESSION['user']);
    unset($_SESSION['pass']);
    header('location:index.php');
}

include 'menu.php';

?>
<span class="d-block p-2 bg-primary text-white text-center">>>> HISTÓRICO do SERIAL <<< </span>

        <script src="./js/report_serial.js"></script>

        <div class="alert alert-danger text-center" id="erroserial">
            <strong>SERIAL NÃO ENCONTRADO !</strong>
        </div>

        <body>

            <div class="container-fluid mt-5 ml-4">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="form-group">
                            <input id="serial" class="form-control" maxlength="25" placeholder="Entre com o serial" onkeyup="maiuscula(this)">
                        </div>

                        <div class="mt-5 float-right">
                            <button id="consultar" class="btn btn-primary" type="button">Consultar</button>
                        </div>
                    </div>

                    <div class="col-md-8 ml-5">
                        <table class="table table-striped">
                            <!-- hidden -->
                            <thead>
                                <tr>
                                    <th>RRM <span id="rrm"></span></th>
                                </tr>
                                <tr>
                                    <th scope="col" class="col-md-3">#</th>
                                    <th scope="col" class="col-md-2">Data</th>
                                    <th scope="col">Colaborador</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">Input</th>
                                    <td id="dt_input"></td>
                                    <td id="func_input"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Teste Inicial</th>
                                    <td id="dt_testeInicial"></td>
                                    <td id="func_testeInicial"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Elétrica</th>
                                    <td id="dt_eletrica"></td>
                                    <td id="func_eletrica"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Cosmética</th>
                                    <td id="dt_cosmetica"></td>
                                    <td id="func_cosmetica"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Teste Final</th>
                                    <td id="dt_testeFinal"></td>
                                    <td id="func_testeFinal"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Embalagem</th>
                                    <td id="dt_embalagem"></td>
                                    <td id="func_embalagem"></td>
                                </tr>
                                <tr>
                                    <th scope="row">Expedição</th>
                                    <td id="dt_expedicao"></td>
                                    <td id="func_expedicao"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>

        </body>

        </html>