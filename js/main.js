
    $(document).ready(function () {

      let marcas = [
        {
          nome: 'Toyota',
          id: 1,
        },
        {
          nome: 'Honda',
          id: 2,
        },
        {
          nome: 'Chevrolet',
          id: 3,
        },
        {
          nome: 'Ferrari',
          id: 4,
        },
        {
          nome: 'Fiat',
          id: 5,
        },
      ]

      populaMarcas();

      listarCarros();

      $(document).on('click', '#btn-cad-carro', function () {
        criarCarro();
      })

      $(document).on('click', '.btn-delete-carro', function (e) {
        excluiCarro($(this).data('id'));
      })

      $(document).on('click', '.btn-carrega-carro', function (e) {
        carregaCarro($(this).data('id'));
      })

      $(document).on('click', '#btn-edit-save', function (e) {
        alteraCarro();
      })

      function criarCarro() {

        let dataPack = {
          marca: $("#select-marca").val(),
          modelo: $("#input-modelo").val(),
          ano: $("#input-ano").val()
        }

        $.post('controller/APIController.php', dataPack, function (response) {
          console.log(response);
          listarCarros();
        }, 'json');

      }

      function listarCarros() {

        let listagem = "";

        $.get('controller/APIController.php', function (response) {

          if (response.success) {

            $.each(response.data, function (index, carro) {

              let objMarca = marcas.find((m) => { return m["id"] == carro.marca });

              listagem += '<tr>';
              listagem += '<td>';
              listagem += index+1;
              listagem += '</td>';
              listagem += '<td>';
              listagem += carro.modelo;
              listagem += '</td>';
              listagem += '<td>';
              listagem += objMarca.nome;
              listagem += '</td>';
              listagem += '<td>';
              listagem += carro.ano;
              listagem += '</td>';
              listagem += '<td><div class="row">';
              listagem += '<div class="col-6" style="padding: 1px !important;"><button class="btn btn-danger btn-delete-carro" data-id="' + carro.id +
                '"><i class="fas fa-trash "></i></button></div>';
              listagem += '<div class="col-6" style="padding: 1px !important;"><button class="btn btn-warning btn-carrega-carro" data-id="' + carro.id +
                '"><i class="fas fa-edit"></i></button></div>';
              listagem += '</div></td>';
              listagem += '</tr>';

            });

            $("#lista-carros").empty();
            $("#lista-carros").append(listagem);

          }
        }, 'json');

      }

      function excluiCarro(idCarro) {

        $.ajax({
          url: 'controller/APIController.php/' + idCarro,
          type: 'DELETE',
          success: function (result) {
            listarCarros();
          }
        });

      }

      function carregaCarro(idCarro) {

        $.get('controller/APIController.php/' + idCarro, function (response) {

          $('#input-edt-ano').val(response.ano);
          $('#id-edt-carro').val(idCarro);
          $('#input-edt-modelo').val(response.modelo);
          $('#select-edt-marca').val(response.marca);
          
          $("#modal-editar-carro").modal('show');

        }, 'json');

      }

      function alteraCarro() {

        $.ajax({
          url: 'controller/APIController.php/' + $('#id-edt-carro').val(),
          type: 'PUT',
          contentType: 'application/json',
          data: {
            ano: $('#input-edt-ano').val(),
            modelo: $('#input-edt-modelo').val(),
            marca: $('#select-edt-marca').val(),
          },
          success: function (result) {
            $("#modal-editar-carro").modal('hide');
            listarCarros();
          }
        });

      }

      function populaMarcas() {

        $.each(marcas, function(index, marca){

          $("#select-marca").append('<option value="'+marca.id+'">'+marca.nome+'</option>');
          $("#select-edt-marca").append('<option value="'+marca.id+'">'+marca.nome+'</option>');

        });

      }
    });