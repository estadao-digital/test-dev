$( document ).ready(function() {
    $('body').delegate('.userinfo','click', function () {
        user_info($(this).data('id-user'));
    });
});

function user_info(user_id) {
    var $user_info = $("#user-info"),
        top = $("body > .header").height() + 40,
        min_width = 500,
        width = ($("#ui-layout-east.ui-layout-pane").length > 0 && $("#ui-layout-east.ui-layout-pane").width() > min_width) ? $("#ui-layout-east.ui-layout-pane").width() : min_width,
        css = {
            height: $(window).height() - (top + 20),
            width: width,
            top: top
        };

    if ($user_info.data('user_id') != user_id) {
        var delay_time = ($user_info.hasClass('open')) ? 500 : 0;
        $user_info.removeClass('open');
        setTimeout(function () {
            $user_info.css(css).addClass('open');
            $.post('ws/user/get_basic_userinfo/', {id: user_id}, function (data) {
                var user = data[0],
                    output = '';

                user.img = user.img === null ? './assets/img/user_pic.jpg' : user.img;

                user.visiblefields = (user.visiblefields && user.visiblefields != null && user.visiblefields != '') ?
                    JSON.parse(user.visiblefields)
                    : "{\"nomesobrenome\":1,\"nomeusuario\":0,\"nid\":1,\"email\":0,\"islider\":0,\"lider\":0,\"localidade\":0,\"celular\":0,\"cargo\":0,\"grupos\":0,\"canais\":0,\"pontuacao\":0,\"nivel\":0,\"telefone\":0,\"ramal\":0,\"minibio\":0,\"customfields\":0}";

                user.show_username = (user.username && user.username != '' && user.visiblefields["nomeusuario"] === 1);
                if (user.visiblefields["pontuacao"] === 1) {
                    user.score = (user.score == 1) ? user.score + " Ponto" : user.score + " Pontos";
                }

                if (typeof(user.visiblefields["nid"]) == 'undefined') {
                    user.visiblefields["nid"] = 1;
                }

                user.show_messenger = (user.messenger && user.messenger != '');

                lastname = (user.lastname) ? user.lastname : "";
                nomesobrenome = user.name + " " + lastname;
                user.show_nome_sobrenome = ((nomesobrenome && nomesobrenome != '') && user.visiblefields["nomesobrenome"] === 1);

                user.show_isleader = (user.leader && user.leader != '' && user.visiblefields["islider"] === 1);

                user.show_leader = (user.leadername && user.leadername != '' && user.visiblefields["lider"] === 1);
                user.show_groups = (user.groups && user.groups != '' && user.visiblefields["grupos"] === 1);
                user.show_nid = (user.nid && user.nid != '' && user.visiblefields["nid"] === 1);

                user.show_chats = (user.chats && user.chats != '' && user.visiblefields["canais"] === 1);

                user.show_phone_branch = ((user.phone && user.phone != '') || (user.branch && user.branch != '') && user.visiblefields["telefone"] === 1);
                user.show_cellphone = (user.cellphone && user.cellphone != '' && user.visiblefields["celular"] === 1);

                user.show_place = (user.place && user.place != '' && user.visiblefields["localidade"] === 1);
                user.show_cell = (user.cell && user.cell != '' && user.visiblefields["celula"] === 1);
                user.show_position = (user.position && user.position != '' && user.visiblefields["cargo"] === 1);
                user.show_description = (user.description && user.description != '' && user.visiblefields["minibio"] === 1);

                output = fill_template($user_info, user, 'template-user-info');

                $user_info.html(output);

                $user_info.find('.close').click(function () {
                    $user_info.removeClass('open');
                    $user_info.data('user_id', 'default');
                    return false;
                });

                $.get('./ws/customfield/get/all', function (data) {
                    var userfield = user.userfield,
                        $userfield = $user_info.find(".userfield"),
                        output_userfield = '',
                        userfield_value = [];

                    for (i in userfield) {
                        userfield_value[userfield[i].customfield_id] = userfield[i].value;
                    }

                    for (i in data.customfield) {
                        var item = {
                            userfield_name: data.customfield[i].name,
                            userfield_value: userfield_value[data.customfield[i].id],
                            show_userfield: (data.customfield[i].name && userfield_value[data.customfield[i].id] && user.visiblefields["customfields"] === 1) ? true : false
                        };
                        output_userfield += fill_template($userfield, item);
                    }

                    $userfield.html(output_userfield);

                });

                $user_info.data('user_id', user_id);

            });
        }, delay_time);
    } else {
       // $user_info.data('user_id', 'default');
    }

    $(".btn-pin, .btn-mentions, .btn-files").click(function () {
        $user_info.find('.close').trigger('click');
    });
}