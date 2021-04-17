$(document).ready(function () {

    $(".alert").hide() //ESCONDE ALERTAS



    if (window.location.href.indexOf("falhalogin") > -1) {

        $("#alertalogin").fadeTo(4000, 500).slideUp(500, function () {

            $(".alert").slideUp(1000);

        });

    }

})



