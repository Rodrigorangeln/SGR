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
                url: 'busca_adm.php',
                method: 'POST',
                data: { s1: $("#1serial").val(), acao: "buscaSerial" },
                dataType: 'json',
                success: (function (result) {
                    if (result[0] != "Serial não encontrado") {
                        $("#2serial").val(result[0])
                        $("#modelo").val(result[1])
                        $("#cod_mod").val(result[2])

                        $("#btn-serial1").prop("disabled", false)
                        $("#btn-serial2").prop("disabled", false)
                        $("#btn-inverte-seriais").prop("disabled", false)

                    }
                    else {
                        $("#erroserial").fadeTo(2000, 500).slideUp(500, function () {
                            $(".alert").slideUp(1000);
                        })
                        limpa_campos()
                        $("#1serial").focus()
                        $("#1serial").val("")
                        $("#btn-serial1").prop("disabled", true)
                        $("#btn-serial2").prop("disabled", true)
                    }
                })
            })
        }
    })


    $("#btn-serial1").on("click", function () {
        $('#ModalAlteraSerial .modal-title').html('Alteração do serial <strong id="altSerial">' + $("#1serial").val() + '</strong>');
        $('#ModalAlteraSerial').modal('show')
    })

    $("#btn-serial2").on("click", function () {
        $('#ModalAlteraSerial .modal-title').html('Alteração do serial <strong id="altSerial">' + $("#2serial").val() + '</strong>');
        $('#ModalAlteraSerial').modal('show')
    })


    //Botão do MODAL
    $("#btn_alterar").on("click", function () {
        $("#btn_alterar").prop("disabled", true)
        $.ajax({
            url: 'busca_adm.php',
            method: 'POST',
            data: { newSerial: $("#new-serial").val(), acao: "verifica-duplicidade" },
            dataType: 'json',
        }).always(function (result) {
            if (result == 1) {
                $('#ModalAlteraSerial .modal-title').html('Alteração<strong> NÃO </strong>realizada');
                $('#ModalAlteraSerial .modal-body').html('Serial <strong style="color:red">' + $("#new-serial").val() + '</strong> já existe!');
            } else {
                $.ajax({
                    url: 'busca_adm.php',
                    method: 'POST',
                    data: { oldSerial: $("#altSerial").html(), newSerial: $("#new-serial").val(), acao: "alteraSerial" },
                    dataType: 'json',
                }).always(function () {
                    $('#ModalAlteraSerial .modal-body').html('<strong style="color:green">Serial alterado ! ✔️</strong>');
                    $('#ModalAlteraSerial').on('hidden.bs.modal', function (e) {
                        limpa_campos()
                    })
                })
            }
        })
    })


    $("#btn-inverte-seriais").on("click", function () {
        $('#ModalInverteSeriais').modal('show')
    })


    //Botão do MODAL
    $("#btn_conf_inversao").on("click", function () {
        $("#btn_conf_inversao").prop("disabled", true)
        $.ajax({
            url: 'busca_adm.php',
            method: 'POST',
            data: { s1: $("#1serial").val(), s2: $("#2serial").val(), acao: "inverteSeriais" },
            dataType: 'json',
        }).always(function () {
            $('#ModalInverteSeriais .modal-title').html('<strong style="color:green">Seriais invertidos ! ✔️</strong>');
            $('#ModalInverteSeriais').on('hidden.bs.modal', function (e) {
                limpa_campos()
            })
        })
    })


    ///////Ao fechar o Modal retorna o mesmo ao estado inicial
    $('#ModalAlteraSerial').on('hidden.bs.modal', function (e) {
        $("#btn_alterar").prop("disabled", false)
        $('#ModalAlteraSerial .modal-body').html('<input type="text" class="form-control" id="new-serial" maxlength="25" placeholder="Digite o novo serial" onkeyup="maiuscula(this)">');
    })

    $('#ModalAlteraSerial').on('shown.bs.modal', function (e) {
        $("#new-serial").focus()
    })

    $('#ModalInverteSeriais').on('hidden.bs.modal', function (e) {
        $("#btn_conf_inversao").prop("disabled", false)
        $('#ModalInverteSeriais .modal-title').html('Confirma inversão entre Serial 1 e Serial 2 ?');
    })
    ////////////////////////////////////////////////


})


function limpa_campos() {
    $("#1serial").val("")
    $("#2serial").val("")
    $("#cod_mod").val("")
    $("#modelo").val("")
    $("#btn-serial1").prop("disabled", true)
    $("#btn-serial2").prop("disabled", true)
    $("#btn-inverte-seriais").prop("disabled", true)
}






