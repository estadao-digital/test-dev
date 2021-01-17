@extends('layout')

@section('header')
Controle de Carros
@endsection

@section('content')

@include('flash-message')

<form method="post">
    @csrf
    <div class="row">
        <div class="col col-4">
            <label for="brand">Marca</label>
            <select id="brand" class="form-control">
                @foreach($brands as $brand)
                    <option value="{{ $brand->id }}">{{ $brand->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col col-2">
            <label for="model">Modelo</label>
            <input type="text" class="form-control" name="model" id="model">
        </div>
        <div class="col col-2">
            <label for="year">Ano</label>
            <input type="number" class="form-control" name="year" id="year">
        </div>
    </div>
    <button class="btn btn-primary mt-2" id="cadastrar">Cadastrar Carro</button>
</form>

<hr>
<h3>Listagem de Carros</h3>
<ul class="list-group">
    @foreach($cars as $car)
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <span id="carro-{{ $car->id }}"><strong>Marca:</strong> {{ $car->car_brand->name }} => <strong>Modelo:</strong> {{ $car->model }} => <strong>Ano:</strong> {{ $car->year }} </span>

        <span class="d-flex">
        <div class="input-group w-100-l" hidden id="input-carro-{{ $car->id }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label for="brand-{{ $car->id }}" class="form-label">Marca</label>
                    <select id="brand-{{ $car->id }}" class="form-control">
                        @foreach($brands as $brand)
                            <option value="{{ $brand->id }}"
                            @if ($brand->id == $car->id_brand)
                                selected
                            @endif
                            >{{ $brand->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="model-{{ $car->id }}" class="form-label">Modelo</label>
                    <input type="text" class="form-control" id="model-{{ $car->id }}" value="{{ $car->model }}">
                </div>
                <div class="col-md-2">
                    <label for="year-{{ $car->id }}" class="form-label">Ano</label>
                    <input type="text" class="form-control" id="year-{{ $car->id }}" value="{{ $car->year }}">
                </div>
                <div class="col-md-2">
                    <div class="input-group-append">
                        <button class="btn btn-primary" onclick="editarCarro({{ $car->id }})">
                            <i class="fas fa-check"></i>
                        </button>
                        @csrf
                    </div>
                </div>
            </div>
        </div>
        </span>
        <span class="d-flex">
            @auth
            <button class="btn btn-info btn-sm mr-1" onclick="toggleInput({{ $car->id }})">
                <i class="fas fa-edit"></i>
            </button>
            @endauth
            @auth
            <form method="post" action="/carros/{{ $car->id }}"
                  onsubmit="return confirm('Tem certeza que deseja remover {{ addslashes($car->model) }}?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm">
                    <i class="far fa-trash-alt"></i>
                </button>
            </form>
            @endauth
        </span>
    </li>
    @endforeach
</ul>

<script>
    document.getElementById("cadastrar").addEventListener("click", function (event) {
        event.preventDefault();

        var formData = new FormData();

        const brand = document.getElementById('brand').value;
        const model = document.getElementById('model').value;
        const year = document.getElementById('year').value;
        const token = document.querySelector(`input[name="_token"]`).value;

        formData.append('marca', brand);
        formData.append('modelo', model);
        formData.append('ano', year);
        formData.append('_token', token);

        const url = `/carros`;

        fetch(url, {
            method: 'POST',
            body: formData,
        })
        .then((body) => body.json())
        .then((data) => {
            alert(`${data.message}`);
            document.location.reload(true);
        })
        .catch((error) => console.error('Whoops! Erro:', error.message || error));
    });

    function toggleInput(carroId) {
        const nomeCarroEl = document.getElementById(`carro-${carroId}`);
        const inputCarroEl = document.getElementById(`input-carro-${carroId}`);
        if (nomeCarroEl.hasAttribute('hidden')) {
            nomeCarroEl.removeAttribute('hidden');
            inputCarroEl.hidden = true;
        } else {
            inputCarroEl.removeAttribute('hidden');
            nomeCarroEl.hidden = true;
        }
    }

    function editarCarro(carroId) {
        var formData = new FormData();

        const brand = document.getElementById(`brand-${carroId}`).value;
        const model = document.getElementById(`model-${carroId}`).value;
        const year = document.getElementById(`year-${carroId}`).value;
        const token = document.querySelector(`input[name="_token"]`).value;

        formData.append('marca', brand);
        formData.append('modelo', model);
        formData.append('ano', year);
        formData.append('_token', token);

        const url = `/carros/${carroId}`;

        fetch(url, {
            method: 'POST',
            body: formData,
        })
        .then((body) => body.json())
        .then((data) => {
            alert(`${data.message}`);
            document.location.reload(true);
        })
        .catch((error) => console.error('Whoops! Erro:', error.message || error));
    }
</script>
@endsection
