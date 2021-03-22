<?php
$servername = "localhost";
$username = "root";
$password = "timeisgold";
$db_name = "db_sgr";

$connect = mysqli_connect($servername, $username, $password, $db_name);

if (mysqli_connect_error()):
	echo "Falha no BD: ".mysqli_connect_error();
endif;