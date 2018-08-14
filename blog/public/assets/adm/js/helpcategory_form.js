$(function () {
    var learntype_id = extract_url('last'),
        $learntype = $(".learntype");

    if (learntype_id == 'create') {
        fill_form({
            title_page: 'Criar nova categoria',
            'name': ''
        });
    } else if ($.isNumeric(learntype_id)) {
        $.post('ws/learntype/get', {id: learntype_id}, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                var data = data.learntype[0];
                data.title_page = 'Alterar categoria';

                fill_form(data);
            }
        });
    } else {
        alert_box({error: ["Houve um erro ao recuperar os dados."]});
    }

});

function fill_form(data) {
    var $learntype = $(".learntype"),
        learntype_id = extract_url('last'),
        output = '';

    output = fill_template($learntype, data);

    $learntype.html(output);

    $learntype.find('form').submit(function () {

        var data_form = $(this).serialize(),
            action = './ws/learntype/save';

        if ($.isNumeric(learntype_id)) {
            action = './ws/learntype/updateb';
            data_form = data_form + '&id=' + learntype_id;
        }

        $.post(action, data_form, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                localMsg(data.learntype);
                window.location = 'adm/learntype'
            }
        });

        return false;
    });
}