
<div id="carros">
    <div class="row">
        <div class="col-md-10 col-sm-12 col-lg-9">
        <h2>Test-dev</h2>
        <button id="btn-add-carro" name="btn-add-carro" class="btn btn-primary btn-xs">Adicionar um novo carro</button>
        <button id="btn-add-marca" name="btn-add-marca" class="btn btn-warning btn-xs">Adicionar uma nova marca</button>
        <button id="btn-add-modelo" name="btn-add-modelo" class="btn btn-danger btn-xs">Adicionar um novo modelo</button>
        <div>
        <!-- Inicio da tabela -->
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Ano</th>
                    </tr>
                </thead>
                <tbody id="carros-list" name="carros-list">
                    @foreach ($carros as $carro)
                    <tr id="carro{{$carro->id}}">
                        <td>{{$carro->id}}</td>
                        <td>{{$carro->marca}}</td>
                        <td>{{$carro->modelo}}</td>
                        <td>{{$carro->ano}}</td>
                        <td>
                            <button class="btn btn-success btn-xs btn-detail open-modal" value="{{ $carro->id}}">Editar</button>
                            <button class="btn btn-danger btn-xs btn-delete delete-carro" value="{{$carro->id}}">Deletar</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>


            <!-- Final da tabela -->
            <!-- Modal -->
            @include('forms.Carros')
            @include('forms.Marcas')
            @include('forms.Modelos')

        </div>
    </div>
    <meta name="_token" content="{!! csrf_token() !!}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <script src="{{asset('js/ajax-crud.js')}}"></script>
  </div>
</div>