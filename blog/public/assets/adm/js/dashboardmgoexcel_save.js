$(function () {
    var $form = $("form#post-import");
    if ($form.length > 0) {
        var data = $form.serialize();

        $.post($form.attr('action'), data, function (data) {
            if (data.error) {
                alert_box({error: [data.error]});
            } else {
                if (data.status) window.location = './adm/dashboard-mgo/importacao-de-dados';
            }
        }).fail(function (xhr, status, error) {
            alert_box({error: [error]});
        });
    }
});