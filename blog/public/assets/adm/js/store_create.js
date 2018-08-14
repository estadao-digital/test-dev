$(function () {

    groupstore();

    $('.btn-send').click(function (event) {
        event.preventDefault();

        var name = $('#input-name').val(),
            img = $('#input-img').val(),
            price = $('#input-price').val();

        if (name.length === 0) {
            $('#input-title').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo título está vazio</div>')
        }
        else {

            var form = document.getElementById('storeCreate');
            var data = new FormData(form);

            $.ajax({
                url: 'ws/store/save',
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
                        alert_box(data)
                    } else {
                        localMsg(data);
                        window.location = 'adm/store/'
                    }



                }
            });
        }
        return false;
    });
});

function groupstore() {

    var $select = $('#groupstore');
    var outputSelect = '';

    if ($select.length != 0) {

        $.post('ws/group/get', function (data) {

            for (i in data) {
                outputSelect += fill_template($select, data[i]);
            }

            $select.html(outputSelect);

            $select.chosen({
                no_results_text: "Oops, grupo não encontrado!"
            });
        });
    }
}