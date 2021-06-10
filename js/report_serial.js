$('#menu_relatorios').addClass('active lead')

function maiuscula(z) {
    v = z.value.toUpperCase().trim();
    z.value = v;
}

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS
    $("#serial").focus()

    $("#consultar").on("click", function () {
        $("#consultar").prop('disabled', true)
        $("#consultar").html('Aguarde ...')
        $.ajax({
            url: 'buscaReport.php',
            method: 'POST',
            data: { serial: $("#serial").val(), acao: "serial" },
            dataType: 'json',
        }).done(function (retorno) {
            if (retorno != '0') {
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
                $("#dt_embalagem").html(retorno['dt_embalagem'])
                $("#func_embalagem").html(retorno['func_embalagem'])
                $("#dt_expedicao").html(retorno['dt_expedicao'])
                $("#func_expedicao").html(retorno['func_expedicao'])

                $("#consultar").prop('disabled', false)
                $("#consultar").html('Consultar')
                $("#serial").focus()
            } else {
                $("#erroserial").fadeTo(2000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                })
                $("#consultar").prop('disabled', false)
                $("#consultar").html('Consultar')
                $("#serial").focus()
                $("#serial").val('')
                limpa()
            }


        })

    })

})

function limpa() {
    $("#rrm").html('')
    $("#dt_input").html('')
    $("#func_input").html('')
    $("#dt_testeInicial").html('')
    $("#func_testeInicial").html('')
    $("#dt_eletrica").html('')
    $("#func_eletrica").html('')
    $("#dt_cosmetica").html('')
    $("#func_cosmetica").html('')
    $("#dt_testeFinal").html('')
    $("#func_testeFinal").html('')
    $("#dt_embalagem").html('')
    $("#func_embalagem").html('')
    $("#dt_expedicao").html('')
    $("#func_expedicao").html('')
}



