$(function () {
    var id = 'blueimp-gallery-' + $('meta[name="controller"]').attr('content') + '-' + $('meta[name="method"]').attr('content');

    var blueimp_modal = ''
        + '<div id="blueimp-gallery" class="blueimp-gallery ' + id + '">'
        + '<div class="slides"></div>'
        + '<h3 class="title show"></h3>'
        + '<a class="prev show">‹</a>'
        + '<a class="next show">›</a>'
        + '<a class="close show">×</a>'
        + '<a class="play-pause show"></a>'
        + '<ol class="indicator show"></ol>'
        + '</div>';

    $("body").append(blueimp_modal);
});