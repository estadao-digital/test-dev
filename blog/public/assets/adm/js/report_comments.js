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
    $('#end_date').data("DateTimePicker").date(new Date(new Date(today.getFullYear(), today.getMonth() + 1, 0)));
    var data = JSON.stringify($("#filter").serializeArray());
    chart_main(data, 'area');
    chart_table(data);

    $('#search').click(function () {
        var data = JSON.stringify($("#filter").serializeArray());
        chart_main(data, $('.chart.active').val());
        chart_table(data);
    });


    $(".status").chosen().change(function () {
        $(".load-table").toggleClass('hide');
        var data = JSON.stringify($("#filter").serializeArray());
        chart_table(data);
        $(".load-table").toggleClass('hide');
    });

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

    $('.chart').click(function () {
        $('.chart').removeClass('active');
        $(this).toggleClass('active');
        if($(this).val() == 'table'){
            $('.chart-statistic').addClass('hide');
            $('.table-statistic').removeClass('hide');
        }else if($(this).val() == 'area'){
            var data = JSON.stringify($("#filter").serializeArray());
            chart_main(data, $(this).val());
            $('.chart-statistic').removeClass('hide');
            $('.table-statistic').addClass('hide');
        }else if($(this).val() == 'column'){
            var data = JSON.stringify($("#filter").serializeArray());
            chart_main(data, $(this).val());
            $('.chart-statistic').removeClass('hide');
            $('.table-statistic').addClass('hide');
        }
    });


    $(".close-filter").click(function () {
        $(".user-filter").addClass("closed").css({
            'background': 'url(./assets/img/filter.png)',
            'padding-left': '30px'
        });

        localStorage.setItem("user-filter", 0);

        return false;
    });

    $(".open-filter").click(function (e) {
        e.preventDefault();
        $(".user-filter").removeClass("closed").css({'background': 'url()', 'padding-left': '0'});

        localStorage.setItem("user-filter", 1);

        return false;
    });

    $("#comment_delete").click(function () {
        $.ajax({
            type: 'GET',
            url: './ws/postcomment/delete/'+$(this).attr("value"),
            success: function () {
                var data = JSON.stringify($("#filter").serializeArray());
                chart_main(data, 'area');
                chart_table(data);
                settableuser($('#user-comments').attr("value"));
            }
        });
    });
});

function set_id_delete(id) {
    $("#comment_delete").attr("value", id);
}

function setmodalname(name, id) {
    $('#form_temp').remove();
    $("#temp_post").val($("#post").val());
    $("#temp_user_id").val(id);
    $("#temp_end").val($("#date-end").val());
    $("#temp_start").val($("#date-start").val());
    $("#temp_word").val($("#word").val());
    $("#temp_order").val($("#user-comments").attr('order'));
    $("#temp_order_by").val($("#user-comments").attr('order_by'));
    var btn = '<button class="btn btn-orange" onclick="download_xls_user(); return false;" style="padding:2px 12px; margin-left:10px;">Gerar Excel</button>';
    $('#table-user-name').html(name+btn);
}

function download_xls_user() {
    $('form.form_temp').submit();
}

function view_user(id){
    $.ajax({
        type: 'POST',
        url: './ws/user/get_basic_userinfo',
        data: {id: id},
        dataType: 'json',
        success: function (data) {
            for (var i = 0; data.length > i; i++) {
                $('#perfil-detail').append('<li>Nome:' + data[i].name + ' ' + data[i].lastname +
                        data[i].level + ' | ' + data[i].score +
                    '</li><li>Líder:' + data[i].leader +
                    '</li><li>Líder Responsável:' + data[i].leadername +
                    '</li><li>Grupos:' + data[i].groups +
                    '</li><li>Canais:' + data[i].chats +
                    '</li><li>Username:' + data[i].username +
                    '</li>');
            }
            $('.glyphicon-spin').toggleClass('hide');
        }
    });
}

function settableuser(id) {
        $(".user_table_row").remove();
        $('.glyphicon-spin').toggleClass('hide');
    $.ajax({
        type: 'POST',
        url: './adm/report/comment_user',
        data: {type: 'json', user_id: id,post:$("#post").val(), end: $("#date-end").val(), start:$("#date-start").val(), word:$("#word").val(), order:$("#user-comments").attr('order'), order_by:$("#user-comments").attr('order_by')},
        success: function (data) {
                for (var i = 0; data.length > i; i++) {
                    //Adicionando registros retornados na tabela
                    $('#user-comments').attr("value",id);
                    $('#table-user').append('<tr class="user_table_row"><td>' +
                        convertDateTime(data[i].datetime)+ '</td><td>' + data[i].title + '</td><td style="word-break: break-all;">'+
                        data[i].text +'</td><td><div class="btn-group">'+
                        '<button class="btn-action-form btn btn-sm btn-success" type="button" onclick="window.location=\'./feed/'+ data[i].post_id+'/'+escape(data[i].title)+'#'+ data[i].id+'\'">'+
                        '<i class="fa fa-eye"></i></button>'+
                        '<button class="btn-action-form btn btn-sm btn-danger" value="'+ data[i].id +
                        '" type="button" data-toggle="modal" onclick="set_id_delete('+data[i].id+')" data-target="#modal-delete"><i class="fa fa-trash"></i></button>' +
                        '</td></td></tr>');
                }
                $('.glyphicon-spin').toggleClass('hide');

        }
    });
}

function reset_order() {
    $("#user-comments").attr('order', 'DESC');
    $("#user-comments").attr('order_by', 'datetime');
    $(".order").removeClass('glyphicon-sort-by-attributes');
    $(".order-date").addClass('glyphicon-sort-by-attributes');
    $(".order-post").addClass('glyphicon-sort');
    $(".order-post").removeClass('glyphicon-sort-by-attributes');
    $(".order-post").removeClass('glyphicon-sort-by-attributes-alt');
}

$(".order-date").click(function () {
    if( $("#user-comments").attr('order') == 'DESC') {
        $(".order-date").removeClass('glyphicon-sort-by-attributes-alt');
        $(".order-date").addClass('glyphicon-sort-by-attributes');
        $("#user-comments").attr('order', 'ASC');
    }else{
        $(".order-date").removeClass('glyphicon-sort-by-attributes');
        $(".order-date").addClass('glyphicon-sort-by-attributes-alt');
        $("#user-comments").attr('order', 'DESC');
    }
    $("#user-comments").attr('order_by', 'datetime');
    $(".order-post").addClass('glyphicon-sort');
    $(".order-post").removeClass('glyphicon-sort-by-attributes-alt');
    $(".order-post").removeClass('glyphicon-sort-by-attributes');
    settableuser($('#user-comments').attr('value'));
});

$(".order-post").click(function () {
    if( $("#user-comments").attr('order') == 'DESC'){
        $(".order-post").removeClass('glyphicon-sort-by-attributes-alt');
        $(".order-post").addClass('glyphicon-sort-by-attributes');
        $("#user-comments").attr('order', 'ASC');
    }else{
        $(".order-post").removeClass('glyphicon-sort-by-attributes');
        $(".order-post").addClass('glyphicon-sort-by-attributes-alt');
        $("#user-comments").attr('order', 'DESC');
    }
    $("#user-comments").attr('order_by', 'post');
    $(".order-date").addClass('glyphicon-sort');
    $(".order-date").removeClass('glyphicon-sort-by-attributes-alt');
    $(".order-date").removeClass('glyphicon-sort-by-attributes');
    settableuser($('#user-comments').attr('value'));
});


function convertDate(date) {
    var d = new Date(date);
    var novo = d.setDate(d.getDate() + 1);
    var n = new Date(novo),
        month = '' + (n.getMonth() + 1),
        day = '' + n.getDate(),
        year = n.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month, year].join('/');
}

function convertDateTime(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [day, month, year].join('/')+' '+[d.getHours(), d.getMinutes()].join(':');
}
/********  GRÁFICOS     *******/
function chart_main(filter, type) {
    Highcharts.setOptions({
        lang: {
            months: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            shortMonths: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            weekdays: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            loading: ['Atualizando o gráfico...aguarde'],
            contextButtonTitle: 'Exportar gráfico',
            decimalPoint: ',',
            thousandsSep: '.',
            downloadJPEG: 'Baixar imagem JPEG',
            downloadPDF: 'Baixar arquivo PDF',
            downloadPNG: 'Baixar imagem PNG',
            downloadSVG: 'Baixar vetor SVG',
            printChart: 'Imprimir gráfico',
            rangeSelectorFrom: 'De',
            rangeSelectorTo: 'Para',
            rangeSelectorZoom: 'Zoom',
            resetZoom: 'Limpar Zoom',
            resetZoomTitle: 'Voltar Zoom para nível 1:1',
        },
        chart: {
            style: {
                fontFamily: 'ubuntu'
            }
        }
    });
    $.ajax({
        type: 'POST',
        url: './adm/report/comments_json',
        data: filter,
        dataType: 'json',
        success: function (data) {
            $('.table-statistic-rows').remove();
            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#table-statistic').append('<tr class="table-statistic-rows"><td>' + convertDate(data[i][0]) + '</td><td>' + data[i][1] + '</td></tr>');
            }
            // create the chart
            Highcharts.stockChart('chartComment', {
                title: {
                    text: 'Quantidade de comentários'
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                   gapGridLineWidth: 100,
                    min: 0,
                    type: 'datetime',

                },
                yAxis: {
                    dateTimeLabelFormats: {
                        year: '%Y'
                    },
                    lineWidth: 1,
                    lineColor: '#fff',
                    min: 0,
                    offset: 30,
                    labels: {
                        align: 'right',
                        x: -3,
                        y: 6
                    },
                    minRange : 0.1,
                    showLastLabel: true
                },
                rangeSelector: {
                    buttons: [{
                        type: 'day',
                        count: 1,
                        text: 'Dia'
                    }, {
                        type: 'week',
                        count: 1,
                        text: 'Sem'
                    }, {
                        type: 'month',
                        count: 1,
                        text: 'Mês'
                    }, {
                        type: 'year',
                        count: 1,
                        text: 'Ano'
                    }, {
                        type: 'all',
                        count: 1,
                        text: 'Tudo'
                    }],
                    selected: 4,
                    inputEnabled: false
                },

                series: [{
                    name: 'Comentários',
                    type: type,
                    pointStart: '',
                    data: data,
                    opposite: true,
                    gapSize: 100,
                    tooltip: {
                        valueDecimals: 0
                    },
                    fillColor: {
                        linearGradient: {
                            x1: 0,
                            y1: 0,
                            x2: 0,
                            y2: 1
                        },
                        stops: [
                            [0, Highcharts.getOptions().colors[0]],
                            [1, Highcharts.Color(Highcharts.getOptions().colors[0]).setOpacity(0).get('rgba')]
                        ]
                    },
                    threshold: null
                }]
            });
        }
    });
}

function chart_table(filter) {
    $('#type-title').html($(".status option:selected").text());
    $(".chart_table_row").remove();
    var type = $("#table-type").val();
    $.ajax({
        type: 'POST',
        url: './adm/report/comments_for_tables?type=' + type,
        data: filter,
        dataType: 'json',
        success: function (data) {
            var total = 0
            for (var i = 0; data.length > i; i++) {
                total = parseInt(data[i].comment_total) + total;
            }
            for (var i = 0; data.length > i; i++) {
                var participant = ((data[i].comment_total / total) * 100);
                var percent = Number((participant).toFixed(2))
                //Adicionando registros retornados na tabela
                if ($(".status option:selected").text() == "Usuário") {
                    $("#leader_cell").removeClass('hide');
                    var leader = data[i].leader == null?'':data[i].leader;
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>'+ leader +'</td>'+
                        '</td><td><a onclick="user_info(' + data[i].id + ')">' + data[i].name +
                        '</a></td><td><a class="table-user" data-toggle="modal" data-target="#modal-user-comments" onclick="settableuser('+data[i].id+'),setmodalname(\'' + data[i].name + '\', \''+data[i].id+'\'),reset_order()">' +
                        data[i].comment_total +
                        '</a></td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                } else {

                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data[i].name === null ? "Sem Campanha" : data[i].name) +
                        '</td><td>' + data[i].comment_total +
                        '</td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                }
            }

            /**
             * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
             * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
             */
            Highcharts.SparkLine = function (a, b, c) {
                var hasRenderToArg = typeof a === 'string' || a.nodeName,
                    options = arguments[hasRenderToArg ? 1 : 0],
                    defaultOptions = {
                        chart: {
                            renderTo: (options.chart && options.chart.renderTo) || this,
                            backgroundColor: null,
                            borderWidth: 0,
                            type: 'bar',
                            margin: [1, 0, 1, 0],
                            width: 120,
                            height: 35,
                            style: {
                                overflow: 'visible'
                            },

                            // small optimalization, saves 1-2 ms each sparkline
                            skipClone: true
                        },
                        title: {
                            text: ''
                        },
                        credits: {
                            enabled: false
                        },
                        xAxis: {
                            labels: {
                                enabled: false
                            },
                            title: {
                                text: null
                            },
                            startOnTick: false,
                            endOnTick: false,
                            tickPositions: []
                        },
                        exporting: {enabled: false},
                        yAxis: {
                            max: 100,
                            endOnTick: false,
                            startOnTick: false,
                            labels: {
                                enabled: false
                            },
                            title: {
                                text: null
                            },
                            tickPositions: [0]
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            backgroundColor: null,
                            borderWidth: 0,
                            shadow: false,
                            useHTML: true,
                            hideDelay: 0,
                            shared: true,
                            padding: 0,
                            positioner: function (w, h, point) {
                                return {x: point.plotX - w / 2, y: point.plotY - h};
                            }
                        },
                        plotOptions: {
                            series: {
                                animation: false,
                                lineWidth: 1,
                                shadow: false,
                                states: {
                                    hover: {
                                        lineWidth: 1
                                    }
                                },
                                marker: {
                                    radius: 1,
                                    states: {
                                        hover: {
                                            radius: 2
                                        }
                                    }
                                },
                                zones: [{
                                    value: 10, // Values up to 10 (not including) ...
                                    color: 'blue' // ... have the color blue.
                                }, {
                                    value: 20,
                                    color: 'green'
                                }, {
                                    value: 30,
                                    color: 'yellow'
                                }, {
                                    value: 40,
                                    color: 'orange'
                                }, {
                                    color: 'red'
                                }],
                                fillOpacity: 0.25
                            },
                            column: {
                                borderColor: 'silver'
                            }
                        }
                    };

                options = Highcharts.merge(defaultOptions, options);

                return hasRenderToArg ?
                    new Highcharts.Chart(a, options, c) :
                    new Highcharts.Chart(options, b);
            };

            var start = +new Date(),
                $tds = $('td[data-sparkline]'),
                fullLen = $tds.length,
                n = 0;

            // Creating 153 sparkline charts is quite fast in modern browsers, but IE8 and mobile
            // can take some seconds, so we split the input into chunks and apply them in timeouts
            // in order avoid locking up the browser process and allow interaction.
            function doChunk() {
                var time = +new Date(),
                    i,
                    len = $tds.length,
                    $td,
                    stringdata,
                    arr,
                    data,
                    chart;

                for (i = 0; i < len; i += 1) {
                    $td = $($tds[i]);
                    stringdata = $td.data('sparkline');
                    arr = stringdata.split('; ');
                    data = $.map(arr[0].split(', '), parseFloat);
                    chart = {};

                    if (arr[1]) {
                        chart.type = arr[1];
                    }
                    $td.highcharts('SparkLine', {
                        series: [{
                            data: data,
                            pointStart: 1
                        }],
                        tooltip: {
                            headerFormat: 'Participação<br/>',
                            pointFormat: '<b>{point.y}%</b>'
                        },
                        chart: chart
                    });

                    n += 1;

                    // If the process takes too much time, run a timeout to allow interaction with the browser
                    if (new Date() - time > 500) {
                        $tds.splice(0, i + 1);
                        setTimeout(doChunk, 0);
                        break;
                    }

                    // Print a feedback on the performance
                    if (n === fullLen) {
                        $('#result').html('Generated ' + fullLen + ' sparklines in ' + (new Date() - start) + ' ms');
                    }
                }
            }

            doChunk();

        }
    });
}
