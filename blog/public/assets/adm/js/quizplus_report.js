$(function () {
    $('[data-toggle="tooltip"]').tooltip();

    $(".quizplus-filter .close-filter").click(function () {
        $(".quizplus-filter").addClass("closed");
        $(".quizplus-filter").removeClass("add-filter");
        localStorage.setItem("quizplus-filter", 0);
        return false;
    });

    $(".quizplus-filter .open-filter").click(function (e) {
        e.preventDefault();
        $(".quizplus-filter").removeClass("closed");
        $(".quizplus-filter").addClass("add-filter");
        localStorage.setItem("quizplus-filter", 1);
        return false;
    });

    if (localStorage.getItem("quizplus-filter") == 1) {

        $(".close-filter").hide();
        $(".quizplus-filter .open-filter").click();
    } else {

        $(".open-filter").hide();
        $(".quizplus-filter .close-filter").click();
    }
    action_form_filter("#form-quizplus-filter");
});


$(document).ready(function () {
    $('#start_date').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'pt-br',
        ignoreReadonly: true,
        allowInputToggle: true,
    });
    $('#end_date').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'pt-br',
        ignoreReadonly: true,
        allowInputToggle: true,
    });

    var today = new Date();
    $('#start_date').data("DateTimePicker").date(new Date(today.getFullYear(), today.getMonth(), 1));
    $('#end_date').data("DateTimePicker").date(new Date(new Date(today.getFullYear(), today.getMonth(), today.getDate())));

    $(".period").chosen().change(function () {
        var today = new Date();
        var newdate = new Date();
        switch ($("#period").val()) {
            case '1':
                $("#start_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '2':
                newdate.setDate(today.getDate() - 1);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                break;
            case '3':
                $("#start_date").data("DateTimePicker").date(moment(getPreviousMonday()).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '4':
                newdate.setDate(today.getDate() - 7);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '5':
                $("#start_date").data("DateTimePicker").date(moment(new Date(today.getFullYear(), today.getMonth(), 1)).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(new Date(today.getFullYear(), today.getMonth() + 1, 0)).format('DD/MM/YYYY'));
                break;
            case '6':
                newdate.setDate(today.getDate() - 30);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '7':
                newdate.setMonth(today.getMonth() - 3);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '8':
                $("#start_date").data("DateTimePicker").date(moment(new Date(today.getFullYear(), 0, 1)).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '9':
                newdate.setMonth(today.getMonth() - 12);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
        }
    });
    function getPreviousMonday() {
        var date = new Date();
        var day = date.getDay();
        var prevMonday;
        if (date.getDay() == 0) {
            prevMonday = new Date().setDate(date.getDate() - 6);
        }
        else {
            prevMonday = new Date().setDate(date.getDate() + 1 - day);
        }

        return prevMonday;
    }

    $(".btn-group-clear-filter").hide();

    $(".close-filter").click(function () {
        $(".quizplus-filter").addClass("closed").css({
            'background': 'url(./assets/img/filter.png)',
            'padding-left': '30px'
        });
        localStorage.setItem("quizplus-filter", 0);
        return false;
    });

    $(".open-filter").click(function (e) {
        e.preventDefault();
        $(".quizplus-filter").removeClass("closed").css({'background': 'url()', 'padding-left': '0'});

        localStorage.setItem("quizplus-filter", 1);

        return false;
    });

    graph_angle('% de aderência', '% de Aderencia', 'content-aderencia', 20);
    graph_angle('% de pontos conquistados', '% de pontos conquistados', 'content-conquistado', 30);
    graph_angle('% de acertos', '% de acertos', 'content-acertos', 45.7);
    graph_angle('% de aprovados', '% de aprovados', 'content-aprovados', 10);

    function graph_angle(text_title,title_series,div, total) {
        var gaugeOptions = {
            chart: {
                type: 'solidgauge'
            },
            title: null,

            pane: {
                center: ['50%', '80%'],
                size: '100%',
                startAngle: -90,
                endAngle: 90,
                background: {
                    backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || '#EEE',
                    innerRadius: '60%',
                    outerRadius: '100%',
                    shape: 'arc'
                }
            },

            tooltip: {
                enabled: false
            },

            // the value axis
            yAxis: {
                stops: [
                    [1, '#337ab7'],
                ],
                lineWidth: 0,
                minorTickInterval: null,
                tickAmount: 2,
                title: {
                    y: -80
                },
                labels: {
                    y: 16
                }
            },

            plotOptions: {
                solidgauge: {
                    dataLabels: {
                        y: -50,
                        borderWidth: 0,
                        useHTML: true
                    }
                }
            }
        };

// The speed gauge
        var chartSpeed = Highcharts.chart(div, Highcharts.merge(gaugeOptions, {
            yAxis: {
                min: 0,
                max: 100,
                title: {
                    text: text_title,
                    style: {
                        color: '#000',
                        fontWeight: 'bold',
                        fontSize:'16px'
                    }
                }
            },

            credits: {
                enabled: false
            },

            series: [{
                name: title_series,
                data: [total],
                dataLabels: {
                    format: '<div style="text-align:center;"><span style="font-size:30px;color:' +
                    ((Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black') + '">{y}%</span><br/>'
                },
            }]

        }));
    }
    var title = 'Quiz';
    var categories = ['um', 'dois', 'tres', 'quatro','cinco'];
    var data = [20, 54, 50, 40, 38];
    $('#agrupamento1').click(function () {
        alert('modal');
    });

    aba2graf('Quiz', categories, data, 'agrupamento1');
    aba2graf('Tipo', categories, data, 'agrupamento2');
    aba2graf('Instrutor', categories, data,'agrupamento3');
    aba2graf('Modelo', categories, data,'agrupamento4');
    aba2graf('Turma', categories, data,'agrupamento5');

    function aba2graf(title, categories, data, div) {
        Highcharts.chart(div, {
            chart: {
                type: 'bar'
            },
            title: {
                text: title
            },
            xAxis: {
                categories: categories,
                title: {
                    text: null
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Total',
                    align: 'high'
                },
                labels: {
                    overflow: 'justify'
                }
            },
            tooltip: {
                valueSuffix: ' Total'
            },
            plotOptions: {
                bar: {
                    dataLabels: {
                        enabled: true
                    }
                }
            },
            credits: {
                enabled: false
            },
            series: [{
                name: title,
                data: data
            }]
        });
    }

    function timelinequiz() {
        Highcharts.chart('content-timeline', {
            chart: {
                zoomType: 'xy'
            },
            title: {
                text: 'Linha do tempo'
            },
            subtitle: {
                text: 'Quantidade de respostas e média de acertos'
            },
            xAxis: [{
                categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                    'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                crosshair: true
            }],
            yAxis: [{ // Secondary yAxis
                title: {
                    text: 'Porcentagem de acertos',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                labels: {
                    format: '{value}%',
                    style: {
                        color: Highcharts.getOptions().colors[0]
                    }
                },
                opposite: true
            },
                { // Primary yAxis
                    labels: {
                        format: '{value}',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    },
                    title: {
                        text: 'Respostas',
                        style: {
                            color: Highcharts.getOptions().colors[1]
                        }
                    }
                }],
            tooltip: {
                shared: true
            },
            legend: {
                layout: 'vertical',
                align: 'left',
                x: 120,
                verticalAlign: 'top',
                y: 100,
                floating: true,
                backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
            },
            series: [{
                name: 'Respostas',
                type: 'column',
                yAxis: 1,
                data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],

            }, {
                name: '% de acertos',
                type: 'spline',
                data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
            }]
        });
    }

    function drillDrops(title, div) {
        Highcharts.chart(div, {
            chart: {
                type: 'bar'
            },
            title: {
                text: title
            },
            xAxis: {
                type: 'category'
            },
            yAxis: {
                title: {
                    text: 'Porcentagem de Acertos'
                }

            },
            legend: {
                enabled: false
            },
            plotOptions: {
                series: {
                    borderWidth: 0,
                    dataLabels: {
                        enabled: true,
                        format: '{point.y:.1f}%'
                    }
                }
            },


            series: [{

                name: 'Perguntas',
                colorByPoint: true,
                data: [{
                    name: 'Pergunta 1',
                    y: 56.33,
                    drilldown: 'Pergunta 1'
                }, {
                    name: 'Pergunta 2',
                    y: 24.03,
                    drilldown: 'Pergunta 2'
                }, {
                    name: 'Pergunta 3',
                    y: 10.38,
                    drilldown: 'Pergunta 3'
                }, {
                    name: 'Pergunta 4',
                    y: 4.77,
                    drilldown: 'Pergunta 4'
                }, {
                    name: 'Pergunta 5',
                    y: 0.91,
                    drilldown: 'Pergunta 5'
                }]
            }],
            drilldown: {
                yAxis: {
                    title: {
                        text: 'Porcentagem de Respostas'
                    }

                },
                series: [{
                    name: 'Pergunta 1',
                    id: 'Pergunta 1',
                    data: [
                        [
                            'Resposta 1',
                            24.13
                        ],
                        [
                            'Resposta 2',
                            17.2
                        ],
                        [
                            'Resposta 3',
                            8.11
                        ]
                    ]
                }, {
                    name: 'Pergunta 2',
                    id: 'Pergunta 2',
                    data: [
                        [
                            'Resposta 1',
                            24.13
                        ],
                        [
                            'Resposta 2',
                            17.2
                        ],
                        [
                            'Resposta 3',
                            8.11
                        ]
                    ]
                }, {
                    name: 'Pergunta 3',
                    id: 'Pergunta 3',
                    data: [
                        [
                            'Resposta 1',
                            24.13
                        ],
                        [
                            'Resposta 2',
                            17.2
                        ],
                        [
                            'Resposta 3',
                            8.11
                        ]
                    ]
                }, {
                    name: 'Pergunta 4',
                    id: 'Pergunta 4',
                    data: [
                        [
                            'Resposta 1',
                            24.13
                        ],
                        [
                            'Resposta 2',
                            17.2
                        ],
                        [
                            'Resposta 3',
                            8.11
                        ]
                    ]
                }, {
                    name: 'Pergunta 5',
                    id: 'Pergunta 5',
                    data: [
                        [
                            'Resposta 1',
                            24.13
                        ],
                        [
                            'Resposta 2',
                            17.2
                        ],
                        [
                            'Resposta 3',
                            8.11
                        ]
                    ]
                }]
            }
        });
    }


    graph_angle('Acertos por drop', '% de acerto no drop', 'content-drop-1', 10);
    drillDrops('Acertos', 'content-drop-1-questions');
    graph_angle('Acertos por drop', '% de acerto no drop', 'content-drop-2', 25.9);
    drillDrops('Acertos', 'content-drop-2-questions');
    timelinequiz();


    var table = $('#table-user').DataTable({
        //responsive: true,
        "scrollX": true,
        pageLength: 10,
        "data": [{"title":0, "user_name":0,"classname":0, "instructor":0,"pontos":0,"perguntas":0, "meta":0, "respostas":0, "certas":0,"pontos_obtidos":0, "assertividade":0, "result":null,
        "classtype":0, "date_response":0 }],
        "cache": false,
        "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "Todos"]],
        "iDisplayLength": 10,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        },
        "columns": [
            {"data": "title"},
            {"data": "user_name"},
            {"data": "classname"},
            {"data":"instructor"},
            {"data":"pontos"},
            {"data":"perguntas"},
            {"data":"meta"},
            {"data":"respostas"},
            {"data":"certas"},
            {"data":"pontos_obtidos"},
            {"data":"assertividade"},
            {"data":"result"},
            {"data":"classtype"},
            {"data": "date_response"}
        ]
    });

    $(".fa-bars").click(function(){
        var dialogOptions = {
            "title" : "dialog@" + new Date().getTime(),
            "width" : 400,
            "height" : 300,
            "background":'blue',
            "modal" : $("#is-modal").is(":checked"),
            "resizable" : $("#is-resizable").is(":checked"),
            "draggable" : $("#is-draggable").is(":checked"),
            "close" : function(){
                    $(this).remove();
            }
        };
        $("<div>This is  content</div>")
            .dialog(dialogOptions)
            .dialogExtend({
                "minimizable" : true,
                "dblclick" : "collapse",
                "minimizeLocation" : "right",
            });
    });
});

