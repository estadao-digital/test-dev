$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
    $('#dataTable').DataTable({
        "cache": false,
        "autoWidth": false,
        "columnDefs": [{
            "targets": 0,
            "orderable": false
        }],
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        },
    }).order([1, "asc"]);
    $('.accept').click(function () {
        $.post("./adm/scales/change",
            {
                scale_id: $(this).val(),
                option: 'accept'
            },
            function(data, status){
                location.reload();
            })
    });
    $('.reject').click(function () {
        $.post("./adm/scales/change",
            {
                scale_id: $(this).val(),
                option: 'reject'
            },
            function(data, status){
                location.reload();
            })
    });
});