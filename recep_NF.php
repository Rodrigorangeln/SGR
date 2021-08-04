<html lang="pt-br">

<head>

</head>
<?php

session_start();

if((!isset ($_SESSION['user']) == true) and (!isset ($_SESSION['pass']) == true))
{
  unset($_SESSION['user']);
  unset($_SESSION['pass']);
  header('location:index.php');
  }
 
  include 'menu.php';
  
  require_once 'db_connect.php';

$query = "SELECT cod_cliente, fantasia FROM cd_clientes";
mysqli_set_charset($connect,"utf8"); //<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<
$resultQuery = mysqli_query($connect, $query);

$queryRRM = "SELECT RRM FROM recep_nf where RRM = (SELECT MAX(RRM) FROM recep_nf)";
$resultqueryRRM = mysqli_query($connect, $queryRRM);

$queryAparelhos = "SELECT cod FROM cd_aparelhos";
$resultqueryAparelhos = mysqli_query($connect, $queryAparelhos);

$row = mysqli_fetch_assoc($resultqueryRRM);
$nextRRM = $row["RRM"] + 1;

?>

<!-- <!DOCTYPE html>
<link rel="shortcut icon" href="./imagens/logo.ico" />
 -->

<!-- <script src="./js/jquery-3.5.1.min.js"></script>
<link href="./css/bootstrap.min.css" rel="stylesheet"> -->
<script src="./js/recep.js"></script>
<!-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> -->
<!-- <script src="./js/bootstrap.min.js"></script> -->
<!-- <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css"> -->
<!--  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
 <link href="./css/recep.css" rel="stylesheet"> -->



<body>


<!-- <span class="d-block p-2 bg-primary text-white text-center">>>> RECEPÇÃO DE NOTAS FISCAIS <<<</span>
<br> -->



<form action="create_NF.php" method="POST">

  <div class="form-group row mx-md-2 mt-5">
    <label for="RRM" class="col-sm-1 col-form-label">RRM</label>
    <div class="col-sm-1">
      <input type="text" class="form-control" name="RRM" id="RRM" value="<?php echo $nextRRM; ?>" placeholder="" readonly>
    </div>
  </div>

  <div class="form-group row mx-md-2">
    <label for="NF" class="col-sm-1 col-form-label">NF</label>
    <div class="col-sm-1">
      <input type="text" class="form-control" maxlength="7" name="NF" id="NF" placeholder="" required autofocus>
    </div>

    <label for="dt_emissao" class="col-sm-1 col-form-label">Emissão</label>
    <div class="col-sm-2">
      <input type="date" class="form-control" name="dt_emissao" id="dt_emissao" required maxlength="10"  >
    </div>

    <label for="dt_entrada" class="col-sm-1 col-form-label">Entrada</label>
    <div class="col-sm-2">
      <input type="date" class="form-control" name="dt_entrada" id="dt_entrada" required maxlength="10" tabindex="-1" value='<?php echo date('Y-m-d'); ?>'>
    </div> 
  </div>

  <div class="form-group row mx-md-2">
    <!-- <label for="cod_cliente" class="col-sm-1 col-form-label">Cód.</label>
    <div class="col-sm-1">
      <input type="text" class="form-control" id="cod_cliente" placeholder="">
    </div> -->

    <label for="cliente" class="col-sm-1 col-form-label">Cliente</label>
    <div class="col-sm-7">

    <!-- COMBO BOX -->
    <select required name="cod_cliente" class="form-control">
    <option disabled selected hidden value="">Digite o código ou Selecione...</option>
    <?php while($row = mysqli_fetch_assoc($resultQuery)) { ?>
    <option><?php echo $row["cod_cliente"]." - ".$row["fantasia"] ?></option>
    <?php }
    mysqli_close($connect);
    ?>
    </select>
        
    <!-- <input type="text" class="form-control" id="cliente" required="" maxlength="10"  onBlur="showhide()"> -->
      
    </div>
  </div>
 

<!-- Botões -->

  <div class="col-md-8 col-form-label text-right">
    <button id="add_row" name="add" class="btn btn-primary" type="button" tabindex="-1">Adicionar modelo</button>
    <button  id="btn_Cadastrar" name="btn-Cadastrar" class="btn btn-success" type="submit" tabindex="-1" data-toggle="tooltip" data-placement="bottom" title="CONFIRMA o CADASTRO da NF">
    Confirmar
    </button>
    <!-- <button id="Cadastrar" name="Cadastrar" class="btn btn-success" type="button" data-toggle="modal" data-target="#ConfirmarNF">Confirmar</button> -->
<!--     <a id="add_row" class="btn btn-primary float-right">Adicionar modelo</a> -->

<!--  MODAL 
  <div class="modal fade" id="ConfirmarNF" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="TituloModalCentralizado">Confirma o recebimento dos modelos?</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
         
        <div class="modal-body">
          ...
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Não</button>
          <button type="submit" id="Confirmo" class="btn btn-primary">Confirmo</button>
        </div>
      </div>
    </div>
  </div>

  </div>
 -->

<div class="panel panel-primary">

<div class="container">
    <div class="row clearfix">
    	<div class="col-md-9 table-responsive">
			<table class="table table-bordered table-hover table-sortable" id="tab_logic">

				<tbody>
    				<tr id='addr0' data-id="0" class="hidden">
              <td data-name="cod" class="col-sm-3">
                  <!-- <input type="text" name='cod0' placeholder='Cód modelo' class="form-control" onblur="getModelo(name)"/> -->

                <!-- COMBO BOX -->
                <select name="cod0" class="form-control" onblur="getModelo(name)">
                <option value="" hidden>Cód modelo</option> <!-- disabled selected -->
                <?php while($row = mysqli_fetch_assoc($resultqueryAparelhos)) { ?>
                <option><?php echo $row["cod"]?></option>
                <?php }
                mysqli_close($connect);
                ?>
                </select>
                <!-- COMBO BOX fim -->

                   

              </td>
              <td data-name="modelo" class="col-sm-7">
                  <input type="text" name='modelo0' placeholder='Modelo' class="form-control" readonly tabindex="-1"/>
              </td>
              <td data-name="quant" class="col-sm-2">
                  <input type="text" name='quant0' maxlength="5" placeholder='Quant.' class="form-control" onblur="add_row.click()"/>
              </td>
              <td data-name="del">
                  <button name="del0" type="button" class='btn btn-danger glyphicon glyphicon-remove row-remove'><span aria-hidden="true">x</span></button>
              </td>
					  </tr>
				</tbody>
			</table>
		</div>
    <label class="mt-3 ml-3">Total:&nbsp;&nbsp;<span class="display-4"><strong id="total"></strong></span></label>
	</div>
	
</div>
</br>


</fieldset>
</form>

</html>