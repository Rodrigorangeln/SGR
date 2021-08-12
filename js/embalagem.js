$('#menu_embalagem').addClass('active lead')

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
    var zebraPrinter;
    ///// ZEBRA PRINTER ////////////
    BrowserPrint.getDefaultDevice('printer', function (printer) {
        //alert(printer.name);
        zebraPrinter = printer;
        //printer.send('^XA^FO200,200^A0N36,36^FDTest Nortcom^FS^XZ');
    },

        function (error_response) {
            alert("Erro de comunicação com a impressora Zebra.");
        }

    );
    ////////// FIM ZEBRA PRINTER ////////


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
            $("#btn_imp_etiqueta_caixa").prop('hidden', false)
            $("#btn_imp_etiquetas").prop('hidden', false)
            $("#finalizar").prop('hidden', false)

            //alert (numero_caixa())
            var quant_seriais = $('#quant').val()
            var cont = 0

            if ($("#radio_n").is(":checked")) {
                while (cont < quant_seriais) {
                    //$("#serial1").append ('<input id = "serial1-'+cont+'" class="form-control mt-2" onblur="getserial(id); verifica_serial_cliente(id);" data-toggle="popover-cliente" data-trigger="manual" data-placement="right" data-html="true" data-content="<strong>Serial não é desse cliente</strong>"></input>')
                    $("#serial1").append('<input id = "serial1-' + cont + '" class="form-control mt-2" maxlength="25" onblur="getserial(id)"; onkeyup="maiuscula(this)"></input>')
                    $("#serial2").append('<input id = "serial2-' + cont + '"class="form-control mt-2" disabled></input>')
                    cont++
                }
            } else if ($("#radio_s").is(":checked")) {
                $("#smartcard").prop('hidden', false)
                while (cont < quant_seriais) {
                    //$("#serial1").append ('<input id = "serial1-'+cont+'" class="form-control mt-2" onblur="getserial(id); verifica_serial_cliente(id);" data-toggle="popover-cliente" data-trigger="manual" data-placement="right" data-html="true" data-content="<strong>Serial não é desse cliente</strong>"></input>')
                    $("#serial1").append('<input id = "serial1-' + cont + '" class="form-control mt-2" maxlength="25" onblur="getserial(id)"; onkeyup="maiuscula(this)"></input>')
                    $("#serial2").append('<input id = "serial2-' + cont + '"class="form-control mt-2" disabled></input>')
                    $("#smartcard").append('<input id = "smartcard-' + cont + '" class="form-control mt-2" onblur="tab(id)"; onkeyup="maiuscula(this)"></input>')
                    cont++
                }
            }
            $("#serial1-0").focus()
            $('#cliente').prop('disabled', true)
            $('#modelo').prop('disabled', true)
            $('#quant').prop('disabled', true)
            $('#radio_s').prop('disabled', true)
            $('#radio_n').prop('disabled', true)
            $('#criar_caixa').prop('disabled', true)
        }
    })


    $("#btn_imp_etiquetas").on("click", function () {
        erro = 0
        for (i = 0; i < $('#quant').val(); i++) {
            if ($("#serial1-" + i).hasClass("is-invalid")) {
                $('#ModalSerialInvalido').modal('toggle')
                i = quant
                erro = 1
            }
            if ($("#serial2-" + i).val() == "") {
                $('#ModalSerial2').modal('toggle')
                i = quant
                erro = 1
            }
            if ($("#smartcard-" + i).val() == "") {
                $('#ModalSmartCard').modal('toggle')
                i = quant
                erro = 1
            }
        }

        if (erro == 0) {
            /* $.ajax({
                url: 'geraEtiquetas.php',
                method: 'POST',
                data: { modelo: $("#modelo").val(), serial1: $("#serial1-0").val(), serial2: $("#serial2-0").val() },
                dataType: 'json',
            }).always(function () {
                alert("Arquivo de etiquetas gerado")
            }) */

            var startLabel = "^XA^MMT^PW639^LL0240^LS0^FO20,12^A3,22"
            var modelo = "^FDMODELO: " + $("#modelo").val() + "^FS^BY3,3,30^FT27,71^BCN,,Y,N"
            var endLabel = "^FT27,124^A0N,17,19^FH\^FDSERIAL:^FS^FT26,211^A0N,16,16^FH\^FDCM MAC:^FS^PQ1,0,1,Y^XZ"

            for (i = 0; i < $("#quant").val(); i++) {

                var seriais = "^FD" + $("#serial1-" + i).val() + "^FS^BY3,3,34^FT27,176^BCN,,Y,N^FD" + $("#serial2-" + i).val() + "^FS"

                zebraPrinter.send(startLabel + modelo + seriais + endLabel)
            }


        }

    })

    $("#btn_imp_etiqueta_caixa").on("click", function () {
        erro = 0
        for (i = 0; i < $('#quant').val(); i++) {
            if ($("#serial1-" + i).hasClass("is-invalid")) {
                $('#ModalSerialInvalido').modal('toggle')
                i = quant
                erro = 1
            }
            if ($("#serial2-" + i).val() == "") {
                $('#ModalSerial2').modal('toggle')
                i = quant
                erro = 1
            }
            if ($("#smartcard-" + i).val() == "") {
                $('#ModalSmartCard').modal('toggle')
                i = quant
                erro = 1
            }
        }

        if (erro == 0) {

            var cod = $("#modelo").val().substring(0, 8)

            $.ajax({
                url: 'busca_embalagem.php',
                method: 'POST',
                data: { cod, acao: "busca_modelo" },
                dataType: 'json',
            }).always(function (result) {
                var labelCaixa = "^XA^MMT^PW639^LL0240^LS0^FO20,12^A3,200^FD" + result + "    " + $("#quant").val() + "^FS^PQ1,0,1,Y^XZ"
                zebraPrinter.send(labelCaixa);
            })
        }

    })

    $("#finalizar").on("click", function () {
        erro = 0
        for (i = 0; i < $('#quant').val(); i++) {
            if ($("#serial1-" + i).hasClass("is-invalid")) {
                $('#ModalSerialInvalido').modal('toggle')
                i = quant
                erro = 1
            }
            if ($("#serial2-" + i).val() == "") {
                $('#ModalSerial2').modal('toggle')
                i = quant
                erro = 1
            }
            if ($("#smartcard-" + i).val() == "") {
                $('#ModalSmartCard').modal('toggle')
                i = quant
                erro = 1
            }
        }

        if (erro == 0) {
            $('#ModalFinalizar').modal('toggle')
        }

    })

    $("#btn_Confirmo").on("click", function () {
        $("#btn_Confirmo").prop('hidden', true);
        $("#btn_ModalNao").prop('hidden', true);

        $('#ModalFinalizar .modal-body').html('AGUARDE. CRIANDO CAIXA ...');

        n_caixa = numero_caixa();

        //$('#ModalFinalizar .modal-body').html('CRIANDO CAIXA <strong>' + n_caixa + ' </strong>...');

        var labelCaixa = "^XA^MMT^PW639^LL0240^LS0^FO20,30^A3,200^FD" + n_caixa + "^FS^PQ1,0,1,Y^XZ"

        if (zebraPrinter != null) // Gera caixa mesmo que não tenha Zebra Browser Printer instalado. 
            zebraPrinter.send(labelCaixa);

        //////>>>>TESTAR ETIQUETA COM LOGO //////////////
        /* var logo = "^XA^FO50,50^GFA,640,640,8,7LF80LFEMFC07KFEMFE07!NF01KFENF81KFENFC0KFENFE07JFEOF03JFEOF01JFEOF80JFEOFC07IFEOFE07IFEPF03IFEPF81IFEPF80IFEPFE07FFEPFE03FFEQF01FFEQF81FFEQFC0FFEQFE07FERF03FERF81FE7QF80FE3QFC07E1QFE03E0RF03E07QF81E03QFC0E03QFE0701QFE0380RF,C07QF8,E03QFC,F01QFE,F80RF,FC07QF8FE07QFCFE03QFCFF01QFEFF80!FFC07PFEFFE03PFEIF03PFEIF81PFEIFC0PFEIFC07OFEIFE03OFEJF01OFEJF80OFEJFC0OFEJFE07NFEJFE03NFEKF01NFEKF80NFEKFC07MFEKFE03MFELF03MFELF01MFELF80MFELFC07!LFE03!7KFE01LFE,::I0EK03038,F31F1F9FCFC7C79EF33F9FDFCFCFE79!F3319CE71CIE79EFB3198C71CDC679EFF319DC71C0C67DEFF319FC71C0C67FEFF319FC71C0C67!EF319DC71CDC67!EF3198C71CFC67F7EF3198C71CIEI7E73F9CC70FCFEI7E71F18E70FC7CI6I0EK030382,^FS"
        var logoFinal = "^MMT^PW639^LL0240^LS0^FO150,60^A3,50^FD" + $("#num_caixa_atual").html() + "^FS^PQ1,0,1,Y^XZ"
        zebraPrinter.send(logo + logoFinal) */
        ///////////////////////////////////////


        var seriais = []
        var smartcards = []
        for (i = 0; i < $("#quant").val(); i++) {
            seriais[i] = $("#serial1-" + i).val()
            smartcards[i] = $("#smartcard-" + i).val()
        }

        $.ajax({
            url: 'busca_embalagem.php',
            method: 'POST',
            data: { n_caixa, quant: $("#quant").val(), seriais, smartcards, acao: "atualiza_seriais" },
            dataType: 'json',
            async: false, //AGUARDA RETORNO DO BD
            /* beforeSend: function () {
                $("#load").show();
            } */
        }).always(function () {
            //$('#ModalFinalizar').modal('hide')
            $('#ModalFinalizar .modal-header').html('<h5><strong>Atenção ✔️</strong></h5>');
            $('#ModalFinalizar .modal-body').html('CAIXA <strong>' + n_caixa + ' </strong>CRIADA.');
            /* $("#embalagemOK").fadeTo(4000, 500).slideUp(500, function () {
                $(".alert").slideUp(1000);
            }) */
            $('#ModalFinalizar').on('hidden.bs.modal', function (e) {
                location.reload();
            })
            $("#load").hide();
        })

    })

})




function numero_caixa() {
    var retornoFunc;
    $.ajax({
        url: 'busca_embalagem.php',
        method: 'POST',
        data: { acao: "numero_caixa" },
        dataType: 'json',
        async: false, //AGUARDA RETORNO DO BD
        beforeSend: function () {
            $("#load").show();
        }
    }).done(function (retorno) {
        retornoFunc = retorno;
        //$('#caixa').html("Caixa nº <strong id='num_caixa_atual' class='display-4'>" + retorno + "</strong>")
        //$('#criar_caixa').prop('disabled', true)
    })
    return retornoFunc;
}


function getserial(id) {
    ///////Dá foco ao próximo input SMARTCARD quando houver
    j = id.substring(8)
    $("#smartcard-" + j).focus()
    ///////////////////////////

    var serial1 = $("#" + id).val()
    var serial2 = id.replace("serial1", "serial2");
    if (serial1 == "") {
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
        var semRepetidos = array.filter(function (el, i) {  //PREENCHE novo array sem os itens repetidos
            return array.indexOf(el) === i;
        });

        serialrepetido = 0
        if (semRepetidos.length < array.length) {
            $("#" + id).addClass("is-invalid")
            $("#" + serial2).val("EXISTE SERIAL REPETIDO");
            serialrepetido = 1
            $('#ModalSerialDuplicado').modal('toggle')
        }


        if (serialrepetido == 0) {
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


    } else {
        $("#" + id).addClass("is-invalid")
    }

}

function tab(id) {
    i = id.substring(10)
    i++
    $("#serial1-" + i).focus()
}