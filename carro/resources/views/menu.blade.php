<div class="links">
  <ul class="nav nav-pills">
    <li class="nav-item">
      {{-- <a class="nav-link" href="{{ url('/') }}">Início</a> --}}
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('carros.index') }}">Listar</a>
    </li>
    <li class="nav-item">
      <form action="{{ route('carros.create') }}" method="get">
        @csrf
        <div class="form-group mx-sm-3 mb-2">
          <button type="submit" class="btn btn-primary">Criar</button>
        </div>
    </form>
    </li>
  </ul>


</div>