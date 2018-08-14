function post_statistic(post_id) {

    $("#post-statistic-modal").modal('show');

    $("#post-statistic-modal .modal-body .load").fadeIn(0);

    $("#post-statistic-modal .modal-body .statistic-content").fadeOut(0);

    $.post('ws/post/statistic', {id: post_id}, function (data) {
        //console.log(data);
        var $template = $("#post-statistic-modal .modal-body .statistic-content"),
            output = '',
            data = data.post,
            react_list = [],
            react = [],
            feedback = [];

        for (i in data) {

            var group = [];

            var ig = 0;
            for (g in data[i].group) {
                group[ig] = data[i].group[g].name;

                ig++;
            }

            var react_count = 0;

            for (r in data[i].react) {
                react_count = react_count + parseInt(data[i].react[r].count);
            }

            var item = {
                id: data[i].id,
                count: data[i].count,
                count_unique: data[i].count_unique + ' <span> - ' + data[i].count_unique_pecent + '</span>',
                react_count: react_count,
                relevance: data[i].relevance,
                total_rate: data[i].total_rate,
                comment_total: data[i].comment_total,
                quiz_answered: data[i].quiz.answered.total_percent,
                quiz_correct: data[i].quiz.correct_answer.total_percent,
                group: group.join(' / '),
                group_user: data[i].group_user,
                feedback: data[i].feedback.length
            };

            react_list = data[i].react_list;

            for (r in data[i].react) {
                react[data[i].react[r].id] = data[i].react[r].count;
            }

            feedback = data[i].feedback;

            output += fill_template($template, item, 'template-detail');
        }

        $template.html(output);


        var $react = $template.find('.statistic-react'),
            output_react = '';

        for (i in react_list) {
            react_list[i].react_react_img = react_list[i].img;
            react_list[i].react_react_name = react_list[i].name;
            react_list[i].react_react_count = (react[react_list[i].id] != undefined) ? react[react_list[i].id] : '0';

            output_react += fill_template($react, react_list[i], 'statistic-react-template');

        }
        $react.html(output_react);

        var $feedback = $template.find(".view-feedback"),
            output_feedback = '';

        for (i in feedback) {
            var item = {
                feedback_text: feedback[i].text
            }

            output_feedback += fill_template($feedback, item, 'feedback-template');
        }

        $feedback.html(output_feedback);


        $('[data-toggle="tooltip"]').tooltip();


        $("#post-statistic-modal .statistic-feedback #view-feedback").click(function () {
            var $feedback_list = $("#post-statistic-modal .statistic-feedback .view-feedback");

            if ($feedback_list.hasClass('hide')) {
                $feedback_list.removeClass('hide');
                $(this).text('fechar');
            } else {
                $feedback_list.addClass('hide');
                $(this).text('ver');
            }

            return false;
        });

        $("#post-statistic-modal .modal-body .load").fadeOut(500);

        $("#post-statistic-modal .modal-body .statistic-content").fadeIn(500);

    });
}
