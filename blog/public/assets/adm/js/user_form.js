$(function () {


    $('.customfield-data').mask('99/99/9999');

    $('#input-user').keyup(function () {
        $(this).val($(this).val().replace(/[^\.a-z0-9_-]/g, ''))
    });

    $('.datetimepicker').datetimepicker({
        locale: 'pt-br',
        format: 'HH:mm:00',
        ignoreReadonly: true,
        allowInputToggle: true
    });


    $('form#user-form').submit(function () {

        var usernameRegex = /^[A-Za-z0-9_\.]{3,20}$/,
            user_username = $('#input-user').val(),
            user_workingaccess = $('input[name="workingaccess"]:checked').val(),
            form = document.getElementById('user-form'),
            action = $(this).attr('action'),
            data = new FormData(form);

        if (!usernameRegex.test(user_username)) {
            $('#input-user').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo usuário não é válido</div>')
        }
        else if (user_workingaccess == 1 && ($("#input-entrytime").val() == '' || $("#input-exittime").val() == '')) {
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Defina o horário de entrada e saída</div>');
        }
        else {

            $.ajax({
                url: action,
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
                        alert_box(data)
                    } else {
                        localMsg(data);
                        window.location = 'adm/user/'
                    }
                }
            });
        }

        return false;
    });

    load_higher();
});

function get_higher(nid, $higherid, $select_higherid) {
    var nid = parseInt(nid) + 1,
        me = extract_url(3);

    me = me != undefined ? me : '';


    $select_higherid.html('<option selected>Carregando...</option>').prop('disabled', true);

    $select_higherid.trigger('chosen:updated');

    $higherid.find('label span').html('');

    $.post('./ws/higherbeneathtype/get_higher', {nid: nid, me: me}, function (data) {
        var selected = $select_higherid.data('higherid'),
            disabled = true,
            label = '',
            output = '';

        selected = selected != undefined && selected != null && selected > 0 ? selected : 0;

        if (data != undefined && data.length > 0) {

            for (var i in data) {

                label = '- ' + data[i].name;

                var item = {
                    name: data[i].user_name + ' ' + data[i].user_lastname,
                    id: data[i].user_id
                };

                output += fill_template($select_higherid, item);
            }

            output = '<option value="">Nenhum</option>' + output;

            disabled = false;
        } else {
            output = '<option selected>Não há superiores acima de seu nível hierárquico.</option>';
        }

        $higherid.find('label span').html(label);

        $select_higherid.html(output).prop('disabled', disabled);

        if (!disabled) $select_higherid.val(selected).change();

        $select_higherid.trigger('chosen:updated');
    });
}

function load_higher() {
    var $item = $("#higherbeneathtype"),
        $select_nid = $item.find('#user_nid'),
        nid = $select_nid.val(),
        $higherid = $item.find('.higherid'),
        $select_higherid = $higherid.find('#higherid');

    get_template($select_higherid);

    $select_higherid.html('<option selected>Carregando...</option>');

    $select_higherid.on('chosen:ready', function (evt, params) {
        var $select = $(this),
            $chosen = params.chosen.container;

        if ($select.attr('required') != undefined) {
            $select.insertAfter($chosen);
            $select.addClass('select-chosen-required');
        }

    }).chosen();

    $select_nid.change(function () {
        nid = $(this).val();
        get_higher(nid, $higherid, $select_higherid);
    });

    get_higher(nid, $higherid, $select_higherid);
}