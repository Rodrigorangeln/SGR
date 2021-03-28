$('#menu_relatorios').addClass('active lead')

/* $(document).keypress(function(e) {
    //alert(event.keyCode)
    if ((e.which == 112) || (e.which == 80)){
        $("#checkPainel").prop("checked", true)
    }    
}); */

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS

    $("#colaborador1").focus()

    $("#colaborador1").on("change", function () {
        if ($("#colaborador1").val() != null) {
            $("#colaborador1").removeClass("is-invalid")
        }
    })
    $("#dt_inicio").on("change", function () {
        if ($("#dt_inicio").val() != "") {
            $("#dt_inicio").removeClass("is-invalid")
        }
    })
    $("#dt_final").on("change", function () {
        if ($("#dt_final").val() != "") {
            $("#dt_final").removeClass("is-invalid")
        }
    })



    $("#consultar").on("click", function () {
        var erro = 0
        if ($("#colaborador1").val() == null) {
            $("#colaborador1").addClass("is-invalid")
            erro = 1
        }
        if ($("#dt_inicio").val() == "") {
            $("#dt_inicio").addClass("is-invalid")
            erro = 1
        }
        if ($("#dt_final").val() == "") {
            $("#dt_final").addClass("is-invalid")
            erro = 1
        }

        if (erro == 0) {
            $.ajax({
                url: 'buscaReportProdutividade.php',
                method: 'POST',
                data: { colab1: $("#colaborador1").val(), colab2: $("#colaborador2").val(), dtInicio: $("#dt_inicio").val(), dtFinal: $("#dt_final").val(), acao: "produtividade" },
                dataType: 'json',
            }).done(function (retorno) {
                $("#label").prop('hidden', false)
                $("#report_colab1").html($("#colaborador1").val())
                $("#quant_colab1").html("-> " + retorno[0])
                
                if($("#colaborador2").val() != "0") {
                    $("#report_colab2").html($("#colaborador2").val())
                    $("#quant_colab2").html("-> " + retorno[1])
                }
            })
        }
    })

})



