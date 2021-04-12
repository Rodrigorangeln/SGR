<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Seriais</title>

</head>
<body>

<?php

session_start();

/* if((!isset ($_SESSION['user']) == true) and (!isset ($_SESSION['pass']) == true))
{
    unset($_SESSION['user']);
    unset($_SESSION['pass']);
    header('location:index.php');
} */

$cliente = $_GET['cliente'];
$nf = $_GET['nf'];
$rrm = $_GET['rrm'];

?>

<div class="text-primary">
    Cliente:
    <span id="cliente"><strong><?php echo $cliente; ?></strong></span>
    &nbsp &nbsp &nbsp &nbsp
    <span id="NF"><strong><?php echo $nf; ?></strong></span>
</div>


<table border="1">
    <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Cód. Modelo</th>
            <th scope="col">Modelo</th>
            <th scope="col">Serial 1</th>
            <th scope="col">Serial 2</th>
            <th scope="col">Bipado em</th>
        </tr>
    </thead>
    <tbody>

        <?php
        require_once 'db_connect.php';
        
        $query = "SELECT s.cod_modelo, s.serial1, s.serial2, m.modelo, s.dt_entr FROM seriais s, cd_aparelhos m WHERE s.rrm = '$rrm' and s.cod_modelo = m.cod";
        $resultQuery = mysqli_query($connect, $query);
        
        $i = 1;
        while ($row = mysqli_fetch_assoc($resultQuery)) {
            echo ("<tr>");
            echo ("<th>" . $i . "</th>");
            echo ("<td>") . $row["cod_modelo"] . ("</td>");
            echo ("<td>") . $row["modelo"] . ("</td>");
            echo ("<td>") . $row["serial1"] . ("</td>");
            echo ("<td>") . $row["serial2"] . ("</td>");
            echo ("<td>") . $row["dt_entr"] . ("</td>");
            echo ("</tr>");
            $i++;
        };
        ?>
    </tbody>
</table>

<?php

/* header ("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
header ("Last-Modified: " . gmdate("D,d M YH:i:s") . " GMT");
header("Cache-Control: no-cache, must-revalidate");
header("Pragma: no-cache"); */
header("Content-type: application/x-msexcel");
//header ("Content-type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
header("Content-Disposition: attachment; filename=\"seriais.xls\"");
//header ("Content-ContentEncoding: System.Text.Encoding.Default");
//header ("Content-Description: PHP Generated Data" );

//echo $html;
?>

</body>

</html>