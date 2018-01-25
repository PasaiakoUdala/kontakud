$(function () {

    $("#btn-modal-gorde").on("click", function () {
        $('#appbundle_tramite_zerbikatkodea').val($("#cmbFitxa").val());
        $("#appbundle_tramite_name").val($("#appbundle_tramite_mota option:selected").text() + " - " + $("#cmbFitxa").val());
        $("#modal-zerbikat").modal("hide");
        $('#frmTramiteNew').submit();
    });

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

    $("#cmdZerbikat").on("click", function () {
        $('#appbundle_tramite_mota').find('option').filter(function () {
            return $(this).html() === "Zerbikat";
        }).prop('selected', true)
    });

    $("#cmdGerkud").on("click", function () {
        $('#appbundle_tramite_mota').find('option').filter(function () {
            return $(this).html() === "Gerkud";
        }).prop('selected', true)
    });

    $("#cmdInformacion").on("click", function () {
        $('#appbundle_tramite_mota').find('option').filter(function () {
            return $(this).html() === "Informazioa";
        }).prop('selected', true)
    });


    /*****************************************************************************************************************/
    /*** Zerbikat Select-ak ******************************************************************************************/
    /*****************************************************************************************************************/
    var url = "http://zerbikat.sare.gipuzkoa.net/api/familiaks/064.json";
    $.getJSON(url, function( data ) {
        $.each( data, function( key, val ) {
            if (!("parent" in val)) {
                if ( $('#txtLocale').val() === "eu" ) {
                    $('#cmbFamilia').append("<option value='" + val.id + "'>" + val.familiaeu + "</option>");
                } else {
                    $('#cmbFamilia').append("<option value='" + val.id + "'>" + val.familiaes + "</option>");
                }
            }
        });
    }).fail(function(jqXHR, textStatus, errorThrown) {
        console.log("error " + textStatus);
        console.log("incoming Text " + jqXHR.responseText);

    });


    $(document).on("change", "#cmbFamilia", function () {

        $("#cmbFitxa").empty();
        $("#cmbAzpiFamilia").empty();


        var url = "http://zerbikat.sare.gipuzkoa.net/api/azpifamiliaks/"+ this.value + ".json";
        // var url = "http://zerbikat.test/app_dev.php/api/azpifamiliaks/"+ this.value + ".json";
        $.getJSON(url, function( data ) {
            $.each( data, function( key, val ) {
                if ( $('#txtLocale').val() === "eu") {
                    $('#cmbAzpiFamilia').append( "<option value='" + val.id + "'>" + val.familiaeu + "</option>" );
                } else {
                    $('#cmbAzpiFamilia').append( "<option value='" + val.id + "'>" + val.familiaes + "</option>" );
                }
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("error " + textStatus);
            console.log("incoming Text " + jqXHR.responseText);
        });


        var url = "http://zerbikat.sare.gipuzkoa.net/api/fitxaks/"+ this.value + ".json";
        // var url = "http://zerbikat.test/app_dev.php/api/fitxaks/"+ this.value + ".json";
        $.getJSON(url, function( data ) {
            $.each( data, function( key, val ) {
                if ( $('#txtLocale').val() === "eu") {
                    $('#cmbFitxa').append( "<option value='" + val.espedientekodea + "'>" + val.espedientekodea + ' - ' + val.deskribapenaeu +"</option>" );
                } else {
                    $('#cmbFitxa').append( "<option value='" + val.espedientekodea + "'>" + val.espedientekodea + ' - ' + val.deskribapenaes + "</option>" );
                }
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("error " + textStatus);
            console.log("incoming Text " + jqXHR.responseText);
        });


    });

    $(document).on("change", "#cmbAzpiFamilia", function () {

        $("#cmbFitxa").empty();

        var url = "http://zerbikat.sare.gipuzkoa.net/api/fitxaks/"+ this.value + ".json";
        // var url = "http://zerbikat.test/app_dev.php/api/fitxaks/"+ this.value + ".json";
        $.getJSON(url, function( data ) {
            $.each( data, function( key, val ) {
                if ( $('#txtLocale').val() === "eu") {
                    $('#cmbFitxa').append( "<option value='" + val.espedientekodea + "'>" + val.espedientekodea + ' - ' + val.deskribapenaeu +"</option>" );
                } else {
                    $('#cmbFitxa').append( "<option value='" + val.espedientekodea + "'>" + val.espedientekodea + ' - ' + val.deskribapenaes + "</option>" );
                }
            });
        }).fail(function(jqXHR, textStatus, errorThrown) {
            console.log("error " + textStatus);
            console.log("incoming Text " + jqXHR.responseText);
        });

    });

});