document.title = "RRMs FECHADAS"

$('#menu_dropdown_rrms').addClass('active lead')

function ModalRRMFechada(rrm){
    $.ajax({
    url: 'busca_RRMFechada.php',
    method: 'POST',
    data: {rrm, acao: "modalRRM"},
    dataType: 'json',
    success: (function(result){

        $('#TituloModal').html("RRM n° <strong id='rrm'>"+rrm)
        /* $('#cliente').html(result['cod_cliente'])
        $('#nf').html("NF: "+result['nf']) */

        $(".modal-body").append( "<span id='cliente'>"+result['cod_cliente']+"</span><br>")
        $(".modal-body").append( "<span id='NF'>NF: "+result['nf']+"</span><br>")
        
        for (var i = 0; i < result['cod_mod'].length; i++) {

            $( ".modal-body" ).append( "<span id='modelo'>Modelo: "+result['cod_mod'][i]+" - "+result['mod'][i]+" | Quant. na NF: "+result['quant'][i]+" | Quant. digitada: "+result['quantDigitada'][i]+" </span><br>");
        
        }
        $('#ModalRRMFechado').modal('toggle')

        $('#ModalRRMFechado').on('hidden.bs.modal', function () {
            $('#ModalRRMFechado .modal-body').html('');    
        })
    })        
    })     
}


$(document).ready(function () {

    $("#btn_report_seriais").on("click", function() {
        cliente = $("#cliente").html()
        nf = $("#NF").html()
        rrm = $("#rrm").html()
        window.location.href = "report_seriais.php?cliente="+cliente+"&nf="+nf+"&rrm="+rrm
    })
    
    $("#btn_excel").on("click", function() {
        cliente = $("#cliente").html()
        nf = $("#NF").html()
        rrm = $("#rrm").html()
        window.location.href = "geraExcelSeriais.php?cliente="+cliente+"&nf="+nf+"&rrm="+rrm
    })
})


