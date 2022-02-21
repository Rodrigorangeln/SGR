$('#menu_expedicao').addClass('active lead')

/* $(document).keypress(function(e) {
    //alert(event.keyCode)
    if ((e.which == 112) || (e.which == 80)){
        $("#checkPainel").prop("checked", true)
    }    
}); */

function maiuscula(z) {
    v = z.value.toUpperCase().trim();
    z.value = v;
    $(z).removeClass("is-invalid")
}

function preencher(y) {
    //this.value = ("00000" + this.value).slice(-5)
    y.value = ("00000" + y.value).slice(-5)
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


    $("#nf").focus()

    ///* Evita digitação de letras na NF e na quantidade */////////    
    $("#nf").keypress(function (e) {
        var chr = String.fromCharCode(e.which);
        if ("1234567890".indexOf(chr) < 0)
            return false;
    })
    $("#quant").keypress(function (e) {
        var chr = String.fromCharCode(e.which);
        if ("1234567890".indexOf(chr) < 0)
            return false;
    })
    //////////////////////////////////////////////////    

    $("#btn-OK").on("click", function () {
        if (($('#nf').val() < 1) || ($('#nf').val() == "")) {
            $('#nf').focus()
        }
         /*else if (($('#quant').val() < 1) || ($('#quant').val() == "")) {
            $('#quant').focus()
        }*/
        else {
            $.ajax({
                url: 'busca_expedicao.php',
                method: 'POST',
                data: { nf: $("#nf").val(), acao: "busca_nf" },
                dataType: 'json',
            }).done(function (retorno) {
                if (retorno == 0) {
                    $("#informe").prop('hidden', false)
                    $("#list").prop('hidden', false)
                    $("#infoList").prop('hidden', false)
                    $("#btn-OK").prop('disabled', true)
                    $("#nf").prop('disabled', true)
                    $("#quant").prop('disabled', true)
                    $("#btn_imp_etiquetas").prop('hidden', false)
                    var quant_caixas = $('#quant').val();
                    var cont = 0;
                    /*while (cont < quant_caixas) {
                        $("#informe").append('<input id = "caixa-' + cont + '" class="form-control mt-3 mb-3" maxlength="5" onblur="preencher(this)" onkeyup="maiuscula(this)"></input>')
                        cont++
                    }
                    $("#caixa-0").focus()*/
                } else {
                    $("#btn-OK").prop('disabled', true)
                    $("#nf").prop('disabled', true)
                    $("#quant").prop('disabled', true)
                    $("#expedicao").prop('hidden', false)
                }
            })

        }

    })



    $("#btn_imp_etiquetas").on("click", function () {
        caixas = [];
        caixas = $('#list').val();

        //for (i = 0; i <  caixas.length; i++) {}

        $.ajax({
            url: 'busca_expedicao.php',
            method: 'POST',
            data: { caixas, acao: "busca_caixa" },
            dataType: 'json',
            async: false  //AJAX síncrono pois é preciso aguardar retorno p continuar.
        })
        /* .done(function (retorno) {
            if (retorno['0'] != null) {
                for (i = 0; i < $('#quant').val(); i++) {
                    if ($("#caixa-" + i).val() == retorno) {
                        $("#caixa-" + i).addClass("is-invalid")
                    }
                }
                $('#ModalCaixaErrada').modal('toggle')
                erro = 1
            }
        }) */

            $.ajax({
                url: 'busca_expedicao.php',
                method: 'POST',
                data: { caixas, nf_saida: $('#nf').val(), acao: "grava_caixas" },
                dataType: 'json',
            }).always(function () {

                for (i = 1; i <= $("#quant").val(); i++) {

                    var labelCaixa = "^XA^MMT^PW639^LL0240^LS0^FO20,30^A3,200^FD" + $("#nf").val() + "   " + i + "/" + $("#quant").val() + "^FS^PQ1,0,1,Y^XZ"

                    //if (zebraPrinter != null) //Continua mesmo que não tenha Zebra Browser Printer instalado. 
                    zebraPrinter.send(labelCaixa);

                }

                $("#expedicao").prop('hidden', false)
                $("#date").focus()

                /* for (i = 0; i < $('#quant').val(); i++) {
                    $("#caixa-" + i).prop('disabled', true)
                } */
                $('#list').prop('disabled', true);

            })
        
        
       /*  erro = 0
        caixas = []
        /// VERIFICA SE EXISTE ALGUMA CAIXA NÃO PREENCHIDA
        for (i = 0; i < $('#quant').val(); i++) {
            if ($("#caixa-" + i).val() == "") {
                $("#caixa-" + i).addClass("is-invalid")
                $('#ModalInputVazio').modal('toggle')
                //i = quant
                erro = 1
            }
            caixas.push($("#caixa-" + i).val())
        }
        ////////////

        if (erro == 0) {
            $.ajax({
                url: 'busca_expedicao.php',
                method: 'POST',
                data: { caixas, acao: "busca_caixa" },
                dataType: 'json',
                async: false  //AJAX síncrono pois é preciso aguardar retorno p continuar.
            }).done(function (retorno) {
                if (retorno['0'] != null) {
                    for (i = 0; i < $('#quant').val(); i++) {
                        if ($("#caixa-" + i).val() == retorno) {
                            $("#caixa-" + i).addClass("is-invalid")
                        }
                    }
                    $('#ModalCaixaErrada').modal('toggle')
                    erro = 1
                }
            })
        }


        if (erro == 0) {
            $.ajax({
                url: 'busca_expedicao.php',
                method: 'POST',
                data: { caixas, nf_saida: $('#nf').val(), acao: "grava_caixas" },
                dataType: 'json',
            }).always(function () {

                for (i = 1; i <= $("#quant").val(); i++) {

                    var labelCaixa = "^XA^MMT^PW639^LL0240^LS0^FO20,30^A3,200^FD" + $("#nf").val() + "   " + i + "/" + $("#quant").val() + "^FS^PQ1,0,1,Y^XZ"

                    //if (zebraPrinter != null) //Continua mesmo que não tenha Zebra Browser Printer instalado. 
                    zebraPrinter.send(labelCaixa);

                }

                $("#expedicao").prop('hidden', false)
                $("#date").focus()

                for (i = 0; i < $('#quant').val(); i++) {
                    $("#caixa-" + i).prop('disabled', true)
                }

            })
        } */
    })



    $("#btn-OK-expedicao").on("click", function () {
        if ($("#date").val() != "") {
            $.ajax({
                url: 'busca_expedicao.php',
                method: 'POST',
                data: { nf_saida: $('#nf').val(), date: $('#date').val(), acao: "grava_data_expedicao" },
                dataType: 'json',
            }).always(function () {
                $('#ModalCaixaDespachada').modal('toggle')
            })
        }

    })

    $('#ModalCaixaDespachada').on('hide.bs.modal', function (event) {
        location.reload();
    })








})
