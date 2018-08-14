$(function () {

    list_item();
    list_popular_help();

    $('#help-form input').on('keyup', function () {
        search_help();
        return false;
    });

    $('#help-form').submit(function () {
        search_help();
        return false;
    });

    $("#list-all-help a").click(function () {
        $('#help-form input').val('');
        $('#help-form').closest('.help').removeClass('search');
        return false;
    });

    var hash_search = extract_url('#');
    if (hash_search) {
        hash_search = hash_search.replace("#", "");

        $('#help-form input').val(hash_search).focus().click();
        $('#help-form').submit();
    }
});

function list_item() {
    $(".load-list-categories").show();
    $.get('ws/help/category', function (data) {
        var categories = data.help_category,
            help_limit = data.help_limit,
            $categories = $('.list-categories'),
            $help = $categories.find('.list-help'),
            output_categories = '',
            output_help = [];

        create_help(categories);

        if (categories && categories.length > 0) {

            console.log(categories);

            for (i in categories) {
                var category = categories[i],
                    help = category.help,
                    id_category = '#help-category-' + category.id;
                category.limit = (help.length < help_limit);

                output_help[id_category] = '';

                category.author = (category.creator == category.modifier) ? 'Criado por <span>' + category.creator + ' ' + category.creator_lastname + '</span>' : 'Criado por <span>' + category.creator + ' ' + category.creator_lastname + '</span> <br>Editado por <span>' + category.modifier + ' ' + category.modifier_lastname + '</span>';

                if(help.length > 0){
                    output_categories += fill_template($categories, category, 'template-category');
                }


                //get_template($help, 'template-help');

                for (h in help) {
                    help[h].help_title = help[h].title;
                    output_help[id_category] += fill_template($help, help[h], 'template-help');
                }
            }
            $(".load-list-categories").hide();
            $categories.html(output_categories).show();


            if (output_help) {
                for (i in output_help) {
                    var $list_help = $categories.find(i).find('.list-help');

                    $list_help.html(output_help[i]);
                }
            }

            //edit_category($categories.find('.item'));

            $categories.find('.all').click(function () {
                var $item = $(this).closest('.item');

                if ($item.hasClass('active')) {
                    $item.removeClass('col-lg-12 active').addClass('col-lg-6');
                    $categories.find('.item').removeClass('hide');

                    $item.find('.all').text('+ Ver todos');

                } else {
                    $categories.find('.item').addClass('col-lg-6 hide');
                    $item.addClass('col-lg-12 active').removeClass('col-lg-6 hide');

                    $item.find('.all').hide().text('- Fechar');

                    var category_id = $item.data('id');

                    $.post('ws/help/category', {id: category_id}, function (data) {
                            if (data.error) {
                                alertMsg(data);
                            } else {

                                var help_category = data.help_category.help,
                                    $help_category = $categories.find("#help-category-" + data.help_category.id).find('.list-help'),
                                    output_help_category = '';

                                for (h in help_category) {
                                    help_category[h].help_title = help_category[h].title;
                                    output_help_category += fill_template($help, help_category[h], 'template-help');
                                }
                                $help_category.html(output_help_category);

                                $item.find('.all').show();
                            }
                        }
                    );

                }

                return false;
            });
        } else {
            $categories.html('<div class="gap"></div>' +
                '<h4>Bem-vindos à Wiki do Beedoo</h4>' +
                '<p>A Wiki é um projeto de base de conhecimento colaborativa. Tem como propósito fornecer um conteúdo livre, objetivo e verificável​​, que todos possam editar e melhorar.</p>' +
                '<p>Todos os editores da Wiki são voluntários. Todos podem publicar conteúdo on-line desde que sigam as regras básicas estabelecidas pela comunidade.</p>');
        }

    })
    ;
}

function list_popular_help() {
    $(".load-populars").show();
    $.get('ws/help/top', function (data) {
        var popular = data.help_top,
            $list_popular = $('.help .popular ul'),
            output_popular = '';

        if (popular) {
            var help_popular = {};
            for (i in popular) {
                help_popular.popular_link = popular[i].link;
                help_popular.popular_title = popular[i].title;
                output_popular += fill_template($list_popular, help_popular, 'template_popular');
            }
            $(".load-populars").hide();
            $list_popular.html(output_popular).show();
        }
    });
}

function search_help() {
    var data = $('#help-form').serialize(),
        $help = $('#help-form').closest('.help'),
        $input = $('#help-form input'),
        xhr;

    if (xhr && xhr.readyState != 4 && xhr.readyState != 0) xhr.abort();

    if ($input.val() == '' || $input.val() == undefined) {

        $("#list-all-help a").trigger('click');

    } else {

        $help.addClass('search');

        xhr = $.ajax({
            url: 'ws/help/get',
            data: data,
            method: 'GET',
            success: function (data) {
                var help = data.help,
                    total_help = (help.length == 1) ? help.length + " Artigo" : help.length + " Artigos",
                    $search = $(".result-search .list-search"),
                    $search_result = $search.find('.list-help'),
                    search = [],
                    output_search = '',
                    output_search_result = '';


                search[0] = {name: 'Busca por: ' + $input.val(), total_help: total_help};
                var search_result = {};
                for (s in search) {
                    search_result.search_name = search[s].name;
                    search_result.search_total = search[s].total_help;
                    output_search += fill_template($search, search_result, 'template-search');
                }
                $search.html(output_search);

                $search_result = $search.find('.list-help');

                //get_template($search_result, 'template-help');

                if (help) {
                    for (h in help) {
                        help[h].search_link     = help[h].link;
                        help[h].search_title    = help[h].title;
                        output_search_result += fill_template($search_result, help[h], 'template-help');
                    }

                    $search_result.html(output_search_result);
                }
            }
        });

    }

}