function load_help_group(group) {
    $.post('ws/group/get', function (data) {
        var $groups_modal = $("#help-modal-group");
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

        $("#help-modal-group").chosen({
            no_results_text: "Oops, usuário não encontrado!"
        });
    });
}
function create_help(categories, help) {
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


    if (categories_length) {

        for (i in categories) {
            var category = categories[i];
            output += fill_template($categories_modal, category, 'template-category');
        }

        $categories_modal.html(output);
    }

    if (me().usertype_id != 2) {
        $('#modal-collaborative').html('');
        $('#modal-group').html('');
    }

    $("#create-help, .help .item .info .edit").click(function () {

        var output_modal_body = '',
            help_for = help,
            output_file = '';

        if ($(this).data('form') == 'create') {
            help_for = help_reset;
            $form.find('button[type="submit"]').text('Criar novo artigo');
            $form.attr('action', action.create);
        } else {
            $form.find('button[type="submit"]').text('Gravar');
            $form.attr('action', action.update);
        }

        for (h in help_for) {
            var new_help = {
                help_id: help_for[h].id,
                help_title: help_for[h].title,
                help_text: help_for[h].text
            };

            files = help_for[h].file;

            //<div class="help-file"><a href="' + help[h].file + '" target="_blank"><i class="fa fa-paperclip"></i> Anexo</a></div>

            output_modal_body += fill_template($modal_body, new_help, 'template-form');
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

        $file_list.find("li .input-group .btn").click(function () {
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
                $file_list.find("li .input-group .btn").click();
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

        load_help_group(group);

        $modal.modal('show').on('shown.bs.modal', function () {
            $("#new-category-text", $form).focus();
        });

        add_file();

        return false;
    });

    $form.submit(function () {

        var data_form = new FormData(this),
            data = $(this).serialize(),
            action = $(this).attr('action');

        $(".now_loading").show();

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
                data = $.parseJSON(data);

                if (data.error) {
                    alertMsg(data);
                } else {

                    $modal.modal('hide');

                    $form.find("button[type='submit']").removeAttr('disabled');

                    localMsg(data);
                    if (me().usertype_id == 2) {
                        window.location = data.helpsent.link
                    }
                    window.location = '/help';

                    $(".now_loading").hide();
                }
            }
        });

        return false;
    });
}

function edit_category(edit_category_id) {
    var item = '#help-category-' + edit_category_id,
        $modal = $("#modal-category"),
        $form = $modal.find("#modalCategory");

    $(function () {
        var $item = $(this).closest('.item'),
            category_id = $(item).data('id'),
            title_category = $(item).find('.title-category').text();


        $modal.modal('show').on('shown.bs.modal', function () {
            $form.find("button[type='reset']").trigger('click');
            $form.find('#category-text').val(title_category).focus();
            $form.find('#category-id').val(category_id);
        });

        return false;
    });

    $form.submit(function () {
        var data_form = $(this).serialize();

        $form.find("button[type='submit']").attr('disabled', 'disabled');

        $.post('ws/helpcategory/update', data_form, function (data) {
            if (data.error) {
                alertMsg(data);
            } else {

                $modal.modal('hide');

                localMsg(data);

                location.reload();
            }

            $form.find("button[type='submit']").removeAttr('disabled');

        });

        return false;
    });
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
$(function () {
    $(document).keyup(function (e) {
        if (e.keyCode == 27) {
            $('#modal-preview video').remove();
        }
    });
});