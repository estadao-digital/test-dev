$(function () {
    $('#date-initialdate, #date-finaldate').datetimepicker({
        locale: 'pt-br',
        format: 'YYYY-MM-DD HH:mm:00',
        ignoreReadonly: true,
        allowInputToggle: true
    });

    $("table .check a.btn-status").click(function () {
        var $input = $(this).closest('.check').find('input').click();

        if ($input.is(':checked')) {
            $(this).removeClass('btn-danger').addClass('btn-success');
        } else {
            $(this).removeClass('btn-success').addClass('btn-danger');
        }
        return false;
    });

    $("table .inverse a.btn-status").click(function() {
        var $input = $(this).closest('.inverse').find('input').click();

        if ($input.is(':checked')) {
            $(this).removeClass('btn-danger').addClass('btn-success');
        } else {
            $(this).removeClass('btn-success').addClass('btn-danger');
        }
        return false;
    });

});