$(function () {
    $(window).load(function () {
        var images = [
            './assets/img/tour/user/1.jpg',
            './assets/img/tour/user/2.jpg',
            './assets/img/tour/user/3.jpg',
            './assets/img/tour/user/4.jpg',
            './assets/img/tour/user/5.jpg',
            './assets/img/tour/user/6.jpg',
            './assets/img/tour/user/7.jpg',
            './assets/img/tour/user/8.jpg',
            './assets/img/tour/user/9.jpg',
            './assets/img/tour/user/10.jpg',
            './assets/img/tour/user/11.jpg',
            './assets/img/tour/user/12.jpg',
            './assets/img/tour/user/13.jpg',
            './assets/img/tour/user/14.jpg',
            './assets/img/tour/user/15.jpg'
        ];

        blueimp.Gallery(images, {
            closeOnEscape: false,
            closeOnSlideClick: false,
            closeOnSwipeUpOrDown: false
        });
    });
});