<?php

session_start();

$user = $_SESSION['user'];

header('Content-type: application/json');
require_once 'db_connect.php';


$rrm = $_POST['rrm'];
$cod_modelo = $_POST['cod_m'];
$item = $_POST['item'];
$s1 = $_POST['serial1'];
$s2 = $_POST['serial2'];
$loc = 1; // Posto Teste inicial


$query = "INSERT INTO seriais (rrm, item, cod_modelo, serial1, serial2, user_entr, dt_entr, local, 
t_cosm1, t_cosm2, t_cosm3, t_cosm4, t_eletr1, eletr1comp, eletr1interv,
t_eletr2, eletr2comp, eletr2interv, user_testeinicial, dt_testeinicial,
user_cosmetica, dt_cosmetica, user_eletrica, dt_eletrica, user_testefinal, dt_testefinal, n_caixa, smartcard) VALUES 
('$rrm', '$item','$cod_modelo', '$s1', '$s2', '$user', now(), '$loc',
null,null,null,null,null,null,null,
null,null,null,null,null,
null,null,null,null,null,null,null,null)";

/* $query = "INSERT INTO seriais VALUES 
('$rrm','$cod_modelo', '$s1', '$s2', '$user', now(), '$loc',
null,null,null,null,null,null,null,
null,null,null,null,'0000-00-00',
null,'0000-00-00',null,'0000-00-00',null,'0000-00-00',null,null)"; */

/* $query = "INSERT INTO seriais (rrm, cod_modelo, serial1, serial2, local, user_entr, dt_entr) VALUES 
('$rrm','$cod_modelo', '$s1', '$s2', '$loc', '$user', now())"; */

/* $query = "INSERT INTO seriais SET 
rrm = '$rrm', 
item = '$item', 
cod_modelo = '$cod_modelo', 
serial1 = '$s1', 
serial2 = '$s2', 
user_entr = '$user', 
dt_entr = now(), 
local = '$loc', 
t_cosm1 = '', 
t_cosm2 = '', 
t_cosm3 = '', 
t_cosm4 = '', 
t_eletr1 = '', 
eletr1comp = '', 
eletr1interv = '',
t_eletr2 = '', 
eletr2comp = '', 
eletr2interv = '', 
user_testeinicial = '', 
dt_testeinicial = '0000-00-00',
user_cosmetica = '', 
dt_cosmetica = '0000-00-00', 
user_eletrica = '', 
dt_eletrica = '0000-00-00', 
user_testefinal = '', 
dt_testefinal = '0000-00-00', 
n_caixa = '', 
smartcard = ''"; */



mysqli_query($connect, $query);
