$(document).ready(function() {

  setTable()

  $.get("marcas", function(data) {
    var options = ''

    $.each(data, function(key, value) {
      options += '<option value="'+value.id+'">'+value.nome+'</option>'
    })

    $('.select-marca').append(options)
  })

  $('#cadastrar-btn').on('click', function() {
    clearErrorMessages()
  })
})


$(".store-car").on('click', function() {

  $('#carroForm').validate({
    errorClass: 'invalid',
    onChange: false,
    onBlur: true,
    rules: {
      'carro[modelo]': {required: true},
      'carro[marca]': {required: true},
      'carro[ano]': {required: true, minlength: 4, maxlength: 4, min: 1900, max: 2020}
    },

    messages: {
      'carro[modelo]': {required: 'O campo Modelo é obrigatorio. '},
      'carro[marca]': {required: 'O campo Marca é obrigatorio. '},
      'carro[ano]': {
        required: 'O campo Ano é obrigatorio. ',
        minlength: 'O campo Ano deve ter no mínimo 4 digitos. ',
        maxlength: 'O campo Ano deve ter no mínimo 4 digitos. ',
        min: 'O campo Ano deve estar entre os anos de 1900 e 2020. ',
        max: 'O campo Ano deve estar entre os anos de 1900 e 2020. ',
      }
    },

    errorPlacement: function(error, element){
      if(element.hasClass('modelo')) {
        $('.modelo-error-create').html(error)
      }

      if(element.hasClass('marca')) {
        $('.marca-error-create').html(error)
      }

      if(element.hasClass('ano')) {
        $('.ano-error-create').html(error)
      }
    }
  })

  if ($('#carroForm').valid()) {
    carroCreate()
  }
})

// ROUTE 'carros' METHOD 'POST'
function carroCreate() {

  $.ajax({
    url: 'carros',
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
  clearErrorMessages()

  $.ajax({
    url: 'carros/'+id,
    method: 'GET',
    success: function(data) {
      $('#modalEdit_').find('.modelo').val(data.modelo)
      $('#modalEdit_').find('.marca').val(data.marca_id)
      $('#modalEdit_').find('.ano').val(data.ano)
      $('#modalEdit_').find('.carroForm').attr('url', 'carros/'+data.id)
      $('#modalEdit_').find('.carroForm').attr('id', 'carroEditForm')
      $('#modalEdit_').modal('show')
    },
    error: function(data){
      $('#modalEdit_').modal('hide')
      $('#modalError_').modal('show')
    }
  })
}


$(".update-car").on('click', function() {

  $('#carroEditForm').validate({
    errorClass: 'invalid',
    onChange: false,
    onBlur: true,
    rules: {
      'carro[modelo]': {required: true},
      'carro[marca]': {required: true},
      'carro[ano]': {required: true, minlength: 4, maxlength: 4, min: 1900, max: 2020}
    },

    messages: {
      'carro[modelo]': {required: 'O campo Modelo é obrigatorio. '},
      'carro[marca]': {required: 'O campo Marca é obrigatorio. '},
      'carro[ano]': {
        required: 'O campo Ano é obrigatorio. ',
        minlength: 'O campo Ano deve ter no mínimo 4 digitos. ',
        maxlength: 'O campo Ano deve ter no mínimo 4 digitos. ',
        min: 'O campo Ano deve estar entre os anos de 1900 e 2020. ',
        max: 'O campo Ano deve estar entre os anos de 1900 e 2020. ',
      }
    },

    errorPlacement: function(error, element){
      if(element.hasClass('modelo')) {
        $('.modelo-error-edit').html(error)
      }

      if(element.hasClass('marca')) {
        $('.marca-error-edit').html(error)
      }

      if(element.hasClass('ano')) {
        $('.ano-error-edit').html(error)
      }
    }
  })

  if ($('#carroEditForm').valid()) {
    carroUpdate()
  }
})

// ROUTE 'carros/{id}' METHOD 'PUT'
function carroUpdate() {

  $.ajax({
    url: $('#modalEdit_').find('#carroEditForm').attr('url'),
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
    url: 'carros/'+id,
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

function clearErrorMessages() {
  $('.error').each (function() {
    $(this).html('');
  })
}
