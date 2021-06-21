/* Níveis de acesso:

0: Tudo, inclusive consultas (nortcom).
1: Somente elétrica
2: Somente postos
3: Somente Recepção e Expedição
 */

$(document).ready(function () {
    $('#load').hide();
});


function niveis_acesso(nivel) {
    if (nivel == '1') {
        $("#menu_eletrica").removeClass('disabled');
        /////// ILHÉUS /////////////////////////
        $("#menu_rrms_fechadas").removeClass('disabled');
        $("#menu_teste").removeClass('disabled');
        $("#menu_cosmetica").removeClass('disabled');
        $("#menu_teste_final").removeClass('disabled');
        //$("#menu_embalagem").removeClass('disabled');
        /////////////////////////////////////////////
    }
    if (nivel == '2') {
        //$("#menu_recep").removeClass('disabled');
        //$("#menu_rrms").removeClass('disabled');
        $("#menu_rrms_fechadas").removeClass('disabled');
        $("#menu_teste").removeClass('disabled');
        $("#menu_cosmetica").removeClass('disabled');
        $("#menu_teste_final").removeClass('disabled');
        $("#menu_embalagem").removeClass('disabled');
        //$("#menu_expedicao").removeClass('disabled');
    }
    if (nivel == '3') {
        $("#menu_recep").removeClass('disabled');
        $("#menu_rrms").removeClass('disabled');
        $("#menu_expedicao").removeClass('disabled');
    }
    if (nivel == '0') {
        $(".nav-link").removeClass('disabled');
        $("#produtividade").removeClass('disabled');
        document.getElementById("adm").href = "adm.php";
    }

}


