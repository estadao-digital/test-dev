function delete_quiz(id) {
    var data = {id: id};
    $.post('ws/quiz/delete', data, function (data) {
        if (data.delete) {
            localMsg(data);
            window.location = window.location.href;
        }
    });
}
function quiz_statistic(quiz_id) {

    $("#quiz-statistic-modal").modal('show');

    $("#quiz-statistic-modal .modal-body .load").fadeIn(0);

    $("#quiz-statistic-modal .modal-body .statistic-content").fadeOut(0);

    var html = '<button class="btn btn-orange" onclick="quiz_xls(' + quiz_id + ',\'#export-form\'); return false;" style="padding:2px 12px; margin-left:10px;">Gerar Excel</button>';
    html += '<button class="btn" onclick="quiz_xls(' + quiz_id + ',\'#export_quiz_answers_xls\'); return false;" style="padding:2px 12px; margin-left:10px;">Gerar Excel Detalhado</button>';
    html += '<form action="ws/quiz/statistic?xls=1" method="post" id="export-form"><input type="hidden" value="' + quiz_id + '" name="id"/></form>';
    html += '<form action="ws/quiz/get_quiz_answers_xls" method="post" id="export_quiz_answers_xls"><input type="hidden" value="' + quiz_id + '" name="id"/></form>';
    //console.log(html);

    $("#button-html").html(html).css('display', 'inline');

    $.post('ws/quiz/statistic', {id: quiz_id}, function (data) {
        var dataSet = [];

        for (var i in data.quiz) {
            var username = '';
            $.each(data.quiz[i].detail, function (index, value) {
                dataSet.push({
                    user_id: value.user_id,
                    answer: (value.answer) ? "Sim" : "Não",
                    user_name: value.user_name + ' ' + value.user_lastname + (value.user_status != 1 ? ' <i>(inativo)</i>' : ''),
                    user_level: value.user_level,
                    quiz_title: value.quiz_title,
                    answer_datetime: value.answer_datetime,
                    post: value.post,
                    answer_percent: value.answer_percent,
                    user: ({
                        'id': value.user_id,
                        'name': value.user_name + ' ' + value.user_lastname,
                        'title': value.quiz_title
                    })
                });
            });
        }

        var table = $('#table-quiz-statistic').DataTable({
            //responsive: true,
            "scrollX": true,
            pageLength: 10,
            "data": dataSet,
            "cache": false,
            "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "Todos"]],
            "iDisplayLength": 10,
            "language": {
                "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
            },
            "columns": [
                //{"data": "user_id", "visible": false},
                {
                    "data": "answer_datetime",
                    "width": "10%",
                    className: "text-left",
                    "type": "datetime",
                    "render": function (data, type, row) {

                        var date = ' - ';

                        if (data) {
                            date = data.split(' ');
                            var hour = date[1];
                            date = date[0].split('-');

                            date = "<span class=\"hide\">" + data + "</span>" + date[2] + '/' + date[1] + '/' + date[0] + ' ' + hour;
                        }

                        return date;
                    }
                },
                {"data": "answer", className: "text-left"},
                {"data": "user_name", className: "text-left", "width": "10%"},
                {"data": "answer_percent", className: "text-left"},
                {"data": "user_level", className: "text-left"},
                {
                    "data": "post",
                    "render": function (data, type, row) {
                        var post_list = [];

                        if (data) {
                            for (var i in data) {
                                post_list[i] = data[i].title;
                            }

                            post_list = post_list.join(", ");

                        } else {
                            post_list = '-';
                        }

                        return post_list;
                    }
                },
                {"data": "quiz_title"},
                {
                    "data": "user",
                    "orderable": false,
                    "render": function (data, type, row, meta) {

                        //console.log(data.id);
                        var output = '<button class="btn btn-orange" onclick="quiz_detail(' + data.id + ',' + quiz_id + ',\'' + data.name + '\',\'' + data.title + '\')">Detalhes</button>';

                        return (output);
                    }
                }

            ]
        }).order([1, "desc"]);

        $("#quiz-statistic-modal .modal-body .load").fadeOut(500);

        $("#quiz-statistic-modal .modal-body .statistic-content").fadeIn(500);

        $("#quiz-statistic-modal").on('hidden.bs.modal', function () {
            table.destroy();
        });

    });
}
function quiz_detail(user_id, quiz_id, user, quiz) {

    $("#quiz-detail-modal").modal('show');

    $("#quiz-detail-modal .modal-body .load").fadeIn(0);

    $("#quiz-detail-modal .modal-body .statistic-content").fadeOut(0);

    var html = '<button class="btn btn-orange" onclick="quiz_detail_xls(); return false;" style="padding:2px 12px; margin-left:10px;">Gerar Excel</button><form action="ws/quiz/detail/' + user_id + '/' + quiz_id + '?xls=1" method="post" id="export-detail-form"><input type="hidden" value="' + user + '" name="user"/><input type="hidden" value="' + quiz + '" name="quiz"/></form>';
    $("#button-html-2").html(html).css('display', 'inline');

    $.ajax({
        url: 'ws/quiz/detail/' + user_id + '/' + quiz_id
    }).done(function (data) {
        var dataSet = [];
        for (var i in data) {
            var correct = '';
            if (data[i].correct && data[i].quizanswer_id) {
                if ($.inArray(data[i].quizanswer_id, data[i].correct) >= 0) {
                    correct = 'Acertou';
                } else {
                    correct = 'Errou';
                }
                dataSet.push({
                    id: (data[i].id) ? data[i].id : "",
                    pergunta: (data[i].name) ? data[i].name : "",
                    resposta_do_usuario: (data[i].text) ? data[i].text : "",
                    resposta_correta: correct
                });
            }

        }
        var table = $('#table-detail-statistic').DataTable({
            "autoWidth": false,
            "data": dataSet,
            "language": {
                "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
            },
            "columns": [
                {"data": "id", "visible": false},
                {"data": "pergunta"},
                {"data": "resposta_do_usuario"},
                {"data": "resposta_correta"}
            ]
        });

        $("#quiz-detail-modal .modal-body .load").fadeOut(500);

        $("#quiz-detail-modal .modal-body .statistic-content").fadeIn(500);

        $("#quiz-detail-modal").on('hidden.bs.modal', function () {
            table.destroy();
        });

    });
}
function quiz_xls(quiz_id, form) {
    $(form).submit();
}
function quiz_detail_xls() {
    $("#export-detail-form").submit();
}

$(function () {

    load_table();

    $(".quiz-filter .close-filter").click(function () {
        $(".quiz-filter").addClass("closed");
        $(".quiz-filter").removeClass("add-filter");


        localStorage.setItem("quiz-filter", 0);

        return false;
    });

    $(".quiz-filter .open-filter").click(function (e) {
        e.preventDefault();
        $(".quiz-filter").removeClass("closed");
        $(".quiz-filter").addClass("add-filter");


        localStorage.setItem("quiz-filter", 1);

        return false;
    });

    if (localStorage.getItem("quiz-filter") == 1) {
        $(".quiz-filter .open-filter").click();
    } else {
        $(".quiz-filter .close-filter").click();
    }

    $('.quiz-filter input, .quiz-filter select').change(function () {
        if ($(this).attr('name') !== 'xls') {
            $('.now_loading').css("display", "block");
            $('.quiz-filter input[name="xls"]').val(0);
        }
        $(this).closest('form').submit();
    });

    $('.date-filter').datetimepicker({
        locale: 'pt-br',
        format: 'YYYY-MM-DD',
        ignoreReadonly: true,
        allowInputToggle: true
    }).on("dp.hide", function (e) {
        $(this).closest('form').submit();
    });

    action_form("#bulkaction-quiz");
    action_form_filter("#form-post-filter");

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
    }).order([5, "desc"]);

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
    var $table = $("table#table-quiz"),
        identifier = {
            reorder: "reorder-table-quiz",
            colvis: "colvis-table-quiz",
            colwidth: "colwidth-table-quiz"
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