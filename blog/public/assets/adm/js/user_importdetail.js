$(function () {
    $(".btn-group .create").click(function () {
        $("#action").attr('value',"create");
    });
    $(".btn-group .update").click(function () {
        $("#action").attr('value',"update");
    });
    $('#csv').change(function () {
        $('.now_loading').css("display", "block");
        $(this).closest("form").submit();
    });

    $('#dataTable').DataTable({
        "cache": false,
        "autoWidth": false,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        }
    }).order([]);
});