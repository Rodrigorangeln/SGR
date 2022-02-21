
function modeloAtual(cod) {

    cod = cod.toString();
    var item = cod.substring(0, 1);
    var cod = cod.substr(1)

    $("input[name='aux_codmod']").val(cod);
    $("input[name='aux_item']").val(item);

    $.ajax({
        url: 'buscaModelo.php',
        method: 'POST',
        data: { cod_mod: cod },
        dataType: 'json',
        success: (function (result) {
            $("table#modelos tr").removeClass("table-info");
            $("table#modelos tr:contains(" + cod + ")").addClass("table-info");

            $("input[name='modelo_atual']").val(result);
            $("input[name='1serial0']").focus();

            $('#tab_logic tr:not(#addr0)').remove()

            if (cod == "41000601") {    ////MODELO C 1 SERIAL /////REVER CÓDIGO pois trecho se repete
                $("input[name='1serial0']").prop("disabled", false);             
                $("#2serial").html('');
                $("input[name='1serial0']").val("");
            } else {
                $("input[name='1serial0']").prop("disabled", false);
                $("#2serial").html("<input type='text' name='2serial0' placeholder='Serial 2' maxlength='25' class='form-control' onkeyup='maiuscula(this)' onblur='add_row.click(); gravaSeriais(name);'/>");
                $("input[name='1serial0']").val("");
                $("input[name='2serial0']").val("");
            }

            /* $("input[name='1serial0']").val("");
            $("input[name='2serial0']").val(""); */

            if (($('tr#addr0')).length) { }
            else {
                location.reload()
            }

        })
    })

}

function verifica2serial(name) {
    //segundoSerial = name.substring(1);
    if ($("input[name='aux_codmod']").val() == "41000601"){ ////MODELO C 1 SERIAL /////REVER CÓDIGO pois trecho se repete
        //alert (segundoSerial)
        add_row.click()
        gravaSerial(name)
    }
    
}


//Habilita botão Fechar RRM se todos os check boxs estiverem ticados.
function verificaCheckbox() {
    var ativo = 1;
    var i = 0;
    while (i < 20) {
        if (document.getElementById('check' + i)) {
            if ($("#check" + i).is(':checked')) {
                document.getElementById("fecharrm").disabled = false;
            } else {
                ativo = 0;
            }
        }
        i++;
    }
    if (ativo == 0)
        document.getElementById("fecharrm").disabled = true;
}


/* $(document).ready(function() {
    $("#fecharrm").on("click", function() {
        window.alert("teste");
    })
}) */


// CONVERTE LETRAS MINÚSCULAS P MAIÚSCULAS E IMPEDE INSERÇÃO DE ESPAÇOS.
function maiuscula(z) {
    v = z.value.toUpperCase().trim();
    z.value = v;
}

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS

    $("#btn_report_seriais").on("click", function () {
        cliente = $("#Cliente").val()
        nf = "NF: " + $("#num_nf").val()
        rrm = $("#num_rrm").val()
        window.location.href = "report_seriais.php?cliente=" + cliente + "&nf=" + nf + "&rrm=" + rrm
    })

    $("#add_row").on("click", function () {
        // Dynamic Rows Code

        // Get max row id and set new id
        var newid = 0;

        $.each($("#tab_logic tr"), function () {
            if (parseInt($(this).data("id")) > newid) {
                newid = parseInt($(this).data("id"));
            }
        });

        //IMPEDE QUE O PRIMEIRO SERIAL ESTEJA VAZIO e QUE NÃO TENHA MODELO SELECIONADO
        if (($("input[name='1serial" + newid + "']").val() != "") && ($("input[name='modelo_atual']").val() != "")) {

            newid++;

            var tr = $("<tr></tr>", {
                id: "addr" + newid,
                "data-id": newid
            });


            // loop through each td and create new elements with name of newid
            $.each($("#tab_logic tbody tr:nth(0) td"), function () {
                var td;
                var cur_td = $(this);
               
                var children = cur_td.children();

                // add new td and element if it has a nane
                if ($(this).data("name") !== undefined) {
                    td = $("<td></td>", {
                        "data-name": $(cur_td).data("name")
                    });

                    var c = $(cur_td).find($(children[0]).prop('tagName')).clone().val("");
                    c.attr("name", $(cur_td).data("name") + newid);
                    c.appendTo($(td));
                    td.appendTo($(tr));
                } else {
                    td = $("<td></td>", {
                        'text': $('#tab_logic tr').length
                    }).appendTo($(tr));
                }
            });

        }

        else if ($("input[name='modelo_atual']").val() == "") {  //MOSTRA ALERTA SE NÃO HOUVER MODELO SELECIONADO
            $("#alertaModeloAtual").fadeTo(6000, 500).slideUp(500, function () {
                $(".alert").slideUp(1000);
            });
        }
        else if ($("input[name='1serial" + newid + "']").val() == "") {
            $("#alertaSerial").fadeTo(6000, 500).slideUp(500, function () {  //MOSTRAR ALERTA SE SERIAL ESTIVER VAZIO
                $(".alert").slideUp(1000);
            });
        }


        var aux = newid - 1
        if ($("input[name='2serial" + aux + "']").val() == "") {
            $("#alertaSerial").fadeTo(6000, 500).slideUp(500, function () {  //MOSTRAR ALERTA SE SERIAL ESTIVER VAZIO
                $(".alert").slideUp(1000);
            });
            $("input[name='1serial" + aux + "']").focus();
        }
        /* else if ($("input[name=1serial"+aux+"]").val() == ($("input[name=2serial"+aux+"]").val())){
            $("#alertaSeriaisIguais").fadeTo(6000, 500).slideUp(500, function(){
                $(".alert").slideUp(1000);                
            });
        } */
        else if ($("input[name=1serial" + aux + "]").val() != ($("input[name=2serial" + aux + "]").val())) {
            // add the new row
            $(tr).prependTo($('#tab_logic'));
        }


        $(tr).find("td button.row-remove").on("click", function () {

            if (($("input[name='1serial" + newid + "']").val() != "") && ($("input[name='2serial" + newid + "']").val() != "")) {
                delSeriais($("input[name='1serial" + newid + "']").val())
                conta_seriais()
                //$("input[name='1serial"+newid+"']").val(""); 
                //$("input[name='2serial"+newid+"']").val("");
                $(this).closest("tr").remove();
            }
            /* else if (($("input[name='1serial0']").val() == "") && ($("input[name='2serial0']").val() == "")) {
                $("input[name='1serial"+newid+"']").val(""); 
                $("input[name='2serial"+newid+"']").val("");
                //$(this).closest("tr").remove();
            } */

        });

        $("button[name='del0']").on("click", function () {
            if (($("input[name='1serial0']").val() != "") && ($("input[name='2serial0']").val() != "")) {
                delSeriais($("input[name='1serial0']").val())
                conta_seriais()
                //$("input[name='1serial"+newid+"']").val(""); 
                //$("input[name='2serial"+newid+"']").val("");
                $(this).closest("tr").remove();
            }
        })



        $("input[name='1serial" + newid + "']").focus(); //Foca no próximo serial



    });


    $("#fecharrm").on("click", function () {
        $.ajax({
            url: 'fecharrm.php',
            method: 'POST',
            data: { rrm: $("input[name=num_rrm]").val() },
            dataType: 'json',
            success: (function (result) {
            })
        })

        $("#alertaRRM_Fechado").fadeTo(6000, 500).slideUp(500, function () {
            $(".alert").slideUp(1000);
        })

        setTimeout("window.location.href = 'rrms_abertas.php'", 2500);
    })


});


function delSeriais(s1) {
    $.ajax({
        url: 'delSeriais.php',
        method: 'POST',
        data: { s1, rrm: $("input[name=num_rrm]").val() },
        dataType: 'json',
    })
}


function gravaSeriais(name) {
    var i = name.substring(7)
    var rrm = $("input[name=num_rrm]").val()
    var s1 = $("input[name=1serial" + i + "]").val()

    if (($("input[name=1serial" + i + "]").val() == ($("input[name=" + name + "]").val())) && ($("input[name=1serial" + i + "]").val() != "")) {
        $("#alertaSeriaisIguais").fadeTo(6000, 500).slideUp(500, function () {
            $(".alert").slideUp(1000);
        });
        $("input[name='1serial" + i + "']").focus();
        $("input[name=1serial" + i + "]").val("")
        $("input[name=" + name + "]").val("")

    }
    //else if (($("input[name=1serial"+i+"]").val() != "") && ($("input[name=2serial"+i+"]").val() != "") && ($("input[name='modelo_atual']").val() != "")){
    else if (($("input[name=1serial" + i + "]").val() != "") && ($("input[name=" + name + "]").val() != "") && ($("input[name='modelo_atual']").val() != "")) {
        $.ajax({
            url: 'serial_duplicado.php',
            method: 'POST',
            data: { s1 },
            dataType: 'json',
        }).done(function (result) {
            //alert (result) /////////////////////apagar
            if (result != 0) {
                $("#alertaSeriaisDuplicadosBD").fadeTo(6000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                });
                $("#addr" + i).remove();
                $("input[name='1serial" + i + "']").focus();
            }
            else {
                var serial1 = $("input[name=1serial" + i + "]").val();
                var serial2 = $("input[name=2serial" + i + "]").val();

                $.ajax({
                    url: 'gravaSeriais.php',
                    method: 'POST',
                    async: false,
                    data: { serial1, serial2, rrm: $("input[name=num_rrm]").val(), cod_m: $("input[name='aux_codmod']").val(), item: $("input[name='aux_item']").val() },
                    dataType: 'json',
                })

                $("input[name='1serial" + i + "']").prop("disabled", true);
                $("input[name='2serial" + i + "']").prop("disabled", true);
                conta_seriais()
            }
        })

    }
}



function gravaSerial(name) {
    var rrm = $("input[name=num_rrm]").val()
    var s1 = $("input[name=" + name + "]").val()

    if (s1 == "") {
        $("#alertaSerial").fadeTo(6000, 500).slideUp(500, function () {
            $(".alert").slideUp(1000);
        });
        $("input[name=" + name + "]").focus();
        $("input[name=" + name + "]").val("")

    }
    //else if (($("input[name=1serial"+i+"]").val() != "") && ($("input[name=2serial"+i+"]").val() != "") && ($("input[name='modelo_atual']").val() != "")){
    else if (($("input[name=" + name + "]").val() != "") && ($("input[name='modelo_atual']").val() != "")) {
        $.ajax({
            url: 'serial_duplicado.php',
            method: 'POST',
            data: { s1 },
            dataType: 'json',
        }).done(function (result) {
            //alert (result) /////////////////////apagar
            if (result != 0) {
                $("#alertaSeriaisDuplicadosBD").fadeTo(6000, 500).slideUp(500, function () {
                    $(".alert").slideUp(1000);
                });
                $("#addr" + i).remove();
                $("input[name=" + name + "]").focus();
            }
            else {
                var serial1 = $("input[name=" + name + "]").val();

                $.ajax({
                    url: 'gravaSeriais.php',
                    method: 'POST',
                    data: { serial1, serial2: "-", rrm: $("input[name=num_rrm]").val(), cod_m: $("input[name='aux_codmod']").val(), item: $("input[name='aux_item']").val() },
                    dataType: 'json',
                })

                $("input[name=" + name + "]").prop("disabled", true);
                conta_seriais()
            }
        })

    }
}




function conta_seriais() {
    //var i = 0
    item = $("input[name='aux_item']").val()
    $.ajax({
        url: 'conta_seriais.php',
        method: 'POST',
        data: { rrm: $("input[name=num_rrm]").val(), cod_m: $("input[name='aux_codmod']").val(), item: $("input[name='aux_item']").val() },
        dataType: 'json',
        success: (function (result) {
            aux = $('.table-info td[id^="tdcountt'+item+'"]').text() - result
            $('.table-info td[id^="tdcountdown'+item+'"]').text(aux)
        }) 
    })
}


