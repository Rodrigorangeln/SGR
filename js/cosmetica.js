$('#menu_cosmetica').addClass('active lead')

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
                url: 'busca_cosmetica.php',
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
                        $("#cosm0").val(result[4])
                        $("#cosm1").val(result[5])
                        $("#cosm2").val(result[6])
                        $("#cosm3").val(result[7])
                        if ($("#cosm0").val() == "") {
                            $("select[name=def_cosm0]").removeAttr('hidden')
                        } else
                            $("#checkcosm0").removeAttr('disabled')

                        if ($("#cosm1").val() == "") {
                            $("select[name=def_cosm1]").removeAttr('hidden')
                        } else
                            $("#checkcosm1").removeAttr('disabled')

                        if ($("#cosm2").val() == "") {
                            $("select[name=def_cosm2]").removeAttr('hidden')
                        } else
                            $("#checkcosm2").removeAttr('disabled')

                        if ($("#cosm3").val() == "") {
                            $("select[name=def_cosm3]").removeAttr('hidden')
                        } else
                            $("#checkcosm3").removeAttr('disabled')

                        $("#checkcosm0").focus()

                    } else {
                        $("#erroserial").fadeTo(2000, 500).slideUp(500, function () {
                            $(".alert").slideUp(1000);
                        })
                        limpa_campos()
                        $("#1serial").focus()
                        $("#1serial").val("")
                    }
                })
            })
        }
    })


    $("#confirmar").on("click", function () {
        var verificador_checkbox = 1
        if ($("#cosm0").val() != "" && $("#checkcosm0").is(":checked") == false) {
            verificador_checkbox = 0
        }
        if ($("#cosm1").val() != "" && $("#checkcosm1").is(":checked") == false) {
            verificador_checkbox = 0
        }
        if ($("#cosm2").val() != "" && $("#checkcosm2").is(":checked") == false) {
            verificador_checkbox = 0
        }
        if ($("#cosm3").val() != "" && $("#checkcosm3").is(":checked") == false) {
            verificador_checkbox = 0
        }

        //Obriga o preenchimento de ao menos um defeito cosmético
        if ($("#cosm0").val() == "" && $("#cosm1").val() == "" && $("#cosm2").val() == "" && $("#cosm3").val() == "" && $("select[name=def_cosm0]").val() == "0" && $("select[name=def_cosm1]").val() == "0" && $("select[name=def_cosm2]").val() == "0" && $("select[name=def_cosm3]").val() == "0"){
            verificador_checkbox = 0
        }


        if (verificador_checkbox == 1) {
            var cosm0 = ""
            var cosm1 = ""
            var cosm2 = ""
            var cosm3 = ""
            var selec_cosm0 = ""
            var selec_cosm1 = ""
            var selec_cosm2 = ""
            var selec_cosm3 = ""
            if ($("#checkcosm0").is(":checked") && ($("#cosm0").val() != "")) {
                cosm0 = $("#cosm0").val()
            }
            if ($("#checkcosm1").is(":checked") && ($("#cosm1").val() != "")) {
                cosm1 = $("#cosm1").val()
            }
            if ($("#checkcosm2").is(":checked") && ($("#cosm2").val() != "")) {
                cosm2 = $("#cosm2").val()
            }
            if ($("#checkcosm3").is(":checked") && ($("#cosm3").val() != "")) {
                cosm3 = $("#cosm3").val()
            }
            if ($("select[name=def_cosm0]").val() != '0') {
                selec_cosm0 = $("select[name=def_cosm0]").val()
            } else
                selec_cosm0 = ""
            if ($("select[name=def_cosm1]").val() != '0') {
                selec_cosm1 = $("select[name=def_cosm1]").val()
            } else
                selec_cosm1 = ""
            if ($("select[name=def_cosm2]").val() != '0') {
                selec_cosm2 = $("select[name=def_cosm2]").val()
            } else
                selec_cosm2 = ""
            if ($("select[name=def_cosm3]").val() != '0') {
                selec_cosm3 = $("select[name=def_cosm3]").val()
            } else
                selec_cosm3 = ""

            $.ajax({
                url: 'busca_cosmetica.php',
                method: 'POST',
                data: {
                    s1: $("#1serial").val(), rrm: $("#rrm").val(), cosm0, cosm1, cosm2, cosm3, selec_cosm0, selec_cosm1, selec_cosm2, selec_cosm3,
                    acao: "grava_cosmetica"
                },
                dataType: 'json',
            }).always(function () {
                $("#cosmeticaok").fadeTo(2000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                })
                limpa_campos()
                $("#1serial").val("")
                $("#1serial").focus()
            })

            /* if ($("#2serial").val() != "" ){
                $("#cosmeticaok").fadeTo(2000, 500).slideUp(500, function(){
                    $(".alert").slideUp(1000);
                    })
                limpa_campos()
                $("#1serial").focus()
            } */

        }
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
    $("#checkcosm0").prop("checked", false);
    $("#checkcosm0").prop('disabled', true);
    $("#checkcosm1").prop("checked", false);
    $("#checkcosm1").prop('disabled', true);
    $("#checkcosm2").prop("checked", false);
    $("#checkcosm2").prop('disabled', true);
    $("#checkcosm3").prop("checked", false);
    $("#checkcosm3").prop('disabled', true);
    $("select[name=def_cosm0]").attr('hidden', '')
    $("select[name=def_cosm1]").attr('hidden', '')
    $("select[name=def_cosm2]").attr('hidden', '')
    $("select[name=def_cosm3]").attr('hidden', '')

    $("select[name=def_cosm0]").val("0")
    $("select[name=def_cosm1]").val("0")
    $("select[name=def_cosm2]").val("0")
    $("select[name=def_cosm3]").val("0")
}


