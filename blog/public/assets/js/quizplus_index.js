$(function () {
    var $statistic_header = $('#statistic-header'),
        $statistic_header_form = $statistic_header.find('#filter-quiz');

    get_template($statistic_header_form, 'statistic-header-template');

    get_template($('#list-quiz-all'), 'item-template');

    load_statistic_header($statistic_header, $statistic_header_form);
});

function load_quiz_pagination(html, $statistic_header_form) {
    var $navigation = $('#navigation-pag');

    $navigation.html(html);

    $navigation.find('ul li a').click(function (e) {
        e.preventDefault();

        $navigation.find('ul li').removeClass('active');

        if ($(this).parent().hasClass('page-item-in')) {
            $(this).parent().addClass('active');
        }
        $statistic_header_form.attr('action', $(this).attr('href'));

        $statistic_header_form.submit();
    });
}

function quiz_count_down($item, $statistic_header_form) {
    var $timer = $item.find('.count-timer'),
        finishin = $timer.data('time');

    if (finishin != null) {
        $timer.countdown(finishin, function (event) {

            if (event.offset.days == 0) {

                $(this).html(event.strftime('%H:%M:%S'));

                if (event.offset.hours < 1 && event.offset.minutes < 10) {
                    $item.addClass('timer-danger');

                    if (event.offset.minutes < 5) {
                        $item.addClass('timer-atention');
                    } else if (event.offset.minutes <= 10 && event.offset.seconds == 0) {
                        $item.addClass('timer-atention');
                    } else {
                        $item.removeClass('timer-atention');
                    }

                } else if (event.offset.hours < 1) {
                    $item.addClass('timer-warning');
                }
            } else {
                $(this).html(event.strftime('%D dias %H:%M:%S'));
            }


        }).on('finish.countdown', function () {
            $statistic_header_form.submit();
        });
    }
}

function insert_quiz_list(data, $statistic_header_form, $statistic_quiz_load) {
    var $listquiz = $('#list-quiz-all'),
        output_html = '<p class="h1">&nbsp;</p><h3 class="text-center">Nada encontrado.</h3>';

    if (data.length > 0) {
        output_html = '';
        for (var i in data) {
            var item = data[i];
            item.pontos_obtidos = item.pontos_obtidos ? item.pontos_obtidos : 0;
            item.pontos_obtidos_percent_circle = Math.round((item.pontos_obtidos / item.pontos) * 100);
            item.pontos_obtidos_percent = item.pontos_obtidos_percent_circle + '%';
            item.respostas = item.respostas ? item.respostas : 0;
            item.respostas_percent_circle = Math.round((item.respostas / item.perguntas) * 100);
            item.respostas_percent = item.respostas_percent_circle + '%';


            if (item.result === null) {
                item.result_text = "Não Finalizado";
                item.result_class = 'nao_respondido';
                item.count_down = 'Finaliza em <span style="width: auto; display: inline-block;" class="count-timer" data-time="' + item.finishin + '"></span>';

                item.pontos_obtidos_percent_circle = 0;
                item.pontos_obtidos = "-";
                item.respostas = "-";
                item.respostas_percent_circle = 0;
                item.pontos_obtidos_percent = "-";

            } else {
                item.result_text = item.result;
                item.result_class = item.result_text == 'Não Entregue' ? 'nao_entregue' : item.result_text.toLowerCase();
                item.count_down = 'Finalizado';
                if(item.result == 'Entregue'){
                    item.pontos_obtidos_percent_circle = 0;
                    item.pontos_obtidos = "-";
                    item.respostas = "-";
                    item.respostas_percent_circle = 0;
                    item.pontos_obtidos_percent = "-";
                    item.count_down = 'Finaliza em <span style="width: auto; display: inline-block;" class="count-timer" data-time="' + item.finishin + '"></span>';
                }
            }

            item.quiz_link = './quizplus/quiz/' + item.id + '/' + item.vlearnclass_id;

            item.quiz_link_text = '<i class="fa fa-search fa-2x" aria-hidden="true"></i><h4>Resultado</h4>';
            if(item.result === null){
                item.quiz_link_text = '<i class="fa fa-check fa-2x" aria-hidden="true"></i><h4>Responder</h4>';
            }
            if(item.result === 'Entregue'){
                item.quiz_link_text = '<i class="fa fa-search fa-2x" aria-hidden="true"></i><h4>Ver quiz</h4>';
            }

            output_html += fill_template($listquiz, item, 'item-template');
        }
    }

    $listquiz.html(output_html);

    $listquiz.show(0, function () {
        $listquiz.animate({opacity: 1}, 500);

        $statistic_quiz_load.animate({opacity: 0}, 500);

        $listquiz.find('.load-percircle').percircle();

        $listquiz.find('.count-down .count-timer').each(function (i, e) {
            quiz_count_down($(e).closest('.count-down'), $statistic_header_form);
        });
    });


}

function load_quiz_list($statistic_header_form) {

    $statistic_header_form.submit(function (e) {
        e.preventDefault();
        var data_form = $(this).serialize(),
            action = $(this).attr('action'),
            $statistic_quiz_load = $('.quiz-plus .general .statistic-quiz-load'),
            $listquiz = $('#list-quiz-all');

        $statistic_quiz_load.animate({opacity: 1}, 500);
        $listquiz.animate({opacity: 0}, 100, function () {
            $(this).hide(0);
        });

        $.post(action, data_form, function (data) {
            load_quiz_pagination(data.pagination, $statistic_header_form);

            insert_quiz_list(data.data, $statistic_header_form, $statistic_quiz_load);
        });

    });

    var changeTimer = false;
    $statistic_header_form.find('input[type="checkbox"]').change(function () {
        if (changeTimer !== false) clearTimeout(changeTimer);
        changeTimer = setTimeout(function () {
            $statistic_header_form.attr('action', $statistic_header_form.data('action'));
            $statistic_header_form.submit();
            changeTimer = false;
        }, 500);
    });

    $statistic_header_form.find('input[type="text"]').keyup(function () {

        if (changeTimer !== false) clearTimeout(changeTimer);
        changeTimer = setTimeout(function () {
            $statistic_header_form.attr('action', $statistic_header_form.data('action'));
            $statistic_header_form.submit();
            changeTimer = false;
        }, 500);

    });

    $statistic_header_form.submit();
}

function load_statistic_header($statistic_header, $statistic_header_form) {

    $.post('./learn/learn/statistic_header', function (data) {
        $statistic_header_form.html(fill_template($statistic_header_form, data, 'statistic-header-template'));

        var $statistic_header_inter = $statistic_header.find('.statistic-header-inter');

        $statistic_header_inter.show(0, function () {

            $statistic_header.find('.statistic-header-load').animate({opacity: 0}, 500, function () {
                $(this).remove()
            });

            $statistic_header_inter.animate({opacity: 1}, 500, function () {
                $statistic_header.find('.statistic-header-load').animate({opacity: 0}, 100, function () {
                    $(this).remove()
                });
            });

            $statistic_header_inter.find('[data-percent-width]').each(function (i, e) {
                var width = $(e).data('percent-width');
                $(e).animate({width: width}, 1000);
            });

            load_quiz_list($statistic_header_form);
        });
    });
}