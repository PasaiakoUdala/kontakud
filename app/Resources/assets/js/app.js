$(function () {

    $("#btn-modal-gorde").on("click", function () {
        $('#appbundle_tramite_zerbikatkodea').val($("#cmbFitxa").val());
        $("#appbundle_tramite_name").val($("#appbundle_tramite_mota option:selected").text() + " - " + $("#cmbFitxa").val());
        $("#modal-zerbikat").modal("hide");
        // $('#frmTramiteNew').submit();
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


    $.fn.datepicker.defaults.format = "mm/dd/yyyy";
    $("#txtGerkudFetxa").datepicker({
        language: "eu"
    });

    $("#btnGerkudSave").click(function () {
        var myData = $("#frmGerkud").serializeObject();

        var url = "http://kexak.pasaia.net/app.php/horkonpon/";
        var miAjax = $.ajax({
            type: "POST",
            url: url,
            data: myData
        }).done(function ( data ) {
            console.log(data);
            var myData = jQuery.parseJSON(data);
            console.log(myData.code);
            console.log();
        }).fail(function ( XMLHttpRequest, textStatus, errorThrown ) {
            console.log("ERROR");
            console.log(XMLHttpRequest);
            console.log(textStatus);
            alert(textStatus);
            console.log(errorThrown);
            console.log("ERROR");
        });
    });


});

(function ( $ ) {
    $.fn.serializeObject = function () {

        var self = this,
            json = {},
            push_counters = {},
            patterns = {
                "validate": /^[a-zA-Z][a-zA-Z0-9_]*(?:\[(?:\d*|[a-zA-Z0-9_]+)\])*$/,
                "key": /[a-zA-Z0-9_]+|(?=\[\])/g,
                "push": /^$/,
                "fixed": /^\d+$/,
                "named": /^[a-zA-Z0-9_]+$/
            };


        this.build = function ( base, key, value ) {
            base[key] = value;
            return base;
        };

        this.push_counter = function ( key ) {
            if ( push_counters[key] === undefined ) {
                push_counters[key] = 0;
            }
            return push_counters[key]++;
        };

        $.each($(this).serializeArray(), function () {

            // skip invalid keys
            if ( !patterns.validate.test(this.name) ) {
                return;
            }

            var k,
                keys = this.name.match(patterns.key),
                merge = this.value,
                reverse_key = this.name;

            while ( (k = keys.pop()) !== undefined ) {

                // adjust reverse_key
                reverse_key = reverse_key.replace(new RegExp("\\[" + k + "\\]$"), "");

                // push
                if ( k.match(patterns.push) ) {
                    merge = self.build([], self.push_counter(reverse_key), merge);
                }

                // fixed
                else if ( k.match(patterns.fixed) ) {
                    merge = self.build([], k, merge);
                }

                // named
                else if ( k.match(patterns.named) ) {
                    merge = self.build({}, k, merge);
                }
            }

            json = $.extend(true, json, merge);
        });

        return json;
    };
})(jQuery);