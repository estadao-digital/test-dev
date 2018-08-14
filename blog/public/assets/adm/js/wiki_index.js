$(function () {
    load_table();
    filter();
    action_form("#bulkaction-wiki");
    action_form_filter("#form-wiki-filter");

    var $modal = $("#modal-help"),
        $form = $modal.find("#modalHelp");

    $form.submit(function () {
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
        
        $('.page_loading').show();

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
                    window.location = './adm/wiki';
                }
            }
        });
        return false;
    });


});

function load_datatable($table, identifier, usersettings) {
    var columns_data = [],
        th_total = $table.find('thead tr th').length,
        td_action = false;

    $table.find('thead tr th').each(function (i, column) {
        var column_id = i,
            $column = $(column),
            title = $column.text(),
            data = {"data": $(column).data('id')};

        if ($(column).data('id') == "action") {
            td_action = true;
        }

        $column.data('column-id', column_id);

        if (usersettings[identifier.colvis]) {
            data.visible = usersettings[identifier.colvis][column_id] == 'true';
        }

        if (usersettings[identifier.colwidth]) {
            if (usersettings[identifier.colwidth][column_id]) {
                data.width = usersettings[identifier.colwidth][column_id];
            }
        }

        if ($column.attr('width') != undefined) {
            data.width = $column.attr('width');
            $column.html('<span class="fix-width">' + title + '</span>');
            $column.find('span.fix-width').width(data.width);
        }

        columns_data.push(data);

    });

    var table = $table.DataTable({
        responsive: true,
        "autoWidth": false,
        "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "Todos"]],
        "sDom": 'C<"clear">RZlfrtip',
        "oColVis": {
            "aiExclude": td_action ? [0, th_total - 1] : [0],
            "fnStateChange": function () {
                var data = [];

                $.each(table.columns()[0], function (i) {
                    data[$(table.column(i).header()).data('column-id')] = table.column(i).visible();
                });

                $.post('./ws/usersettings/save', {
                    identifier: identifier.colvis,
                    data: data
                });
            }
        },
        "colResize": {
            "exclude": td_action ? [0, th_total - 1] : [0],
            "handleWidth": 5,
            "resizeCallback": function () {
                var data = [];

                $.each(table.columns()[0], function (i) {
                    var $column = $(table.column(i).header()),
                        width = $column.is(':visible') ? $column.width() : 10;


                    data[$column.data('column-id')] = width;
                });

                $.post('./ws/usersettings/save', {
                    identifier: identifier.colwidth,
                    data: data
                });
            }
        },
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        },
        "columns": columns_data,
        "columnDefs": [{
            "targets": td_action ? [0, th_total - 1] : [0],
            "orderable": false
        }],
        "initComplete": function () {
            $(".page_loading").hide(0, function () {
                $table.removeClass('invisible');
            });
        }
    }).order([1, "asc"]);

    // Reorder
    new $.fn.dataTable.ColReorder(table, {
        fnReorderCallback: function () {
            var data = [];

            $('thead tr th', $table).each(function (i, el) {
                if (td_action) {
                    if ($(el).data('column-id') != th_total - 1) {
                        data[i] = $(el).data('column-id');
                    }
                }
            });

            $.each(table.columns()[0], function (i) {
                if (td_action) {
                    if ($.inArray(i, data) == -1 && i != th_total - 1) {
                        data.push(i);
                    }
                } else {
                    if ($.inArray(i, data) == -1) {
                        data.push(i);
                    }
                }
            });

            if (td_action) data.push(table.columns()[0].length - 1);

            $.post('./ws/usersettings/save', {
                identifier: identifier.reorder,
                data: data
            });
        },
        iFixedColumnsLeft: 1,
        iFixedColumnsRight: td_action ? 1 : 0,
        aiOrder: usersettings[identifier.reorder]
    });
}

function load_table() {
    var $table = $("table#table-wiki"),
        identifier = {
            reorder: "reorder-table-wiki",
            colvis: "colvis-table-wiki",
            colwidth: "colwidth-table-wiki"
        };

    $.post('./ws/usersettings/get', {
        identifier: identifier
    }, function (json) {
        var usersettings = [];

        for (i in identifier) {
            usersettings[identifier[i]] = json != null && json[identifier[i]] ? json[identifier[i]].data : null
        }

        load_datatable($table, identifier, usersettings);
    });
}

function filter() {
    $("#filter_wiki select, #filter_wiki input").change(function () {
        if ($(this).attr('name') != 'xls') {
            $('.now_loading').css("display", "block");
            $('#filter_wiki input[name="xls"]').val(0);
        }
        $(this).closest("form").submit();
    });
    $(".form-filter-wiki .close-filter-wiki").click(function () {
        $(".form-filter-wiki").addClass("closed");
        $(".form-filter-wiki").removeClass("add-filter");
        localStorage.setItem("wiki-filter", 0);
        return false;
    });

    $(".form-filter-wiki .open-filter-wiki").click(function () {
        $(".form-filter-wiki").removeClass("closed");
        $(".form-filter-wiki").addClass("add-filter");
        localStorage.setItem("wiki-filter", 1);
        return false;
    });
    if (localStorage.getItem("wiki-filter") == 1) {
        $(".form-filter-wiki .open-filter-wiki").click();
    } else {
        $(".form-filter-wiki .close-filter-wiki").click();
    }
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

function add_artigo() {
    $.get('ws/help/category', function (data) {
        var categories = data.help_category,
            help_limit = data.help_limit,
            $categories = $('.list-categories'),
            $help = $categories.find('.list-help'),
            output_categories = '',
            output_help = [];
        create_help_adm(categories);
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
        $form.find('button[type="submit"]').text('Salvar');
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
            $file_list.find("li .input-group .btn.help").click();
            return false;
        }
    });

    $file_list.find("li a.delete-file").click(function () {
        var $item = $(this).closest('li'),
            id = $item.data('id'),
            help_id = $item.data('help_id');

        $.post('./ws/helpfile/delete', {id: id, help_id: help_id}, function (data) {
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
function delete_wiki(id) {
    var data = {id: id};
    $.post('ws/help/delete', data, function (data) {
        if (data.delete) {
            localMsg(data);
            window.location = window.location.href;
        }
    });
}

$('.icon-list ul li').click(function () {
    $('.toggle-vis > i', this).toggleClass('check-none');

});