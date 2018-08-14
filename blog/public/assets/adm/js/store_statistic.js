$(function () {

    var store_id = extract_url(3);

    $.post('./ws/store/statistic', {id: store_id}, function (data) {
        $(".store_statistic .title").html('Relatório de compras - ' + data.store.name);

        var dataSet = [];
        $.each(data.user, function (index, value) {
            dataSet.push({
                id: value.id,
                name: value.user_name + ' ' + value.user_lastname,
                datetime: value.datetime,
            });
        });

        $('table#store-statistic').DataTable({
            "data": dataSet,
            "language": {
                "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
            },
            "columns": [
                {"data": "id", "visible": false},
                {"data": "name"},
                {
                    "data": "datetime",
                    "render": function (data, type, row, meta) {

                        var ret = '';
                        if (data) {
                            var date = data.split(' '),
                                hour = date[1].split(':');
                            date = date[0].split('-');

                            ret = date[2] + '/' + date[1] + '/' + date[0] + ' ' + hour[0] + ':' + hour[1];

                        }
                        return ret;
                    }
                }
            ]
        });
    });
});
