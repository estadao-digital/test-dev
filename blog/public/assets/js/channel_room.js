var Broadcast = {
    POST : "post",
    BROADCAST_URL : "socket.beedoo.io",
    BROADCAST_PORT : "2000",
};

$.wait = function( callback, seconds){
    return window.setTimeout( callback, seconds * 1000 );
}


var conn = new Connection2("socket.beedoo.io:2000");
$.wait( function(){
    var typeData = { 'Register' : true, user_id : $("#user_id").val(), channel: $("#channel_id").val(), team_id: $("#team_id").val()};
    conn.sendMsg(typeData);
}, 2);

$(function () {
    var $channelprivate = $(".channel-type label input");

    $channelprivate.click(function () {
        channel_private($channelprivate);
    });
});

function channel_private($channelprivate) {
    var $channeltype = $channelprivate.closest(".channel-type-modal");

    if ($('.channel-type-modal').hasClass("checked-input")) {
        $channeltype.removeClass('checked-input');
        $("select#select-user-id").removeAttr('required');
    } else {
        $channeltype.addClass('checked-input');
        $("select#select-user-id").attr('required', 'required');
    }
}
$(function () {
    $('#ui-layout-center .scroll').scroll(function() {
        if($('#ui-layout-center .scroll').scrollTop() + $('#ui-layout-center .scroll').height() - 60 === $('#ui-layout-center .scroll > div').height()) {
                load_item(true, false, $('.channel-message:last').attr('value'), true);
        }
    });
    $(".box-1 .scroll").scroll(function () {
        if ($(".box-1 .scroll ").scrollTop() < 2) {
            load_item(false, true);
        }
        return false;
    });
    $("textarea.comment-area").atwho({
        at: "@",
        searchKey: 'q',
        minLen: 2,
        insertTpl: "${atwho-at}${username}",
        displayTpl: "<li><img src='${img}'><p>${name} ${lastname}</p><p><small>@${username}</small></p><div class='clearfix'></div></li>",
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/user/get_basic/0/name_lastname_username_id_avatar?channel=' + $('#channel_id').val(), {q: query}, function (data) {
                    $.each(data, function (i, el) {
                        data[i]['q'] = el.name + " " + el.username;
                    });
                    callback(data)
                });
            }
        }
    }).atwho({
        at: "*",
        searchKey: 'q',
        minLen: 2,
        insertTpl: "${atwho-at}${name}",
        displayTpl: "<li><p>${name}</p><div class='clearfix'></div></li>",
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/group/get/', {q: query}, function (data) {
                    $.each(data, function (i, el) {
                        data[i]['q'] = el.name + " " + el.username;
                    });
                    callback(data)
                });
            }
        }
    }).atwho({
        at: ":",
        searchKey: 'q',
        minLen: 1,
        insertTpl: ":${name}:",
        displayTpl: "<li class='emojis'><p><img src='${img}'> ${name}</p><div class='clearfix'></div></li>",
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/emoji/get/', {q: query}, function (data) {

                    var emojis = [],
                        emoji = data.emoji;

                    if (emoji) {
                        for (i in emoji) {
                            var item = emoji[i].item;

                            for (e in item) {
                                item[e]['q'] = item[e].name;
                                emojis.push(item[e]);
                            }
                        }
                    }
                    callback(emojis);
                });
            }
        }
    }).keypress(function (event) {
        if (event.keyCode == 13 && !event.shiftKey) {
            $(this).closest('form').submit();
            return false;
        }
    }).focus();

    $('#comentAreaForm .emojitextarea').emoji({
        action: 'click mouseover',
        position: 'top-left',
        callback: function (element, contanier) {
            var $textarea = $(this).prev('textarea');

            $textarea.val($textarea.val() + element.code + " ").focus();

            contanier.hide();
        }
    });

    $('#modal-file .emojitextarea').emoji({
        action: 'click mouseover',
        position: 'bottom-left',
        callback: function (element, contanier) {
            var $textarea = $(this).prev('textarea');
            $textarea.val($textarea.val() + element.code + " ").focus();
            contanier.hide();
        }
    });

    $('#comentAreaForm, #modalFile').submit(function () {
        if ($('.input-img').length) {
            if (checar($('.input-img'), false) == false) {
                return false;
                $('.input-img').val('');
            }
        }
        var form_id = $(this).attr('id');
        send_message(form_id);
        return false;
    });

    $("#more-posts").click(function () {
        load_item(false, true);
    });

    chat_update();

    $("#chat-info, .new-channel a").click(function () {
        $("#modal-channel-update").modal('show');
        return false;
    });

    $(".channel .participants-count").click(function () {
        var info = $(this).data('info'),
            term = ":Usuários do canal " + info.name + " (" + info.id + "):";

        $('.header .navbar-right .search').val(term).keyup().focus();

        return false;

    });

    send_file();
    load_item(false, false, extract_url("#"));
    //load_pins();
    channel_info();
    //scroll_button('hide')

    window.onhashchange = function () {
        location.reload();
    };


});

function delete_channel_modal(text_html, id, location) {
    var $modal = $('#modal-confirm'),
        text_html = text_html != undefined ? text_html : '';

    $modal.modal('show');

    $modal.find('.modal-body').html(text_html);


    if (id) {
        $modal.find('.confirm').attr('onclick', "channel_delete("+id+",'"+location+"')" + ";return false;");
    }
}

function channel_delete(id, location) {
    $.get("./ws/chat/delete/" + id, function () {
        window.location = location;
    });
}


function load_item(scroll, beforeposts, chat_id, new_page) {
    var time_out = 5000,
        $channel_info = $("#channel-info"),
        $list_posts = $(".channel .group-itens"),
        firstpost = $(".item", $list_posts).first().data('datetime'),
        lastpost = $(".item", $list_posts).last().data('datetime'),
        chatinfo_id = extract_url(1),
        adfterdate = (!beforeposts && lastpost != "{{datetime}}") ? lastpost : '',
        beforedate = (beforeposts && firstpost != "{{datetime}}") ? firstpost : '',
        $chat_item = null,
        h_scroll_div = $('#ui-layout-center .scroll > div').height(),
        h_scroll = $('#ui-layout-center .scroll').height(),
        t_scroll = $('#ui-layout-center .scroll').scrollTop(),
        scroll_status = ((h_scroll + t_scroll + 250) > h_scroll_div);

    if (chat_id) {
        chat_id = chat_id.replace('#', '');
    }

    var itemscroll = $(".item", $list_posts).first();
    var aux = 0;

    if (beforeposts) $("#more-posts").addClass('hide');
    if (beforeposts != '') $(".load-chat").show();

    $.post('ws/chat/get', {
        afterdate: "" + adfterdate + "",
        beforedate: "" + beforedate + "",
        chatinfo_id: chatinfo_id,
        chat_id: chat_id
    }, function (data) {
        if (data.error) {
            alert_box(data);
        } else {
            var title = (data.chatinfo.private == 1) ? '<i class="fa fa-lock" aria-hidden="true"></i> ' + data.chatinfo.name : (data.chatinfo.private == 3) ? '<i class="fa fa-dot-circle-o" aria-hidden="true"></i> ' + data.chatinfo.name : '<i class="fa fa-hashtag" aria-hidden="true"></i> ' + data.chatinfo.name,
                total_users = data.chatinfo.total_users,
                posts = data.chat_list_datetime,
                emojis = [],
                output = '',
                limitMore = (beforeposts && data.limit > posts.length) ? false : true,
                more = (beforeposts && data.more != undefined) ? data.more : limitMore;

            $channel_info.data('info', data.chatinfo);

            $(".channel h1.title").html(title);

            $(".channel .participants-count").text(total_users + " Participantes").data('info', data.chatinfo);

            if (Object.keys(posts).length > 0) {
                for (d in posts) {

                    var date_divider = d.split('-'),
                        date_block_id = "date-" + d;

                    output = '';

                    date_divider = date_divider[2] + '/' + date_divider[1] + '/' + date_divider[0];

                    var html_date = "<div class=\"group-datetime\" id=\"" + date_block_id + "\">" +
                        "<div class=\"clearfix\"></div><h3>" + date_divider + "</h3>" +
                        "<div class=\"itens\"></div>" +
                        "<div class=\"clearfix\"></div></div>";

                    if ($list_posts.find("#" + date_block_id).length == 0) {
                        if (!$list_posts.hasClass('first-load-ok') || beforeposts) {
                            $list_posts.prepend(html_date);
                        } else {
                            $list_posts.append(html_date);
                        }
                    }
                    for (i in posts[d]) {
                        emojis[posts[d][i].id] = posts[d][i].emoji;

                        posts[d][i].user_img = posts[d][i].user_img === null ? './assets/img/user_pic.jpg' : posts[d][i].user_img;
                        posts[d][i].is_shared_wiki = 'false';
                        posts[d][i].not_shared_wiki = 'true';
                        if (posts[d][i].sharedwiki_id && posts[d][i].sharedwiki_id != null && posts[d][i].sharedwiki_id != false) {
                            posts[d][i].is_shared_wiki = 'true';
                            posts[d][i].not_shared_wiki = 'false';
                            posts[d][i].sample_article = posts[d][i].sharedwiki_id.text;
                            posts[d][i].title_article = posts[d][i].sharedwiki_id.title;
                            posts[d][i].link_article = posts[d][i].sharedwiki_id.link;
                        }
                        if (posts[d][i].reference) {
                            posts[d][i].reference_class = "show";
                            posts[d][i].reference_user_name = posts[d][i].reference.user_name + ' ' + posts[d][i].reference.user_lastname;
                            posts[d][i].reference_date = posts[d][i].reference.date;
                            posts[d][i].reference_hour = posts[d][i].reference.hour;
                            posts[d][i].reference_datetime = posts[d][i].reference.format_datetime;
                            posts[d][i].reference_text = posts[d][i].reference.text;
                        }
                        posts[d][i].delete_message = posts[d][i].id;
                        posts[d][i].complaint_message = posts[d][i].id;
                        posts[d][i].delete_mesage_ctrl = me().usertype_id == 2 || me().id == posts[d][i].user_id ? '' : 'hidden';
                        if (posts[d][i].file.format != "" && posts[d][i].file.format != undefined) {

                            if (posts[d][i].file.format == "image") {
                                fileName = posts[d][i].file.src;
                                fileName = fileName.split('/');
                                fileName = fileName.pop();
                                posts[d][i].file = '<a href="' + posts[d][i].file.src + '" style="background-image: url(' + posts[d][i].file.src + ')" gallery-image class="img-rounded img-ajuste"><img src="' + posts[d][i].file.src + '" class="img-responsive" alt="" /></a>';
                            } else {
                                var permission = data.permission;
                                if(permission) {
                                    posts[d][i].file = '<a href="' + posts[d][i].file.src + '" download="' + posts[d][i].file.name + '"><span class="glyphicon glyphicon-save"></span> ' + posts[d][i].file.name + '</a>';
                                }else{
                                    posts[d][i].file = '<span class="glyphicon glyphicon-remove-circle"></span> Conteúdo Bloqueado.';
                                }
                            }

                        } else {
                            posts[d][i].file = "";
                        }
                        output = fill_template($list_posts, posts[d][i]) + output;
                    }
                    output = $.parseHTML(output);
                    if (beforeposts) {
                        $list_posts.find("#" + date_block_id).find(".itens").prepend(output);
                        if (more)$("#more-posts").removeClass('hide');
                    } else {
                        $list_posts.find("#" + date_block_id).find(".itens").append(output);
                    }
                }
                for (var post_id in emojis) {
                    if (emojis[post_id].length > 0) {
                        load_emoji_chat($("#item-post-" + post_id).find('li.emojichat'), emojis[post_id]);
                    }
                }
                $list_posts.addClass('first-load-ok');
                blueimp_load($list_posts);
                if (chat_id) {
                    $chat_item = $('#item-post-' + chat_id);
                    $.post('ws/mention/read_mention', {fk_id: chat_id, target: "chat"}).done(loadMentions());

                    if ($chat_item && $chat_item.length > 0) {

                        var bg_temp = "#d65a00",
                            bg_default = $chat_item.css('background-color'),
                            custom = get_custom();
                        if (custom) {
                            bg_temp = custom.color1;
                        }
                        $chat_item.addClass('focus_trans');

                        //console.log("TESTESTESTE: " + bg_temp);
                        color = hexToRgb(bg_temp);
                        color_string = "rgba(" + color.r + "," + color.g + "," + color.b + ",.15)";

                        if(new_page !== true){
                            $chat_item.css('background-color', color_string);
                        }

                        if(new_page) {
                            $('#ui-layout-center .scroll').animate({scrollTop:$('.conversations-list').height()*0.70},1000);
                        }else {
                            $('#ui-layout-center .scroll').animate({scrollTop: $chat_item.offset().top - (($chat_item.height() + $("#more-posts").height()) + 75)}, 0);
                            $("#comentAreaForm > .comment-area").attr('data-action', 'redirect');
                        }
                    }

                } else if (!beforeposts && scroll) {

                    if (scroll_status) {
                        $('#ui-layout-center .scroll').animate({scrollTop: $($list_posts).height()}, 500);
                    }
                } else if (beforeposts) {
                    $('#ui-layout-center .scroll').animate({scrollTop: itemscroll.offset().top - ((itemscroll.height() + $("#more-posts").height()) + 75)}, 0);

                } else {
                    $('#ui-layout-center .scroll').scrollTop($($list_posts).height());
                }

                $list_posts.find('.emojiChat.not-loaded').removeClass('not-loaded').emoji({
                    action: 'click mouseover',
                    position: 'bottom-right',
                    callback: function (element, contanier) {

                        var $chat = $(this).closest('.item'),
                            chat_id = $chat.data('chat-id'),
                            emoji_id = element.id,
                            $localemoji = $chat.find('li.emojichat');

                        $.post('ws/emojichat/save',
                            {
                                chat_id: chat_id,
                                emoji_id: emoji_id
                            },
                            function (data) {
                                if (data.error) {
                                    alert_box(data);
                                    return false;
                                } else {

                                    load_emoji_chat($localemoji, data.emojichat);
                                }
                            });

                        contanier.hide();
                    }
                });

                $(output).find(".menu-item.dropdown > a").on('mouseover', function () {
                    if (!$(this).parent().hasClass('open')) $(this).trigger('click');
                });

                if (data.chat_list_datetime && data.chat_list_datetime.length > 0) {
                    for (i in data.chat_list_datetime) {
                        var $chat = $(output).filter(".item[data-chat-id=" + data.chat_list_datetime[i].id + "]"),
                            $localemoji = $chat.find('.emojichat');

                        load_emoji_chat($localemoji, data.chat_list_datetime[i].emoji);
                    }
                }

                $(".new-channel").hide();
            }
            else if (!scroll && !beforeposts) {
                $(".new-channel").show().find(".insert-name").html(title);
            }
            if (!beforeposts && !chat_id) {
               /* setTimeout(function () {
                    load_item(true, false, false);
                }, time_out);
*/
            }
            $(".load-chat").hide();
        }
    });
}

function modal_complaint_message(message_id) {
    var complaint_button = '<button type="button" class="oi btn btn-orange" onclick="complaint_message(' + message_id + ')" >Denunciar</button>';
    $('#complaint-footer').html(complaint_button);
    $('#complaint_modal').modal('show');
};

function complaint_message(message_id) {
    if($('#complaint_type option:selected').val() > 0){
        var message = '#item-post-' + message_id;
        $.post('ws/chat/complaint/' + message_id + '',{'type':$('#complaint_type option:selected').val(), 'description':$('#complaint_description').val()});
        $(message).css("border", "1px solid red");
        $(message + " > .conversations-info > .row > .conversations-name").append('<i title="Comentário denúnciado!" class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
        $("#complaint_modal").modal('hide');
    }else{
        $("#complaint_valid").removeClass("hide");
    }
};

function modal_delete_message(message_id) {
    var delete_button = '<button type="button" id="oi" class="oi btn btn-orange" onclick="delete_message(' + message_id + ')" data-dismiss="modal">Apagar</button>';
    $('#delete-footer').html(delete_button);
    $('#delete_modal').modal('show');
};

function delete_message(message_id) {
    var message = '#item-post-' + message_id;
    $.post('ws/chat/delete_msg/' + message_id + '');
    $(message).css("display", "none");
};

function load_emoji_chat($localemoji, data) {
    var $localemoji = load_emoji($localemoji, data);

    if ($localemoji && $localemoji != undefined) {

        $localemoji.find('a').click(function () {

            var $chat = $(this).closest('.item'),
                chat_id = $chat.data('chat-id'),
                emoji_id = $(this).data('emoji-id'),
                $localemoji = $chat.find('li.emojichat');

            $.post('ws/emojichat/save',
                {
                    chat_id: chat_id,
                    emoji_id: emoji_id
                },
                function (data) {
                    if (data.error) {
                        alert_box(data);
                        return false;
                    } else {

                        load_emoji_chat($localemoji, data.emojichat);
                    }
                });

            return false;

        });
    }
}

function load_emoji($localemoji, data) {

    var $localemoji = $localemoji,
        data = data,
        output = '';

    get_template($localemoji);

    $localemoji.html('');


    if (data && data.length > 0) {
        for (i in data) {
            data[i].emoji_id = data[i].id;
            data[i].emoji_name = data[i].name;
            data[i].emoji_img = data[i].img;
            data[i].emoji_code = ":" + data[i].name + ":";
            data[i].emoji_count = data[i].count;

            output += fill_template($localemoji, data[i]);
        }

        $localemoji.html(output);

        return $localemoji;
    }
}

function send_message(form_id) {
    var $list_posts = $(".message .group-itens"),
        form = $("#" + form_id),
        chatinfo_id = extract_url(1),
        formData = new FormData(document.getElementById(form_id)),
        text_area = $("textarea.comment-area", form),
        inputFile = $("input[name='file']", form);
    formData.append('chatinfo_id', chatinfo_id);
    if (/*text_area.val().trim() == '' || */ inputFile.val() == '') {
        var data = {error: {}};
        /*
        if (text_area.val().trim() == '') {
            data.error[1] = "Por favor uma mensagem";
         }*/
        //if (inputFile.val() == '') {
            data.error[2] = "Por favor envie um arquivo";
        //}
        alert_box(data);
    } else {

        $("textarea, input, button", form).attr('disabled', 'disabled');

        $.ajax({
            url: 'ws/chat/save',
            data: formData,
            processData: false,
            type: 'POST',
            contentType: false,
            mimeType: 'multipart/form-data',
            success: function (response, textStatus) {

                if($("#comentAreaForm > .comment-area").attr('data-action') == 'redirect'){
                    var href = window.location.href;
                    var redirect = href.split("#")
                    window.location.href = redirect[0];
                }
                data = $.parseJSON(response);
                if (data.error) {
                    alert_box(data);
                    $("textarea, input, button", form).removeAttr('disabled');
                    return false;
                }

                var typeData = { broadType : 'post', msg : 'check_new', channel:$("#channel_id").val()};
                conn.sendMsg(typeData);

                $(form).find("textarea, input").val('');
                $("#modal-file:visible").modal("hide");


                $("textarea, input, button", form).removeAttr('disabled');

                $("#comentAreaForm textarea.comment-area").focus();

                $("#comentAreaForm input[name='chat_id']").val('0');

                //load_item(true, false, false);
            }
        });
    }

    return false;
}

function send_file() {
    $(".comment-box i.fa-plus").click(function () {
        $("#modal-file").modal("show");
        $("#modalFile textarea").val('').focus();
        $("#modalFile input[type='file']").val('').trigger('click').change(function () {
            $("#modalFile textarea").focus();
        });
    });
}

function blueimp_load(target) {
    var attrGallery = "[gallery-image]",
        $target = (target != undefined) ? $(target).find(attrGallery) : $(attrGallery);

    $target.click(function (event) {
        event = event || window.event;
        var target = event.target || event.srcElement,
            link = target.src ? target.parentNode : target,
            options = {index: link, event: event};
        [name = 'user_id[]']
        blueimp.Gallery($target, options);
        return false;
    });
}

var fix_ajax = 0;
function chat_update() {
    var $modal = $("#modal-channel-update"),
        $form = $("form", $modal),
        $type = $(".channel-type"),
        $name_channel = $(".channel-name", $modal),
        $description_channel = $(".channel-description", $modal),
        $list_users = $("select[name='user_id[]']", $modal),
        chatinfo_id = extract_url(1),
        me_user = me();

    if ($("#input_me", $form).length < 1) $form.append("<input id='input_me' type='hidden' name='user_id[]' value='" + me_user.id + "'>");


    $list_users.html('<option>Carregando...</option>');

    $name_channel.val('Carregando...').attr('disabled', 'disabled');
    $description_channel.val('Carregando...').attr('disabled', 'disabled');

    $("button[type='submit']", $form).attr('disabled', 'disabled');

    $modal.on('shown.bs.modal', function () {


        if(fix_ajax == 0){
            fix_ajax= 1;
        $.post('ws/chat/info', {chatinfo_id: chatinfo_id}, function (data) {

            var name = data.chatinfo.name,
                type = data.chatinfo.private,
                description = data.chatinfo.description,
                users = data.chatinfo.user,
                groups = data.chatinfo.group,
                users_inArray = [],
                groups_inArray = [],
                output = '',
                output_group = '';

            for (i in users) {
                users_inArray[users[i].user_id] = users[i].user_id;
            }

            for (i in groups) {
                groups_inArray[groups[i].group_id] = groups[i].group_id;
            }

            if(type == 1){
                $type.addClass('checked-input');
            }
            $name_channel.val(name).removeAttr('disabled');
            $description_channel.val(description).removeAttr('disabled');

                $.post("ws/user/get_basic/0/name_lastname_id?status=1&channel="+chatinfo_id, function (data_users) {


                    if (data_users.length > 0) {
                        $('#users-alter-channel').show();
                        for (i in data_users) {
                            data_users[i].selected = (users_inArray.length > 0 && $.inArray(data_users[i].id, users_inArray) >= 0) ? 'selected' : '';
                            if (data_users[i].id != me_user.id) {
                                $('#users-alter-channel').append('<option class="template" value="' + data_users[i].id + '" ' + data_users[i].selected + '>' + data_users[i].name + ' ' + data_users[i].lastname + '</option>');
                            }
                        }

                        $('#users-alter-channel').chosen().trigger("chosen:updated");
                        $('#users-alter-channel').removeAttr('disabled').chosen().trigger("chosen:updated");
                        $('.chosen-results').trigger("chosen:updated");
                        $('.chosen-results').attr('style',"display:none;");

                        $list_users.chosen({
                            no_results_text: "Oops, usuário não encontrado!",
                            allow_single_deselect: true
                        });

                        $("button[type='submit']", $form).removeAttr('disabled');
                    }
                });


        });
    }
    }).on('hidden.bs.modal', function () {
        //$list_users.chosen("destroy");
    });

    $form.submit(function () {


        var data = $(this).serializeArray();
        data.push({name: 'chatinfo_id', value: chatinfo_id});

        data = $.param(data);

        $("button[type='submit']", $form).attr('disabled', 'disabled');

        $.post('ws/chat/update', data, function (data) {
            if (data.error) {
                console.log(data.console);
                alert_box(data);
            } else {
                $modal.modal('hide');
                //if($(".alterChat").length > 0) $(".alterChat").closest('.alert').remove();
                alertMsg("<span class='alterChat'>Alterações realizadas com sucesso.</span>");
            }

            $("button[type='submit']", $form).removeAttr('disabled');
        });

        return false;
    })
}


function answer(item_id, user_username) {

    var item = '#item-post-' + item_id,
        chat_id = $(item).data('chat-id');
    $("#comentAreaForm input[name='reference']").val(chat_id);
    $("#comentAreaForm .comment-area").val('@' + user_username + ' ').trigger('click').focus();
}

function pins_post(pin_id) {
    var pin = '#item-post-' + pin_id,
        fk_id = pin_id,
        text = $(pin).find('.comment-chanel').text();

    $.post('ws/chat/favorite', {
        fk_id: fk_id,
        text: text
    }, function (data) {
        if (data.error) {
            alert_box(data);
            return false;
        } else {
            var chatsent = data.chatsent,
                favorites = data.favorites;
            $(pin).removeClass('pin-' + !chatsent.pin);
            $(pin).addClass('pin-' + chatsent.pin);
            show_pins(favorites);
        }
    });
}

function channel_info() {
    var $channel_info = $("#channel-info");

    $("#channel-info-button").click(function () {
        var info = $channel_info.data('info'),
            top = $("body > .header").height() + 40,
            min_width = 400,
            width = ($("#ui-layout-east").width() > min_width) ? $("#ui-layout-east").width() : min_width,
            css = {
                height: $(window).height() - (top + 20),
                width: width,
                top: top
            },
            output = '';

        if ($channel_info.hasClass('open')) {
            $channel_info.removeClass('open');
        } else {
            $channel_info.css(css).addClass('open', function () {

                info.title = (info.private == 1) ? '<i class="fa fa-lock" aria-hidden="true"></i> ' + info.name : '<i class="fa fa-hashtag" aria-hidden="true"></i> ' + info.name,
                    info.description = (info.description) ? "<p>" + info.description + "</p>" : "";
                info.total_users = (info.total_users == 1) ? info.total_users + " membro" : info.total_users + " membros";

                output = fill_template($channel_info, info, 'template-channel-info');

                $channel_info.html(output);

                $channel_info.find('.box h4 a').click(function () {
                    var term = ":Usuários do canal " + info.name + " (" + info.id + "):";

                    $('.header .navbar-right .search').val(term).keyup().focus();

                    return false;
                });

                $channel_info.find('.close').click(function () {
                    $channel_info.removeClass('open');

                    return false;
                });

            });
        }

        return false;
    });

    $(".btn-pin, .btn-mentions, .btn-files").click(function () {
        $channel_info.find('.close').trigger('click');
    });
}

function get_json_message(chat_id, chatinfo_id, adfterdate, beforedate) {
    $.post('ws/chat/get', {
        afterdate: "" + adfterdate + "",
        beforedate: "" + beforedate + "",
        chatinfo_id: chatinfo_id,
        chat_id: chat_id
    }, function (data) {
        if (data.error) {
            alert_box(data);
        } else {
            var title = (data.chatinfo.private == 1) ? '<i class="fa fa-lock" aria-hidden="true"></i> ' + data.chatinfo.name : '<i class="fa fa-hashtag" aria-hidden="true"></i> ' + data.chatinfo.name,
                total_users = data.chatinfo.total_users,
                posts = data.chat_list_datetime,
                output = '',
                limitMore = (beforeposts && data.limit > posts.length) ? false : true,
                more = (beforeposts && data.more != undefined) ? data.more : limitMore;

            $channel_info.data('info', data.chatinfo);

            $(".channel h1.title").html(title);

            $(".channel .participants-count").text(total_users + " Participantes").data('info', data.chatinfo);

            if (Object.keys(posts).length > 0) {

                for (d in posts) {

                    var date_divider = d.split('-'),
                        date_block_id = "date-" + d;

                    output = '';

                    date_divider = date_divider[2] + '/' + date_divider[1] + '/' + date_divider[0];

                    var html_date = "<div class=\"group-datetime\" id=\"" + date_block_id + "\">" +
                        "<div class=\"clearfix\"></div><h3>" + date_divider + "</h3>" +
                        "<div class=\"itens\"></div>" +
                        "<div class=\"clearfix\"></div></div>";


                    if ($list_posts.find("#" + date_block_id).length == 0) {
                        if (!$list_posts.hasClass('first-load-ok') || beforeposts) {
                            $list_posts.prepend(html_date);
                        } else {
                            $list_posts.append(html_date);
                        }
                    }

                    for (i in posts[d]) {

                        if (posts[d][i].reference) {
                            posts[d][i].reference_class = "show";
                            posts[d][i].reference_user_name = posts[d][i].reference.user_name + ' ' + posts[d][i].reference.user_lastname;
                            posts[d][i].reference_date = posts[d][i].reference.date;
                            posts[d][i].reference_hour = posts[d][i].reference.hour;
                            posts[d][i].reference_datetime = posts[d][i].reference.format_datetime;
                            posts[d][i].reference_text = posts[d][i].reference.text;
                        }
                        posts[d][i].delete_message = posts[d][i].id;
                        posts[d][i].complaint_message = posts[d][i].id;
                        posts[d][i].delete_mesage_ctrl = me().usertype_id == 2 || me().id == posts[d][i].user_id ? '' : 'hidden';
                        if (posts[d][i].file.format != "" && posts[d][i].file.format != undefined) {
                            if (posts[d][i].file.format == "image") {
                                fileName = posts[d][i].file.src;
                                fileName = fileName.split('/');
                                fileName = fileName.pop();
                                posts[d][i].file = '<a href="' + posts[d][i].file.src + '" style="background-image: url(' + posts[d][i].file.src + ')" data-gallery class="img-rounded img-ajuste"><img src="' + posts[d][i].file.src + '" class="img-responsive" alt=""></a>';
                            } else {
                                var permission = data.permission;
                                if(permission) {
                                    posts[d][i].file = '<a href="' + posts[d][i].file.src + '" download="' + posts[d][i].file.name + '"><span class="glyphicon glyphicon-save"></span> ' + posts[d][i].file.name + '</a>';
                                }else{
                                    posts[i].file = '<span class="glyphicon glyphicon-remove-circle"></span> Conteúdo Bloqueado.';
                                }
                            }
                        } else {
                            posts[d][i].file = "";
                        }


                        output = fill_template($list_posts, posts[d][i]) + output;
                    }

                    output = $.parseHTML(output);

                    if (beforeposts) {
                        $list_posts.find("#" + date_block_id).find(".itens").prepend(output);
                        if (more)$("#more-posts").removeClass('hide');
                    } else {
                        $list_posts.find("#" + date_block_id).find(".itens").append(output);
                    }
                }

                $list_posts.addClass('first-load-ok');

                blueimp_load($list_posts);

                if (chat_id) {
                    $chat_item = $('#item-post-' + chat_id);

                    if ($chat_item && $chat_item.length > 0) {

                        var bg_temp = "#d65a00",
                            bg_default = $chat_item.css('background-color'),
                            custom = get_custom();

                        if (custom) {
                            bg_temp = custom.color1;
                        }


                        $chat_item.addClass('focus_trans');

                        if(new_page !== true){
                            $chat_item.css({'background-color': bg_temp});
                        }

                        if(new_page) {
                            $('#ui-layout-center .scroll').animate({scrollTop:$('.conversations-list').height()*0.5},1000);
                        }else {
                            $('#ui-layout-center .scroll').animate({scrollTop: $chat_item.offset().top - (($chat_item.height() + $("#more-posts").height()) + 20)}, 0);
                        }
                    }

                } else if (!beforeposts && scroll) {

                    if (scroll_status) {
                        $('#ui-layout-center .scroll').animate({scrollTop: $($list_posts).height()}, 500);
                    }
                } else if (beforeposts) {
                    $('#ui-layout-center .scroll').animate({scrollTop: itemscroll.offset().top - ((itemscroll.height() + $("#more-posts").height()) + 20)}, 0);

                } else {
                    $('#ui-layout-center .scroll').scrollTop($($list_posts).height());
                }

                $list_posts.find('.emojiChat.not-loaded').removeClass('not-loaded').emoji({
                    action: 'click mouseover',
                    position: 'bottom-right',
                    callback: function (element, contanier) {

                        var $chat = $(this).closest('.item'),
                            chat_id = $chat.data('chat-id'),
                            emoji_id = element.id,
                            $localemoji = $chat.find('li.emojichat');

                        $.post('ws/emojichat/save',
                            {
                                chat_id: chat_id,
                                emoji_id: emoji_id
                            },
                            function (data) {
                                if (data.error) {
                                    alert_box(data);
                                    return false;
                                } else {

                                    load_emoji_chat($localemoji, data.emojichat);
                                }
                            });

                        contanier.hide();
                    }
                });

                $(output).find(".menu-item.dropdown > a").on('mouseover', function () {
                    if (!$(this).parent().hasClass('open')) $(this).trigger('click');
                });

                if (data.chat_list_datetime && data.chat_list_datetime.length > 0) {
                    for (i in data.chat_list_datetime) {
                        var $chat = $(output).filter(".item[data-chat-id=" + data.chat_list_datetime[i].id + "]"),
                            $localemoji = $chat.find('.emojichat');

                        load_emoji_chat($localemoji, data.chat_list_datetime[i].emoji);
                    }
                }

                $(".new-channel").hide();
            }
            else if (!scroll && !beforeposts) {
                $(".new-channel").show().find(".insert-name").html(title);
            }

            if (chat_id) {
                $('#ui-layout-center .scroll').scroll(function() {
                    if($('#ui-layout-center .scroll').scrollTop() + $('#ui-layout-center .scroll').height() === $('#ui-layout-center .scroll > div').height()) {
                        if(chat_id != $('.channel-message:last').attr('value')){
                        }
                    }
                });

                //load_item(true, false, false);

            } else if (!beforeposts) {
                setTimeout(function () {
                    load_item(true, false, false);
                }, time_out);

            }
        }
    });

}