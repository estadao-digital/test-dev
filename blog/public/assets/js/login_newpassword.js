$(function () {
    $('.form-newpassword').submit(function () {

        var password  = $('#inputPassword').val();
        var confirmPassword  = $('#inputConfirmPassword').val();
        var id = $('.newpassword .id').html();
        var hash = $('.newpassword .hash').html();

        if( password != confirmPassword){
            var data = {
                error:{
                1:"As senhas digitadas não conferem"
            }};
            alert_box(data);
            return false
        }
        else{
            $.post('ws/user/save-password',{
                    password:"" + password,
                    id:"" + id,
                    hash:""+ hash
                },
                function(data){
                    if (data.error) {
                        alert_box(data);
                        return false;
                    } else {
                        window.location = '/feed';
                        alertMsg(data.msg);
                    }
                });
        }
        return false;
    });
});
