$(function () {

    amount_posts();
    amount_views();
    amount_users();
    amount_mentions();
    amount_chats();
    amount_files();
    amount_relevance();
    amount_beebot();
    amount_likes();
    amount_quiz();
    amount_group();
    amount_points();
    amount_help();
    amount_dm();
    amount_store();
});

function setMaxTextSize($element, maxFont) {
    var fontSize = parseInt($element.css("font-size"));

    var previousWidth = $element.width();

    for (i = 0; $element.width() <= previousWidth && fontSize <= maxFont; i++) {
        $element.css("font-size", "" + (++fontSize) + "px");
    }

    return fontSize;
}

function amount_posts() {
    $.get('ws/post/get/all', function (data) {
        var $element = $(".list .amount_posts .result");
        $element.html(data.post.length).removeClass('hide');
        amount_comments(data.post.length);
        setMaxTextSize($element, 100);

        $element.closest('div').find(".load").hide();
    });
}

function amount_views() {
    $.get('ws/post/view', function (data) {
        var $element = $(".list .amount_views .result"),
            $element2 = $(".list .amount_views .result2");
        $element.html(data.video + ' videos').removeClass('hide');
        $element2.html(data.post + " post").removeClass('hide');

        setMaxTextSize($element, 100);
        setMaxTextSize($element2, 100);

        $element.closest('div').find(".load").hide();
    });
}

function amount_users() {
    $.get('ws/user/get2', function (data) {
        var $element = $(".list .amount_users .result"),
            $element2 = $(".list .amount_users .result2");

        $element.html(data.activated + " ativos").removeClass('hide');
        $element2.html(data.disabled + " inativos").removeClass('hide');

        setMaxTextSize($element, 30);
        setMaxTextSize($element2, 30);

        $element.closest('div').find(".load").hide();
    });
}

function amount_mentions() {
    $.get('ws/mention/get/all', function (data) {
        var $element = $(".list .amount_mentions .result");

        $element.html(data.mention.length).removeClass('hide');

        setMaxTextSize($element, 100);

        $element.closest('div').find(".load").hide();
    });
}

function amount_comments(amount_posts) {
    $.get('ws/postcomment/get/all', function (data) {
        var $element = $(".list .amount_comments .result"),
            $element2 = $(".list .amount_comments .result2"),
            average = (Object.keys(data).length > 0) ? Math.ceil(data.length / amount_posts) : 0;

        $element.html(data.length).removeClass('hide');
        $element2.html("MÉDIA DE <b>" + average + "</b> POR POST ").removeClass('hide');

        setMaxTextSize($element, 90);
        setMaxTextSize($element2, 14);

        $element.closest('div').find(".load").hide();
    });
}

function amount_chats() {
    $.get('ws/chat/totalize', function (data) {
        var $element = $(".list .amount_chats .result"),
            $element2 = $(".list .amount_chats .result2"),
            private = 0,
            public = 0;

        for (i in data) {

            if (data[i].private == 1) {
                private = private + 1;
            } else {
                public = public + 1;
            }
        }

        $element.html(public + ' públicos').removeClass('hide');
        $element2.html(private + ' privados').removeClass('hide');

        setMaxTextSize($element, 100);
        setMaxTextSize($element2, 100);

        $element.closest('div').find(".load").hide();
    });
}

function amount_files() {
    $.get('ws/file/totalize', function (data) {
        var $element = $(".list .amount_files .result"),
            $element2 = $(".list .amount_files .result2");

        $element.html(data.count + ' arquivos').removeClass('hide');
        $element2.html(data.size).removeClass('hide');

        setMaxTextSize($element, 100);
        setMaxTextSize($element2, 100);

        $element.closest('div').find(".load").hide();
    });
}

function amount_relevance() {
    $.get('ws/postrate/totalize', function (data) {
        var $element = $(".list .relevance .result");

        $element.find('.color').animate({width: data.rate}, 1500);

        $element.removeClass('hide');

        $element.closest('div').find(".load").hide();
    });
}

function amount_beebot() {
    $.get('ws/beebot/totalize', function (data) {
        var $element = $(".list .amount_beebot .result"),
            $element2 = $(".list .amount_beebot .result2");

        $element.html(data).removeClass('hide');
        $element2.removeClass('hide');

        setMaxTextSize($element, 85);
        setMaxTextSize($element2, 16);

        $element.closest('div').find(".load").hide();
    });
}

function amount_likes() {
    $.get('ws/post/reactpost_totalize', function (data) {
        var $element = $(".list .amount_likes .result"),
            $element2 = $(".list .amount_likes .result2"),
            average = (data.likes > 0) ? Math.ceil(data.likes / data.posts) : 0;

        $element.html(data.likes).removeClass('hide');
        $element2.html('MÉDIA DE <b>' + average + '</b> POR POST').removeClass('hide');

        setMaxTextSize($element, 85);
        setMaxTextSize($element2, 14);

        $element.closest('div').find(".load").hide();
    });
}

function amount_quiz() {
    $.get('ws/quiz/totalize', function (data) {
        var $element = $(".list .amount_quiz .result"),
            $element2 = $(".list .amount_quiz .result2");

        $element.html(data.quiz).removeClass('hide');
        $element2.html(data.correct + ' DE ACERTOS').removeClass('hide');

        setMaxTextSize($element, 85);
        setMaxTextSize($element2, 16);

        $element.closest('div').find(".load").hide();
    });
}

function amount_group() {
    $.get('ws/group/get', function (data) {
        var $element = $(".list .amount_group .result");

        $element.html(data.length).removeClass('hide');

        setMaxTextSize($element, 85);

        $element.closest('div').find(".load").hide();
    });
}

function amount_points() {
    $.get('ws/user/totalize', function (data) {
        var $element = $(".list .amount_points .result");

        $element.html(data.score + ' / ' + data.level).removeClass('hide');

        setMaxTextSize($element, 85);

        $element.closest('div').find(".load").hide();
    });
}

function amount_help() {
    $.get('ws/help/get', function (data) {
        var $element = $(".list .amount_help .result");

        $element.html(data.help.length + ' artigos').removeClass('hide');

        setMaxTextSize($element, 85);

        $element.closest('div').find(".load").hide();
    });
}

function amount_dm() {
    $.get('ws/dm/totalize', function (data) {
        var $element = $(".list .amount_dm .result");

        $element.html(data).removeClass('hide');

        setMaxTextSize($element, 85);

        $element.closest('div').find(".load").hide();
    });
}

function amount_store() {
    $.get('ws/store/totalize', function (data) {
        var $element = $(".list .amount_store .result"),
            $element2 = $(".list .amount_store .result2");

        $element.html(data.products + ' produtos').removeClass('hide');
        $element2.html(data.buy + ' compras').removeClass('hide');

        setMaxTextSize($element, 85);
        setMaxTextSize($element2, 85);

        $element.closest('div').find(".load").hide();
    });
}