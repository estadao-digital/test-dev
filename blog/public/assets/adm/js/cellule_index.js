$(function () {
    $('#dataTable').DataTable({
        "cache": false,
        "autoWidth": false,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        },
        "columnDefs": [{
            "targets": [0, 2],
            "orderable": false
        }]
    }).order([1, "desc"]);

    window.onload = function () {
        $('.page_loading').hide();
    }

    action_form("#bulkaction-cellule");
    action_form_filter("#form-cellule-filter");
});