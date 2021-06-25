$('#menuAdm').addClass('active lead')

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
                if (retorno != "") {
                    document.getElementById("marca_todos").removeAttribute("hidden")
                    document.getElementById("btn_imp_etiquetas").removeAttribute("hidden")
                    document.getElementById("btn_imp_etiqueta_caixa").removeAttribute("hidden")
                    $("#checkTodos").prop('checked', false)
                    i = 0
                    retorno.forEach(() => {
                        $("#marca_todos").append('<div class="input-group mt-3" id="checkSerial' + i + '"><div class="input-group-text"><input type="checkbox"></div><input type="text" class="form-control" disabled id="serial' + i + '" value="' + retorno[i] + '"></div>')
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
        
    })

})