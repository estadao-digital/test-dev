$(document).ready(function(){
    $('.scaleAccept').click(function () {
        $.post("./scales/details",
            {
                scale_id: $(this).attr('scale'),
                user_id: $(this).attr('user'),
                date: $(this).attr('date'),
                option_date: $(this).attr('option_date')
            },
            function(data, status){
                var json = JSON.parse(data);
                $("#change").attr("scale_id", json.scale_id);
                var scale = json.scaleDay;
                var myscale = json.myScale;
                var htmlScale = "";
                var htmlMyScale = "";
                scale.forEach(function(entry) {
                    htmlScale += entry.start + " - " + entry.stop + " - " + entry.exception + "<br>"
                });
                myscale.forEach(function(entry) {
                    htmlMyScale += entry.start + " - " + entry.stop + " - " + entry.exception + "<br>"
                });
                $('.modal-title').html('Troca de escala - '+json.date);
                $('#scaleContent').html("<div class='row'>" +
                    "<div class='col-md-6'> Escala Ofertada "+json.scaleDaydate+"<br>" + htmlScale +
                    "</div><div class='col-md-6'>Sua Escala "+json.myScaledate+"<br>" + htmlMyScale +
                    "</div>" +
                    "</div>");
            })
    });
    $("#change").click(function () {
        $.post("./scales/acceptchange",
            {
                scale_id: $(this).attr('scale_id')
            },
            function(data, status){
                location.reload();
            });
    });
});