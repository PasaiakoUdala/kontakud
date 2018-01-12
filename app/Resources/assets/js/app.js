$(function () {

    $("#txtNan").on("blur", function () {

        //44152950 Ruth

        var url = "http://172.28.64.70:3000/nan/" + $(this).val();

        var myPromise = $.getJSON(url);

        myPromise.done(function ( data ) {

            console.log(data[0]["NUMERO FIJO"]);

            $("#txtBizilekuZenbakia").text(data[0]["NUMERO FIJO"]);
        });

        myPromise.fail(function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR.responseText);
            console.log("Akats bat egon da datuak eskuratzerakoan.");
        });

    });

});