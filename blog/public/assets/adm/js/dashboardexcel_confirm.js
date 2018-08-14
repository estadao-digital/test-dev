$(function () {
    var $form = $("#confirm-data-dashboard");

    load_table();

    $form.submit(function () {
        $('.page_loading').show();
    });
});

function load_datatable($table, identifier, usersettings) {
    var columns_data = [],
        $form = $("#confirm-data-dashboard"),
        data_form = $form.serializeArray()
            .reduce(function (a, x) {
                a[x.name] = x.value;
                return a;
            }, {}),
        microservice_url = $form.data('microservice_url');

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
        "columnDefs": [{
            "orderable": false
        }],
        "cache": true,
        "deferRender": true,
        "serverSide": false,
        "processing": true,
        "ajax": {
            "url": microservice_url + 'ms/dashboard/confirm?CI_SUB_DOMAIN=' + $form.data('ci_sub_domain'),
            "type": "POST",
            "data": data_form,
            "error": function (xhr, ajaxOptions, thrownError) {
                error_ajax(table, $form, {error: [ajaxOptions]});
                $table.data('not_exit', false);
            },
            "complete": function (data) {
                data = JSON.parse(data.responseText);

                if (data.error) {
                    error_ajax(table, $form, data);
                } else {
                    $form.find('button[type="submit"]').removeAttr('disabled');
                }
            },
            "statusCode": {
                401: function () {
                    error_ajax(table, $form, {error: ['401 Unauthorized']});
                }
            }
        },
        "initComplete": function () {
            $(".page_loading").hide(0, function () {
                $table.removeClass('invisible');
            });
        }
    }).order([]).on('preXhr.dt', function (e, settings, data) {
        $table.data('not_exit', true);
    }).on('xhr.dt', function (e, settings, json, xhr) {
        $table.data('not_exit', false);
    });

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

    $("a[href]").click(function () {
        if ($table.data('not_exit')) {
            return confirm("A importação ainda está em andamento!\n Deseja sair desta página?");
        } else {
            return true;
        }
    });
}

function load_table() {
    var $table = $("table#table-dashboard-confirm"),
        identifier = {
            reorder: "reorder-table-dashboard-confirm",
            colvis: "colvis-table-dashboard-confirm",
            colwidth: "colwidth-table-dashboard-confirm"
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

function error_ajax(table, $form, error) {
    console.log(error);
    table.clear().draw();
    $('#dataTable_processing').hide();
    $form.find('button[type="submit"]').remove();
    alert_box(error);
}