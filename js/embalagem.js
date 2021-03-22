$('#menu_embalagem').addClass('active lead')

/* $(document).keypress(function(e) {
    //alert(event.keyCode)
    if ((e.which == 112) || (e.which == 80)){
        $("#checkPainel").prop("checked", true)
    }    
}); */

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS

    $("#cliente").focus()

    ///* Evita digitação de letras na quantidade */////////    
    $("#quant").keypress(function (e) {
        var chr = String.fromCharCode(e.which);
        if ("1234567890".indexOf(chr) < 0)
            return false;
    })
    //////////////////////////////////////////////////    
    $("#cliente").on("blur", function () {
        $.ajax({
            url: 'busca_embalagem.php',
            method: 'POST',
            data: { cliente: $("#cliente").val(), acao: "busca_cliente" },
            dataType: 'json',
        }).done(function (retorno) {
            if (retorno == '0') {
                $("#errocliente").fadeTo(2000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                })
                $("#cliente").focus()

                document.querySelectorAll('#modelo option').forEach(option => option.remove())
                $('#modelo').append('<option disabled selected>Digite o código ou Selecione...</option>');
            } else {

                document.querySelectorAll('#modelo option').forEach(option => option.remove())
                $('#modelo').append('<option value = "0"  selected>Digite o código ou Selecione...</option>');

                retorno.forEach((modelos) => {
                    option = new Option(modelos, modelos.toLowerCase());
                    modelo.options[modelo.options.length] = option;
                });
            }
        })
    })


    $("#criar_caixa").on("click", function () {
        if ($('#cliente').val() == "0") {
            $('#cliente').focus()
        } else if ($('#modelo').val() == "0") {
            $('#modelo').focus()
        } else if ($('#quant').val() == "") {
            $('#quant').focus()
        } else if ($("#radio_s").is(":checked") == false && $("#radio_n").is(":checked") == false) {
            $("#errosmartcard").fadeTo(2000, 500).slideUp(500, function () {
                $(".alert").slideUp(1000);
            })
        } else {
            $("#serial1").prop('hidden', false)
            $("#serial2").prop('hidden', false)
            $("#finalizar").prop('hidden', false)

            numero_caixa()
            var quant_seriais = $('#quant').val()
            var cont = 0

            if ($("#radio_n").is(":checked")) {
                while (cont < quant_seriais) {
                    //$("#serial1").append ('<input id = "serial1-'+cont+'" class="form-control mt-2" onblur="getserial(id); verifica_serial_cliente(id);" data-toggle="popover-cliente" data-trigger="manual" data-placement="right" data-html="true" data-content="<strong>Serial não é desse cliente</strong>"></input>')
                    $("#serial1").append('<input id = "serial1-' + cont + '" class="form-control mt-2" maxlength="18" onblur="getserial(id)";></input>')
                    $("#serial2").append('<input id = "serial2-' + cont + '"class="form-control mt-2" disabled></input>')
                    cont++
                }
            } else if ($("#radio_s").is(":checked")) {
                $("#smartcard").prop('hidden', false)
                while (cont < quant_seriais) {
                    //$("#serial1").append ('<input id = "serial1-'+cont+'" class="form-control mt-2" onblur="getserial(id); verifica_serial_cliente(id);" data-toggle="popover-cliente" data-trigger="manual" data-placement="right" data-html="true" data-content="<strong>Serial não é desse cliente</strong>"></input>')
                    $("#serial1").append('<input id = "serial1-' + cont + '" class="form-control mt-2" maxlength="18" onblur="getserial(id)";></input>')
                    $("#serial2").append('<input id = "serial2-' + cont + '"class="form-control mt-2" disabled></input>')
                    $("#smartcard").append('<input id = "smartcard-' + cont + '" class="form-control mt-2"></input>')
                    cont++
                }
            }
            $("#serial1-0").focus()
            $('#cliente').prop('disabled', true)
            $('#modelo').prop('disabled', true)
            $('#quant').prop('disabled', true)
            $('#radio_s').prop('disabled', true)
            $('#radio_n').prop('disabled', true)
        }
    })


    $("#finalizar").on("click", function () {
        for (i = 0; i < $('#quant').val(); i++) { 
            if ($("#serial1-" + i).hasClass("is-invalid")) {
                $('#ModalSerialInvalido').modal('toggle')
                i = quant
            }
            if ($("#serial2-" + i).val() == "") {
                $('#ModalSerial2').modal('toggle')
                i = quant
            }
            if ($("#smartcard-" + i).val() == "") {
                $('#ModalSmartCard').modal('toggle')
                i = quant
            }
        }

    })

    /* x = 0
    $(document).on('blur', '#serial1-'+x, function(){
        alert ("testeTAB")
    }) */

})





function numero_caixa() {
    $.ajax({
        url: 'busca_embalagem.php',
        method: 'POST',
        data: { acao: "numero_caixa" },
        dataType: 'json',
    }).done(function (retorno) {
        $('#caixa').html("Caixa nº <strong class='display-4'>" + retorno + "</strong>")
        $('#criar_caixa').prop('disabled', true)
    })
}


function getserial(id) {
    var serial1 = $("#" + id).val()
    var serial2 = id.replace("serial1", "serial2");
    if (serial1 == ""){
        $("#" + id).removeClass("is-invalid")
        $("#" + serial2).val("")
    }

    if (serial1 != "") {

        array = []
        var quant = $("#quant").val()
        for (i = 0; i < quant; i++) { 
            if ($("#serial1-" + i).val() != "") {
                array.push($("#serial1-" + i).val())
            }
        }
        var semRepetidos = array.filter(function(el, i) {  //PREENCHE novo array sem os itens repetidos
            return array.indexOf(el) === i;
        });
        
        serialrepetido = 0
        if (semRepetidos.length < array.length){
            $("#" + id).addClass("is-invalid")
            $("#" + serial2).val("EXISTE SERIAL REPETIDO");
            serialrepetido = 1
            $('#ModalSerialDuplicado').modal('toggle')
        }


        if (serialrepetido == 0){
            $.ajax({
                url: 'busca_embalagem.php',
                method: 'POST',
                data: { serial1, cliente: $("#cliente").val(), modelo: $("#modelo").val(), acao: "busca_serial" },
                dataType: 'json',
            }).done(function (result) {
                if (result == "erro-embalagem") {
                    $("#" + id).addClass("is-invalid")
                    $("#" + serial2).val("NÃO ESTÁ NO SETOR EMBALAGEM");
                } else
                    if (result == "erro-cliente") {
                        $("#" + id).addClass("is-invalid")
                        $("#" + serial2).val("NÃO É DESSE CLIENTE");
                    } else
                        if (result == "erro-modelo") {
                            $("#" + id).addClass("is-invalid")
                            $("#" + serial2).val("NÃO É DESSE MODELO");
                        } else
                            if (result == "erro-jaembalado") {
                                $("#" + id).addClass("is-invalid")
                                $("#" + serial2).val("JÁ FOI EMBALADO");
                            }
                            else {
                                $("#" + id).removeClass("is-invalid")
                                $("#" + id).addClass("is-valid")
                                $("#" + serial2).val(result);
                            }
            })

        }

        
    }

}