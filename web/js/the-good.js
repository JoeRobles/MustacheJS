$(document).on("ready", function(){
    $.getJSON("api/versions/json", function(versions){
        $.get('js/templates/options.html', function(template){
            var mustache = $.mustache(template, versions);
            $("select#server_versions").append(mustache);
        });
    });
    $("select#server_versions").on("change", function(){
        $("div#urls").html("");
        $.getJSON("api/type/" + $(this).val() + "/json", function(types){
            var option = $('<option />').attr("value", "").text("Please select");
            var select_types = $("select#types");
            select_types.html("").append(option);
            $.get('js/templates/options.html', function(template){
                var mustache = $.mustache(template, types);
                select_types.append(mustache);
            });
        });
    });
    $("select#types").on("change", function(){
        $.getJSON("api/urls/" + $("select#server_versions").val() + "/" + $(this).val() + "/json", function(urls){
            $.get('js/templates/table.html', function(template){
                var mustache = $.mustache(template, urls);
                $("div#urls").html("").append(mustache);
            });
        });
    });
});