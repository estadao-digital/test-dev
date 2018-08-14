$(function () {
    var categorypost_id = extract_url('last'),
        $categorypost = $(".categorypost");

    if (categorypost_id == 'create') {
        fill_form({
            title_page: 'Criar nova campanha',
            'name': ''
        });
    } else if ($.isNumeric(categorypost_id)) {
        $.post('ws/categorypost/get', {id: categorypost_id}, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                var data = data.categorypost[0];
                data.title_page = 'Alterar campanha';

                fill_form(data);
            }
        });
    } else {
        alert_box({error: ["Houve um erro ao recuperar os dados."]});
    }

});

function fill_form(data) {
    var $categorypost = $(".categorypost"),
        categorypost_id = extract_url('last'),
        output = '';

    output = fill_template($categorypost, data);

    $categorypost.html(output);

    $categorypost.find('form').submit(function () {

        var data_form = $(this).serialize(),
            action = './ws/categorypost/save';

        if ($.isNumeric(categorypost_id)) {
            action = './ws/categorypost/update';
            data_form = data_form + '&id=' + categorypost_id;
        }

        $.post(action, data_form, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                localMsg(data.categorypost);
                window.location = 'adm/categorypost'
            }
        });

        return false;
    });
}