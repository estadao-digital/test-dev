
$.wait = function( callback, seconds){
    return window.setTimeout( callback, seconds * 1000 );
};

var conn = new Connection2("socket.beedoo.io:2000");

$.wait( function(){
    var typeData = { 'Register' : true, user_id : $("#user_id").val(), channel: $("#channel_id").val(), team_id: $("#team_id").val()};
    conn.sendMsg(typeData);
}, 2);

$(function () {
    $('#ui-layout-center .scroll').scroll(function () {
        if ($('#ui-layout-center .scroll').scrollTop() + $('#ui-layout-center .scroll').height() - 60 === $('#ui-layout-center .scroll > div').height()) {
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
        at: ":",
        searchKey: 'q',
        minLen: 1,
        insertTpl: ":${name}:",
        displayTpl: "<li class='emojis'><p><img src='${img}'> ${name} ${lastname}</p><div class='clearfix'></div></li>",
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

    $('.conversations-list').on('click','.complaint_denouncer, .complaint_denounced, .complaint_denounced_leader', function () {
        $.ajax({
            type: 'POST',
            url: "./help/moderation/get_detail",
            data: {id: $(this).data('id')},
            dataType: 'json',
            success: function (data) {
                $('#complaits_detail_user').children().remove();
                $.each(data.data,function () {
                    $('#complaits_detail_user').append('<ul><li>Data: '+this.created+'</li><li>Local: '+this.local+' - '+this.title+'</li><li>Nome do Denúnciado: '+this.name+' '+this.lastname+'</li><li>Mensagem: '+ this.message +'</li></ul>');
                });
                $("#complaits_type").modal('show');
            }
        });
        $("#complaint_detail").modal('show');
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

    send_file();
    load_item(false, false);
});

function load_item(scroll, beforeposts) {
    var time_out = 2000,
        $list_posts = $(".message .group-itens"),
        firstpost = $(".item:first-child", $list_posts).data('datetime'),
        lastpost = $(".item:last-child", $list_posts).data('datetime');

    var adfterdate = (!beforeposts && lastpost != "{{datetime}}") ? lastpost : '';
    var beforedate = (beforeposts && firstpost != "{{datetime}}") ? firstpost : '';

    var itemscroll = $(".item:first-child", $list_posts);
    if (beforeposts) $("#more-posts").addClass('hide');
    if (beforeposts != '') $(".load-chat").show();

    $.post('ws/dm/get/', {
            afterdate: "" + adfterdate + "",
            beforedate: "" + beforedate + "",
            friend_username: get_friend_username()
        },
        function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                var title = data.friend.name + ' ' + data.friend.lastname,
                    posts = data.list,
                    output = '',
                    fileName;
                var limitMore = (beforeposts && data.limit > posts.length) ? false : true;
                var more = (beforeposts && data.more != undefined) ? data.more : limitMore;

                $(".message h1.title").text(title);

                if (posts.length > 0) {
                    for (i in posts) {
                        posts[i].receiver_img = posts[i].receiver_img === null ? './assets/img/user_pic.jpg' : posts[i].receiver_img;
                        posts[i].sender_img = posts[i].sender_img === null ? './assets/img/user_pic.jpg' : posts[i].sender_img;
                        posts[i].is_shared_wiki = 'false';
                        posts[i].not_shared_wiki = 'true';

                        if (posts[i].sharedwiki_id && posts[i].sharedwiki_id != null && posts[i].sharedwiki_id != false) {
                            posts[i].is_shared_wiki = 'true';
                            posts[i].not_shared_wiki = 'false';
                            posts[i].sample_article = posts[i].sharedwiki_id.text;
                            posts[i].title_article = posts[i].sharedwiki_id.title;
                            posts[i].link_article = posts[i].sharedwiki_id.link;
                        }

                        if (posts[i].file.format != "" && posts[i].file.format != undefined) {
                            if (posts[i].file.format == "image") {
                                fileName = posts[i].file.src;
                                fileName = fileName.split('/');
                                fileName = fileName.pop();
                                posts[i].file = '<a href="' + posts[i].file.src + '" style="background-image: url(' + posts[i].file.src + ')" data-gallery class="img-rounded img-ajuste"><img src="' + posts[i].file.src + '" class="img-responsive" alt=""></a>';
                            } else {
                                var permission = data.permission;
                                if(permission) {
                                    posts[i].file = '<a href="' + posts[i].file.src + '" download="' + posts[i].file.name + '"><span class="glyphicon glyphicon-save"></span> ' + posts[i].file.name + '</a>';
                                }else{
                                    posts[i].file = '<span class="glyphicon glyphicon-remove-circle"></span> Conteúdo Bloqueado.';
                                }
                            }
                        } else {
                            posts[i].file = "";
                        }
                        /*if (posts[i].sender == data.friend.id) {
                         notification_sound();
                         }*/
                        output = fill_template($list_posts, posts[i]) + output;
                    }

                    output = $.parseHTML(output);

                    if (beforeposts) {
                        $list_posts.prepend(output);
                        if (more) $(".load-chat").show();
                    } else {
                        $list_posts.append(output);
                    }

                    blueimp_load($list_posts);

                    if (!beforeposts && scroll && $('#ui-layout-center .scroll:hover').length < 1 || $("#comentAreaForm:hover").length > 0) {
                        $('#ui-layout-center .scroll').animate({scrollTop: $($list_posts).height()}, 500);
                    } else if (beforeposts) {
                        $('#ui-layout-center .scroll').animate({scrollTop: itemscroll.offset().top - ((itemscroll.height() + $("#more-posts").height()) + 20)}, 0);
                    } else {
                        $('#ui-layout-center .scroll').animate({scrollTop: $($list_posts).height()}, 100);
                    }
                }
                /*if (!beforeposts) setTimeout(function () {
                    load_item(true, false);
                }, time_out);*/

                //list_users(true);
                localStorage.removeItem('n_dm_' + get_friend_username());
                $(".load-chat").hide();
            }
        });
}

function get_friend_username() {
    var friend_username = extract_url('last');
    return (friend_username != '' && friend_username != null && friend_username != undefined) ? friend_username : 0;
}

function send_message(form_id) {
    var $list_posts = $(".message .group-itens");
    var form = $("#" + form_id);
    var formData = new FormData(document.getElementById(form_id));
    formData.append('friend_username', get_friend_username());
    var text_area = $("textarea.comment-area", form);
    var inputFile = $("input[name='file']", form);


    if (text_area.val().trim() == '' || inputFile.val() == '') {
        var data = {error: {}};

        if (text_area.val().trim() == '') {
            data.error[1] = "Por favor uma mensagem";
        }

        if (inputFile.val() == '') {
            data.error[2] = "Por favor envie um arquivo";
        }

        alert_box(data);

    } else {

        $("textarea, input, button", form).attr('disabled', 'disabled');
        $.ajax({
            url: 'ws/dm/save',
            data: formData,
            processData: false,
            type: 'POST',
            contentType: false,
            mimeType: 'multipart/form-data',
            success: function (response, textStatus) {
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
    var attrGallery = "[data-gallery]";
    var $target = (target != undefined) ? $(target).find(attrGallery) : $(attrGallery);

    $target.click(function (event) {
        event = event || window.event;
        var target = event.target || event.srcElement,
            link = target.src ? target.parentNode : target,
            options = {index: link, event: event};
        blueimp.Gallery($target, options);
        return false;
    });
}


function modal_complaint_message(message_id) {
    var complaint_button = '<button type="button" class="oi btn btn-orange" onclick="complaint_message(' + message_id + ')">Denunciar</button>';
    $('#complaint-footer').html(complaint_button);
    $('#complaint_modal').modal('show');
};

function complaint_message(message_id) {
    if($('#complaint_type option:selected').val() > 0){
        var message = '#item-post-' + message_id;
        $.post('ws/dm/complaint/' + message_id + '',{'type':$('#complaint_type option:selected').val(), 'description':$('#complaint_description').val()});
        $(message).css("border", "1px solid red");
        $(message + " > .conversations-info > .row > .conversations-name").append('<i title="Comentário denúnciado!" class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
        $("#complaint_modal").modal('hide');
    }else{
        $("#complaint_valid").removeClass("hide");
    }
};

