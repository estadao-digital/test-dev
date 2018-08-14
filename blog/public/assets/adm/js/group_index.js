$(function () {
    load_table();
    $(".group-filter .close-filter").click(function () {
        $(".group-filter").addClass("closed");
        $(".group-filter").removeClass("add-filter");
        localStorage.setItem("group-filter", 0);
        return false;
    });

    $(".group-filter .open-filter").click(function (e) {
        e.preventDefault();
        $(".group-filter").removeClass("closed");
        $(".group-filter").addClass("add-filter");
        localStorage.setItem("group-filter", 1);
        return false;
    });

    if (localStorage.getItem("group-filter") == 1) {
        $(".group-filter .open-filter").click();
    } else {
        $(".group-filter .close-filter").click();
    }
    $('.group-filter input').change(function () {
        if ($(this).attr('name') != 'xls') {
            $('.now_loading').css("display", "block");
            $('.group-filter input[name="xls"]').val(0);
        }
        $(this).closest('form').submit();
    });

    $(".group-filter select").chosen().change(function () {
        if ($(this).attr('name') != 'xls') {
            $('.now_loading').css("display", "block");
            $('.group-filter input[name="xls"]').val(0);
        }
        $(this).closest('form').submit();
    });

    action_form("#bulkaction-group");
    action_form_filter("#form-group-filter");
});

function load_datatable($table, identifier, usersettings) {
    var columns_data = [],
        th_total = $table.find('thead tr th').length;

    $table.find('thead tr th').each(function (i, column) {
        var column_id = i,
            $column = $(column),
            title = $column.text(),
            data = {"data": $(column).data('id')};

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
            "aiExclude": [0, th_total - 1],
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
            "exclude": [0, th_total - 1],
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
            "targets": [0, th_total - 1],
            "orderable": false
        }],
        "initComplete": function () {
            $(".page_loading").hide(0, function () {
                $table.removeClass('invisible');
            });
        }
    }).order([2, "asc"]);

    // Reorder
    new $.fn.dataTable.ColReorder(table, {
        fnReorderCallback: function () {
            var data = [];

            $('thead tr th', $table).each(function (i, el) {
                if ($(el).data('column-id') != th_total - 1) {
                    data[i] = $(el).data('column-id');
                }
            });

            $.each(table.columns()[0], function (i) {
                if ($.inArray(i, data) == -1 && i != th_total - 1) {
                    data.push(i);
                }
            });

            data.push(table.columns()[0].length - 1);

            $.post('./ws/usersettings/save', {
                identifier: identifier.reorder,
                data: data
            });
        },
        iFixedColumnsLeft: 1,
        iFixedColumnsRight: 1,
        aiOrder: usersettings[identifier.reorder]
    });
}

function load_table() {
    var $table = $("table#table-groups"), identifier = {
        reorder: "reorder-table-groups",
        colvis: "colvis-table-groups",
        colwidth: "colwidth-table-groups"
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

function delete_group(id) {
    var data = {id: id};
    $.post('ws/group/delete/' + id, data, function (data) {
        if (!data.error) {
            localMsg(data);
            window.location = window.location.href;
        }
    });
}
function filter_users(form, id) {
    $(form + ' input').val(id);
    $(form).submit();
}