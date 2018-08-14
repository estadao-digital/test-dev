$(function () {
    var $list_item = $('.list-store'),
        output = '';

    $.get('ws/store/get', function (data, status) {
        var store = data.store,
            money = data.money,
            $points = $(".box-1 .points-count"),
            $points_calculator = $(".box-1 .points-count-calculator"),
            output_points = '',
            output_points_calculator = '',
            store_item = '';

        get_template($points);

        output_points = fill_template($points, money);
        $points.html(output_points);

        get_template($points_calculator);

        output_points_calculator = fill_template($points_calculator, money);
        $points_calculator.html(output_points_calculator);

        for (i in store) {
            store_item = store[i];
            output += fill_template($list_item, store_item);
        }
        output = $.parseHTML(output);

        $(output).filter('.item.avaliable_true').find('.btn.buy').click(function () {
            $('#modal-avaliation' + $(this).closest('.item').data('item_id')).modal();
        });
        $(output).filter('.item.avaliable_true').find('.purchase').click(function () {

            $.post('ws/store/purchase', {
                    id: $(this).closest('.item').data('item_id'),
                },
                function (data) {
                    if (data.error) {
                        alert_box(data);
                    } else {
                        alertMsg(data.msg);
                        clear_data_score_me()
                        var storesent = data.storesent;
                        $('.item' + storesent.store_id).removeClass('my-item_false');
                        $('.item' + storesent.store_id).removeClass('avaliable_true');
                        $('.item' + storesent.store_id).addClass('my-item_true');
                        $('.item' + storesent.store_id).addClass('avaliable_false');
                    }

                    money = data.money;

                    output_points = fill_template($points, money);
                    $points.html(output_points);

                    output_points_calculator = fill_template($points_calculator, money);
                    $points_calculator.html(output_points_calculator);
                });
        });

        $list_item.prepend(output);

        $(output).find('.emojiStore').emoji({
            action: 'click mouseover',
            position: 'top-right',
            callback: function (element, contanier) {

                var $product = $(this).closest('li.item'),
                    store_id = $product.data('item_id'),
                    emoji_id = element.id,
                    $localemoji = $product.find('li.emojistore');

                $.post('ws/emojistore/save',
                    {
                        store_id: store_id,
                        emoji_id: emoji_id
                    },
                    function (data) {
                        if (data.error) {
                            alert_box(data);
                            return false;
                        } else {

                            load_emoji_store($localemoji, data.emojistore);
                        }
                    });

                contanier.hide();
            }
        });

        for (i in store) {
            var $product = $(output).filter("[data-item_id=" + store[i].id + "]"),
                $localemoji = $product.find('li.emojistore');

            load_emoji_store($localemoji, store[i].emoji);
        }

        blueimp_load($list_item);
    });

});

function load_emoji_store($localemoji, data) {
    var $localemoji = load_emoji($localemoji, data);

    if ($localemoji && $localemoji != undefined) {

        $localemoji.find('a').click(function () {

            var $product = $(this).closest('li.item'),
                store_id = $product.data('item_id'),
                emoji_id = $(this).data('emoji-id'),
                $localemoji = $product.find('li.emojistore');

            $.post('ws/emojistore/save',
                {
                    store_id: store_id,
                    emoji_id: emoji_id
                },
                function (data) {
                    if (data.error) {
                        alert_box(data);
                        return false;
                    } else {
                        load_emoji_store($localemoji, data.emojistore);
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

        return $localemoji;
    }
}

function blueimp_load(target) {
    var attrGallery = "[data-gallery]";
    var $target = (target != undefined) ? $(target).find(attrGallery) : $(attrGallery);

    $target.click(function (event) {
        event = event || window.event;
        var target = event.target || event.srcElement,
            link = target.src ? target.parentNode : target,
            options = {index: link, event: event};
        blueimp.Gallery($target, options);
        return false;
    });
}