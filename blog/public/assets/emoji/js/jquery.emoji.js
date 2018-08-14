/**/

var jr_name = 'jquery-emoji-01';

if (typeof jQuery === 'undefined') {
    throw new Error('Emoji Beedoo JavaScript requires jQuery')
}

(function ($) {

    $.fn.emoji = function (options) {

        var defaults = {
            type: 'emoji',
            action: 'click mouseover',
            position: 'top', // top | left | top-left | right | top-right | bottom | bottom-left | bottom-right
            parent: null,
            callback: null,
            data: 'ws/emoji/get'
        };

        var $this = $(this);

        var settings = $.extend({}, defaults, options);

        switch (settings.type) {
            case "emoji":
                settings.emoji_categories = [];

                $this.bind(settings.action, function () {

                    $this = $(this);

                    $.fn.emoji.emoji($this, settings);

                    return false;
                });
                break;

            case "create_emoji":
                $this.bind(settings.action, function () {

                    $this = $(this);

                    var idmodal = $.fn.emoji.emoji.create($('<div/>'), settings);

                    $(idmodal).modal('show');

                    return false;
                });
                break;
        }
    };

    $.fn.emoji.emoji = function ($this, settings) {
        var class_container = ".emoji-container",
            class_position = "emoji-" + settings.position,
            html = "<div class='" + class_container.replace('.', '') + "'>" +
                "<div class='content'>" +
                "<div class='categories'>" +
                "<ul>" +
                "<li class='template'><a href='#" + jr_name + "category-{{id_category}}'><img ___src___='{{img_category}}' alt='{{name_category}}''></a></li>" +
                "</ul>" +
                "</div>" +
                "<div class='icons'>" +
                "<ul class='template' id='" + jr_name + "category-{{id_category}}'>" +
                "<li class='template icon-{{id_icon}}'><a href='#{{name_icon}}'><img ___src___='{{img_icon}}' alt='{{name_icon}}'></a></li>" +
                "</ul>" +
                "</div> " +
                "<div class='footer'><div class='clearfix'></div></div> " +
                "</div>" +
                "<span class='arrow'></span>" +
                "</div>",
            $parent = (settings.parent) ? $(settings.parent) : $this.parent(),
            $contanier = $parent.find(class_container),
            timer,
            output_category = '',
            output_categoryul = '',
            output_ul = '',
            timeout = 1000,
            position = {
                top: $this.position().top + ($this.height() / 2),
                left: $this.position().left + ($this.width() / 2)
            };

        if ($parent.css('position') == undefined) $parent.css({'position': 'relative'});

        if ($contanier.length < 1) {
            $parent.append(html);
            $contanier = $parent.find(class_container);

            $this.on("mouseleave", function () {

                timer = setTimeout(function () {
                    $contanier.hide();
                }, timeout);

            }).on("mouseenter", function () {
                clearTimeout(timer);
            });

            $contanier.on("mouseleave", function () {

                timer = setTimeout(function () {
                    $contanier.hide();
                }, timeout);

            }).on("mouseenter", function () {
                clearTimeout(timer);
            });

            if (!$contanier.is(":visible")) {

                var $listcategory = $contanier.find('.categories ul'),
                    $listcategoryul = $contanier.find('.icons'),
                    $listul,
                    output_listul;


                $.get(settings.data, function (data) {

                    if (!data) {
                    } else {

                        var emoji = data.emoji;

                        for (c in emoji) {
                            emoji[c].name_category = (emoji[c].name) ? emoji[c].name : '-';
                            emoji[c].id_category = emoji[c].id;
                            emoji[c].img_category = emoji[c].img;

                            settings.emoji_categories[c] = {
                                name_category: emoji[c].name_category,
                                id_category: emoji[c].id
                            };

                            output_category += fill_template($listcategory, emoji[c]);

                            output_categoryul += fill_template($listcategoryul, emoji[c]);

                        }

                        $listcategory.html(output_category);

                        $listcategoryul.html(output_categoryul);

                        for (c in emoji) {

                            $listul = $listcategoryul.find("#" + jr_name + "category-" + emoji[c].id_category);
                            output_listul = '';

                            for (i in emoji[c].item) {
                                var item = {};
                                item.name_icon = emoji[c].item[i].name;
                                item.img_icon = emoji[c].item[i].img;
                                item.id_icon = emoji[c].item[i].id;


                                output_listul += fill_template($listul, item);
                            }

                            $listul.html(output_listul);

                            for (i in emoji[c].item) {
                                emoji[c].item[i].code = ':' + emoji[c].item[i].name + ':';
                                $('.icon-' + emoji[c].item[i].id).data('element', emoji[c].item[i]);
                            }

                            $listul.find('a').click(function () {
                                var element = $(this).closest('li').data('element');

                                settings.callback.apply($this, [element, $contanier]);

                                return false;
                            });
                        }

                        $("li a", $listcategory).click(function (e) {
                            var id_ul = $(this).attr('href'),
                                h_ul = $(id_ul).height();

                            $contanier.find('.icons').animate({scrollTop: 0}, 0, function () {
                                $contanier.find('.icons').animate({scrollTop: $(id_ul, $listcategoryul).position().top}, 0);
                            });

                            e.preventDefault();
                        });

                        var idmodal = $.fn.emoji.emoji.create($contanier, settings);

                        $('.add-emoji').click(function () {
                            $(idmodal).modal('show');
                            return false;
                        });
                    }
                });
            }
        }

        $(class_container).hide();

        $contanier.show().css(position).addClass(class_position);

        var container_w = $contanier.width(),
            container_cw = container_w / 2,
            container_h = $contanier.height(),
            container_ch = container_h / 2,
            container_t = parseInt($contanier.css('top').replace('px', '')),
            container_l = parseInt($contanier.css('left').replace('px', '')),
            element_w = $this.width(),
            element_cw = element_w / 2,
            element_h = $this.height(),
            element_ch = element_h / 2;

        if (settings.position == 'top' || settings.position == 'top-left' || settings.position == 'top-right') {
            $contanier.css({
                'top': ((container_t - container_ch) - element_h) + 'px'
            });

            if (settings.position == 'top-left') {
                $contanier.css({
                    'left': ((container_l - container_cw) - element_w) + 'px'
                });
            }

            if (settings.position == 'top-right') {
                $contanier.css({
                    'left': ((container_l + container_cw) + element_w) + 'px'
                });
            }

        } else if (settings.position == 'bottom' || settings.position == 'bottom-left' || settings.position == 'bottom-right') {
            $contanier.css({
                'top': ((container_t - container_ch) + element_h) + 'px'
            });

            if (settings.position == 'bottom-left') {
                $contanier.css({
                    'left': ((container_l - container_cw) - element_w) + 'px'
                });
            }

            if (settings.position == 'bottom-right') {
                $contanier.css({
                    'left': ((container_l + container_cw) + element_w) + 'px'
                });

            }


        } else if (settings.position == 'left') {
            $contanier.css({
                'top': (element_h) + 'px',
                'left': ((container_l - container_cw) - element_w) + 'px'
            });

        } else if (settings.position == 'right') {
            $contanier.css({
                'top': (element_ch) + 'px',
                'left': ((container_l + container_cw) + (element_w + element_w)) + 'px'
            });

        }

    }

    $.fn.emoji.emoji.create = function ($contanier, settings) {
        var idmodal = '#modal-' + jr_name;

        var html = '<div class="modal fade ' + idmodal.replace("#", '') + '" id="' + idmodal.replace("#", '') + '" tabindex="-1" data-backdrop="static">' +
            '<div class="modal-dialog" data-keyboard="false">' +
            '<div class="modal-content">' +
            '<form name="emojiCreate" id="emojiCreate" method="emoji" enctype="multipart/form-data">' +
            '<div class="modal-header">' +
            '<h4>Upload de emoji</h4>' +
            '</div>' +
            '<div class="modal-body emoji">' +
            '<div class="row">' +
            '<div class="col-md-12">' +
            '<p>Usando a ferramenta abaixo você consegue criar Emojis personalizados, eles vão poder ser usados por qualquer um do seu time.</p>' +
            '</div>' +
            '</div>' +
            '<div class="row">' +
            '<div class="form">' +
            '<div class="col-sm-5">' +
            '<div class="item">' +
            '</div>' +
            '<div class="item">' +
            '<label>Escolha um nome</label>' +
            '<input type="text" name="name" class="form-control emoji-name" id="input-name" required>' +
            '<p class="helper">Isso é o que você vai escrever para usar o Emoji.</p>' +
            '</div>' +
            '</div>' +
            '<div class="col-sm-7">' +
            '<label>Escolha uma imagem</label>' +
            '<div class="upload">' +
            '<input type="file" class="form-control choose-image" name="img" id="emoji-file" required>' +
            '<label for="emoji" class="emoji-file">Nenhum arquivo selecionado</label>' +
            '</div>' +
            '<p class="helper">Imagens quadradas funcionam melhor. A imagem não pode ser menor que 16px em altura ou largura.</p>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="modal-footer">' +
            '<button type="button" class="btn btn-default btn-gray" data-dismiss="modal">Cancelar</button>' +
            '<input type="submit" class="btn btn-default btn-orange send-emoji" value="Salvar novo Emoji">' +
            '</div>' +
            '</form>' +
            '</div>' +
            '</div>' +
            '</div>';

        if ($(idmodal).length > 0) {
            $(idmodal).remove();
            $('.modal-backdrop').remove();
        }

        $('body').append(html);

        var $modal = $(idmodal);

        $('.emoji input[type="file"]', $modal).on('change', function (event, files, label) {
            var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '')
            $('.emoji-file').text(file_name);
        });

        $('#input-name', $modal).keypress(function (event) {
            $(this).val($(this).val().replace(/[^a-z0-9_-]/g, ''));
        });

        $('form', $modal).submit(function () {
            var $form = $(this),
                name = $('#input-name', $form).val(),
                img = $('#emoji-file', $form).val(),
                formData = new FormData(document.getElementById($form.attr('id')));

            $("input[type='submit']", $form).attr('disabled', 'disabled');

            if (name.length === 0) {
                $('#input-title', $form).addClass('error');
                $('.global-inf').prepend('<div class="alert alert-danger fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fa fa-exclamation-circle" aria-hidden="true"></i> O campo título está vazio</div>')
            } else {

                $.ajax({
                    url: 'ws/emoji/save',
                    data: formData,
                    processData: false,
                    type: 'POST',
                    contentType: false,
                    mimeType: 'multipart/form-data',
                    success: function (response, textStatus) {
                        data = $.parseJSON(response);
                        if (data.error) {
                            alert_box(data);
                            $("input[type='submit']", $form).removeAttr('disabled');
                            return false;
                        }

                        $("input[type='submit']", $form).removeAttr('disabled');

                        $modal.modal('hide');
                        $contanier.remove();
                    }
                });
            }

            return false;
        });

        $modal.on('hidden.bs.modal', function () {
            $("input[type='submit']", $form).removeAttr('disabled');
        });
        $modal.on('shown.bs.modal', function () {
            $('.emoji input[type="file"]', $modal).val('');
            $('#input-name', $modal).val('').focus();
            //$('#input-category', $modal).val('').change();
            $("label.emoji-file").text('Nenhum arquivo selecionado');
        });

        return idmodal;
    }

})(jQuery);