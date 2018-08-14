$(function () {
    $('.emoji input[type="file"]').on('change', function (event, files, label) {
        var file_name = this.value.replace(/\\/g, '/').replace(/.*\//, '')
        $('.emoji-file').text(file_name);
    });
});