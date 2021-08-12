<?php
require_once 'db_connect.php';
require 'vendor/autoload.php';
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

$htmlString = "
<tr>
    <td>Cliente: <strong>" . $cliente ."  ". $nf . "</strong></td>
</tr>

<table>
    <thead>
        <tr>
            <th>#</th>
            <th>Cód. Modelo</th>
            <th>Modelo</th>
            <th>Serial 1</th>
            <th>Serial 2</th>
            <th>Bipado em</th>
        </tr>
    </thead>";


$query = "SELECT s.cod_modelo, s.serial1, s.serial2, m.modelo, s.dt_entr FROM seriais s, cd_aparelhos m WHERE s.rrm = '$rrm' and s.cod_modelo = m.cod";
$resultQuery = mysqli_query($connect, $query);

$i = 1;
while ($row = mysqli_fetch_assoc($resultQuery)) {
    $htmlString .=  "<tr>";
    $htmlString .=  "<th>" . $i . "</th>";
    $htmlString .=  "<td>" . $row["cod_modelo"] . "</td>";
    $htmlString .=  "<td>" . $row["modelo"] . "</td>";
    $htmlString .=  "<td>" . $row["serial1"] . "</td>";
    $htmlString .=  "<td>" . $row["serial2"] . "</td>";
    $htmlString .=  "<td>" . $row["dt_entr"] . "</td>";
    $htmlString .=  "</tr>";
    $i++;
};
$htmlString .=  "</table>";


$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
$spreadsheet = $reader->loadFromString($htmlString);
$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save('zseriaisRRM'.$rrm.'.xls');
//$writer->save('seriaisRRM'.$rrm.'.xls');

/* header("Content-type: application/x-msexcel");
header("Content-Disposition: attachment; filename=\"write.xls\""); */


    // Define o tempo máximo de execução em 0 para as conexões lentas
    set_time_limit(0);
    // Arqui você faz as validações e/ou pega os dados do banco de dados
    $arquivoNome = 'zseriaisRRM'.$rrm.'.xls'; // nome do arquivo que será enviado p/ download
   
    //$arquivoLocal = './xls/'.$arquivoNome; // caminho absoluto do arquivo
    $arquivoLocal = $arquivoNome; // caminho absoluto do arquivo

    // Verifica se o arquivo não existe
    if (!file_exists($arquivoLocal)) {
    // Exiba uma mensagem de erro caso ele não exista
    exit;
    }
    // Aqui você pode aumentar o contador de downloads
    // Definimos o novo nome do arquivo
    $novoNome = 'seriaisRRM'.$rrm.'.xls';
    // Configuramos os headers que serão enviados para o browser
    header('Content-Description: File Transfer');
    header('Content-Disposition: attachment; filename="'.$novoNome.'"');
    header('Content-Type: application/octet-stream');
    header('Content-Transfer-Encoding: binary');
    header('Content-Length: ' . filesize($arquivoNome));
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Expires: 0');
    // Envia o arquivo para o cliente
    readfile($arquivoNome);

?>


<!-- <script>
     window.location.href = "rrms_fechadas.php"
</script> -->



