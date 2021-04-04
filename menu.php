<!DOCTYPE html5>
<link rel="shortcut icon" href="./imagens/logo.ico" />

<head>
  <title>SGR - Nortcom</title>
  <script src="./js/jquery-3.5.1.min.js"></script>
  <script src="./js/popper.min.js"></script>
  <link href="./css/bootstrap.min.css" rel="stylesheet">
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>

</head>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <!-- fixed-top -->
  <a class="navbar-brand" href="#">
    <img src="./imagens/logo.ico" width="30" height="30" alt="">
  </a>
  <div class="navbar-nav">
    <a class="nav-item nav-link" id="menu_recep" href="recep_NF.php">Recepção NF</a>
    <a class="nav-item nav-link" id="menu_rrms" href="rrms_abertas.php">RRMs Abertas</a>
    <a class="nav-item nav-link" id="menu_rrms_fechadas" href="rrms_fechadas.php">RRMs Fechadas</a>
    <a class="nav-item nav-link" id="menu_teste" href="teste_inicial.php">Teste Inicial</a>
    <a class="nav-item nav-link" id="menu_eletrica" href="eletrica.php">Elétrica</a>
    <a class="nav-item nav-link" id="menu_cosmetica" href="cosmetica.php">Cosmética</a>
    <a class="nav-item nav-link" id="menu_teste_final" href="teste_final.php">Teste Final</a>
    <a class="nav-item nav-link" id="menu_embalagem" href="embalagem.php">Embalagem</a>
    <a class="nav-item nav-link" id="menu_expedicao" href="#">Expedição</a>
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" data-toggle="dropdown" id="menu_relatorios" href="#">Consultas</a>
      <div class="dropdown-menu bg-primary">
        <a class="dropdown-item bg-primary text-white" href="report_produtividade.php">Produtividade</a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item bg-primary text-white" href="report_serial.php">Serial</a> 
      </div>
    </li>
  </div>
  
  <span class="col-2 text-right">
    <b class="text-white" id="user"> <?php echo $_SESSION['name'] . " | "; ?> </b>
    <b class="text-white"> <?php echo date('d-m-Y'); ?> </b>
    <a class="text-white" href="logoff.php"> Sair </a>
  </span>
  <!--     <ul class="navbar-nav ml-auto nav navbar-nav navbar-right">
    <li><a class="nav-item nav-link" href="logout.php">Sair</a></li>
  </ul> -->
</nav>