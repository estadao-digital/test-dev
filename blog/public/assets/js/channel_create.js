$(function () {


    $('.privacy-botton').click(function () {
        if ($('input#myonoffswitch').is(':checked')) {
            $('.public').addClass('active');
            $('.private').removeClass('active');

        }
        else {
            $('.private').addClass('active');
            $('.public').removeClass('active')
        }

    });


    $('.select2').select2({
        placeholder: "Procurar coleguinhas",
        minimumInputLength: 1,
        ajax: {
            url: 'ws/user/get',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;

                var results = [];
                $.each(data, function (index, item) {
                    results.push({
                        id: item.id,
                        url_img: item.img,
                        text: item.name,
                        username: item.username,
                    });
                });

                return {
                    results: results,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };

            },
            cache: true
        },
        templateResult: function (data, results) {

            if (!data.id) { return data.text; }
            var $state = $(
                '<div class="icon-search">' +
                    '<div class="image"><img src="' + data.url_img + '" class="img-flag" width="60" /></div>' +
                    '<div class="text">' +
                    '<p>' + data.text + '</p>' +
                    '<p class="username">@' + data.username + '</p>' +
                    '</div>' +
                '</div>'
            );
            return $state;
        },
        escapeMarkup: function (markup) {
            return markup;
        },
    });
});