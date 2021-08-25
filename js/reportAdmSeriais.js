$('#menuAdm').addClass('active lead')

$(document).ready(function () {
    $("#btn_excel").on("click", function () {
        //$("#load").show();
        $("#de").removeClass("is-invalid")
        $("#ate").removeClass("is-invalid")

        if ($("#de").val() == "")
            $("#de").addClass("is-invalid")
        if ($("#ate").val() == "")
            $("#ate").addClass("is-invalid")

        if (($("#de").val() != "") && ($("#ate").val() != "")) {
            $("#de").removeClass("is-invalid")
            $("#ate").removeClass("is-invalid")

            de = $("#de").val()
            ate = $("#ate").val()
            window.location.href = "geraExcelAdm.php?de=" + de + "&ate=" + ate
        }
    })
})
