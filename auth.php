<?php
require_once 'db_connect.php';

session_start();

$user = $_POST['user'];
$pass = $_POST['pass'];

$query = "SELECT * FROM cd_usuarios WHERE registration = '$user' AND pass= '$pass'";
$resultQuery = mysqli_query($connect, $query);

if($resultQuery->num_rows)
{
$_SESSION['user'] = $user;
$_SESSION['pass'] = $pass;
header('location:recep_NF.php');
}
else{
  unset ($_SESSION['user']);
  unset ($_SESSION['pass']);
  header('location:index.php');

  }
?>
