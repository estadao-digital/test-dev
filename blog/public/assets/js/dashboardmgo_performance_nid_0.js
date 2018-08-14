$(function () {
    dashboardmgo();
});

function create_table_tbody($table, tbody) {

    var output = '';

    $table.append('<tbody/>');

    var $tbody = $table.find('tbody');

    for (var t in tbody) {
        var tr = tbody[t];

        output += "<tr class=\"" + t + "\">";

        for (var h in tr) {
            var td = tr[h];

            output += "<td class=\"" + h + (td.primaryid > 0 ? ' secundary secundary-' + td.primaryid : '') + "\">";

            if (h == 'td-1') {
                output += td;
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
            name: graphic_series.name,
            data: data,
            color: graphic_series.color,
            //className: graphic.class_name[s],
            tooltip: {
                valueSuffix: graphic.tooltip.valueSuffix,
                pointFormat: "<div style=\"color: " + graphic_series.color + "\"><span style=\"color:{point.color}\">\u25CF</span> " + graphic_series.name + ": <span style=\"color:{point.color}\">{point.y}</span></div>",
            }
        };

        series.push(graphic_push);
    }


    Highcharts.chart(chart_id, {
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
            headerFormat: '<div style="font-size: 12px; text-align: center; padding-bottom: 3px; font-weight: bold; color: #636363;">{point.key}</div>',
            useHTML: true,
            xDateFormat: tolltip_xDateFormat,
            shared: true
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
}

function create_graphic($table, graphic, period_format) {
    $table.find('thead tr:eq(2) th button').click(function () {
        var $modal = $("#modal-graphic"),
            id = parseInt($(this).data('id')),
            chart_id = "chart-graphic-" + id,
            new_graphic = false;

        if ($modal.find('.modal-body #' + chart_id).length == 0) {
            new_graphic = true;
            $modal.find('.modal-body').append("<div id=\"" + chart_id + "\" style=\"width: 100%; height: calc(100vh - 220px);\"></div>");
        }

        $modal.find('.modal-body > div').hide(0);

        $modal.find('.modal-body #' + chart_id).show(0);

        $modal.modal('show').on('shown.bs.modal', function () {
            if (new_graphic) {
                set_graphic($modal, graphic[id], chart_id, period_format);
            }
        });
    });
}