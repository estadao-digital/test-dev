$(function () {
    $('#dataTable').DataTable({
        "cache": false,
        "autoWidth": false,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        },
        "initComplete": function () {
            $(".page_loading").hide(0, function () {
                $table.removeClass('invisible');
            });
        }
    }).order([1, "desc"]);
});