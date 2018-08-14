$(function () {
    window.onload = function () {
        $('.page_loading').hide();
    }
    load_table();
    $('#search').click(function () {
        $('#table-moderation').DataTable().ajax.reload();
    });

    $('.checkall').click(function(){
        if($('.checkall:checked').length == 0){
            $('.checkList').prop('checked', false);
            $('.mass-action').hide();
        }else{
            $('.checkList').prop('checked', true);
            $('.mass-action').show();
        }
    });

    $('#table-moderation').on('click', ".checkList",function () {
        if($('.checkList:checked').length > 0){
            $('.mass-action').show();
        }else{
            $('.mass-action').hide();
        }
    });

    $('body').on('mouseover mouseout','.multiple',function () {
        $(this).children(".multiple-item").toggleClass('hide');
    });

    $('.btn-mass-action').click(function () {
        var action = $(this).val();
        $('.send-action').attr('action',action);
        if(action == 1){
            $("#free").modal('show');
        }else{
            $("#block").modal('show');
        }
        $('.send-action').attr('type', 'many');

    });


    $('#start_date').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'pt-br',
        ignoreReadonly: true,
        allowInputToggle: true,
    });
    $('#end_date').datetimepicker({
        format: 'DD/MM/YYYY',
        locale: 'pt-br',
        ignoreReadonly: true,
        allowInputToggle: true,
    });

    var today = new Date();
    $('#start_date').data("DateTimePicker").date(new Date(today.getFullYear(), today.getMonth(), 1));
    $('#end_date').data("DateTimePicker").date(new Date(new Date(today.getFullYear(), today.getMonth() + 1, 0)));

    $(".period").chosen().change(function () {
        var today = new Date();
        var newdate = new Date();
        switch ($("#period").val()) {
            case '1':
                $("#start_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '2':
                newdate.setDate(today.getDate() - 1);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                break;
            case '3':
                $("#start_date").data("DateTimePicker").date(moment(getPreviousMonday()).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '4':
                newdate.setDate(today.getDate() - 7);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '5':
                $("#start_date").data("DateTimePicker").date(moment(new Date(today.getFullYear(), today.getMonth(), 1)).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(new Date(today.getFullYear(), today.getMonth() + 1, 0)).format('DD/MM/YYYY'));
                break;
            case '6':
                newdate.setDate(today.getDate() - 30);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '7':
                newdate.setMonth(today.getMonth() - 3);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '8':
                $("#start_date").data("DateTimePicker").date(moment(new Date(today.getFullYear(), 0, 1)).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
            case '9':
                newdate.setMonth(today.getMonth() - 12);
                $("#start_date").data("DateTimePicker").date(moment(newdate).format('DD/MM/YYYY'));
                $("#end_date").data("DateTimePicker").date(moment(today).format('DD/MM/YYYY'));
                break;
        }
    });
    //complaits_type
    $('#table-moderation').on("click",'.complaits_detail', function () {
        $.ajax({
            type: 'POST',
            url: "./adm/moderation/get_complaint_detail",
            data: {id: $(this).data('id')},
            dataType: 'json',
            success: function (data) {
                $('.type_complains').children().remove();
                $('#complaits_detail_user').children().remove();
                $.each(data.types,function () {
                    $('.type_complains').append('<li>'+this.typename+':'+ this.total +'</li>');
                });
                $.each(data.details,function () {
                    $('#complaits_detail_user').append('<tr><td>'+this.name+'</td><td>'+this.typename+'</td><td>'+ this.description +'</td><td>'+this.data+'</td></tr>');
                });
                $("#complaits_type").modal('show');
            }
        });
    });

    $('#table-moderation').on("click",'.status-change', function () {
        $('.send-action').val($(this).val());
        $('.send-action').attr('action',$(this).attr('action'));
        if($(this).attr('action') == 1){
            $("#free").modal('show');
        }else{
            $("#block").modal('show');
        }
        $('.send-action').attr('type', 'one');
    });

    $('.send-action').on("click",function () {
        if($(this).attr('type') == 'many') {
            var action = $(this).attr('action');
            $('.checkList:checked').each(function () {
                var button = $(this).val();
                $.ajax({
                    type: 'POST',
                    url: "./adm/moderation/change_status",
                    data: {id: $(this).val(), action: action, message:$("#block_message").val()},
                    dataType: 'json',
                    success: function (data) {
                        if(action == 1){
                            $('#btn'+button).attr('action', "2");
                            $('#btn'+button).removeClass("multiple-item");
                            $('#aux'+button).removeClass("multiple-item");
                            $('#btn'+button).removeClass("btn-default");
                            $('#btn'+button).removeClass("btn-danger");
                            $('#btn'+button).addClass("btn-success");
                        }else{
                            $('#btn'+button).attr('action', "1");
                            $('#btn'+button).removeClass("multiple-item");
                            $('#aux'+button).removeClass("multiple-item");
                            $('#btn'+button).removeClass("btn-default");
                            $('#btn'+button).removeClass("btn-success");
                            $('#btn'+button).addClass("btn-danger");
                        }
                    }

                });
            });
        }else if($(this).attr('type') == 'one'){
            var action = $(this).attr('action');
            var id = $(this).val();
            $.ajax({
                type: 'POST',
                url: "./adm/moderation/change_status",
                data: {id: id, action: action, message:$("#block_message").val()},
                dataType: 'json',
                success: function (data) {
                    if(action == 1){
                        $('#btn'+id).attr('action', "2");
                        $('#btn'+id).removeClass("multiple-item");
                        $('#aux'+id).removeClass("multiple-item");
                        $('#btn'+id).removeClass("btn-default");
                        $('#btn'+id).removeClass("btn-danger");
                        $('#btn'+id).addClass("btn-success");
                    }else{
                        $('#btn'+id).attr('action', "1");
                        $('#btn'+id).removeClass("multiple-item");
                        $('#aux'+id).removeClass("multiple-item");
                        $('#btn'+id).removeClass("btn-default");
                        $('#btn'+id).removeClass("btn-success");
                        $('#btn'+id).addClass("btn-danger");
                    }
                }
            });
        }
        $("#block_message").val('');
        $("#block").modal('hide');
        $("#free").modal('hide');
    });

    $(".user-filter .close-filter").click(function () {
        $(".user-filter").addClass("closed");
        $(".user-filter").removeClass("add-filter");


        localStorage.setItem("user-filter", 0);

        return false;
    });

    $(".open-filter").click(function (e) {
        e.preventDefault();
        $(".user-filter").removeClass("closed");
        $(".user-filter").addClass("add-filter");

        localStorage.setItem("user-filter", 1);
        return false;
    });

    if (localStorage.getItem("user-filter") == 1) {
        $(".user-filter .open-filter").click();
    } else {
        $(".user-filter .close-filter").click();
    }

    function getPreviousMonday() {
        var date = new Date();
        var day = date.getDay();
        var prevMonday;
        if (date.getDay() == 0) {
            prevMonday = new Date().setDate(date.getDate() - 6);
        }
        else {
            prevMonday = new Date().setDate(date.getDate() + 1 - day);
        }
        return prevMonday;
    }
});

function load_table() {
    var $table = $("table#table-moderation"),
        identifier = {
            reorder: "reorder-table-moderation",
            colvis: "colvis-table-moderation",
            colwidth: "colwidth-table-moderation"
        };

    $.post('./ws/usersettings/get', {
        identifier: identifier
    }, function (json) {
        var usersettings = [];

        for (i in identifier) {
            usersettings[identifier[i]] = json != null && json[identifier[i]] ? json[identifier[i]].data : null
        }

        load_datatable($table, identifier, usersettings);
    });
}

function load_datatable($table, identifier, usersettings) {
    var columns_data = [],
        th_total = $table.find('thead tr th').length;

    $table.find('thead tr th').each(function (i, column) {
        var column_id = i,
            $column = $(column),
            title = $column.text(),
            data = {"data": $(column).data('id')};

        $column.data('column-id', column_id);

        if (usersettings[identifier.colvis]) {
            data.visible = usersettings[identifier.colvis][column_id] == 'true';
        }

        if (usersettings[identifier.colwidth]) {
            if (usersettings[identifier.colwidth][column_id]) {
                data.width = usersettings[identifier.colwidth][column_id];
            }
        }

        if ($column.attr('width') != undefined) {
            data.width = $column.attr('width');
            $column.html('<span class="fix-width">' + title + '</span>');
            $column.find('span.fix-width').width(data.width);
        }

        columns_data.push(data);

    });

    $("form#filter").serializeArray().map(function(x){filter[x.name] = x.value;});
    var table = $table.DataTable({
        responsive: true,
        "autoWidth": false,
        "lengthMenu": [[10, 25, 50, 100, 500, 1000, -1], [10, 25, 50, 100, 500, 1000, "Todos"]],
        "sDom": 'C<"clear">RZlfrtip',
        "oColVis": {
            "aiExclude": [0, th_total - 1],
            "fnStateChange": function () {
                var data = [];

                $.each(table.columns()[0], function (i) {
                    data[$(table.column(i).header()).data('column-id')] = table.column(i).visible();
                });

                $.post('./ws/usersettings/save', {
                    identifier: identifier.colvis,
                    data: data
                });
            }
        },
        "colResize": {
            "exclude": [0, th_total - 1],
            "handleWidth": 5,
            "resizeCallback": function () {
                var data = [];

                $.each(table.columns()[0], function (i) {
                    var $column = $(table.column(i).header()),
                        width = $column.is(':visible') ? $column.width() : 10;
                    data[$column.data('column-id')] = width;
                });

                $.post('./ws/usersettings/save', {
                    identifier: identifier.colwidth,
                    data: data
                });
            }
        },
        "language": {
            "url": "assets/dataTables/plugins/i18n/Portuguese-Brasil.lang"
        },
        "columns": columns_data,
        "columnDefs": [{
            "targets": [0, th_total - 1],
            "orderable": false
        }],
        "cache": true,
        "deferRender": true,
        "serverSide": true,
        "processing": true,
        "ajax": {
            "url": 'adm/moderation/messagesfilter_json',
            "type": "POST",
            "data" :  function(d) {
                var filter = {};
                $("form#filter").serializeArray().map(function(x){filter[x.name] = x.value;});
                $('.checkall').prop('checked', false);
                $('.mass-action').hide();
                d.filter = filter;
            },
            "done": function () {
                $.each(table.columns()[0], function (i) {
                    var column_id = $(table.column(i).header()).data('column-id');
                    if (usersettings[identifier.colwidth][column_id]) {
                        $(table.column(i).header()).width(usersettings[identifier.colwidth][column_id]);
                    }

                    $(table.column(i).header()).width(usersettings[identifier.colwidth][column_id]);
                });
            },
            "dataSrc": function (json) {
                var return_data = new Array();
                for(var i=0;i< json.data.length; i++){
                    switch(json.data[i].status){
                        case 'Liberado':
                            var button_action = '<button  type="button" id="btn'+ json.data[i].id +'" value="'+ json.data[i].id +'" action="2" class="status-change btn btn-status btn-success" ></button>';
                            break;
                        case 'Bloqueado':
                            var button_action = '<button  type="button" id="btn'+ json.data[i].id +'" value="'+ json.data[i].id +'" action="1" class="status-change btn btn-status btn-danger" ></button>';
                            break;
                        case 'Analisar':
                            var button_action = '<div class="multiple"><button  type="button" id="btn'+ json.data[i].id +'" value="'+ json.data[i].id +'" class="multiple-item status-change btn btn-status btn-default" ></button>';
                            button_action += '<div  id="aux'+ json.data[i].id +'" class="btn-group multiple-item hide"><button  type="button" id="btn'+ json.data[i].id +'" value="'+ json.data[i].id +'" action="1" class="status-change btn btn-success" title="Liberar"><i class="fa fa-check" aria-hidden="true"></i></button>';
                            button_action += '<button  type="button" id="btn'+ json.data[i].id +'" value="'+ json.data[i].id +'" action="2" class="status-change btn btn-danger" title="Bloquear"><i class="fa fa-ban" aria-hidden="true"></i></button></div></div>';
                            break;
                    }
                    return_data.push({
                        'local' : json.data[i].local + ' - ' + json.data[i].title,
                        'user' : '<a href="#" onclick="user_info('+json.data[i].user_id +'); return false;">' + json.data[i].name + ' ' + json.data[i].lastname + '</a>',
                        'message' : json.data[i].message,
                        'type' : json.data[i].type,
                        'created' : json.data[i].created,
                        'checkbox': '<input type="checkbox" class="checkList" name="change_status[]" value="'+json.data[i].id+'" />',
                        'action'  : button_action,
                        'total'  : '<div class="complaits_detail" data-id="'+json.data[i].id +'">'+json.data[i].total+'</div>',
                    })
                }
                return return_data;
            }
        }
    }).order([6, "desc"]);

    // Reorder
    new $.fn.dataTable.ColReorder(table, {
        fnReorderCallback: function () {
            var data = [];

            $('thead tr th', $table).each(function (i, el) {
                if ($(el).data('column-id') != th_total - 1) {
                    data[i] = $(el).data('column-id');
                }
            });

            $.each(table.columns()[0], function (i) {
                if ($.inArray(i, data) == -1 && i != th_total - 1) {
                    data.push(i);
                }
            });

            data.push(table.columns()[0].length - 1);

            $.post('./ws/usersettings/save', {
                identifier: identifier.reorder,
                data: data
            });
        },
        iFixedColumnsLeft: 1,
        iFixedColumnsRight: 1,
        aiOrder: usersettings[identifier.reorder]
    });
}