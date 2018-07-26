function RemplirtableauAjax(token, type) {

    $("#subView").html('Chargement... ');
    
    $.ajax({
        type: "POST",
        url: "/"+type+"/"+token+"/info",
        success: function(msg) {
           $("#subView").html(msg);
           $("#subView").show();
        }
    });
}
