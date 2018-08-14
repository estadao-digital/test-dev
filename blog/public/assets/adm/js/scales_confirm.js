$(function () {
    $('#dataTable').DataTable({
        "cache": false,
        "autoWidth": false,
        responsive: true,
        "scrollX": true,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        }
    }).order([0, "asc"]);
});