function listaCarro(){
  $.ajax({
    url: 'api.php',
    type: 'GET',
    cache: false,
    contentType: false,
    processData: false,
    success: function(data) {
      $(`#dados-carros`).html(``);
      let carros = JSON.parse(data);
      for(let carro of carros){
        let id     = carro.id
        let marca  = carro.marca
        let modelo = carro.modelo
        let ano    = carro.ano
        $(`#dados-carros`).append(`<tr>
                                      <td>${id}</td>
                                      <td>${marca}</td>
                                      <td>${modelo}</td>
                                      <td>${ano}</td>
                                      <td>
                                        <button type="button" onClick = "editarCarro(${id})" class="btn btn-outline-primary waves-effect waves-light"><i class="fas fa-edit"></i></button>
                                        <button type="button" onClick = "deleteCarro(${id})" class="btn btn-outline-danger waves-effect waves-light"><i class="fas fa-trash"></i></button>
                                      </td>
                                    </tr>`);
      }

    }
  })
}
function Listamarca(){
    $.ajax({
      url: 'functions/marcas.php',
      type: 'POST',
      cache: false,
      success: function(data) {
        $(`#marca`).html(`<option value="0">Escolha a Marca</option>`)
        let marcas = JSON.parse(data);
        for(let marca of marcas){
          let idFipe    = marca.id;
          let nomeMarca = marca.descricao;
          $(`#marca`).append(`<option value=${nomeMarca}>${nomeMarca}</option>`)
        }
      }
    })
}
function editarCarro(idCarro){
  $.ajax({
    url: `api.php?id=${idCarro}`,
    type: 'GET',
    success: function(data) {
      $(`#form-carro`).show();
      $(`#lista-carro`).hide();
      let carro = JSON.parse(data);
      let id        = carro.id
      let marca     = carro.marca
      let modelo    = carro.modelo
      let ano       = carro.ano
      $(`#marca`).val(marca)
      $(`#modelo`).val(modelo)
      $(`#ano`).val(ano)
      $(`#id_carro`).val(id)

    }
  })
}
function deleteCarro(idCarro){
  swal({
    text: `Deseja realmente excluir este cadastro?`,
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    type: "warning",
    confirmButtonText: 'OK',
  }).then(function(result) {
    if(result['value'] == true){
      $.ajax({
        url: `api.php`,
        type: 'DELETE',
        data:{id:idCarro},
        success: function(data) {
          listaCarro()
        }
      })
    }

  });

}


$(document).ready(function(){
  $(`#form-carro`).hide();
  listaCarro()
  $(`#novo-carro`).on('click',function(){
    $(`#form-carro`).show();
    $(`#lista-carro`).hide();
  })
  $(`#btn-voltar`).on('click',function(){
    $(`#form-cadastro-carro`).trigger(`reset`)
    $(`#form-carro`).hide();
    $(`#lista-carro`).show();
  })
  Listamarca()

  $('#form-cadastro-carro').submit(function(event) {
  event.preventDefault();
  var formDados = new FormData($(this)[0]);
    let check = true
    let marca          = $(`#marca`).val().trim();
    let modelo         = $(`#modelo`).val().trim();
    let ano            = $(`#ano`).val().trim();
    let idCarro        = $(`#id_carro`).val()

    if(marca =="0") {
      check = false
      swal('', 'É necessário informar a marca ', 'warning');
    }
    else if(modelo == ""){
      check = false
      swal('', 'É necessário informar o modelo ', 'warning');
    }
    else if(ano == ""){
      check = false
      swal('', 'É necessário informar o ano ', 'warning');
    }

    if(check == true){
      if(idCarro == ""){
        $.ajax({
          url: 'api.php',
          type: 'POST',
          data: formDados,
          cache: false,
          contentType: false,
          processData: false,
          success: function(data) {
              swal({
                text: `Carro cadastrado com sucesso!`,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                type: "success",
                confirmButtonText: 'OK',
              }).then(function(result) {
                  $(`#form-cadastro-carro`).trigger(`reset`)
                  $(`#form-carro`).hide();
                  listaCarro()
                  $(`#lista-carro`).show();

              });
          },
          dataType: 'html'
          });
      }
      else{
        $.ajax({
          url: 'api.php',
          type: 'PUT',
          data: formDados,
          cache: false,
          contentType: JSON,
          processData: false,
          success: function(data) {
            swal({
              text: `Carro Atualizado com sucesso!`,
              showCancelButton: false,
              confirmButtonColor: '#3085d6',
              type: "success",
              confirmButtonText: 'OK',
            }).then(function(result) {
                $(`#form-cadastro-carro`).trigger(`reset`)
                $(`#form-carro`).hide();
                listaCarro()
                $(`#lista-carro`).show();

            });
          },
          dataType: 'html'
          });
      }

    }
    return false;
  });

})
