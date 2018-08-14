$(function () {
    $('#customfield').DataTable({
        responsive: true,
        "cache": false,
        "autoWidth": false,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        },
        "columnDefs": [{
            "targets": 0,
            "orderable": false
        }]
    }).order([1, "desc"]);

    window.onload = function () {
        $('.page_loading').hide();
    }

    action_form("#bulkaction-customfield");
});
function delete_customfield(id) {
    $.post('ws/customfield/delete/' + id, function (data) {
        console.log(data);
        if (data.error) {
            alert_box(data);
        } else {
            localMsg(data.customfield);
            window.location = window.location.href;
        }
    });
}