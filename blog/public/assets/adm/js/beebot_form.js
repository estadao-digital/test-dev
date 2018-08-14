$(function () {
    var beebot_id = extract_url('last'),
        $beebot = $(".beebot");

    if (beebot_id == 'create') {
        fill_form({
            title_page: 'Criar nova',
            'textin': '',
            'textout': ''
        });

    } else if ($.isNumeric(beebot_id)) {
        $.post('ws/beebot/get', {id: beebot_id}, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                var data = data.beebot[0];
                data.title_page = 'Alterar';

                fill_form(data);
            }
        });
    } else {
        alert_box({error: ["Houve um erro ao recuperar os dados."]});
    }

});

function fill_form(data) {
    var $beebot = $(".beebot"),
        $beebot_log = $(".beebotlog"),
        beebot_id = extract_url('last'),
        output = '',
        outputlog = '<li style="background-image: url(\'' + data.user_img + '\');"><span> Criado por ' + data.user_name + ' ' + data.user_lastname + '</span> em ' + data.long_date_format + '</li>';

    output = fill_template($beebot, data);

    $beebot.html(output);

    if (data.changed_by) {
        for (i in data.changed_by) {
            data.changed_by[i].style = (data.changed_by[i].user_img) ? 'style="background-image: url(\'' + data.changed_by[i].user_img + '\');"' : '';
            outputlog += fill_template($beebot_log.find('.list'), data.changed_by[i]);
        }
    } else {
        $beebot_log.hide();
    }

    $beebot_log.find('.list').html(outputlog);

    $beebot.find('form').submit(function () {

        var data_form = $(this).serialize(),
            action = './ws/beebot/save';

        if ($.isNumeric(beebot_id)) {
            action = './ws/beebot/update';
            data_form = data_form + '&id=' + beebot_id;
        }

        $.post(action, data_form, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                localMsg(data);
                window.location = 'adm/beebot'
            }
        });

        return false;
    });
}