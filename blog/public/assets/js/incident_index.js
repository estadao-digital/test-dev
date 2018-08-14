$(function () {
    var table = $('#dataTable').DataTable({
        responsive: true,
        "cache": false,
        "autoWidth": false,
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        },
        "columnDefs": [{
            "targets": 0,
            "orderable": false
        }],

        initComplete: function (settings) {
            $('#dataTable').colResizable({liveDrag: true});
        }

    }).order([1, "desc"]);

    $('a.toggle-vis').on('click', function (e) {
        e.preventDefault();

        // Get the column API object
        var column = table.column($(this).attr('data-column'));

        // Toggle the visibility
        column.visible(!column.visible());
    });

    $('.incident .form-filter input, .incident .form-filter select').change(function () {
        if ($(this).attr('name') != 'xls') {
            $('.now_loading').css("display", "block");
            $('.incident .form-filter input[name="xls"]').val(0);
        }

        $(this).closest('form').submit();
    });

    $('.date-filter').datetimepicker({
        locale: 'pt-br',
        format: 'YYYY-MM-DD HH:mm:00',
        ignoreReadonly: true,
        allowInputToggle: true
    }).on("dp.hide", function (e) {
        $(this).closest('form').submit();
    });


    $(".form-filter .close-filter").click(function () {
        $(".form-filter").addClass("closed").css('padding-left', '30px');
        ;

        localStorage.setItem("incident-filter", 0);

        return false;
    });

    $(".form-filter .open-filter").click(function () {
        $(".form-filter").removeClass("closed").css('padding-left', '0');

        localStorage.setItem("incident-filter", 1);

        return false;
    });

    if (localStorage.getItem("incident-filter") == 1) {
        $(".form-filter .open-filter").click();
    } else {
        $(".form-filter .close-filter").click();
    }
    action_form("#bulkaction-incident");
});

$('.icon-list ul li').click(function () {
    $('.toggle-vis > i', this).toggleClass('check-none');

});