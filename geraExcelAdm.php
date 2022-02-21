<?php
require_once 'db_connect.php';
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

//$sheet->getColumnDimension('I')->setAutoSize(true);

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
$sheet->setCellValue('B1', 'NF entrada');
$sheet->setCellValue('C1', 'Data emissão NF');
$sheet->setCellValue('D1', 'Data entrada NF');
$sheet->setCellValue('E1', 'Cliente');
$sheet->setCellValue('F1', 'Cód modelo');

$sheet->setCellValue('G1', 'Serial 1');
$sheet->setCellValue('H1', 'Serial 2');
$sheet->setCellValue('I1', 'Smart card');
$sheet->setCellValue('J1', 'Entrada do serial - Data e hora');
$sheet->setCellValue('K1', 'Usuário de entrada');
$sheet->setCellValue('L1', 'TI Elétrico 1');
$sheet->setCellValue('M1', 'TI Elétrico 2');
$sheet->setCellValue('N1', 'TI Cosmético 1');
$sheet->setCellValue('O1', 'TI Cosmético 2');
$sheet->setCellValue('P1', 'TI Cosmético 3');
$sheet->setCellValue('Q1', 'TI Cosmético 4');
$sheet->setCellValue('R1', 'Teste Inicial - Data e hora');
$sheet->setCellValue('S1', 'Usuário - Teste Inicial');
$sheet->setCellValue('T1', 'Reparo Elétrico 1');
$sheet->setCellValue('U1', 'Componente 1');
$sheet->setCellValue('V1', 'Intervenção 1');
$sheet->setCellValue('W1', 'Reparo Elétrico 2');
$sheet->setCellValue('X1', 'Componente 2');
$sheet->setCellValue('Y1', 'Intervenção 2');
$sheet->setCellValue('Z1', 'Reparo Elétrico - Data e hora');
$sheet->setCellValue('AA1', 'Usuário - Reparo Elétrico');
$sheet->setCellValue('AB1', 'Reparo Cosmético 1');
$sheet->setCellValue('AC1', 'Reparo Cosmético 2');
$sheet->setCellValue('AD1', 'Reparo Cosmético 3');
$sheet->setCellValue('AE1', 'Reparo Cosmético 4');
$sheet->setCellValue('AF1', 'Reparo Cosmético - Data e hora');
$sheet->setCellValue('AG1', 'Usuário - Reparo Cosmético');
$sheet->setCellValue('AH1', 'Teste Final (A/R)');
$sheet->setCellValue('AI1', 'TF Elétrico 1');
$sheet->setCellValue('AJ1', 'TF Elétrico 2');
$sheet->setCellValue('AK1', 'TF Cosmético 1');
$sheet->setCellValue('AL1', 'TF Cosmético 2');
$sheet->setCellValue('AM1', 'TF Cosmético 3');
$sheet->setCellValue('AN1', 'TF Cosmético 4');
$sheet->setCellValue('AO1', 'Teste Final - Data e hora');
$sheet->setCellValue('AP1', 'Usuário - Teste Final');

$sheet->setCellValue('AQ1', 'Reparo Elétrico 1 REP.');

$sheet->setCellValue('AR1', 'Componente 1 REP.');
$sheet->setCellValue('AS1', 'Intervenção 1 REP');

$sheet->setCellValue('AT1', 'Reparo Elétrico 2 REP.');

$sheet->setCellValue('AU1', 'Componente 2 REP.');
$sheet->setCellValue('AV1', 'Intervenção 2 REP');

$sheet->setCellValue('AW1', 'Reparo Elétrico 3 REP.');

$sheet->setCellValue('AX1', 'Componente 3 REP'); //Incluído após reprovação
$sheet->setCellValue('AY1', 'Intervenção 3 REP');
$sheet->setCellValue('AZ1', 'TF Elétrico - Data e hora');
$sheet->setCellValue('BA1', 'Usuário - TF Elétrico');
$sheet->setCellValue('BB1', 'TF Cosmético +1'); //Incluído após reprovação
$sheet->setCellValue('BC1', 'TF Cosmético +2');
$sheet->setCellValue('BD1', 'TF Cosmético +3');
$sheet->setCellValue('BE1', 'TF Cosmético +4');
$sheet->setCellValue('BF1', 'TF Cosmético - Data e hora');
$sheet->setCellValue('BG1', 'Usuário - TF Cosmético');
$sheet->setCellValue('BH1', 'Teste Final 2 (A/R)');
$sheet->setCellValue('BI1', 'Teste Final 2 - Data e hora');
$sheet->setCellValue('BJ1', 'Usuário - Teste Final 2');
$sheet->setCellValue('BK1', 'N da caixa');
$sheet->setCellValue('BL1', 'Embalagem - Data e hora');
$sheet->setCellValue('BM1', 'Usuário - Embalagem');
$sheet->setCellValue('BN1', 'Expedição - NF');
$sheet->setCellValue('BO1', 'Expedição - Data e hora');
$sheet->setCellValue('BP1', 'Expedição - Usuário');
$sheet->setCellValue('BQ1', 'Status');

//$dtAte = new DateTime($ate);

//$dtAte->add(new DateInterval("P1D"));
//$dtAte = urlEncode(date("Y-m-d"));

$de = $de . " 00:00:00";
$ate = $ate . " 23:59:59";

$query = "SELECT * FROM seriais where dt_entr BETWEEN '$de' AND '$ate'";

$resultQuery = mysqli_query($connect, $query);

$queryUsuarios = "SELECT registration, name FROM cd_usuarios";
$resultQueryUsuarios = mysqli_query($connect, $queryUsuarios);
$arrayMatricula = array();
$arrayName = array();
while ($rows = mysqli_fetch_assoc($resultQueryUsuarios)) {
    //array_push ($retorno_mod, $rows['cod_modelo']." - ".$rows["modelo"]);
    array_push($arrayMatricula, $rows['registration']);
    array_push($arrayName, $rows['name']);
}

$queryNfe = "SELECT * FROM recep_nf";
$resultQueryNfe = mysqli_query($connect, $queryNfe);
$arrayNfe = array();
$arrayRRM = array();
$arrayDataNfe = array();
$arrayEmissaoNfe = array();
$arrayCliente = array();
while ($rowNfe = mysqli_fetch_assoc($resultQueryNfe)) {
    array_push($arrayNfe, $rowNfe['nf']);
    array_push($arrayRRM, $rowNfe['RRM']);
    array_push($arrayDataNfe, $rowNfe['nf_entrada']);
    array_push($arrayEmissaoNfe, $rowNfe['nf_emissao']);
    array_push($arrayCliente, $rowNfe['cod_cliente']);
}

$queryElet = "SELECT * FROM reparo_eletrico";
$resultQueryElet = mysqli_query($connect, $queryElet);
$arrayElet_rrm = array();
$arrayElet_serial1 = array();
$arrayElet_defeito = array();
$arrayElet_comp = array();
$arrayElet_intervencao = array();
$arrayElet_date = array();
$arrayElet_user = array();
while ($rowElet = mysqli_fetch_assoc($resultQueryElet)) {
    array_push($arrayElet_rrm, $rowElet['rrm']);
    array_push($arrayElet_serial1, $rowElet['serial1']);
    array_push($arrayElet_defeito, $rowElet['defeito']);
    array_push($arrayElet_comp, $rowElet['componente']);
    array_push($arrayElet_intervencao, $rowElet['intervencao']);
    array_push($arrayElet_date, $rowElet['date']);
    array_push($arrayElet_user, $rowElet['user']);
}

$queryCosm = "SELECT * FROM reparo_cosmetico";
$resultQueryCosm = mysqli_query($connect, $queryCosm);
$arrayCosm_rrm = array();
$arrayCosm_serial1 = array();
$arrayCosm_defeito = array();
$arrayCosm_date = array();
$arrayCosm_user = array();
while ($rowCosm = mysqli_fetch_assoc($resultQueryCosm)) {
    array_push($arrayCosm_rrm, $rowCosm['rrm']);
    array_push($arrayCosm_serial1, $rowCosm['serial1']);
    array_push($arrayCosm_defeito, $rowCosm['defeito']);
    array_push($arrayCosm_date, $rowCosm['date']);
    array_push($arrayCosm_user, $rowCosm['user']);
}


$queryTF = "SELECT * FROM reprov WHERE posto = 'teste_final'";
$resultQueryTF = mysqli_query($connect, $queryTF);
$arrayTF_serial = array();
$arrayTF_rrm = array();
$arrayTF_user = array();
$arrayTF_data = array();
$arrayTF_cosm1 = array();
$arrayTF_cosm2 = array();
$arrayTF_cosm3 = array();
$arrayTF_cosm4 = array();
$arrayTF_eletr1 = array();
$arrayTF_eletr1comp = array();
$arrayTF_eletr1interv = array();
$arrayTF_eletr2 = array();
$arrayTF_eletr2comp = array();
$arrayTF_eletr2interv = array();
$arrayTF_eletr3 = array();
$arrayTF_eletr3comp = array();
$arrayTF_eletr3interv = array();
while ($rowTF = mysqli_fetch_assoc($resultQueryTF)) {
    array_push($arrayTF_serial, $rowTF['serial']);
    array_push($arrayTF_rrm, $rowTF['rrm']);
    array_push($arrayTF_user, $rowTF['user']);
    array_push($arrayTF_data, $rowTF['data']);
    array_push($arrayTF_cosm1, $rowTF['cosm1']);
    array_push($arrayTF_cosm2, $rowTF['cosm2']);
    array_push($arrayTF_cosm3, $rowTF['cosm3']);
    array_push($arrayTF_cosm4, $rowTF['cosm4']);
    array_push($arrayTF_eletr1, $rowTF['eletr1']);
    array_push($arrayTF_eletr1comp, $rowTF['eletr1comp']);
    array_push($arrayTF_eletr1interv, $rowTF['eletr1interv']);
    array_push($arrayTF_eletr2, $rowTF['eletr2']);
    array_push($arrayTF_eletr2comp, $rowTF['eletr2comp']);
    array_push($arrayTF_eletr2interv, $rowTF['eletr2interv']);
    array_push($arrayTF_eletr3, $rowTF['eletr3']);
    array_push($arrayTF_eletr3comp, $rowTF['eletr3comp']);
    array_push($arrayTF_eletr3interv, $rowTF['eletr3interv']);
}

$queryTF2 = "SELECT * FROM seriais WHERE semconserto is not null";
$resultQueryTF2 = mysqli_query($connect, $queryTF2);
$arrayTF2_serial = array();
$arrayTF2_rrm = array();
$arrayTF2_user = array();
$arrayTF2_data = array();
while ($rowTF2 = mysqli_fetch_assoc($resultQueryTF2)) {
    array_push($arrayTF2_serial, $rowTF2['serial1']);
    array_push($arrayTF2_rrm, $rowTF2['rrm']);
    array_push($arrayTF2_user, $rowTF2['user_semconserto']);
    array_push($arrayTF2_data, $rowTF2['dt_semconserto']);
}

$queryTFEletr = "SELECT * FROM reprov WHERE posto = 'eletrica'";
$resultQueryTFEletr = mysqli_query($connect, $queryTFEletr);
$arrayTFEletr_serial = array();
$arrayTFEletr_rrm = array();
$arrayTFEletr_user = array();
$arrayTFEletr_data = array();
$arrayTFEletr1 = array();
$arrayTFEletr1comp = array();
$arrayTFEletr1interv = array();
$arrayTFEletr2 = array();
$arrayTFEletr2comp = array();
$arrayTFEletr2interv = array();
$arrayTFEletr3 = array();
$arrayTFEletr3comp = array();
$arrayTFEletr3interv = array();
while ($rowTFEletr = mysqli_fetch_assoc($resultQueryTFEletr)) {
    array_push($arrayTFEletr_serial, $rowTFEletr['serial']);
    array_push($arrayTFEletr_rrm, $rowTFEletr['rrm']);
    array_push($arrayTFEletr_user, $rowTFEletr['user']);
    array_push($arrayTFEletr_data, $rowTFEletr['data']);
    array_push($arrayTFEletr1, $rowTFEletr['eletr1']);
    array_push($arrayTFEletr1comp, $rowTFEletr['eletr1comp']);
    array_push($arrayTFEletr1interv, $rowTFEletr['eletr1interv']);
    array_push($arrayTFEletr2, $rowTFEletr['eletr2']);
    array_push($arrayTFEletr2comp, $rowTFEletr['eletr2comp']);
    array_push($arrayTFEletr2interv, $rowTFEletr['eletr2interv']);
    array_push($arrayTFEletr3, $rowTFEletr['eletr3']);
    array_push($arrayTFEletr3comp, $rowTFEletr['eletr3comp']);
    array_push($arrayTFEletr3interv, $rowTFEletr['eletr3interv']);
}

$queryTFCosm = "SELECT * FROM reprov WHERE posto = 'cosmetica'";
$resultQueryTFCosm = mysqli_query($connect, $queryTFCosm);
$arrayTFCosm_serial = array();
$arrayTFCosm_rrm = array();
$arrayTFCosm_user = array();
$arrayTFCosm_data = array();
$arrayTFCosm_cosm1 = array();
$arrayTFCosm_cosm2 = array();
$arrayTFCosm_cosm3 = array();
$arrayTFCosm_cosm4 = array();
while ($rowTFCosm = mysqli_fetch_assoc($resultQueryTFCosm)) {
    array_push($arrayTFCosm_serial, $rowTFCosm['serial']);
    array_push($arrayTFCosm_rrm, $rowTFCosm['rrm']);
    array_push($arrayTFCosm_user, $rowTFCosm['user']);
    array_push($arrayTFCosm_data, $rowTFCosm['data']);
    array_push($arrayTFCosm_cosm1, $rowTFCosm['cosm1']);
    array_push($arrayTFCosm_cosm2, $rowTFCosm['cosm2']);
    array_push($arrayTFCosm_cosm3, $rowTFCosm['cosm3']);
    array_push($arrayTFCosm_cosm4, $rowTFCosm['cosm4']);
}

$queryEmbalagem = "SELECT n_caixa, quant, data, user FROM embalagem";
$resultQueryEmbalagem = mysqli_query($connect, $queryEmbalagem);
$arrayEmb_ncaixa = array();
$arrayEmb_quant = array();
$arrayEmb_data = array();
$arrayEmb_user = array();
while ($rowEmbalagem = mysqli_fetch_assoc($resultQueryEmbalagem)) {
    //array_push ($retorno_mod, $rows['cod_modelo']." - ".$rows["modelo"]);
    array_push($arrayEmb_ncaixa, $rowEmbalagem['n_caixa']);
    array_push($arrayEmb_quant, $rowEmbalagem['quant']);
    array_push($arrayEmb_data, $rowEmbalagem['data']);
    array_push($arrayEmb_user, $rowEmbalagem['user']);
}

$querySeriais = "SELECT serial1, n_caixa FROM seriais where dt_entr BETWEEN '$de' AND '$ate'";
$resultQuerySeriais = mysqli_query($connect, $querySeriais);
$arraySerial1 = array();
$arrayNcaixa = array();
while ($rowSeriais = mysqli_fetch_assoc($resultQuerySeriais)) {
    //array_push ($retorno_mod, $rows['cod_modelo']." - ".$rows["modelo"]);
    array_push($arraySerial1, $rowSeriais['serial1']);
    array_push($arrayNcaixa, $rowSeriais['n_caixa']);
}

$queryExpedicao = "SELECT nf_saida, caixa, data_expedicao, user FROM expedicao";
$resultQueryExpedicao = mysqli_query($connect, $queryExpedicao);
$arrayExp_nfsaida = array();
$arrayExp_caixa = array();
$arrayExp_dataExp = array();
$arrayExp_user = array();
while ($rowExpedicao = mysqli_fetch_assoc($resultQueryExpedicao)) {
    //array_push ($retorno_mod, $rows['cod_modelo']." - ".$rows["modelo"]);
    array_push($arrayExp_nfsaida, $rowExpedicao['nf_saida']);
    array_push($arrayExp_caixa, $rowExpedicao['caixa']);
    array_push($arrayExp_dataExp, $rowExpedicao['data_expedicao']);
    array_push($arrayExp_user, $rowExpedicao['user']);
}


$i = 2;
while ($row = mysqli_fetch_assoc($resultQuery)) {
    $sheet->setCellValue('A' . $i, $row["rrm"]);
    
    $resultNFE = consultaNfe($row["rrm"], $arrayNfe,  $arrayDataNfe, $arrayEmissaoNfe, $arrayRRM);
    $sheet->setCellValue('B' . $i, $resultNFE['nfe']);
    $sheet->setCellValue('C' . $i, $resultNFE['emissao_nfe']);
    $sheet->setCellValue('D' . $i, $resultNFE['entrada_nfe']);
    $sheet->setCellValue('E' . $i, clienteNfe($row["rrm"], $arrayCliente, $arrayRRM));
    $sheet->setCellValue('F' . $i, $row["cod_modelo"]);

    $sheet->setCellValue('G' . $i, $row["serial1"]);
    $sheet->setCellValue('H' . $i, $row["serial2"]);
    $sheet->setCellValue('I' . $i, $row["smartcard"]);
    $sheet->setCellValue('J' . $i, $row["dt_entr"]);
    $sheet->setCellValue('K' . $i, usuario($row["user_entr"], $arrayMatricula, $arrayName));
    $sheet->setCellValue('L' . $i, $row["t_eletr1"]);
    $sheet->setCellValue('M' . $i, $row["t_eletr2"]);
    $sheet->setCellValue('N' . $i, $row["t_cosm1"]);
    $sheet->setCellValue('O' . $i, $row["t_cosm2"]);
    $sheet->setCellValue('P' . $i, $row["t_cosm3"]);
    $sheet->setCellValue('Q' . $i, $row["t_cosm4"]);
    $sheet->setCellValue('R' . $i, $row["dt_testeinicial"]);
    $sheet->setCellValue('S' . $i, usuario($row["user_testeinicial"], $arrayMatricula, $arrayName));

    $resultDefeitoElet = defeito_elet($row["serial1"], $arrayElet_defeito, $arrayElet_serial1, $arrayElet_comp, $arrayElet_intervencao, $arrayElet_date, $arrayElet_user);
    $sheet->setCellValue('T' . $i, $resultDefeitoElet['defeito1']);
    $sheet->setCellValue('U' . $i, $resultDefeitoElet['componente1']);
    $sheet->setCellValue('V' . $i, $resultDefeitoElet['intervencao1']);
    $sheet->setCellValue('W' . $i, $resultDefeitoElet['defeito2']);
    $sheet->setCellValue('X' . $i, $resultDefeitoElet['componente2']);
    $sheet->setCellValue('Y' . $i, $resultDefeitoElet['intervencao2']);
    $sheet->setCellValue('Z' . $i, $resultDefeitoElet['date']);
    $sheet->setCellValue('AA' . $i, usuario($resultDefeitoElet['user'], $arrayMatricula, $arrayName));

    $resultDefeitoCosm = defeito_cosm($row["serial1"], $arrayCosm_serial1, $arrayCosm_defeito, $arrayCosm_date, $arrayCosm_user);
    $sheet->setCellValue('AB' . $i, $resultDefeitoCosm['defeito1']);
    $sheet->setCellValue('AC' . $i, $resultDefeitoCosm['defeito2']);
    $sheet->setCellValue('AD' . $i, $resultDefeitoCosm['defeito3']);
    $sheet->setCellValue('AE' . $i, $resultDefeitoCosm['defeito4']);
    $sheet->setCellValue('AF' . $i, $resultDefeitoCosm['date']);
    $sheet->setCellValue('AG' . $i, usuario($resultDefeitoCosm['user'], $arrayMatricula, $arrayName));

    $resultTesteFinal1 = testeFinal1($row["rrm"], $row["serial1"], $row["dt_testefinal"],$arrayTF_rrm, $arrayTF_serial, $arrayTF_eletr1, $arrayTF_eletr2, $arrayTF_cosm1, $arrayTF_cosm2, $arrayTF_cosm3, $arrayTF_cosm4, $arrayTF_data, $arrayTF_user);
    $sheet->setCellValue('AH' . $i, $resultTesteFinal1['status']);
    $sheet->setCellValue('AI' . $i, $resultTesteFinal1['eletr1']);
    $sheet->setCellValue('AJ' . $i, $resultTesteFinal1['eletr2']);
    $sheet->setCellValue('AK' . $i, $resultTesteFinal1['cosm1']);
    $sheet->setCellValue('AL' . $i, $resultTesteFinal1['cosm2']);
    $sheet->setCellValue('AM' . $i, $resultTesteFinal1['cosm3']);
    $sheet->setCellValue('AN' . $i, $resultTesteFinal1['cosm4']);
    $sheet->setCellValue('AO' . $i, $resultTesteFinal1['data']);
    $sheet->setCellValue('AP' . $i, usuario($resultTesteFinal1['user'], $arrayMatricula, $arrayName));
    
    $resultTesteFinalEletr = testeFinalEletr($row["rrm"], $row["serial1"], $arrayTFEletr_rrm, $arrayTFEletr_serial, $arrayTFEletr1, $arrayTFEletr1comp, $arrayTFEletr1interv, $arrayTFEletr2, $arrayTFEletr2comp, $arrayTFEletr2interv, $arrayTFEletr3, $arrayTFEletr3comp, $arrayTFEletr3interv, $arrayTFEletr_data, $arrayTFEletr_user);

    $sheet->setCellValue('AQ' . $i, $resultTesteFinalEletr['defeito1']);
    
    $sheet->setCellValue('AR' . $i, $resultTesteFinalEletr['componente1']);
    $sheet->setCellValue('AS' . $i, $resultTesteFinalEletr['interv1']);

    $sheet->setCellValue('AT' . $i, $resultTesteFinalEletr['defeito2']);

    $sheet->setCellValue('AU' . $i, $resultTesteFinalEletr['componente2']);
    $sheet->setCellValue('AV' . $i, $resultTesteFinalEletr['interv2']);

    $sheet->setCellValue('AW' . $i, $resultTesteFinalEletr['defeito3']);

    $sheet->setCellValue('AX' . $i, $resultTesteFinalEletr['componente3']);
    $sheet->setCellValue('AY' . $i, $resultTesteFinalEletr['interv3']);
    $sheet->setCellValue('AZ' . $i, $resultTesteFinalEletr['data']);
    $sheet->setCellValue('BA' . $i, usuario($resultTesteFinalEletr['user'], $arrayMatricula, $arrayName));
    

    $resultTesteFinalCosm = testeFinalCosm($row["rrm"], $row["serial1"], $arrayTFCosm_rrm, $arrayTFCosm_serial, $arrayTFCosm_cosm1, $arrayTFCosm_cosm2, $arrayTFCosm_cosm3, $arrayTFCosm_cosm4, $arrayTFCosm_data, $arrayTFCosm_user);
    $sheet->setCellValue('BB' . $i, $resultTesteFinalCosm['cosmetico1']);
    $sheet->setCellValue('BC' . $i, $resultTesteFinalCosm['cosmetico2']);
    $sheet->setCellValue('BD' . $i, $resultTesteFinalCosm['cosmetico3']);
    $sheet->setCellValue('BE' . $i, $resultTesteFinalCosm['cosmetico4']);
    $sheet->setCellValue('BF' . $i, $resultTesteFinalCosm['data']);
    $sheet->setCellValue('BG' . $i, usuario($resultTesteFinalCosm['user'], $arrayMatricula, $arrayName));

    $resultTesteFinal2 = testeFinal2($row["rrm"], $row["serial1"], $arrayTF2_serial, $arrayTF2_rrm, $arrayTF2_user, $arrayTF2_data);
    $sheet->setCellValue('BH' . $i, $resultTesteFinal2['status']);
    $sheet->setCellValue('BI' . $i, $resultTesteFinal2['data']);
    $sheet->setCellValue('BJ' . $i, usuario($resultTesteFinal2['user'], $arrayMatricula, $arrayName));

    $resultNcaixa = ncaixa($row["serial1"], $arraySerial1, $arrayNcaixa);
    $sheet->setCellValue('BK' . $i, $resultNcaixa);

    $resultEmbalagem = embalagem($resultNcaixa, $arrayEmb_ncaixa, $arrayEmb_data, $arrayEmb_user);
    $sheet->setCellValue('BL' . $i, $resultEmbalagem['data']);
    $sheet->setCellValue('BM' . $i, usuario($resultEmbalagem['user'], $arrayMatricula, $arrayName));

    $resultexpedicao = expedicao($resultNcaixa, $arrayExp_nfsaida, $arrayExp_caixa, $arrayExp_dataExp, $arrayExp_user);
    $sheet->setCellValue('BN' . $i, $resultexpedicao['nf']);
    $sheet->setCellValue('BO' . $i, $resultexpedicao['data']);
    $sheet->setCellValue('BP' . $i, usuario($resultexpedicao['user'], $arrayMatricula, $arrayName));

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
header('Content-Disposition: attachment; filename="' . $novoNome . '"');
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
    if ($registration == null)
        return '';
    else {
        while (($registration != $arrayMatricula[$i]) && ($i < 200)) { // < 200 p evitar loop infinito em caso de usuário inválido no BD.
            $i++;
        }
        return $arrayName[$i];
    }
}

function consultaNfe($rrm, $arrayNfe, $arrayDataNfe, $arrayEmissaoNfe, $arrayRRM)
{
    $i = 0;
    while ($rrm != $arrayRRM[$i]) {
        $i++;
    }
    $result['nfe'] = $arrayNfe[$i];
    $result['entrada_nfe'] = $arrayDataNfe[$i];
    $result['emissao_nfe'] = $arrayEmissaoNfe[$i];

    return $result;
}

/* function dataNfe($rrm, $arrayDataNfe, $arrayRRM)
{
    $i = 0;
    while ($rrm != $arrayRRM[$i]) {
        $i++;
    }
    return $arrayDataNfe[$i];
} */

function clienteNfe($rrm, $arrayCliente, $arrayRRM)
{
    $i = 0;
    while ($rrm != $arrayRRM[$i]) {
        $i++;
    }
    return $arrayCliente[$i];
}

function defeito_elet($serial, $arrayElet_defeito, $arrayElet_serial1, $arrayElet_comp, $arrayElet_intervencao, $arrayElet_date, $arrayElet_user)
{
    $result['defeito1'] = '';
    $result['defeito2'] = '';
    $result['componente1'] = '';
    $result['componente2'] = '';
    $result['intervencao1'] = '';
    $result['intervencao2'] = '';
    $result['date'] = '';
    $result['user'] = '';
    for ($i = 0; $i <  sizeof($arrayElet_defeito); $i++) {
        if (($serial == $arrayElet_serial1[$i]) && ($result['defeito1'] == '')) {
            $result['defeito1'] = $arrayElet_defeito[$i];
            $result['componente1'] = $arrayElet_comp[$i];
            $result['intervencao1'] = $arrayElet_intervencao[$i];
            $result['date'] = $arrayElet_date[$i];
            $result['user'] = $arrayElet_user[$i];
            $i++;
        }
        if ($i < sizeof($arrayElet_defeito)) {
            if (($serial == $arrayElet_serial1[$i]) && ($result['defeito2'] == '')) {
                $result['defeito2'] = $arrayElet_defeito[$i];
                $result['componente2'] = $arrayElet_comp[$i];
                $result['intervencao2'] = $arrayElet_intervencao[$i];
                $i = sizeof($arrayElet_defeito);
            }
        }
    }
    return $result;
}

function defeito_cosm($serial, $arrayCosm_serial1, $arrayCosm_defeito, $arrayCosm_date, $arrayCosm_user)
{
    $result['defeito1'] = '';
    $result['defeito2'] = '';
    $result['defeito3'] = '';
    $result['defeito4'] = '';
    $result['date'] = '';
    $result['user'] = '';
    for ($i = 0; $i <  sizeof($arrayCosm_defeito); $i++) {
        if (($serial == $arrayCosm_serial1[$i]) && ($result['defeito1'] == '')) {
            $result['defeito1'] = $arrayCosm_defeito[$i];
            $result['date'] = $arrayCosm_date[$i];
            $result['user'] = $arrayCosm_user[$i];
            $i++;
        }
        if ($i <  sizeof($arrayCosm_defeito)) {
            if (($serial == $arrayCosm_serial1[$i]) && ($result['defeito2'] == '')) {
                $result['defeito2'] = $arrayCosm_defeito[$i];
                $i++;
            }
        }
        if ($i <  sizeof($arrayCosm_defeito)) {
            if (($serial == $arrayCosm_serial1[$i]) && ($result['defeito3'] == '')) {
                $result['defeito3'] = $arrayCosm_defeito[$i];
                $i++;
            }
        }
        if ($i <  sizeof($arrayCosm_defeito)) {
            if (($serial == $arrayCosm_serial1[$i]) && ($result['defeito4'] == '')) {
                $result['defeito4'] = $arrayCosm_defeito[$i];
                $i = sizeof($arrayCosm_defeito);
            }
        }
    }

    return $result;
}

function usuarioEmbalagem($n_caixa, $arrayN_caixa, $arrayUser)
{
    $i = 0;
    while ($n_caixa != $arrayN_caixa[$i]) { // && ($i < 999999)) {
        $i++;
    }
    return $arrayUser[$i];
}

function dataEmbalagem($n_caixa, $arrayN_caixa, $arrayData)
{
    $i = 0;
    while ($n_caixa != $arrayN_caixa[$i]) { // && ($i < 999999)) {
        $i++;
    }
    return $arrayData[$i];
}

function testeFinal1($rrm, $serial, $dt_testefinal, $arrayTF_rrm, $arrayTF_serial, $arrayTF_eletr1, $arrayTF_eletr2, $arrayTF_cosm1, $arrayTF_cosm2, $arrayTF_cosm3, $arrayTF_cosm4, $arrayTF_data, $arrayTF_user)
{
    $result['status'] = '';
    $result['eletr1'] = '';
    $result['eletr2'] = '';
    $result['cosm1'] = '';
    $result['cosm2'] = '';
    $result['cosm3'] = '';
    $result['cosm4'] = '';
    $result['data'] = '';
    $result['user'] = '';
    for ($i = 0; $i <  sizeof($arrayTF_serial); $i++) {
        if (($serial == $arrayTF_serial[$i]) && ($rrm == $arrayTF_rrm[$i])) {
            $result['status'] = "R";
            $result['eletr1'] = $arrayTF_eletr1[$i];
            $result['eletr2'] = $arrayTF_eletr2[$i];
            $result['cosm1'] = $arrayTF_cosm1[$i];
            $result['cosm2'] = $arrayTF_cosm2[$i];
            $result['cosm3'] = $arrayTF_cosm3[$i];
            $result['cosm4'] = $arrayTF_cosm4[$i];
            $result['data'] = $arrayTF_data[$i];
            $result['user'] = $arrayTF_user[$i];
        } 
    }

    if (($dt_testefinal != null) && ( $result['status'] != "R"))
    $result['status'] = "A";

    return $result;
}

function testeFinalEletr($rrm, $serial, $arrayTFEletr_rrm, $arrayTFEletr_serial, $arrayTFEletr1, $arrayTFEletr1comp, $arrayTFEletr1interv, $arrayTFEletr2, $arrayTFEletr2comp, $arrayTFEletr2interv, $arrayTFEletr3, $arrayTFEletr3comp, $arrayTFEletr3interv, $arrayTFEletr_data, $arrayTFEletr_user)
{
    $result['defeito1'] = '';
    $result['componente1'] = '';
    $result['interv1'] = '';
    $result['defeito2'] = '';
    $result['componente2'] = '';
    $result['interv2'] = '';
    $result['defeito3'] = '';
    $result['componente3'] = '';
    $result['interv3'] = '';
    $result['data'] = '';
    $result['user'] = '';
    for ($i = 0; $i <  sizeof($arrayTFEletr_serial); $i++) {
        if (($serial == $arrayTFEletr_serial[$i]) && ($rrm == $arrayTFEletr_rrm[$i])) {
            $result['defeito1'] = $arrayTFEletr1[$i];
            $result['componente1'] = $arrayTFEletr1comp[$i];
            $result['interv1'] = $arrayTFEletr1interv[$i];
            $result['defeito2'] = $arrayTFEletr2[$i];
            $result['componente2'] = $arrayTFEletr2comp[$i];
            $result['interv2'] = $arrayTFEletr2interv[$i];
            $result['defeito3'] = $arrayTFEletr3[$i];
            $result['componente3'] = $arrayTFEletr3comp[$i];
            $result['interv3'] = $arrayTFEletr3interv[$i];
            $result['data'] = $arrayTFEletr_data[$i];
            $result['user'] = $arrayTFEletr_user[$i];
        }
    }
    return $result;
}

function testeFinalCosm($rrm, $serial, $arrayTFCosm_rrm, $arrayTFCosm_serial, $arrayTFCosm_cosm1, $arrayTFCosm_cosm2, $arrayTFCosm_cosm3, $arrayTFCosm_cosm4, $arrayTFCosm_data, $arrayTFCosm_user)
{
    $result['cosmetico1'] = '';
    $result['cosmetico2'] = '';
    $result['cosmetico3'] = '';
    $result['cosmetico4'] = '';
    $result['data'] = '';
    $result['user'] = '';
    for ($i = 0; $i <  sizeof($arrayTFCosm_serial); $i++) {
        if (($serial == $arrayTFCosm_serial[$i]) && ($rrm == $arrayTFCosm_rrm[$i])) {
            $result['cosmetico1'] = $arrayTFCosm_cosm1[$i];
            $result['cosmetico2'] = $arrayTFCosm_cosm2[$i];
            $result['cosmetico3'] = $arrayTFCosm_cosm3[$i];
            $result['cosmetico4'] = $arrayTFCosm_cosm4[$i];
            $result['data'] = $arrayTFCosm_data[$i];
            $result['user'] = $arrayTFCosm_user[$i];
        }
    }
    return $result;
}

function testeFinal2($rrm, $serial, $arrayTF2_rrm, $arrayTF2_serial, $arrayTF2_user, $arrayTF2_data)
{
    $result['status'] = '';
    $result['data'] = '';
    $result['user'] = '';
    for ($i = 0; $i <  sizeof($arrayTF2_serial); $i++) {
        if (($serial == $arrayTF2_serial[$i]) && ($rrm == $arrayTF2_rrm[$i])) {
            $result['status'] = "R";
            $result['data'] = $arrayTF2_data[$i];
            $result['user'] = $arrayTF2_user[$i];
        }
    }
    return $result;
}

function ncaixa($serial, $arraySerial1, $arrayNcaixa)
{
    $result['ncaixa'] = '';
    for ($i = 0; $i <  sizeof($arraySerial1); $i++) {
        if ($serial == $arraySerial1[$i]) {
            $result =  $arrayNcaixa[$i];
        }
    }
    return $result;
}

function embalagem($resultNcaixa, $arrayEmb_ncaixa, $arrayEmb_data, $arrayEmb_user)
{
    $result['data'] = '';
    $result['user'] = '';
    for ($i = 0; $i <  sizeof($arrayEmb_ncaixa); $i++) {
        if ($resultNcaixa == $arrayEmb_ncaixa[$i])  {
            $result['data'] = $arrayEmb_data[$i];
            $result['user'] = $arrayEmb_user[$i];
        }
    }
    return $result;
}

function expedicao($resultNcaixa, $arrayExp_nfsaida, $arrayExp_caixa, $arrayExp_dataExp, $arrayExp_user)
{
    $result['nf'] = '';
    $result['data'] = '';
    $result['user'] = '';
    for ($i = 0; $i <  sizeof($arrayExp_nfsaida); $i++) {
        if ($resultNcaixa == $arrayExp_caixa[$i])  {
            $result['nf'] = $arrayExp_nfsaida[$i];
            $result['data'] = $arrayExp_dataExp[$i];
            $result['user'] = $arrayExp_user[$i];
        }
    }
    return $result;
}

