$(function () {
    var number = extract_url('last');

    if (number == 'create') {
        fill_form({
            title_page: 'Criar novo campo',
            'name': ''
        });
    } else if ($.isNumeric(number)) {
        $.post('ws/Grouping/get', {number: number}, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                var data = data.Grouping;

                data.title_page = 'Alterar campo';
                $("#type option[value=" + data.type + "]").attr('selected', 'selected');
                $("#type").trigger('chosen:updated');
                if (data) {
                    $("#type").prop('disabled', true);
                    $("#first").parent().remove();
                    for (var i in data) {
                        if (typeof(data[i].value) == 'undefined') {
                            continue;
                        }
                        addListField(data[i].value, true, data[i].id);
                    }
                    $("#list :input").prop('required', true);
                    $('#list').show();
                }
                fill_form(data);
            }
        });
    } else {
        alert_box({error: ["Houve um erro ao recuperar os dados."]});
    }
    $('#type').change(function () {
        if ($(this).val() === 'list') {
            $("#list :input").prop('required', true);
            $('#list').show();
        } else {
            $("#list :input").prop('required', false);
            $('#list').hide();
        }
    });
});

function fill_form(data) {
    var $customfield = $(".customfield"),
        customfield_id = extract_url('last'),
        output = '';
    output = fill_template($customfield, data);
    $customfield.html(output);
    $customfield.find('form').submit(function () {
        var data_form = $(this).serialize(),
            action = './ws/customfield/save';
        if ($.isNumeric(customfield_id)) {
            action = './ws/customfield/update';
            data_form = data_form + '&id=' + customfield_id;
        }
        $.post(action, data_form, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                localMsg(data.customfield);
                window.location = 'adm/customfield'
            }
        });
        return false;
    });
}

function removeListField(input) {
    $(input).parent().remove();
}
function addListField(texto, noDeleted, id) {
    var trash = '';
    if (!texto) {
        texto = '';
    }
    if (id) {
        input = '<input type="text" class="form-control existing" name="option[' + id + ']" value="' + texto + '" data-id="' + id + '"  required>';
    } else {
        input = '<input type="text" class="form-control" name="value[]" value="' + texto + '" required>';
    }

    if (!noDeleted) {
        trash = '<span class="input-group-addon" onclick="removeListField(this)"><i class="fa fa-trash"></i></span>';
    } else {
        trash = '<span class="input-group-addon" onclick="removeExistingListField(' + id + ')"><i class="fa fa-trash"></i></span>';
    }
    var output = '<div class="input-group" style="margin-top:10px"><span class="input-group-addon">Texto</span>' + input + trash + '</div>';
    $('#list .fields').append(output);
}


function removeExistingListField(grouping_id) {
    input_hidden = '<input type="hidden" class="exclude" name="exclude[]" value="' + grouping_id + '" data-id="' + grouping_id + '" >';
    $elemento_hidden = $(".exclude[data-id=" + grouping_id + "]");
    $elemento_existing = $('.existing[data-id=' + grouping_id + ']');

    $elemento_existing.parent(".input-group").toggleClass("to-exclude");

    if ($elemento_existing.parent(".input-group").hasClass("to-exclude") && $elemento_hidden.length == 0) {
        $('#list .fields').append(input_hidden);
    } else if (!$elemento_existing.parent(".input-group").hasClass("to-exclude") && $elemento_hidden.length > 0) {
        $elemento_hidden.remove();
    }
}