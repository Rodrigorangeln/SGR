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

/* $queryE = "SELECT cod, descr FROM cd_eletrica where ativo = 1";
$resultQueryEletr = mysqli_query($connect, $queryE); */
?>

<script src="./js/teste_final.js"></script>



<div class="alert alert-danger text-center" id="erroserial">
  <strong>SERIAL NÃO ESTÁ NO TESTE FINAL.</strong>
</div>

<div class="alert alert-success text-center" id="testeok">
  <strong>TESTE FINAL REALIZADO.</strong>
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

    <div class="ml-1 col-sm-3">
        <strong>Defeito COSMÉTICO:</strong>
        <select name="def_cosm0" class="form-control mt-2"tabindex="-1"> <!-- tabindex="-1" temporário -->
            <option></option>
            <option value="0" selected>0000 - sem defeito</option>  <!-- SELECTED temporário. Enquanto "Confirmar" não é implementado -->
            <?php while($row = mysqli_fetch_assoc($resultQueryCosm)) { ?>
            <option><?php echo $row["cod"]." - ".$row["descr"]?></option>
            <?php } 
            $resultQueryCosm = mysqli_query($connect, $queryC);?>
        </select>
        <select name="def_cosm1" class="form-control mt-2" tabindex="-1" disabled> <!-- DISABLED temporário. -->
            <option></option>
            <?php while($row = mysqli_fetch_assoc($resultQueryCosm)) { ?>
            <option><?php echo $row["cod"]." - ".$row["descr"]?></option>
            <?php }
            $resultQueryCosm = mysqli_query($connect, $queryC);?>
        </select>
        <select name="def_cosm2" class="form-control mt-2" tabindex="-1" disabled> <!-- DISABLED temporário. -->
            <option></option>
            <?php while($row = mysqli_fetch_assoc($resultQueryCosm)) { ?>
            <option><?php echo $row["cod"]." - ".$row["descr"]?></option>
            <?php } 
            $resultQueryCosm = mysqli_query($connect, $queryC);?>
        </select>
        <select name="def_cosm3" class="form-control mt-2" tabindex="-1" disabled> <!-- DISABLED temporário. -->
            <option></option>
            <?php while($row = mysqli_fetch_assoc($resultQueryCosm)) { ?>
            <option><?php echo $row["cod"]." - ".$row["descr"]?></option>
            <?php }
            
            ?>
        </select>
    </div>

    <div class="ml-3 col-sm-3">
    <strong>Defeito ELÉTRICO:</strong>
    <select id="def_elet0" name="def_elet0" class="form-control mt-2" tabindex="-1"> <!-- tabindex="-1" temporário -->
        <option></option>
        <option value="0">0000 - sem defeito</option>
    </select>
    <select id="def_elet1" name="def_elet1" class="form-control mt-2" tabindex="-1" disabled> <!-- DISABLED temporário -->
        <option></option>
    </select>
    <div class="d-flex flex-row-reverse mt-5">        
        <button id="aprovado" class="btn btn-success" type="button">Aprovado</button> <!-- Incluir DISABLED -->
        &nbsp &nbsp
        <button id="confirmar" class="btn btn-primary" type="button" disabled>Confirmar</button>
    </div>
    
    </div>
    
</div>

</body>
</html>





