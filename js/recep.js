$('#menu_recep').addClass('active lead')

/* Impede que o ENTER submeta o form */
$(document).keypress(function (e) {
    //if(e.which == 13) e.preventDefault();
    //if ($("input[name='quant0']").val() == "") e.preventDefault()
});


/* Adiciona e exclui dinamicamente linhas para inclusão de modelos */
$(document).ready(function () {

    ///* Evita digitação de letras */////////    
    $(document).keypress(function (e) {
        var chr = String.fromCharCode(e.which);
        if ("1234567890".indexOf(chr) < 0)
            return false;
    })
    //////////////////////////////////////////////////    

    $("#add_row").on("click", function () {
        // Dynamic Rows Code

        // Get max row id and set new id
        var newid = 0;
        $.each($("#tab_logic tr"), function () {
            if (parseInt($(this).data("id")) > newid) {
                newid = parseInt($(this).data("id"));
            }
        });

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


        // add delete button and td
        /*
        $("<td></td>").append(
            $("<button class='btn btn-danger glyphicon glyphicon-remove row-remove'></button>")
                .click(function() {
                    $(this).closest("tr").remove();
                })
        ).appendTo($(tr));
        */

        //IMPEDE CÓDIGO DO MODELO INVÁLIDO
        aux = newid - 1
        if (($("input[name='modelo" + aux + "']").val() == "") || ($("input[name='modelo" + aux + "']").val() == "Modelo não encontrado") || ($("input[name='quant" + aux + "']").val() == "")) {
            $("select[name='cod" + aux + "']").focus()
        } else {
            // add the new row
            $(tr).prependTo($('#tab_logic'));
        }



        $(tr).find("td button.row-remove").on("click", function () {
            /* $("select[name='cod"+newid+"']").val("")   
            $("input[name='modelo"+newid+"']").val("")  
            $("input[name='quant"+newid+"']").val("") */

            if (($("input[name='modelo" + newid + "']").val() != "") && ($("input[name='modelo" + newid + "']").val() != "Modelo não encontrado"))
                $(this).closest("tr").remove();

            calculaTotal();
        });


        $("button[name='del0']").on("click", function () {
            if (($("input[name='modelo0']").val() != "") && ($("input[name='modelo0']").val() != "Modelo não encontrado"))
                $(this).closest("tr").remove();

            calculaTotal();
        })


        //$("input[name='cod"+newid+"']").focus(); //Foca no próximo código de modelo
        $("select[name='cod" + newid + "']").focus(); //Foca no próximo código de modelo

        calculaTotal()

        
        $("input[name='item" + aux + "']").val(newid) //Implementa número do item.

    });

    $("#btn_Cadastrar").on("click", function (e) {
        if ($("input[name='quant0']").val() == "") e.preventDefault()
        if (($("select.input[name='cod0'] select").val() == "")) e.preventDefault()
        if (($("select.input[name='cod_cliente'] select").val() == "")) e.preventDefault()
        if ($('#dt_emissao').hasClass("is-invalid")) e.preventDefault()
    });

    $("#dt_emissao").on("blur", function (e) {
        if ($('#dt_emissao').val() > $('#dt_entrada').val())
            $('#dt_emissao').addClass("is-invalid")
         else
            $('#dt_emissao').removeClass("is-invalid")

    });


    // Sortable Code
    var fixHelperModified = function (e, tr) {
        var $originals = tr.children();
        var $helper = tr.clone();

        $helper.children().each(function (index) {
            $(this).width($originals.eq(index).width())
        });

        return $helper;
    };

    $(".table-sortable tbody").sortable({
        helper: fixHelperModified
    }).disableSelection();

    $(".table-sortable thead").disableSelection();



    $("#add_row").trigger("click");



});


function getModelo(name) {
    var x_modelo = $("select[name=" + name + "]").val();
    $.ajax({
        url: 'buscaModelo.php',
        method: 'POST',
        data: { cod_mod: x_modelo },
        dataType: 'json',
        success: (function (result) {
            switch (name) {
                case "cod0":
                    $("input[name='modelo0']").val(result);
                    break;
                case "cod1":
                    $("input[name='modelo1']").val(result);
                    break;
                case "cod2":
                    $("input[name='modelo2']").val(result);
                    break;
                case "cod3":
                    $("input[name='modelo3']").val(result);
                    break;
                case "cod4":
                    $("input[name='modelo4']").val(result);
                    break;
                case "cod5":
                    $("input[name='modelo5']").val(result);
                    break;
                case "cod6":
                    $("input[name='modelo6']").val(result);
                    break;
                case "cod7":
                    $("input[name='modelo7']").val(result);
                    break;
                case "cod8":
                    $("input[name='modelo8']").val(result);
                    break;
                case "cod9":
                    $("input[name='modelo9']").val(result);
                    break;
                case "cod10":
                    $("input[name='modelo10']").val(result);
                    break;
                case "cod11":
                    $("input[name='modelo11']").val(result);
                    break;
                case "cod12":
                    $("input[name='modelo12']").val(result);
                    break;
                case "cod13":
                    $("input[name='modelo13']").val(result);
                    break;
                case "cod14":
                    $("input[name='modelo14']").val(result);
                    break;
                case "cod15":
                    $("input[name='modelo15']").val(result);
                    break;
            }
        })
    })
}


/* function SomenteNumeros()
{
  var tecla = window.event.keyCode;
  tecla     = String.fromCharCode(tecla);
  if(!((tecla >= "0") && (tecla <= "9")))
  {
    window.event.keyCode = 0;
  }
}

document.getElementById("NF").onkeypress = function(e) {
    var chr = String.fromCharCode(e.which);
    if ("1234567890".indexOf(chr) < 0)
      return false;
  }; */

function calculaTotal() {
    var total = 0
    //total = parseInt($("input[name='quant0']").val()) + parseInt($("input[name='quant1']").val())
    for (i = 0; i < 15; i++) {
        if (($("input[name='quant" + i + "']").val() != "") && ($("input[name='quant" + i + "']").val() != null)) {
            total = total + parseInt($("input[name='quant" + i + "']").val())
        }
    }
    $("#total").html(total)

}
