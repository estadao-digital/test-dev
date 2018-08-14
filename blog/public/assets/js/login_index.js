$(function () {

    localStorage.removeItem('custom');


    $('.forgot-pass').click(function () {

        $('.form-recover').removeClass('hidden');
        $('.form-login').addClass('hidden');
        $('#inputEmailRecovery').focus();
    });
    $('.registred').click(function () {

        $('.form-recover').addClass('hidden');
        $('.form-login').removeClass('hidden');
        $('#inputEmail').focus();
    });


    $('.form-login').submit(function (e) {
        e.preventDefault();
        e.stopImmediatePropagation();

        var login = $('#inputLogin').val();
        var pass = $('#inputPassword').val();
        var url_entered = window.location.href;
        var arr_1 = url_entered.split('/');
        var arr_2 = arr_1[2].split('.');
        var subdomain = arr_2[0];

         /*$.post('ws/ad/auth', {
                email: "" + email,
                password: "" + pass,
                subdomain: "" + subdomain,
            });*/
        $.post('ws/user/auth', {
                login: "" + login,
                password: "" + pass,
                subdomain: "" + subdomain,
                web: 1
            },
            function (data) {
                if (data.me) {
                    data = data.me


                    console.info(data);
                    // throw new Error('dd');
                    get_me(data);


                        // window.location = $('base').prop('href');
                }
                else {
                    alert_box(data)
                }
            });
        return false;
    });

    $('.form-recover').submit(function () {
        var emailRecovery = $('#inputEmailRecovery').val();
        $.post('ws/user/recovery_password', {
                email: "" + emailRecovery
            },
            function (data) {
                alert_box(data)
                if (data.msg && data.msg.length > 0) {
                    $('#inputEmailRecovery').val('').focus();
                }
            });
        return false;
    });
});

