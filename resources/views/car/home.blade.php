@extends('layouts/app')

@section('title')
    Carros
@endsection


@section('content')
<section id="car-index">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card" id="cars-card">
                    <div class="card-header">
                        <h1 id="cars-card-title">Lista de carros</h1>
                    </div>
                    <div class="card-content">
                        <div class="text-center">
                            <div class="table-responsive">
                                <table class="table" id="cars-card-list"></table>
                            </div>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="card" id="cars-form">
                    <div class="card-header">
                        <h1 id="cars-form-title">Criar novo carro</h1>
                    </div>
                    <div class="card-content">
                        <div class="text-center">
                            <div class="row ">
                                <div class="col-xl-4 col-md-6 col-12 mb-2">
                                    <fieldset class="form-group mt-1">
                                        <label for="basicInput">Marca</label>
                                        <select class="form-control" id="brand"></select>
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-md-6 col-12 mb-1">
                                    <fieldset class="form-group mt-1">
                                        <label for="basicInput">Modelo</label>
                                        <input type="text" class="form-control round" id="model"  placeholder="Ex:Honda">
                                    </fieldset>
                                </div>
                                <div class="col-xl-4 col-md-6 col-12 mb-1">
                                    <fieldset class="form-group mt-1">
                                        <label for="basicInput">Ano</label>
                                        <input type="text" class="form-control round" id="year"  placeholder="ex: 1999" maxlength="4" >
                                    </fieldset>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6 col-md-6 col-12 mb-1">
                                    <button class="btn btn-success" style="width:80%" onclick="storeCar()" id="cars-form-action-button">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection



@section('js')

<script>

var actionButton = document.getElementById('cars-form-action-button')

listCars()//Mostra todos carros do "banco" na tela
getBrandsForSelectField()//Tras as opcoes de marca de carro "do banco dinamicamente"

function listCars() {

    clearInputFields()
    restoreSaveButton()

    document.getElementById('cars-card-title').innerHTML='Lista de Carros'
    fetch("{{ route('car.index') }}", {
        method: 'GET',
        credentials: "same-origin",
        headers: {'Content-Type':'application/json', "X-CSRF-Token": ' {{ csrf_token() }} '}
        })
        .then(response => response.json())
        .then(data => {

            addCarsToView(data)

     })
}

function addCarsToView(cars) {
    document.getElementById('cars-card-list').innerHTML = ''
    document.getElementById('cars-form-title').innerHTML = 'Criar novo carro'

    cars.forEach(function(car) {
        var row = document.createElement("tr");

        for (var [key, value] of Object.entries(car)) {

            var td = document.createElement("td");

            if (key == 'id') {
                var tt = document.createTextNode('#' + car[key]);
            } else {
                var tt = document.createTextNode(car[key]);
            }

            td.appendChild(tt);
            row.appendChild(td);
        }

        row.onclick= () => { showCar(car['id']) }
        document.getElementById('cars-card-list').appendChild(row)
    })
}

function storeCar() {

  var brand = document.getElementById('brand').value
  var model = document.getElementById('model').value
  var year = document.getElementById('year').value

  //Validação FRONTEND
  var formValidation = validateForm()
  var yearValidation = validateYear()
  if(formValidation == false || yearValidation == false) return alert('Ops...Verifique se preencheu todos campos corretamente');

  fetch("{{ route('car.store') }}", {
      method: 'POST',
      credentials: "same-origin",
      headers: {'Content-Type':'application/json', "X-CSRF-Token": ' {{ csrf_token() }} '},
      body:JSON.stringify({
          brand:brand,
          model:model,
          year:year
      })
      })
      .then(response => response.json())
      .then(data => {

          if(data == '400') return alert('Ops...Ocorreu um erro e não foi possível completar a ação');

          document.getElementById('model').value = ''
          document.getElementById('year').value = ''

          listCars()
   })

}

function showCar(id) {

    var url = "{!! route('car.show', [':id'] ) !!}".replace(':id', id);

    fetch(url, {
        method: 'GET',
        credentials: "same-origin",
        headers: {'Content-Type':'application/json', "X-CSRF-Token": ' {{ csrf_token() }} '}
        })
        .then(response => response.json())
        .then(data => {

          addSelectedCarToView(data)

     })
}

function addSelectedCarToView(selectedCar) {

    document.getElementById('cars-card-title').innerHTML=''

    var deleteButton = document.createElement("button")
    var listCarsButton = document.createElement("button")

    document.getElementById(selectedCar.brand).selected = "true"
    document.getElementById('model').value = selectedCar.model
    document.getElementById('year').value = selectedCar.year

    deleteButton.innerHTML = "Deletar";
    deleteButton.classList.add('btn')
    deleteButton.classList.add('btn-danger')
    deleteButton.onclick= () => { deleteCar(selectedCar.id) }

    listCarsButton.innerHTML='Voltar para Lista de carros'
    listCarsButton.classList.add('btn')
    listCarsButton.classList.add('btn-primary')
    listCarsButton.onclick= () => { listCars() }

    actionButton.innerHTML='Editar Carro Selecionado'
    actionButton.removeAttribute("onclick")
    actionButton.onclick = () => { updateCar(selectedCar.id) }

    document.getElementById('cars-card-title').appendChild(deleteButton);
    document.getElementById('cars-card-title').appendChild(listCarsButton);

    var car = []
    car.push(selectedCar)
    addCarsToView(car)
    document.getElementById('cars-form-title').innerHTML='Editar carro'

}

function updateCar(id) {
    var url = "{!! route('car.update', [':id'] ) !!}".replace(':id', id)

    var brand = document.getElementById('brand').value
    var model = document.getElementById('model').value
    var year = document.getElementById('year').value

    //Validação FRONTEND
    var formValidation = validateForm()
    var yearValidation = validateYear()
    if(formValidation == false || yearValidation == false) return alert('Ops...Verifique se preencheu todos campos corretamente');

    fetch(url, {
        method: 'PUT',
        credentials: "same-origin",
        headers: {'Content-Type':'application/json', "X-CSRF-Token": ' {{ csrf_token() }} '},
        body:JSON.stringify({
            brand:brand,
            model:model,
            year:year
        })
        })
        .then(response => response.json())
        .then(data => {

            if(data == '400') return alert('Ops...Ocorreu um erro e não foi possível completar a ação');

            listCars()
            clearInputFields()
            restoreSaveButton()
     })
}

function deleteCar(id) {

    var url = "{!! route('car.destroy', [':id'] ) !!}".replace(':id', id)

    fetch(url, {
        method: 'DELETE',
        credentials: "same-origin",
        headers: {'Content-Type':'application/json', "X-CSRF-Token": ' {{ csrf_token() }} '}
        })
        .then(response => response.json())
        .then(data => {
            alert('Carro deletado com sucesso')
            listCars()
            clearInputFields()
            restoreSaveButton()

     })
}

function getBrandsForSelectField() {
    fetch("{{ route('brand.index') }}", {
        method: 'GET',
        credentials: "same-origin",
        headers: {'Content-Type':'application/json', "X-CSRF-Token": ' {{ csrf_token() }} '}
        })
        .then(response => response.json())
        .then(data => {

            addOptionsToBrands(data)

     })
}

function clearInputFields() {

    document.getElementById('year').value=''
    document.getElementById('model').value=''
}

function restoreSaveButton() {
    actionButton.innerHTML='Salvar'
    actionButton.classList.remove('btn-danger')
    actionButton.classList.add('btn-success')
    actionButton.removeAttribute("onclick")
    actionButton.onclick = () => { storeCar() }
}

function addOptionsToBrands(brands) {

    Object.keys(brands).forEach(function(key) {

        var option = document.createElement("option")
        option.value = brands[key]
        option.text = brands[key]
        option.id = brands[key]
        document.getElementById('brand').appendChild(option)

    })
}

function validateForm() {
    var brand = document.getElementById('brand').value
    var model = document.getElementById('model').value
    var year = document.getElementById('year').value

    if(brand.length < 1 || model.length < 1 || year.length < 1 ) return false;

    return true
}


function validateYear() {
  var year = document.getElementById('year').value
  var text = /^[0-9]+$/;

    if (year != 0) {
        if ((year != "") && (!text.test(year))) {

            alert("Por favor insira numeros válidos");
            document.getElementById('year').value = ''
            return false;
        }

        if (year.length != 4) {
            alert("Ano inválido");
            return false;
        }

        var current_year=new Date().getFullYear();
        if((year < 1920) || (year > current_year))
            {
            alert("Ano Deve ser entre 1920 e seu ano atual");
            return false;
            }
        return true;
    }else{
      return false;
    }
}

</script>

@endsection
