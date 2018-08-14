$(function () {
    /*
     * Essa é a função que é carregada junto com a página.
     * Primeiro colocamos na variável $table o elemento em JQuery respectivo a tabela que os
     * resultados da busca por grupos com os filtros acima
     * */
    var $table = $("table#superfilter-groups");
    $table.find('thead tr th').each(function (i, column) {
        $(column).data('column-id', i);
    });
});

function group_load_filter(data, reload) {
    var $form = $('#group_superfilter_modal form'),
        $table = $("table#superfilter-groups"),
        no_data = "Não há dados";
    $table.find('thead #check-all').prop('checked', false);
    reload = reload == true;
    for (i in data) {
        var filter = data[i],
            filter_id = '#filter-' + i,
            $element = $form.find(filter_id),
            title = $element.data('title'),
            output = '';

        if (!reload) {
            if (!reload) $element.chosen();
            if (filter.length > 0) {
                $element.attr('data-placeholder', title).removeAttr('disabled');
                for (a in filter) {
                    var item = filter[a];
                    output += fill_template($element, item);
                }
            } else {
                $element.attr('data-placeholder', no_data);
            }
            $element.html(output).trigger("chosen:updated");
            $element.change(function () {
                $element.closest('form').submit();
                $form.data('changed_id', $(this).attr('id'));
            });
        } else {
            var val = $element.val();
            if ($form.data('changed_id') != $element.attr('id') || (val == '' || val == null || val == -1 || ($.isArray(val) && val.length == 1 && val[0] == -1))) {
                if (filter.length > 0) {
                    for (a in filter) {
                        var item = filter[a];
                        output += fill_template($element, item);
                    }
                } else {
                    $element.attr('data-placeholder', no_data);
                }
                $element.html(output);
                if (val) {
                    val = $.isArray(val) ? val : [val];
                    for (a in val) {
                        $element.find('option[value="' + val[a] + '"]').attr('selected', 'selected');
                    }
                }
                $element.trigger("chosen:updated");
            }
        }
        if ($element.has('option').length == 0) {
            //alert($element.data("placeholder"));
        }

    }
}

function group_serialize_object_form(data) {
    var serialize = [];
    if ($.isArray(data)) {
        for (i in data) {
            serialize.push(serialize_object_form(data[i]));
        }
    } else {
        if ($.isPlainObject(data.value) || $.isArray(data.value)) {
            for (i in data.value) {
                serialize.push(serialize_object_form({name: data.name + '[' + i + ']', value: data.value[i]}));
            }
        } else {
            serialize.push(data.name + '=' + data.value);
        }
    }

    serialize = serialize.join('&');

    return serialize;
}

function group_load_datatable($table, identifier, usersettings) {

    var columns_data = [],
        th_total = $table.find('thead tr th').length;

    /*  --------------Carregar configurações do superfiltros salvas no banco---------------  */
    $table.find('thead tr th').each(function (i, column) {
        var column_id = i,
            $column = $(column),
            title = $column.text(),
            data = {};
        $column.data('column-id', column_id);
        if (usersettings[identifier.colvis]) {
            data.visible = usersettings[identifier.colvis][column_id] == 'true';
        }
        if (usersettings[identifier.colwidth]) {
            if (usersettings[identifier.colwidth][column_id]) {
                data.width = usersettings[identifier.colwidth][column_id];
            }
        }
        data.width = $column.attr('width') != undefined ? $column.attr('width') : data.width;
        columns_data[$column.data('id')] = data;
        if ($column.attr('width') != undefined) {
            $column.html('<span class="fix-width">' + title + '</span>');
            $column.find('span.fix-width').width(data.width);
        }
    });
    /*  --------------Carregar configurações do superfiltros salvas no banco---------------  */

    var table = $table.DataTable({
        responsive: true,
        "autoWidth": false,
        "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "Todos"]],
        "sDom": 'C<"clear">RZlfirtip',
        "oColVis": {
            "aiExclude": [0],
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
            "exclude": [0],
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
        "cache": true,
        "deferRender": true,
        "serverSide": true,
        "processing": true,
        "fnServerData": function (sSource, aoData, fnCallback, oSettings) {
            var $modal = $('#group_superfilter_modal'),
                data_form = $("#form-group-superfilter").serialize(),
                data_post = serialize_object_form(aoData);
            if (data_form) {
                data_post += '&' + data_form;
            }
            if (oSettings.jqXHR) oSettings.jqXHR.abort();

            $modal.find("#save-filter, #apply-filter, #clear-filter").prop('disabled', true);

            oSettings.jqXHR = $.ajax({
                "url": './ws/superfilter/group_filter',
                "type": "POST",
                "data": data_post,
                "success": function (data) {
                    fnCallback(data);
                    group_load_filter(data.filter, true);
                    $modal.find("#save-filter, #apply-filter, #clear-filter").prop('disabled', false);
                    $modal.addClass('loaded');
                }
            });
        },
        "columns": [
            {
                "data": null,
                "width": columns_data["checkbox"].width,
                "visible": columns_data["checkbox"].visible,
                "orderable": false,
                "searchable": false,
                "render": function (data, type, row, meta) {
                    return '<label class="checkbox"><input type="checkbox" class="check-all" value="' + data.id + '"/><i class="fa fa-check" aria-hidden="true"></i></label>';
                }
            },
            {
                "data": "name",
                "className": "name",
                "name": "group.name",
                "width": columns_data["name"].width,
                "visible": columns_data["name"].visible
            },
            {
                "data": "parameter1",
                "className": "parameter1",
                "name": "group.parameter1",
                "width": columns_data["parameter1"].width,
                "visible": columns_data["parameter1"].visible
            },
            {
                "data": "parameter2",
                "className": "parameter2",
                "name": "group.parameter2",
                "width": columns_data["parameter2"].width,
                "visible": columns_data["parameter2"].visible
            },
            {
                "data": "parameter3",
                "className": "parameter3",
                "name": "group.parameter3",
                "width": columns_data["parameter3"].width,
                "visible": columns_data["parameter3"].visible
            },
            {
                "data": "parameter4",
                "className": "parameter4",
                "name": "group.parameter4",
                "width": columns_data["parameter4"].width,
                "visible": columns_data["parameter4"].visible
            },
            {
                "data": "parameter5",
                "className": "parameter5",
                "name": "group.parameter5",
                "width": columns_data["parameter5"].width,
                "visible": columns_data["parameter5"].visible
            },
            {
                "data": "parameter6",
                "className": "parameter6",
                "name": "group.parameter6",
                "width": columns_data["parameter6"].width,
                "visible": columns_data["parameter6"].visible
            },
            {
                "data": "parameter7",
                "className": "parameter7",
                "name": "group.parameter7",
                "width": columns_data["parameter7"].width,
                "visible": columns_data["parameter7"].visible
            },
            {
                "data": "parameter8",
                "className": "parameter8",
                "name": "group.parameter8",
                "width": columns_data["parameter8"].width,
                "visible": columns_data["parameter8"].visible
            }
        ]
    }).order([2, "asc"]);

    // Reorder
    new $.fn.dataTable.ColReorder(table, {
        fnReorderCallback: function () {
            var data = [];

            $('thead tr th', $table).each(function (i, el) {
                data[i] = $(el).data('column-id');
            });

            $.each(table.columns()[0], function (i) {
                if ($.inArray(i, data) == -1) {
                    data.push(i);
                }
            });

            $.post('./ws/usersettings/save', {
                identifier: identifier.reorder,
                data: data
            });
        },
        iFixedColumnsLeft: 1,
        aiOrder: usersettings[identifier.reorder]
    });

    $table.data('datatable', table);
}

function group_load_table(table_reload) {
    var $table = $("table#superfilter-groups"),
        identifier = {
            reorder: "reorder-table-group-superfilter",
            colvis: "colvis-table-group-superfilter",
            colwidth: "colwidth-table-group-superfilter"
        };

    if (table_reload != true) {
        $.post('./ws/usersettings/get', {
            identifier: identifier
        }, function (json) {
            var usersettings = [];
            for (i in identifier) {
                usersettings[identifier[i]] = json != null && json[identifier[i]] ? json[identifier[i]].data : null
            }
            group_load_datatable($table, identifier, usersettings);
            //default_savedfilter();
        });

    } else {
        var table = $table.data('datatable');
        table.order([]);
    }
}

function group_get_filter_superfilter() {
    $.get('./ws/superfilter/filter_group_item', function (data) {
        group_load_filter(data.filter);
        group_load_table(false);
    });
}

function group_clear_filter() {
    var $modal = $('#group_superfilter_modal'),
        $form = $("#form-group-superfilter", $modal),
        $dataTables_wrapper = $(".dataTables_wrapper", $modal);

    $(".modal-body", $modal).scrollTop(0);

    $modal.find("#save-filter, #apply-filter, #clear-filter").prop('disabled', true);

    $form.data('reaload', false);

    $modal.removeClass('loaded');

    $form.find('input').val('');
    $dataTables_wrapper.find('input').val('');
    $dataTables_wrapper.find('select').val($dataTables_wrapper.find('select option:first').attr('value')).change();
    $form.find('select').val('').change().trigger("chosen:updated");

    $form.data('reaload', true).submit();

    group_load_table(true);

}

function group_save_filter($modalsavefilter, $form) {

    $modalsavefilter.find('form').submit(function () {
        var data = $(this).serialize(),
            $modal = $modalsavefilter.data('modal');
        data = data + '&' + $form.serialize();
        data += '&type=group';
        $modalsavefilter.find('form [type="submit"], form input').prop('disabled', true);

        $.post('./ws/savedfilter/save', data, function (data) {
            $modalsavefilter.find('form [type="submit"], form input').prop('disabled', false);
            $modalsavefilter.modal('hide');
            if ($modal) {
                $modal.modal('hide');
            }

            load_savedfilter();
        });

        return false;
    });

    $modalsavefilter.find('form #close-save-filter').click(function () {
        var $modal = $modalsavefilter.data('modal');
        if ($modal) {
            $modal.modal('hide');
        }
    });
}

function group_pre_save_filter($modal) {
    var $modalsavefilter = $("#savefilter_modal");
    $modalsavefilter.css('z-index', '1000001');
    $modalsavefilter.modal('show');
    $modalsavefilter.find('form input').val('');
    $modalsavefilter.data('modal', $modal);

}

function group_remove_savedfilter($this) {
    var id = $this.data('id'),
        $a = $this.closest('a');

    $.post('./ws/savedfilter/delete', {id: id});

    $a.remove();
}

function group_apply_savedfilter(data) {

    var name = [],
        $modal = $('#group_superfilter_modal'),
        $form = $("#form-group-superfilter", $modal);
    group_clear_filter();
    data = $.parseJSON(data);
    for (var i in data) {
        if ($.isPlainObject(data[i])) {
            for (var a in data[i]) {
                if ($.isPlainObject(data[i][a])) {
                    for (var b in data[i][a]) {
                        name[i + '[' + a + '][' + b + ']'] = data[i][a][b];
                    }
                } else {
                    var is_array = $.isArray(data[i][a]) ? '[]' : '';
                    name[i + '[' + a + ']' + is_array] = data[i][a];
                }
            }
        } else {
            name[i] = data[i];
        }
    }
    for (i in name) {
        $form.find('[name="' + i + '"]').val(name[i]);
        $form.find('select').trigger("chosen:updated");
    }
    $form.submit();
}

function group_default_savedfilter() {
    var data = JSON.stringify({
        filter_form_sub: {
            user__status: 1
        }
    });
    group_apply_savedfilter(data);
}

function group_load_savedfilter() {
    var $modal = $('#group_superfilter_modal'),
        $savedfilters = $modal.find('.saved-filters'),
        $filters = $savedfilters.find('.filters'),
        output = '';

    get_template($filters);

    $.post('./ws/savedfilter/get', {type: 'group'}, function (data) {
        var data_item = [];
        for (i in data) {
            data_item[data[i].id] = data[i].data;
            output += fill_template($filters, data[i]);
        }
        $filters.html(output);

        for (i in data_item) {
            $filters.find('[data-id="' + i + '"]').data('data', data_item[i]);
        }

        $filters.find('a').click(function (e) {
            if (e.target.localName == 'i') {
                modal_confirm($(this).find('i').attr('title') + '?', null, 'remove_savedfilter($(\'#superfilter_modal .saved-filters .filters a[data-id=\\\'' + $(this).closest('a').data('id') + '\\\']\'))');
            } else {
                $modal.removeClass('loaded');
                group_apply_savedfilter($(this).data('data'));
            }
        });

        $savedfilters.show();
    });
}

function group_apply_filter($this, $modal, $table) {
    var id = [],
        $input = $table.find('tbody .check-all:checked');

    $this.prop('disabled', true);
    var $element = $modal.data('element'),
        is_chosen = $modal.data('is_chosen');

    if ($input.length > 0) {
        $input.each(function (i, element) {
            var data = $(element).parents('tr:eq(0)');
            $element.find('option[value="' + $(element).val() + '"]').remove();
            $element
                .append($('<option>' + data.find('.name').html() + '</option>')
                    .val($(element).val())
                    .attr('selected', 'selected')).trigger("chosen:updated");
        });

        $('#group_superfilter_modal').modal("hide");
        $modal.find("#save-filter, #apply-filter, #clear-filter").prop('disabled', false);

        $element.trigger("change");

    } else {
        alertErrorMsg('Selecione ao menos 1 usuário.');
    }
}


//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
function group_load_superfilter() {
    var $modal = $('#group_superfilter_modal'),
        $modalsavefilter = $("#savefilter_modal"),
        $form = $("#form-group-superfilter", $modal),
        $table = $("table#superfilter-groups", $modal);
    group_get_filter_superfilter();

    $form.submit(function () {
        $modal.find("#save-filter, #apply-filter, #clear-filter").prop('disabled', true);
        if ($form.data('reaload') != false) {
            $table.DataTable().ajax.reload();
        }

        return false;
    });

    var changeTimer = false;
    $('#form-group-superfilter, .filter-custom', $form).change(function () {
        $form.data('changed_id', null);
        if (changeTimer !== false) clearTimeout(changeTimer);
        changeTimer = setTimeout(function () {
            $form.submit();
            changeTimer = false;
        }, 500);
    });

    $('input[type="text"], input[type="number"], .filter-custom', $form).keyup(function () {
        $form.data('changed_id', null);
        if (changeTimer !== false) clearTimeout(changeTimer);
        changeTimer = setTimeout(function () {
            $form.submit();
            changeTimer = false;
        }, 500);
    });

    $('select.filter-custom', $form).chosen();

    $modal.find("#clear-filter").click(function () {
        group_clear_filter();
    });

    $table.find('thead #check-all').click(function () {
        $table.find('tbody .check-all').prop('checked', $(this).is(':checked'));
    });

    $modal.find("#apply-filter").click(function () {
        group_apply_filter($(this), $modal, $table);
    });

    $modal.find("#save-filter").click(function () {
        group_pre_save_filter(false);
    });

    group_save_filter($modalsavefilter, $form);

}

//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------
//-------------------------------------------------------------


function group_superfilter(element, is_chosen) {

    var $table = $("table#superfilter-groups"),
        $modal = $('#group_superfilter_modal'),
        $element = $(element);

    $modal.data('element', element).data('is_chosen', is_chosen).modal('show').off('shown.bs.modal');
    is_chosen = is_chosen == undefined ? true : is_chosen;
    $modal.data('element', $element).data('is_chosen', is_chosen).modal('show').on('shown.bs.modal', function () {
        if ($modal.data('loaded') == true) {
            group_clear_filter();

            //group_load_savedfilter();
        } else {
            group_load_superfilter();
            group_load_savedfilter();
            $modal.data('loaded', true);
        }
    });
}

function group_superfilter_clear_list(element) {
    var $element = $(element);
    $element.val([]).change().trigger("chosen:updated");

}