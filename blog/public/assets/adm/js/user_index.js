$(function () {
    $(".user-filter .close-filter").click(function () {
        $(".user-filter").addClass("closed");
        $(".user-filter").removeClass("add-filter");
        localStorage.setItem("user-filter", 0);
        return false;
    });

    $(".user-filter .open-filter").click(function (e) {
        e.preventDefault();
        $(".user-filter").removeClass("closed");
        $(".user-filter").addClass("add-filter");


        localStorage.setItem("user-filter", 1);

        return false;
    });

    if (localStorage.getItem("user-filter") == 1) {
        $(".user-filter .open-filter").click();
    } else {
        $(".user-filter .close-filter").click();
    }
    $('.user-filter input').change(function () {
        if ($(this).attr('name') != 'xls') {
            $('.now_loading').css("display", "block");
            $('.user-filter input[name="xls"]').val(0);
        }
        $(this).closest('form').submit();
    });

    $(".user-filter select").chosen().change(function () {
        if ($(this).attr('name') != 'xls') {
            $('.now_loading').css("display", "block");
            $('.user-filter input[name="xls"]').val(0);
        }
        $(this).closest('form').submit();
    });

    action_form("#bulkaction-user");
    action_form_filter("#form-user-filter");
});

function load_datatable($table, identifier, usersettings) {
    var columns_data = [],
        th_total = $table.find('thead tr th').length;

    $table.find('thead tr th').each(function (i, column) {
        var column_id = i,
            $column = $(column),
            title = $column.text(),
            data = {"data": $column.data('id')};

        $column.data('column-id', column_id);

        if (usersettings[identifier.colvis]) {
            data.visible = usersettings[identifier.colvis][column_id] == 'true';
        }

        if (usersettings[identifier.colwidth]) {
            if (usersettings[identifier.colwidth][column_id]) {
                data.width = usersettings[identifier.colwidth][column_id];
            }
        }

        if ($column.data('id') == 'action') {
            data.visible = true;
        }

        if ($column.attr('width') != undefined) {
            data.width = $column.attr('width')
            $column.html('<span class="fix-width">' + title + '</span>');
            $column.find('span.fix-width').width(data.width);
        }

        columns_data.push(data);
    });

    console.log(columns_data);

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
        "cache": true,
        "deferRender": true,
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": 'adm/user/index_ajax/',
            "type": "POST",
            "done": function () {
                $.each(table.columns()[0], function (i) {
                    var column_id = $(table.column(i).header()).data('column-id');
                    if (usersettings[identifier.colwidth][column_id]) {
                        $(table.column(i).header()).width(usersettings[identifier.colwidth][column_id]);
                    }

                    $(table.column(i).header()).width(usersettings[identifier.colwidth][column_id]);
                });
            }
        },
        "initComplete": function () {
            $(".page_loading").hide(0, function () {
                $table.removeClass('invisible');
            });
        }
    }).order([3, "asc"]);

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
    var $table = $("table#table-user"),
        identifier = {
        reorder: "reorder-table-users",
        colvis: "colvis-table-users",
        colwidth: "colwidth-table-users"
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

function status(e) {
    var url = $(e).attr("href");
    $.get(url, function (data) {
        if (data.error) {
            alert_box(data)
        } else {
            localMsg(data);
            window.location = './adm/user/'
        }
    });
    return false;
}

function openVoucher() {
    var numberOfChecked = $('input[name="id[]"]:checked').length;
    if (numberOfChecked > 0) {
        $('#voucher').modal('show');
    } else {
        alertErrorMsg('Nenhum item foi selecionado, você precisa selecionar pelo menos 1 item para continuar.');
    }
}

function filter_users(form, id) {
    $(form + ' input').val(id);
    $(form).submit();
}