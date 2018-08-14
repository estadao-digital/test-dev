$(function () {
    var $list_item = $('.list_item'),
        output = '',
        quiz_id_focus = extract_url("#");

    quiz_amount(false, true);

    if (quiz_id_focus) {
        quiz_id_focus = quiz_id_focus.replace('#', '');
        quiz_id_focus = quiz_id_focus.split(',');

        $("#show-all-quiz").removeClass('hide');
    }

    $.post('ws/quiz/get', function (data) {
        $(".load-itens").show();

        var quiz = data.quiz,
            questions = [],
            posts = [],
            unanswered = 0,
            itens = [];
        for (i in quiz) {
            var item = quiz[i];
            item.class = (item.answered) ? "answered" : "";
            item.hide_quiz = quiz_id_focus && $.inArray(item.id, quiz_id_focus) == -1 ? "hide hide-quiz" : "";
            item.label_class = (item.answered) ? "success" : "danger";
            item.label_text = (item.answered) ? "Respondido" : "Não respondido";
            item.points = (item.total_weight == 1) ? "<small>" + item.total_weight + " ponto</small>" : "<small>" + item.total_weight + " pontos</small>";
            item.btn_submit = (item.answered) ? '' : '<button type="submit" class="btn btn-orange pull-right">Enviar</button>';
            questions[item.id] = (!item.answered && item.question.length == 0) ? null : item.question;

            if (item.userquizanswer_datetime) {
                var date = item.userquizanswer_datetime.split(' ');
                var Data = date[0].split('-');
                Data = Data[2] + "/" + Data[1] + "/" + Data[0];
                var Hora = date[1].split(':');
                Hora = Hora[0] + "h" + Hora[1];
                Data = Hora + ' - ' + Data;
                item.userquizanswer_datetime = Data;
            } else {
                item.userquizanswer_datetime = '';
            }
            if (!item.answered) {
                unanswered = unanswered + 1;
                item.points = item.points;
            } else {
                item.points = '<small>Você ganhou ' + item.total_points + ' pontos de ' + item.total_weight + ' disponíveis neste Quiz' + '</small><small> ' + item.userquizanswer_datetime + '</small>';
            }
            posts[item.id] = item.posts;
            itens[item.id] = item;
            output += fill_template($list_item, item, 'template-item');
        }

        $(".load-itens").hide();
        $list_item.html(output).show();

        if (posts && posts.length > 0) {
            for (pid in posts) {
                var post = posts[pid],
                    $quiz_item = $list_item.find("#quiz-item-" + pid),
                    $post_list = $quiz_item.find('.posts-list'),
                    output_post = '';

                get_template($post_list, 'template-post');

                for (p in post) {
                    var post_item = {
                        post_url: post[p].url,
                        post_title: post[p].title
                    };

                    output_post += fill_template($post_list, post_item, 'template-post');

                }

                $post_list.html(output_post);

                if (output_post == "") {
                    $post_list.remove();
                }
            }
        }

        if (questions && questions.length > 0) {
            for (qid in questions) {
                var question = questions[qid],
                    $quiz_item = $list_item.find("#quiz-item-" + qid),
                    $question_list = $quiz_item.find('.question-list'),
                    output_question = '',
                    answers = [];

                if ($quiz_item) {
                    if (question) {

                        get_template($question_list, 'template-question');

                        for (i in question) {
                            var question_item = {
                                question_id: qid + "-" + question[i].id,
                                question_name: question[i].name,
                                question_points: (question[i].total_weight == 1) ? "<small>" + question[i].total_weight + " ponto</small>" : "<small>" + question[i].total_weight + " pontos</small>",
                                question_name_input: 'question[' + question[i].id + ']',
                                answer: question[i].answer
                            };

                            answers[question_item.question_id] = (question_item.answer.length == 0) ? null : question_item.answer;
                            output_question += fill_template($question_list, question_item, 'template-question');
                        }

                        if (!output_question) {
                            $quiz_item.find(".form-item").remove();
                        } else {

                            $question_list.html(output_question);

                            if (answers) {

                                for (aid in answers) {
                                    var answer = answers[aid],
                                        $question_item = $question_list.find("#question-" + aid),
                                        $answer_list = $question_item.find('.answer'),
                                        output_answer = '';

                                    get_template($answer_list, 'template-answer');

                                    if (answer) {
                                        for (a in answer) {
                                            var answer_item = {
                                                answer_id: answer[a].id,
                                                answer_text: answer[a].text,
                                                answer_disable: (itens[qid].answered) ? 'disabled' : '',
                                                answer_correct: (itens[qid].answered && answer[a].weight == 1) ? 'answer-correct' : '',
                                                answer_checked: answer[a].answered ? 'checked' : ''
                                            };

                                            output_answer += fill_template($answer_list, answer_item, 'template-answer')

                                        }

                                        $answer_list.html(output_answer);
                                    }
                                }
                            }
                        }

                    } else {

                        $quiz_item.find(".form-item").remove();
                    }
                }
            }

        }

        count_down($list_item);

        $list_item.find('.item .content-item .quiz-item h4').click(function () {
            var $item = $(this).closest('.item'),
                $chevron = $(this).find('.glyphicon');

            $item.find('.form-item').toggle(200, function () {
                if ($(this).is(':visible')) {
                    $chevron.removeClass('glyphicon-chevron-down').addClass('glyphicon-chevron-up');
                    if ($item.hasClass('answered') == false) {
                        $list_item.find('.item:not(.answered):not(#' + $item.attr('id') + ')').addClass('opacity').find('.form-item').slideUp(200);
                    }
                } else {
                    $chevron.removeClass('glyphicon-chevron-up').addClass('glyphicon-chevron-down');
                    $list_item.find('.item:not(.answered):not(#' + $item.attr('id') + ')').removeClass('opacity');
                }

                $item.removeClass('opacity');

            });

            return false;
        });

        $list_item.find('form').submit(function () {
            var $form = $(this),
                $item = $form.closest('.item'),
                data = $form.serialize();

            $form.find('button[type="submit"]').attr('disabled', 'disabled');

            $.post('ws/quiz/reply', data, function (data) {

                $item.addClass('answered').find('.content-item .quiz-item h4 .label').removeClass('label-danger').addClass("label-success").text('Respondido');

                $item.find('.form-item').remove();

                quiz_amount(true, true);

                alert_box(data);

                clear_data_score_me();

                window.location = window.location.href;

            });

            return false;
        });

        $("#show-all-quiz").click(function () {
            $list_item.find('.hide-quiz').removeClass('hide');
            $(this).remove();
        });
    });

    $(".filter-quiz label").click(function () {
        if ($(this).find('input').is(':checked')) {
            $(".quiz").addClass('quiz-checked');
        } else {
            $(".quiz").removeClass('quiz-checked');
        }
    });
});

function count_down($list_item) {
    $list_item.find('.item:not(.answered)').each(function (i, element) {
        var $item = $(element),
            $countdown = $item.find('.content-item .quiz-item h4 .label-countdown'),
            finishin = $countdown.data('finishin');

        if (finishin != null) {
            $countdown.show();
            $countdown.find('span').countdown(finishin, function (event) {

                if (event.offset.days == 0) {

                    $(this).html(event.strftime('%H:%M:%S'));

                    if (event.offset.hours < 1 && event.offset.minutes < 10) {
                        $(this).closest('.label-countdown').removeClass('label-info').addClass('label-danger');

                        if (event.offset.minutes < 5) {
                            $(this).closest('.label-countdown').addClass('label-atention');
                        } else if (event.offset.minutes <= 10 && event.offset.seconds == 0) {
                            $(this).closest('.label-countdown').addClass('label-atention');
                        } else {
                            $(this).closest('.label-countdown').removeClass('label-atention');
                        }

                    } else if (event.offset.hours < 1) {
                        $(this).closest('.label-countdown').removeClass('label-info').addClass('label-warning');
                    }
                } else {
                    $(this).html(event.strftime('%D dias %H:%M:%S'));
                }


            }).on('finish.countdown', function () {
                var $item = $(this).closest('.item');
                $(this).parent().html('Este quiz não está mais disponível');
                $item.find('.content-item .quiz-item h4 .glyphicon').remove();
                $item.find('.content-item .quiz-item h4 .label:not(.label-countdown)').remove();
                $item.find('.content-item .form-item').remove();
                setTimeout(function () {
                    $item.fadeOut(1000);
                }, 5000);
            });
        }

    });
}