$(function () {
    var quiz_id = $.isNumeric(extract_url('last')) ? {id: extract_url('last'), adm: true} : null,
        quiz_default = {
            quiz_title: "Criar novo quiz",
            text_submit: "Enviar",
            quiz_not_found: false,
            quiz_not_found_class: '',
            action: 'ws/quiz/save',
            id: 0,
            title: "",
            posts: [],
            users: [],
            finishin: '',
            finishin_class: '',
            finishin_checked: 'checked',
            finishin_disabled: '',
            question: [{
                id: 1,
                name: "",
                weight: "",
                new: true,
                answer: [{
                    id: 1,
                    text: "",
                    weight: -1,
                    new: true
                }]
            }]
        },
        data_quiz = (quiz_id) ? null : quiz_default;

    $("#quiz-content").data('quiz-default', quiz_default);

    if (quiz_id) {
        $.post('ws/quiz/get/all', quiz_id, function (data) {
            if (data.error) {

                for (i in data.error) {
                    quiz_default.quiz_title = data.error[i];
                }

                quiz_default.quiz_not_found_class = 'hide';

                insert_data(quiz_default);

                alert_box(data);
                return false;
            } else {

                data_quiz = data.quiz;

                data_quiz.quiz_title = "Editar quiz";
                data_quiz.text_submit = "Salvar Alterações";
                data_quiz.action = 'ws/quiz/update';
                data_quiz.finishin_class = data_quiz.finishin == null ? 'disabled' : '';
                data_quiz.finishin_checked = data_quiz.finishin == null ? '' : 'checked';
                data_quiz.finishin_disabled = data_quiz.finishin == null ? 'disabled' : '';

                insert_data(data_quiz);
            }
        });
    }
    else {

        insert_data(data_quiz);
    }

});

function insert_select_posts($quiz_content, posts_ids) {
    $.post('ws/post/get_basic/title_id', function (data_posts) {
        var $select_posts = $quiz_content.find("select#input-post"),
            output_posts = '';

        for (i in data_posts) {
            var post = {
                post_title: data_posts[i].title,
                post_id: data_posts[i].id
            };

            output_posts += fill_template($select_posts, post, 'template-post');
        }

        $select_posts.html(output_posts);

        $select_posts.val(posts_ids).change().chosen({
            no_results_text: "Oops, post não encontrado!",
            allow_single_deselect: true
        });

    });
}

function insert_select_users($quiz_content, users_ids) {
    var quiz_id = $.isNumeric(extract_url('last')) ? {id: extract_url('last'), adm: true} : null;
    if (quiz_id) {
        $.post('ws/user/get_basic/0/name_lastname_id?status=1&quiz=' + quiz_id.id, function (data_users) {
            var $select_users = $quiz_content.find("select#input-users");

            for (i in data_users) {
                data_users[i].selected = (users_ids.length > 0 && $.inArray(data_users[i].id, users_ids) >= 0) ? 'selected' : '';
                $select_users.append('<option value="' + data_users[i].id + '" ' + data_users[i].selected + '>' + data_users[i].name + ' ' + data_users[i].lastname + '</option>');
            }

            $select_users.val(users_ids).change().chosen();

            $select_users.next().find('.chosen-results').attr('style', "display:none;");

        });
    } else {
        $('#input-users').removeAttr('disabled').chosen();
    }
}

function insert_answers($questions, answers, focus) {

    if (Object.keys(answers).length > 0) {

        var answers_ids = [];

        for (idq in answers) {
            var $question = $questions.find('#question-' + idq),
                $answers = $question.find('.container-answer'),
                output_answers = '';


            for (a in answers[idq]) {
                var answer = {
                    answer_id: answers[idq][a].id,
                    answer_text: answers[idq][a].text,
                    answer_checked_1: (answers[idq][a].weight == 1) ? "checked" : "",
                    answer_checked_0: (answers[idq][a].weight == 0) ? "checked" : "",
                    class_new_answer: (answers[idq][a].new) ? true : false
                };

                answers_ids[answer.answer_id] = '#question-' + idq + '-answer-' + answer.answer_id;

                answer.checked_class_1 = (answer.answer_checked_1 == "checked") ? "active" : "";
                answer.checked_class_0 = (answer.answer_checked_0 == "checked") ? "active" : "";

                output_answers += fill_template($answers, answer, 'template-answer');

            }

            $answers.append(output_answers);

            if (focus == true) {
                $answers.find('.box-answer:last .item:first input').focus();
            }
        }

        for (i in answers_ids) {
            $(answers_ids[i]).find('.answer-delete').click(function () {
                var $answer = $(this).closest('.box-answer');

                $answer.fadeOut(function () {
                    $answer.remove();
                })
            });
        }
    }
}

function insert_questions($quiz_content, questions, focus) {

    var $questions = $quiz_content.find('#container-question');

    if (Object.keys(questions).length > 0) {
        var output_questions = '',
            answers = [],
            questions_ids = [],
            output_answers = '';

        for (q in questions) {

            var question = {
                question_id: questions[q].id,
                question_name: questions[q].name,
                question_weight: questions[q].weight,
                class_new_question: (questions[q].new) ? true : false
            };

            answers[questions[q].id] = questions[q].answer;

            questions_ids[questions[q].id] = "#question-" + question.question_id;

            output_questions += fill_template($questions, question, 'template-question');
        }

        $questions.append(output_questions);

        if (focus == true) {
            $questions.find('.box-question:last .item:first input').focus();
        }

        if (answers) {

            for (idq in answers) {
                var $question = $questions.find('#question-' + idq),
                    $answers = $question.find('.container-answer');

                get_template($answers, 'template-answer');

            }

            for (i in questions_ids) {

                $(questions_ids[i]).find('.question-delete').click(function () {
                    var $box_question = $(this).closest('.box-question');

                    $box_question.fadeOut(function () {
                        $box_question.remove();
                    })
                });

                $(questions_ids[i]).find('.add-answer').click(function () {
                    var quiz_default = $("#quiz-content").data('quiz-default'),
                        $question = $(this).closest('.box-question'),
                        question_id = $question.attr('id').replace('question-', ''),
                        answers = [];

                    quiz_default.question[0].answer[0].id = check_id($question.find('.container-answer'), '#question-' + question_id + '-answer-');

                    answers[question_id] = quiz_default.question[0].answer;

                    insert_answers($questions, answers, true);

                });
            }

            insert_answers($questions, answers);
        }
    }
}

function check_id($content, id_complete) {

    var id = 1;

    for (i = 1; $content.find(id_complete + id).length > 0; i++) {
        id = i;
    }

    return id;

}

function insert_data(data) {
    var $quiz_content = $("#quiz-content"),
        output = '',
        posts_selected = data.posts,
        posts_ids = [],
        users_ids = data.users,
        questions = data.question;

    if (posts_selected && posts_selected.length > 0) {
        for (p in posts_selected) {
            posts_ids[p] = posts_selected[p].id;
        }
    }

    output = fill_template($quiz_content, data, 'template-content');

    $quiz_content.html(output);

    get_template($quiz_content.find('#container-question'), 'template-question');

    $quiz_content.find('#add-question').click(function () {
        var quiz_default = $("#quiz-content").data('quiz-default');

        quiz_default.question[0].id = check_id($quiz_content.find('#container-question'), '#question-');

        insert_questions($quiz_content, quiz_default.question, true);

    });

    insert_questions($quiz_content, questions);

    insert_select_posts($quiz_content, posts_ids);

    insert_select_users($quiz_content, users_ids);

    var $finishin = $quiz_content.find('#finishin');

    $finishin.find('#input-finishin-input').datetimepicker({
        locale: 'pt-br',
        format: 'YYYY-MM-DD HH:mm:00',
        ignoreReadonly: true,
        allowInputToggle: true
    });

    $finishin.find('input[type="checkbox"]').click(function () {
        if ($(this).is(':checked')) {
            $finishin.removeClass('disabled');
            $finishin.find('#input-finishin-input').prop('disabled', false);

            $finishin.find('#input-finishin-input').datetimepicker({
                locale: 'pt-br',
                format: 'YYYY-MM-DD HH:mm:00',
                ignoreReadonly: true,
                allowInputToggle: true
            });
        } else {
            $finishin.addClass('disabled');
            $finishin.find('#input-finishin-input').prop('disabled', true).val('');
        }
    });

    $quiz_content.find("form").submit(function () {
        var data_form = $(this).serialize(),
            action = $(this).attr('action');

        $.post(action, data_form, function (data) {
            if (data.error) {
                quiz_amount(true, false);
                alert_box(data);
            } else {
                localMsg(data);
                window.location = "./adm/quiz";
            }
        });

        return false;
    });

}

