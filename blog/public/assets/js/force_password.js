$(function () {
    $("#modal-force-password").modal('show');

    $("#modal-force-password").find('.modal-body button').click(function () {
        var $update_profile = $(".update-profile .form-profile form");

        $("#modal-force-password").modal('hide');
        $(".img-user img").click();
        $(".profile-password #profile-password").focus().attr('required', 'required');
        $(".profile-password-confirm #profile-password-confirm").attr('required', 'required');

        $(".profile-force-password").addClass('force-password');

        $update_profile.animate({scrollTop: 99999}, 500);

    });
});