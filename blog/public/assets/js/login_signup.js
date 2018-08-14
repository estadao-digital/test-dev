$(function () {


    $('#username').keyup(function () {
        $(this).val($(this).val().replace(/[^\.a-z0-9_-]/g, ''))
    });

    $(".form-singup").submit(function () {
        var data_form = $(this).serialize(),
            password = $(".form-singup #password").val(),
            password_confirm = $(".form-singup #confirmPassword").val(),
            password_status = true;

        if (password != '' || password_confirm != '') {
            if (password != password_confirm) {
                password_status = false;
            }
        }

        if (!password_status) {
            var error = {error: ['Senhas não coincidem!']};

            alert_box(error);

            $(".form-singup #password").focus();

        } else {
            $.post('ws/user/save', data_form, function (data) {
                if (data.error) {
                    alert_box(data);
                } else {
                    alertMsg("Conta foi criada com sucesso. Você será redirecinado ou clique <a href='./login'>aqui</a>.");
                    $(".form-singup button[type='reset']").trigger('click');
                    window.location = '/login';
                }

            });

        }

        return false;
    });
});
