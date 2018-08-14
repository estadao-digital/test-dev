$(function () {
    var idProduct = extract_url('last');

    $.ajax({
        url: 'ws/store/get/all',
    })
        .done(function(product) {
            product = product.store
            $.each( product, function(index, value ){
                if (value.id === idProduct)
                {
                    $('#input-name').val(value.name);
                    $('#input-price').val(value.price);
                    $('#input-stock').val(value.stock);
                    $('#preview').append('<label for="input-img"><img src="'+ value.img +'" class="img-thumbnail"></label>');

                    var category_id = [];

                    for (i in value.group) {
                        category_id[i] = value.group[i].group_id
                    }

                    groupstore(category_id);
                }
            });

        });

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

            var form = document.getElementById('storeCreate')
            var data = new FormData(form);
            data.append('id', idProduct);

            $.ajax({
                url: 'ws/store/update',
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

function groupstore(groupstore_id) {

    var $select = $('#groupstore');
    var outputSelect = '';

    if ($select.length != 0) {

        $.post('ws/group/get', function (data) {

            for (i in data) {
                outputSelect += fill_template($select, data[i]);
            }

            $select.html(outputSelect);

            $select.val(groupstore_id).change().chosen({
                no_results_text: "Oops, grupo não encontrado!"
            });
        });
    }
}