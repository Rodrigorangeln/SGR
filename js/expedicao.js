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
        if (($('#nf').val() == "0") || ($('#nf').val() == "")) {
            $('#nf').focus()
        } else if (($('#quant').val() == "0") || ($('#quant').val() == "")) {
            $('#quant').focus()
        }
        else {
            $.ajax({
                url: 'busca_expedicao.php',
                method: 'POST',
                data: { nf: $("#nf").val(), acao: "busca_nf" },
                dataType: 'json',
            }).done(function (retorno) {
                if (retorno == '0') {
                    $("#informe").prop('hidden', false)
                    $("#btn-OK").prop('disabled', true)
                    $("#nf").prop('disabled', true)
                    $("#quant").prop('disabled', true)
                    $("#btn_imp_etiquetas").prop('hidden', false)
                    var quant_caixas = $('#quant').val();
                    var cont = 0;
                    while (cont < quant_caixas) {
                        $("#informe").append('<input id = "caixa-' + cont + '" class="form-control mt-3 mb-3" maxlength="5" onkeyup="maiuscula(this)"></input>')
                        cont++
                    }
                } else {
                    $("#expedicao").prop('hidden', false)
                }
            })


        }
        $("#caixa-0").focus()

    })



    $("#btn_imp_etiquetas").on("click", function () {
        erro = 0
        caixas = []
        for (i = 0; i < $('#quant').val(); i++) {
            if ($("#caixa-" + i).val() == "") {
                $("#caixa-" + i).addClass("is-invalid")
                $('#ModalInputVazio').modal('toggle')
                //i = quant
                erro = 1
            }
            caixas.push($("#caixa-" + i).val())
        }

        $.ajax({
            url: 'busca_expedicao.php',
            method: 'POST',
            data: { caixas, acao: "busca_caixa" },
            dataType: 'json',
        }).done(function (retorno) {
            if (retorno != "") {
                erro = 1
                for (i = 0; i < $('#quant').val(); i++) {
                    if ($("#caixa-" + i).val() == retorno) {
                        $("#caixa-" + i).addClass("is-invalid")
                    }
                }
                $('#ModalCaixaErrada').modal('toggle')
            }
        })

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

})
