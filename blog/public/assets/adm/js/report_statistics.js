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
    var data = JSON.stringify($("#filter").serializeArray());
    var val_select_statistics = $('.select-statistics').val();
    var var_graph = $('.select-graph').val();
    var acumulado = $('.acumulados').is(':checked');
    data = JSON.parse(data);
    if (acumulado == true) {
        data.push({"name": "acumulado", "value": "true"});
    }
    data.push({"name": "chart-period", "value": var_graph});
    data = JSON.stringify(data);
    switch_main_table(data,'column',val_select_statistics);

    $('#search').click(function () {
        $(".btn-group-clear-filter").show();
        var val_select_statistics = $('.select-statistics').val();
        var data = JSON.stringify($("#filter").serializeArray());
        var acumulado = $('.acumulados').is(':checked');
        var var_graph = $('.select-graph').val();
        data = JSON.parse(data);
        if (acumulado == true) {
            data.push({"name": "acumulado", "value": "true"});
        }
        data.push({"name": "chart-period", "value": var_graph});
        data = JSON.stringify(data);

        switch_main_table(data,'column',val_select_statistics);

    });

    $(document.body).on('click','.paginate_button',function(e){
        e.preventDefault();
        var offset = $(this).data('offset');
        var val_select_statistics = $('.select-statistics').val();
        var val_pag = $(this).attr('data-page');
        $(".load-table").toggleClass('hide');
        var data = JSON.stringify($("#filter").serializeArray());
        switch(val_select_statistics) {
            case 'Reactions':
                chart_table_reactions(data,offset,val_pag);
                break;
            case 'Comentários':
                chart_table_comments(data,offset,val_pag);
                break;
            case 'Visualizações':
                chart_table_visualizacoes(data,offset,val_pag);
                break;
            case 'Visualizações únicas - qtde':
                chart_table_visu_unicas(data,offset,val_pag);
                break;
            case 'Visualizações únicas - %':
                chart_table_visu_percent(data,offset,val_pag);
                break;
            case 'Relevância':
                chart_table_relevancia(data,offset,val_pag);
                break;
            case 'Feedbacks':
                chart_table_feed(data,offset,val_pag);
                break;
        }
        $(".load-table").toggleClass('hide');
    });

    $(".status").chosen().change(function () {
        var val_select_statistics = $('.select-statistics').val();
        $(".load-table").toggleClass('hide');
        var data = JSON.stringify($("#filter").serializeArray());
        switch(val_select_statistics) {
            case 'Reactions':
                chart_table_reactions(data,null,1);
                break;
            case 'Comentários':
                chart_table_comments(data,null,1);
                break;
            case 'Visualizações':
                chart_table_visualizacoes(data,null,1);
                break;
            case 'Visualizações únicas - qtde':
                chart_table_visu_unicas(data,null,1);
                break;
            case 'Visualizações únicas - %':
                chart_table_visu_percent(data,null,1);
                break;
            case 'Relevância':
                chart_table_relevancia(data,null,1);
                break;
            case 'Feedbacks':
                chart_table_feed(data,null,1);
                break;
        }
        $(".load-table").toggleClass('hide');
    });

    $(".select-statistics").chosen().change(function () {
        var val_select_statistics = $(this).val();
        var val_graph = $(".select-graph").val();
        $(".load-table").toggleClass('hide');
        var data = JSON.stringify($("#filter").serializeArray());
        var acumulado = $('.acumulados').is(':checked');
        data = JSON.parse(data);
        if (acumulado == true) {
            data.push({"name": "acumulado", "value": "true"});
        }
        data.push({"name": "chart-period", "value": val_graph});
        data = JSON.stringify(data);
        var valor = $('.chart.active').val();
        verify_graph(valor, data,val_select_statistics);

        $(".load-table").toggleClass('hide');
    });

    $(".select-graph").chosen().change(function() {
        var val_select_statistics = $(".select-statistics").val();
        var val_graph = $(this).val();
        $(".load-table").toggleClass('hide');
        var data = JSON.stringify($("#filter").serializeArray());
        var acumulado = $('.acumulados').is(':checked');
        data = JSON.parse(data);
        if (acumulado == true) {
            data.push({"name": "acumulado", "value": "true"});
        }
        data.push({"name": "chart-period", "value": val_graph});
        data = JSON.stringify(data);
        var valor = $('.chart.active').val();
        verify_graph(valor, data,val_select_statistics);

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
        var val_select_statistics = $('.select-statistics').val();
        var val_graph = $('.select-graph').val();
        var valor = $(this).val();
        var data = JSON.stringify($("#filter").serializeArray());
        var acumulado = $('.acumulados').is(':checked');
        data = JSON.parse(data);
        if (acumulado == true) {
            data.push({"name": "acumulado", "value": "true"});
        }
        data.push({"name": "chart-period", "value": val_graph});
        data = JSON.stringify(data);
        $('.chart').removeClass('active');
        $(this).toggleClass('active');
        if(valor == 'table'){
            $('.chart-statistic').addClass('hide');
            $('.table-statistic').removeClass('hide');
        } else if(valor == 'area'){
            switch_main(data,valor,val_select_statistics);
            $('.chart-statistic').removeClass('hide');
            $('.table-statistic').addClass('hide');
        } else if(valor == 'column'){
            switch_main(data, valor, val_select_statistics);
            $('.chart-statistic').removeClass('hide');
            $('.table-statistic').addClass('hide');
        }
    });

    $(".close-filter").show();
    $(".btn-group-clear-filter").hide();

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


function verify_graph(valor, data,val_select_statistics) {
    if(valor == 'table'){
        switch_main_table(data, valor, val_select_statistics);
        $('.chart-statistic').addClass('hide');
        $('.table-statistic').removeClass('hide');
    } else if(valor == 'area'){
        switch_main_table(data,valor,val_select_statistics);
        $('.chart-statistic').removeClass('hide');
        $('.table-statistic').addClass('hide');
    } else if(valor == 'column'){
        switch_main_table(data, valor, val_select_statistics);
        $('.chart-statistic').removeClass('hide');
        $('.table-statistic').addClass('hide');
    }
}

function switch_main_table(data,tipo,statistics) {

    switch(statistics) {
        case 'Reactions':
            chart_main_reactions(data, tipo);
            chart_table_reactions(data,null,1);
            break;
        case 'Comentários':
            chart_main_comments(data, tipo);
            chart_table_comments(data,null,1);
            break;
        case 'Visualizações':
            chart_main_visualizacoes(data, tipo);
            chart_table_visualizacoes(data,null,1);
            break;
        case 'Relevância':
            chart_main_relevancia(data, tipo);
            chart_table_relevancia(data,null,1);
            break;
        case 'Feedbacks':
            chart_main_feed(data, tipo);
            chart_table_feed(data,null,1);
            break;
        case 'Visualizações únicas - qtde':
            chart_main_visu_unicas(data, tipo);
            chart_table_visu_unicas(data);
            break;
        case 'Visualizações únicas - %':
            chart_main_visu_percent(data, tipo);
            chart_table_visu_percent(data,null,1);
            break;
    }
}

function switch_table(data,statistics) {
    switch(statistics) {
        case 'Reactions':
            var off = $('.paginate_button.active').attr('data-offset');
            var pag = $('.paginate_button.active').attr('data-page');
            chart_table_reactions(data,off,pag);
            break;
        case 'Comentários':
            var off = $('.paginate_button.active').attr('data-offset');
            var pag = $('.paginate_button.active').attr('data-page');
            chart_table_comments(data,off,pag);
            break;
        case 'Visualizações':
            var off = $('.paginate_button.active').attr('data-offset');
            var pag = $('.paginate_button.active').attr('data-page');
            chart_table_visualizacoes(data,off,pag);
            break;
        case 'Relevância':
            var off = $('.paginate_button.active').attr('data-offset');
            var pag = $('.paginate_button.active').attr('data-page');
            chart_table_relevancia(data,off,pag);
            break;
        case 'Feedbacks':
            var off = $('.paginate_button.active').attr('data-offset');
            var pag = $('.paginate_button.active').attr('data-page');
            chart_table_feed(data,off,pag);
            break;
        case 'Visualizações únicas - qtde':
            var off = $('.paginate_button.active').attr('data-offset');
            var pag = $('.paginate_button.active').attr('data-page');
            chart_table_visu_unicas(data,off,pag);
            break;
        case 'Visualizações únicas - %':
            var off = $('.paginate_button.active').attr('data-offset');
            var pag = $('.paginate_button.active').attr('data-page');
            chart_table_visu_percent(data,off,pag);
            break;
    }
}

function switch_main(data,tipo,select_statistics) {
    switch(select_statistics) {
        case 'Reactions':
            chart_main_reactions(data,tipo);
            break;
        case 'Comentários':
            chart_main_comments(data,tipo);
            break;
        case 'Visualizações':
            chart_main_visualizacoes(data, tipo);
            break;
        case 'Relevância':
            chart_main_relevancia(data,tipo);
            break;
        case 'Feedbacks':
            chart_main_feed(data, tipo);
            break;
        case 'Visualizações únicas - qtde':
            chart_main_visu_unicas(data, tipo);
            break;
        case 'Visualizações únicas - %':
            chart_main_visu_percent(data,tipo);
            break;
        case null:
            chart_main_reactions(data,tipo);
            break;
    }
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
function get_table_tipo_statiscs(id, statistics) {
    switch (statistics) {
        case 'Reactions':
            settableuserReact(id);
            break;
        case 'Comentários':
            settableuser(id);
            break;
        case 'Visualizações':
            settableuserVisu(id);
            break;
        case 'Relevância':
            settableuserRel(id);
            break;
        case 'Feedbacks':
            settableuserFeed(id);
            break;
    }

}
function settableuser(id) {
    $(".user_table_row").remove();
    $('.glyphicon-spin').toggleClass('hide');
    $('.tipo-th-name').html('Comentários');
    $('input.tipo-statistics').val('comments');
    $.ajax({
        type: 'POST',
        url: './adm/report/user',
        data: {type: 'json', user_id: id,post:$("#post").val(), end: $("#date-end").val(), start:$("#date-start").val(), word:$("#word").val(), order:$("#user-comments").attr('order'), order_by:$("#user-comments").attr('order_by'), statistic:'comments'},
        success: function (data) {
            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#user-comments').attr("value",id);
                $('#table-user').append('<tr class="user_table_row"><td>' +
                    convertDateTime(data[i].datetime)+ '</td><td>' + data[i].title + '</td><td style="word-break: break-all;">'+
                    data[i].text +'</td><td><div class="btn-group">'+
                    '<button class="btn-action-form btn btn-sm btn-success" type="button" onclick="window.location=\'./feed/'+ data[i].post_id+'/'+escape(data[i].title)+'#'+ data[i].id+'\'">'+
                    '<i class="fa fa-eye"></i></button>'+
                    '</td></td></tr>');
            }
            $('.glyphicon-spin').toggleClass('hide');

        }
    });
}
function settableuserReact(id) {
    $(".user_table_row").remove();
    $('.glyphicon-spin').toggleClass('hide');
    $('.tipo-th-name').html('Reactions');
    $('input.tipo-statistics').val('reactions');
    $.ajax({
        type: 'POST',
        url: './adm/report/user',
        data: {type: 'json', user_id: id,post:$("#post").val(), end: $("#date-end").val(), start:$("#date-start").val(), word:$("#word").val(), order:$("#user-comments").attr('order'), order_by:$("#user-comments").attr('order_by'),statistic:'reactions'},
        success: function (data) {

            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#user-comments').attr("value",id);
                $('#table-user').append('<tr class="user_table_row"><td>' +
                    convertDateTime(data[i].datetime)+ '</td><td>' + data[i].title + '</td><td style="word-break: break-all;"><img src="'+
                    data[i].react_img +'" style="width:6%"></td><td><div class="btn-group">'+
                    '<button class="btn-action-form btn btn-sm btn-success" type="button" onclick="window.location=\'./feed/'+ data[i].post_id+'/'+escape(data[i].title)+'\'">'+
                    '<i class="fa fa-eye"></i></button>'+
                    '</td></td></tr>');
            }
            $('.glyphicon-spin').toggleClass('hide');

        }
    });
}

function settableuserVisu(id) {
    $(".user_table_row").remove();
    $('.glyphicon-spin').toggleClass('hide');
    $('.tipo-th-name').html('Visualizações');
    $('input.tipo-statistics').val('visualizações');
    $.ajax({
        type: 'POST',
        url: './adm/report/user',
        data: {type: 'json', user_id: id,post:$("#post").val(), end: $("#date-end").val(), start:$("#date-start").val(), word:$("#word").val(), order:$("#user-comments").attr('order'), order_by:$("#user-comments").attr('order_by'),statistic:'visualizacoes'},
        success: function (data) {

            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#user-comments').attr("value",id);
                $('#table-user').append('<tr class="user_table_row"><td>' +
                    convertDateTime(data[i].datetime)+ '</td><td>' + data[i].title + '</td><td style="word-break: break-all;">'+
                    data[i].total +'</td><td><div class="btn-group">'+
                    '<button class="btn-action-form btn btn-sm btn-success" type="button" onclick="window.location=\'./feed/'+ data[i].post_id+'/'+escape(data[i].title)+'\'">'+
                    '<i class="fa fa-eye"></i></button>'+
                    '</td></td></tr>');
            }
            $('.glyphicon-spin').toggleClass('hide');

        }
    });
}

function settableuserVisuUnicas(id) {
    $(".user_table_row").remove();
    $('.glyphicon-spin').toggleClass('hide');
    $('.tipo-th-name').html('Visualizações');
    $('input.tipo-statistics').val('visualizações');
    $.ajax({
        type: 'POST',
        url: './adm/report/user',
        data: {type: 'json', user_id: id,post:$("#post").val(), end: $("#date-end").val(), start:$("#date-start").val(), word:$("#word").val(), order:$("#user-comments").attr('order'), order_by:$("#user-comments").attr('order_by'),statistic:'visualizacoes_unicas'},
        success: function (data) {

            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#user-comments').attr("value",id);
                $('#table-user').append('<tr class="user_table_row"><td>' +
                    convertDateTime(data[i].datetime)+ '</td><td>' + data[i].title + '</td><td style="word-break: break-all;">'+
                    data[i].total +'</td><td><div class="btn-group">'+
                    '<button class="btn-action-form btn btn-sm btn-success" type="button" onclick="window.location=\'./feed/'+ data[i].post_id+'/'+escape(data[i].title)+'\'">'+
                    '<i class="fa fa-eye"></i></button>'+
                    '</td></td></tr>');
            }
            $('.glyphicon-spin').toggleClass('hide');
            $('.spin').addClass('hide');
        }
    });
}

function settableuserVisuPercent(id) {
    $(".user_table_row").remove();
    $('.glyphicon-spin').toggleClass('hide');
    $('.tipo-th-name').html('Visualizações únicas - %');
    $('input.tipo-statistics').val('visualizações únicas - %');
    $.ajax({
        type: 'POST',
        url: './adm/report/user',
        data: {type: 'json', user_id: id,post:$("#post").val(), end: $("#date-end").val(), start:$("#date-start").val(), word:$("#word").val(), order:$("#user-comments").attr('order'), order_by:$("#user-comments").attr('order_by'),statistic:'visualizacoes_percent'},
        success: function (data) {

            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#user-comments').attr("value",id);
                $('#table-user').append('<tr class="user_table_row"><td>' +
                    convertDateTime(data[i].datetime)+ '</td><td>' + data[i].title + '</td><td style="word-break: break-all;">'+
                    data[i].total +'</td><td><div class="btn-group">'+
                    '<button class="btn-action-form btn btn-sm btn-success" type="button" onclick="window.location=\'./feed/'+ data[i].post_id+'/'+escape(data[i].title)+'\'">'+
                    '<i class="fa fa-eye"></i></button>'+
                    '</td></td></tr>');
            }
            $('.glyphicon-spin').toggleClass('hide');
            $('.spin').addClass('hide');
        }
    });
}

function settableuserRel(id) {
    $(".user_table_row").remove();
    $('.glyphicon-spin').toggleClass('hide');
    $('.tipo-th-name').html('Relevâncias');
    $('input.tipo-statistics').val('Relevâncias');
    $.ajax({
        type: 'POST',
        url: './adm/report/user',
        data: {type: 'json', user_id: id,post:$("#post").val(), end: $("#date-end").val(), start:$("#date-start").val(), word:$("#word").val(), order:$("#user-comments").attr('order'), order_by:$("#user-comments").attr('order_by'),statistic:'relevancias'},
        success: function (data) {

            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#user-comments').attr("value",id);
                $('#table-user').append('<tr class="user_table_row"><td>' +
                    convertDateTime(data[i].datetime)+ '</td><td>' + data[i].title + '</td><td style="word-break: break-all;">'+
                    data[i].total +'</td><td><div class="btn-group">'+
                    '<button class="btn-action-form btn btn-sm btn-success" type="button" onclick="window.location=\'./feed/'+ data[i].post_id+'/'+escape(data[i].title)+'\'">'+
                    '<i class="fa fa-eye"></i></button>'+
                    '</td></td></tr>');
            }
            $('.glyphicon-spin').toggleClass('hide');

        }
    });
}

function settableuserFeed(id) {
    $(".user_table_row").remove();
    $('.glyphicon-spin').toggleClass('hide');
    $('.tipo-th-name').html('Feedbacks');
    $('input.tipo-statistics').val('Feedbacks');
    $.ajax({
        type: 'POST',
        url: './adm/report/user',
        data: {type: 'json', user_id: id,post:$("#post").val(), end: $("#date-end").val(), start:$("#date-start").val(), word:$("#word").val(), order:$("#user-comments").attr('order'), order_by:$("#user-comments").attr('order_by'),statistic:'feedbacks'},
        success: function (data) {

            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#user-comments').attr("value",id);
                $('#table-user').append('<tr class="user_table_row"><td>' +
                    convertDateTime(data[i].datetime)+ '</td><td>' + data[i].title + '</td><td style="word-break: break-all;">'+
                    data[i].total +'</td><td><div class="btn-group">'+
                    '<button class="btn-action-form btn btn-sm btn-success" type="button" onclick="window.location=\'./feed/'+ data[i].post_id+'/'+escape(data[i].title)+'\'">'+
                    '<i class="fa fa-eye"></i></button>'+
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
    var val_select_statistics = $('.select-statistics').val();
    get_table_tipo_statiscs($('#user-comments').attr('value'), val_select_statistics);
});

$(".acumulados").click(function () {
    var val_select_statistics = $('.select-statistics').val();
    var val_graph = $('.select-graph').val();
    var data = JSON.stringify($("#filter").serializeArray());
    var acumulado = $('.acumulados').is(':checked');

    data = JSON.parse(data);
    if (acumulado == true) {
        data.push({"name": "acumulado", "value": "true"});
    }
    data.push({"name": "chart-period", "value": val_graph});
    data = JSON.stringify(data);
    var valor = $('.chart.active').val();
    verify_graph(valor, data,val_select_statistics);
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
    var val_select_statistics = $('.select-statistics').val();
    get_table_tipo_statiscs($('#user-comments').attr('value'), val_select_statistics);
});

$(document.body).on('click', '.order-post-table' ,function(event){
    var data = JSON.stringify($("#filter").serializeArray());
    data = JSON.parse(data);
    var val_select_statistics = $('.select-statistics').val();

    data.push({"name": "order", "value": $(this).attr('data-order')});
    data.push({"name": "order_by", "value": $(this).attr('data-orderby')});
    data = JSON.stringify(data);

    switch_table(data,val_select_statistics);

    $data_order = $(this).attr('id');

    if( $('#'+$data_order).attr('data-order') == 'DESC'){
        $('#'+$data_order).attr('data-order', 'ASC');
        $('#'+$data_order).removeClass('glyphicon-sort-by-attributes-alt');
        $('#'+$data_order).addClass('glyphicon-sort-by-attributes');
    } else {
        $('#'+$data_order).attr('data-order', 'DESC');
        $('#'+$data_order).removeClass('glyphicon-sort-by-attributes');
        $('#'+$data_order).addClass('glyphicon-sort-by-attributes-alt');

    }
});

function convertDate(date,tipo) {
        var d = new Date(date);
        var novo = d.setDate(d.getDate() + 1);
        var n = new Date(novo),
        month = '' + (n.getMonth() + 1),
        day = '' + n.getDate(),
        year = n.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;
    if (tipo == 4) {
        return date;
    } else if (tipo == 3) {
        return [month, year].join('/');
    } else {
        return [day, month, year].join('/');
    }

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
function chart_main_comments(filter, type) {
    $(".status").html('<option value="category">Campanha</option><option value="group">Grupo</option><option value="post">Post</option><option value="user">Usuário</option>');
    $(".status").trigger("chosen:updated");
    $('.tipo-table').html('Comentários');
    var select_tipo = $(".select-graph").val();
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
        beforeSend: function () {
            $('.comp-charge').show();
        },
        success: function (data) {
            $('.table-statistic-rows').remove();
            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#table-statistic').append('<tr class="table-statistic-rows"><td>' + convertDate(data[i][0],select_tipo) + '</td><td>' + data[i][1] + '</td></tr>');
            }

            if (select_tipo == 4) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_year(data, 'Quantidade de Comentários', 'Comentários', type);
            } else if(select_tipo == 3) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_month(data, 'Quantidade de Comentários', 'Comentários', type);
            } else if (select_tipo == 2) {
                    for(i=0;i < data.length;i++) {
                        data[i][0] = Date.parse(data[i][0]);
                    }
                create_chart(data, 'Quantidade de Comentários', 'Comentários', type,'%A, %b %e');
            }else {
                create_chart(data, 'Quantidade de Comentários', 'Comentários', type,'%A, %b %e, %H:%M');
            }

            $('.comp-charge').hide();
        }
    });
}

function chart_table_comments(filter,offset,val_page) {
    if (offset == null) {
        var offset = '';
    }
    var status = $(".status option:selected").text();
    //para ordenação nas tabelas
    switch (status) {
        case 'Campanha':
            $('#order01').attr('data-orderby','categorypost.name');
            $('#order02').attr('data-orderby','comment_total');
            break;
        case 'Grupo':
            $('#order01').attr('data-orderby','group.name');
            $('#order02').attr('data-orderby','comment_total');
            break;
        case 'Post':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','comment_total');
            break;
        case 'Usuário':
            $('#order01').attr('data-orderby','name');
            $('#order02').attr('data-orderby','comment_total');
            break;
    }
    $('#type-title').html(status);
    $('#type-tipo').html('Comentários totais');
    $('.glyphicon').removeClass('glyphicon-sort-by-attributes').removeClass('glyphicon-sort-by-attributes-alt');
    $(".chart_table_row").remove();
    var type = $("#table-type").val();
    $.ajax({
        type: 'POST',
        url: './adm/report/comments_for_tables?type=' + type+'&offset='+ offset+'&page='+val_page,
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge-table').show();
        },
        success: function (data) {
            var total = 0
            for (var i = 0; data['res'].length > i; i++) {
                total = parseInt(data['res'][i].comment_total) + total;
            }
            for (var i = 0; data['res'].length > i; i++) {
                var participant = ((data['res'][i].comment_total / total) * 100);
                var percent = Number((participant).toFixed(2))
                //Adicionando registros retornados na tabela
                if ($(".status option:selected").text() == "Usuário") {
                    $("#leader_cell").removeClass('hide');
                    var leader = data['res'][i].leader == null?'':data['res'][i].leader;
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>'+ leader +'</td>'+
                        '</td><td><a onclick="user_info(' + data["res"][i].id + ')">' + data['res'][i].name +
                        '</a></td><td><a class="table-user" data-toggle="modal" data-target="#modal-user-comments" onclick="settableuser('+data['res'][i].id+'),setmodalname(\'' + data['res'][i].name + '\', \''+data['res'][i].id+'\'),reset_order()">' +
                        data['res'][i].comment_total +
                        '</a></td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                } else {

                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data['res'][i].name === null ? "Sem Campanha" : data['res'][i].name) +
                        '</td><td>' + data['res'][i].comment_total +
                        '</td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                }
            }

            $('.paginacao').html(data['paginacao']);

            if (val_page != null) {
                $(".paginacao li").removeClass("active")
                $(".paginacao li").each(function(){
                    var page = $(this).attr('data-page');
                    if (page == val_page) {
                        $(this, '.numbers-pag').addClass('active');
                    }
                });
            }
            $('.glyphicon-spin').toggleClass('hide');

            /**
             * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
             * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
             */
            create_sparkline();
            $('.comp-charge-table').hide();

        }
    });
}
function highcharts_opt() {

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
}
/* Gráfico de Visualizações %*/
function chart_main_visu_percent(filter, type) {
    $(".status").html('<option value="post">Post</option><option value="category">Campanha</option>');
    $(".status").trigger("chosen:updated");
    var select_tipo = $('.select-graph').val();
    $('.tipo-table').html('Visualizações únicas - %');

    highcharts_opt();

    $.ajax({
        type: 'POST',
        url: './adm/report/visualizacoes_json/visualizacoes_percent',
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge').show();
        },
        success: function (data) {
            $('.table-statistic-rows').remove();
            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#table-statistic').append('<tr class="table-statistic-rows"><td>' + convertDate(data[i][0],select_tipo) + '</td><td>' + data[i][1] + '%</td></tr>');
            }
            // create the chart
            if (select_tipo == 4) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_percent_year(data, 'Quantidade de Visualizações Únicas - %', 'Visualizações Únicas - %', type);
            } else if(select_tipo == 3) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_percent_month(data, 'Quantidade de Visualizações Únicas - %', 'Visualizações Únicas - %', type);
            } else if (select_tipo == 2) {
                    for(i=0;i < data.length;i++) {
                        data[i][0] = Date.parse(data[i][0]);
                    }
                create_chart_percent(data, 'Quantidade de Visualizações Únicas - %', 'Visualizações Únicas - %', type,'%A, %b %e');
            } else {
                create_chart_percent(data, 'Quantidade de Visualizações Únicas - %', 'Visualizações Únicas - %', type,'%A, %b %e, %H:%M');
            }

            $('.comp-charge').hide();
        }
    });
}
function chart_table_visu_percent(filter,offset,val_page) {
    if (offset == null) {
        var offset = '';
    }
    //para ordenação nas tabelas
    var status = $(".status option:selected").text();
    switch (status) {
        case 'Visualizações':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','cont');
            break;
        case 'Campanha':
            $('#order01').attr('data-orderby','CP.name');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Grupo':
            $('#order01').attr('data-orderby','group.name');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Post':
            $('#order01').attr('data-orderby','Ptl.name');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Usuário':
            $('#order01').attr('data-orderby','name');
            $('#order02').attr('data-orderby','postview_total');
            break;
    }
    $('#type-title').html(status);
    $('#type-tipo').html('Visualizações únicas - %');
    $(".chart_table_row").remove();
    $('.glyphicon').removeClass('glyphicon-sort-by-attributes').removeClass('glyphicon-sort-by-attributes-alt');
    var val_status = $(".status option:selected").text();
    var type = $("#table-type").val();
    $.ajax({
        type: 'POST',
        url: './adm/report/visu_percent_for_tables?type=' + type+'&offset='+ offset+'&page='+val_page,
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge-table').show();
        },
        success: function (data) {
            var total = 0
            for (var i = 0; data['res'].length > i; i++) {
                total = parseInt(data['res'][i].postview_total) + total;
            }
            for (var i = 0; data['res'].length > i; i++) {
                if (data["res"][i].postview_total == null)
                {
                    data["res"][i].postview_total = 0;
                }
                var conta = parseFloat(data["res"][i].postview_total);
                var p = parseFloat(conta.toFixed(2));
                //Adicionando registros retornados na tabela
                if (val_status == "Post") {
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Nenhum nome cadastrado" : data["res"][i].name) +
                        '</td><td>' + p +
                        '%</td><td class="union1">' + p +
                        '%</td><td class="union2" data-sparkline="' + p + ';"></td></tr>');
                } else {
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Sem Campanha" : data["res"][i].name) +
                        '</td><td>' + p +
                        '%</td><td class="union1">' + p +
                        '%</td><td class="union2" data-sparkline="' + p + ';"></td></tr>');
                }
            }
            $('.paginacao').html(data['paginacao']);

            if (val_page != null) {
                $(".paginacao li").removeClass("active")
                $(".paginacao li").each(function(){
                    var page = $(this).attr('data-page');
                    if (page == val_page) {
                       $(this, '.numbers-pag').addClass('active');
                    }
                });
            }
            /**
             * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
             * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
             */
            create_sparkline();
            $('.comp-charge-table').hide();
        }
    });
}
/* Gráfico de Visualizações Únicas */
function chart_main_visu_unicas(filter, type) {
    $(".status").html('<option value="category">Campanha</option><option value="group">Grupo</option><option value="post">Post</option><option value="user">Usuário</option>');
    $(".status").trigger("chosen:updated");
    $('.tipo-table').html('Visualizações Únicas');
    var select_tipo = $('.select-graph').val();

    highcharts_opt();

    $.ajax({
        type: 'POST',
        url: './adm/report/visualizacoes_json/visualizacoes_unicas',
        data: filter,
        dataType: 'json',
        beforeSend: function (data) {
            $('.comp-charge').show();
        },
        success: function (data) {
            $('.table-statistic-rows').remove();
            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#table-statistic').append('<tr class="table-statistic-rows"><td>' + convertDate(data[i][0],select_tipo) + '</td><td>' + data[i][1] + '</td></tr>');
            }
            // create the chart
            if (select_tipo == 4) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_year(data, 'Quantidade de Visualizações Únicas', 'Visualizações Únicas', type);
            } else if(select_tipo == 3) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_month(data, 'Quantidade de Visualizações Únicas', 'Visualizações Únicas', type);
            } else if (select_tipo == 2) {
                    for(i=0;i < data.length;i++) {
                        data[i][0] = Date.parse(data[i][0]);
                    }
                create_chart(data, 'Quantidade de Visualizações Únicas', 'Visualizações Únicas', type,'%A, %b %e');
            } else {
                create_chart(data, 'Quantidade de Visualizações Únicas', 'Visualizações Únicas', type,'%A, %b %e, %H:%M');
            }

            $('.comp-charge').hide();
        }
    });
}
function chart_table_visu_unicas(filter,offset,val_page) {
    if (offset == null) {
        var offset = '';
    }
    //para ordenação nas tabelas
    var status = $(".status option:selected").text();
    switch (status) {
        case 'Visualizações':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','cont');
            break;
        case 'Campanha':
            $('#order01').attr('data-orderby','categorypost.name');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Grupo':
            $('#order01').attr('data-orderby','group.name');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Post':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Usuário':
            $('#order01').attr('data-orderby','name');
            $('#order02').attr('data-orderby','postview_total');
            break;
    }
    $('#type-title').html(status);
    $('#type-tipo').html('Visualizações únicas');
    $(".chart_table_row").remove();
    $('.glyphicon').removeClass('glyphicon-sort-by-attributes').removeClass('glyphicon-sort-by-attributes-alt');
    var val_status = $(".status option:selected").text();
    var type = $("#table-type").val();
    $.ajax({
        type: 'POST',
        url: './adm/report/visu_unicas_for_tables?type=' + type+'&offset='+ offset+'&page='+val_page,
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge-table').show();
        },
        success: function (data) {
            var total = 0
            for (var i = 0; data["res"].length > i; i++) {
                total = parseInt(data["res"][i].postview_total) + total;
            }
            for (var i = 0; data["res"].length > i; i++) {
                var participant = ((data["res"][i].postview_total / total) * 100);
                var percent = Number((participant).toFixed(2))
                //Adicionando registros retornados na tabela
                if (val_status == "Usuário") {
                    $("#leader_cell").removeClass('hide');
                    var leader = data["res"][i].leader == null?'':data["res"][i].leader;
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>'+ leader +'</td>'+
                        '</td><td><a onclick="user_info(' + data["res"][i].id + ')">' + data["res"][i].name +
                        '</a></td><td><a class="table-user" data-toggle="modal" data-target="#modal-user-comments" onclick="settableuserVisuUnicas('+data["res"][i].id+'),setmodalname(\'' + data["res"][i].name + '\', \''+data["res"][i].id+'\'),reset_order()">' +
                        data["res"][i].postview_total +
                        '</a></td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                } else {
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Sem Campanha" : data["res"][i].name) +
                        '</td><td>' + data["res"][i].postview_total +
                        '</td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                }
            }

            $('.paginacao').html(data['paginacao']);

            if (val_page != null) {
                $(".paginacao li").removeClass("active")
                $(".paginacao li").each(function(){
                    var page = $(this).attr('data-page');
                    if (page == val_page) {
                        $(this, '.numbers-pag').addClass('active');
                    }
                });
            }


            /**
             * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
             * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
             */
            create_sparkline();
            $('.comp-charge-table').hide();
        }
    });
}
/* Gráfico de Visualizações */
function chart_main_visualizacoes(filter, type) {
    $(".status").html('<option value="category">Campanha</option><option value="group">Grupo</option><option value="post">Post</option><option value="user">Usuário</option>');
    $(".status").trigger("chosen:updated");
    $('.tipo-table').html('Visualizações');
    var select_tipo = $('.select-graph').val();
    highcharts_opt();
    $.ajax({
        type: 'POST',
        url: './adm/report/visualizacoes_json',
        data: filter,
        dataType: 'json',
        beforeSend: function (data) {
            $('.comp-charge').show();
        },
        success: function (data) {
            $('.table-statistic-rows').remove();
            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#table-statistic').append('<tr class="table-statistic-rows"><td>' + convertDate(data[i][0],select_tipo) + '</td><td>' + data[i][1] + '</td></tr>');
            }
            // create the chart
            if (select_tipo == 4) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_year(data, 'Quantidade de Visualizações', 'Visualizações', type);
            } else if(select_tipo == 3) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_month(data, 'Quantidade de Visualizações', 'Visualizações', type);
            } else if (select_tipo == 2) {
                    for(i=0;i < data.length;i++) {
                        data[i][0] = Date.parse(data[i][0]);
                    }
                create_chart(data, 'Quantidade de Visualizações', 'Visualizações', type,'%A, %b %e');
            } else {
                create_chart(data, 'Quantidade de Visualizações', 'Visualizações', type,'%A, %b %e, %H:%M');
            }

            $('.comp-charge').hide();
        }
    });
}

function chart_table_visualizacoes(filter,offset,val_page) {
    if (offset == null) {
        var offset = '';
    }
    //para ordenação nas tabelas
    var status = $(".status option:selected").text();
    switch (status) {
        case 'Visualizações':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','cont');
            break;
        case 'Campanha':
            $('#order01').attr('data-orderby','categorypost.name');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Grupo':
            $('#order01').attr('data-orderby','group.name');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Post':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','postview_total');
            break;
        case 'Usuário':
            $('#order01').attr('data-orderby','name');
            $('#order02').attr('data-orderby','postview_total');
            break;
    }
    $('#type-title').html(status);
    $('#type-tipo').html('Visualizações totais');
    $(".chart_table_row").remove();
    $('.glyphicon').removeClass('glyphicon-sort-by-attributes').removeClass('glyphicon-sort-by-attributes-alt');
    var val_status = $(".status option:selected").text();
    var type = $("#table-type").val();
    $.ajax({
        type: 'POST',
        url: './adm/report/visualizacoes_for_tables?type=' + type+'&offset='+ offset+'&page='+val_page,
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge-table').show();
        },
        success: function (data) {
            var total = 0
            for (var i = 0; data["res"].length > i; i++) {
                total = parseInt(data["res"][i].postview_total) + total;
            }
            for (var i = 0; data["res"].length > i; i++) {
                var participant = ((data["res"][i].postview_total / total) * 100);
                var percent = Number((participant).toFixed(2))
                //Adicionando registros retornados na tabela
                if (val_status == "Usuário") {
                    $("#leader_cell").removeClass('hide');
                    var leader = data["res"][i].leader == null?'':data["res"][i].leader;
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>'+ leader +'</td>'+
                        '</td><td><a onclick="user_info(' + data["res"][i].id + ')">' + data["res"][i].name +
                        '</a></td><td><a class="table-user" data-toggle="modal" data-target="#modal-user-comments" onclick="settableuserVisu('+data["res"][i].id+'),setmodalname(\'' + data["res"][i].name + '\', \''+data["res"][i].id+'\'),reset_order()">' +
                        data["res"][i].postview_total +
                        '</a></td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                } else if (val_status == 'Visualizações Únicas'){
                    $('#type-tipo').html('Visualizações Únicas');
                    $('#type-title').html('Post');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Sem Campanha" : data["res"][i].name) +
                        '</td><td>' + data["res"][i].cont +
                        '</td><td class="union1">' + data["res"][i].porcentagem +
                        '%</td><td class="union2" data-sparkline="' + data["res"][i].porcentagem + ';"></td></tr>');
                } else {
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Sem Campanha" : data["res"][i].name) +
                        '</td><td>' + data["res"][i].postview_total +
                        '</td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                }
            }
            $('.paginacao').html(data['paginacao']);

            if (val_page != null) {
                $(".paginacao li").removeClass("active")
                $(".paginacao li").each(function(){
                    var page = $(this).attr('data-page');
                    if (page == val_page) {
                        $(this, '.numbers-pag').addClass('active');
                    }
                });
            }

            /**
             * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
             * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
             */
            create_sparkline();
            $('.comp-charge-table').hide();
        }
    });
}

/* Gráfico de Feedbacks */
function chart_main_feed(filter, type) {

    $(".status").html('<option value="post">Post</option><option value="category">Campanha</option><option value="group">Grupo</option><option value="user">Usuário</option>');
    $(".status").trigger("chosen:updated");
    $('.tipo-table').html('Feedbacks');
    var select_tipo = $('.select-graph').val();

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
        url: './adm/report/feedback_json',
        data: filter,
        dataType: 'json',
        beforeSend: function (data) {
            $('.comp-charge').show();
        },
        success: function (data) {
            $('.table-statistic-rows').remove();
            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#table-statistic').append('<tr class="table-statistic-rows"><td>' + convertDate(data[i][0],select_tipo) + '</td><td>' + data[i][1] + '</td></tr>');
            }
            // create the chart
            if (select_tipo == 4) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_year(data, 'Quantidade de Feedback', 'Feedback', type);
            } else if(select_tipo == 3) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_month(data, 'Quantidade de Feedback', 'Feedback', type);
            } else if (select_tipo == 2) {
                    for(i=0;i < data.length;i++) {
                        data[i][0] = Date.parse(data[i][0]);
                    }
                create_chart(data, 'Quantidade de Feedback', 'Feedback', type,'%A, %b %e');
            } else {
                create_chart(data, 'Quantidade de Feedback', 'Feedback', type,'%A, %b %e, %H:%M');
            }
            $('.comp-charge').hide();

        }
    });
}

function chart_table_feed(filter,offset,val_page) {
    if (offset == null) {
        var offset = '';
    }
    //para ordenação nas tabelas
    var status = $(".status option:selected").text();
    switch (status) {
        case 'Campanha':
            $('#order01').attr('data-orderby','categorypost.name');
            $('#order02').attr('data-orderby','feed_total');
            break;
        case 'Grupo':
            $('#order01').attr('data-orderby','group.name');
            $('#order02').attr('data-orderby','feed_total');
            break;
        case 'Post':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','feed_total');
            break;
        case 'Usuário':
            $('#order01').attr('data-orderby','name');
            $('#order02').attr('data-orderby','feed_total');
            break;
    }
    $('#type-title').html(status);
    $('#type-tipo').html('Quantidade de Feedback');
    $(".chart_table_row").remove();
    $('.glyphicon').removeClass('glyphicon-sort-by-attributes').removeClass('glyphicon-sort-by-attributes-alt');
    var val_status = $(".status option:selected").text();
    var type = $("#table-type").val();
    $.ajax({
        type: 'POST',
        url: './adm/report/feedback_for_tables?type=' + type+'&offset='+ offset+'&page='+val_page,
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge-table').show();
        },
        success: function (data) {
            var total = 0
            for (var i = 0; data["res"].length > i; i++) {
                total = parseInt(data["res"][i].feed_total) + total;
            }
            for (var i = 0; data["res"].length > i; i++) {
                var participant = ((data["res"][i].feed_total / total) * 100);
                var percent = Number((participant).toFixed(2))
                //Adicionando registros retornados na tabela
                if (val_status == "Usuário") {
                    $("#leader_cell").removeClass('hide');
                    var leader = data["res"][i].leader == null?'':data["res"][i].leader;
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>'+ leader +'</td>'+
                        '</td><td><a onclick="user_info(' + data["res"][i].id + ')">' + data["res"][i].name +
                        '</a></td><td><a class="table-user" data-toggle="modal" data-target="#modal-user-comments" onclick="settableuserFeed('+data["res"][i].id+'),setmodalname(\'' + data["res"][i].name + '\', \''+data["res"][i].id+'\'),reset_order()">' +
                        data["res"][i].feed_total +
                        '</a></td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                } else if (val_status == 'Visualizações Únicas'){
                    $('#type-tipo').html('Visualizações Únicas');
                    $('#type-title').html('Post');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Sem Campanha" : data["res"][i].name) +
                        '</td><td>' + data["res"][i].cont +
                        '</td><td class="union1">' + data["res"][i].porcentagem +
                        '%</td><td class="union2" data-sparkline="' + data["res"][i].porcentagem + ';"></td></tr>');
                } else {
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Sem Campanha" : data["res"][i].name) +
                        '</td><td>' + data["res"][i].feed_total +
                        '</td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                }
            }

            $('.paginacao').html(data['paginacao']);

            if (val_page != null) {
                $(".paginacao li").removeClass("active")
                $(".paginacao li").each(function(){
                    var page = $(this).attr('data-page');
                    if (page == val_page) {
                        $(this, '.numbers-pag').addClass('active');
                    }
                });
            }

            /**
             * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
             * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
             */
            create_sparkline();
            $('.comp-charge-table').hide();
        }
    });
}

/* Gráfico de Relevância */
function chart_main_relevancia(filter, type) {

    $(".status").html('<option value="relevancias">Relevância</option><option value="category">Campanha</option><option value="group">Grupo</option><option value="post">Post</option><option value="user">Usuário</option>');
    $(".status").trigger("chosen:updated");
    var select_tipo = $('.select-graph').val();
    $('.tipo-table').html('Relevância');
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
        url: './adm/report/relevancias_json',
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge').show();
        },
        success: function (data) {
            $('.table-statistic-rows').remove();
            for (var i = 0; data.length > i; i++) {
                if (select_tipo == 4) {
                    //Adicionando registros retornados na tabela
                    $('#table-statistic').append('<tr class="table-statistic-rows"><td>' + convertDate(data[i][0],select_tipo) + '</td><td>' + data[i][1] + '</td></tr>');
                }

            }
            // create the chart
            // create the chart
            if (select_tipo == 4) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_year(data, 'Quantidade de Relevância', 'Relevância', type);
            } else if(select_tipo == 3) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_month(data, 'Quantidade de Relevância', 'Relevância', type);
            } else if (select_tipo == 2) {
                    for(i=0;i < data.length;i++) {
                        data[i][0] = Date.parse(data[i][0]);
                    }
                create_chart(data, 'Quantidade de Relevância', 'Relevância', type,'%A, %b %e');
            } else {
                create_chart(data, 'Quantidade de Relevância', 'Relevância', type,'%A, %b %e, %H:%M');
            }

            $('.comp-charge').hide();
        }
    });
}

function chart_table_relevancia(filter,offset,val_page) {
    if (offset == null) {
        var offset = '';
    }
    var status = $(".status option:selected").text();
    switch (status) {
        case 'Relevâncias':
            $('#order01').attr('data-orderby','estrelinhas');
            $('#order02').attr('data-orderby','relevancias_total');
            break;
        case 'Campanha':
            $('#order01').attr('data-orderby','categorypost.name');
            $('#order02').attr('data-orderby','relevancias_total');
            break;
        case 'Grupo':
            $('#order01').attr('data-orderby','group.name');
            $('#order02').attr('data-orderby','relevancias_total');
            break;
        case 'Post':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','relevancias_total');
            break;
        case 'Usuário':
            $('#order01').attr('data-orderby','name');
            $('#order02').attr('data-orderby','relevancias_total');
            break;
    }

    $('#type-title').html(status);
    $('#type-tipo').html('Quantidade de Avaliações');
    $('.glyphicon').removeClass('glyphicon-sort-by-attributes').removeClass('glyphicon-sort-by-attributes-alt');
    $(".chart_table_row").remove();
    var val_status = status;
    var type = $("#table-type").val();
    $.ajax({
        type: 'POST',
        url: './adm/report/relevancias_for_tables?type=' + type+'&offset='+ offset+'&page='+val_page,
        data: filter,
        dataType: 'json',
        beforeSend: function (){
            $('.comp-charge-table').show();
        },
        success: function (data) {
            var total = 0
            for (var i = 0; data.length > i; i++) {
                total = parseInt(data["res"][i].relevancias_total) + total;
            }

            for (var i = 0; data["res"].length > i; i++) {
                var participant = ((data["res"][i].relevancias_total / total) * 100);
                var porcentagem = Number((participant).toFixed(2));
                //Adicionando registros retornados na tabela
                if (val_status == "Usuário") {
                    var percent = (parseFloat(data["res"][i].media) * 100) / 5;
                    if (data["res"][i].media > 1 && data["res"][i].media <= 2) {
                        var estrela = "./assets/img/stars/2.jpg";
                    } else if (data["res"][i].media > 2 && data["res"][i].media <= 3) {
                        var estrela = "./assets/img/stars/3.jpg";
                    } else if (data["res"][i].media > 3 && data["res"][i].media <= 4) {
                        var estrela = "./assets/img/stars/4.jpg";
                    } else if (data["res"][i].media > 4 && data["res"][i].media <= 5) {
                        var estrela = "./assets/img/stars/5.jpg";
                    } else {
                        var estrela = "./assets/img/stars/1.jpg";
                    }
                    var percent_cem = 100 - percent.toFixed(2);
                    $("#type-part").html('Média das Avaliações');
                    $("#leader_cell").removeClass('hide');
                    var leader = data["res"][i].leader == null?'':data["res"][i].leader;
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>'+ leader +'</td>'+
                        '</td><td><a onclick="user_info(' + data["res"][i].id + ')">' + data["res"][i].name +
                        '</a></td><td><a class="table-user" data-toggle="modal" data-target="#modal-user-comments" onclick="settableuserRel('+data["res"][i].id+'),setmodalname(\'' + data["res"][i].name + '\', \''+data["res"][i].id+'\'),reset_order()">' +
                        data["res"][i].relevancias_total +
                        '</a></td><td><div class="percent-star" title="'+percent.toFixed(2)+'%" style="background: url('+ estrela +')">'+
                        '<div class="cobre-estrela" style="width:'+percent_cem+'%"></div></div></td></tr>');
                } else if (val_status == 'Relevância'){
                    var percent = (parseFloat(data["res"][i].media) * 100) / 5;

                    //var percent_cem = 100 - percent.toFixed(2);
                    $("#type-part").html('Média das Avaliações');
                    $('#type-title').html('Resultado da Avaliação');
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td><img src="./assets/img/stars/' + data["res"][i].estrelinhas +'.jpg" style="width: 20%;margin:0 auto" class="img-responsive">'+
                        '</td><td>' + data["res"][i].relevancias_total +
                        '</td><td><img src="./assets/img/stars/' + data["res"][i].estrelinhas +'.jpg" style="width: 38%;margin:0 auto" class="img-responsive"></td></tr>');
                } else {
                    var percent = (parseFloat(data["res"][i].media) * 100) / 5;
                    if (data["res"][i].media > 1 && data["res"][i].media <= 2) {
                        var estrela = "./assets/img/stars/2.jpg";
                    } else if (data["res"][i].media > 2 && data["res"][i].media <= 3) {
                        var estrela = "./assets/img/stars/3.jpg";
                    } else if (data["res"][i].media > 3 && data["res"][i].media <= 4) {
                        var estrela = "./assets/img/stars/4.jpg";
                    } else if (data["res"][i].media > 4 && data["res"][i].media <= 5) {
                        var estrela = "./assets/img/stars/5.jpg";
                    } else {
                        var estrela = "./assets/img/stars/1.jpg";
                    }
                    var percent_cem = 100 - percent.toFixed(2);
                    $("#type-part").html('Média das Avaliações');
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Sem Campanha" : data["res"][i].name) +
                        '</td><td>' + data["res"][i].relevancias_total +
                        '</td><td><div class="percent-star" title="'+percent.toFixed(2)+'%" style="background: url('+ estrela +')">'+
                        '<div class="cobre-estrela" style="width:'+percent_cem+'%"></div></div></td></tr>');
                }
            }

            $('.paginacao').html(data['paginacao']);

            if (val_page != null) {
                $(".paginacao li").removeClass("active")
                $(".paginacao li").each(function(){
                    var page = $(this).attr('data-page');
                    if (page == val_page) {
                        $(this, '.numbers-pag').addClass('active');
                    }
                });
            }

            /**
             * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
             * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
             */
            create_sparkline();
            $('.comp-charge-table').hide();
        }
    });
}
/* Gráfico de Reactions */
function chart_main_reactions(filter, type) {
        $('.tipo-table').html('Reactions');
        $(".status").html('<option value="react">Reactions</option><option value="category">Campanha</option><option value="group">Grupo</option><option value="post">Post</option><option value="user">Usuário</option>');
        $(".status").trigger("chosen:updated");
        var select_tipo = $('.select-graph').val();
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
        url: './adm/report/reactions_json',
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge').show();
        },
        success: function (data) {
            $('.table-statistic-rows').remove();
            for (var i = 0; data.length > i; i++) {
                //Adicionando registros retornados na tabela
                $('#table-statistic').append('<tr class="table-statistic-rows"><td>' + convertDate(data[i][0],select_tipo) + '</td><td>' + data[i][1] + '</td></tr>');
            }
            // create the chart
            if (select_tipo == 4) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_year(data, 'Quantidade de Reactions', 'Reactions', type);
            } else if(select_tipo == 3) {
                for(i=0;i < data.length;i++) {
                    data[i][0] = Date.parse(data[i][0]);
                }
                create_chart_month(data, 'Quantidade de Reactions', 'Reactions', type);
            } else if (select_tipo == 2) {
                    for(i=0;i < data.length;i++) {
                        data[i][0] = Date.parse(data[i][0]);
                    }
                create_chart(data,  'Quantidade de Reactions', 'Reactions', type,'%A, %b %e');
            } else {
                create_chart(data,  'Quantidade de Reactions', 'Reactions', type,'%A, %b %e, %H:%M');
            }

            $('.comp-charge').hide();
        }
    });
}
function chart_table_reactions(filter,offset,val_page) {
    if (offset == null) {
        var offset = '';
    }
    var status = $(".status option:selected").text();
    switch (status) {
        case 'Reactions':
            $('#order01').attr('data-orderby','react.name');
            $('#order02').attr('data-orderby','reactions_total');
            break;
        case 'Campanha':
            $('#order01').attr('data-orderby','categorypost.name');
            $('#order02').attr('data-orderby','reactions_total');
            break;
        case 'Grupo':
            $('#order01').attr('data-orderby','group.name');
            $('#order02').attr('data-orderby','reactions_total');
            break;
        case 'Post':
            $('#order01').attr('data-orderby','post.title');
            $('#order02').attr('data-orderby','reactions_total');
            break;
        case 'Usuário':
            $('#order01').attr('data-orderby','name');
            $('#order02').attr('data-orderby','reactions_total');
            break;
    }

    $('#type-title').html(status);
    $('#type-tipo').html('Reactions totais');
    $('.glyphicon').removeClass('glyphicon-sort-by-attributes').removeClass('glyphicon-sort-by-attributes-alt');
    $(".chart_table_row").remove();
    var val_status = status;
    var type = $("#table-type").val();
    $.ajax({
        type: 'POST',
        url: './adm/report/reactions_for_tables?type=' + type+'&offset='+ offset+'&page='+val_page,
        data: filter,
        dataType: 'json',
        beforeSend: function () {
            $('.comp-charge-table').show();
        },
        success: function (data) {
            var total = 0
            for (var i = 0; data["res"].length > i; i++) {
                total = parseInt(data["res"][i].reactions_total) + total;
            }
            for (var i = 0; data["res"].length > i; i++) {
                var participant = ((data["res"][i].reactions_total / total) * 100);
                var percent = Number((participant).toFixed(2))
                //Adicionando registros retornados na tabela
                if (val_status == "Usuário") {
                    $("#leader_cell").removeClass('hide');
                    var leader = data["res"][i].leader == null?'':data["res"][i].leader;
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>'+ leader +'</td>'+
                        '</td><td><a onclick="user_info(' + data["res"][i].id + ')">' + data["res"][i].name +
                        '</a></td><td><a class="table-user" data-toggle="modal" data-target="#modal-user-comments" onclick="settableuserReact('+data["res"][i].id+'),setmodalname(\'' + data["res"][i].name + '\', \''+data["res"][i].id+'\'),reset_order()">' +
                        data["res"][i].reactions_total +
                        '</a></td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                } else if (val_status == 'Reactions'){
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td><img style="width:6%" src="'+ data["res"][i].img_react +'"></td>'+
                        '<td>' +data["res"][i].reactions_total +'</td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                } else {
                    $("#leader_cell").addClass('hide');
                    $('#table-aux').append('<tr class="chart_table_row">' +
                        '<td>' + (data["res"][i].name === null ? "Sem Campanha" : data["res"][i].name) +
                        '</td><td>' + data["res"][i].reactions_total +
                        '</td><td class="union1">' + percent +
                        '%</td><td class="union2" data-sparkline="' + percent + ';"></td></tr>');
                }
            }

            $('.paginacao').html(data['paginacao']);

            if (val_page != null) {
                $(".paginacao li").removeClass("active")
                $(".paginacao li").each(function(){
                    var page = $(this).attr('data-page');
                    if (page == val_page) {
                        $(this, '.numbers-pag').addClass('active');
                    }
                });
            }

            /**
             * Create a constructor for sparklines that takes some sensible defaults and merges in the individual
             * chart options. This function is also available from the jQuery plugin as $(element).highcharts('SparkLine').
             */
            create_sparkline();
            $('.comp-charge-table').hide();
        }
    });
}
function create_chart(data, titulo1, titulo2, type, xdateformat) {
    Highcharts.stockChart('chartComment', {
        title: {
            text: titulo1
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
        tooltip: {
            xDateFormat: xdateformat
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
            name: titulo2,
            type: type,
            data: data,
            opposite: true,
            gapSize: 100,
            tooltip: {
                valueDecimals: 0,
                dateTimeLabelFormats: {
                    millisecond:"%A, %b %e, %H:%M:%S.%L",
                    second:"%A, %b %e, %H:%M:%S",
                    minute:"%A, %b %e, %H:%M",
                    hour:"%A, %b %e, %H:%M",
                    day:"%A, %b %e, %Y",
                    week:"Week from %A, %b %e, %Y",
                    month:"%B %Y",
                    year:"%Y"
                }
            },
            dataGrouping: {
                enabled: false
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

function create_chart_percent(data, titulo1, titulo2, type, xdateformat) {
    Highcharts.stockChart('chartComment', {
        title: {
            text: titulo1
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
        tooltip: {
            xDateFormat: xdateformat,
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.2f}%</b><br/>',
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
            name: titulo2,
            type: type,
            data: data,
            opposite: true,
            gapSize: 100,
            tooltip: {
                valueDecimals: 0,
                dateTimeLabelFormats: {
                    millisecond:"%A, %b %e, %H:%M:%S.%L",
                    second:"%A, %b %e, %H:%M:%S",
                    minute:"%A, %b %e, %H:%M",
                    hour:"%A, %b %e, %H:%M",
                    day:"%A, %b %e, %Y",
                    week:"Week from %A, %b %e, %Y",
                    month:"%B %Y",
                    year:"%Y"
                }
            },
            dataGrouping: {
                enabled: false
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
function create_chart_percent_year(data, titulo1, titulo2, type) {
    // create the chart
    Highcharts.stockChart('chartComment', {
        title: {
            text: titulo1
        },
        credits: {
            enabled: false
        },
        navigator: {
            xAxis: {
                minRange: 12 * 30 * 24 * 3600 * 1000,
                tickInterval: 12 * 30 * 24 * 3600 * 1000
            }
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                year: '%Y'
            },
            minRange: 12 * 30 * 24 * 3600 * 1000,
            tickInterval: 12 * 30 * 24 * 3600 * 1000
        },
        yAxis: {
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
            inputEnabled: false,
            enabled:false
        },
        tooltip: {
            xDateFormat: '%Y',
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.1f}%</b><br/>',
        },
        series: [{
            name: titulo2,
            type: type,
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
function create_chart_percent_month(data, titulo1, titulo2, type) {
    // create the chart
    Highcharts.stockChart('chartComment', {
        title: {
            text: titulo1
        },
        credits: {
            enabled: false
        },
        navigator: {
            xAxis: {
                minRange: 30 * 24 * 3600 * 1000,
                tickInterval:  30 * 24 * 3600 * 1000
            }
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%b / %y',
                year: '%Y'
            },
            minRange: 30 * 24 * 3600 * 1000,
            tickInterval: 30 * 24 * 3600 * 1000
        },
        yAxis: {
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
        tooltip: {
            xDateFormat: '%m/%Y',
            pointFormat: '<span style="color:{series.color}">{series.name}</span>: <b>{point.y:.1f}%</b><br/>'
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
            inputEnabled: false,
            enabled:false
        },
        series: [{
            name: titulo2,
            type: type,
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
function create_chart_year(data, titulo1, titulo2, type) {
    // create the chart
    Highcharts.stockChart('chartComment', {
        title: {
            text: titulo1
        },
        credits: {
            enabled: false
        },
        navigator: {
            xAxis: {
                minRange: 12 * 30 * 24 * 3600 * 1000,
                tickInterval: 12 * 30 * 24 * 3600 * 1000
            }
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: { // don't display the dummy year
                year: '%Y'
            },
            minRange: 12 * 30 * 24 * 3600 * 1000,
            tickInterval: 12 * 30 * 24 * 3600 * 1000
        },
        yAxis: {
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
            inputEnabled: false,
            enabled:false
        },
        tooltip: {
            xDateFormat: '%Y'
        },
        series: [{
            name: titulo2,
            type: type,
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
function create_chart_month(data, titulo1, titulo2, type) {
    // create the chart
    Highcharts.stockChart('chartComment', {
        title: {
            text: titulo1
        },
        credits: {
            enabled: false
        },
        navigator: {
            xAxis: {
                minRange: 30 * 24 * 3600 * 1000,
                tickInterval:  30 * 24 * 3600 * 1000
            }
        },
        xAxis: {
            type: 'datetime',
            dateTimeLabelFormats: {
                month: '%b / %y',
                year: '%Y'
            },
            minRange: 30 * 24 * 3600 * 1000,
            tickInterval: 30 * 24 * 3600 * 1000
        },
        yAxis: {
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
        tooltip: {
            xDateFormat: '%m/%Y'
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
            inputEnabled: false,
            enabled:false
        },
        series: [{
            name: titulo2,
            type: type,
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
function create_sparkline() {
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
                        zones: [ {
                            color: 'blue'
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