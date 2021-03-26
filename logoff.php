<?php

//if (session_status() == PHP_SESSION_ACTIVE){
  //Apagando todos os dados da sessão:
  session_unset();
  //Destruindo a sessão:
  session_gc();
  session_destroy();
  header('location:index.php');

//}
?>