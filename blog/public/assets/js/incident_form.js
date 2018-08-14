$(function () {
    var $indicator = $("#indicator"),
        $form = $(".incident form");

    $indicator.change(indicator_cause);
    $indicator.change();

    $form.find('button.close-incident').click(function () {
        $form.find('input#close-incident').val(1);
        $form.submit();
    });

    $('#datetimepicker1, #datetimepicker2, #datetimepicker3, #datetimepicker4').datetimepicker({
        locale: 'pt-br',
        format: 'YYYY-MM-DD HH:mm:00',
        ignoreReadonly: true,
        allowInputToggle: true
    });

    add_file();

    $(".list-file ul li a.edit-name").click(function () {
        var $item = $(this).closest('li');

        $item.addClass('edit');

        return false;

    });

    $(".list-file ul li .input-group .btn").click(function () {
        var $item = $(this).closest('li'),
            id = $item.data('id'),
            name = $item.find('.input-group input').val();

        $item.find('a.name').text(name);

        $item.removeClass('edit');

        $.post('./ws/incidentfile/save', {id: id, name: name, incident_id: extract_url('last')}, function (data) {
            if (data.error) {
                alert_box(data);
            }
        });

        return false;
    });

    $(".list-file ul li .input-group input").keypress(function (e) {
        if (e.keyCode == 13) {
            $(".list-file ul li .input-group .btn").click();
            return false;
        }
    });

    $(".list-file ul li a.delete-file").click(function () {
        var $item = $(this).closest('li'),
            id = $item.data('id');

        $.post('./ws/incidentfile/delete', {id: id, incident_id: extract_url('last')}, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                $item.remove();
            }
        });

        return false;
    });

    $("#creator_id, #finisher_id").chosen();

});

function indicator_cause() {
    var data = {
            indicator_id: $("#indicator").val()
        },
        incident_id = extract_url(1),
        $causes = $("#causes"),
        $form = $(".incident form"),
        causes_output = '';

    if (!isNaN(parseFloat(incident_id)) && isFinite(incident_id)) {
        data.incident_id = incident_id;
    }

    get_template($causes);

    if (data.indicator_id != undefined && data.indicator_id != '') {

        $.post('./ws/indicator/get', data, function (data) {

            $form.find('.action-form').removeClass('hide');

            var diagnostic = [],
                correction = [];

            for (i in data.data) {
                var item = {
                    cause_id: data.data[i].id,
                    cause_text: data.data[i].text
                };

                diagnostic[data.data[i].id] = data.data[i].diagnostic;

                correction[data.data[i].id] = data.data[i].correction;

                causes_output += fill_template($causes, item);
            }

            $causes.html(causes_output);

            for (cause_id in diagnostic) {
                var $cause_diagnostic = $causes.find("#cause-" + cause_id + " .diagnostic"),
                    cause_output = '';

                if (diagnostic[cause_id]) {
                    for (i in diagnostic[cause_id]) {

                        diagnostic[cause_id][i].checked = (diagnostic[cause_id][i].checked) ? 'checked' : '';

                        cause_output += fill_template($cause_diagnostic, diagnostic[cause_id][i]);
                    }
                } else {
                    cause_output = '<p class="text-center">Nenhuma ação de diagnóstico cadastrada.</p>';
                }

                $cause_diagnostic.html(cause_output);
            }

            for (cause_id in correction) {
                var $cause_correction = $causes.find("#cause-" + cause_id + " .correction"),
                    cause_output = '';

                if (correction[cause_id]) {
                    for (i in correction[cause_id]) {

                        correction[cause_id][i].checked = (correction[cause_id][i].checked) ? 'checked' : '';

                        cause_output += fill_template($cause_correction, correction[cause_id][i]);
                    }
                } else {
                    cause_output = '<p class="text-center">Nenhuma ação de correção cadastrada.</p>';
                }

                $cause_correction.html(cause_output);
            }

        });
    } else {
        $causes.html(causes_output);
        $form.find('.action-form').addClass('hide');
    }
}

function check_id($content, id_complete) {

    var id = 1;

    for (i = 1; $content.find(id_complete + id).length > 0; i++) {
        id = i;
    }

    return id;

}

function change_file($inputfile) {
    $inputfile.click();

    $inputfile.change(function () {
        var $group = $(this).closest('.input-group');

        if ($(this).val() == '' || $(this).val() == undefined) {
            $group.find('button').click();
        } else {
            $group.removeClass('hide');

            var file = $(this).val(),
                file_name = file.split('\\');

            file_name = file_name.pop();

            file_name = (file_name != '') ? file_name.slice(0, -4) : '';

            $group.find('input[type="text"]').val(file_name);
        }
    });
}


function add_file() {
    var $files = $(".incident form .files"),
        $list = $files.find('.list');

    get_template($list);

    $files.find('#add-file').click(function () {
        var data = {id: check_id($list, '#file-')},
            output = fill_template($list, data);

        $list.append(output);

        change_file($list.find("#file-" + data.id + " input[type='file']"));

        $list.find("#file-" + data.id + " button").click(function () {
            $(this).closest('.input-group').remove();
        });

    });

}