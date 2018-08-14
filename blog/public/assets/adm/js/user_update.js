$(function () {

    $('.customfield-data').mask('99/99/9999');
    var idUser = extract_url('last');
    var getUrl = 'ws/user/get/all';

    $('#input-user').keyup(function () {
        $(this).val($(this).val().replace(/[^\.a-z0-9_-]/g, ''))
    });

    $('#group-id').chosen({
        no_results_text: "Oops, grupo não encontrado!"
    });

    $('.datetimepicker').datetimepicker({
        locale: 'pt-br',
        format: 'HH:mm:00',
        ignoreReadonly: true,
        allowInputToggle: true
    });


    $('form#user-form').submit(function () {

        var usernameRegex = /^[A-Za-z0-9\.]{3,20}$/;

        var user_username = $('#input-user').val(),
            user_workingaccess = $('input[name="workingaccess"]:checked').val();

        if (!usernameRegex.test(user_username)) {
            $('#input-user').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo usuário não é válido</div>')
        }
        else if (user_workingaccess == 1 && ($("#input-entrytime").val() == '' || $("#input-exittime").val() == '')) {
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Defina o horário de entrada e saída</div>');
        }
        else {

            var form = document.getElementById('userAdd');
            var data = new FormData(form);
            data.append('id', idUser);

            $.ajax({
                url: 'ws/user/update',
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
});

function load_custom_field(userfield) {
    $.get('./ws/customfield/get/all', function (data) {
        var $custom_field = $(".custom-field"),
            output = '',
            userfield_value = [];

        for (i in userfield) {
            userfield_value[userfield[i].customfield_id] = userfield[i].value;
        }

        for (i in data.customfield) {

            data.customfield[i].value = (userfield_value[data.customfield[i].id]) ? userfield_value[data.customfield[i].id] : '';

            output += fill_template($custom_field, data.customfield[i]);
        }

        $custom_field.html(output);

    });

}

function load_type(usertype_id) {
    $.get('ws/usertype/get', function (data) {
        var $item = $('#user_types'),
            output = '';

        get_template($item);

        $item.html('');

        for (i in data.usertype) {
            output += fill_template($item, data.usertype[i]);
        }

        $item.append(output);

        $item.val(usertype_id).change();

    });
}

function load_template(template_id) {
    $.get('ws/template/get', function (data) {
        var $item = $('#user_template_id'),
            output = '',
            template_default = 0;

        get_template($item);

        $item.html('');

        for (i in data.template) {

            if (data.template[i].default == 1) template_default = data.template[i].id;

            output += fill_template($item, data.template[i]);
        }

        $item.append('<option value="0">Nenhum</option>' + output);

        if (template_id == 0) {
            template_id = 0;
        }

        $item.val(template_id).change();

    });
}

function load_group(groupuser) {
    var group_id = [];

    for (i in groupuser) {
        group_id[i] = groupuser[i].group_id;
    }

    $.get('ws/group/get', function (data) {
        var $item = $('#group-id'),
            output = '';

        get_template($item);

        $item.html('');

        for (i in data) {
            output += fill_template($item, data[i]);
        }

        $item.append(output);

        $item.val(group_id).change();

        $item.chosen({
            no_results_text: "Oops, grupo não encontrado!"
        });
    });
}