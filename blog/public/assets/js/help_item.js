$(function () {
    var id_help = extract_url(1),
        $modal = $("#modal-help"),
        $form = $modal.find("#modalHelp");

    $.post('ws/help/get', {id: id_help}, function (data) {
        //console.log(data);
        if (data.error) {
            alert_box(data);
        } else {
            var help = data.help,
                logs = [],
                files = [],
                $article = $(".help-article"),
                $log = $(".log"),
                $log_list = $log.find(".item ul"),
                allowed_video = ["mp4"],
                allowed_img = ["jpg", "png", "gif"],
                allowed_files = ["pptx", "ppt", "pptm", "odp", "pdf", "doc", "docx", "xls", "xlsx"],
                output = '',
                output_log = '',
                output_file = '';

            allowed_files = $.merge($.merge(allowed_files, allowed_img), allowed_video);

            if (help) {
                for (h in help) {

                    logs = help[h].helplog;
                    files = help[h].file;
                    //help[h].author = (help[h].creator == help[h].modifier) ? 'Criado por <span>' + help[h].creator + ' ' + help[h].creator_lastname + '</span>' : 'Criado por <span>' + help[h].creator + ' ' + help[h].creator_lastname + '</span><br>Editado por <span>' + help[h].modifier + ' ' + help[h].modifier_lastname + '</span>';
                    help[h].author = (help[h].creator == help[h].modifier) ? 'Criado por <span>' + ' ' + help[h].creator_fullname + '</span>' : 'Criado por <span>' + help[h].creator_fullname + '</span><br>Editado por <span>' + help[h].modifier_fullname + '</span>';
                    if (help[h].img == null) {
                        help[h].img = '';
                    } else {
                        help[h].img = '<img class="photo img-responsive w100" src="' + help[h].img + '" alt="">';
                    }
                    if (help[h].video == null) {
                        help[h].video = '';
                    } else {
                        help[h].video = '<div align="center" class="embed-responsive embed-responsive-16by9">' +
                            '<video  controls loop class="embed-responsive-item" id="video-id-' + help[h].id + '">' +
                            '<source src="' + help[h].video + '">' +
                            '</video>' +
                            '</div>';
                    }
                    output += fill_template($article, help[h]);
                }

                $article.html(output);

                for (l in logs) {

                    logs[l].style = (logs[l].user_img) ? "style=\"background-image:url('" + logs[l].user_img + "');\"" : null;

                    logs[l].class = (logs[l].style) ? true : false;

                    output_log += fill_template($log_list, logs[l]);
                }

                $log_list.html(output_log);

                if (logs.length == 0) {
                    $log.addClass('hide');
                }

                var $file_list = $article.find(".files-list");

                for (f in files) {

                    var item = files[f];

                    var file_ext = files[f].src.split('.').pop();

                    if ($.inArray(file_ext, allowed_files) != -1) {

                        var srcPath = files[f].src,
                            name = "'" + files[f].name + "'",
                            permission = data.permission,
                            srcTemp = srcPath.substring(0, 1);

                        var m3u8 = files[f].m3u8;

                        if (srcTemp == '.') {
                            var src = "'http://" + document.domain + srcPath.substring(1) + "'";
                        } else {
                            var src = "'" + files[f].src + "'";
                        }

                        if ($.inArray(file_ext, allowed_video) != -1) {
                            if (m3u8 !== false) {
                                item.file_preview = '<a href="#" onclick="video_preview_m3u8(' + src + ',\'' + m3u8.video + '\',\'' + m3u8.thumbnail + '\',' + name + ', ' + permission + ');return false;"><i class="fa fa-eye pull" > </i> ' + files[f].name + '</a>';
                            } else {
                                item.file_preview = '<a href="#" onclick="video_preview(' + src + ',' + name + ', ' + permission + ');return false;"><i class="fa fa-eye pull" > </i> ' + files[f].name + '</a>';
                            }
                        } else if ($.inArray(file_ext, allowed_img) != -1) {
                            item.file_preview = '<a href="#" onclick="img_preview(' + src + ',' + name + ', ' + permission + ');return false;"><i class="fa fa-eye pull" > </i> ' + files[f].name + '</a>';
                        } else {
                            item.file_preview = '<a href="#" onclick="preview(' + src + ',' + name + ', ' + permission + ');return false;"><i class="fa fa-eye pull"> </i> ' + files[f].name + '</a>';
                        }
                    }

                    output_file += fill_template($file_list, item, 'template-file');
                }

                $file_list.html(output_file);
            }
        }
    });

    $('#help-form').submit(function () {
        var serach = $(this).find('input').val();

        window.location = "./help#" + serach;

        return false;
    });

    $form.submit(function (e) {
        erro = false;
        $.each($("#modalHelp input[type=file]"), function (key, object) {
            if (checar($(this), true) == false) {
                erro = true;
                return false;
            }
        });
        if (erro == true) {
            return false;
        }
        $(".now_loading").show();

        var data_form = new FormData(this),
            data = $(this).serialize(),
            action = $(this).attr('action');

        $form.find("button[type='submit']").attr('disabled', 'disabled');

        $.ajax({
            url: action,
            data: data_form,
            processData: false,
            type: 'POST',
            contentType: false,
            beforeSend: function (x) {
                if (x && x.overrideMimeType) {
                    x.overrideMimeType("multipart/form-data");
                }
            },
            mimeType: 'multipart/form-data',
            success: function (data) {
                $('.page_loading').hide();
                data = $.parseJSON(data);
                if (data.error) {
                    alertMsg(data.error);
                } else {
                    $modal.modal('hide');
                    $form.find("button[type='submit']").removeAttr('disabled');
                    localMsg(data);
                    window.location = window.location.href;
                    $(".now_loading").hide();
                }
            }
        });
        return false;
    });

});

function img_preview(url, name, blockdown) {
    var img = '<img src="' + url + '" style="width:100%;">',
        title = '<h4>' + name + '</h4>',
        download = '<a href="' + url + '" download="' + name + '"><button type="button" class="btn btn-default btn-orange">Download</button></a>';

    $('#preview-header').html(title);
    $("#preview-body").html(img);
    if (blockdown) {
        $("#preview-confirm").html(download);
    }
    $('#modal-preview').modal('show');
}

function preview(url, name, blockdown) {
    var iframe = '<iframe src="https://docs.google.com/viewer?url=' + url + '&output=embed&&embedded=true" style="width:100%; height:400px;" frameborder="0"></iframe>',
        title = '<h4>' + name + '</h4>',
        download = '<a href="' + url + '" download="' + name + '"><button type="button" class="btn btn-default btn-orange">Download</button></a>';

    $('#preview-header').html(title);
    $("#preview-body").html(iframe);
    if (blockdown) {
        $("#preview-confirm").html(download);
    }
    $('#modal-preview').modal('show');
}

function video_preview(url, name, blockdown) {
    var video = '<video width="100%" height="300" controls><source src="' + url + '" type="video/mp4"></video>',
        title = '<h4>' + name + '</h4>',
        download = '<a href="' + url + '" download="' + name + '"><button type="button" class="btn btn-default btn-orange">Download</button></a>';

    $('#preview-header').html(title);
    $("#preview-body").html(video);
    if (blockdown) {
        $("#preview-confirm").html(download);
    }
    $('#modal-preview').modal('show');
}

function video_preview_m3u8(url, src, thumbnail, name, blockdown) {
    var ms = '' + +new Date;
    ms = ms.match(new RegExp('.{1,4}', 'g')).join("-").split('').reverse().join('');

    var video = '<div id="show-player-' + ms + '" data-src="' + src + '" data-thumbnail="' + thumbnail + '"></div>',
        title = '<h4>' + name + '</h4>',
        download = '<a href="' + url + '" download="' + name + '"><button type="button" class="btn btn-default btn-orange">Download</button></a>';

    $('#preview-header').html(title);
    $("#preview-body").html(video);
    if (blockdown) {
        $("#preview-confirm").html(download);
    }

    $('#modal-preview').modal('show');

    initPlay($("#preview-body").find('#show-player-' + ms), null, 320);
}

function edit_artigo(id) {
    $.post('ws/help/get/all', {id: id, edit: true}, function (data) {
        if (data.error) {
            alertMsg(data);
        } else {
            var help = data.help;
            $.get('ws/help/category', function (data) {
                if (data.error) {
                    alertMsg(data);
                } else {
                    var categories = data.help_category;
                    create_help_adm(categories, help, 'update');
                }
            });
        }
    });
}


function create_help_adm(categories, help, target) {

    var $modal = $("#modal-help"),
        $form = $modal.find("#modalHelp"),
        $modal_body = $form.find(".modal-body"),
        $categories_modal = $form.find("#help-modal-category"),
        output = '',
        categories_length = (categories && categories.length > 0),
        help_status = (help != undefined),
        help_reset = [{id: '', text: '', title: '', file: []}],
        help = (help_status) ? help : help_reset,
        files = [],
        helpcategory_id = (help_status) ? help[0].helpcategory_id : '',
        action = {create: 'ws/help/create', update: 'ws/help/update'},
        group = help[0].group,
        colaborative = help[0].collaborative;

    if (colaborative == 0) {
        $('.collaborative-0').attr('selected', 'selected');
    } else {
        $('.collaborative-0').removeAttr('selected');
    }

    var $modal_body_original = $modal_body;
    if (categories_length) {
        for (i in categories) {
            var category = categories[i];
            output += fill_template($categories_modal, category, 'template-category');
        }
        $categories_modal.html(output);
    }
    $.post('ws/group/get', function (data) {
        var $groups_modal = $form.find("#help-modal-group");
        var output_groups,
            groups_inArray = [];
        for (g in group) {
            groups_inArray[group[g].group_id] = group[g].group_id;
        }
        for (i in data) {
            var groups = {};
            groups.group_id = data[i].id;
            groups.group_name = data[i].name;
            groups.selected = (groups_inArray.length > 0 && $.inArray(data[i].id, groups_inArray) >= 0) ? 'selected' : '';
            output_groups += fill_template($groups_modal, groups, 'template-group-help');
        }
        $groups_modal.html(output_groups);

        $groups_modal.chosen({
            no_results_text: "Oops, usuário não encontrado!"
        });
    });
    get_template($modal_body, 'template-form');

    var output_modal_body = '',
        help_for = help,
        output_file = '';

    if (target == 'update') {
        $form.find('button[type="submit"]').text('Gravar');
        $form.attr('action', action.update);
    } else {
        help_for = help_reset;
        $form.find('button[type="submit"]').text('Criar novo artigo');
        $form.attr('action', action.create);
    }

    for (h in help_for) {
        var new_help = {
            help_id: help_for[h].id,
            help_title: help_for[h].title,
            help_text: help_for[h].text
        };

        files = help_for[h].file;
        //<div class="help-file"><a href="' + help[h].file + '" target="_blank"><i class="fa fa-paperclip"></i> Anexo</a></div>
        output_modal_body += fill_template($modal_body_original, new_help, 'template-form');
    }

    $modal_body.html(output_modal_body);

    var $file_list = $modal_body.find(".list-file ul");

    for (f in files) {
        var item = {
            file_id: files[f].id,
            file_src: files[f].src,
            file_name: files[f].name
        };

        output_file += fill_template($file_list, item, 'template-file');
    }

    $file_list.html(output_file);

    $file_list.find("li a.edit-name").click(function () {
        var $item = $(this).closest('li');

        $item.addClass('edit');

        return false;
    });

    $file_list.find("li .input-group .btn.help").click(function () {
        alert("teste");
        var $item = $(this).closest('li'),
            id = $item.data('id'),
            name = $item.find('.input-group input').val();

        $item.find('a.name').text(name);
        $(".files-list .file#help-file-" + id).find('a span').text(name);

        $item.removeClass('edit');

        $.post('./ws/helpfile/save', {id: id, name: name, help_id: extract_url(1)}, function (data) {
            if (data.error) {
                alert_box(data);
            }
        });

        return false;
    });

    $file_list.find("li .input-group input").keypress(function (e) {
        if (e.keyCode == 13) {
            alert("teste");
            $file_list.find("li .input-group .btn.help").click();
            return false;
        }
    });

    $file_list.find("li a.delete-file").click(function () {
        var $item = $(this).closest('li'),
            id = $item.data('id');

        $.post('./ws/helpfile/delete', {id: id, help_id: extract_url(1)}, function (data) {
            if (data.error) {
                alert_box(data);
            } else {
                $item.remove();
                $(".files-list .file#help-file-" + id).remove();
            }
        });

        return false;
    });

    $form.find("#help-modal-category").val(helpcategory_id).change();

    $form.find('#new-category').click(function () {
        $(".select-category", $form).addClass('hide').find("#help-modal-category").attr('disabled', 'disabled');
        $(".new-category", $form).removeClass('hide').find("#new-category-text, #new-category-id").removeAttr('disabled');

        $("#new-category-text", $form).focus();
    });

    $form.find("#new-category-cancel").click(function () {
        $(".select-category", $form).removeClass('hide').find("#help-modal-category").removeAttr('disabled');
        $(".new-category", $form).addClass('hide').find("#new-category-text, #new-category-id").attr('disabled', 'disabled');

        $("#help-modal-category", $form).focus();
    });

    if (!categories_length) {
        $form.find('#new-category').click();
        $form.addClass('add-category');
    }

    $modal.modal('show').on('shown.bs.modal', function () {
        $("#new-category-text", $form).focus();

        if ($modal.find("textarea#help-modal-text").data('tinymce') != true) {
            $modal.find("textarea#help-modal-text").tinymce(tinymce_config_default);
            $modal.find("textarea#help-modal-text").data('tinymce', true);
        } else {
            tinyMCE.execCommand("mceRemoveEditor", true, 'help-modal-text');
            $modal.find("textarea#help-modal-text").tinymce(tinymce_config_default);
        }
    });

    add_file();

    $('#template-form').addClass('template-form');
    $('#template-category').addClass('template-category');
}

function check_id($content, id_complete) {

    var id = 1;

    for (i = 1; $content.find(id_complete + id).length > 0; i++) {
        id = i;
    }

    return id;

}

function add_file() {
    var $modal = $("#modal-help"),
        $files = $modal.find("form .files"),
        $list = $files.find('.list');

    get_template($list);

    $files.find('#add-file').click(function () {

        var data = {id: check_id($list, '#file-')},
            output = fill_template($list, data);

        $list.append(output);

        change_file($list.find("#file-" + data.id + " input[type='file']"));

        $list.find("#file-" + data.id + " button").click(function () {
            $(this).closest('.input-group').remove();
        });

    });
}

function change_file($inputfile) {
    $inputfile.click();

    $inputfile.change(function () {
        var $group = $(this).closest('.input-group');

        if ($(this).val() == '' || $(this).val() == undefined) {
            $group.find('button').click();
        } else {
            $group.removeClass('hide');

            var file = $(this).val(),
                file_name = file.split('\\');

            file_name = file_name.pop();

            file_name = (file_name != '') ? file_name.slice(0, -4) : '';

            $group.find('input[type="text"]').val(file_name);
        }
    });
}