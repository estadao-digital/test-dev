$(function () {
    $('.btn-pin').click(function () {
        $('.box-2 .pins').show('fast');
        $('.box-2 .mentions, .box-2 .files').hide('fast');
        $('.btn-mentions,.btn-files').addClass('go-right');
        $('.btn-pin').removeClass('go-right');
    });
    $('.btn-mentions').click(function () {
        var notification_localStorage_id = $(this).data('local-storage-id');

        $('.box-2 .mentions').show('fast');
        $('.box-2 .pins,.box-2 .files').hide('fast');
        $('.btn-pin, .btn-files').addClass('go-right');
        $('.btn-mentions').removeClass('go-right');

        $.get('ws/mention/read', function () {
            number_mentions(0);
        });

        clean_notifications(notification_localStorage_id);
    });

    $('.btn-files').click(function () {
        $('.box-2 .files').show('fast');
        $('.box-2 .pins, .box-2 .mentions').hide('fast');
        $('.btn-pin,.btn-mentions ').addClass('go-right');
        $('.btn-files').removeClass('go-right');
    });

    $('#modal-share').on('hide.bs.modal', function () {
        $('#modal-share .form-users').hide();
        $('#modal-share .form-channels').hide();
        document.getElementById("modalShareFile").reset();
    });

    $('#modal-newfile').on('hide.bs.modal', function () {
        $('#modal-newfile .form-users').hide();
        $('#modal-newfile .form-channels').hide();
        document.getElementById("modalNewFile").reset();
    });

    var $selectNewFile = $('#modal-newfile #type-share');
    $selectNewFile.on('change', function () {
        var value = $(this).val();
        if (value === '1') {
            $('#modal-newfile .form-users').show();
            $('#modal-newfile .form-channels').hide();
        } else if (value === '2') {
            $('#modal-newfile .form-users').hide();
            $('#modal-newfile .form-channels').show();
        } else {
            $('#modal-newfile .form-users').hide();
            $('#modal-newfile .form-channels').hide();
        }
    });

    var $selectShare = $('#modal-share #type-share');

    $selectShare.on('change', function () {
        var value = $(this).val();
        if (value === '1') {
            $('#modal-share .form-users').show();
            $('#modal-share .form-channels').hide();
        } else if (value === '2') {
            $('#modal-share .form-users').hide();
            $('#modal-share .form-channels').show();
        } else {
            $('#modal-share .form-users').hide();
            $('#modal-share .form-channels').hide();
        }
    });

    $('.new-file a').click(function (event) {
        event.preventDefault();
        var $modal = $('#modal-newfile');
        $modal.modal('show');
        $('.btn-share', $modal).click(function () {
            event.preventDefault();

            var validate = $('#input-newfile').val();
            var type = $('#type-share').val();

            if (validate === '') {
                var data = {error: {1: 'Selecione um arquivo'}};
                alert_box(data);
            }
            else {
                sendFileModalNewFile($modal);
            }
        });
    });

    $(document).ready(function () {
        load_files();
        loadMentions();
        load_pins();
        loadChannels();
        //loadUsers();

        $('.mention-force-click').click();
    });

    $(".mybox").simpleSwitch();

    $("input[name='lidas'],input[name='respondidas']").change(function () {
        loadMentions('write');
    });

});

function sendFileModalNewFile() {
    var users = [];

    $('#modalNewFile #check-message option:selected').each(function () {
        users.push({'id': this.value, 'username': $(this).data('username')});
    });

    if ($('#modal-newfile #type-share').val() === '1') {

        var formData = new FormData(document.getElementById('modalNewFile'));
        for (i in users) {
            formData.append('id', users[i].id);
            formData.append('text', 'Novo arquivo compartilhado');
            formData.delete('type-share2');
            formData.delete('channel');
            formData.append('friend_username', users[i].username);
        }

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
                    return false;
                } else {
                    window.location = './message/' + data.friend.username
                }
            }
        });
    } else if ($('#modal-newfile #type-share').val() === '2') {
        var channel = $('#modalNewFile #check-channel option:selected').val();
        var formData = new FormData(document.getElementById('modalNewFile'));
        formData.append('chatinfo_id', channel);
        formData.append('text', 'Novo arquivo compartilhado');
        formData.delete('type-share2');
        formData.delete('message');
        $.ajax({
            url: 'ws/chat/save',
            data: formData,
            processData: false,
            type: 'POST',
            contentType: false,
            mimeType: 'multipart/form-data',
            success: function (response, textStatus) {
                data = $.parseJSON(response);
                if (data.error) {
                    alert_box(data);
                    return false;
                } else {
                    var my_channel = data.chatinfo;
                    $.post('ws/chat/possible',
                        function (data) {
                            var channels = data.chatinfo;
                            for (i in channels) {
                                if (my_channel.id === channels[i].id) {
                                    window.location = './channel/' + channels[i].id + '/' + channels[i].name_sanitized;
                                }
                            }
                        });
                }
            }
        });
    } else {
        var data = {error: {1: 'Selecione com quem compartilhar'}};
        alert_box(data);
    }
}


function sendFileModalShare() {
    var users = [];
    $('#check-message option:selected').each(function () {
        users.push({'id': this.value, 'username': $(this).data('username')});
    });
    if ($('#modal-share #type-share').val() === '1') {
        var formData = new FormData(document.getElementById('modalShareFile'));
        for (i in users) {
            formData.append('id', users[i].id);
            formData.append('text', 'Novo arquivo compartilhado');
            formData.delete('type-share');
            formData.delete('channel');
            formData.append('friend_username', users[i].username);
            formData.append('id_file', $('#modal-share').find('.pad0').data('id'));
        }
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
                    return false;
                } else {
                    window.location = './message/' + data.friend.username
                }
            }
        });
    } else if ($('#modal-share #type-share').val() === '2') {
        var channel = $('#check-channel option:selected').val();
        var formData = new FormData(document.getElementById('modalShareFile'));
        formData.append('chatinfo_id', channel);
        formData.append('text', 'Novo arquivo compartilhado');
        formData.append('file_id', $('#modal-share').find('.pad0').data('id'));
        formData.delete('type-share');
        formData.delete('message');
        $.ajax({
            url: 'ws/chat/save',
            data: formData,
            processData: false,
            type: 'POST',
            contentType: false,
            mimeType: 'multipart/form-data',
            success: function (response, textStatus) {

                data = $.parseJSON(response);
                if (data.error) {
                    alert_box(data);
                    return false;
                } else {
                    var my_channel = data.chatinfo;
                    $.post('ws/chat/possible',
                        function (data) {
                            var channels = data.chatinfo;
                            for (i in channels) {
                                if (my_channel.id === channels[i].id) {
                                    window.location = './channel/' + channels[i].id + '/' + channels[i].name_sanitized;
                                }
                            }
                        });
                }
            }
        });
    } else {
        var data = {error: {1: 'Selecione com quem compartilhar'}};
        alert_box(data);
    }
}
function loadUsers() {
    $.post('ws/user/get_basic/0/name_lastname_username_id',
     function (data) {
         for (i in  data) {
             if (data[i].id === me().id) {
                 data.splice(i, 1);
                 if (data.error) {
                     alert_box(data);
                     return false;
                 } else {
                     var $select = $('.modal-share #check-message');
                     var $select2 = $('.modal-newfile #check-message');
                     list_chosen($select, data);
                     list_chosen($select2, data);
                 }
             }
         }
     });
}

function loadChannels() {
    $.post('ws/chat/possible',
        function (data) {
            if (data.error) {
                alert_box(data);
                return false;
            }
            else {
                var $select = $('.modal-share #check-channel');
                var $select2 = $('.modal-newfile #check-channel');
                list_chosen($select, data.chatinfo);
                list_chosen($select2, data.chatinfo);
            }
        });
}
//---------------------------------------------------------------------------------------------------------
file_offset = 0;
function load_files(type) {
    if (typeof(type) === 'undefined') {
        type = 'write';
    }
    file_limit = 8;
    $.get('ws/file/shared', {offset: file_offset, limit: file_limit},
        function (data) {
            if (data.error) {
                alert_box(data);
                return false;
            } else {
                if (data.file.length == 0 || data.file.length < file_limit - 1) {
                    $(".more-files").hide();
                } else {
                    $(".more-files").show();
                }
                show_files(data.file, type);
                file_offset += file_limit;
            }
        }
    );
}
//---------------------------------------------------------------------------------------------------------
function show_files(data, type) {
    var $list_item_files = $('.files-list');
    var output = '';
    get_template($list_item_files, 'template-files');
    if ($list_item_files.length > 0) {
        if (data != undefined && data.length > 0) {
            for (i in data) {
                var chat_name = [];
                if (data[i].chat.length > 0) {
                    for (c in data[i].chat) {
                        chat_name[c] = data[i].chat[c].name;
                    }
                }
                data[i].chat_name = chat_name.join(', ');
                output += fill_template($list_item_files, data[i], 'template-files');
            }
        } else {
            $list_item_files = $('.side-file');
            output = "<p class=\"col-md-12\">Você não tem nenhum arquivo aqui ainda. Compartilhe não apenas suas mensagens, mas todos os seus arquivos, imagens, PDFs, documentos, planilhas podem ser compartilhados com 	quem quiser.</p>";
        }

        output = $.parseHTML(output);

        if (type == 'write') {
            $list_item_files.html(output);
        } else {
            $list_item_files.append(output);
        }

        $list_item_files.find('.item .share-files').click(function () {
            var $modal = $('#modal-share');
            modalfiles($(this), data, $modal, type);
        });

        $list_item_files.find('.item .trash-files').click(function () {
            $(".files_id"+$(this).attr('id')).hide(1000);

            $.get('ws/file/deleteUserFileRelation/'+$(this).attr('id'), function (data) {
            });

        });
    }
}
function modalfiles($file, data, $modal, $type) {
    var $file = $file.closest('.item'),
        $item = $('.item_file'),
        file_id = $file.data('file_id').toString(),
        output = '';

    get_template($item);

    for (i in data) {

        if (file_id === data[i].id) {
            output += fill_template($item, data[i]);
        }
    }

    output = $.parseHTML(output);
    if ($type == 'write') {
        $item.html(output);
    } else {
        $item.append(output);
    }

    $('.btn-share', $modal).click(function () {
        event.preventDefault();
        var type = $('#type-share').val();
        sendFileModalShare();
    });

    //load_shareable(data);
}
function load_shareable(file) {
    $.post('ws/chat/possible',
        function (data) {
            if (data.error) {
                alert_box(data);
                return false;
            }
            else {
                //sent_shared(data, file);
            }
        });
}
function sent_shared(data) {
    var $select = $('#check-share'),
        data = data.chatinfo;
    list_chosen($select, data);
}
function list_item($item, data) {
    var output = '';
    get_template($item);
    $item.html('');
    for (i in data) {
        output += fill_template($item, data[i]);
    }
    output = "<option></option>" + output;
    $item.append(output);
}
function list_chosen($item, data) {
    var output = '';

    get_template($item);

    $item.html('');

    for (i in data) {
        output += fill_template($item, data[i]);
    }

    output = "<option></option>" + output;
    $item.append(output);

    $item.chosen({
        no_results_text: "Oops, usuário não encontrado!"
    });

}

loading_mentions = false;
mentions_reset = true;

var limit = 8;
mentions_offset = 0;
function loadMentions(fill_mode) {
    if (typeof(fill_mode) === 'undefined') fill_mode = 'write';
    loading_mentions = true;
    $list_item = $('.list-mentions');
    var read = false;
    var replied = false;
    if ($("input[name='lidas']:checked").length > 0) {
        read = true;
    }
    if ($("input[name='respondidas']:checked").length > 0) {
        replied = true;
    }
    if (fill_mode == 'write') {
        mentions_offset = 0;
        $list_item.hide();
    } else {
        mentions_offset += limit;
    }
    $.get('ws/mention/get', {
        read: read,
        replied: replied,
        limit: limit,
        offset: mentions_offset
    }, function (data) {
        if (data["mention"].length == 0 || data["mention"].length < limit - 1) {
            $(".more-mentions").hide();
        } else {
            $(".more-mentions").show();
        }
        var data = data.mention;

        loadMentionsItem(data, fill_mode);
        if (fill_mode == 'write') {
            $list_item.fadeIn("slow");
        }
        loading_mentions = false;
    });
}

function number_mentions(number) {
    var $mentions_badge = $(".box-2 .nav-right .btn-mentions .badge");

    if (number > 0) {
        $mentions_badge.text(number).removeClass('hide');
    } else {
        $mentions_badge.addClass('hide');
    }
}


function delete_notification(notification) {
    $.get('ws/mention/delete_notification', {notification: notification}, function (data) {
        var data = data.mention;
        loadMentions();
        $list_item.fadeIn("slow");
        loading_mentions = false;
    });
}

function delete_pin(pid,uid) {
    $.get('ws/favorite/delete_pin/'+pid+'e'+uid, function (data) {
        load_pins();
        $list_item.fadeIn("slow");
        loading_mentions = false;
    });
}

function loadMentionsItem(data, type) {
    var $list_item_mentions = $('.list-mentions'),
        notification_localStorage_id = $('.btn-mentions').data('local-storage-id'),
        output = '',
        number_mentions_ini = 0,
        notification = [];
    get_template($list_item_mentions, 'template-mention');

    if (data.length > 0) {
        for (i in data) {
            if (data[i].target == 'postcomment') {
                data[i].info_text = data[i].detail.info ? "Post: " + data[i].detail.title : '';

            }
            if (data[i].target == 'chat') {
                data[i].info_text = data[i].detail.info ? "Canais: " + data[i].detail.info.name : '';
            }
            data[i].desativado = '';
            data[i].width1 = '90%';
            data[i].width2 = '0';
            if (data[i].detail.info.status == 0) {
                data[i].desativado = ' (Desativado)';
                data[i].width1 = '66%';
                data[i].width2 = '32%';
            }

            data[i].is_read = '';
            var datetime = data[i].datetime;
            if (data[i].read) {
                data[i].is_read = ' is_read ';
            } else {
                data[i].is_read = ' not_read ';
            }
            if (data[i].replied) {
                data[i].is_replied = ' is_replied ';
            } else {
                data[i].is_replied = ' not_replied ';
            }
            data[i].datetime = datetime.split(' ', 2);
            data[i].hour = data[i].datetime[1];
            var hour = data[i].hour;
            data[i].hour = hour.split(':', 3);
            data[i].hour = data[i].hour[0] + 'h' + data[i].hour[1];
            data[i].date = data[i].datetime[0];
            var date = data[i].date;
            data[i].date = date.split('-', 3);
            data[i].date = data[i].date[2] + '/' + data[i].date[1] + '/' + data[i].date[0];
            data[i].friend_mention = data[i].detail.user_name + ' ' + data[i].detail.user_lastname;
            data[i].image_friend_mention = data[i].detail.user_img ? data[i].detail.user_img : './assets/img/user_pic.jpg';
            data[i].detail_user_id = data[i].detail.user_id;
            data[i].classes += "";
            data[i].classes += (data[i].read != null && data[i].read != 'NULL' && data[i].read != '') ? " read " : "";
            data[i].classes += (data[i].read != null && data[i].read != 'NULL' && data[i].read != '') ? " read " : "";
            data[i].classes += (data[i].read != null && data[i].read != 'NULL' && data[i].read != '') ? " read " : "";
            if (!data[i].read) {
                number_mentions_ini = number_mentions_ini + 1;
                notification[i] = {
                    id: data[i].id,
                    title: "Mention: " + data[i].friend_mention + " - " + data[i].date + " " + data[i].hour,
                    text: data[i].text,
                    icon: data[i].image_friend_mention,
                    link: data[i].url
                };
            }
            output += fill_template($list_item_mentions, data[i], 'template-mention');
        }
    } else {
        output = '<p>Você não tem nenhuma mentions ainda. Quando alguém menciona pelo nome essa mensagem aparecerá aqui.</p>';
    }
    number_mentions(number_mentions_ini);
    //if (notification.length > 0) notifications(notification, notification_localStorage_id);

    output = $.parseHTML(output);
    if (type == "write") {
        $list_item_mentions.html(output);
    } else if ("add") {
        $list_item_mentions.append(output);
    }
}
offset_pins = 0;
function load_pins(type) {
    pins_limit = 8;
    if (typeof(type) === 'undefined') {
        type = 'write';
    }
    if (type == 'write') {
        offset_pins = 0;
        $list_item.hide();
    } else {
        offset_pins += pins_limit;
    }

    $.get('ws/post/get_favorites', {limit: pins_limit, offset: offset_pins}, function (data) {
        if (data.error) {
            alert_box(data);
            return false;
        } else {
            if (data["favorites"].length == 0 || data["favorites"].length < pins_limit - 1) {
                $(".more-pins").hide();
            } else {
                $(".more-pins").show();
            }
            show_pins(data.favorites, type);
        }
    });
}

function show_pins(data, type) {
    if (typeof(type) === 'undefined') type = 'write';
    var $pinlist_item = $('.pins-list');
    var output = '';

    get_template($pinlist_item, 'template-post');
    if (data.length > 0) {
        for (i in data) {
            var hour = data[i].hour;
            data[i].hour = hour.split(':', 2);
            data[i].hour = hour[0] + hour[1] + "h" + hour[3] + hour[4];

            if (data[i].target === 'chat') {
                data[i].icon = data[i].detail.user_img;
                data[i].chatroom = data[i].detail.info ? data[i].detail.info.name : '';
                data[i].text = data[i].detail.text;
                data[i].datetime = Date(data[i].detail.datetime);
                data[i].nickname = data[i].detail.user_name;
                data[i].post_text = '';
                data[i].info_text = data[i].detail.info ? "Canais: " + data[i].detail.info.name : '';
            }
            if (data[i].target === 'post') {
                data[i].nickname = data[i].detail.title;
                data[i].text = data[i].detail.text;
                data[i].icon = data[i].detail.icon;

                data[i].info_text = data[i].detail.info ? "Post: " + data[i].detail.title : '';
            }
            output += fill_template($pinlist_item, data[i], 'template-post');
        }
    }
    else {
        output = '<p>Você não pinou quaisquer mensagens ou arquivos ainda. Talvez agora seja o momento de começar .  Você pode adicionar um pin a mensagens , arquivos, trechos , posts, comentários... praticamente qualquer coisa no Beedoo. Pinar torna as coisas mais fáceis de encontrar: eles vão aparecer aqui nesta lista.</p>';
    }
    output = $.parseHTML(output);

    if (type == 'write') {
        $pinlist_item.html(output);
    } else {
        $pinlist_item.append(output);
    }

    $(".list-mentions").show();
}

function checkAllRead() {
    mentions = [];
    $.each($(".list-mentions .item"), function (item, obj) {
        mentions.push($(this).data("mention_id"));
    });
    $.get('ws/mention/setAllRead', {mentions: mentions}, function (data) {
        if (data.error) {
            alert_box(data);
            return false;
        } else {
            loadMentions();
            alert_box("Todas as notificações foram marcadas como lidas");
            return false;
        }
    });
}