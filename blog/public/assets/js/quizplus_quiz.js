
function preview(url, name, blockdown) {
    var iframe = '<iframe src="https://docs.google.com/viewer?url=' + url + '&output=embed&&embedded=true" style="width:100%; height:400px;" frameborder="0"></iframe>',
        title = '<h4>' + name + '</h4>',
        //download = '<a href="' + url + '" download="' + name + '"><button type="button" class="btn btn-default btn-orange">Download</button></a>';
        download = '';
    $('#preview-header').html(title);
    $("#preview-body").html(iframe);
    if (blockdown) {
        $("#preview-confirm").html(download);
    }
    $('#modal-preview').modal('show');
}
$(document.body).on('click', '.btn-finished', function() {
    var learnclass_id = $('#learnclass_id').val();
    var user_id = $('#user_id').val();
    $.ajax({
        method: 'POST',
        data: {learnclass_id:learnclass_id,user_id:user_id,status:1},
        url: "./learn/learn/saveFinished/",
        beforeSend: function () {
            $('.btn-finished').prop( "disabled", true );
            $('.btn-finished').attr("value","Aguarde...");
        },
        complete: function () {
            $('.btn-finished').prop( "disabled", false );
            $('.btn-finished').attr("value","FINALIZAR");
        },
        success: function (data) {
           if (data.msg == 'Finalizado') {
               location.reload();
           }
        }
    });

});
$(document.body).on('click', '.responde', function(){
    var varinput = $(this);
    var classe = $(this).prevAll('.content-answ');
    var order = classe.data('order');
    var obrigatorio = false;
    var total_question = $('.total_question').val();
    var total_respondidas = $('.total_respondidas').val();
    for (i=order-1; i >= 0; i--) {
        var selector = $('.content-answ').filter('[data-order="'+i+'"]');
        if (selector.length == 0) {
            if (selector.data('required') == 1) {
                obrigatorio = true;
            }
        } else {
            if (selector.eq(i).attr('data-required') == 1){
                obrigatorio = true;
            }
        }

    }
    var data = $(this).parents('form').serialize();

    if (obrigatorio == false) {
        $.ajax({
            method: 'POST',
            data: data,
            url: "./learn/responses/create/"+$('.learn').data('id'),
            beforeSend: function () {
                varinput.prop( "disabled", true );
                varinput.attr("value","Aguarde...");
            },
            complete: function () {
                varinput.prop( "disabled", false );
                varinput.attr("value","Responder");
            },
            success: function (data) {
                if(classe.data('required') == 1) {
                    if (data.answered_all == 1) {
                        classe.attr('data-required','0');
                    }
                }
                for (i=0;i<data.ids.length;i++){
                    var inpt = $("#id-radio-"+data.ids[i]).parents('.answer');

                    inpt.attr('data-respondida','1');
                }
                var total = $( ".answer[data-respondida='1'] input:checked" ).length;
                var percent_progress = (100*total)/total_question;

                $(".progress-quiz").css("width", percent_progress+"%").html(percent_progress+"%");

                alertMsgFadeOut('Respostas salvas com sucesso!',8);
            }
        });
    } else {
        alertErrorMsgFade('Existem perguntas para serem respondidas.',8);
    }

    return false;
});

$( document ).ready(function() {
    $('.learn').animate({
        scrollTop: 0
    }, 800);
    var learnclass_id = $('#learnclass_id').val();
    var user_id = $('#user_id').val();
    var id_quiz = $('#id_quiz').val();

    var url_sub = extract_url(3);
    var route_from_adm = 0;
    if(url_sub == "visualization_user"){
        route_from_adm = 1;
    }


    if(!route_from_adm)
    {

        $.ajax({
            method: 'POST',
            data: {user_id: user_id, learnclass_id: learnclass_id},
            url: "learn/quiz/" + id_quiz + "/get_detail_by_user",
            beforeSend: function () {
                $('.details').hide();
                $('.statistic-quiz-load').show();
            },
            complete: function () {
                $('.details').show();
                $('.statistic-quiz-load').hide();
            },
            success: function (data) {
                var p_obtidos = data[0].pontos_obtidos;
                if (p_obtidos == null) {
                    p_obtidos = 0;
                }
                switch (data[0].result) {
                    case 'Entregue':
                        $('.running_quiz').show();
                        $('.closed_quiz').hide();
                        $('.content-correction').hide();
                        $('.btn-finished').hide();
                        break;
                    case 'Não Entregue':
                        $('.running_quiz').hide();
                        $('.closed_quiz').show();
                        $('#learn_container').addClass('hide');
                        $('.resume').show();
                        $('.btn-finished').hide();
                        $('.content-progress').hide();
                        $('.timeout-entregue').hide();
                        $('.timeout').show();
                        $('.content-correction').hide();
                        $('#btn_verify').hide();
                        var msgbox = $('.msgbox p');
                        $('.msgbox p').css({'right': '42px', 'top': '-84px'});
                        msgbox.html(msgbox.html().replace("##msg-tipo##", 'Você não entregou'));
                        break;
                    case 'Aprovado':
                        $('.running_quiz').hide();
                        $('.closed_quiz').show();
                        $('#learn_container').addClass('hide');
                        $('.resume').show();
                        $('.btn-finished').hide();
                        $('.content-progress').hide();
                        $('.timeout-entregue').hide();
                        $('.timeout').show();
                        var msgbox = $('.msgbox p');
                        msgbox.html(msgbox.html().replace("##msg-tipo##", 'Parabéns!<br>Você ganhou ' + data[0].pontos + ' pontos<br/>e foi aprovado'));
                        break;
                    case 'Reprovado':
                        $('.running_quiz').hide();
                        $('.closed_quiz').show();
                        $('#learn_container').addClass('hide');
                        $('.resume').show();
                        $('.btn-finished').hide();
                        $('.content-progress').hide();
                        $('.timeout-entregue').hide();
                        $('.timeout').show();
                        var msgbox = $('.msgbox p');
                        msgbox.html(msgbox.html().replace("##msg-tipo##", 'Você ganhou ' + p_obtidos + ' pontos<br/>e foi reprovado'));
                        break;

                }
                console.log(data);
                if (data[0].result != 'Reprovado' && data[0].result != 'Aprovado') {
                    quiz_count_down(data[0].finishin);
                }
                checkResult(data[0].result);
                $(".details").attr('data-res', data[0].result);
                var status_fim = $(".status-fim");
                status_fim.html(status_fim.html().replace("##status-fim##", data[0].result));
                var inst = $(".instruc_name");
                inst.html(inst.html().replace("##instructor##", data[0].instructor));
                $('.linkdminstructor').attr("href", "./message/" + data[0].instructor_username);
                var modelo = $(".modelo_name");
                modelo.html(modelo.html().replace("##modelo##", data[0].category));
                var tipo = $(".tipo_name");
                tipo.html(tipo.html().replace("##tipo##", data[0].classtype));
                var pc = $(".pc");
                //pc.html(pc.html().replace("##pontos-n-conquistado##",data[0].pontos_obtidos));
                if (data[0].pontos_obtidos != null) {
                    pc.html(pc.html().replace("##pontos-n-conquistado##", data[0].pontos_obtidos));
                } else {
                    pc.html(pc.html().replace("##pontos-n-conquistado##", "-"));
                }

                var pd = $(".disponiveis");
                pd.html(pd.html().replace("##pontos-disponiveis##", data[0].pontos));
                $("#circlesample").percircle({percent: Math.round(((data[0].pontos_obtidos / data[0].pontos) * 100))});
                $("#circlesample2").percircle({
                    percent: Math.round(((data[0].certas / data[0].perguntas) * 100)),
                    progressBarColor: "#f7a600",
                });
                $("#resumecircle_points").percircle({percent: Math.round(((data[0].pontos_obtidos / data[0].pontos) * 100))});
                $("#resumecircle_questions").percircle({
                    percent: Math.round(((data[0].certas / data[0].perguntas) * 100)),
                    progressBarColor: "#f7a600",
                });
                var qst_act = $(".qst-act");
                if (data[0].certas != null) {
                    qst_act.html(qst_act.html().replace("##qst-acertos##", data[0].certas));
                } else {
                    qst_act.html(qst_act.html().replace("##qst-acertos##", "-"));
                }

                var qst_act = $(".qst-dispo");
                qst_act.html(qst_act.html().replace("##qst-dispo##", data[0].perguntas));
                $('.input-progress').val(data[0].perguntas);
                var title = $(".title");
                title.html(title.html().replace("##quiz-title##", data[0].title));

                var status = $(".status-esq");
                status.html(status.html().replace("##result##", data[0].result));
                if (data[0].result == 'aprovado') {
                    $(".status-esq").show();
                    $(".status-esq").css("background", "rgb(77, 169, 131)");
                } else if (data[0].result == 'reprovado') {
                    $(".status-esq").show();
                    $(".status-esq").css("background", "rgb(236, 70, 48)");
                    $(".status-fim").css("background", "rgb(236, 70, 48)");
                } else {
                    $(".status-esq").show();
                    $(".status-esq").css("background", "rgb(255, 51, 49)");
                    $(".status-fim").css("background", "rgb(255, 51, 49)");
                }
                var res_perc = $(".result-percent");
                res_perc.html(res_perc.html().replace("##result-percent##", data[0].meta));
            }

        });
    }

    if(route_from_adm){

        $('.quizuserinfo_adm').hide() ;
        $('.quizcontent_adm').addClass("wid84") ;
        $('input[type=radio]').prop("disabled",true);
        $('.responde').remove() ;
        $('.quizuserinfo').hide() ;
        id_quiz =  extract_url(2);

    }

    $(document.body).on('click', '.ball' ,function(){
        var scroll = $(this).data('scroll');

        var learncontainer = $('.cont-learn').offset().top;

        if ($('#learn_container').hasClass("hide")) {
            var learn = $('.resume div[data-scroll="'+scroll+'"]').offset().top;
            var totalTop = (learn-learncontainer);
        } else {
            var learn = $('.cont-learn div[data-scroll="'+scroll+'"]').offset().top;
            var totalTop = (learn-learncontainer)-11;
        }

        $('.learn').animate({
            scrollTop: totalTop
        }, 800);

    });
    $('#btn_verify').click(function(e){
        e.preventDefault();
        var learncontainer = $('.cont-learn').offset().top;
        var learn = $('.content-correction').offset().top;
        var totalTop = (learn-learncontainer);
        $('.learn').animate({
            scrollTop: totalTop+30
        }, 800);

    });

    var learnclass_id = $('#learnclass_id').val();
    var user_id = $('#user_id').val();
    var id_quiz = $('#id_quiz').val();

    $('[data-toggle="tooltip"]').tooltip();
    $.ajax({
        method: 'POST',
        data: {learnclass_id: learnclass_id, user_id:user_id},
        url: "learn/quiz/"+id_quiz,
        beforeSend: function(){
            $('.learn').hide();
            $('.timeline').hide();
            $('.statistic-quiz-load').show();
        },
        complete: function(){
            $('.learn').show();
            $('.timeline').show();
            $('.statistic-quiz-load').hide();
        },
        success: function(data) {
            console.log(data);
            var obrigatorio;
            var conta = 0;
            var conta_respondidas = 0;
            var total_question = 0;
            var timeline = $(".timeline");
            var number_question = 0;
            $(data.Quiz[0].drops).each(function(index, item) {
                if(item.contents.length > 0){
                    conta++;
                    timeline.append(
                        "<div class='lineSegment'></div><div class='ball line"+item.contents[0].type[0].name+"' data-scroll='"+ conta +"' data-toggle='tooltip' data-placement='right' data-local='' title='"+item.contents[0].type[0].name+"'></div>"
                    );
                    if (item.contents[0].content[0] != null) {
                        switch(item.contents[0].type[0].name)
                        {
                            case "Post":
                                //missing icon, videooutput, condition vrf null to show img or video
                                var content_model = $("#content_models .model_post").html().toString();
                                var content_post = item.contents[0].content[0];
                                var title = content_post.title;
                                var content_date = content_post.datetime.substr(11, 2) + 'h' + content_post.datetime.substr(14, 2);
                                content_date += " - " + content_post.datetime.substr(8, 2) + '/' + content_post.datetime.substr(5, 2) + '/' + content_post.datetime.substr(0, 4);
                                $("#learn_container").html($("#learn_container").html() +
                                    content_model.replace("##id##", content_post.id)
                                        .replace("##imgicon##", content_post.src)
                                        .replace("##title-post##", title)
                                        .replace("##item-conta##",conta)
                                        .replace("##text##", content_post.text)
                                        .replace("##imgpost##", content_post.img) + "<br/>"
                                );
                                //preenche div de correção
                                $(".content-correction").html($(".content-correction").html() +
                                    content_model.replace("##id##", content_post.id)
                                        .replace("##imgicon##", content_post.src)
                                        .replace("##title-post##", title)
                                        .replace("##date##", content_date)
                                        .replace("##item-conta##",conta)
                                        .replace("##text##", content_post.text)
                                        .replace("##imgpost##", content_post.img) + "<br/>"
                                );
                                break;

                            case "Wiki":
                                var content_model = $("#content_models .model_wiki").html().toString();
                                var content_post = item.contents[0].content[0];
                                var content_date = monthName(content_post.datetime.substr(5, 2)) + ' de ' + content_post.datetime.substr(0, 4);
                                $("#learn_container").html($("#learn_container").html() +
                                    content_model.replace("##id##", content_post.id)
                                        //.replace("##imgicon##", "./assets/img/doc.png")
                                        .replace("##title-wiki##", content_post.title)
                                        .replace("##createdate##", content_date)
                                        .replace("##item-conta##",conta)
                                        .replace("##createby##", content_post.creator)
                                        .replace("##createbylast##", content_post.creator_lastname)
                                        .replace("##text##", content_post.text) + "<br/>"
                                );
                                //preenche div de correção
                                $(".content-correction").html($(".content-correction").html() +
                                    content_model.replace("##id##", content_post.id)
                                        //.replace("##imgicon##", "./assets/img/doc.png")
                                        .replace("##title-wiki##", content_post.title)
                                        .replace("##createdate##", content_date)
                                        .replace("##item-conta##",conta)
                                        .replace("##createby##", content_post.creator)
                                        .replace("##createbylast##", content_post.creator_lastname)
                                        .replace("##text##", content_post.text) + "<br/>"
                                );
                                break;

                            case "Texto":
                                var content_model = $("#content_models .model_text").html().toString();
                                var content_post = item.contents[0].content;
                                $("#learn_container").html($("#learn_container").html() +
                                    content_model.replace("##id##", item.contents[0].id)
                                        .replace("##item-conta##",conta)
                                        .replace("##imgicon##", "./assets/img/doc.png")
                                        .replace("##title##", item.name)
                                        .replace("##text##", content_post) + "<br/>"
                                );
                                $(".content-correction").html($(".content-correction").html() +
                                    content_model.replace("##id##", item.contents[0].id)
                                        .replace("##item-conta##",conta)
                                        .replace("##imgicon##", "./assets/img/doc.png")
                                        .replace("##title##", item.name)
                                        .replace("##text##", content_post) + "<br/>"
                                );
                                break;

                            case "Video":
                                var content_model = $("#content_models .model_video").html().toString();
                                var content_post = item.contents[0].content;
                                //var content_post = 'http://dev.localhost/b9ed3f3f-dca4-46a2-8f4d-ee35b1ce329b';
                                $("#learn_container").html($("#learn_container").html() +
                                    content_model.replace("##id##", item.contents[0].id)
                                        .replace("##item-conta##",conta)
                                        .replace("##imgicon##", "./assets/img/doc.png")
                                        .replace("##videoid##", "video-id-"+item.contents[0].id)
                                        .replace("##title##", item.name)
                                        .replace("##video##",'data-src="'+content_post+'"')
                                        .replace("##video-2##", "") + "<br/>"
                                );

                                $(".content-correction").html($(".content-correction").html() +
                                    content_model.replace("##id##", item.contents[0].id)
                                        .replace("##item-conta##",conta)
                                        .replace("##imgicon##", "./assets/img/doc.png")
                                        .replace("##videoid##", "video-id-correct-"+item.contents[0].id)
                                        .replace("##title##", item.name)
                                        .replace("##video-2##",'data-src="'+content_post+'"')
                                        .replace("##video##", "") + "<br/>"
                                );


                                var video_pl = content_post,
                                    thumbnail_pl = "https://s3.amazonaws.com/beedoo-user-us/default/icon-default-beedoo-post.jpg";

                                var player = jwplayer("video-id-correct-" + item.contents[0].id);

                                player.setup({
                                    "file": video_pl,
                                    "image": thumbnail_pl,
                                    "width": "100%",
                                    "height": 307,
                                    "preload": "metadata",
                                    "bufferlength": '20'
                                });
                                var video = content_post,
                                    thumbnail = "https://s3.amazonaws.com/beedoo-user-us/default/icon-default-beedoo-post.jpg";
                                var playerInstance = jwplayer("video-id-" + item.contents[0].id);
                                playerInstance.setup({
                                    "file": video,
                                    "image": thumbnail,
                                    "width": "100%",
                                    "height": 307,
                                    "preload": "metadata",
                                    "bufferlength": '20'
                                });
                                break;

                            case "Arquivo":
                                var content_model = $("#content_models .model_file").html().toString();
                                var content_post = item.contents[0].content[0];
                                $("#learn_container").html($("#learn_container").html() +
                                    content_model.replace("##id##", content_post.id)
                                        .replace("##imgicon##", "./assets/img/doc.png")
                                        .replace("##item-conta##",conta)
                                        .replace("##url##", content_post.text)
                                        .replace("##title##", item.name)
                                        .replace("##file##", content_post.text) + "<br/>"
                                );
                                $(".content-correction").html($(".content-correction").html() +
                                    content_model.replace("##id##", content_post.id)
                                        .replace("##imgicon##", "./assets/img/doc.png")
                                        .replace("##item-conta##",conta)
                                        .replace("##url##", content_post.text)
                                        .replace("##title##", item.name)
                                        .replace("##file##", content_post.text) + "<br/>"
                                );
                                break;

                        }
                    }

                }
                if(item.questions.length > 0){
                    conta++;
                    timeline.append(
                        "<div class='lineSegment'></div><div class='ball lineQuestion' data-scroll='"+conta+"' data-toggle='tooltip' data-placement='right' title='Avaliação'></div>"
                    );


                    var content_all = $("#content_models .soufoda").html().toString();
                    var question = "";
                    var cont = 0;
                    var question_correct = "";
                    for(i = 0; i<item.questions.length; i++) {
                        total_question++;
                        number_question++;
                        var content_model = $("#content_models .model_question").html().toString();
                        if (item.required==1) {
                            var content_post = item.questions[i].title+"<span class='ast-spn'>*</span>";
                        } else {
                            var content_post = item.questions[i].title;
                        }
                        var answers = "";
                        var answers_correct = "";
                        var answered = 0;
                        var separacao = "sep-quiz";
                        var correctasw = 0;
                        for(a = 0; a<item.questions[i].answers.length; a++) {
                            var answer_model = $("#content_models .model_answer").html().toString();
                            var content_answer = item.questions[i].answers[a].title;
                            var correct = item.questions[i].answers[a].answered;
                            var weight = item.questions[i].answers[a].weight;

                            if (weight== 1) {
                                var icon = 'fa-check-circle i-font-correct';
                            } else {
                                var icon = 'fa-times-circle i-font-wrong';
                            }
                            if (correct != null) {
                                var answ_class = "missed";
                            }
                            if (correct !=null && weight == 1) {
                                correctasw++;
                                var answ_class = "correct";
                            }
                            if (correct != null) {
                                cont++;
                                conta_respondidas++;

                                answers += answer_model.replace("##id##", item.questions[i].answers[a].id)
                                    .replace("##value##", item.questions[i].answers[a].id)
                                    .replace("##idquestion##", "learnanswer_id["+ item.questions[i].id+"]")
                                    .replace("##answer##", content_answer)
                                    .replace("##radio-answer##","")
                                    .replace("##answ-class##","")
                                    .replace("##disbaled##","")
                                    .replace("##respondida##","1")
                                    .replace("##checked##",'checked');

                                answers_correct += answer_model.replace("##id##", item.questions[i].answers[a].id)
                                    .replace("##value##", item.questions[i].answers[a].id)
                                    .replace("##idquestion##", "learnanswer_id["+ item.questions[i].id+"]")
                                    .replace("##answer##", content_answer)
                                    .replace("##radio-answer##","<i class='fa "+icon+"' aria-hidden='true'></i>")
                                    .replace("##answ-class##",answ_class)
                                    .replace("##respondida##","0")
                                    .replace("##disbaled##","disabled")
                                    .replace("##checked##",'checked');
                            } else {
                                answers += answer_model.replace("##id##", item.questions[i].answers[a].id)
                                    .replace("##value##", item.questions[i].answers[a].id)
                                    .replace("##idquestion##", "learnanswer_id["+ item.questions[i].id+"]")
                                    .replace("##answer##", content_answer)
                                    .replace("##radio-answer##","")
                                    .replace("##answ-class##","")
                                    .replace("##disbaled##","")
                                    .replace("##checked##",'');

                                answers_correct += answer_model.replace("##id##", item.questions[i].answers[a].id)
                                    .replace("##value##", item.questions[i].answers[a].id)
                                    .replace("##idquestion##", "learnanswer_id["+ item.questions[i].id+"]")
                                    .replace("##answer##", content_answer)
                                    .replace("##answ-class##","")
                                    .replace("##disbaled##","disabled")
                                    .replace("##radio-answer##","<i class='fa "+icon+"' aria-hidden='true'></i>")
                                    .replace("##checked##",'');
                            }
                        }
                        if (correctasw == 1) {
                            var frase = "<span class='acertou-spn'>Acertou</span>";
                        } else {
                            var frase = "<span class='errou-spn'>Errou</span>";
                        }
                        if (i == 0) {
                            question += content_model.replace("##id##", item.questions[i].id)
                                .replace("##question##", content_post)
                                .replace("##answers##", answers)
                                .replace("##item-conta##",conta)
                                .replace("##icon-correct##","")
                                .replace("##i##",'<div class="comp-top"><div class="ball-qst"><i class="fa fa-question-circle-o"></i></div><span class="title-span s-text">'+item.name+'</span></div>')
                                .replace("##separacao##", separacao);

                            question_correct += content_model.replace("##id##", item.questions[i].id)
                                .replace("##question##", "<span class='spn-correct'>"+content_post+"</span>")
                                .replace("##answers##", answers_correct)
                                .replace("##item-conta##",conta)
                                .replace("##i##",'<div class="comp-top"><div class="ball-qst"><i class="fa fa-question-circle-o"></i></div><span class="title-span s-text">'+item.name+'</span></div>')
                                .replace("##icon-correct##",frase)
                                .replace("##separacao##", separacao);

                        } else {
                            question += content_model.replace("##id##", item.questions[i].id)
                                .replace("##question##", content_post)
                                .replace("##answers##", answers)
                                .replace("##i##","")
                                .replace("##item-conta##",conta)
                                .replace("##icon-correct##","")
                                .replace("##separacao##", separacao);

                            question_correct += content_model.replace("##id##", item.questions[i].id)
                                .replace("##question##", "<span class='spn-correct'>"+content_post+"</span>")
                                .replace("##answers##", answers_correct)
                                .replace("##item-conta##",conta)
                                .replace("##i##",'')
                                .replace("##icon-correct##",frase)
                                .replace("##separacao##", separacao);
                        }
                    }
                    if (item.required==1 && cont==item.questions.length) {
                        answered = 0;
                    } else if(item.required==1) {
                        answered = 1;
                    }
                    $("#learn_container").html($("#learn_container").html() +
                        content_all.replace('##content_questions##', question)
                            .replace('##required##',answered)
                            .replace('##ordem##',item.order)
                    );
                    $("#learn_container").html($("#learn_container").html() +
                        "<br>"
                    );
                    $(".content-correction").html($(".content-correction").html() +
                        content_all.replace('##content_questions##', question_correct)
                            .replace('##required##',answered)
                            .replace('##ordem##',item.order)
                    );
                    $(".content-correction").html($(".content-correction").html() +
                        "<br>"
                    );
                    var percent_progress = (100*conta_respondidas)/total_question;
                    $(".progress-quiz").css("width", percent_progress+"%").html(percent_progress+"%");

                }


            });
            $("#learn_container").html($("#learn_container").html() +
                '<input type="hidden" class="total_question" value="'+total_question+'"><input type="hidden" class="total_respondidas" value="'+conta_respondidas+'">'
            );
            checkResult($('.details').data('res'));
            $("body").tooltip({
                selector: '[data-toggle="tooltip"]'
            });

        }
    });

});

function monthName(pMonth) {
    var fn_result = "";
    switch(parseInt(pMonth)) {
        case 1: fn_result = "Janeiro"; break;
        case 2: fn_result = "Fevereiro"; break;
        case 3: fn_result = "Março"; break;
        case 4: fn_result = "Abril"; break;
        case 5: fn_result = "Maio"; break;
        case 6: fn_result = "Junho"; break;
        case 7: fn_result = "Julho"; break;
        case 8: fn_result = "Agosto"; break;
        case 9: fn_result = "Setembro"; break;
        case 10: fn_result = "Outubro"; break;
        case 11: fn_result = "Novembro"; break;
        case 12: fn_result = "Dezembro"; break;
    }
    return fn_result;
}
function checkResult(res) {
    if (res == 'Não entregue' || res == null) {
        $('.sep-quiz span.errou-spn').html('');
        $('.sep-quiz span.acertou-spn').html('');
        $('.answer i').removeClass('fa-check-circle');
        $('.answer i').removeClass('fa-times-circle');
        $('.sep-quiz span').removeClass('errou-spn');
        $('.sep-quiz span').removeClass('acertou-spn');
        $('.answer').removeClass('correct');
        $('.answer').removeClass('missed');
    }
    if (res == 'Entregue') {
        $('.sep-quiz span.errou-spn').html('');
        $('.sep-quiz span.acertou-spn').html('');
        $('.answer i').removeClass('fa-check-circle');
        $('.answer i').removeClass('fa-times-circle');
        $('.sep-quiz span').removeClass('errou-spn');
        $('.sep-quiz span').removeClass('acertou-spn');
        $('.answer').removeClass('correct');
        $('.answer').removeClass('missed');
        $('.btn-finished').hide();
        $('.responde').hide();
        $('.answer input[type="radio"]').attr('disabled',"disabled");
    }
}
function quiz_count_down($finish) {
    var $timer = $('.count-timer'),
        finishin = $finish;
    if (finishin != null) {
        $timer.countdown(finishin, function (event) {

            if (event.offset.days == 0) {

                $(this).html(event.strftime('%H:%M:%S'));

                if (event.offset.hours < 1 && event.offset.minutes < 10) {
                    $timer.addClass('timer-danger');

                    if (event.offset.minutes < 5) {
                        $timer.addClass('timer-atention');
                    } else if (event.offset.minutes <= 10 && event.offset.seconds == 0) {
                        $timer.addClass('timer-atention');
                    } else {
                        $timer.removeClass('timer-atention');
                    }

                } else if (event.offset.hours < 1) {
                    $timer.addClass('timer-warning');
                }
            } else {
                $(this).html(event.strftime('%D dias %H:%M:%S'));
            }


        }).on('finish.countdown', function () {
            if( window.location.hash.indexOf('_loaded') == -1) {
                window.location = window.location + '#_loaded';
                window.location.reload();
            }
        });
    }
}
