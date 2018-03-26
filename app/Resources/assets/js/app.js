$(function () {


    (function ($) {
        $.fn.serializeFormJSON = function () {

            var o = {};
            var a = this.serializeArray();
            $.each(a, function () {
                if (o[this.name]) {
                    if (!o[this.name].push) {
                        o[this.name] = [o[this.name]];
                    }
                    o[this.name].push(this.value || '');
                } else {
                    o[this.name] = this.value || '';
                }
            });
            return o;
        };
    })(jQuery);


    $("#txtNan").on("blur", function () {

        //44152950 Ruth

        var url = "http://172.28.64.70:3000/nan/" + $(this).val();

        var myPromise = $.getJSON(url);

        myPromise.done(function ( data ) {

            console.log(data[0]["NUMERO FIJO"]);

            $("#txtBizilekuZenbakia").text(data[0]["NUMERO FIJO"]);
        });

        myPromise.fail(function ( jqXHR, textStatus, errorThrown ) {
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
                    label: "<i class=\"fa fa-times\"></i> Ezeztatu"
                },
                confirm: {
                    label: "<i class=\"fa fa-check\"></i> Onartu"
                }
            },
            callback: function ( result ) {
                if ( result === true ) {
                    $("#frmEzabatuArreta").submit();
                }
            }
        });
    });

    $("#btnArretaSave").on("click", function () {
        $("#frmArretaEdit").submit();
    });

    $("#btnArretaClose").on("click", function () {
        $("#appbundle_arreta_isclosed").prop("checked", true);
        $("#frmArretaEdit").submit();
    });

    $("#cmdZerbikat").on("click", function () {
        $("#appbundle_tramite_mota").find("option").filter(function () {
            return $(this).html() === "Zerbikat";
        }).prop("selected", true);
    });

    $("#cmdGerkud").on("click", function () {
        $("#appbundle_tramite_mota").find("option").filter(function () {
            return $(this).html() === "Gerkud";
        }).prop("selected", true);
    });

    $("#cmdInformacion").on("click", function () {
        $("#appbundle_tramite_mota").find("option").filter(function () {
            return $(this).html() === "Informazioa";
        }).prop("selected", true);
    });

    /*****************************************************************************************************************/
    /*** Tab Change **************************************************************************************************/
    /*****************************************************************************************************************/
    $("a[data-toggle=\"tab\"]").on("shown.bs.tab", function ( e ) {
        if ( e.relatedTarget.hash === "#datuak" ) {

            var frm = "#frmArretaEdit";
            $.ajax({
                type: $(frm).attr("method"),
                url: $(frm).attr("action"),
                data: $(frm).serialize()
            })
             .done(function ( data ) {
                 // $("#alertSpot").html("<div class=\"alert alert-success nirealert\">\n" +
                 //     "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span\n" +
                 //     "                                        aria-hidden=\"true\">&times;</span></button>" +
                 //     "<p>Datuak ongi grabatu dira.</p>" +
                 //     "</div>");
                 // $("#alertSpot").show("slow").delay(3000).fadeOut("slow");
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
                 console.log(jqXHR);
                 console.log(textStatus);
                 console.log(errorThrown);

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

        var url = "http://zerbikat.sare.gipuzkoa.net/api/sailak/064.json";
        var selId = this.value;

        $.getJSON(url, function ( data ) {
            $.each(data, function ( key, val ) {
                console.log(selId);
                console.log(val.id);
                if ( parseInt(val.id) === parseInt(selId) ) {
                    $.each(val.azpisailak, function ( k, v ) {
                        if ( $("#txtLocale").val() === "eu" ) {
                            $("#cmbAzpiFamilia").append("<option value='" + v.id + "'>" + v.azpisailaeu + "</option>");
                        } else {
                            $("#cmbAzpiFamilia").append("<option value='" + v.id + "'>" + v.azpisailaes + "</option>");
                        }
                    });
                }
            });
        }).fail(function ( jqXHR, textStatus, errorThrown ) {
            console.log("error " + textStatus);
            console.log("incoming Text " + jqXHR.responseText);
        });
    });

    $(document).on("change", "#cmbAzpiFamilia", function () {



        $("#cmbFitxa").empty();

        var url = "http://zerbikat.test/app_dev.php/api/azpisailenfitxak/" + this.value + ".json";
        $.getJSON(url, function ( data ) {
            $.each(data, function ( key, val ) {
                if ( $("#txtLocale").val() === "eu" ) {
                    $("#cmbFitxa").append("<option data-zerbikatid='" + val.id +"' value='" + val.espedientekodea + "'>" + val.espedientekodea + " - " + val.deskribapenaeu + "</option>");
                } else {
                    $("#cmbFitxa").append("<option data-zerbikatid='" + val.id +"' value='" + val.espedientekodea + "'>" + val.espedientekodea + " - " + val.deskribapenaes + "</option>");
                }
            });
        }).fail(function ( jqXHR, textStatus, errorThrown ) {
            console.log("error " + textStatus);
            console.log("incoming Text " + jqXHR.responseText);
        });

    });

    $("#btn-modal-gorde").on("click", function () {
        var zerbikatid = $("#cmbFitxa").find(":selected").data("zerbikatid");
        console.log(zerbikatid);
        $("#appbundle_tramite_kodea").val($("#cmbFitxa").val());
        $("#appbundle_tramite_name").val($("#appbundle_tramite_mota option:selected").text());
        $("#appbundle_tramite_zerbikatid").val(zerbikatid);
        $("#modal-zerbikat").modal("hide");

        // console.log(zerbikatid);
        var frm = "#frmTramiteNew";
        // var d = $(frm).serialize();
        // console.log(d);
        // console.log(zerbikatid);
        $.ajax({
            type: $(frm).attr("method"),
            url: $(frm).attr("action"),
            data: $(frm).serialize()
        })
         .done(function ( data ) {

             $("#alertSpot").html("<div class=\"alert alert-success nirealert\">\n" +
                 "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span\n" +
                 "                                        aria-hidden=\"true\">&times;</span></button>" +
                 "<p>Datuak ongi grabatu dira.</p>" +
                 "</div>");
             $("#alertSpot").delay(3000).fadeOut("slow");

             window.location.href += "#tramites";
             location.reload();

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
             console.log(jqXHR);
             console.log(textStatus);
             console.log(errorThrown);
         });

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

        var myData = $("#frmGerkud").serializeObject();


        var nireData = $("#frmGerkud").serializeFormJSON();


        var ss = {};

        ss.data = JSON.stringify(myData);
        ss.bertsioa = 2;



        var url = "http://gerkud/app.php/horkonpon/";
        var miAjax = $.ajax({
            type: "POST",
            url: url,
            data: ss
        }).done(function ( data ) {
            var myData = jQuery.parseJSON(data);
            if ( myData.status === -1 ) {
                alert(myData.message);
            } else {
                $("#appbundle_tramite_kodea").val(myData.code);
                $("#appbundle_tramite_name").val($("#appbundle_tramite_mota option:selected").text());
                $("#modal-zerbikat").modal("hide");
                $("#frmTramiteNew").submit();
            }

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

    function frmAjaxPost( tramiteId ) {
        var frm = "#frmTramiteEdit" + tramiteId;
        $.ajax({
            type: $(frm).attr("method"),
            url: $(frm).attr("action"),
            data: $(frm).serialize()
        })
         .done(function ( data ) {
             // $("#alertSpot").html("<div class=\"alert alert-success nirealert\">\n" +
             //     "<button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\"><span\n" +
             //     "                                        aria-hidden=\"true\">&times;</span></button>" +
             //     "<p>Datuak ongi grabatu dira.</p>" +
             //     "</div>");
             // $("#alertSpot").delay(3000).fadeOut("slow");
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

    $(".radioResult").on("change", function () {
        var valBerria = this.value;
        $("input[name='appbundle_tramite[result]'][value='" + valBerria + "']").prop("checked", true);

        var tramiteId = $(this).data("tramiteid");
        frmAjaxPost(tramiteId);

    });

    $("#btnInfoSave").on("click", function () {
        $("#appbundle_tramite_kodea").val("Info");
        $("#appbundle_tramite_name").val("Informazio eskaera");
        $("#appbundle_tramite_notes").val($("#infobox").val());
        $("#modal-info").modal("hide");
        $("#frmTramiteNew").submit();
    });

    $(".btnTramiteEzabatu").on("click", function () {
        var $tramiteId = $(this).data("tramiteid");
        var url = Routing.generate('admin_tramite_delete', { id: $tramiteId });
        var mitr = $(this).closest("tr");
        bootbox.confirm({
            title: "Ezbatu",
            message: "Ziur zaude ezabatu nahi duzula?",
            buttons: {
                cancel: {
                    label: '<i class="fa fa-times"></i> Ezeztatu'
                },
                confirm: {
                    label: '<i class="fa fa-check"></i> Onartu'
                }
            },
            callback: function (result) {
                if (result === true) {
                    $.ajax({
                        url: url,
                        type: 'delete',
                        success: function(result) {
                            $(mitr).remove();
                        },
                        error: function(e){
                            console.log(e.responseText);
                        }
                    });
                }
            }
        });
    });
    /*****************************************************************************************************************/
    /*** FIN Tramite tab *********************************************************************************************/
    /*****************************************************************************************************************/

    /*****************************************************************************************************************/
    /*** Index Arreta ** *********************************************************************************************/
    /*****************************************************************************************************************/
    $('#divDateRange .input-daterange').datepicker({
        weekStart: 1,
        todayBtn: "linked",
        language: "eu",
        autoclose: true,
        todayHighlight: true
    });

    /*****************************************************************************************************************/
    /*** FIN Index Arreta ********************************************************************************************/
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