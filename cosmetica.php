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
$resultQueryCosm = mysqli_query($connect, $queryC);


?>

<script src="./js/cosmetica.js"></script>


<!-- <span class="d-block p-2 bg-primary text-white text-center">>>> TESTE INICIAL <<<</span>
<br> -->

<div class="alert alert-danger text-center" id="erroserial">
    <strong>SERIAL NÃO ESTÁ NA COSMÉTICA.</strong>
</div>

<div class="alert alert-success text-center" id="cosmeticaok">
    <strong>COSMÉTICA REALIZADA.</strong>
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
                <strong>Defeito COSMÉTICO:</strong><br>
                <small class="form-text text-muted">Marque o que foi substituído.</small>
                <small class="form-text text-muted">Adicione o que não foi identificado no Teste Inicial. (Máx. 4)</small>

                <div class="input-group mb-3 mt-2">
                    <input type="text" id="cosm0" class="form-control" readonly tabindex="-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="checkcosm0" disabled>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3 mt-2">
                    <input type="text" id="cosm1" class="form-control" readonly tabindex="-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="checkcosm1" disabled>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3 mt-2">
                    <input type="text" id="cosm2" class="form-control" readonly tabindex="-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="checkcosm2" disabled>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3 mt-2">
                    <input type="text" id="cosm3" class="form-control" readonly tabindex="-1">
                    <div class="input-group-prepend">
                        <div class="input-group-text">
                            <input type="checkbox" id="checkcosm3" disabled>
                        </div>
                    </div>
                </div>

                <select name="def_cosm0" class="form-control mt-2" hidden tabindex="-1">
                    <option value = "0">Selecione...</option>
                    <?php while ($row = mysqli_fetch_assoc($resultQueryCosm)) { ?>
                        <option><?php echo $row["cod"] . " - " . $row["descr"] ?></option>
                    <?php }
                    $resultQueryCosm = mysqli_query($connect, $queryC); ?>
                </select>
                <select name="def_cosm1" class="form-control mt-2" hidden tabindex="-1">
                    <option value = "0">Selecione...</option>
                    <?php while ($row = mysqli_fetch_assoc($resultQueryCosm)) { ?>
                        <option><?php echo $row["cod"] . " - " . $row["descr"] ?></option>
                    <?php }
                    $resultQueryCosm = mysqli_query($connect, $queryC); ?>
                </select>
                <select name="def_cosm2" class="form-control mt-2" hidden tabindex="-1">
                    <option value = "0">Selecione...</option>
                    <?php while ($row = mysqli_fetch_assoc($resultQueryCosm)) { ?>
                        <option><?php echo $row["cod"] . " - " . $row["descr"] ?></option>
                    <?php }
                    $resultQueryCosm = mysqli_query($connect, $queryC); ?>
                </select>
                <select name="def_cosm3" class="form-control mt-2" hidden tabindex="-1">
                    <option value = "0">Selecione...</option>
                    <?php while ($row = mysqli_fetch_assoc($resultQueryCosm)) { ?>
                        <option><?php echo $row["cod"] . " - " . $row["descr"] ?></option>
                    <?php }

                    ?>
                </select>
                <div class="d-flex flex-row-reverse mt-5">
                    <button id="confirmar" class="btn btn-primary" type="button">Confirmar</button>
                </div>
            </div>

        </div>

</body>

</html>