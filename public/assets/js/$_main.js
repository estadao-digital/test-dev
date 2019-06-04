$(document).ready(function() {

  setTable()

  $.get("marcas", function(data) {
    var options = ''

    $.each(data, function(key, value) {
      options += '<option value="'+value.id+'">'+value.nome+'</option>'
    })

    $('.select-marca').append(options)
  })
})


$(".store-car").on('click', function() {
  carroCreate()
})

// ROUTE 'carros' METHOD 'POST'
function carroCreate() {

  $.ajax({
    url: main_url+'carros',
    method: 'POST',
    data: {
      modelo: $('#modalCreate_').find('.modelo').val(),
      marca: $('#modalCreate_').find('.marca').val(),
      ano: $('#modalCreate_').find('.ano').val(),
    },
    success: function(data) {
      $('#modalCreate_').find('.modelo').val('')
      $('#modalCreate_').find('.marca').val('')
      $('#modalCreate_').find('.ano').val('')
      $('#modalCreate_').modal('hide')
      $('button[name="refresh"]').click()
      setTimeout(function() {
        alert(data)
      }, 200)
    },
    error: function(data){
      $('#modalCreate_').modal('hide')
      $('#modalError_').modal('show')
    }
  })
}

// ROUTE 'carros/{id}' METHOD 'GET'
function carroEdit(id) {

  $.ajax({
    url: main_url+'carros/'+id,
    method: 'GET',
    success: function(data) {
      $('#modalEdit_').find('.modelo').val(data.modelo)
      $('#modalEdit_').find('.marca').val(data.marca_id)
      $('#modalEdit_').find('.ano').val(data.ano)
      $('#modalEdit_').find('#carroForm').attr('url', 'carros/'+data.id)
      $('#modalEdit_').modal('show')
    },
    error: function(data){
      $('#modalEdit_').modal('hide')
      $('#modalError_').modal('show')
    }
  })
}


$(".update-car").on('click', function() {
  carroUpdate()
})

// ROUTE 'carros/{id}' METHOD 'PUT'
function carroUpdate() {

  $.ajax({
    url: $('#modalEdit_').find('#carroForm').attr('url'),
    method: 'PUT',
    data: {
      modelo: $('#modalEdit_').find('.modelo').val(),
      marca: $('#modalEdit_').find('.marca').val(),
      ano: $('#modalEdit_').find('.ano').val(),
    },
    success: function(data) {
      $('#modalEdit_').modal('hide')
      $('button[name="refresh"]').click()
      setTimeout(function() {
        alert(data)
      }, 200)
    },
    error: function(data){
      $('#modalEdit_').modal('hide')
      $('#modalError_').modal('show')
    }
  })
}


// ROUTE 'carros/{id}' METHOD 'GET'
function carroDeleteGet(id) {

  $.ajax({
    url: main_url+'carros/'+id,
    method: 'GET',
    success: function(data) {
      $('#modalDelete_').find('.modelo').html(data.modelo)
      $('#modalDelete_').find('.marca').html(data.marca_nome)
      $('#modalDelete_').find('.ano').html(data.ano)
      $('#modalDelete_').find('#deleteForm').attr('url', 'carros/'+data.id)
      $('#modalDelete_').modal('show')
    },
    error: function(data){
      $('#modalDelete_').modal('hide')
      $('#modalError_').modal('show')
    }
  })
}

$(".delete-car").on('click', function() {
  carroDelete()
})

// ROUTE 'carros/{id}' METHOD 'DELETE'
function carroDelete() {
  var url = $('#modalDelete_').find('#deleteForm').attr('url')
  var id = url.split('/')

  $.ajax({
    url: $('#modalDelete_').find('#deleteForm').attr('url'),
    method: 'DELETE',
    success: function(data) {
      $('#modalDelete_').modal('hide')
      $('button[name="refresh"]').click()
      setTimeout(function() {
        alert(data)
      }, 200)
    },
    error: function(data){
      $('#modalDelete_').modal('hide')
      $('#modalError_').modal('show')
    }
  })
}
