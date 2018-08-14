$(function () {
    if ($('.main').length > 0) {
        var main = $('.main').layout({
            applyDefaultStyles: true,
            east__paneSelector: "#ui-layout-east",
            center__paneSelector: "#ui-layout-center",
            east__size: 400,
            east__minSize: 360,
            east__maxSize: .5,
            scrollToBookmarkOnLoad: false
        });

        $('.main').data('layout', main);
    }
});