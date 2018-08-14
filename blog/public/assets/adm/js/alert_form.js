$(function () {
    var $tbody = $(".table-alert tbody"),
        value = [];

    get_template($tbody);

    $("#add-item").click(function () {
        var data = {
            id: check_id($tbody, '#item-tr-'),
            initial: '',
            final: '',
            color: '#008000'
        };

        add_item(data)
    });

    $tbody.find('tr').each(function (i, tr) {
        check_value($(tr));
        change_color($(tr));
        remove_item($(tr));
        value.push(parseInt($(tr).find('input.initial').val()));
        value.push(parseInt($(tr).find('input.final').val()));
    });

    data_value_update(value);

});

function check_id($content, id_complete) {

    var id = 1;

    for (i = 1; $content.find(id_complete + id).length > 0; i++) {
        id = i;
    }

    return id;

}

function add_item(data) {
    var $tbody = $(".table-alert tbody"),
        output = '';

    output = fill_template($tbody, data);

    $tbody.append(output);

    check_value($tbody.find('#item-tr-' + data.id));
    change_color($tbody.find('#item-tr-' + data.id));
    remove_item($tbody.find('#item-tr-' + data.id));
}

function change_color($tr) {
    var $select = $tr.find('.input-color'),
        $input = $tr.find('input[type="color"]');

    $select.change(function () {
        var value = $(this).val();

        if (value == 0) {
            $input.removeClass('invisible');
            $tr.find('.change-color .row .col-xs-12').removeClass('col-xs-12').addClass('col-xs-6');
            $input.trigger('click');
        } else {
            $select.css({'background': value});
            $input.addClass('invisible').val(value).change();
            $tr.find('.change-color .row .col-xs-6').removeClass('col-xs-6').addClass('col-xs-12');
        }

    });

    $input.on('change', function () {
        var value = $(this).val();
        $select.css({'background': value});
    });


}

function remove_item($tr) {
    $tr.find('button.remove-item').click(function () {
        $tr.remove();
        data_value_update();
    });
}

function check_value($tr) {
    var $tbody = $(".table-alert tbody");

    $tr.find('input.initial, input.final').change(function () {
        var tbody_value = $tbody.data('value'),
            $initial = $tr.find('input.initial'),
            $final = $tr.find('input.final'),
            initial = parseInt($initial.val()),
            final = parseInt($final.val()),
            this_value = parseInt($(this).val()),
            update = true,
            for_in = true;

        if (!isNaN(initial) && !isNaN(final)) {
            if (initial >= final) {
                $tr.addClass('error');
                update = false;
            } else {
                if ($initial.data('value') != undefined && $final.data('value') != undefined) {
                    if (initial >= $initial.data('value') && initial < $final.data('value') && final > $initial.data('value') && final <= $final.data('value')) {
                        for_in = false;
                    }
                }

                if (for_in) {
                    if (initial < 999999 && final < 999999) {
                        for (i = initial; i <= final; i++) {
                            if ($.inArray(i, tbody_value) > -1) {
                                if ($initial.data('value') != undefined && $final.data('value') != undefined) {
                                    if (i < $initial.data('value') || i > $final.data('value')) {
                                        update = false;
                                    }
                                } else {
                                    update = false;
                                }
                            }
                        }
                    } else {
                        $tr.find('input.initial, input.final').val('');
                    }
                }
            }

            if (update) {
                $initial.data('value', initial);
                $final.data('value', final);
            } else {
                $tr.find('input.initial, input.final').val('').data('value', null);
            }
        }

        data_value_update();

    });
}

function data_value_update() {
    var $tbody = $(".table-alert tbody"),
        value = [];

    if ($tbody.find('tr').length > 0) {
        $tbody.find('tr td .input-group').each(function (i, group) {
            var initial = $(group).find('input.initial').val(),
                final = $(group).find('input.final').val();

            if (initial < 999999 && final < 999999) {
                for (i = initial; i <= final; i++) {
                    value.push(parseInt(i));
                }
            }
        });
    }

    $tbody.data('value', value);
    return value;
}