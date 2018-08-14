$(function () {

    $('.register .carousel').each(function () {
        $(this).carousel({
            pause: true,
            interval: false
        });
    });


    $('#input-url').keyup(function () {
        $(this).val($(this).val().replace(/[^a-z0-9]/g, ''))
    });

    $('#user_username').keyup(function () {
        $(this).val($(this).val().replace(/[^\.a-z0-9_-]/g, ''))
    });

    $('.step5 .btn-send').click(function () {

        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var nameRegex = /^[A-Za-z0-9]{3,20}$/;
        var domainRegex = /^[a-z0-9]{3,20}$/;

        event.preventDefault();
        var user_email = $('.input-email').val(),
            team_name = $('.input-team').val(),
            team_subdomain = $('.input-url').val(),
            first_name = $('.input-name').val(),
            user_password = $('.input-password').val(),
            last_name = $('.input-last-name').val(),
            user_username = $('.input-user').val(),
            user_name = $('.input-name').val();

        if (!$('.accept').prop('checked')) {

            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Por favor aceite os termos de uso do Beedoo!</div>')
        }
        else if (!regex.test(user_email)) {
            $('#input-email').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Email inválido, confira se o email está correto</div>')
            $('.register .carousel').carousel(0);
            $('#input-email').focus;
        }
        else if (user_email.length === 0) {
            $('#input-email').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo email está vazio</div>')
            $('.register .carousel').carousel(0);
            $('#input-email').focus;
        }
        else if (user_password.length === 0) {
            $('#input-password').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo senha está vazio</div>')
            $('.register .carousel').carousel(0);
            $('#input-password').focus;
        }
        else if (team_name.length === 0) {
            $('#input-team').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo nome do time está vazio</div>')
            $('.register .carousel').carousel(1);
            $('#input-team').focus;
        }
        else if (team_subdomain.length === 0) {
            $('#input-url').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo subdominio está vazio</div>')
            $('.register .carousel').carousel(2);
            $('#input-url').focus;
        }
        else if (!domainRegex.test(team_subdomain)) {
            $('#input-url').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O subdominio não é válido, use apenas letras e números</div>')
            $('.register .carousel').carousel(2);
            $('#input-url').focus;
        }
        else if (last_name.length === 0) {
            $('#input-last-name').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo sobrenome está vazio</div>')
            $('.register .carousel').carousel(3);
            $('#input-last-name').focus;
        }
        else if (first_name.length === 0) {
            $('#input-name').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo nome está vazio</div>')
            $('.register .carousel').carousel(3);
            $('#input-name').focus;
        }
        else if (user_username.length === 0) {
            $('#input-user').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo usuário está vazio</div>')
            $('.register .carousel').carousel(3);
            $('#input-user').focus;
        }
        else if (!nameRegex.test(user_username)) {
            $('#input-user').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo usuário não é válido</div>')
            $('.register .carousel').carousel(3);
            $('#input-user').focus;
        }
        else {
            $.post('ws/team/save', {
                    user_password: user_password,
                    user_email: user_email,
                    team_name: team_name,
                    team_subdomain: team_subdomain,
                    user_username: user_username,
                    user_name: user_name,
                    last_name: last_name
                },
                function (data) {

                    if (data.error) {
                        alert_box(data);
                        $('.register .carousel').carousel(0);
                    } else {

                        window.location.href = data.link;
                    }
                });
        }
        return false;
    });

    var input = $('.more_friends').html();
    $('.label_more_friends').click(function () {
        $('.more_friends').prepend(input);
    })
});


