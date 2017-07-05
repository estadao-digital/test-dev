var app = (function () {
    return {
        init: function () {
            this.loadData();
            this.incluir();
            this.editar();
            this.excluir();
            this.salvar();
        },
        incluir: function () {
            $(document).on('click', '#incluir', function (e) {
                e.preventDefault();
                $('.modal').find('.modal-title').text('Carro - Novo');
                $('.modal').modal('show');
            });
        },
        editar: function () {
            $(document).on('click', '.editar', function (e) {
                e.preventDefault();
                var tr = $(this).closest('tr');
                var $form = $('.modal').find('form');

                var marca = tr.children('td:eq(1)').text();
                var modelo = tr.children('td:eq(2)').text();
                var ano = tr.children('td:eq(3)').text();

                $('#marca', $form).val(marca);
                $('#modelo', $form).val(modelo);
                $('#ano', $form).val(ano);

                $form.append($('<input/>', {
                    value: $(this).data('id'),
                    type: 'hidden',
                    name: 'id'
                }));
                $('.modal').find('.modal-title').text('Carro - Editar');
                $('.modal').modal('show');
            });
        },
        excluir: function () {
            var _this = this;
            $(document).on('click', '.excluir', function (e) {
                e.preventDefault();
                $.ajax({
                    url: '/api/carros/' + $(this).data('id'),
                    type: 'DELETE',
                    dataType: 'json',
                    success: function () {
                        _this.loadData();
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            });
        },
        salvar: function () {
            var _this = this;
            $(document).on('click', '#salvar', function (e) {
                e.preventDefault();
                var $form = $('.modal').find('form');
                if ($('input[name=id]', $form).size()) {
                    $.ajax({
                        url: '/api/carros/' + $('input[name=id]', $form).val(),
                        type: 'PUT',
                        data: $form.serialize(),
                        dataType: 'json',
                        success: function () {
                            _this.loadData();
                        },
                        error: function (error) {
                            console.log(error);
                        },
                        complete: function () {
                            _this.close();
                        }
                    });
                } else {
                    $.ajax({
                        url: '/api/carros',
                        type: 'POST',
                        data: $form.serialize(),
                        dataType: 'json',
                        success: function () {
                            _this.loadData();
                        },
                        error: function (error) {
                            console.log(error);
                        },
                        complete: function () {
                            _this.close();
                        }
                    });
                }
            });
        },
        loadData: function () {
            $.ajax({
                url: '/api/carros',
                dataType: 'json',
                success: function (data) {
                    var content = null;
                    if (!data.carros.length) {
                        content += '<tr>';
                        content += '<td colspan="5" align="center">Não há carros cadastrados</td>';
                        content += '</tr>';
                    }

                    $.each(data.carros, function (i, item) {
                        content += '<tr>';
                        content += '<td>'+i+'</td>';
                        content += '<td>'+item.marca+'</td>';
                        content += '<td>'+item.modelo+'</td>';
                        content += '<td>'+item.ano+'</td>';
                        content += '<td>' +
                            '<button type="button" class="btn btn-info editar" data-id="'+i+'">' +
                            '<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>' +
                            '</button>' +
                            '<button type="button" class="btn btn-danger excluir" data-id="'+i+'">' +
                            '<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>' +
                            '</button>' +
                        '</td>';
                        content += '</tr>';
                    });
                    $('table tbody').html(content);
                }
            })
        },
        close: function () {
            var $form = $('.modal').find('form');
            $('.modal').modal('hide');
            $form[0].reset();
        }
    }
}());

$(document).ready(function () {
   app.init();
});