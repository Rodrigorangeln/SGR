$('#menu_eletrica').addClass('active lead')

function maiuscula(z) {
    v = z.value.toUpperCase().trim();
    z.value = v;
}

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS

    $("#1serial").focus()

    $("#1serial").on("blur", function () {
        if ($("#1serial").val() == "") {
            limpa_campos()
        } else {

            $.ajax({
                url: 'busca_eletrica.php',
                method: 'POST',
                data: { s1: $("#1serial").val(), acao: "buscaSerial" },
                dataType: 'json',
                success: (function (result) {
                    if (result[0] != "Serial não encontrado") {
                        limpa_campos()
                        $("#2serial").val(result[0])
                        $("#rrm").val(result[1])
                        $("#modelo").val(result[2])
                        $("#cod_mod").val(result[3])
                        $("#elet0").val(result[4])
                        $("#elet1").val(result[5])


                        $.ajax({
                            url: 'busca_eletrica.php',
                            method: 'POST',
                            data: { cod_mod: result[3], cod_sintoma: result[4].substring(0, 4), acao: "buscaComponentes" },
                            dataType: 'json',
                        }).done(function (resultcomponentes) {

                            document.querySelectorAll('#componente1 option').forEach(option => option.remove())
                            $('#componente1').append('<option value="0">Selecione componente...</option>');

                            document.querySelectorAll('#componente2 option').forEach(option => option.remove())
                            $('#componente2').append('<option value="0">Selecione componente...</option>');

                            resultcomponentes.forEach((componente) => {
                                option = new Option(componente, componente.toLowerCase());
                                //option2 = new Option(componentes, componentes.toLowerCase());
                                componente1.options[componente1.options.length] = option;
                                //componente2.options[componente2.options.length] = option2;

                                $.ajax({
                                    url: 'busca_eletrica.php',
                                    method: 'POST',
                                    data: { cod_mod: result[3], cod_sintoma: result[5].substring(0, 4), acao: "buscaComponentes" },
                                    dataType: 'json',
                                }).done(function (resultcomponentes) {

                                    resultcomponentes.forEach((componente) => {
                                        option2 = new Option(componente, componente.toLowerCase());
                                        componente2.options[componente2.options.length] = option2;
                                    });


                                    $.ajax({
                                        url: 'busca_testeinicial.php',
                                        method: 'POST',
                                        data: { cod_mod: result[3], acao: "buscaSintomas" },
                                        dataType: 'json',
                                        success: (function (resultSintomas) {

                                            document.querySelectorAll('#sintoma3 option').forEach(option => option.remove())
                                            $('#sintoma3').append('<option>Selecione se houver novo sintoma...</option>');

                                            resultSintomas.forEach((sintoma) => {
                                                option = new Option(sintoma, sintoma.toLowerCase());
                                                sintoma3.options[sintoma3.options.length] = option;
                                            });

                                        })
                                    })

                                })

                            });

                        })

                        if ($("#elet1").val() == "") {
                            $("#componente2").prop('disabled', true)
                            $("#radioelet1sub").prop('disabled', true)
                            $("#radioelet1res").prop('disabled', true)

                            $("#sintoma_extra").removeAttr('hidden')

                        }

                    }
                    else {
                        $("#erroserial").fadeTo(2000, 500).slideUp(500, function () {
                            $(".alert").slideUp(1000);
                        })
                        limpa_campos()
                        $("#1serial").focus()
                    }
                })
            })
        }
    })


    $("#sintoma3").on("click", function () {
        $.ajax({
            url: 'busca_eletrica.php',
            method: 'POST',
            data: { cod_mod: $("#cod_mod").val(), cod_sintoma: $("#sintoma3").val().substring(0, 4), acao: "buscaComponentes" },
            dataType: 'json',
        }).done(function (resultcomponentes) {
            document.querySelectorAll('#componente3 option').forEach(option => option.remove())
            $('#componente3').append('<option value="0">Selecione componente...</option>');

            resultcomponentes.forEach((componente) => {
                option = new Option(componente, componente.toLowerCase());
                componente3.options[componente3.options.length] = option;
            })
        })
    })

    $("#confirmar").on("click", function () {
        var defeito1 = ""
        var defeito2 = ""
        var defeito3 = ""
        var componente1 = ""
        var componente2 = ""
        var componente3 = ""
        var radio1 = ""
        var radio2 = ""
        var radio3 = ""
        var erro = "0"

        if ($("select[name=componente1]").val() != '0') {
            defeito1 = $("#elet0").val()
            componente1 = $("select[name=componente1]").val()
            if ($("#radioelet0sub").is(":checked")) {
                radio1 = "s"  //Substituído
            } else if ($("#radioelet0res").is(":checked")) {
                radio1 = "r"  //Ressoldado
            } else {
                erro = "1"
                $("#erroradio").fadeTo(2000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                })
            }
        } else {
            erro = "1"
            $("#errocomponente").fadeTo(2000, 500).slideUp(500, function () {
                $(".alert").slideUp(1000);
            })
            $("select[name=componente1]").focus()
        }

        if ($("#elet1").val() != "") {
            defeito2 = $("#elet1").val()
            if ($("select[name=componente2]").val() != '0') {
                componente2 = $("select[name=componente2]").val()
                if ($("#radioelet1sub").is(":checked")) {
                    radio2 = "s"  //Substituído
                } else if ($("#radioelet1res").is(":checked")) {
                    radio2 = "r"  //Ressoldado
                } else {
                    erro = "1"
                    $("#erroradio").fadeTo(2000, 500).slideUp(500, function () {
                        $(".alert").slideUp(1000);
                    })
                }
            } else {
                erro = "1"
                $("#errocomponente").fadeTo(2000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                })
                $("select[name=componente2]").focus()
            }
        }

        if ($("#sintoma3").val() != 'Selecione se houver novo sintoma...') {
            defeito3 = $("#sintoma3").val()
            if ($("select[name=componente3]").val() != '0') {
                componente3 = $("select[name=componente3]").val()
                if ($("#radioelet2sub").is(":checked")) {
                    radio3 = "s"  //Substituído
                } else if ($("#radioelet2res").is(":checked")) {
                    radio3 = "r"  //Ressoldado
                } else {
                    erro = "1"
                    $("#erroradio").fadeTo(2000, 500).slideUp(500, function () {
                        $(".alert").slideUp(1000);
                    })
                }
            } else {
                erro = "1"
                $("#errocomponente").fadeTo(2000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                })
                $("select[name=componente3]").focus()
            }
        }


        if (erro == "0") {
            $.ajax({
                url: 'busca_eletrica.php',
                method: 'POST',
                data: {
                    s1: $("#1serial").val(), rrm: $("#rrm").val(), defeito1, defeito2, defeito3, componente1, componente2, componente3, radio1, radio2, radio3,
                    acao: "grava_eletrica"
                },
                dataType: 'json',
            }).always(function () {
                $("#eletricaok").fadeTo(2000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                })
                limpa_campos()
                $("#1serial").val("")
                $("#1serial").focus()
            })
        }

    })

    $("#sconserto").on("click", function () {
        if ($('#2serial').val() != '') {
            $('#ModalSemConserto').modal('toggle')
            $('#serial').html($('#1serial').val())
        }
    })


    $("#btn_confirmar").on("click", function () {
        $('#ModalSemConserto .modal-body').html('<strong>CONFIRMANDO ...</strong>');
        //setTimeout(function () { $('#ModalSemConserto').modal('hide'); }, 2000);

        $.ajax({
            url: 'busca_eletrica.php',
            method: 'POST',
            data: { s1: $("#1serial").val(), rrm: $("#rrm").val(), acao: "semConserto" },
            dataType: 'json',
        }).always(function () {
            $('#ModalSemConserto .modal-body').html('<strong style="color:green">CONFIRMADO !!!</strong>');
            setTimeout(function () { $('#ModalSemConserto').modal('hide'); }, 2000);
            $("#1serial").val("")
            limpa_campos();

        })
    })



})


function limpa_campos() {
    $("#2serial").val("")
    $("#rrm").val("")
    $("#cod_mod").val("")
    $("#modelo").val("")
    $("#cosm0").val("")
    $("#cosm1").val("")
    $("#cosm2").val("")
    $("#cosm3").val("")
    $("select[name=def_cosm0]").attr('hidden', '')
    $("select[name=def_cosm1]").attr('hidden', '')
    $("select[name=def_cosm2]").attr('hidden', '')
    $("select[name=def_cosm3]").attr('hidden', '')
    $("#elet0").val("")
    $("#elet1").val("")
    $("input[name=radio1]").prop('checked', false)
    $("input[name=radio2]").prop('checked', false)
    $("select[name=componente1]").val('0')
    $("select[name=componente2]").val('0')

    $("select[name=sintoma3]").val('0')
    $("select[name=componente3]").val('0')
    $("input[name=radio3]").prop('checked', false)
    $("#sintoma_extra").attr('hidden', '')
    $("#componente2").prop('disabled', false)
    $("#radioelet1sub").prop('disabled', false)
    $("#radioelet1res").prop('disabled', false)

}






