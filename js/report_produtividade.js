$('#menu_relatorios').addClass('active lead')

/* $(document).keypress(function(e) {
    //alert(event.keyCode)
    if ((e.which == 112) || (e.which == 80)){
        $("#checkPainel").prop("checked", true)
    }    
}); */

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS

    $("#posto").focus()

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
        var controle = 0

        if ($("#dt_inicio").val() == "") {
            $("#dt_inicio").addClass("is-invalid")
            controle = 1
        }
        if ($("#dt_final").val() == "") {
            $("#dt_final").addClass("is-invalid")
            controle = 1
        }

        if (($("#colaborador1").val() == "0") && (controle == 0) && ($("#colaborador2").val() == "0")) {
            $.ajax({
                url: 'buscaReport.php',
                method: 'POST',
                data: { posto: $("#posto").val(), dtInicio: $("#dt_inicio").val(), dtFinal: $("#dt_final").val(), acao: "produtividadeGeral" },
                dataType: 'json',
                beforeSend: function () {
                    $("#load").show();
                }
            }).done(function (retorno) {
                $("#label").html(retorno[2])
                $("#report_colab1").html("Total GERAL: ")
                $("#quant_colab1").html("-> " + retorno[0])

                $("#report_colab2").html("")
                $("#quant_colab2").html("")

                $("#load").hide();
            })

            controle = 1
        }


        if (controle == 0) {
            $("#report_colab1").html("")
            $("#quant_colab1").html("")
            $("#report_colab2").html("")
            $("#quant_colab2").html("")

            $.ajax({
                url: 'buscaReport.php',
                method: 'POST',
                data: { posto: $("#posto").val(), colab1: $("#colaborador1").val(), colab2: $("#colaborador2").val(), dtInicio: $("#dt_inicio").val(), dtFinal: $("#dt_final").val(), acao: "produtividade" },
                dataType: 'json',
                beforeSend: function () {
                    $("#load").show();
                }
            }).done(function (retorno) {
                $("#label").html(retorno[2])

                if ($("#colaborador1").val() != "0") {
                    $("#report_colab1").html($("#colaborador1").val())
                    $("#quant_colab1").html("-> " + retorno[0])
                }

                if ($("#colaborador2").val() != "0") {
                    $("#report_colab2").html($("#colaborador2").val())
                    $("#quant_colab2").html("-> " + retorno[1])
                }
                $("#load").hide();
            })
        }
    })

})



