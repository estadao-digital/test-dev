$(function () {

    $('#input-score').keyup(function(){
        $(this).val($(this).val().replace(/[^0-9]/g, ''))
    });

    var idLevel = extract_url('last');

    $.get('ws/level/get',
        function (data) {
            for (i in data) {
                if (data[i].id === idLevel) {
                    $('#input-name').val(data[i].name);
                    $('#input-score').val(data[i].score);
                    if(data[i].score == 0){
                        $('#input-score').prop("disabled", true);
                        $('#input-score').prop("title", 'Impossível editar pontuação, este é um nível padrão do sistema');
                    }
                }
            }
        });

    $('.btn-send').click(function (event) {
        event.preventDefault();
        $('.now_loading').show();

        var name_level = $('#input-name').val();
        var score_level = $('#input-score').val();

        if (score_level.length <= 0) {
            var data = {error: ['Preencha a pontuação']};
            alert_box(data);
        } else {
            var form = document.getElementById('levelCreate')
            var data = new FormData(form);
            data.append('id', idLevel);
            data.append('score', ' ' + score_level + ' ');

            $.ajax({
                url: 'ws/level/update',
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
                success: function(response, textStatus) {
                    var data = $.parseJSON(response);

                    if (data.error){
                        alert_box(data);
                        $('.now_loading').hide();
                    } else {
                        localMsg(data);
                        window.location = 'adm/level/'
                    }

                }
            });
        }


    });
});

