$(function () {
    $('#dashboard_file').change(function () {

        var file = this.files[0],
            ext = file.name.split("."),
            arrayExtensions = ["xlsx", "xls", "txt", "csv"];

        ext = ext[ext.length - 1].toLowerCase();

        if (arrayExtensions.lastIndexOf(ext) == -1) {
            alert_box({error: ["Arquivo inválido! Permitido somente .xlsx, .xls, .txt e .csv."]});
            $(this).val("");
        } else {
            $('.now_loading').css("display", "block");
            $(this).closest("form").submit();
        }
    });

    load_table();
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
        "initComplete": function () {
            $('.page_loading').hide(0, function () {
                $table.removeClass("invisible");
            });
        }
    }).order([1, "desc"]);

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
        aiOrder: usersettings[identifier.reorder]
    });
}

function load_table() {
    var $table = $("table#table-dashboard-list-import"),
        identifier = {
            reorder: "reorder-table-dashboard-list-import",
            colvis: "colvis-table-dashboard-list-import",
            colwidth: "colwidth-table-dashboard-list-import"
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
