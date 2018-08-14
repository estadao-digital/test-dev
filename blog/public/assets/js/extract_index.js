$(function () {
    $('#dataTable').DataTable({
        responsive: false,
        "cache": false,
        "autoWidth": true,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        }
    }).order([ 0, "desc" ]);
    $(".filter").change(function() {
        $('.now_loading').css("display", "block");
        $(this).closest("form").submit();
    });

    $(".form-filter .close-filter").click(function () {
        $(".form-filter").addClass("closed").css('padding-left', '0px');

        localStorage.setItem("extract-filter", 0);

        return false;
    });

    $(".form-filter .open-filter").click(function () {
        $(".form-filter").removeClass("closed");

        localStorage.setItem("extract-filter", 1);

        return false;
    });
    if (localStorage.getItem("extract-filter") == 1) {
        $(".form-filter .open-filter").click();
    } else {
        $(".form-filter .close-filter").click();
    }
});
