$('#menuAdm').addClass('active lead')

function maiuscula(z) {
    v = z.value.toUpperCase().trim();
    z.value = v;
}

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS
    var seriaisCaixa
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

    $("#caixa").focus()

    $("#caixa").on("keydown", function () {
        $("#caixa").removeClass("is-invalid")
    })

    //SELECIONA TODOS CHECKBOXs
    $("#checkTodos").click(function () {
        if ($("#checkTodos").prop('checked')) {
            $("input:checkbox").attr('checked', true)
        } else {
            $("input:checkbox").attr('checked', false)
        }
    })


    $("#buscar_caixa").on("click", function () {
        //$("#marca_todos").prop('hidden', false)

        if (($("#caixa").val()) == "") {
            $("#caixa").focus()
            $("#caixa").addClass("is-invalid")

            document.getElementById("marca_todos").setAttribute("hidden", "true")
            document.getElementById("btn_imp_etiquetas").setAttribute("hidden", "true")
            document.getElementById("btn_imp_etiqueta_caixa").setAttribute("hidden", "true")
            i = 0
            while ($("#checkSerial" + i).length) {
                $("#checkSerial" + i).remove()
                i++
            }

        } else {

            $.ajax({
                url: 'busca_adm.php',
                method: 'POST',
                data: { caixa: $("#caixa").val(), acao: "buscaCaixa" },
                dataType: 'json',
                beforeSend: function () {
                    $("#load").show();
                }
            }).done(function (retorno) {
                seriaisCaixa = retorno

                if (retorno != "") {
                    document.getElementById("marca_todos").removeAttribute("hidden")
                    document.getElementById("btn_imp_etiquetas").removeAttribute("hidden")
                    document.getElementById("btn_imp_etiqueta_caixa").removeAttribute("hidden")
                    $("#checkTodos").prop('checked', false)
                    i = 0
                    retorno['s1'].forEach(() => {
                        $("#marca_todos").append('<div class="input-group mt-3" id="checkSerial' + i + '"><div class="input-group-text"><input type="checkbox" id="checkbox' + i + '"></div><input type="text" class="form-control" disabled id="serial' + i + '" value="' + retorno['s1'][i] + '"></div>')
                        i++
                    });
                } else {
                    $("#caixa").focus()
                    $("#errocaixa").fadeTo(1500, 500).slideUp(1000, function () {
                        $(".alert").slideUp(1000);
                    })

                    document.getElementById("marca_todos").setAttribute("hidden", "true")
                    document.getElementById("btn_imp_etiquetas").setAttribute("hidden", "true")
                    document.getElementById("btn_imp_etiqueta_caixa").setAttribute("hidden", "true")

                    i = 0
                    while ($("#checkSerial" + i).length) {
                        $("#checkSerial" + i).remove()
                        i++
                    }
                }

                $("#load").hide();
            })
        }

    })

    $("#btn_imp_etiquetas").on("click", function () {

        var startLabel = "^XA^MMT^PW639^LL0240^LS0^FO20,12^A3,22"
        var modelo = "^FDMODELO: " + seriaisCaixa['cod_mod'] + "^FS^BY3,3,30^FT27,71^BCN,,Y,N"
        var endLabel = "^FT27,124^A0N,17,19^FH\^FDSERIAL:^FS^FT26,211^A0N,16,16^FH\^FDCM MAC:^FS^PQ1,0,1,Y^XZ"

        i = 0
        while ($("#checkbox" + i).length) {
            if ($("#checkbox" + i).prop('checked')) {
                var seriais = "^FD" + seriaisCaixa['s1'][i] + "^FS^BY3,3,34^FT27,176^BCN,,Y,N^FD" + seriaisCaixa['s2'][i] + "^FS"
                zebraPrinter.send(startLabel + modelo + seriais + endLabel)
            }
            i++
        }
    })

})