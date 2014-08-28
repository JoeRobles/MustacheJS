$(document).on("ready", function(){
    $.getJSON("api/versions/list", function(versions){
        $.each(versions, function(key, version) {
            var option = $('<option />').attr("value", version).text(version);
            $("select#server_versions").append(option);
        });
    });
    $("select#server_versions").on("change", function(){
        $("div#urls").html("");
        $.getJSON("api/type/" + $(this).val() + "/list", function(types){
            var option = $('<option />').attr("value", "").text("Please select");
            var select_types = $("select#types");
            select_types.html("").append(option);
            $.each(types, function(key, type){
                option = $('<option />').attr("value", type).text(type);
                select_types.append(option);
            });
        });
    });
    $("select#types").on("change", function(){
        $.getJSON("api/urls/" + $("select#server_versions").val() + "/" + $(this).val() + "/list", function(urls){
            var tbody = $('<tbody />');
            $.each(urls, function(key, url){
                var tr = $('<tr />');
                var td_type = $('<td />').text(url[0]);
                var td_url = $('<td />').text(url[1]);
                tbody.append(
                    tr.append(
                        td_type,
                        td_url
                    )
                );
            });
            var div = $('<div />').addClass("table-responsive");
            var table = $('<table />').addClass("table table-bordered table-striped table-condensed table-hover").attr("id", "table");
            var thead = $('<thead />');
            var tr = $('<tr />');
            var th_type = $('<th />').text("Type");
            var th_url = $('<th />').text("URL");
            $("div#urls").html("").append(
                div.append(
                    table.append(
                        thead.append(
                            tr.append(
                                th_type,
                                th_url
                            )
                        ),
                        tbody
                    )
                )
            );
        });
    });
});