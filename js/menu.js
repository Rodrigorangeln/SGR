/* Níveis de acesso:

0: Sem restrições
1: Somente elétrica
2: Somente postos */


function niveis_acesso(nivel) {
    if (nivel == '1'){
        $("#menu_eletrica").removeClass('disabled');
    }
    if (nivel == '2'){
        $("#menu_recep").removeClass('disabled');
        $("#menu_rrms").removeClass('disabled');
        $("#menu_rrms_fechadas").removeClass('disabled');
        $("#menu_teste").removeClass('disabled');
        $("#menu_cosmetica").removeClass('disabled');
        $("#menu_teste_final").removeClass('disabled');
        //$("#menu_embalagem").removeClass('disabled'); DESABILITADO POIS FALTA CONCLUIR ESSAS TELAS
        //$("#menu_expedicao").removeClass('disabled');
    }
    if (nivel == '0'){ 
        $(".nav-link").removeClass('disabled');
    }

}


