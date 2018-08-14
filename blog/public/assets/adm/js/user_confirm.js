$(function () {

    $('#dataTable').DataTable({
        "cache": false,
        "autoWidth": false,
        "scrollX": true,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        }
    }).order([1, "desc"]);

    $("#group-id").chosen({
        no_results_text: "Oops, grupo não encontrado!"
    });

    $("#import").submit(function () {
        $('.now_loading').css("display", "block");
    });
});