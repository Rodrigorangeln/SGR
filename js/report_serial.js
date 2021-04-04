$('#menu_relatorios').addClass('active lead')

function maiuscula(z) {
    v = z.value.toUpperCase().trim();
    z.value = v;
}

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS

    $("#serial").focus()

    $("#consultar").on("click", function () {
        alert ("teste")
        /* $.ajax({
            url: 'buscaReport.php',
            method: 'POST',
            data: { serial: $("#serial").val(), acao: "serial" },
            dataType: 'json',
        }).done(function (retorno) {
            $("#label").prop('hidden', false)
            $("#report_colab1").html($("#colaborador1").val())
            $("#quant_colab1").html("-> " + retorno[0])

            if ($("#colaborador2").val() != "0") {
                $("#report_colab2").html($("#colaborador2").val())
                $("#quant_colab2").html("-> " + retorno[1])
            }
        }) */

    })

})



