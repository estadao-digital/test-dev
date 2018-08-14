$(document).ready(function () {
    $("#ui-layout-center").scroll(function () {
        if ($('.list_item').data('adfterdate') != null && $("#ui-layout-center").height() + $("#ui-layout-center").scrollTop() >= $(".scroll > .col-md-12").height()) {
            loadItem(null);
            return false;
        }
    });
});

$(function () {
    loadItem(extract_url("#"));
    //load_pins();
    submit_favorite();
    window.onhashchange = function () {
        location.reload();
    };
    termscommentaccept_btn();
});
var countloaditem = 0;
var termsarray = [];
function loadItem(comment_id) {

    countloaditem++;

    if (countloaditem == 1) {
        var $list_item = $('.list_item'),
            Data_list_item = ($list_item.data('adfterdate') != undefined) ? {afterdate: $list_item.data('adfterdate')} : {};
        var data = Data_list_item;
        var id_feed = extract_url(1);
        var comment_id = (comment_id) ? comment_id.replace('#', '') : null;

        //if (beforeposts != '') $(".load-chat").show();

        $(".more-itens").show();

        if (comment_id) {
            data.comment_id = comment_id;
        }

        $.post('ws/mention/read_mention', {fk_id: comment_id, target: "postcomment"});

        if (!isNaN(parseFloat(id_feed)) && isFinite(id_feed)) {
            data.id = id_feed;
            $('.more-itens .more-icon').hide();
            $('.feed').addClass('single-item');
        }

        $.post('ws/post/get', data).done(function (data) {
            countloaditem = 0;
            if (data.error) {
                for (i in data.error) {
                    if (i == 700) {
                        window.location = './feed';
                    }
                }
                return false;
            } else {
                data = data.post;

                var output = '';

                if (Object.keys(data).length > 0) {

                    for (i in data) {

                        if (data[i].comment_total != null && data[i].comment_total != undefined && data[i].comment_total > 0) {

                            data[i].comment_total = data[i].top_comment != null && data[i].top_comment != undefined && data[i].top_comment.length > 0 ?
                                data[i].comment_total - data[i].top_comment.length
                                : data[i].comment_total;

                            data[i].comment_total_plus = data[i].comment_total + 1;
                        }

                        if (data[i].top_comment.length > 0) {
                            var topcom = data[i].top_comment;
                            data[i].idja_nohtm = topcom[0].id;

                        }
                        data[i].comentarios_exibidos = 1;

                        data[i].is_shared_wiki = 'false';
                        data[i].not_shared_wiki = 'true';
                        if (data[i].sharedwiki_id && data[i].sharedwiki_id != null && data[i].sharedwiki_id != false) {
                            data[i].is_shared_wiki = 'true';
                            data[i].not_shared_wiki = 'false';
                            data[i].sample_article = data[i].sharedwiki_id.text;
                            data[i].title_article = data[i].sharedwiki_id.title;
                            data[i].link_article = data[i].sharedwiki_id.link + "?post_id=" + data[i].id + "&user_id=" + me().id;
                        }
                        var regex = '/(&nbsp;|<([^>]+)>)/ig';
                        data[i].text = data[i].text.replace(regex, "");
                        if (data[i].count == 0) {
                            data[i].count = "";
                        } else {
                            data[i].count = '<i class="fa fa-eye" title="Visualizações" style="font-size: 15px; position: relative; top: 1px;"></i> ' + data[i].count;
                        }
                        var delete_comment = '',
                            user_id_comment = data[i].top_comment;

                        if (data[i].quiz_id.length > 0) {
                            data[i].total_quiz = '<a href="./quiz#' + data[i].quiz_id.join(',') + '" class="statistic" style="color:green;"><i class="fa fa-check-square-o"></i></a>';
                        } else if (data[i].total_quiz > 0) {
                            data[i].total_quiz = '<a href="./quiz" class="statistic"><i class="fa fa-check-square-o"></i></a>';
                        } else {
                            data[i].total_quiz = '';
                        }

                        hour = data[i].hour.split(':', 2);
                        data[i].hour = hour[0] + "h" + hour[1];
                        //data[i].delete_comment = delete_comment;
                        if (data[i].img == null) {
                            data[i].img = '';
                        } else {
                            //data[i].img = '<a href="' + data[i].link + '"><img class="photo img-r esponsive w100" src="' + data[i].img + '" alt=""></a>';
                            data[i].img = '<a onclick="open_image(\'' + data[i].img + '\', \'' + data[i].id + '\'); return false;" style="cursor: pointer;"><img class="photo img-responsive w100" src="' + data[i].img + '" alt=""></a>';
                        }
                        if (data[i].m3u8 == false) {
                            if (data[i].video != null) {
                                data[i].video = '<div align="center" class="embed-responsive embed-video embed-responsive-16by9" data-src="' + data[i].video + '" id="video-id-' + data[i].id + '" ></div>';
                            } else {
                                data[i].video = '';
                            }
                        } else {
                            var background = data[i].m3u8.thumbnail ? 'background-image: url(' + data[i].m3u8.thumbnail + ');' : 'background-color:#FFF;';
                            data[i].video = '<div align="center" class="embed-responsive embed-video embed-responsive-16by9" style="' + background + '" data-thumbnail="' + data[i].m3u8.thumbnail + '" data-src="' + data[i].m3u8.video + '" id="video-id-' + data[i].id + '"></div>';
                        }
                        show_artigo_nome = 0;

                        data[i].block_comment = data[i].comment == 0 ? 'hide' : '';

                        output += fill_template($list_item, data[i]);

                        $list_item.data('firstpost', true);
                    }
                } else {
                    $(".no-posts").fadeIn('slow');
                    setTimeout(function () {
                        $("").fadeOut('slow');
                    }, 5000);
                    if ($list_item.data('firstpost') !== true) {
                        output = "<div style=\"width: 500px; margin: 0 auto; display: table;\">Publicações de conteúdos em vídeo, imagem ou gif. Seu canal de comunicação para curtir e comentar posts com recursos exclusivos de reactions, emojis, qualificação de conteúdo e exercícios de fixação para se manter informado e engajado.</div>";
                    }
                }

                $(output).find('.block-comment.hide').remove();
                $(".more-itens").hide();

                output = $.parseHTML(output);

                $(output).filter('.item').each(function () {
                    var $this = $(this);
                    if ($this.find('.list_comment').data('total') == '0') {
                        $this.find('.more-comment').remove();
                    }
                });

                $(output).find('.emojiPost').emoji({
                    action: 'click mouseover',
                    position: 'top-left',
                    callback: function (element, contanier) {

                        var $post = $(this).closest('.item'),
                            post_id = $post.data('post_id'),
                            emoji_id = element.id,
                            $localemoji = $(this).closest('ul').find('span.emoji');
                        $.post('ws/emojipost/save',
                            {
                                post_id: post_id,
                                emoji_id: emoji_id
                            },
                            function (data) {
                                if (data.error) {
                                    alert_box(data);
                                    return false;
                                } else {
                                    load_emoji_post($localemoji, data.emojipost);
                                }
                            });
                        contanier.hide();
                    }
                });
                $(output).find('.emojitextarea').emoji({
                    action: 'click mouseover',
                    position: 'top-left',
                    callback: function (element, contanier) {
                        var $textarea = $(this).prev('textarea');
                        $textarea.val($textarea.val() + element.code + " ").focus();
                        contanier.hide();
                    }
                });
                $(output).find('.send-comment').click(function () {
                    var $modal = $(this).closest('.modal');
                    save_feeedback($modal.find('textarea.feedback'));
                    return false;
                });
                $(output).find('textarea.feedback').keypress(function (event) {
                    if (event.keyCode == 13 && !event.shiftKey) {
                        save_feeedback(this);
                        return false;
                    }
                });
                load_mentions(output);
                $(output).find('.avaliation .fa-star').click(function () {
                    getStar(this, output);
                });
                for (i in data) {
                    rating(data[i].id, data[i].postrate_value, output);
                }

                var afterdate = (Object.keys(data).length > 0) ? data[data.length - 1].datetime : null;

                $list_item.data("adfterdate", afterdate);

                get_comments(data, output, comment_id);

                $(output).find('.more-comment').click(function () {
                    more_comments(this, output, comment_id)
                });

                if (!isNaN(parseFloat(id_feed)) && isFinite(id_feed))
                    $(output).find('.more-comment').trigger('click');

                $(output).find('.comment-area').keypress(function (event) {
                    if (event.keyCode == 13 && !event.shiftKey) {
                        comment(this, 0);
                        return false;
                    }
                });

                $(output).find('.comment-area.answer-quiz-true').on('keypress click', function (event) {
                    answer_quiz($(this));
                    return false;
                });

                $(output).find('.comment-area.termscommentaccept-false:not(.answer-quiz-true)').on('keypress click', function (event) {
                    if ($(this).hasClass('termscommentaccept-false')) {
                        termscommentaccept($(this));
                        return false;
                    }
                });

                $(output).find('.pin_target').click(function () {
                    pins_post($(this));
                    return false;
                });

                $list_item.append(output);

                if (Object.keys(data).length > 0)
                    react($(output));
                for (i in data) {
                    var $post = $(output).filter(".item[data-post_id=" + data[i].id + "]"),
                        $localreact = $post.find('.reactions');
                    load_react_post($localreact, data[i].react);
                }

                check_video_view($list_item.find('.item'));

            }
        }).error(function () {

            $('.feed .more-itens').css('visibility', 'hidden');
            var output = '';
            output = "<p>Publicações de conteúdos em vídeo, imagem ou gif. Seu canal de comunicação para curtir e comentar posts com recursos exclusivos de reactions, emojis, qualificação de conteúdo e exercícios de fixação para se manter informado e engajado.</p>";
            output = $.parseHTML(output);
            $list_item.append(output);
        });
    }
}


function answer_quiz($textarea) {
    var $item = $textarea.closest('.item'),
        $modal = $("#answer-quiz"),
        quiz_id = $item.data('quiz_id').toString();

    quiz_id = quiz_id.indexOf(',') !== -1 ? quiz_id.split(',') : [quiz_id];

    $modal.modal('show').find('.modal-body').html('Você precisa responder ' + quiz_id.length + ' quiz para poder comentar neste post.');
    $('.modal-footer a.go-quiz', $modal).attr('href', './quiz#' + $item.data('quiz_id'));
}

function termscommentaccept($textarea) {
    var $item = $textarea.closest('.item'),
        $modal = $("#accept-comments-terms-post"),
        $btn = $(".modal-footer #accept-comments-terms-btn", $modal);

    $btn.data('type', 'post');
    $btn.data('typeid', $item.data('post_id'));

    $modal.modal('show');

    $.get('./ws/team/get/1', function (data) {
        var text = data[0].privacycomment;
        text += '<p><b><i>Veja também: <a href="#termos-de-uso" onclick="open_privacy();return false;">Termos de uso</a></i></b></p>';
        $modal.find('.modal-body').html(text);
    });
}

function termscommentaccept_btn() {
    var $modal = $("#accept-comments-terms-post"),
        $btn = $(".modal-footer #accept-comments-terms-btn", $modal);

    $btn.click(function () {

        // $btn.attr('disabled', 'disabled');

        $.post('./ws/termscommentaccept/save', {
            type: $btn.data('type'),
            typeid: $btn.data('typeid')
        }, function () {
            termsarray.push($btn.data('typeid'));
            $('.list_item .item[data-post_id="' + $btn.data('typeid') + '"]').find('.comment-area.termscommentaccept-false').removeClass('termscommentaccept-false');
            $('.list_item .item[data-post_id="' + $btn.data('typeid') + '"]').find('.comment-comment.termscommentaccept-false').removeClass('termscommentaccept-false');

            $modal.modal('hide');
            $btn.removeAttr('disabled');
        });
    });
}

function pins_post($pin) {
    var $item = $pin.closest('.item'),
        fk_id = $item.data('post_id'),
        $modal = $('#pin-modal'),
        text = $item.find('.title-post').text();
    if ($item.hasClass('pin-true')) {
        $.post('ws/post/favoriteInsert', {
            fk_id: fk_id,
            text: text
        }, function (data) {

            if (data.error) {
                alert_box(data);
                return false;
            } else {
                var postsent = data.postsent,
                    favorites = data.favorites;
                $item.removeClass('pin-' + !postsent.pin);
                $item.addClass('pin-' + postsent.pin);

                if (postsent.status == "removed") {
                    alertMsg('Conteúdo já pinado')
                }
                ;

                //show_pins(favorites,'write');
                //load_pins('write');
            }
        });
    } else {
        $modal.modal('show');
        $('form input[name="text"]', $modal).val(text);
        $('form input[name="fk_id"]', $modal).val(fk_id);
    }
}
function load_emoji_post($localemoji, data) {
    var $localemoji = load_emoji($localemoji, data);
    if ($localemoji && $localemoji != undefined) {

        $localemoji.find('a').click(function () {
            var $post = $(this).closest('.item'),
                post_id = $post.data('post_id'),
                emoji_id = $(this).data('emoji-id'),
                $localemoji = $(this).closest('ul').find('span.emoji');
            $.post('ws/emojipost/save',
                {
                    post_id: post_id,
                    emoji_id: emoji_id
                },
                function (data) {
                    if (data.error) {
                        alert_box(data);
                        return false;
                    } else {
                        load_emoji_post($localemoji, data.emojipost);
                    }
                });
            return false;
        });
    }
}

function load_emoji_commment($localemoji, data) {
    var $localemoji = load_emoji($localemoji, data);
    if ($localemoji && $localemoji != undefined) {

        $localemoji.find('a').click(function () {

            var $postcomment = $(this).closest('.item_comment'),
                postcomment_id = $postcomment.data('comment_id'),
                emoji_id = $(this).data('emoji-id'),
                $localemoji = $postcomment.find('span.emojipostcomment');
            $.post('ws/emojipostcomment/save',
                {
                    postcomment_id: postcomment_id,
                    emoji_id: emoji_id
                },
                function (data) {
                    if (data.error) {
                        alert_box(data);
                        return false;
                    } else {
                        load_emoji_commment($localemoji, data.emojipostcomment);
                    }
                });
            return false;
        });
    }
}

function load_emoji($localemoji, data) {
    var $localemoji = $localemoji,
        data = data,
        output = '';

    if ($localemoji.length > 0) {

        get_template($localemoji);
        $localemoji.html('');
        if (data && data.length > 0) {
            for (i in data) {
                data[i].emoji_id = data[i].id;
                data[i].emoji_name = data[i].name;
                data[i].emoji_img = data[i].img;
                data[i].emoji_code = ":" + data[i].name + ":";
                data[i].emoji_count = data[i].count;
                output += fill_template($localemoji, data[i]);
            }

            $localemoji.html(output);
        }
    }

    return $localemoji;
}

function load_mentions(output) {
    $(output).find('.comment-area').atwho({
        at: "@",
        searchKey: 'q',
        minLen: 3,
        delay: 1000,
        insertTpl: "${atwho-at}${username}",
        displayTpl: '<li><img src="${img}"><p>${name} ${lastname}</p><p><small>@${username}</small></p><div class="clearfix"></div></li>',
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/user/get_user_mention/', {q: query}, function (data) {
                    $.each(data, function (i, el) {
                        data[i]['q'] = el.name + " " + el.username;
                    });
                    callback(data)
                });
            }
        }
    }).atwho({
        at: "*",
        searchKey: 'q',
        minLen: 3,
        delay: 1000,
        insertTpl: "${atwho-at}${name}",
        displayTpl: '<li><p>${name}</p><div class="clearfix"></div></li>',
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/group/get/', {q: query}, function (data) {
                    $.each(data, function (i, el) {
                        data[i]['q'] = el.name + " " + el.username;
                    });
                    callback(data)
                });
            }
        }
    }).atwho({
        at: ":",
        searchKey: 'q',
        minLen: 3,
        delay: 1000,
        insertTpl: ":${name}:",
        displayTpl: '<li class="emojis"><p><img src="${img}"> ${name}</p><div class="clearfix"></div></li>',
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/emoji/get/', {q: query}, function (data) {
                    var emojis = [],
                        emoji = data.emoji;
                    if (emoji) {
                        for (i in emoji) {
                            var item = emoji[i].item;
                            for (e in item) {
                                item[e]['q'] = item[e].name;
                                emojis.push(item[e]);
                            }
                        }
                    }
                    callback(emojis);
                });
            }
        }
    });


    $(output).find('.comment-comment').atwho({
        at: "@",
        searchKey: 'q',
        minLen: 3,
        delay: 1000,
        insertTpl: "${atwho-at}${username}",
        displayTpl: '<li><img src="${img}"><p>${name} ${lastname}</p><p><small>@${username}</small></p><div class="clearfix"></div></li>',
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/user/get_user_mention/', {q: query}, function (data) {
                    $.each(data, function (i, el) {
                        data[i]['q'] = el.name + " " + el.username;
                    });
                    callback(data)
                });
            }
        }
    }).atwho({
        at: "*",
        searchKey: 'q',
        minLen: 3,
        delay: 1000,
        insertTpl: "${atwho-at}${name}",
        displayTpl: '<li><p>${name}</p><div class="clearfix"></div></li>',
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/group/get/', {q: query}, function (data) {
                    $.each(data, function (i, el) {
                        data[i]['q'] = el.name + " " + el.username;
                    });
                    callback(data)
                });
            }
        }
    }).atwho({
        at: ":",
        searchKey: 'q',
        minLen: 3,
        delay: 1000,
        insertTpl: ":${name}:",
        displayTpl: '<li class="emojis"><p><img src="${img}"> ${name}</p><div class="clearfix"></div></li>',
        callbacks: {
            remoteFilter: function (query, callback) {
                $.getJSON('ws/emoji/get/', {q: query}, function (data) {
                    var emojis = [],
                        emoji = data.emoji;
                    if (emoji) {
                        for (i in emoji) {
                            var item = emoji[i].item;
                            for (e in item) {
                                item[e]['q'] = item[e].name;
                                emojis.push(item[e]);
                            }
                        }
                    }
                    callback(emojis);
                });
            }
        }
    });
}

function get_comments(data, out, comment_id) {
    for (i in data) {
        var post_id = data[i].id
        var comment = data[i].top_comment;
        load_comments(comment, out, post_id, comment_id, null);
    }
}

function textAreaAdjust(o) {
    if(o.scrollHeight > 38 ) {

        o.style.height = "1px";
        o.style.height = (25+o.scrollHeight)+"px";
    }

}

function load_comments(comment, out, post_id, comment_id, idja_nohtm) {
    var $post = $(out).filter('.post_id' + post_id),
        $list = $post.find('.list_comment');

    var todos = [];

    $.post('ws/postcomment/get', {
        post_id: "" + post_id + "",
        postcomment_id: "all",
        id: comment_id
    }, function (todos) {
        output = '';

        for (j in comment) {

            if (idja_nohtm == comment[j].id) {
                continue;
            }

            var q = 0;

            for (i in todos) {
                if (todos[i].postcomment_id == comment[j].id && todos[i].postcomment_id != null) {
                    q++;
                }
            }

            if (q > 1) {
                var output = '<div class="mid"><a href="#" class="loadMore" id="loadMore' + comment[j].id + '">Ver mais respostas</a>' +
                    '</div>' + output;
            }

            for (i in todos) {

                if (todos[i].postcomment_id == comment[j].id && todos[i].postcomment_id != null) {

                    var comment_variables = fill_comment_variables(todos, i, comment[j].id);

                    var output = fill_template($list, comment_variables) + output;
                }
            }

            var comment_variables = fill_comment_variables(comment, j, null);

            var output = fill_template($list, comment_variables) + output;

            var afterdate = comment[comment.length - 1].datetime;

        }

        $(out).filter('.post_id' + post_id).find('.list_comment').data('afterdate', afterdate)
        output = $.parseHTML(output);
        $list.prepend(output);
        if (comment_id) {
            var $comment_item = $list.find('#comment-id-' + comment_id);
            if ($comment_item && $comment_item.length > 0) {
                var bg_temp = "#d65a00",
                    bg_default = $comment_item.css('background-color'),
                    custom = get_custom();
                if (custom) {
                    bg_temp = custom.color1;
                }
                color = hexToRgb(bg_temp);
                color_string = "rgba(" + color.r + "," + color.g + "," + color.b + ",.15)";

                $comment_item.addClass('focus_trans');
                $comment_item.css({'background-color': color_string});
                $('#ui-layout-center').animate({scrollTop: $comment_item.offset().top - 200}, 0);
            }
        }


        //antigo
        //if ($list.data('total') - $list.find('.item_comment').length == 0) {
        if ($list.data('total') == 0) {
            $post.find('.more-comment').remove();
        } else {
            var count_comments = $list.find('.item_comment').length;
            var total = $list.data('total');
            $post.find('.more-comment .left').text(total - count_comments)
        }

        $(output).find('.emojiPostComment').emoji({
            action: 'click mouseover',
            position: 'top-right',
            callback: function (element, contanier) {

                var $postcomment = $(this).closest('.item_comment'),
                    postcomment_id = $postcomment.data('comment_id'),
                    emoji_id = element.id,
                    $localemoji = $postcomment.find('span.emojipostcomment');
                $.post('ws/emojipostcomment/save',
                    {
                        postcomment_id: postcomment_id,
                        emoji_id: emoji_id
                    },
                    function (data) {
                        if (data.error) {
                            alert_box(data);
                            return false;
                        } else {

                            load_emoji_commment($localemoji, data.emojipostcomment);
                        }
                    });
                contanier.hide();
            }
        });

        // comentarios_exibidos
        $(".comentarios_exibidos" + post_id).html($(".comment_post_group" + post_id).length);

        if ($(".comment_post_group" + post_id).length > 0) {
            $(".bc" + post_id).show();
        }

        var uw = 0;
        for (i in comment) {
            uw = uw + 1;
            if ($(".comment_group" + comment[i].id + ":hidden").length > 1) {
                $(".num_respostas" + comment[i].id + "").html('&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-share" aria-hidden="true"></i>&nbsp;&nbsp;' + $(".comment_group" + comment[i].id + ":hidden").length + ' respostas');
            }

            var $comment = $(output).filter(".item_comment[data-comment_id=" + comment[i].id + "]"),
                $localemoji = $comment.find('span.emojipostcomment');
            load_emoji_commment($localemoji, comment[i].emoji);


        }

        for (j in comment) {
            addSlideSubs(comment[j].id);
        }
        for (p in todos) {
            var $comment = $(output).filter(".item_comment[data-comment_id=" + todos[p].id + "]"),
                $localemoji = $comment.find('span.emojipostcomment');
            load_emoji_commment($localemoji, todos[p].emoji);
        }

    })

}

function addSlideSubs($id_comment_pai) {

    $(".comment_group" + $id_comment_pai).slice(0, 1).show();
    $("#loadMore" + $id_comment_pai).on('click', function (e) {
        e.preventDefault();
        $(".comment_group" + $id_comment_pai + ":hidden").slice(0, 4).slideDown();
        if ($(".comment_group" + $id_comment_pai + ":hidden").length == 0) {
            $("#loadMore" + $id_comment_pai).fadeOut('slow');
            $(".num_respostas" + $id_comment_pai + "").html('');
        }
        if ($(".comment_group" + $id_comment_pai + ":hidden").length > 0) {
            $(".num_respostas" + $id_comment_pai + "").html('&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-share" aria-hidden="true"></i>&nbsp;&nbsp;' + $(".comment_group" + $id_comment_pai + ":hidden").length + ' respostas');
        } else {
            $(".num_respostas" + $id_comment_pai + "").html('');
        }
        // $('html,body').animate({
        //     scrollTop: $(this).offset().top
        // }, 1500);
    });

    $(".num_respostas" + $id_comment_pai).on('click', function (e) {
        e.preventDefault();
        $(".comment_group" + $id_comment_pai + ":hidden").slice(0, 4).slideDown();

        if ($(".comment_group" + $id_comment_pai + ":hidden").length == 0) {
            $("#loadMore" + $id_comment_pai).fadeOut('slow');
            $(".num_respostas" + $id_comment_pai + "").html('');
        }

        if ($(".comment_group" + $id_comment_pai + ":hidden").length > 0) {
            $(".num_respostas" + $id_comment_pai + "").html('&nbsp;&nbsp;|&nbsp;&nbsp;<i class="fa fa-share" aria-hidden="true"></i>&nbsp;&nbsp;' + $(".comment_group" + $id_comment_pai + ":hidden").length + ' respostas');
        } else {
            $(".num_respostas" + $id_comment_pai + "").html('');
        }

        // $('html,body').animate({
        //     scrollTop: $(this).offset().top
        // }, 1500);
    });

    $('a[href=#top]').click(function () {
        $('body,html').animate({
            scrollTop: 0
        }, 600);
        return false;
    });

    $(window).scroll(function () {
        if ($(this).scrollTop() > 50) {
            $('.totop a').fadeIn();
        } else {
            $('.totop a').fadeOut();
        }
    });
}

function fill_comment_variables(comment, j, post_pai) {

    comment[j].comment_ctrl = me().usertype_id == 2 || me().id == comment[j].user_id ? '' : 'hidden';
    comment[j].comment_ctrl_edit = me().id == comment[j].user_id ? '' : 'hidden';
    comment[j].comment_delete = comment[j].id;
    comment[j].comment_edit = comment[j].id;
    comment[j].comment_id = comment[j].id;
    comment[j].comment_text = comment[j].text;
    comment[j].user = comment[j].user_id;
    comment[j].user_img = ( comment[j].user_img ? comment[j].user_img : './assets/img/user_pic.jpg' );

    if (comment[j].postcomment_id) {
        //entrou aqui é comment filho
        if (post_pai) {
            comment[j].comment_comment = "comment_comment comment_group" + post_pai;

        } else {
            comment[j].comment_comment = "comment_comment";

        }

        comment[j].id_comment_pai = post_pai;
        comment[j].hide_comment_comment = "display:none;";
    } else {
        // else nao tem postcomment id, entao é um pai

        comment[j].id_comment_pai = "";
        comment[j].comment_comment = "";
        comment[j].hide_comment_comment = "";
        comment[j].id_post_group = comment[j].post_id;
    }

    var date = comment[j].datetime;
    date = date.split(' ');
    hour = date[1].split(':', 2);
    comment[j].comment_hour = hour[0] + "h" + hour[1] + ' - ';
    date = date[0];
    var meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];
    date = date.split('-');
    //comment[j].date_comment = date[2] + " de " + meses[date[1] - 1] + " as ";
    comment[j].date_comment = date[2] + "/" + date[1] + "/" + date[0];

    return comment[j];
}


function modal_delete_comment(comment_id) {
    var delete_button = '<button type="button" id="oi" class="oi btn btn-orange" onclick="delete_comment(' + comment_id + ')" data-dismiss="modal">Apagar</button>';
    $('#delete-footer').html(delete_button);
    $('#delete_modal').modal('show');
}



function modal_answer_comment(comment_id, post_id, terms) {

    if (terms){
        var term = "true";
    } else {
        var term = "false";
    }


    if (me().permissions[7] == true) {
        $('#comment-comment-' + comment_id).remove();
        $('#comment-id-' + comment_id).append("<div class=\"textarea-emoji textarea-emoji-responder\"><textarea onkeyup=\"textAreaAdjust(this)\" maxlength=\"1024\" id=\"comment-comment-" + comment_id + "\" name=\"comment\" rows=\"1\" class=\"form-control comment-comment\ termscommentaccept-"+term+"\"></textarea><a href=\"#emojitextarea\" class=\"emojitextarea \">Emoji</a></div>");

    } else {

        $('#comment-comment-' + comment_id).remove();
        $('#comment-id-' + comment_id).append("<textarea maxlength=\"1024\" name=\"comment\" rows=\"1\" class=\"form-control comment-area comment-comment comment-feed answer-quiz-false termscommentaccept-true\" disabled=\"\" readonly=\"\" placeholder=\"Para obter permissão de envio entre em contato com o administrador.\" required=\"\" data-comment_id=\"\"></textarea>");
    }

    $('#comment-id-' + comment_id).find('.emojiPost').emoji({
        action: 'click mouseover',
        position: 'top-left',
        callback: function (element, contanier) {

            var $post = $(this).closest('.item'),
                post_id = $post.data('post_id'),
                emoji_id = element.id,
                $localemoji = $(this).closest('ul').find('span.emoji');
            $.post('ws/emojipost/save',
                {
                    post_id: post_id,
                    emoji_id: emoji_id
                },
                function (data) {
                    if (data.error) {
                        alert_box(data);
                        return false;
                    } else {
                        load_emoji_post($localemoji, data.emojipost);
                    }
                });
            contanier.hide();
        }
    });
    $('#comment-id-' + comment_id).find('.emojitextarea').emoji({
        action: 'click mouseover',
        position: 'top-left',
        callback: function (element, contanier) {
            var $textarea = $(this).prev('textarea');
            $textarea.val($textarea.val() + element.code + " ").focus();
            contanier.hide();
        }
    });



    if(terms){
        $('#comment-comment-' + comment_id).focus();
    } else {

        // este inarray é pelo fato dos textareas das subrespostas serem random, entao eh gravado um array com todos os posts q ele aceitou o termo
        if ( $.inArray( post_id, termsarray ) < 0 ) {
            $('#comment-comment-' + comment_id + '.comment-comment.termscommentaccept-false').on('keypress click', function (event) {
                if ($(this).hasClass('termscommentaccept-false')) {
                    termscommentaccept($(this));
                    return false;
                }
            });
        } else {
            $('#comment-comment-' + comment_id).focus();
        }

    }



    load_mentions($('#comment-id-' + comment_id));

    $('.comment-comment').keypress(function (event) {
        if (event.keyCode == 13 && !event.shiftKey) {

            comment_comment(comment_id, post_id, 0);
            return false;
        }
    });

}

function comment_comment(comment_pai, post_id, edit) {

    if (edit) {
        var text_area = $("textarea[data-comment_id='" + edit + "']");
    } else {
        edit = 0;
        var text_area = $('#comment-comment-' + comment_pai);
    }

    var str = text_area.val();

    if (str.trim() == '') {
        var data = {
            error: {
                1: "Por favor preencha o comentário"
            }
        };
        alert_box(data);
    } else {
        // text_area.attr('disabled', 'disabled');

        if (edit) {
            text_area.addClass('hidden');
            text_area.data('comment_id', '');
            text_area.prop('name', 'comment')

        }

        text_area.remove();
        $(".textarea-emoji-responder").remove();

        $.post('ws/postcomment/save_comment', {
            comment_pai: "" + comment_pai + "",
            comment_id: "" + edit + "",
            post_id: "" + post_id + "",
            text: "" + str + ""
        }, function (data) {
            if (data.error) {
                alert_box(data);
                return false;
            }

            var data_comment = data.comment[0];

            $list = $('.post_id' + post_id + ' .list_comment');

            data_comment.comment_ctrl = me().usertype_id == 2 || me().id == data_comment.user_id ? '' : 'hidden';
            data_comment.comment_ctrl_edit = me().id == data_comment.user_id ? '' : 'hidden';
            data_comment.comment_delete = data_comment.id;
            data_comment.comment_edit = data_comment.id;
            data_comment.comment_text = data_comment.text;
            data_comment.comment_id = data_comment.id;
            data_comment.hide_comment_comment = "display:none;";
            data_comment.user_img = ( data_comment.user_img ? data_comment.user_img : './assets/img/perfil.jpg' );
            var date = data_comment.datetime;
            var meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];
            date = date.split(' ');
            var hour = date[1].split(':', 2);
            date = date[0];
            date = date.split('-');
            //data_comment.date_comment = date[2] + " de " + meses[date[1] - 1] + " as ";
            data_comment.date_comment = date[2] + "/" + date[1] + "/" + date[0];
            data_comment.comment_hour = hour[0] + "h" + hour[1] + ' - ';
            var output = '';

            output += fill_template($list, data_comment);
            // throw new Error('THROW');

            output = $.parseHTML(output);

            if (edit) {

                $comment = $('#comment-id-' + edit);
                $comment.replaceWith(output);

                $item_comment = $("#comment-id-" + edit).addClass("comment_comment");
                $item_comment = $("#comment-id-" + edit).show();

                $text_area.remove();


            } else {
                // $comment = $('#comment_group-' + comment_pai ).last();

                $(".comment_group" + comment_pai).show();
                $("#loadMore" + comment_pai).fadeOut('slow');

                if ($(".comment_group" + comment_pai).length > 0) {

                    $last = $(".comment_group" + comment_pai).last();
                    $last.after(output);

                } else {
                    $comment = $('#comment-id-' + comment_pai);
                    $comment.after(output);
                }

                $item_comment = $("#comment-id-" + data_comment.id).addClass("comment_comment");
                $item_comment = $("#comment-id-" + data_comment.id).show();

                $textbox = $('#comment-comment-' + comment_pai);
                // $textbox.remove();
            }

        });
    }
}


function modal_complaint_comment(comment_id) {
    var complaint_button = '<button type="button"  class="oi btn btn-orange" onclick="complaint_comment(' + comment_id + ')" >Denunciar</button>';
    $('#complaint-footer').html(complaint_button);
    $('#complaint_modal').modal('show');
};

function delete_comment(comment_id) {
    var comment = '#comment-id-' + comment_id;
    $.post('ws/postcomment/delete/' + comment_id + '');
    $(comment).css("display", "none");
}

function complaint_comment(message_id) {
    if ($('#complaint_type option:selected').val() > 0) {
        var comment = '#comment-id-' + message_id;
        $.post('ws/postcomment/complaint/' + message_id + '', {
            'type': $('#complaint_type option:selected').val(),
            'description': $('#complaint_description').val()
        });
        $(comment).css("border", "1px solid red");
        $(comment + " > .conversations-info > .row > .conversations-name").append('<i title="Comentário denúnciado!" class="fa fa-exclamation-triangle" aria-hidden="true"></i>');
        $("#complaint_modal").modal('hide');
    } else {
        $("#complaint_valid").removeClass("hide");
    }
};

function edit_comment(comment_id, post_id, comment_pai) {
    $.post('ws/postcomment/get', {
        post_id: "" + post_id + "",
        postcomment_id: "all",
        id: "" + comment_id + ""
    }, function (data) {
        var text = data[0].text;
        text = strip_tags(text);

        var textArea = $('<textarea onkeyup=\"textAreaAdjust(this)\" maxlength="1024" name="edit" rows="1" id="coment-area-' + post_id +
            '" class="form-control comment-area comment-edit comment-feed answer-quiz-false termscommentaccept-true" required="" data-comment_id="' + comment_id +
            '" data-comment_pai="' + comment_pai + '">' + text +
            ' </textarea>');

        if (comment_pai) {
            textArea.addClass("comment-edit-sub");
        }

        $comment = $('#comment-id-' + comment_id);
        $comment.after(textArea);

        textArea.keypress(function (event) {
            if (event.keyCode == 13 && !event.shiftKey) {

                if (comment_pai) {
                    comment_comment(comment_pai, post_id, comment_id);
                } else {
                    comment(textArea, 1);

                }
            }
        });

    });
}

function strip_tags(html) {
    var tmp = document.createElement("DIV");
    tmp.innerHTML = html;
    return tmp.textContent || tmp.innerText || "";
}

function more_comments(btn, output, comment_id) {
    var post_id = $(btn).closest('.item').data('post_id'),
        afterdate = $(btn).closest('.item').find('.list_comment').data('afterdate'),
        idja_nohtm = $(btn).closest('.item').find('.item_comment').data('comment_id')
    var temp = $(location).attr('href');
    var comment_id = temp.indexOf('#') > 0 ? temp.split('#').pop() : "";

    $.post('ws/postcomment/get', {
        post_id: "" + post_id + "",
        afterdate: "" + afterdate + "",
        id: comment_id,
        postcomment_id: '',
        idja_nohtm: $(btn).data('idja_nohtm')
    }, function (data) {
        load_comments(data, output, post_id, comment_id, idja_nohtm);

        var total = $(btn).data('total');
        var total_total = $(btn).data('total_total') + 1;

        total = total - data.length;

        // (total == 1 ? ' comentário' : ' comentários')

        $(btn).data('total', total);

        $(btn).html('<span class="more-left">Exibir comentários anteriores</span>' +
            '<span class="more-right"><span class="comentarios_exibidos' + post_id + '">' + $(".comment_post_group" + post_id).length + '</span> de ' + total_total + '</span>');

        if (total < 1) {
            $(btn).remove();
        }

    })
}

function comment(btn, edit) {

    if (edit) {
        var text_area = btn;
    } else {
        var text_area = $(btn).closest('.box_comment').find('.comment-area');
    }
    var comment = text_area.val(),
        post_id = $(btn).closest('.item').data('post_id'),
        str = (" " + comment + " ").trim();
    text_area.val('' + str + '');

    if (str.trim() == '') {
        var data = {
            error: {
                1: "Por favor preencha o comentário"
            }
        };
        alert_box(data);
    } else {
        var comment_id = 0;
        var comment_pai = null;
        text_area.attr('disabled', 'disabled');
        if (text_area.prop('name') == 'edit') {
            comment_id = text_area.data('comment_id');
            comment_pai = text_area.data('comment_pai');
            $('#comment-id-' + comment_id).addClass('hidden');
            text_area.data('comment_id', '');
            text_area.data('comment_pai', '');
            text_area.prop('name', 'comment');
        }

        $.post('ws/postcomment/save', {
            post_id: "" + post_id + "",
            text: "" + comment + "",
            comment_id: "" + comment_id + ""
        }, function (data) {
            if (data.error) {
                alert_box(data);
                return false;
            }

            var data_comment = data.comment[0],
                $list = $('.post_id' + post_id + ' .list_comment');
            data_comment.comment_ctrl = me().usertype_id == 2 || me().id == data_comment.user_id ? '' : 'hidden';
            data_comment.comment_ctrl_edit = me().id == data_comment.user_id ? '' : 'hidden';
            data_comment.comment_delete = data_comment.id;
            data_comment.comment_edit = data_comment.id;
            data_comment.comment_text = data_comment.text;
            data_comment.comment_id = data_comment.id;
            data_comment.id_comment_pai = "";
            data_comment.user_img = ( data_comment.user_img ? data_comment.user_img : './assets/img/perfil.jpg' );
            var date = data_comment.datetime;
            var meses = ['janeiro', 'fevereiro', 'março', 'abril', 'maio', 'junho', 'julho', 'agosto', 'setembro', 'outubro', 'novembro', 'dezembro'];
            date = date.split(' ');
            var hour = date[1].split(':', 2);
            date = date[0];
            date = date.split('-');
            //data_comment.date_comment = date[2] + " de " + meses[date[1] - 1] + " as ";
            data_comment.date_comment = date[2] + "/" + date[1] + "/" + date[0];
            data_comment.comment_hour = hour[0] + "h" + hour[1] + ' - ';
            var output = '';

            output += fill_template($list, data_comment);
            output = $.parseHTML(output);

            if (edit) {
                $comment_id_div = $('#comment-id-' + comment_id);
                $comment_id_div.replaceWith(output);

                if ($(".comment_group" + comment_id).length > 0) {
                    window.location.reload();
                }

            } else {
                $list.append(output);
            }

            $('.emojipostcomment .template').hide();

            $('.comment-area').val('');
            $(output).find('a.emojiPostComment').emoji({
                action: 'click mouseover',
                position: 'top-right',
                callback: function (element, contanier) {

                    var $postcomment = $(this).closest('.item_comment'),
                        postcomment_id = $postcomment.data('comment_id'),
                        emoji_id = element.id,
                        $localemoji = $postcomment.find('span.emojipostcomment');
                    $.post('ws/emojipostcomment/save',
                        {
                            postcomment_id: postcomment_id,
                            emoji_id: emoji_id
                        },
                        function (data) {
                            if (data.error) {
                                alert_box(data);
                                return false;
                            } else {
                                $('.emojipostcomment .template').show();
                                load_emoji_commment($localemoji, data.emojipostcomment);
                            }
                        });
                    contanier.hide();
                }
            });


            if (edit) {

                text_area.remove();
            } else {
                text_area.removeAttr('disabled').focus();
            }


        });
    }
}

function getStar(stars, output) {

    var data_val = $(stars).data('value'),
        post_id = $(stars).closest('.item').data('post_id');
    $.post('ws/post/rate/' + post_id + '/' + data_val, function (data) {

        data = data.rate;
        var post_idWS = data.post_id,
            valuedWS = data.value;
        $('.post_id' + post_id + ' .avaliation .fa-star').removeClass('active')

        rating(post_idWS, valuedWS, output);
        clear_data_score_me();
        get_feeedback($(stars).closest('.item'));
    });
}

function rating(post_idWS, valuedWS, output) {
    for (i = 0; i <= valuedWS; i++) {
        $(output).filter('.post_id' + post_idWS).find('.star_' + i).addClass('active');
    }
}

function save_feeedback(textarea) {
    var $item = $(textarea).closest('.item');
    var $textarea = $(textarea);
    var text = ($textarea.val() != undefined && $textarea.val() != '') ? $textarea.val() : "",
        post_id = $item.data('post_id');
    // $textarea.attr('disabled', 'disabled');
    $.post('ws/postfeedback/save', {post_id: post_id, text: text}, function (data) {
        if (data.error) {
            alert_box(data);
        } else {
            alertMsg(data.msg);
            $item.find('.modal-avaliation-1').modal('hide');
        }
        $textarea.removeAttr('disabled');
        clear_data_score_me();
    });
}

function get_feeedback($item) {
    var post_id = $item.data('post_id'),
        $textarea = $item.find('textarea.feedback');
    $textarea.removeAttr('disabled');
    $.post('ws/postfeedback/get', {post_id: post_id}, function (data) {
        var text = "";
        if (data.error) {
            alert_box(data);
            return false;
        } else {
            text = data.text;
        }

        $textarea.val(text);
        $item.find('.modal-avaliation-1').modal('show');
    });
}

function submit_favorite() {
    var $modal = $('#pin-modal');
    $("form", $modal).submit(function () {
        var data = $(this).serialize(),
            fk_id = $('form input[name="fk_id"]', $modal).val(),
            $item = $(".item.post_id" + fk_id);
        $.post('ws/post/favorite', data, function (data) {
            if (data.error) {
                alert_box(data);
                return false;
            } else {
                //var postsent = data.postsent,
                //favorites = data.favorites;
                //$item.removeClass('pin-' + !postsent.pin);
                //$item.addClass('pin-' + postsent.pin);
                //show_pins(favorites);
                load_pins('write');
                $modal.modal('hide');
                $('form input', $modal).val('');
            }
        });
        return false;
    });
}

function load_react($localreact, data) {
    var $localreact = $localreact,
        data = data,
        output = '';
    get_template($localreact, 'template-reactions');
    $localreact.html('');
    if (data && data.length > 0) {
        for (i in data) {
            var react = {
                react_name: data[i].name,
                react_id: data[i].id,
                react_img: data[i].img,
                react_count: data[i].count
            };
            output += fill_template($localreact, react, 'template-reactions');
        }

        $localreact.html(output);
        return $localreact;
    }
}

function load_react_post($localreact, data) {
    var $localreact = load_react($localreact, data);
    if ($localreact && $localreact != undefined) {

        $localreact.find('a').click(function () {

            var $item = $(this).closest('.item'),
                post_id = $item.data('post_id'),
                react_id = $(this).data('id');
            $.post('ws/reactpost/save', {post_id: post_id, react_id: react_id}, function (data) {
                if (data.error) {
                    alert_box(data);
                    return false;
                } else {
                    load_react_post($localreact, data.reactpost);
                }
            });
            return false;
        });
    }

}

function react($output) {
    $.get('ws/react/get', function (data) {
        var $react_post = $output.find(".react-post"),
            $react_group = $react_post.find('.react ul'),
            $react_item = $react_post.find('.react'),
            timeout = 500,
            timer;
        output = '';
        if (Object.keys(data.react).length > 0) {

            for (i in data.react) {
                var icon = {
                    react_name: data.react[i].name,
                    react_id: data.react[i].id,
                    react_img: data.react[i].img
                };
                output += fill_template($react_group, icon, 'template-react-icon');
            }

            $react_group.html(output);
            $react_item.on("mouseenter", function () {

                $(".react-post .react").removeClass('open');
                $(this).addClass('open');
                clearTimeout(timer);
            }).on("mouseleave", function () {
                var $this = $(this);
                timer = setTimeout(function () {
                    $this.removeClass('open');
                }, timeout);
            });

            $react_group.find("a").click(function () {
                var $parent = $(this).closest('.react'),
                    $item = $parent.closest('.item'),
                    $localreact = $item.find('.reactions');
                post_id = $item.data('post_id'),
                    react_id = $(this).data('id');
                $.post('ws/reactpost/save', {post_id: post_id, react_id: react_id}, function (data) {
                    if (data.error) {
                        alert_box(data);
                        return false;
                    } else {
                        load_react_post($localreact, data.reactpost);
                    }
                });
                $parent.removeClass('open');
                return false;
            });
        }
    })
}

function check_video_view($post) {

    var $videos = $post.find('.quadro .embed-video');

    if ($videos.length > 0) {

        $videos.each(function (i, element) {
            var $video = $(element);

            var video = $video.data('src'),
                thumbnail = $video.data('thumbnail');

            var playerInstance = jwplayer($video[0]);

            playerInstance.setup({
                "file": video,
                "image": thumbnail,
                "width": "100%",
                "height": 307,
                "preload": "metadata",
                "bufferlength": '20'
            }).on('play', function () {
                if ($(element).data('play') != true) {
                    var post_id = $(this)[0].id,
                        post_id = post_id.replace('video-id-', '');

                    $.post('ws/post/get', {id: post_id});
                    $(element).data('play', true);
                }
            });
        });
    }
}
function open_image(image, post_id) {
    $('.popup-image img').attr('src', image);
    $('.popup-image').css('display', 'flex');
    $.post('./ws/post/get', {id: post_id});
}

function listUseByReaction(post_id, react_id) {
    $tab_pane = $("#react_users" + react_id);
    if ($tab_pane.html() != '') {
        return;
    }
    $(".load-reactions-users").show();
    $bloco = '';
    if (react_id == 0) {
        url = 'ws/reactpost/getAllReactionsByPost/' + post_id;
    } else {
        url = 'ws/reactpost/usersByPostReaction/' + post_id + '/' + react_id;
    }
    $.post(url, function (data) {
        $(".load-reactions-users").hide();
        for (i in data) {
            console.log(data[i]);
            $bloco = '<div class="col-md-12" style="height: 65px;border-bottom: 1px solid #eae8e8;float:left;position:relative;    margin-top: 10px;padding:0px">' +
                '<a href="#" onclick="user_info(' + data[i].id + '); return false;"  style="width: 60px;height: auto;overflow: visible;position: relative;float: left;">' +
                '<img ' +
                'class="img-user w100" ' +
                'style="width:50px;float: left;    border-radius: 50% !important;" ' +
                'src="' + data[i].img + '" ' +
                'alt="">' +
                '<img src="' + data[i]['reaction_img'] + '" style="position: absolute;width: 16px;right: 6px;top: 34px;" />' +
                '</a>' +
                '<div style="position: relative;float: left;width: 300px;line-height: 65px;display: inline;margin-left: 10px;">' +
                data[i].name +
                '</div>' +
                '</div>';
            $tab_pane.append($bloco);
        }
    });
}

function getReactionsByPost(post_id, react_id) {
    $ul = $("ul#tab-reactpost");
    $tab_content = $("#reactionsinfo_modal .tab-content");
    $ul.empty();
    $tab_content.empty();
    $(".load-reactions-users").show();
    $("#reactionsinfo_modal").modal('toggle');
    $.post('ws/reactpost/countByPost/', {post_id: post_id}, function (data) {
        if (data['reactions'].length > 1) {
            createTabPane($tab_content, $ul, 0, post_id, '', false, data['total']);
        }
        $(".load-reactions-users").hide();
        for (i in data['reactions']) {
            blocos = {};
            total = data['reactions'][i].total;
            react_id = data['reactions'][i].react_id;
            img = data['reactions'][i].img;
            createTabPane($tab_content, $ul, react_id, post_id, img, true, total);
        }
        if (typeof(react_id) === 'undefined') {
            react_id = data[0].react_id;
        }
        $("#tab-reactpost").animate(
            {scrollLeft: $("li[data-react_id=\"" + react_id + "\"]").position().left}, 500);
        $("li[data-react_id=\"" + react_id + "\"] a").trigger("click");

    });
}

function createTabPane($tab_content, $ul, react_id, post_id, label, isLabelImg, text) {
    if (isLabelImg == true) {
        label = "<img src=\"" + label + "\" style=\"width:20px\" />";
    } else {
        text = "Ver todas as " + text + " reações";
        label = '';
    }
    var li_add = "<li data-react_id=\"" + react_id + "\" style=\"display:inline; zoom:1;\">" +
        "<a data-toggle=\"tab\" href=\"#react_users" + react_id + "\" onclick=\"listUseByReaction(" + post_id + "," + react_id + ")\">" + label +
        "<span class=\"total\">" + text + "</span>" +
        "</a>" +
        "</li>";
    var tab_pane = "<div id=\"react_users" + react_id + "\" class=\"tab-pane fade\"></div>";
    $tab_content.append(tab_pane);
    $ul.append(li_add);

}