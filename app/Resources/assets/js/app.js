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

    $("#btnArretaEzabatu").on("click", function () {
        bootbox.confirm({
            title: "Ziur zaude?",
            message: "Ziur zaude abian dagoen tramitea ezabatu nahi duzula?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Ezeztatu'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Onartu'
                }
            },
            callback: function (result) {
                if ( result === true ) {
                    $("#frmEzabatuArreta").submit();
                }
            }
        });
    });

    $("#btnArretaGorde").on("click", function () {
        $("#appbundle_arreta_isclosed").prop("checked", true);
        $("#frmArretaEdit").submit();
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
    /*** Tab Change **************************************************************************************************/
    /*****************************************************************************************************************/
    $("a[data-toggle=\"tab\"]").on("shown.bs.tab", function ( e ) {
        if ( e.relatedTarget.hash === "#datuak") {

            var frm = "#frmArretaEdit";
            $.ajax({
                type: $(frm).attr("method"),
                url: $(frm).attr("action"),
                data: $(frm).serialize()
            })
             .done(function ( data ) {
                 if ( typeof data.message !== "undefined" ) {
                     $("#alertSpot").html("<div class=\"alert alert-success\">\n" +
                         "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span\n" +
                         "                                        aria-hidden=\"true\">&times;</span></button>" +
                         "<p>Ongi grabatu da.</p>" +
                         "</div>");
                     $('#alertSpot').delay(3000).fadeOut('slow');
                 }
             })
             .fail(function ( jqXHR, textStatus, errorThrown ) {
                 if ( typeof jqXHR.responseJSON !== "undefined" ) {
                     if ( jqXHR.responseJSON.hasOwnProperty("form") ) {
                         $("#form_body").html(jqXHR.responseJSON.form);
                     }

                     $(".form_error").html(jqXHR.responseJSON.message);

                 } else {
                     alert(errorThrown);
                 }

             });

        }
        // e.target; // newly activated tab
        // console.log(e);
        // console.log(e.target);
        // e.relatedTarget; // previous active tab
        // console.log(e.relatedTarget);
    });
    /*****************************************************************************************************************/
    /*** End Tab Change **********************************************************************************************/
    /*****************************************************************************************************************/

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

    $("#btn-modal-gorde").on("click", function () {
        $('#appbundle_tramite_kodea').val($("#cmbFitxa").val());
        $("#appbundle_tramite_name").val($("#appbundle_tramite_mota option:selected").text());
        $("#modal-zerbikat").modal("hide");
        $('#frmTramiteNew').submit();
    });
    /*****************************************************************************************************************/
    /*** FIN Zerbikat Select-ak **************************************************************************************/
    /*****************************************************************************************************************/

    /*****************************************************************************************************************/
    /**** Tramite tab ************************************************************************************************/
    /*****************************************************************************************************************/
    var fetxa = new Date();
    $.fn.datepicker.defaults.format = "mm/dd/yyyy";
    $("#txtGerkudFetxa").datepicker({
        language: "eu",
        todayHighlight: true,
        setDate: fetxa,
        "autoclose": true
    });

    $("#btnGerkudSave").click(function () {

        if ( $('#txtGerkudFetxa') )

            var myData = $("#frmGerkud").serializeObject();

        var url = "http://kexak.pasaia.net/app.php/horkonpon/";
        var miAjax = $.ajax({
            type: "POST",
            url: url,
            data: myData
        }).done(function ( data ) {
            console.log(data);
            var myData = jQuery.parseJSON(data);
            $('#appbundle_tramite_kodea').val(data.code);
            $("#appbundle_tramite_name").val($("#appbundle_tramite_mota option:selected").text() + " - " + myData.code);
            $("#modal-zerbikat").modal("hide");
            $('#frmTramiteNew').submit();

        }).fail(function ( XMLHttpRequest, textStatus, errorThrown ) {
            console.log("ERROR");
            console.log(XMLHttpRequest);
            console.log(textStatus);
            alert(textStatus);
            console.log(errorThrown);
            console.log("ERROR");
        });
    });

    $(".btnAjaxTramite").on("click", function ( e ) {
        e.preventDefault();
        var tramiteId = $(this).data("tramiteid");
        frmAjaxPost(tramiteId);
    });

    function frmAjaxPost( tramiteId  ) {
        var url = Routing.generate("admin_tramite_edit", { id: tramiteId });
        var frm = "#frmTramiteEdit" + tramiteId;
        $.ajax({
            type: $(frm).attr("method"),
            url: $(frm).attr("action"),
            data: $(frm).serialize()
        })
         .done(function ( data ) {
             if ( typeof data.message !== "undefined" ) {
                 $("#alertSpot").html("<div class=\"alert alert-success\">\n" +
                     "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span\n" +
                     "                                        aria-hidden=\"true\">&times;</span></button>" +
                     "<p>Ongi grabatu da.</p>" +
                     "</div>");
                 $('#alertSpot').delay(3000).fadeOut('slow');
             }
         })
         .fail(function ( jqXHR, textStatus, errorThrown ) {
             if ( typeof jqXHR.responseJSON !== "undefined" ) {
                 if ( jqXHR.responseJSON.hasOwnProperty("form") ) {
                     $("#form_body").html(jqXHR.responseJSON.form);
                 }

                 $(".form_error").html(jqXHR.responseJSON.message);

             } else {
                 alert(errorThrown);
             }

         });
    }

    $(".radioResult").on('change', function() {
        var valBerria = this.value;
        $("input[name='appbundle_tramite[result]'][value='"+valBerria+"']").prop('checked',true);

        var tramiteId = $(this).data("tramiteid");
        frmAjaxPost(tramiteId)

    });
    /*****************************************************************************************************************/
    /*** FIN Tramite tab *********************************************************************************************/
    /*****************************************************************************************************************/

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