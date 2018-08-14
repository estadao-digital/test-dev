$(function () {
    $('#dataTable').DataTable({
        "cache": false,
        "autoWidth": false,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        }
    }).order([0, "desc"]);
});