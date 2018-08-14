

function add_class(){

    quiz_default = {
        publishin: "",
        name: "",
        description: "",
        finishin: "",
        class_title: "Adicionar Carro",
        status_checked_1: 'checked=checked',
        status_1: 'active'
    };

    $quiz_content = insert_data(quiz_default, $( "#quiz-content" ).data( "var"));

    $("#post-statistic-modal").modal('show');

    $("#post-statistic-modal .modal-body .load").fadeOut(1000);

    var $quiz_content = $("#quiz-content");

    $filevideo = $quiz_content.find("#input-video");
    
    $quiz_content.find('form').submit(function (e) {

        // alert('submit intercepted');
        e.preventDefault(e);


        var data_form = $quiz_content.find('form').serialize();
		
		console.info(data_form);
		$.post('carros', data_form, function (turma) {
		
			window.location.reload();		
		});

		
        

        return false;

    });



}


function update_carro($id){


	$.get('carros/'+$id, '', function (data) {
		
		console.info('fasd') ;
		
		console.info(data) ;
		
		console.info(data.modelo);
		
		$( "#id" ).val( $id );
		$( "#modelo" ).val( data.modelo );
		$( "#ano" ).val( data.ano );
		$( "#marca" ).val( data.marca );
		
    $("#post-statistic-modal").modal('show');

    $("#post-statistic-modal .modal-body .load").fadeOut(1000);
	});
	
	
    var $quiz_content = $("#quiz-content");

    $filevideo = $quiz_content.find("#input-video");
    
    $quiz_content.find('form').submit(function (e) {

        // alert('submit intercepted');
        e.preventDefault(e);


        var data_form = $quiz_content.find('form').serialize();
		
		console.info(data_form);
		$.post('carros', data_form, function (turma) {
		
			window.location.reload();		
		});
    

        return false;

    });



}




function delete_carro($id)
{
	
		$.delete('carros', $id, function (turma) {
			window.location.reload();		
						
		});

		
	
}




$(function () {



function load_datatable_classes($table, identifier, usersettings) {

    jQuery.extend( jQuery.fn.dataTableExt.oSort, {
        "date-uk-pre": function ( a ) {
            if (a == null || a == "") {
                return 0;
            }
            var ukDatea = a.split('/');
            return (ukDatea[2] + ukDatea[1] + ukDatea[0]) * 1;
        },

        "date-uk-asc": function ( a, b ) {
            return ((a < b) ? -1 : ((a > b) ? 1 : 0));
        },

        "date-uk-desc": function ( a, b ) {
            return ((a < b) ? 1 : ((a > b) ? -1 : 0));
        }
    } );


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
        columnDefs: [
            { type: 'date-uk', targets: 7 }
        ],
        "colResize": {
            // "exclude": [0, th_total - 1],
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
        "initComplete": function () {
            $(".page_loading").hide(0, function () {
                $table.removeClass('invisible');
            });
        }
    }).order([1, "desc"]);

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

function load_table_classes() {
    var $table = $("table#table-quiz"),
        identifier = {
            reorder: "reorder-table-quiz",
            colvis: "colvis-table-quiz",
            colwidth: "colwidth-table-quiz"
        };

    var usersettings = [];
    load_datatable_classes($table, identifier, usersettings);
}



        load_table_classes();



});


function update_class(quiz_id, class_id){


    // $("#post-statistic-modal").modal('show');

    // $("#post-statistic-modal .modal-body .load").fadeOut(1000);

    $.get('http://dev.localhost/blog/public/crudintro/modal', '', function (data) {
        if (data.error) {

            alert_box(data);

            return false;
        } else {

            
            $("#post-statistic-modal").modal('show');

            $("#post-statistic-modal .modal-body .load").fadeOut(1000);


            $('#content-modal').html(data);


        }
    });
}



$.delete = function(url, data, callback, type){
 
  if ( $.isFunction(data) ){
    type = type || callback,
        callback = data,
        data = {}
  }
 
  return $.ajax({
    url: url,
    type: 'DELETE',
    success: callback,
    data: data,
    contentType: type
  });
}

$.put = function(url, data, callback, type){
 
  if ( $.isFunction(data) ){
    type = type || callback,
    callback = data,
    data = {}
  }
 
  return $.ajax({
    url: url,
    type: 'PUT',
    success: callback,
    data: data,
    contentType: type
  });
}




function insert_data(data, $quiz_content) {

    // output = fill_template($quiz_content, data, 'template-content');



    return $quiz_content;

}

