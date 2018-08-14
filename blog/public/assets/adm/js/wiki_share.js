/**
 * Created by user on 07/03/2017.
 */
data_current_wiki = [];

$("input[name='share'][value='feed']").click(function () {
    $(".groups").show();
    $(".chats").hide();
});
$("input[name='share'][value='chat']").click(function () {
    $(".groups").hide();
    $(".chats").show();
});

$(".btn-share,.btn-edit-before-share").click(function (e) {
    e.preventDefault();
    if ($(".share_comment").val() == '') {
        alert_box({error: ["Digite algo neste POST."]});
        return;
    }
    if ($('.input-share').length) {
        if (checar($('.input-share'), 3) == false) {
            return false;
        }
    }
    editBefore = false;
    if ($(this).hasClass("btn-edit-before-share")) {
        editBefore = true;
    }
    op = $("#tab-wiki li.active a").attr("href");
    $('.now_loading').css("display", "block");
    opcoes = [];
    switch (op) {
        case "#feed": {
            if ($(".groups :selected").length == 0) {
                $('.now_loading').css("display", "none");
                alert_box({error: ["Selecione ao menos um grupo."]});
                return;
            }
            $(".groups :selected").each(function (i, selected) {
                opcoes[i] = $(selected).val();
            });
            fd = new FormData();
            fd.append('img', $(".input-share")[0].files[0]);
            fd.append("title", data_current_wiki["title"]);
            fd.append("text", $(".share_comment").val());
            fd.append("status", 1);
            fd.append("shared_wiki", data_current_wiki["id"]);
            fd.append("iconpost_id", 1);
            fd.append("group_id", opcoes);
            $.ajax({
                url: 'ws/post/save',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (response, textStatus) {
                    $('.now_loading').css("display", "none");
                    if (editBefore) {
                        post_id = response["id"];
                        url = "/adm/post/alterar/" + post_id;
                        window.location.replace(url);
                    }
                    $('#modal-share-options').modal('hide');
                    alertMsg(response["msg"]);
                },
                error: function (response) {
                    //alert("Erro: " + JSON.stringify(response));
                }
            });

        }
            break;
        case "#channel": {
            if ($(".chats :selected").length == 0) {
                $('.now_loading').css("display", "none");
                alert_box({error: ["Selecione ao menos um canal."]});
                return;
            }
            $(".chats :selected").each(function (i, selected) {
                opcoes[i] = $(selected).val();
            });
            fd = new FormData();
            fd.append('file', $(".input-share")[0].files[0]);
            fd.append("text", $(".share_comment").val());
            fd.append("shared_wiki", data_current_wiki["id"]);
            fd.append("chatinfo_id", opcoes);
            fd.append("reference", 0);
            $.ajax({
                url: 'ws/chat/save_batch/',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (response, textStatus) {
                    $('.now_loading').css("display", "none");
                    $('#modal-share-options').modal('hide');
                    alertMsg(response["msg"]);
                }
            });
        }
            break;
        case "#chat": {
            if ($(".users :selected").length == 0) {
                $('.now_loading').css("display", "none");
                alert_box({error: ["Selecione ao menos um usuário."]});
                return;
            }
            $(".users :selected").each(function (i, selected) {
                opcoes[i] = $(selected).val();
            });
            fd = new FormData();
            fd.append('file', $(".input-share")[0].files[0]);
            fd.append("text", $(".share_comment").val());
            fd.append("sharedwiki_id", data_current_wiki["id"]);
            fd.append("no_user_name_needed", true);
            fd.append("receiver", opcoes);
            $.ajax({
                url: 'ws/dm/save_with_wiki/',
                data: fd,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (response, textStatus) {
                    $('.now_loading').css("display", "none");
                    $('#modal-share-options').modal('hide');
                    alertMsg(response["msg"]);
                }
            });
        }
            break;
    }
});

function get_article_info(id) {
    $('#modal-share-options').modal('show');
    $('#share_wiki_id').val(id);

    $.get('ws/help/getById/' + id, function (data) {
        data_current_wiki = JSON.parse(data);
        data_current_wiki["id"] = id;
        $(".wiki_sample h5.titulo").text(data_current_wiki["title"]);
        $(".wiki_sample h6.subtitulo").html(data_current_wiki["text"]);
    });
}

$(".add_foto").click(function () {
    $(".upload-alert").show();
    $(".added-photo").show();
    $(this).hide();
});
$("#cancel-upload-icon").click(function () {
    $(".add_foto").show();
    $(".upload-alert").hide();
    $(".added-photo").hide();
});