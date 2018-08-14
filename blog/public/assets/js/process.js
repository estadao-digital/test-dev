$(function () {

    $('[data-toggle="tooltip"]').tooltip();

    notification_wiki();

    var time = 1000;
    setTimeout(function () {
        get_progress(time);
    }, time);
});

function update_process(data) {
    var $process = $(".notification-wiki .notification-body#process-" + data.id),
        refresh = 0,
        meta_controller_content = $("meta[name='controller']").attr('content');

    if ($process.length) {
        $process.find('p').html(data.text);
        $process.find('.progress .progress-bar').css({'width': data.progress + '%'}).find('span').text(data.progress + '%');

        if (data.progress == 100) {
            $process.addClass('notification-success');

            if (meta_controller_content == 'dashboard') {
                refresh = 5000;
            }

            if (meta_controller_content == 'dashboardexcel') {
                refresh = 5000;
            }

            if (meta_controller_content == 'dashboardmgoexcel') {
                refresh = 0;
            }

            if (refresh > 0) {
                setTimeout(function () {
                    window.location = window.location.href;
                }, refresh);
            }

        }
    } else {
        if ($(".notification-wiki").length == 0) {
            $("body").prepend("<div class=\"notification-wiki\"/>");
        }
        var $notification_wiki = $(".notification-wiki"),
            class_ = data.progress == 100 ? ' notification-success' : '';
        class_ = data.status == 2 ? class_ + ' notification-danger' : '';

        var html = "<div class=\"notification-body" + class_ + "\" data-id=\"process-" + data.id + "\" id=\"process-" + data.id + "\">" +
            "<p>" + data.text + "</p>" +
            "<a href=\"#\" class=\"close\"><span class=\"fa fa-close\"></span></a>" +
            "<div class=\"progress\">" +
            "<div class=\"progress-bar progress-bar-striped active\" role=\"progressbar\" aria-valuenow=\"100\" aria-valuemin=\"0\" aria-valuemax=\"100\" style=\"width: " + data.progress + "%\">" +
            "<span>" + data.progress + "%</span>" +
            "</div>" +
            "</div>" +
            "</div>";

        $notification_wiki.append(html);

        $notification_wiki.find("#process-" + data.id).show();
    }
}

function get_progress(time) {
    $.ajax({
        'url': './ws/process/get',
        'success': function (data) {
            var process_exists = false,
                id_exists = [];

            for (i in data) {
                update_process(data[i]);
                process_exists = true;

                id_exists[data[i].id] = data[i].id;
            }

            if (!process_exists) {

                var local_storage = findLocalItems('notification-wiki');

                for (i in local_storage) {
                    localStorage.removeItem(local_storage[i].key);
                }


            } else {
                setTimeout(function () {
                    get_progress(time);
                }, time);
            }

            var $process = $(".notification-wiki .notification-body"),
                fade_out_time = 0;

            $process.each(function (i, element) {
                fade_out_time = fade_out_time + 500;
                var id = $(element).data('id').replace('process-', '');

                if (!process_exists || jQuery.inArray(id, id_exists) === -1) {
                    $(element).fadeOut(fade_out_time, function () {
                        if ($("meta[name='controller']").attr('content') == 'dashboard') {
                            setTimeout(function () {
                                window.location = window.location.href;
                            }, time);
                        }
                    });
                }
            });
        }
    });
}

function notification_wiki() {

    var $nw = $(".notification-wiki .notification-body"),
        localStorageId = "notification-wiki-";

    $nw.each(function (i, element) {
        var id = $(element).data('id').replace('process-', '');

        if (localStorage.getItem(localStorageId + id) == undefined) {
            $nw.show();
        }

    });

    $(".notification-wiki a.close").on('click', function (e) {
        e.preventDefault();

        var $notification_body = $(this).closest(".notification-body"),
            id = $notification_body.data('id').replace('process-', ''),
            data = {id: id};

        $notification_body.hide();

        localStorage.setItem(localStorageId + id, true);

        //$.post('./ws/process/delete', data);
    });
}