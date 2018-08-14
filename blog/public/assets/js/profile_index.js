$ (function () {
    $.ajax({
        url: 'ws/user/get_basic/me',
            cache: false
        })
        .done(function(user) {

            $('#input-name').val(user.name);
            $('#input-user').val(user.username);
            $('#input-img').val(user.img);
            $('#input-email').val(user.email);
        });

    $('#input-user').keyup(function(){
        $(this).val($(this).val().replace(/[^a-z0-9_-]/g, ''))
    });

    $('.btn-send').click(function () {

        var regex =  /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var nameRegex = /^[A-Za-z0-9]{3,20}$/;

        event.preventDefault();
        var user_email = $('#input-email').val(),
            user_name = $('#input-name').val(),
            user_img = $('#input-img').val(),
            user_username = $('#input-user').val();

        if(!regex.test(user_email)){
            $('#input-email').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> Email inválido, confira se o email está correto</div>')
        }
        else if (user_email.length === 0) {
            $('#input-email').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo email está vazio</div>')
        }
        else if (user_name.length === 0) {
            $('#input-name').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo nome está vazio</div>')
        }
        else if (user_username.length === 0) {
            $('#input-user').addClass('error');
            $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo usuário está vazio</div>');
        }
        else {

            var form = document.getElementById('userAdd')
            var data = new FormData(form);

            $.ajax({
                url: 'ws/user/update',
                data: data,
                processData: false,
                type: 'POST',
                contentType: false,
                beforeSend: function (x) {
                    if (x && x.overrideMimeType) {
                        x.overrideMimeType("multipart/form-data");
                    }
                },
                mimeType: 'multipart/form-data',
                success: function(response, textStatus) {
                    var data = $.parseJSON(response);
                    if (data.error){
                        alert_box(data)
                    } else {
                        localMsg(data);
                        window.location = 'feed'
                    }
                }
            });
        }
    });

});
