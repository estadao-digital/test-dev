$(function () {

    $("form#invite-new").submit(function () {
        var data_form = $(this).serialize(),
            $input = $(this).find('input.input_more_friends'),
            input_val = null;

        $input.each(function (i, input) {
            if ($(input).val() != '' && $(input).val() != undefined) input_val = true;
        });

        if (input_val) {
            $.post('ws/user/invite', data_form, function (data) {
                if(data.error) {
                    alert_box(data.error);
                }else{
                    window.location = './confirmation?tour';
                }
            });
        }

        return false;
    });

    $(".btn-send").click(function () {
        $('form#invite-new button[type="submit"]').click();
    });
});