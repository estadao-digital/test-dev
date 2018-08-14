$(function () {
    blueimp_load();
        iconpost($("#iconpost_id").data('iconpost_id'));

    $('#datetimepicker1').datetimepicker({
        locale: 'pt-br',
        format: 'YYYY-MM-DD HH:mm:00',
        ignoreReadonly: true,
        allowInputToggle: true
    });

    $(".delete-icon.img, .abort-delete.img").click(function () {
        if ($(this).hasClass('delete-icon')) {
            $(".delete-icon.img").hide();
            $(".faixa.img").show();
            $("input[name='delete_img']").val($(this).data('src'));
        } else {
            $(".delete-icon.img").show();
            $(".faixa.img").hide();
            $("input[name='delete_img']").val('');
        }
    });

    $(".delete-icon.vid, .abort-delete.vid").click(function () {
        if ($(this).hasClass('delete-icon')) {
            $(".delete-icon.vid").hide();
            $(".faixa.vid").show();
            $("input[name='delete_video']").val($(this).data('src'));
        } else {
            $(".delete-icon.vid").show();
            $(".faixa.vid").hide();
            $("input[name='delete_video']").val('');
        }
    });

    $("#form-post").submit(function () {
        $(this).find('[type="submit"]').prop('disabled', true);
    });

    check_comment();

    $('[name="comment"]').change(function () {
        check_comment();
    });

    $('[name="quiz"]').change(function () {
        check_quiz();
    });

    $jwplayer_init = $("#preview-video .jwplayer-init");

    if ($jwplayer_init.length > 0) {
        initPlay($jwplayer_init);
    }

});

function check_comment() {
    if ($('[name="comment"]:checked').val() == 1) {
        $(".comment-quiz").removeClass('hide');
        check_quiz();
    } else {
        $(".comment-quiz").addClass('hide');
    }
}

function check_quiz() {
    var $quiz_select = $('[name="quiz_id[]"]');

    $quiz_select.chosen('destroy');

    $quiz_select.prop('required', $('[name="quiz"]:checked').val() == 1).on('chosen:ready', function (evt, params) {
        var $select = $(this),
            $chosen = params.chosen.container;

        if ($select.attr('required') != undefined) {
            $select.insertAfter($chosen);
            $select.addClass('select-chosen-required');
        }
    }).chosen();
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

function iconpost(icon_default_id) {
    var $item = $('.item.icons'),
        icon_default_id = (icon_default_id == undefined) ? 1 : icon_default_id;

    $.get('./ws/iconpost/get', function (data) {
        var data = data.iconpost,
            $icon_default = $item.find('.icon-default'),
            $list_icon = $icon_default.find('.list-icon'),
            list_icon_output = '',
            icon_default_output = '',
            icon_default = null;

        for (i in data) {
            var icon = {
                list_iconpost_id: data[i].id,
                list_iconpost_src: data[i].src,
                span_delete: (data[i].id != 1) ? '<span class="delete-icon"><i class="fa fa-trash"></i></span>' : ''
            };

            if (data[i].id == icon_default_id) icon_default = {
                iconpost_id: data[i].id,
                iconpost_src: data[i].src
            };

            list_icon_output += fill_template($list_icon, icon, 'template-list-icon');
        }

        $list_icon.prepend(list_icon_output);

        icon_default_output += fill_template($icon_default, icon_default, 'template-icon');

        $icon_default.html(icon_default_output);

        $icon_default.find("button#new-icon").click(function () {
            $icon_default.find('.list-icon').addClass('hide');

            $icon_default.find('div:first').addClass('hide');

            $(".new-icon").removeClass('hide');

            $(".new-icon input").click();

        });

        $(".new-icon button#cancel-upload-icon").click(function () {

            $(".new-icon #input-icon").val('').change();

            $icon_default.find('.list-icon').removeClass('hide');

            $icon_default.find('div:first').removeClass('hide');

            $(".new-icon").addClass('hide');

        });

        $icon_default.find('.list-icon a').click(function (e) {
            var iconpost_id = $(this).attr('href').replace("#", ''),
                iconpost_src = $(this).find('img').attr('src');

            if (e.target.localName != 'i' && e.target.localName != 'span') {
                $icon_default.find('div:first > img').attr('src', iconpost_src);
                $icon_default.find('div:first > #iconpost_id').val(iconpost_id);
            } else {
                $(this).remove();
                $.post('./ws/iconpost/delete', {id: iconpost_id});
                $icon_default.find('.list-icon a:first').click();
            }
            return false;
        });

        if (!icon_default) {
            $icon_default.find('.list-icon').addClass('hide');

            $icon_default.find('div:first').addClass('hide');

            $(".new-icon").removeClass('hide').removeClass('input-group').find('button').remove();
            $(".new-icon").removeClass('hide').removeClass('input-group').append('');
        }

    });
}

function check_sharedwiki_url() {
    var url = $("input[name=wiki_url]").val();
    $.get('ws/help/check_url', {url: url}, function (data) {
        data = JSON.parse(data);
        if (data.error == true) {
            $(".artigo_sample").hide();
            $(".sharedwiki_id").val("");
        } else {
            if (Object.keys(data).length > 0) {
                $(".artigo_sample").show();
                $(".nome_artigo").text(data["title"]);
                $(".texto_artigo").html(data["text_sample"]);
                $(".sharedwiki_id").val(data["id"]);
            } else {
                $(".artigo_sample").hide();
            }
        }
    });
}
$(document).ready(check_sharedwiki_url);
$("input[name=wiki_url]").on("input", check_sharedwiki_url);

$(".btn-send,button[type=submit]").click(function (event) {
    error = false;
    if (error == false && checar($('#input-video'), 2) == false) {
        error = true;
        event.preventDefault();
    }
    if (error == false && checar($('#input-img'), 3) == false) {
        error = true;
        event.preventDefault();
    }
    if (error == false && checar($('#input-icon'), 3) == false) {
        error = true;
        event.preventDefault();
        //return false;
    }
});

