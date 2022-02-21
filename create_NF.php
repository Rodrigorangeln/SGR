<!-- <!DOCTYPE html>
<link rel="shortcut icon" href="./imagens/logo.ico" />
<head>

<link href="./css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
<div class="progress">
  <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 95%"></div>
</div>
</body>
 -->

<?php
date_default_timezone_set('Brazil/East');

session_start();
$user = $_SESSION['user'];

require_once 'db_connect.php';

if (isset($_POST['btn-Cadastrar'])):
    $NF = mysqli_escape_string($connect, $_POST['NF']);
    $RRM = mysqli_escape_string($connect, $_POST['RRM']);
    $cod_cliente = mysqli_escape_string($connect, $_POST['cod_cliente']);
    $dt_emissao = mysqli_escape_string($connect, $_POST['dt_emissao']);
    //$dt_entrada = mysqli_escape_string($connect, $_POST['dt_entrada']);

    $i=0;
    while ($i < "30") {
      if ((($_POST['cod'.$i]) <> "") && ($_POST['quant'.$i]) <> "") {
        $cod_modelo = mysqli_escape_string($connect, $_POST['cod'.$i]);
        $quant = mysqli_escape_string($connect, $_POST['quant'.$i]);
        $item = mysqli_escape_string($connect, $_POST['item'.$i]);

        $sql = "INSERT INTO recep_nf (nf, RRM, cod_cliente, nf_emissao, nf_entrada, cod_modelo, quant, user, item) VALUES 
        ('$NF','$RRM', '$cod_cliente', '$dt_emissao', now(), '$cod_modelo', '$quant', '$user', '$item')";

        mysqli_query($connect, $sql);
      }
        $i++;  
    }

    $sql = "INSERT INTO rrm (num, aberta) VALUES ('$RRM', '1')";
    mysqli_query($connect, $sql);

    header("Location: rrms_abertas.php"); 
    exit();

endif;
?>