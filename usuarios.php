<script type="text/javascript" charset="UTF-8"></script>
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

$query = "SELECT * FROM cd_usuarios";
//mysqli_set_charset($connect, "utf8");
$resultQuery = mysqli_query($connect, $query);

?>
<html>
<!-- <span class="d-block p-2 bg-primary text-white text-center">>>> USUÁRIOS <<< </span> -->
<script src="./js/usuarios.js"></script>

  <button id="incluirUsuario" class="btn btn-outline-primary align-items-start ml-4 mt-3" type="button">Incluir usuário</button>

  <small class="form-text text-muted border border-primary float-right position-fixed" style="top: 60px; right: 1%;">
  &nbsp;Níveis de acesso: <br>
  &nbsp;0: &nbsp; Sem restrição. <br>
  &nbsp;1: &nbsp; RRMs Fechadas, Teste Inicial/ Final, Elétrica e Cosmética. <br>
  &nbsp;2: &nbsp; Nível 1 + Embalagem (-) Elétrica. (PRODUÇÃO) <br>
  &nbsp;3: &nbsp; Receção, RRms Abertas e Expedição. <br>
  </small>

<table class="table table-hover mt-3">
  <thead>
    <tr>
      <th scope="col" class="col-1">Matrícula</th>
      <th scope="col" class='w-25'>Usuário</th>
      <th scope="col" class="col-1">Nível</th>
      <th scope="col" class="col-1"></th>
      <th scope="col"></th>
    </tr>
  </thead>

  <tbody>

    <?php
    require_once 'db_connect.php';

    while ($row = mysqli_fetch_assoc($resultQuery)) {
      //echo ("<tr onclick=ModalRRMFechada($rrm)>");
      echo ("<tr>");
      /* echo ("<tr data-toggle='modal' data-target='#ModalRRMFechado'>") ; */
      echo ("<td>") . $row["registration"] . ("</td>");
      echo ("<td>") . $row["name"] . ("</td>");
      echo ("<td>") . $row["nivel"] . ("</td>");
      echo ("<td>
      <div class='btn-group btn-group-toggle' data-toggle='buttons'>
      <label class='btn btn-outline-primary btn-sm active'>
      <input type='radio' name='options' id='option1' autocomplete='off' checked> Ativo
      </label>
      <label class='btn btn-outline-danger btn-sm'>
      <input type='radio' name='options' id='option2' autocomplete='off'> Inativo
      </label>
      </div>
      </td>");
      echo ("<td><button id='alterarSenha' class='btn btn-sm btn-outline-primary' type='button'>Alterar Senha</button></td>");
      /* echo ("<td>").$rowrrm["nf"].("</td>");
  echo ("<td>").$rowrrm["nf_emissao"].("</td>"); */
      echo ("</tr>");
    };
    //mysqli_close($connect);
    ?>

  </tbody>
</table>



<div class="modal fade" id="modalIncluiUsuario" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cadastro de usuário</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>...</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
            </div>
        </div>
    </div>
</div>