$('#menuAdm').addClass('active lead')

$(document).ready(function () {
    $("#btn_excel").on("click", function() {
        de = $("#de").val()
        ate = $("#ate").val()
        window.location.href = "geraExcelAdm.php?de="+de+"&ate="+ate
    })
})
