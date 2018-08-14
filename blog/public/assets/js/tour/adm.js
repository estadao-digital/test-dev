$(function () {
    $(window).load(function () {
        var images = [
            './assets/img/tour/adm/1.png',
            './assets/img/tour/adm/2.png',
            './assets/img/tour/adm/3.png',
            './assets/img/tour/adm/4.png',
            './assets/img/tour/adm/5.png',
            './assets/img/tour/adm/6.png',
            './assets/img/tour/adm/7.png',
            './assets/img/tour/adm/8.png',
            './assets/img/tour/adm/9.png',
            './assets/img/tour/adm/10.png',
            './assets/img/tour/adm/11.png',
            './assets/img/tour/adm/12.png',
            './assets/img/tour/adm/13.png',
            './assets/img/tour/adm/14.png',
            './assets/img/tour/adm/15.png',
            './assets/img/tour/adm/16.png',
            './assets/img/tour/adm/17.png',
            './assets/img/tour/adm/18.png',
        ];

        blueimp.Gallery(images, {
            closeOnEscape: false,
            closeOnSlideClick: false,
            closeOnSwipeUpOrDown: false
        });
    });
});