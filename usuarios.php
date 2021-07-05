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

$query = "SELECT * FROM cd_usuarios where ativo = '1'";
//mysqli_set_charset($connect, "utf8");
$resultQuery = mysqli_query($connect, $query);

?>
<html>
<!-- <span class="d-block p-2 bg-primary text-white text-center">>>> USUÁRIOS <<< </span> -->
<script src="./js/usuarios.js"></script>

<button id="incluirUsuario" class="btn btn-outline-primary align-items-start ml-4 mt-3" type="button">Incluir usuário</button>

<div class="form-check form-check-inline align-bottom ml-5">Listar: &nbsp;
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radioAtivos" checked>
  <label class="form-check-label" for="radioAtivos">Ativos</label>
</div>
<div class="form-check form-check-inline align-bottom">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="radioInativos" >
  <label class="form-check-label" for="radioInativos">Inativos</label>
</div>


<small class="form-text text-muted border border-primary float-right position-fixed" style="top: 60px; right: 1%;">
  &nbsp;Níveis de acesso: <br>
  &nbsp;0: &nbsp; Sem restrição. <br>
  &nbsp;1: &nbsp; Elétrica. <br>
  &nbsp;2: &nbsp; Produção. <br>
  &nbsp;3: &nbsp; Recepção e Expedição. &nbsp;
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

  <tbody id="body">

    <?php
    require_once 'db_connect.php';

    
    ?>

  </tbody>
</table>

</html>

<div class="modal fade" id="modalIncluiUsuario" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cadastro de usuário</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input class="form-control col-md-5 mb-2" id="inputMat" placeholder="Matrícula">
      <input class="form-control mb-2" id="inputNome" placeholder="Nome">
      <select id="selectNivel" class="form-control col-md-5 mb-2">
      <option selected disabled>Nível de acesso</option>
      <option>0</option>
      <option>1</option>
      <option>2</option>
      <option>3</option>
      <input type="password"class="form-control col-md-5 mb-2" id="inputPass" placeholder="Senha">
      </select>
      </div>
      <div class="modal-footer">
        <button type="button" id="btnCadastrar" class="btn btn-primary">Cadastrar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="modalAlteraSenha" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Alterar senha</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <input type="password" class="form-control col-md-5" id="newpass" placeholder="Digite a nova senha">
      </div>
      <div class="modal-footer">
        <button type="button" id="btnAlterarSenha" class="btn btn-primary">Alterar</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
        <!-- <button type="button" class="btn btn-primary">Salvar mudanças</button> -->
      </div>
    </div>
  </div>
</div>