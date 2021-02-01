new Vue({
    el: '#app',
    data() {
      return {
        cars: [],
        search: '',
        data: {},
        default: {
          id: '',
          brand: '',
          model: '',
          year: '',
          description: ''
        },
        titleForm: 'Adicionar Carro',
        file: ''
      }
    },
    created() {
      $.getJSON('http://localhost:8080/carros', (data) => {
        this.cars = data
      })
    },
    methods: {
      addCar() {
        this.titleForm = 'Adicionar Carro'
        this.data = this.default
        this.swal()
      },
      updateList()
      {
        $.getJSON('http://localhost:8080/carros', (data) => {
          this.cars = data
        })
      },
      editCar(id) {
        this.titleForm = 'Configurar Carro'
        this.setData(id).then(response => {
          this.data = response

          this.swal()
        })
      },
      deleteCar(id) {
        const $self = this

        Swal.fire({
          title: 'Tem certeza que deseja remover esse carro?',
          text: "Você não será capaz de reverter isso!",
          icon: 'warning',
          showCancelButton: true,
          reverseButtons: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sim, remova!',
          cancelButtonText: 'Cancelar',
          showClass: {
            popup: 'animate__animated animate__fadeIn'
          },
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: `http://localhost:8080/carros/${id}`,
              type: 'DELETE',
              success(data) {
                $self.cars = JSON.parse(data)
              }
            })
          }
        })
      },
      swal() {
        const $self = this
        Swal.fire({
          title: this.titleForm,
          html: this.getForm(),
          showCancelButton: true,
          reverseButtons: true,
          confirmButtonColor: '#28a745',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Salvar',
          cancelButtonText: 'Cancelar',
          showLoaderOnConfirm: true,
          showClass: {
            popup: 'animate__animated animate__fadeIn'
          },
          preConfirm: () => {              
            const formdata = new FormData($('#formCar')[0]);

            let options = {
              type: 'POST',
              url: 'http://localhost:8080/carros',
              data: formdata,
              processData: false,
              contentType: false
            }

            let title = 'Carro adicionado com sucesso!'
            
            if ($('#car-id').val()) {
              title = 'Carro atualizado com sucesso!'

              options = {
                type: 'PUT',
                url: 'http://localhost:8080/carros/' +  $('#car-id').val(),
                data: JSON.stringify({
                  brand: $('#brand').val(),
                  model: $('#model').val(),
                  year: $('#year').val(),
                  description: $('#description').val()
                })
              }
            }
            
            const response = new Promise(() => {
              $.ajax(options).done(data => {
                $self.updateCars(data)

                Swal.fire(title, '', 'success')
              }).fail(() => {
                Swal.showValidationMessage(
                  'Dados inválidos, por favor, preencha todos os campos!'
                )
                Swal.hideLoading()
              })
            })

            return response
          },
          allowOutsideClick: () => !Swal.isLoading()
        })
      },
      getForm() {
        let fileElement = ''

        if (!this.data.id) {
          // o método PUT não preenche a global $_FILES, sendo assim, só vou habilitar o envio do arquivo no método POST
          fileElement = `
            <div class="mb-3">
              <label for="description" class="form-label">Imagem do carro</label>
              <input type="file" name="file" class="form-control" />
            </div>`
        }

        let select = '<select name="brand" class="form-control" id="brand">'

        const brands = ['Chevrolet', 'Fiat', 'Ford', 'Honda', 'Toyota', 'Volkswagen']

        const data_brand = this.data.brand

        brands.forEach(function(brand, key) {
          const selected = (brand == data_brand) ? 'selected' : ''

          select += `<option value="${brand}" ${selected}>${brand}</option>`
        })

        select += '</select>'

        return `
          <hr />
          <form id="formCar" enctype="multipart/form-data" method="POST" class="text-left">
            <input type="hidden" name="id" id="car-id" value="${this.data.id}" />
            <div class="mb-3">
              <label for="brand" class="form-label">Marca</label>
              ${select}
            </div>
            <div class="mb-3">
              <label for="model" class="form-label">Modelo</label>
              <input type="text" name="model" value="${this.data.model}" class="form-control" id="model">
            </div>
            <div class="mb-3">
              <label for="year" class="form-label">Ano</label>
              <input type="text" name="year" value="${this.data.year}" class="form-control" id="year">
            </div>
            <div class="mb-3">
              <label for="description" class="form-label">Descrição curta</label>
              <input type="text" name="description" value="${this.data.description}" class="form-control" id="description">
            </div>
            ${fileElement}
          </form>`
      },
      setData(id) {
        return fetch(`http://localhost:8080/carros/${id}`).then(async response => {
          return await response.json()
        })
      },
      updateCars(cars) {
        this.cars = JSON.parse(cars)
      }
    },
    computed: {
      filterCars() {
        return this.cars.filter(car => {
          return car.brand.toLowerCase().indexOf(this.search.toLowerCase()) > -1 || car.model.toLowerCase().indexOf(this.search.toLowerCase()) > -1 || car.year.toLowerCase().indexOf(this.search.toLowerCase()) > -1 || car.description.toLowerCase().indexOf(this.search.toLowerCase()) > -1
        })
      }
    }
}) 
