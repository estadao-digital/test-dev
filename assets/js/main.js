function loadCarros() {
    $.ajax({
        type: 'GET',
        url: BASE_URL + 'carros',
        dataType: 'JSON',
        success: function(data) {
            montaLinha(data)
            editCarro()
            deleteCarro()
        }
    })
}

function montaLinha(data) {
    $.each(data, function() {
        var html = '<tr>' +
            '<td>' + this.id + '</td>' +
            '<td>' + this.marca + '</td>' +
            '<td>' + this.modelo + '</td>' +
            '<td>' + this.ano + '</td>' +
            '<td>' +
            '<a href="#" class="carro-view" data-toggle="modal" data-id="'+this.id+'" data-target="#viewCarro"><i class="fa fa-eye"></i></a>' +
            '<a href="#" class="carro-edit ml-2" data-toggle="modal" data-id="'+this.id+'" data-target="#editCarro"><i class="fa fa-pencil"></i></a>' +
            '<a href="#" class="carro-delete ml-2" data-id="'+this.id+'"><i class="fa fa-trash"></i></a>' +
            '</td>' +
            '</td>'
        $('#carros>tbody').append(html)
    })

}

function editCarro(){
    $('.carro-edit').click(function(e){
        e.preventDefault()
        var id = $(this).data('id')

        $.ajax({
            type: 'GET',
            url: BASE_URL+'carros/'+id,
            dataType: 'JSON',
            success: function(data){
                $('input[name=modelo]').val(data.modelo)
                $('input[name=ano]').val(data.ano)
                $('select[name=marca] option:selected').val(data.marca).text(data.marca)
                updateCarro(data.id)
            }
        })
    })
}

function updateCarro(id){
    $('.btn-update-carro').click(function(e){
        e.preventDefault()
        var modelo = $('input[name=modelo]').val()
        var ano = $('input[name=ano]').val()
        var marca = $('select[name=marca] option:selected').val()
                
        $.ajax({
            type: 'PUT',
            url: BASE_URL+'carros/'+id,
            data: {marca:marca, modelo:modelo, ano:ano},
            success: function(data){
                window.location.reload()
            }
        })
    })
}

function addCarro(){
    $('.btn-add-carro').click(function(e){
        e.preventDefault()
        var modelo = $('input[name=add-modelo]').val()
        var ano = $('input[name=add-ano]').val()
        var marca = $('select[name=add-marca] option:selected').val()
                
        $.ajax({
            type: 'POST',
            url: BASE_URL+'carros',
            data: {marca:marca, modelo:modelo, ano:ano},
            success: function(data){
                window.location.reload()
            }
        })
    })
}

function deleteCarro(){
    $('.carro-delete').click(function(e){
        e.preventDefault()
        var id = $(this).data('id')

        $.ajax({
            type: 'DELETE',
            url: BASE_URL+'carros/'+id,
            success: function(data){
                window.location.reload()
            }
        })
    })
}

$(function() {

    loadCarros()
    addCarro()
    
})