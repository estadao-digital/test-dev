$(function () {
    dashboardmgo();
});

function create_table_tbody($table, tbody) {

    var output = '',
        $form = $("#form-dashboardmgo"),
        url_param = '?',
        data = $form.serializeArray();

    for (var i in data) {
        if (data[i].name != 'user_id' && data[i].name != 'in_user_id' && data[i].name != 'select_group[]') {
            url_param += data[i].name + '=' + data[i].value + '&';
        }
    }

    $table.append('<tbody/>');

    var $tbody = $table.find('tbody');

    for (var t in tbody) {
        var tr = tbody[t];

        output += "<tr class=\"" + t + "\">";

        for (var h in tr) {
            var td = tr[h],
                url = "./dashboard-mgo/grafico-de-desempenho/" + (page_nid - 1) + url_param + "user_id=" + td.id;

            output += "<td class=\"" + h + (td.primaryid > 0 ? ' secundary secundary-' + td.primaryid : '') + "\">";

            if (h == 'td-1') {
                output += "<div class=\"dash-user-info\">" +
                    (td.img !== null && td.img != '' ? "<img src=\"" + td.img + "\" onclick=\"user_info(" + td.id + ");\">" : "") +
                    "<a href=\"" + url + "\" title=\"" + td.name + "\">" + td.name + "</a>" +
                    "<div class=\"clearfix\"></div>";
                "</div>";
            } else {
                output += (td.value_real != undefined ? "<span class=\"hide\">" + td.value_real + "</span>" : '') + "<span style=\"color:" + td.color + "\">" + td.value + "</span>";
            }
            output += "</td>";
        }

        output += "</tr>";
    }

    $tbody.html(output);

    return $table;
}

function set_graphic($modal, graphic, chart_id, period_format) {
    var legend = [],
        series = [],
        series_off = [],
        date_min = graphic.xAxis.min,
        date_max = graphic.xAxis.max,
        graphic_xAxis_min,
        graphic_xAxis_max,
        tolltip_xDateFormat = '%d de %B de %Y';

    date_min = date_min.split('-');
    date_max = date_max.split('-');

    if (period_format == "Y") {
        graphic_xAxis_min = Date.UTC(parseInt(date_min[0]));
        graphic_xAxis_max = Date.UTC(parseInt(date_max[0]));
        tolltip_xDateFormat = '%Y';

    } else if (period_format == "Y-m") {
        graphic_xAxis_min = Date.UTC(parseInt(date_min[0]), parseInt(date_min[1]) - 1);
        graphic_xAxis_max = Date.UTC(parseInt(date_max[0]), parseInt(date_max[1]) - 1);
        tolltip_xDateFormat = '%B de %Y';
    } else {
        graphic_xAxis_min = Date.UTC(parseInt(date_min[0]), parseInt(date_min[1]) - 1, parseInt(date_min[2]));
        graphic_xAxis_max = Date.UTC(parseInt(date_max[0]), parseInt(date_max[1]) - 1, parseInt(date_max[2]));
    }

    $modal.find('.modal-header .modal-title').html(graphic.title);

    for (var s in graphic.series) {
        var graphic_series = graphic.series[s],
            data = [];

        for (var i in graphic_series.data) {
            var data_series = graphic_series.data[i],
                date = data_series.date.split('-'),
                date_x;

            if (period_format == "Y") {
                date_x = Date.UTC(parseInt(date[0]));
            } else if (period_format == "Y-m") {
                date_x = Date.UTC(parseInt(date[0]), parseInt(date[1]) - 1);
            } else {
                date_x = Date.UTC(parseInt(date[0]), parseInt(date[1]) - 1, parseInt(date[2]));
            }

            data.push({
                x: date_x,
                y: data_series.value,
                color: data_series.color
            });
        }

        var graphic_push = {
            id: 'series-' + s,
            name: graphic_series.name,
            data: data,
            color: graphic_series.color,
            marker: {
                symbol: "circle"
            },
            //className: graphic.class_name[s],
            tooltip: {
                valueSuffix: graphic.tooltip.valueSuffix,
                pointFormat: "<div style=\"color: " + graphic_series.color + "\"><span style=\"color:{point.color}\">\u25CF</span> " + graphic_series.name + ": <span style=\"color:{point.color}\">{point.y}</span></div>",
            }
        };


        series_off.push(graphic_push);

        if (s == 0) {
            series.push(graphic_push);
        }
    }

    var chart = Highcharts.chart(chart_id, {
        chart: {
            zoomType: 'yx'
        },
        title: {
            text: null
        },
        xAxis: {
            dateTimeLabelFormats: {
                day: '%e de %b',
                month: '%b de %Y',
                year: '%Y'
            },
            crosshair: {
                width: 1,
                color: '#8d8d8d',
                dashStyle: 'shortdot'
            },
            type: 'datetime',
            min: graphic_xAxis_min,
            max: graphic_xAxis_max,
            labels: {
                style: {
                    color: '#636363',
                    'font-weight': 'bold'
                }
            }
        },
        yAxis: {
            title: {
                text: ''
            },
            endOnTick: false,
            maxPadding: 0,
            crosshair: {
                width: 1,
                color: '#8d8d8d',
                dashStyle: 'shortdot'
            },
            min: graphic.yAxis.min,
            max: graphic.yAxis.max,
            plotBands: graphic.yAxis.plotBands,
            labels: {
                style: {
                    color: '#636363',
                    'font-weight': 'bold'
                }
            }
        },
        credits: {
            enabled: false
        },
        tooltip: {
            headerFormat: '<div style="background: #FFF; padding: 5px;"><div style="font-size: 12px; text-align: center; padding-bottom: 3px; font-weight: bold; color: #636363;">{point.key}</div>',
            footerFormat: '</div>',
            padding: 1,
            backgroundColor: '#FFFFFF',
            useHTML: true,
            xDateFormat: tolltip_xDateFormat,
            shared: true,
            positioner: function (boxWidth, boxHeight, point) {
                var x = point.plotX > ((this.chart.plotWidth - boxWidth) - (boxWidth / 2)) ? 60 : this.chart.plotWidth - (boxWidth - 30);
                return {x: x, y: 20};
            }
        },
        legend: {
            labelFormatter: function () {
                return '<div class="label" style="background-color: ' + this.color + ';margin-bottom: 5px;">' + this.name + '</div>';
            },
            useHTML: true,
            symbolPadding: 0,
            symbolWidth: 0,
            symbolHeight: 0,
            symbolRadius: 0,
            itemStyle: {
                'font-size': '15px',
                color: "#FFFFFF",
                opacity: 1,
                'font-family': 'Ubuntu, sans-serif',
                'font-weight': 400
            },
            itemMarginTop: 3,
            itemDistance: 2,
            itemHiddenStyle: {opacity: .4},
            itemHoverStyle: {opacity: .6}
        },
        series: series

    });

    var $list = $modal.find(".modal-body .panel-bottom ul"),
        output = '';

    for (i in series_off) {
        if (series_off[i].id != "series-0") {
            output += fill_template($list, series_off[i]);
        }
    }

    $list.html(output);

    filter_users($list, chart, series_off);

    $modal.data('chart', chart);

    panel_resize();
}

function create_graphic($table, graphic, period_format) {
    $table.find('thead tr:eq(2) th button').click(function () {
        var $modal = $("#modal-graphic"),
            id = parseInt($(this).data('id')),
            chart_id = "chart-graphic-" + id,
            new_graphic = false;

        if ($modal.find('.modal-body .panel-top #' + chart_id).length > 0) {
            $modal.find('.modal-body .panel-top #' + chart_id).remove();
        }

        new_graphic = true;
        $modal.find('.modal-body .panel-top').append("<div id=\"" + chart_id + "\" style=\"width: 100%;\"></div>");

        $modal.find('.modal-body .panel-top > div').hide(0);

        $modal.find('.modal-body .panel-top #' + chart_id).show(0);

        $modal.modal('show').on('shown.bs.modal', function () {

            if ($modal.data('layout') != true) {
                var maxSize = $modal.find(".modal-body").height() / 2,
                    minSize = (maxSize / 5) * 1.5;

                maxSize = maxSize - ((maxSize / 2) / 2);

                $modal.find(".modal-body").layout({
                    applyDefaultStyles: true,
                    size: minSize,
                    minSize: minSize,
                    maxSize: maxSize,
                    onresize: function () {
                        panel_resize();
                    }
                });

                $modal.data('layout', true);
            }

            if (new_graphic) {
                set_graphic($modal, graphic[id], chart_id, period_format);
            }
        });
    });
}

function filter_users($list, chart, series_off) {
    var $li = $list.find("li"),
        $input = $("#modal-graphic .modal-body .panel-bottom .filter-user #search-user"),
        $label = $li.find("label:not(.checkbox)");

    $label.each(function (i, element) {
        $(this).data('text', $(element).text());
    });

    $input.off('keyup').val('');

    $input.on('keyup', function () {
        var text = $(this).val();

        $label.each(function (i, element) {
            $(element).html($(element).data('text'));
        });

        if (text.length > 0) {
            $li.hide();
            $label.filter(function () {
                var pos = $(this).text().toLowerCase().indexOf(text.toLowerCase()),
                    data_text = $(this).data('text');

                if (pos >= 0) {
                    var rep = data_text.substr(pos, text.length);
                    data_text = data_text.replace(rep, "<span style=\"text-decoration: underline;\">" + rep + "</span>");

                    $(this).html(data_text);
                } else {
                    $(this).html(data_text);
                }

                return pos >= 0;
            }).closest('li').show();

        } else {
            $li.show();
        }
    });

    $li.find("label input").off('change');

    $li.find("label input").on('change', function () {
        var $input = $(this),
            value = $input.val();

        if ($input.is(':checked')) {
            chart.addSeries(series_off[parseInt(value.replace("series-", ''))]);
            $input.closest('li').addClass('active');
        } else {
            chart.get(value).remove();
            $input.closest('li').removeClass('active');
        }
    });
}

function panel_resize() {
    var $modal = $("#modal-graphic"),
        chart = $modal.data('chart'),
        $panel_top = $modal.find('.modal-body .panel-top'),
        panel_top_h = $panel_top.height();

    chart.setSize(null, panel_top_h, false);
}