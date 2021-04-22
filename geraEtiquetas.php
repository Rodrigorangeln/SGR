<?php

$modelo = $_POST['modelo'];
$serial1 = $_POST['serial1'];
$serial2 = $_POST['serial2'];

$arquivo = fopen('aatest.prn','w+');

if ($arquivo) {
	if (!fwrite($arquivo, 
    '^XA
^MMT
^PW639
^LL0240
^LS0
^FO20,12^A3,22^FDMODELO: '.$modelo.'^FS
^BY3,3,30^FT27,71^BCN,,Y,N
^FD'.$serial1.'^FS
^BY3,3,34^FT27,176^BCN,,Y,N
^FD'.$serial2.'^FS
^FT27,124^A0N,17,19^FH\^FDSERIAL:^FS
^FT26,211^A0N,16,16^FH\^FDCM MAC:^FS
^PQ1,0,1,Y^XZ'
    )) die('Não foi possível atualizar o arquivo.');
	echo 'Arquivo atualizado com sucesso';
	fclose($arquivo);
}

/* // abre o arquivo colocando o ponteiro de escrita no final 
$arquivo = fopen('aaaa.txt','r+'); 
if ($arquivo) { 
    while(true) { 
        $linha = fgets($arquivo); 
        if ($linha==null) break; 
        // busca na linha atual o conteudo que vai ser alterado 
        if(preg_match("/React/", $linha)) { 
            $string .= str_replace("React", "Rangel Neves", $linha);
         } else { 
             // vai colocando tudo numa nova string 
             $string.= $linha; } } 
             // move o ponteiro para o inicio pois o ftruncate() nao fara isso 
             rewind($arquivo); 
             // truca o arquivo apagando tudo dentro dele 
             ftruncate($arquivo, 0); 
             // reescreve o conteudo dentro do arquivo 
             if (!fwrite($arquivo, $string)) die('Não foi possível atualizar o arquivo.'); 
             echo 'Arquivo atualizado com sucesso'; fclose($arquivo); }  */
             

?>