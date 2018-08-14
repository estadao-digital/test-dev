$(function () {
    var learntype_id = extract_url('last'),
        $learntype = $(".learntype");


    if (learntype_id == 'create') {
        fill_form({
            title_page: 'Criar nova categoria',
            'name': ''
        });
    } else if ($.isNumeric(learntype_id)) {

        $.get('learn/quiz/type/' + learntype_id, '', function (data) {

            console.info('opiausjdf');

            $varfill = fill_form({
                title_page: 'Alterar categoria',
                name: data.quiztype[0].title,
                id: learntype_id
            });

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

    $learntype.find('form').submit(function (e) {


        var data_form = $(this).serialize(),
            action = 'learn/quiz/type/create';

        if ($.isNumeric(learntype_id)) {
            action = 'learn/quiz/type/update/' + learntype_id;
        }

        $.post(action, data_form, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                var dt = {};
                dt.msg = "Inserido com sucesso"
                localMsg(dt);
                window.location = 'adm/learntype'
            }
        });

        return false;
    });
}