document.title = "SGR - USUÁRIOS"

$('#menuAdm').addClass('active lead')

$(document).ready(function () {
    $(".alert").hide() //ESCONDE ALERTAS

    radioAtivos();

    $("#incluirUsuario").click(function () {
        $('#modalIncluiUsuario').modal('show')
        $("#selectNivel").val("Nível de acesso")
        $("#inputMat").val("")
        $("#inputNome").val("")
        $("#inputPass").val("")
    })

    //$("#radioAtivos").on("click", radioAtivos)
    $("#radioAtivos").click(radioAtivos)

    $("#radioInativos").click(radioInativos)

    $("#btnCadastrar").click(function () {
        //alert ($("#selectNivel").val())
        if (($("#inputMat").val() != "") && ($("#inputNome").val() != "") && ($("#selectNivel").val() != null) && ($("#inputPass").val() != "")) {
            $.ajax({
                url: 'busca_adm.php',
                method: 'POST',
                data: { matricula: $("#inputMat").val(), nome: $("#inputNome").val(), nivel: $("#selectNivel").val(), pass: $("#inputPass").val(), acao: "cadastraUsuario" },
                dataType: 'json',
                beforeSend: function () {
                    $("#load").show();
                    $('#ModalIncluiUsuario .modal-title').html('AGUARDE... ⏳ ')
                }
            }).done(function (result) {
                $("#load").hide();
                if (result == "ok") {
                    $('#ModalIncluiUsuario .modal-title').html('USUÁRIO CADASTRADO! ✔️');

                    $("#inputMat").focus()
                    $("#selectNivel").val("Nível de acesso")
                    $("#inputMat").val("")
                    $("#inputNome").val("")
                    $("#inputPass").val("")
                    radioAtivos();
                    setTimeout(function () {
                        $('#modalIncluiUsuario').modal('hide')
                        $('#ModalIncluiUsuario .modal-title').html('Cadastro de usuário');
                    }, 2000);
                    //$('#modalIncluiUsuario').modal('hide')
                } else {
                    alert("MATRÍCULA INFORMADA JÁ EXISTE!")
                    $('#ModalIncluiUsuario .modal-title').html('Cadastro de usuário');
                    $("#inputMat").focus()
                }
            })
        }


    })


    /* $("#btnAlterarSenha").click(function () {
        alert ("testesaedfa")
        
    }) */



    /*     $('#ModalIncluiUsuario').on('shown.bs.modal', function (e) {
            $("#inputMat").focus()
        })
    
        $('#ModalIncluiUsuario').on('hidden.bs.modal', function (e) {
            $("#selectNivel").val("Nível de acesso")
            $("#inputMat").val("")
            $("#inputNome").val("")
            $("#inputPass").val("")
        }) */
})


function radioAtivos() {
    document.querySelectorAll('td').forEach(option => option.remove())
    $.ajax({
        url: 'busca_adm.php',
        method: 'POST',
        data: { acao: "usuariosAtivos" },
        dataType: 'json',
        beforeSend: function () {
            $("#load").show();
        }
    }).done(function (result) {
        i = 0
        while (i < result['matricula'].length) {
            //Evita que o usuário corrente seja listado
            if ($("#user").html().trim() == result['name'][i].trim()){
                i++
            }
            //////////////
            $('#body').append('<tr>')
            $('#body').append('<td id="mat' + i + '">' + result['matricula'][i] + '</td>');
            $('#body').append('<td id="nome' + i + '">' + result['name'][i] + '</td>');
            $('#body').append('<td>' + result['nivel'][i] + '</td>');
            $('#body').append('<td> <div class="btn-group btn-group-toggle" data-toggle="buttons">' +
                '<label class="btn btn-outline-primary btn-sm active" id="' + i + '" onclick="ativar(id)">' +
                '<input type="radio" id="optAtivo"> Ativo' +
                '</label>' +
                '<label class="btn btn-outline-danger btn-sm" id="' + i + '" onclick="inativar(id)">' +
                '<input type="radio" id="optInativo"> Inativo' +
                '</label>  </div>   </td>' +
                '<td><button id="alterarSenha-' + i + '" class="btn btn-sm btn-outline-primary" type="button" onclick="alteraSenha(id)">Alterar Senha</button></td>' +
                '</tr')
            i++;
        }

        $("#load").hide();
    })
};

function radioInativos() {
    document.querySelectorAll('td').forEach(option => option.remove())
    $.ajax({
        url: 'busca_adm.php',
        method: 'POST',
        data: { acao: "usuariosInativos" },
        dataType: 'json',
        beforeSend: function () {
            $("#load").show();
        }
    }).done(function (result) {
        i = 0
        while (i < result['matricula'].length) {
            $('#body').append('<tr>')
            $('#body').append('<td id="mat' + i + '">' + result['matricula'][i] + '</td>');
            $('#body').append('<td id="nome' + i + '">' + result['name'][i] + '</td>');
            $('#body').append('<td>' + result['nivel'][i] + '</td>');
            $('#body').append('<td> <div class="btn-group btn-group-toggle" data-toggle="buttons">' +
                '<label class="btn btn-outline-primary btn-sm" id="' + i + '" onclick="ativar(id)">' +
                '<input type="radio"> Ativo' +
                '</label>' +
                '<label class="btn btn-outline-danger btn-sm active" id="' + i + '" onclick="inativar(id)">' +
                '<input type="radio"> Inativo' +
                '</label>  </div>   </td>' +
                '<td><button id="alterarSenha-' + i + '" class="btn btn-sm btn-outline-primary" type="button" onclick="alteraSenha(id)">Alterar Senha</button></td>' +
                '</tr')
            i++;
        }

        $("#load").hide();
    })
};



function ativar(id) {
    matricula = $("#mat" + id).html()
    $.ajax({
        url: 'busca_adm.php',
        method: 'POST',
        data: { matricula, acao: "ativarUsuario" },
        dataType: 'json',
        beforeSend: function () {
            $("#load").show();
        }
    }).always(function () {
        $("#load").hide();

    })
}

function inativar(id) {
    matricula = $("#mat" + id).html()
    $.ajax({
        url: 'busca_adm.php',
        method: 'POST',
        data: { matricula, acao: "inativarUsuario" },
        dataType: 'json',
        beforeSend: function () {
            $("#load").show();
        }
    }).always(function () {
        $("#load").hide();

    })
}

function alteraSenha(id) {
    newId = id.substring(id.indexOf("-") + 1);

    matricula = $("#mat" + newId).html()
    nome = $("#nome" + newId).html()

    $('#modalAlteraSenha').modal('show')
    $('#ModalAlteraSenha .modal-title').html('Alterar senha de ' + nome);


    $("#btnAlterarSenha").click(function () {
        if ($("#newpass").val() != "") {
            $('#ModalAlteraSenha .modal-title').html('AGUARDE... ⏳ ')
            $.ajax({
                url: 'busca_adm.php',
                method: 'POST',
                data: { matricula, newpass: $("#newpass").val(), acao: "alteraSenha" },
                dataType: 'json',
                beforeSend: function () {
                    $("#load").show();
                }
            }).always(function () {
                $('#ModalAlteraSenha .modal-title').html('SENHA ALTERADA! ✔️');
                setTimeout(function () {
                    $('#ModalAlteraSenha').modal('hide')
                    $('#ModalAlteraSenha .modal-title').html('');
                    $("#newpass").val("")
                    $('#modalAlteraSenha').modal('hide')
                }, 2000);
                $("#load").hide();

            })

        } else {
            $("#newpass").focus()
        }
    })
}