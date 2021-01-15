$(document).ready(function(){
   App.initialize();
});
var App = {
    initialize: function(){
        App.list.initialize();
    },
    list:{
         initialize :function() {
             $('#list-body').empty();
             $.getJSON('/carros', function (result){
                 if(result){
                     $.each(result, function(k, val){
                         App.list.row(val);
                     });
                 }
             });
         },
        row: function (car){
             let actions = App.list.actions(car.id);
             let row = `<tr>
                            <td>${car.id}</td>
                            <td>${car.marca}</td>
                            <td>${car.modelo}</td>
                            <td>${car.ano}</td>
                            <td>${actions}</td>
                         </tr>`;
            $('#list-body').append(row);
        },
        actions: function(id){
             let edit = `<a href="#!" onclick="App.edit.form.create(${id})"><i class="material-icons">edit</i></a>`
             let del = `<a href="#!" onclick="App.edit.del(${id})"><i class="material-icons" style="color:red">delete</i></a>`

            return edit + del;
        }
    },
    edit:{
        del: function(id){
            $.ajax({
                url:'/carros/' + id,
                type: 'DELETE',
                success: function(result) {
                    App.list.initialize();
                }
            });
        },
        form:{
            create: function(id){
                $.getJSON('/carros/' + id, function (result){
                    App.edit.form.build(result);
                });
            },
            build: function(car){
                let form = "#form-edit ";
                $(form + 'input[name=id]').val(car.id);
                $(form + `select[name=marca] option[value=${car.marca}]`).attr('selected','selected');
                $(form + 'input[name=modelo]').val(car.modelo);
                $(form + 'input[name=ano]').val(car.ano);
                $('#form-create').hide();
                $('#form-edit').fadeIn();
            },
            submit: function(){
                let form = "#form-edit ";
                let data = {
                    id : $(form  + 'input[name=id]').val(),
                    marca: $(form + `select[name=marca] option:selected`).val(),
                    modelo: $(form + 'input[name=modelo]').val(),
                    ano: $(form + 'input[name=ano]').val()
                }
                $.ajax({
                    url:'/carros/' + data.id,
                    type: 'PUT',
                    data: data,
                    success: function(result) {
                        $('#form-edit').hide();
                        $('#form-create').fadeIn();
                        App.list.initialize();
                    }
                });
            }
        }
    },
    create: {
        submit: function(){
            let form = "#form-create ";
            let data = {
                marca: $(form + `select[name=marca] option:selected`).val(),
                modelo: $(form + 'input[name=modelo]').val(),
                ano: $(form + 'input[name=ano]').val()
            }
            $.ajax({
                url:'/carros',
                type: 'POST',
                data: data,
                success: function(result) {
                    App.list.initialize();
                }
            });
        }
    }
}
