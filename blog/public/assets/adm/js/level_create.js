$(function () {

    var name = $('#input-name').val(),
        score = $('#input-score').val();


    $('#input-score').keyup(function(){
        $(this).val($(this).val().replace(/[^0-9]/g, ''))
    });

    $('#levelCreate').submit(function (event) {
        event.preventDefault();
        $('.now_loading').show();

        if (score.length < 0) {
            var data = {error: ['Preencha a pontuação']};
            alert_box(data);
        } else {
            var form = document.getElementById('levelCreate')
            var data = new FormData(form);

            $.ajax({
                url: 'ws/level/save',
                data: data,
                processData: false,
                type: 'POST',
                contentType: false,
                beforeSend: function (x) {
                    if (x && x.overrideMimeType) {
                        x.overrideMimeType("multipart/form-data");
                    }
                },
                mimeType: 'multipart/form-data',
                success: function (response, textStatus) {
                    var data = $.parseJSON(response);

                    if (data.error) {
                        $('.now_loading').hide();
                        alert_box(data);
                    } else {
                        localMsg(data);
                        window.location = 'adm/level/'
                    }
                }
            });
        }
    });
});
