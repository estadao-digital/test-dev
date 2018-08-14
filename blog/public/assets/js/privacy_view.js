$(function () {
    $(".privacy-button").click(function () {
        open_privacy();
        return false;
    });
});

function open_privacy() {
    $('#forceprivacy').modal('show');
    $('#forceprivacy .modal-footer .btn').hide();
}