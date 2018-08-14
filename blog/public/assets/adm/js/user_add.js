$(function () {
    $('.customfield-data').mask('99/99/9999');

    load_custom_field();

    load_type();

    load_template();

    load_group();

    $('#input-user').keyup(function () {
        $(this).val($(this).val().replace(/[^\.a-z0-9_-]/g, ''))
    });

    $('.datetimepicker').datetimepicker({
        locale: 'pt-br',
        format: 'HH:mm:00',
        ignoreReadonly: true,
        allowInputToggle: true
    });

    $('form#userAdd').submit(function (event) {

        var usernameRegex = /^[A-Za-z0-9\.]{3,20}$/;

        event.preventDefault();
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

            $.ajax({
                url: 'ws/user/save',
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

function load_custom_field() {
    $.get('./ws/customfield/get/all', function (data) {
        var output = ''; 
        for (var i in data.customfield) {
           if(data.customfield[i].type == 'list'){
               output += '<div class="item"><label for="userfiled-'+data.customfield[i].id+'">'+data.customfield[i].name+'</label><select class="form-control input-user" id="userfiled-'+data.customfield[i].id+'" name="userfiled[customfieldlist]['+data.customfield[i].id+']">';
               var options = data.customfield[i].options;
                for(var op in options){
                   output += '<option value="'+options[op].id+'">'+options[op].value+'</option>';
               }
                output += '</select></div>';
           } else {
               output += '<div class="item"><label for="userfiled-'+data.customfield[i].id+'">'+data.customfield[i].name+'</label><input type="text" class="form-control input-user" id="userfiled-'+data.customfield[i].id+'" name="userfiled[customfield]['+data.customfield[i].id+']"></div>';
           }
        }
        $(".custom-field").html(output);
    });

}

function load_type() {
    $.get('ws/usertype/get', function (data) {
        var $item = $('#user_types'),
            output = '';

        get_template($item);

        $item.html('');

        for (i in data.usertype) {
            output += fill_template($item, data.usertype[i]);
        }

        $item.append(output);

    });
}

function load_template() {
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

        $item.val(template_default).change();

    });
}

function load_group() {
    $.get('ws/group/get', function (data) {
        var $item = $('#group-id'),
            output = '';

        get_template($item);

        $item.html('');

        for (i in data) {
            output += fill_template($item, data[i]);
        }

        $item.append(output);

        $item.chosen({
            no_results_text: "Oops, grupo não encontrado!"
        });
    });
}