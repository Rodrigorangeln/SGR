<?php
require_once 'db_connect.php';

session_start();

$user = $_POST['user'];
$pass = $_POST['pass'];

$query = "SELECT * FROM cd_usuarios WHERE registration = '$user' AND pass= '$pass' AND ativo = '1'";
$resultQuery = mysqli_query($connect, $query);

if ($resultQuery->num_rows) {
  $_SESSION['user'] = $user;
  $_SESSION['pass'] = $pass;

  $row = mysqli_fetch_assoc($resultQuery);
  $_SESSION['name'] = $row['name'];
  $_SESSION['nivel'] = $row['nivel'];

  /* Níveis de acesso:

0: Tudo, inclusive consultas (nortcom).
1: Somente elétrica
2: Somente postos */

  if ($_SESSION['nivel'] == '1') {
    header('location:eletrica.php');
  } else if ($_SESSION['nivel'] == '2') {
    header('location:teste_inicial.php');
  } else if ($_SESSION['nivel'] == '0') {
    header('location:recep_NF.php');
  } else if ($_SESSION['nivel'] == '3') {
    header('location:recep_NF.php');
  }
} else {
  unset($_SESSION['user']);
  unset($_SESSION['pass']);

  session_destroy();
  header('location:index.php?erro=falhalogin');
}
