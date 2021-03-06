$('#menu_teste_final').addClass('active lead')

/* $(document).keypress(function(e) {
    //alert(event.keyCode)
    if ((e.which == 112) || (e.which == 80)){
        $("#checkPainel").prop("checked", true)
    }    
}); */

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
            $("#reprovado").attr("hidden", true);

            $("#aprovar").prop('disabled', true)
            $("#reprovar").attr("hidden", false);
            $("#reprovar").prop('disabled', true)
            $("#semConserto").attr("hidden", true);
        } else {

            $.ajax({
                url: 'busca_testefinal.php',
                method: 'POST',
                data: { s1: $("#1serial").val(), acao: "buscaSerial" },
                dataType: 'json',
                success: (function (result) {
                    if (result[0] != "Serial não encontrado") {
                        $("#2serial").val(result[0])
                        $("#rrm").val(result[1])
                        $("#modelo").val(result[2])
                        $("#cod_mod").val(result[3])

                        if (result['reprovado'] == 1) {
                            $("#reprovado").attr("hidden", false);
                            $("#reprovar").attr("hidden", true);
                            $("#semConserto").attr("hidden", false);

                        }

                        //$("#aprovar").prop('disabled', false)

                        $.ajax({
                            url: 'busca_testefinal.php',
                            method: 'POST',
                            data: { cod_mod: result[3], acao: "buscaSintomas" },
                            dataType: 'json',
                            success: (function (resultSintomas) {

                                document.querySelectorAll('#def_elet0 option').forEach(option => option.remove())
                                $('#def_elet0').append('<option></option>');
                                $('#def_elet0').append('<option value="0" >0000 - sem defeito</option>'); //SELECTED temporário

                                document.querySelectorAll('#def_elet1 option').forEach(option => option.remove())
                                $('#def_elet1').append('<option></option>');

                                resultSintomas.forEach((sintoma) => {
                                    option = new Option(sintoma, sintoma.toLowerCase());
                                    option2 = new Option(sintoma, sintoma.toLowerCase());
                                    def_elet0.options[def_elet0.options.length] = option;
                                    def_elet1.options[def_elet1.options.length] = option2;
                                });

                            })
                        })
                    }
                    else {
                        $("#local").html(result[1])
                        $("#alertaRRM").html(result[2])
                        $("#erroserial").fadeTo(2000, 500).slideUp(500, function () {
                            $(".alert").slideUp(1000);
                        })
                        limpa_campos()
                        $("#1serial").focus()
                        $("#aprovar").prop('disabled', false)
                    }
                })
            })
        }

    })


    $("select[name=def_cosm0]").on("change", function () {
        if ($("#rrm").val() != '') {
            if (($("select[name=def_cosm0]").val() != "0") || ($("select[name=def_cosm2]").val() != "") || ($("select[name=def_cosm3]").val() != "") || ($("select[name=def_elet0]").val() != "0") || ($("select[name=def_elet1]").val() != "")) {
                $("#aprovar").prop('disabled', true)
                $("#reprovar").prop('disabled', false)
            } else {
                $("#aprovar").prop('disabled', false)
                $("#reprovar").prop('disabled', true)
            }
            if (($("select[name=def_cosm0]").val() == "0") || ($("select[name=def_cosm0]").val() == "")) {
                $("select[name=def_cosm1]").prop('disabled', true)
                $("select[name=def_cosm2]").prop('disabled', true)
                $("select[name=def_cosm3]").prop('disabled', true)

                $("select[name=def_cosm1]").val('')
                $("select[name=def_cosm2]").val('')
                $("select[name=def_cosm3]").val('')
            } else {
                $("select[name=def_cosm1]").prop('disabled', false)
                $("select[name=def_cosm2]").prop('disabled', false)
                $("select[name=def_cosm3]").prop('disabled', false)
            }
            if (($("select[name=def_cosm0]").val() == "") && ($("select[name=def_elet0]").val() == "")){
                $("#aprovar").prop('disabled', true)
                $("#reprovar").prop('disabled', true)
            }
            if (($("select[name=def_cosm0]").val() == "0") && ($("select[name=def_elet0]").val() == "") || ($("select[name=def_cosm0]").val() == "") && ($("select[name=def_elet0]").val() == "0")){
                $("#aprovar").prop('disabled', true)
                $("#reprovar").prop('disabled', true)
            }
        }
    })
/*     $("select[name=def_cosm1]").on("change", function () {
        if (($("select[name=def_cosm0]").val() != "0") || ($("select[name=def_cosm2]").val() != "") || ($("select[name=def_cosm3]").val() != "") || ($("select[name=def_elet0]").val() != "0") || ($("select[name=def_elet1]").val() != "")) {
            $("#aprovar").prop('disabled', true)
            $("#reprovar").prop('disabled', false)
        } else {
            $("#aprovar").prop('disabled', false)
            $("#reprovar").prop('disabled', true)
        }
    })
    $("select[name=def_cosm2]").on("change", function () {
        if (($("select[name=def_cosm0]").val() != "0") || ($("select[name=def_cosm2]").val() != "") || ($("select[name=def_cosm3]").val() != "") || ($("select[name=def_elet0]").val() != "0") || ($("select[name=def_elet1]").val() != "")) {
            $("#aprovar").prop('disabled', true)
            $("#reprovar").prop('disabled', false)
        } else {
            $("#aprovar").prop('disabled', false)
            $("#reprovar").prop('disabled', true)
        }
    })
    $("select[name=def_cosm3]").on("change", function () {
        if (($("select[name=def_cosm0]").val() != "0") || ($("select[name=def_cosm2]").val() != "") || ($("select[name=def_cosm3]").val() != "") || ($("select[name=def_elet0]").val() != "0") || ($("select[name=def_elet1]").val() != "")) {
            $("#aprovar").prop('disabled', true)
            $("#reprovar").prop('disabled', false)
        } else {
            $("#aprovar").prop('disabled', false)
            $("#reprovar").prop('disabled', true)
        }
    }) */
    $("select[name=def_elet0]").on("change", function () {
        if ($("#rrm").val() != '') {
            if (($("select[name=def_cosm0]").val() != "0") || ($("select[name=def_cosm2]").val() != "") || ($("select[name=def_cosm3]").val() != "") || ($("select[name=def_elet0]").val() != "0") || ($("select[name=def_elet1]").val() != "")) {
                $("#aprovar").prop('disabled', true)
                $("#reprovar").prop('disabled', false)
            } else {
                $("#aprovar").prop('disabled', false)
                $("#reprovar").prop('disabled', true)
            }
            if (($("select[name=def_elet0").val() == "0") || ($("select[name=def_elet0").val() == "")) {
                $("select[name=def_elet1]").prop('disabled', true)

                $("select[name=def_elet1]").val('')
            } else {
                $("select[name=def_elet1]").prop('disabled', false)
            }
            if (($("select[name=def_cosm0]").val() == "") && ($("select[name=def_elet0]").val() == "")){
                $("#aprovar").prop('disabled', true)
                $("#reprovar").prop('disabled', true)
            }
            if (($("select[name=def_cosm0]").val() == "") && ($("select[name=def_elet0]").val() == "0") || ($("select[name=def_cosm0]").val() == "0") && ($("select[name=def_elet0]").val() == "")){
                $("#aprovar").prop('disabled', true)
                $("#reprovar").prop('disabled', true)
            }
        }
    })
/*     $("select[name=def_elet1]").on("change", function () {
        if (($("select[name=def_cosm0]").val() != "0") || ($("select[name=def_cosm2]").val() != "") || ($("select[name=def_cosm3]").val() != "") || ($("select[name=def_elet0]").val() != "0") || ($("select[name=def_elet1]").val() != "")) {
            $("#aprovar").prop('disabled', true)
            $("#reprovar").prop('disabled', false)
        } else {
            $("#aprovar").prop('disabled', false)
            $("#reprovar").prop('disabled', true)
        }
    }) */




    /* $("#reprovar").on("click", function() {
        if ($("#1serial").val() != "" && ($("#2serial").val() != "" )){
            var serial1 = $("#1serial").val()
            var rrm = $("#rrm").val()
            var cosm1 = $("select[name=def_cosm0]").val()
            var cosm2 = $("select[name=def_cosm1]").val()
            var cosm3 = $("select[name=def_cosm2]").val()
            var cosm4 = $("select[name=def_cosm3]").val()
            var elet1 = $("select[name=def_elet0]").val()
            var elet2 = $("select[name=def_elet1]").val()

            $.ajax({
                url: 'grava_testefinal.php',
                method: 'POST',
                data: {serial1, rrm, cosm1, cosm2, cosm3, cosm4, elet1, elet2},
                dataType: 'json',
                    success: (function(){
                    $("#testeok").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(1000);
                    })
                    $("#1serial").val("")
                    limpa_campos()
                    $("#1serial").focus()
                    }) 
                })
        }
    }) */

    $("#aprovar").on("click", function () {
        $.ajax({
            url: 'busca_testefinal.php',
            method: 'POST',
            data: { s1: $("#1serial").val(), acao: "aprovar" },
            dataType: 'json',
        }).always(function () {
            $("#testeok").fadeTo(2000, 500).slideUp(500, function () {
                $(".alert").slideUp(1000);
            })
            limpa_campos()
            $("#1serial").val("")
            $("#1serial").focus()
        })
    })

    $("#reprovar").on("click", function () {
        if ($("#1serial").val() != "") {

            let def_eletrico = 0
            if ($("select[name=def_elet0]").val() != 0)
                def_eletrico = 1

            $.ajax({
                url: 'busca_testefinal.php',
                method: 'POST',
                data: {
                    s1: $("#1serial").val(), rrm: $("#rrm").val(), def_eletrico, cosm0: $("select[name=def_cosm0]").val(), cosm1: $("select[name=def_cosm1]").val(), cosm2: $("select[name=def_cosm2]").val(), cosm3: $("select[name=def_cosm3]").val(), elet0: $("select[name=def_elet0]").val(), elet1: $("select[name=def_elet1]").val(),
                    acao: "reprovar"
                },
                dataType: 'json',
            }).always(function () {
                $("#alertReprovado").fadeTo(2000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                })
                limpa_campos()
                $("#1serial").val("")
                $("#1serial").focus()
                $("select[name=def_cosm0]").val("")
                $("select[name=def_elet0]").val("")
            })
        }
    })

    $("#semConserto").on("click", function () {
        if ($('#rrm').val() != '') {
            $('#ModalSemConserto').modal('toggle')
            $('#serial').html($('#1serial').val())
        }
    })

    // BOTÃO CONFIRMAR DO MODAL SEM CONSERTO
    $("#btn_confirmar").on("click", function () { 
        $('#ModalSemConserto .modal-body').html('<strong>CONFIRMANDO ...</strong>');
        //setTimeout(function () { $('#ModalSemConserto').modal('hide'); }, 2000);

        $.ajax({
            url: 'busca_testefinal.php',
            method: 'POST',
            data: { s1: $("#1serial").val(), rrm: $("#rrm").val(), acao: "semConserto" },
            dataType: 'json',
        }).always(function () {
            $('#ModalSemConserto .modal-body').html('<strong style="color:green">CONFIRMADO !!!</strong>');
            setTimeout(function () { $('#ModalSemConserto').modal('hide'); }, 2000);
            $("#1serial").val("")
            limpa_campos();
            $("#reprovado").attr("hidden", true);

            $("#aprovar").prop('disabled', true)
            $("#reprovar").attr("hidden", false);
            $("#reprovar").prop('disabled', true)
            $("#semConserto").attr("hidden", true);
        })
    })


})

function limpa_campos() {
    $("#1serial").val("")
    $("#2serial").val("")
    $("#rrm").val("")
    $("#cod_mod").val("")
    $("#modelo").val("")
    //$("select[name=def_cosm0]").val("")
    $("select[name=def_cosm1]").val("")
    $("select[name=def_cosm2]").val("")
    $("select[name=def_cosm3]").val("")
    //$("select[name=def_elet0]").val("")
    $("select[name=def_elet1]").val("")

}

/* function buscaSintomas(){
    $.ajax({
        url: 'busca_testeinicial.php',
        method: 'POST',
        data: {cod_modelo: $("#cod_modelo").val() , acao: "buscaSintomas"},
        dataType: 'json',
        success: (function(resultSintomas){
            //alert (resultSintomas)

            document.querySelectorAll('#def_elet0 option').forEach(option => option.remove())
            $('#def_elet0').append('<option></option>');

            document.querySelectorAll('#def_elet1 option').forEach(option => option.remove())
            $('#def_elet1').append('<option></option>');

            resultSintomas.forEach((sintoma) => {
            option = new Option(sintoma, sintoma.toLowerCase());
            option2 = new Option(sintoma, sintoma.toLowerCase());
            def_elet0.options[def_elet0.options.length] = option;
            def_elet1.options[def_elet1.options.length] = option2;
            });

        })
    })

}*/





/* $(document).keypress(function(e) {
            //alert(event.keyCode)
            if ((e.which == 112) || (e.which == 80)){ //letras p e P
                if ($("#checkPainel").is(":checked") == false){
                    $("#checkPainel").prop("checked", true)
                }
                else {
                    $("#checkPainel").prop("checked", false)
                }
            }
            if ((e.which == 116) || (e.which == 84)){  //letras t e T
                if ($("#checkTampa").is(":checked") == false){
                    $("#checkTampa").prop("checked", true)
                }
                else {
                    $("#checkTampa").prop("checked", false)
                }
            }
            if ((e.which == 99) || (e.which == 67)){ //letras c e C
                if ($("#checkChassi").is(":checked") == false){
                    $("#checkChassi").prop("checked", true)
                }
                else {
                    $("#checkChassi").prop("checked", false)
                }
            }
            if ((e.which == 101) || (e.which == 69)){ //letras e e E
                if ($("#checkEtiqueta").is(":checked") == false){
                    $("#checkEtiqueta").prop("checked", true)
                }
                else {
                    $("#checkEtiqueta").prop("checked", false)
                }
            }

        }); */