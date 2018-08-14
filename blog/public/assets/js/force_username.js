$(function () {
    $("#modal-force-username").modal('show');
    $("#modal-force-username").find('.modal-body button').click(function () {
        var $update_profile = $(".update-profile .form-profile form");
        $("#modal-force-username").modal('hide');
        $(".img-user img").click();
        $("#profile-username").val('').focus().attr('required', 'required');

        $update_profile.animate({
            scrollTop: $("#profile-username").offset().top - 150
        }, 500);

        $(".profile-force-username").addClass('force-username');
    });
});