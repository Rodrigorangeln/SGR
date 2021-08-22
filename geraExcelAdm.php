<?php
require_once 'db_connect.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

$styleArrayFirstRow = [
    'font' => [
        'bold' => true,
    ]
];

$de = $_GET['de'];
$ate = $_GET['ate'];

//set first row bold
$sheet->getStyle('A1:AF1:' . '1')->applyFromArray($styleArrayFirstRow);

$sheet->setCellValue('A1', 'RRM');
$sheet->setCellValue('B1', 'Cód Modelo');
$sheet->setCellValue('C1', 'Serial 1');
$sheet->setCellValue('D1', 'Serial 2');
$sheet->setCellValue('E1', 'Usuário - Entrada');
$sheet->setCellValue('F1', 'Data de entrada');
$sheet->setCellValue('G1', 'Local');
$sheet->setCellValue('H1', 'Teste Cosmética 1');
$sheet->setCellValue('I1', 'Teste Cosmética 2');
$sheet->setCellValue('J1', 'Teste Cosmética 3');
$sheet->setCellValue('K1', 'Teste Cosmética 4');
$sheet->setCellValue('L1', 'Teste Elétrica 1');
$sheet->setCellValue('M1', 'Comp. Elétrica 1');
$sheet->setCellValue('N1', 'Interv. Elétrica1');
$sheet->setCellValue('O1', 'Teste Elétrica 2');
$sheet->setCellValue('P1', 'Comp. Elétrica 2');
$sheet->setCellValue('Q1', 'Interv. Elétrica 2');
$sheet->setCellValue('R1', 'Usuário - Teste Inicial');
$sheet->setCellValue('S1', 'Data Teste Inicial');
$sheet->setCellValue('T1', 'Usuário - Cosmética');
$sheet->setCellValue('U1', 'Data Cosmética');
$sheet->setCellValue('V1', 'Usuário - Elétrica');
$sheet->setCellValue('W1', 'Data Elétrica');
$sheet->setCellValue('X1', 'Usuário - Teste Final');
$sheet->setCellValue('Y1', 'Data Teste Final');
$sheet->setCellValue('Z1', 'Usuário - Embalagem');
$sheet->setCellValue('AA1', 'Smart Card');
$sheet->setCellValue('AB1', 'Data Embalagem');
$sheet->setCellValue('AC1', 'Número Caixa');
$sheet->setCellValue('AD1', 'Usuário - Expedição');
$sheet->setCellValue('AE1', 'Data Expedição');
$sheet->setCellValue('AF1', 'NF Expedição');

$query = "SELECT * FROM seriais where dt_entr BETWEEN '$de' AND '$ate'";
$resultQuery = mysqli_query($connect, $query);

$queryUsuarios = "SELECT registration, name FROM cd_usuarios";
$resultQueryUsuarios = mysqli_query($connect, $queryUsuarios);
$arrayMatricula = array();
$arrayName = array();
while ($rows = mysqli_fetch_assoc($resultQueryUsuarios)) {
    //array_push ($retorno_mod, $rows['cod_modelo']." - ".$rows["modelo"]);
    $matricula = $rows['registration'];
    $name = $rows['name'];
    array_push($arrayMatricula, $matricula);
    array_push($arrayName, $name);
}

$i = 2;
while ($row = mysqli_fetch_assoc($resultQuery)) {
    $sheet->setCellValue('A' . $i, $row["rrm"]);
    $sheet->setCellValue('B' . $i, $row["cod_modelo"]);
    $sheet->setCellValue('C' . $i, $row["serial1"]);
    $sheet->setCellValue('D' . $i, $row["serial2"]);

    $sheet->setCellValue('E' . $i, usuario($row["user_entr"], $arrayMatricula, $arrayName));
    //$sheet->setCellValue('E' . $i, $row["user_entr"]);

    $sheet->setCellValue('F' . $i, $row["dt_entr"]);

    $sheet->setCellValue('G' . $i, local($row["local"]));

    $sheet->setCellValue('H' . $i, $row["t_cosm1"]);
    $sheet->setCellValue('I' . $i, $row["t_cosm2"]);
    $sheet->setCellValue('J' . $i, $row["t_cosm3"]);
    $sheet->setCellValue('K' . $i, $row["t_cosm4"]);
    $sheet->setCellValue('L' . $i, $row["t_eletr1"]);
    $sheet->setCellValue('M' . $i, $row["eletr1comp"]);
    $sheet->setCellValue('N' . $i, $row["eletr1interv"]);
    $sheet->setCellValue('O' . $i, $row["t_eletr2"]);
    $sheet->setCellValue('P' . $i, $row["eletr2comp"]);
    $sheet->setCellValue('Q' . $i, $row["eletr2interv"]);

    if ($row["user_testeinicial"] != ""){
        $sheet->setCellValue('R' . $i, usuario($row["user_testeinicial"], $arrayMatricula, $arrayName));
    } else {
        $sheet->setCellValue('R' . $i, "-");
    }

    $sheet->setCellValue('S' . $i, $row["dt_testeinicial"]);

    if ($row["user_cosmetica"] != ""){
        $sheet->setCellValue('T' . $i, usuario($row["user_cosmetica"], $arrayMatricula, $arrayName));
    } else {
        $sheet->setCellValue('T' . $i, "-");
    }

    $sheet->setCellValue('U' . $i, $row["dt_cosmetica"]);

    if ($row["user_eletrica"] != ""){
        $sheet->setCellValue('V' . $i, usuario($row["user_eletrica"], $arrayMatricula, $arrayName));
    } else {
        $sheet->setCellValue('V' . $i, "-");
    }
    
    $sheet->setCellValue('W' . $i, $row["dt_eletrica"]);
    
    if ($row["user_testefinal"] != ""){
        $sheet->setCellValue('X' . $i, usuario($row["user_testefinal"], $arrayMatricula, $arrayName));
    } else {
        $sheet->setCellValue('X' . $i, "-");
    }
    
    $sheet->setCellValue('Y' . $i, $row["dt_testefinal"]);
    
    //$sheet->setCellValue('Z' . $i, 'Usuário Embalagem');
    $sheet->setCellValue('AA' . $i, $row["smartcard"]);
    //$sheet->setCellValue('AB' . $i, 'Data embalagem');
    $sheet->setCellValue('AC' . $i, $row["n_caixa"]);
    //$sheet->setCellValue('AD' . $i, 'Usuário Expedição');
    //$sheet->setCellValue('AE' . $i, 'Data Expedição');
    //$sheet->setCellValue('AF' . $i, 'NF Expedição');
    $i++;
};

$writer = new Xlsx($spreadsheet);
$writer->save('zSeriaisAdm.xlsx');

// Define o tempo máximo de execução em 0 para as conexões lentas
set_time_limit(0);
// Arqui você faz as validações e/ou pega os dados do banco de dados
$arquivoNome = 'zSeriaisAdm.xlsx'; // nome do arquivo que será enviado p/ download

//$arquivoLocal = './xls/'.$arquivoNome; // caminho absoluto do arquivo
//$arquivoLocal = $arquivoNome; // caminho absoluto do arquivo

// Verifica se o arquivo não existe
if (!file_exists($arquivoNome)) {
// Exiba uma mensagem de erro caso ele não exista
exit;
}
// Aqui você pode aumentar o contador de downloads
// Definimos o novo nome do arquivo
$novoNome = 'SeriaisAdm.xlsx';
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


///////////////////////////////////
/* $htmlString = '<table>
                  <tr>
                      <td>Hello World</td>
                  </tr>
                  <tr>
                      <td>Hello<br />World</td>
                  </tr>
                  <tr>
                      <td>Hello<br>World</td>
                  </tr>
              </table>';

$reader = new \PhpOffice\PhpSpreadsheet\Reader\Html();
$spreadsheet = $reader->loadFromString($htmlString);

$writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xls');
$writer->save('zwrite.xls');  */

function local($id)
{
    if ($id == 0)
        $local = "Saiu";
    if ($id == 1)
        $local = "Recepção";
    if ($id == 2)
        $local = "Teste Inicial";
    if ($id == 3)
        $local = "Elétrica";
    if ($id == 4)
        $local = "Cosmética";
    if ($id == 5)
        $local = "Teste Final";
    if ($id == 6)
        $local = "Embalagem";
    if ($id == 7)
        $local = "Expedição";

    return $local;
}

function usuario($registration, $arrayMatricula, $arrayName)
{
    $i = 0;
    while ($registration != $arrayMatricula[$i]) {
        $i++;
    }
    return $arrayName[$i];
}
