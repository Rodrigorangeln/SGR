
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

$rrm_atual = $_GET['n_rrm'];

$query = "SELECT * FROM recep_nf WHERE RRM = $rrm_atual";
$resultQuery = mysqli_query($connect, $query);
$resultQueryMod = mysqli_query($connect, $query);
$row = mysqli_fetch_assoc($resultQuery);
$nf_atual = $row["nf"];
$cli_atual = $row["cod_cliente"];

//mysqli_close($connect);

?>

<script src="./js/entr_seriais.js"></script>

<span class="d-block p-2 bg-primary text-white text-center">>>> ENTRADA de SERIAIS <<<</span>


<div class="alert alert-danger text-center" id="alertaSerial">
  <strong>SERIAL NÃO PODE FICAR VAZIO.</strong>
</div>

<div class="alert alert-danger text-center" id="alertaModeloAtual">
  <strong>SELECIONE UM MODELO.</strong>
</div>

<div class="alert alert-danger text-center" id="alertaSeriaisIguais">
<strong>O PRIMEIRO E O SEGUNDO SERIAL NÃO PODEM SER IGUAIS.</strong>
</div>

<div class="alert alert-danger text-center" id="alertaSeriaisDuplicadosBD">
<strong>SERIAL JÁ CADASTRADO.</strong>
</div>

<div class="alert alert-success text-center" id="alertaRRM_Fechado">
<strong>Pronto! RRM FECHADO.</strong>
</div>

<div class="container">
<input tabindex="-1" type="text" name="modelo_atual" id="modelo_atual" style="font-weight: bold; font-size: x-large; " value="" class="col-sm form-control-plaintext" readonly>
  <div class="row">
    <!-- <div class="col-3">
      <input type="text" class="form-control" name="s1" id="s1" placeholder="Serial 1">
    </div>
    <div class="col-3">
    <input type="text" class="form-control" name="s2" id="s2" placeholder="Serial 2">
    </div> -->

    	<div class="col-sm table-responsive">
			<table class="table table-bordered table-hover table-sortable" id="tab_logic">
				<tbody>
    				<tr id='addr0' data-id="0" class="hidden">
              <td data-name="1serial" class="col-sm-6">
                  <input type="text" name='1serial0' placeholder='Serial 1' maxlength="25" class="form-control" onkeyup="maiuscula(this)" onblur="verifica2serial(name)"/> 
              </td>
              <td id="2serial" data-name="2serial" class="col-sm-6">
                  <input type="text" name='2serial0' placeholder='Serial 2' maxlength="25" class="form-control" onkeyup="maiuscula(this)" onblur="add_row.click(); gravaSeriais(name);"/>
              </td>
              <td data-name="del">
                  <button name="del0" class='btn btn-danger glyphicon glyphicon-remove row-remove' tabindex="-1"><span aria-hidden="true">x</span></button>
              </td>
					  </tr>
				</tbody>
			</table>
		</div>

    <div class="col-sm">
        <div class="input-group">
        <div class="input-group-prepend">
          <span class="input-group-text">RRM</span>
        </div>
          <input tabindex="-1" type="text" id="num_rrm" name="num_rrm" style="font-weight: bold; font-size: x-large; text-align: center;" value="<?php echo $rrm_atual; ?>" class="col-sm form-control-plaintext" readonly>
          <span class="input-group-text">NF</span>
          <input tabindex="-1" type="text" id="num_nf" style="font-weight: bold; font-size: x-large; text-align: center;" value="<?php echo $nf_atual; ?>" class="col-sm form-control-plaintext" readonly>
        </div>
        <div class="input-group-prepend">
          <span class="input-group-text">Cliente</span>
          <input tabindex="-1" type="text" name="Cliente" id="Cliente" style="font-weight: bold; font-size: x-large; text-align: center;" value="<?php echo $cli_atual; ?>" class="col-sm form-control-plaintext" readonly>
        </div>

      <table id="modelos" class="table table-hover table-sm">
        <thead>
          <tr>
            <th scope="col">Cód</th>
            <th scope="col">Modelo</th>
            <th scope="col">Quant</th>
            <th scope="col">Faltam</th>
          </tr>
        </thead>
        <tbody>


        <div id="divmodelos">
        <?php
          $i=0;
          while($rowmodelos = mysqli_fetch_assoc($resultQueryMod)) {
            $codmod = $rowmodelos["cod_modelo"];
            $item = $rowmodelos["item"];
            $sql = "SELECT cod, modelo FROM cd_aparelhos WHERE cod = $codmod";
            $resultsql = mysqli_query($connect, $sql);
            $rowsql = mysqli_fetch_assoc($resultsql);

            //CALCULA A QUANTIDADE DE SERIAIS QUE FALTA DAR ENTRADA
            $sqlcount = "SELECT COUNT(rrm) FROM seriais WHERE rrm = $rrm_atual and cod_modelo = $codmod AND item = '$item'";
            $resultsqlcount = mysqli_query($connect, $sqlcount);
            $rowsqlcount = mysqli_fetch_assoc($resultsqlcount);
            $falta = ($rowmodelos["quant"] - $rowsqlcount["COUNT(rrm)"]);
            ///////////////////////////////////////////////////////////////

            echo ("<tr onclick=modeloAtual($rowmodelos[item]$rowsql[cod])>");
            
            echo ("<th scope='row'>".$rowmodelos["cod_modelo"]."</th>");

            echo ("<td>".$rowsql["modelo"]."</td>");

            echo ("<td id='tdcountt$rowmodelos[item]'>".$rowmodelos["quant"]."</td>");

            echo ("<td id='tdcountdown$rowmodelos[item]'>".$falta."</td>");

            //echo ("<td><input id='checkbox' type='checkbox' onclick=verificaCheckbox()></td>");
            echo ("<td><input id=check$i type='checkbox' onclick=verificaCheckbox()></td>");
            echo ("</tr>");
            $i++;
          };

        ?>
        </div>
        </tbody>
      </table>

      <div style="text-align: right;">
        <input name="aux_item" hidden>  
        <input name="aux_codmod" hidden>  <!-- INPUT P AUXILIAR O UPDATE DO CÓDIGO DO MODELO -->
        <button hidden type="button" id="add_row" name="add_row" class="btn btn-primary">add</button>
        <button type="button" id="btn_report_seriais" class="btn btn-primary">Relatório</button>
        <button type="button" id="fecharrm" name="fecharrm" class="btn btn-primary" disabled>Fechar RRM</button>
      </div>   <!-- INCLUIR MENSAGEM DE SUCESSO AO FECHAR RRM -->

    </div>
  </div>
</div>
