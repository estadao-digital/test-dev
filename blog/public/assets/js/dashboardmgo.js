var page_nid = $(".dashboardmgo").data('nid');
var minutes_default = 0.1;

function dashboardmgo() {
    var $main = $('.main'),
        main = $main.data('layout'),
        $errordashboard = $("#error-dashboard"),
        error = $errordashboard.length > 0 ? $errordashboard.data('error') : false;

    //main.destroy();

    $main.layout({
        applyDefaultStyles: true,
        east__paneSelector: "#ui-layout-east",
        center__paneSelector: "#ui-layout-center",
        east__size: 230,
        east__minSize: 230,
        east__maxSize: 230,
        scrollToBookmarkOnLoad: false
    });

    $("#select-month").chosen().on('chosen:showing_dropdown', function () {
        $('.chosen-results li').each(function () {
            var $li = $(this);
            $li.attr('title', $li.text());
        });
    }).change(function () {
        $(this).closest('form').submit();
    });

    var $user = $("#select-user_id"),
        loaded_list_user = false;


    if ($user.length > 0) {
        get_subordinate($user, error);
        loaded_list_user = true;
    }

    if (error === false) {
        if (!loaded_list_user) {
            date_picker_default();
        }
    } else {
        default_set_loading(error, 'error');
        $("#form-dashboardmgo").find('.remove').remove();
    }

    var count_waggle = localStorage.getItem("count_waggle");

    if (count_waggle != null && count_waggle > 3) {
        $(".dashboardmgo .box-2 .type-chart a").removeClass('waggle');
    }

    load_group_dash();
}

function create_table_thead($table, thead) {

    var output = '';

    $table.prepend('<thead/>');

    var $thead = $table.find('thead');

    for (var t in thead) {
        var tr = thead[t],
            class_tr = '';

        if (t == 'tr-10' || t == 'tr-11') {
            class_tr += ' hide';
        }

        output += "<tr class=\"" + t + class_tr + "\">";

        if (t == 'tr-3' || t == 'tr-7' || t == 'tr-12') {
            output += "<th colspan=\"" + tr + "\"></th>";
            tr = [];
        }

        for (var h in tr) {
            var th = tr[h];

            output += "<th class=\"" + h + (th.primaryid > 0 ? ' secundary secundary-' + th.primaryid : '') + (t == 'tr-4' && !th.secundary ? ' secundary-not' : '') + "\">";
            if (t == 'tr-1') {
                if (h == 'th-1') {
                    output += "<div><div class=\"alert " + (th.score > 0 ? 'alert-success' : 'alert-danger') + "\">" +
                        "<div><p>Você está acumulando</p><h3>" + (th.score > 0 ? '+' : '') + th.score + "</h3><p>Pontos</p></div>" +
                        "</div>";
                    //"<div class=\"alert " + (th.expectedscore > 0 ? 'alert-success' : 'alert-danger') + "\"><div><p>Melhorando seus indicadores, você pode acumular até</p><h3>" + (th.expectedscore > 0 ? '+' : '') + th.expectedscore + "</h3><p>Pontos</p></div></div>";
                } else {

                    if (th.primary) {
                        output += "<div style=\"width: 130px; height: 130px; margin: 0 12px;\" class=\"chart-primary\" id=\"chart-th-" + th.id + "\"></div>";
                    } else {
                        output += "<div style=\"width: 130px;margin: 0 12px;\"></div>";
                    }
                }
            } else if (t == 'tr-2') {
                if (h != 'th-1') {
                    output += th.primaryid == null ? "<button class=\"btn btn-default\" data-id=\"" + th.id + "\"><i class=\"fa fa-area-chart\"></i> Gráfico</button>" : "";
                }
            } else if (t == 'tr-4') {
                if (h != 'th-1') {
                    output += th.name + (th.primaryid == null && th.secundary ? '<span data-id="' + th.id + '"></span>' : '');
                }
            } else if (t == 'tr-5' || t == 'tr-8') {
                if (h == 'th-1') {
                    output += "<span style=\"color:" + th.color + ";\">" + th.name + "</span>";
                } else {
                    output += th.primaryid == null ? "<span style=\"color:" + th.color + ";\">" + th.score + "</span>" : "-";
                }
            } else if (t == 'tr-6' || t == 'tr-9') {
                if (h == 'th-1') {

                    if (t == 'tr-9') {
                        if ($("#select-user_id").length > 0) {
                            th.name = "Resultado até o momento";
                        }
                    }

                    output += "<span style=\"color:" + th.color + ";\">" + th.name + "</span>";
                } else {
                    output += "<span style=\"color:" + th.color + ";\">" + th.result + "</span>";
                }
            } else if (t == 'tr-10') {
                if (h == 'th-1') {
                    output += "<span style=\"color:" + th.color + ";\">" + th.name + "</span>";
                } else {
                    output += th.primaryid == null ? th.newgoal : "-";
                }
            } else if (t == 'tr-11') {
                if (h == 'th-1') {
                    output += "<span style=\"color:" + th.color + ";\">" + th.name + "</span>";
                } else {
                    output += th.primaryid == null ? "<span style=\"color:" + th.expectedcolor + ";\">" + th.expectedscore + "</span>" : "-";
                }
            } else {
                output += th;
            }

            output += "</th>";
        }
        output += "</tr>";
    }

    $thead.html(output);

    $thead.prepend("<tr>" + $thead.find('.tr-4').html() + "</tr>");

    return $table;
}

function create_table_evolution_thead($table, thead) {

    var output = '';

    $table.prepend('<thead/>');

    var $thead = $table.find('thead');

    for (var t in thead) {
        var tr = thead[t],
            class_tr = '';


        output += "<tr class=\"" + t + class_tr + "\">";

        for (var h in tr) {
            var th = tr[h];

            if (t == 'tr-1') {
                if (h == 'th-1') {
                    output += "<th class=\"" + h + "\">";
                    output += "<span class=\"title-th\"><select class=\"form-control\">";
                    for (var o in th) {
                        output += "<option value=\"" + th[o].id + "\">" + th[o].title + "</option>";
                    }
                    output += "</select></span>";
                } else if (h == 'th-2') {
                    output += "<th class=\"" + h + "\">";
                    output += "<span class=\"title-th\">" + th.title + "</span>";
                } else {
                    output += "<th class=\"" + h + " " + th.id.join(' ') + "\">";
                    output += "<span class=\"title-th\">" + th.title + "</span>";
                }
            } else {
                output += "<th class=\"" + h + "\">";
            }

            output += "</th>";
        }
        output += "</tr>";
    }

    $thead.html(output);

    return $table;
}

function create_table_evolution_tbody($table, tbody) {

    var output = '';

    $table.append('<tbody/>');

    var $tbody = $table.find('tbody');

    for (var t in tbody) {
        var tr = tbody[t];

        output += "<tr class=\"" + t + ' ' + tr.id + " hide-show\">";

        for (var h in tr.td) {
            var td = tr.td[h],
                background = "background-color:" + td.background + ";",
                color = "color:" + td.color + ";";

            output += "<td class=\"" + h + "\" " + (background != null ? "style=\"" + background + color + "\"" : "") + ">";

            if (h == 'td-1') {
                output += td.title;
            } else if (h == 'td-2') {
                output += td.score;
            } else {
                output += (td.value_real != undefined ? "<span class=\"hide\">" + td.value_real + "</span>" : '') + "<span>" + td.value + "</span>";
            }
            output += "</td>";
        }

        output += "</tr>";
    }

    $tbody.html(output);

    return $table;
}

function default_set_gauge(gauge, resume, chart_id) {
    var legend = [];

    for (var i in gauge) {

        var item = gauge[i],
            series = [];

        for (var s in item.series) {
            var item_series = item.series[s];

            legend[s] = {
                title: item.point_title[s],
                color: item.point_title_color[s],
                class: item.class_name[s]
            }

            var item_push = {
                name: item.title.text,
                data: item_series.data,
                className: item.class_name[s],
                tooltip: {
                    valueSuffix: item_series.tooltip.valueSuffix,
                    pointFormat: "<div style=\"min-width: 210px;\"><b style=\"color: " + item.point_title_color[s] + ";\">" + item.point_title[s] + "</b><br/><span style=\"display: inline-block; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 180px; float: left;\" title=\"{series.name}\"><span style=\"color:" + item.point_color[s] + "\">\u25CF</span> {series.name}</span> <span style=\"display: inline-block;float: left;\">:<b>{point.y}</b></span></div>",
                },
                dataLabels: {
                    format: item_series.dataLabels.format,
                    y: item.series_dataLabels_y[s],
                    color: item.point_title_color[s],
                    borderColor: item.point_title_color[s],
                    enabled: !resume
                }
                ,
                dial: {
                    backgroundColor: item.point_title_color[s]
                }
            };

            series.push(item_push);
        }

        if (resume) {
            if (item.yAxis.tickPixelInterval == 100) {
                item.yAxis.tickPixelInterval = 50;
            }
        }

        Highcharts.chart(chart_id + item.id, {
            chart: {
                type: 'gauge',
                plotBackgroundColor: null,
                plotBackgroundImage: null,
                plotBorderWidth: 0,
                plotShadow: false
            },

            title: {
                text: resume ? null : "<span class=\"ajust-title\">" + item.title.text + "</span>",
                useHTML: true,
                widthAdjust: 0
            },

            pane: {
                size: '100%',
                startAngle: -150,
                endAngle: 150,
                background: [{
                    backgroundColor: {
                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, '#FFF'],
                            [1, '#333']
                        ]
                    },
                    borderWidth: 0,
                    outerRadius: '109%'
                }, {
                    backgroundColor: {
                        linearGradient: {x1: 0, y1: 0, x2: 0, y2: 1},
                        stops: [
                            [0, '#333'],
                            [1, '#FFF']
                        ]
                    },
                    borderWidth: 1,
                    outerRadius: '107%'
                }, {
                    // default background
                }, {
                    backgroundColor: '#DDD',
                    borderWidth: 0,
                    outerRadius: '105%',
                    innerRadius: '103%'
                }]
            },

            // the value axis
            yAxis: {
                min: item.yAxis.min,
                max: item.yAxis.max,
                minorTickInterval: 'auto',
                minorTickWidth: 1,
                minorTickLength: 10,
                minorTickPosition: 'inside',
                minorTickColor: '#ffffff',

                tickPixelInterval: item.yAxis.tickPixelInterval,
                tickWidth: 2,
                tickPosition: 'inside',
                tickLength: 10,
                tickColor: '#ffffff',
                labels: {
                    step: 1,
                    rotation: 'auto'
                },

                plotBands: item.yAxis.plotBands
            },
            plotOptions: {
                series: {
                    animation: {
                        duration: 2000,
                        easing: function (pos) {
                            if ((pos) < (1 / 2.75)) {
                                return (7.5625 * pos * pos);
                            }
                            if (pos < (2 / 2.75)) {
                                return (7.5625 * (pos -= (1.5 / 2.75)) * pos + 0.75);
                            }
                            if (pos < (2.5 / 2.75)) {
                                return (7.5625 * (pos -= (2.25 / 2.75)) * pos + 0.9375);
                            }
                            return (7.5625 * (pos -= (2.625 / 2.75)) * pos + 0.984375);
                        }
                    }
                }
            },
            series: series,
            tooltip: {
                borderColor: '#e5e5e5',
                borderRadius: 5,
                borderWidth: 1,
                useHTML: true,
                enabled: !resume
            }
        });
    }

    if (resume) {
        $(".dashboardmgo .box-1 .box .chart-table table .class-item-team").hide();
    }

    return legend;
}

function default_create_gauge(data) {

    var $chart = $(".dashboardmgo .box .chart-gauge .charts"),
        gauge = data.gauge,
        legend = [];

    if (Object.keys(gauge).length > 0) {
        default_set_loading('', '', 'hide');


        $chart.show();

        for (var i in gauge) {
            $chart.append("<div id=\"chart-" + gauge[i].id + "\" class=\"chart col-lg-4 col-md-6\"></div>");
        }

        legend = default_set_gauge(gauge, false, 'chart-');

    } else {
        default_set_loading('Houve um erro ao criar os gráficos. Tente novamente mais tarde.', 'error');
    }

    default_set_legend_gauge(legend);

    $(".dashboardmgo .box-2 .type-chart a").click(function () {
        $(".scroll-button").hide();
        $(".dashboardmgo .box-1 .box .chart-change:not(." + $(this).data('id') + ")").slideUp(500);

        $(".dashboardmgo .box-1 .box ." + $(this).data('id')).slideDown(500, function () {
            default_scroll_button();
        });

        $(".dashboardmgo .box-2 .type-chart a").removeClass('active');

        $(this).addClass('active');

        var count_waggle = localStorage.getItem("count_waggle");

        if (count_waggle == null || count_waggle < 3) {

            if ($(this).hasClass('waggle')) {
                localStorage.setItem("count_waggle", (count_waggle == null ? 1 : count_waggle + 1));
            }

            $(".dashboardmgo .box-2 .type-chart a").removeClass('waggle');
            $(".dashboardmgo .box-2 .type-chart a:not(.active)").addClass('waggle');
        } else {
            $(".dashboardmgo .box-2 .type-chart a").removeClass('waggle');
        }
    });
}

function default_post_form() {
    var $form = $("#form-dashboardmgo"),
        action = $form.data('action'),
        data = $form.serialize(),
        time = 500;

    var jqxhr = $.ajax({
        url: action,
        type: "POST",
        dataType: "json",
        data: data,
        success: function (data) {
            if (data.error) {
                default_set_loading(data.error, 'error');
            } else {

                default_updated(data);

                default_set_loading("Gerando gráficos. Aguarde...", 'finish');

                setTimeout(function () {
                    default_create_gauge(data);
                }, 2000);

                default_waiting_table(data);
                default_waiting_table_evolution(data);
            }

            $form.find('.remove').remove();
        }
    });

    var interval = setInterval(function () {
        if (jqxhr.readyState == 4) {
            clearInterval(interval);
        } else {
            default_get_progress();
        }
    }, time);
}

function default_create_table(data) {
    var $chart = $(".dashboardmgo .box-1 .box .chart-table .charts"),
        table = data.table;

    default_set_loading('', '', 'hide', $(".dashboardmgo .box .chart-table .loading"));

    $chart.html("<table/>");

    var $table = $chart.find('table');

    $table = create_table_thead($table, data.table.thead);
    $table = create_table_tbody($table, data.table.tbody);

    default_set_gauge(data.gauge, true, 'chart-th-');

    var data_table = $table.DataTable({
        "paging": false,
        "info": false,
        "bFilter": false,
        "orderCellsTop": true,
        "autoWidth": false,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        }
    });

    $table.find('thead tr:eq(0)').hide();
    $table.find('thead tr:eq(4) th').addClass('sorting');

    $table.on('click', 'tr:eq(4) th', function (event) {
        if (event.target.localName != 'span') {
            var index = $(this).parent().find('th').index(this);
            var cellTop = $(this).closest('thead').find('tr:eq(0) th:eq(' + index + ')');
            $(cellTop).trigger('click');
            $table.find('thead tr:eq(4) th').each(function (i, element) {
                $(element).attr('class', $table.find('thead tr:eq(0) th:eq(' + i + ')').attr('class'));
            });
        }
    });

    $table.on('click', 'tr:eq(4) th span', function () {
        var id = $(this).data('id'),
            $t = $table.find(".secundary.secundary-" + id);

        $(this).toggleClass('open');
        $t.toggleClass('hide');

        default_check_pos();
    });

    $table.find(".secundary").addClass('hide');

    create_graphic($table, data.graphic, data.period_format);
}

function default_create_table_evolution(data) {
    var $chart = $(".dashboardmgo .box-1 .box .chart-table-evolution .charts"),
        table = data.table_evolution;

    default_set_loading('', '', 'hide', $(".dashboardmgo .box .chart-table-evolution .loading"));

    $chart.html("<table/>");

    var $table = $chart.find('table');

    $table = create_table_evolution_thead($table, table.thead);
    $table = create_table_evolution_tbody($table, table.tbody);

    var $select = $table.find("thead .tr-1 .th-1 select");

    $select.chosen();

    var data_table = $table.DataTable({
        "paging": false,
        "info": false,
        "bFilter": false,
        "orderCellsTop": true,
        "autoWidth": false,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        }
    });

    $select.change(function () {
        hide_show_table($table, $(this).val());
    });

    $select.change();

    $select.next('.chosen-container').on('click', function () {
        var $th = $table.find("thead .tr-1 .th-1"),
            sort = 'asc';

        if ($th.hasClass('sorting_asc')) {
            sort = 'desc';
        }

        data_table.order([0, sort]).draw();

    });


    /*

     $table.find('thead tr:eq(0)').hide();
     $table.find('thead tr:eq(4) th').addClass('sorting');

     $table.on('click', 'tr:eq(4) th', function (event) {
     if (event.target.localName != 'span') {
     var index = $(this).parent().find('th').index(this);
     var cellTop = $(this).closest('thead').find('tr:eq(0) th:eq(' + index + ')');
     $(cellTop).trigger('click');
     $table.find('thead tr:eq(4) th').each(function (i, element) {
     $(element).attr('class', $table.find('thead tr:eq(0) th:eq(' + i + ')').attr('class'));
     });
     }
     });

     $table.on('click', 'tr:eq(4) th span', function () {
     var id = $(this).data('id'),
     $t = $table.find(".secundary.secundary-" + id);

     $(this).toggleClass('open');
     $t.toggleClass('hide');

     default_check_pos();
     });

     $table.find(".secundary").addClass('hide');

     create_graphic($table, data.graphic, data.period_format);*/
}

function hide_show_table($table, id) {
    $table.find('.hide-show').hide();
    $table.find('.' + id).show();
}

function default_get_progress() {
    var $loading = $(".dashboardmgo .box .loading");

    if ($loading.data('progress') !== true) {

        $loading.data('progress', true);
        $.ajax({
            'url': './ws/process/get',
            'success': function (data) {
                for (i in data) {
                    var msg = data[i].text;

                    default_set_loading(msg);
                }

                $loading.data('progress', false);
            }
        });

    }
}

function default_check_pos() {
    var $box = $(".dashboardmgo .box-1 .box"),
        $button_left = $(".scroll-button.button-left"),
        $button_right = $(".scroll-button.button-right");

    if (($box[0].scrollWidth - $box[0].clientWidth) == 0) {
        $button_left.hide();
        $button_right.hide();
    } else if ($box[0].scrollLeft == 0) {
        $button_left.hide();
        $button_right.show();
    } else if ($box[0].scrollLeft >= ($box[0].scrollWidth - $box[0].clientWidth)) {
        $button_left.show();
        $button_right.hide();
    } else {
        $button_left.show();
        $button_right.show();
    }
}

function default_scroll_button() {
    var $box = $(".dashboardmgo .box-1 .box"),
        $button = $(".scroll-button");

    default_check_pos();

    if ($box.data('load-scroll') != true) {

        $box.scroll(function () {
            default_check_pos();
        });

        $button.css({
            'top': $box[0].offsetTop + 'px',
            'height': $box[0].clientHeight + 'px'
        });

        $button.on('mouseenter mousedown mouseup', function (event) {
            var scrolleft = $(this).hasClass('button-right') ? ($box[0].scrollWidth - $box[0].clientWidth) : 0;
            $box.data('direction', $(this).hasClass('button-right'));
            if (event.type == 'mouseenter') {
                $box.stop();
                $box.animate({scrollLeft: scrolleft}, 5000, "easeInOutQuad");
            } else if (event.type == 'mousedown') {
                $box.stop();
                $box.animate({scrollLeft: scrolleft}, 500, "easeInOutQuad");
            } else if (event.type == 'mouseup') {
                $box.stop();
                $box.animate({scrollLeft: scrolleft}, 5000, "easeInOutQuad");
            }
        }).mouseout(function () {
            $box.stop();
        });
        $box.data('load-scroll', true);
    }
}

function default_set_loading(text, status_class, status, $local) {
    var $loading = $local == undefined ? $(".dashboardmgo .box .chart-gauge .loading") : $local,
        status_class = status_class == undefined ? '' : status_class;

    if ($loading.data('status') != true) {

        $loading.addClass(status_class).find('.msg').text(text);

        if (status_class == 'error') {
            $loading.data('status', true);
            default_updated({datetime: new Date()}, 0.001);
        }

        if (status_class == 'finish') {
            $loading.data('status', true);
        }
    }

    if (status == "remove") {
        $loading.remove();
    }

    if (status == "reload") {
        $loading.data('status', false).removeClass('error');
    }

    if (status == "hide") {
        $loading.hide();
    }
}

function default_set_legend_gauge(legend) {
    var $legend = $(".dashboardmgo .box-1 .box .chart-gauge .legend"),
        $charts = $(".dashboardmgo .box-1 .box .chart-gauge .charts"),
        output = '',
        all_class = [];

    if (legend.length > 0) {

        for (i in legend) {

            all_class.push(legend[i].class);

            if ($("#select-user_id").length > 0) {
                legend[i].title = legend[i].class == "class-item-me" ? "Resultado" : "Resultado da equipe";
            }

            output += fill_template($legend, legend[i]);
        }

        $legend.html(output);

        $legend.find('a').click(function () {
            var $a = $(this);

            if ($legend.hasClass('legend-' + $a.data('class'))) {
                $legend.removeClass('legend-' + all_class.join(' legend-'));
                $('.' + all_class.join(', .'), $charts).show();
            } else {
                $legend.removeClass('legend-' + all_class.join(' legend-'));
                $legend.addClass('legend-' + $a.data('class'));
                $('.' + all_class.join(', .'), $charts).hide();
                $('.' + $a.data('class'), $charts).show();
            }
        });

        $legend.find('a').mouseenter(function () {
            var $a = $(this),
                opacity = false;

            for (var i in all_class) {
                if ($legend.hasClass('legend-' + all_class[i])) {
                    opacity = true;
                    break;
                }
            }

            if (!opacity) {
                $('.' + all_class.join(', .'), $charts).css({'opacity': '.3'});
                $('.' + $a.data('class'), $charts).css({'opacity': '1'});
            }

        }).mouseout(function () {
            var $a = $(this);

            $('.' + all_class.join(', .'), $charts).css({'opacity': '1'});
        });

        $legend.show(500);
    }
}

function default_waiting_table(data) {
    $(".dashboardmgo .box-2 .type-chart a[data-id='chart-table']").click(function () {
        if ($(this).data('loaded') != true) {
            default_create_table(data);
            $(this).data('loaded', true);
        }
    });
}

function default_waiting_table_evolution(data) {
    $(".dashboardmgo .box-2 .type-chart a[data-id='chart-table-evolution']").click(function () {
        if ($(this).data('loaded') != true) {
            default_create_table_evolution(data);
            $(this).data('loaded', true);
        }
    });
}

function default_updated(data, minutes) {
    var minutes = minutes == undefined ? minutes_default : minutes,
        $small = $(".dashboardmgo h1.title small"),
        $a = $(".dashboardmgo h1.title a.updated-btn"),
        datetime = new Date(data.datetime),
        datetime_day = new Date(datetime.getFullYear(), datetime.getMonth(), datetime.getDate()),
        today = new Date(),
        today_compare = new Date(today.getFullYear(), today.getMonth(), today.getDate()),
        inittime = datetime.getTime(),
        text_updated = "Atualizado " +
            (datetime_day.getTime() == today_compare.getTime() ? "hoje" : "em " +
                (datetime.getDate() > 9 ? datetime.getDate() : '0' + datetime.getDate()) +
                '/' + (datetime.getMonth() > 9 ? datetime.getMonth() : '0' + datetime.getMonth()) + '' +
                '/' + datetime.getFullYear()) +
            " às " + datetime.getHours() + ":" + (datetime.getMinutes() > 9 ? datetime.getMinutes() : '0' + datetime.getMinutes());

    var interval = setInterval(function () {
        var endtime = new Date().getTime();

        if ((endtime - inittime) > (60000 * minutes)) {
            var href = window.location.href;

            href = href.replace("&update=1", '').replace("?update=1", '');

            $a.attr('href', href + (href.indexOf('?') !== -1 ? '&' : '?') + 'update=1');

            clearInterval(interval);
        }
    }, 1000);

    $a.click(function () {
        var href = $(this).attr('href'),
            cache_page = $(this).data('cache'),
            clear_cache_url = $(this).data('clear_cache_url');

        if (href != undefined) {
            $(this).removeAttr('href');
            $.post(clear_cache_url, {cache_page: cache_page}, function () {
                window.location = href;
            });
        }

        return false;
    });

    $small.text(text_updated);
}

function get_subordinate($user, error) {

    var subordinate = $user.data('subordinate'),
        current_subordinate = $user.data('current-subordinate') != null ? $user.data('current-subordinate') : {},
        url;

    get_template($user);

    $user.attr('disabled', 'disabled').html('<option>Carregando...</option>').chosen();

    if (subordinate) {
        url = './ws/user/get_hierarchy/' + page_nid;
        $.get(url, function (data) {
            var output = '<option></option>',
                my_subordinate = false;

            for (i in data) {

                if (current_subordinate.id == data[i].id) {
                    my_subordinate = true;
                }

                data[i].agentid = data[i].agentid != null && data[i].agentid != '' ? " - " + data[i].agentid : '';

                output += fill_template($user, data[i]);
            }

            $user.html(output);

            $user.val(current_subordinate.id).change();
            $user.data('redirect', true);

            $user.removeAttr('disabled');

            $user.trigger('chosen:updated').on('chosen:showing_dropdown', function () {
                $('.chosen-results li').each(function () {
                    var $li = $(this);
                    $li.attr('title', $li.text());
                });
            }).change(function () {
                if ($user.data('redirect') == true) {
                    $(this).closest('form').submit();
                }
            });

            if (error === false) {

                if (my_subordinate) {
                    date_picker_default();
                } else {
                    default_set_loading("Selecione um " + $user.data('label') + ".", 'error');
                }

            } else {
                default_set_loading(error, 'error');
                $("#form-dashboardmgo").find('.remove').remove();
            }

        });
    } else {
        url = './ws/user/get_basic/0/id_name_lastname_agentid?limit=100';

        var where = {nid: page_nid};

        if (page_nid == 0) {
            where.agentid_not_null = 1;
        }

        $.post(url, where, function (data) {
            var output = '<option></option>';

            if (current_subordinate.id != undefined) {
                output += "<option value=\"" + current_subordinate.id + "\">" + current_subordinate.name + " " + current_subordinate.lastname + " - " + current_subordinate.agentid + "</option>";
            }

            for (i in data) {

                data[i].agentid = data[i].agentid != null && data[i].agentid != '' ? " - " + data[i].agentid : '';

                output += fill_template($user, data[i]);
            }

            $user.html(output);

            var $option_repeat = $user.find('option[value=\"' + current_subordinate.id + '\"]');

            if ($option_repeat.length > 1) {
                $option_repeat[0].remove();
            }

            $user.val(current_subordinate.id).change();
            $user.data('redirect', true);

            $user.removeAttr('disabled');

            $user.chosen('destroy');

            $user.ajaxChosen({
                type: 'POST',
                url: url,
                data: where,
                dataType: 'json',
                keepTypingMsg: "Continue digitando...",
                lookingForMsg: "Procurando por",
                jsonTermKey: "q"
            }, function (data) {
                var results = [];

                $.each(data, function (i, val) {
                    results.push({
                        value: val.id,
                        text: val.name + ' ' + val.lastname + (val.agentid != null && val.agentid != '' ? ' - ' + val.agentid : '')
                    });
                });

                return results;
            }).on('chosen:showing_dropdown', function () {
                $('.chosen-results li').each(function () {
                    var $li = $(this);
                    $li.attr('title', $li.text());
                });
            }).change(function () {
                if ($user.data('redirect') == true) {
                    $(this).closest('form').submit();
                }
            });

            if (error === false) {
                date_picker_default();
            } else {
                default_set_loading(error, 'error');
                $("#form-dashboardmgo").find('.remove').remove();
            }
        });
    }
}

function date_picker_default() {

    var $form = $("#form-dashboardmgo"),
        $datepicker_container = $form.find(".datepicker-input"),
        $periodformat = $form.find("input.radio-format");

    $.post($datepicker_container.data('url'), {
        'token': $datepicker_container.data('token'),
        'data': $datepicker_container.data('data')
    }, function (data) {
        $periodformat.data('interval', data);
        date_picker_load($form, true);

        default_post_form();
    }, "json");

    $periodformat.on('change', function () {
        date_picker_load($form);
    });

}

function date_picker_load($form, date) {
    var $periodformat = $form.find("input.radio-format"),
        type_format = $form.find("input.radio-format:checked").val(),
        $datepicker_container = $form.find(".datepicker-input"),
        $datepicker = $datepicker_container.find('.input-daterange'),
        interval = $periodformat.data('interval'),
        startDate = interval.min,
        startDate_array = startDate.split('-'),
        endDate = interval.max,
        endDate_array = endDate.split('-'),
        options = {
            language: "pt-BR",
            todayHighlight: true,
            startDate: startDate,
            endDate: endDate

        },
        formats = [],
        html = "<div class=\"input-daterange input-group\">" +
            "<input type=\"text\" class=\"input-sm form-control input-start\" name=\"date[]\" required>" +
            "<span class=\"input-group-addon\">até</span>" +
            "<input type=\"text\" class=\"input-sm form-control input-end\" name=\"date[]\" required>" +
            "</div>";

    formats['Y'] = {'minViewMode': 2, 'format': "yyyy", 'startDate': startDate_array[0], 'endDate': endDate_array[0]};
    formats['Y-m'] = {
        'minViewMode': 1,
        'format': "yyyy-mm",
        'startDate': startDate_array[0] + "-" + startDate_array[1],
        'endDate': endDate_array[0] + "-" + endDate_array[1]
    };
    formats['Y-m-d'] = {'minViewMode': 0, 'format': "yyyy-mm-dd", 'startDate': startDate, 'endDate': endDate};

    options.minViewMode = formats[type_format].minViewMode;
    options.format = formats[type_format].format;
    options.startDate = formats[type_format].startDate;
    options.endDate = formats[type_format].endDate;

    if ($datepicker.length == 0) {
        $datepicker_container.html(html);
    } else {
        $datepicker.datepicker('remove');
        $datepicker_container.html(html);
    }

    $datepicker = $datepicker_container.find('.input-daterange');

    if (date === true) {
        var date = $datepicker_container.data('date');
        for (var i in date) {
            $datepicker.find('input:eq(' + i + ')').val(date[i]);
        }
    }

    $datepicker.datepicker(options);

    $datepicker.find('.input-start').change(function () {
        if ($datepicker.find('.input-end').val() == '') {
            $datepicker.find('.input-end').val($(this).val());
        }
    });
}

function load_group_dash() {
    var $btn_all = $("#form-dashboardmgo .select-group label a"),
        $select = $("#form-dashboardmgo .select-group #select-group"),
        $in_user_id = $("#form-dashboardmgo .select-group #in-user-id"),
        user_id = $select.data('user-id');

    $select.chosen();


    if ($select.length > 0) {
        $.post('./ws/user/get_hierarchy/' + (page_nid - 1), {user_id: user_id, nid: page_nid}, function (data) {
            var users_id = [];

            for (var i in data) {
                users_id.push(data[i].id);
            }

            $.post('./ws/group/get_groupuser', {user_id: users_id}, function (data) {
                var output = '',
                    all_group = [],
                    group = [];

                for (var i in data) {
                    group[data[i].id] = {
                        id: data[i].id,
                        name: data[i].name,
                        user_id: []
                    };
                }

                for (var i in data) {
                    group[data[i].id].user_id.push(data[i].user_id);
                }

                for (var i in group) {
                    group[i].value = group[i].id + '-' + group[i].user_id.join(',');
                    all_group.push(group[i].value);
                    output += fill_template($select, group[i]);
                }

                $select.chosen('destroy');

                $select.html(output).removeAttr('disabled');
                $select.attr('data-placeholder', 'Selecione:');

                $select.change(function () {
                    var value = $(this).val(),
                        n_value = [];

                    for (var i in value) {
                        if ($.inArray(value[i], n_value) == -1) {
                            var value_exp = value[i].split('-');
                            n_value.push(value_exp[1]);
                        }
                    }

                    $in_user_id.val(n_value.join(','));
                });

                if ($select.data('selected') != null) {
                    $select.val($select.data('selected')).change();
                } else {
                    $select.val(all_group).change();
                }

                $select.chosen();

                $btn_all.click(function () {
                    if ($(this).hasClass('select-all')) {
                        $select.val(all_group).change();
                    } else {
                        $select.val([]).change();
                    }

                    $select.trigger('chosen:updated');
                });


            });

        });


    }


}
