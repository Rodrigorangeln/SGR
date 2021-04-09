$('#menu_relatorios').addClass('active lead')

function maiuscula(z) {
    v = z.value.toUpperCase().trim();
    z.value = v;
}

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS

    $("#serial").focus()

    $("#consultar").on("click", function () {
        $.ajax({
            url: 'buscaReport.php',
            method: 'POST',
            data: { serial: $("#serial").val(), acao: "serial" },
            dataType: 'json',
        }).done(function (retorno) {
            $("#label").prop('hidden', false)
            $("#rrm").html(retorno['rrm'])
            $("#dt_input").html(retorno['dt_input'])
            $("#func_input").html(retorno['func_input'])
            $("#dt_testeInicial").html(retorno['dt_testeinicial'])
            $("#func_testeInicial").html(retorno['func_testeinicial'])
            $("#dt_eletrica").html(retorno['dt_eletrica'])
            $("#func_eletrica").html(retorno['func_eletrica'])
            $("#dt_cosmetica").html(retorno['dt_cosmetica'])
            $("#func_cosmetica").html(retorno['func_cosmetica'])
            $("#dt_testeFinal").html(retorno['dt_testefinal'])
            $("#func_testeFinal").html(retorno['func_testefinal'])

            //FALTA POPULAR EMBALAGEM e EXPEDIÇÃO. Esses postos ainda não foram implementados.

        })

    })

})



