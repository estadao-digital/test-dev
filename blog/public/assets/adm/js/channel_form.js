$(function () {
    var $channelprivate = $(".channel-type label input");

    $channelprivate.click(function () {
        channel_private($channelprivate);
    });
});

function channel_private($channelprivate) {
    var $channeltype = $channelprivate.closest(".channel-type");

    if ($channelprivate.is(":checked")) {
        $channeltype.addClass('checked-input');
        $("select#select-user-id").attr('required', 'required');
    } else {
        $channeltype.removeClass('checked-input');
        $("select#select-user-id").removeAttr('required');
    }
}