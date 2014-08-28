$(document).on("ready", function(){
    $("select#server_versions").html("").load("api/versions");
    $("select#server_versions").on("change", function(){
        $("div#urls").html("");
        $("select#types").html("").load("api/type/" + $(this).val());
    });
    $("select#types").on("change", function(){
        $("div#urls").load("api/urls/" + $("select#server_versions").val() + "/" + $(this).val());
    });
});