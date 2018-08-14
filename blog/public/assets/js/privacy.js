$(window).load(function(){
    var forceprivacy = $('#forceprivacy');
    if(forceprivacy.length) {
        $('#forceprivacy').modal({backdrop: 'static', keyboard: false});

        $('#forceprivacy .btn-success').click(function() {
            $.get('./ws/user/acceptprivacy', function(){
                $('#forceprivacy').modal('hide');
            });
        });
        $('#forceprivacy .btn-gray').click(function() {
            window.history.back();
        });
    }
});

function open_privacy() {
    $('#forceprivacy').modal('show');
}