@extends('welcome')

@section('content')
    <table class="table table-striped">
        <th colspan="5">Carros</th>
        <tr>
            <td>Código</td>
            <td>Fabricante</td>
            <td>Modelo</td>
            <td>Ano</td>
            <td>Preço</td>
        </tr>

        @foreach($carro as $value)
        <tr>
            <td>{{$value->id}}</td>
            <td>{{$value->fabricante}}</td>
            <td>{{$value->modelo}}</td>
            <td>{{$value->ano}}</td>
            <td>{{$value->preco}}</td>
        </tr>
        @endforeach
    </table>
  <div class="col-md-4">
  <table class="table table-striped">
                <th colspan="2">Cadastro de Carros</th>
                <tr>
                <tr>                
                    <td><input type="text" name="fabricante" class="form-control" placeholder="Fabricante" required="required"/></td>
                </tr>
                <tr>
                
                    <td><input type="text" name="modelo" class="form-control" placeholder="Modelo"/></td>
                </tr>
                <tr>
            
                    <td><input type="text" name="ano" class="form-control" placeholder="Ano"/></td>
                </tr>
                <tr>
            
                    <td><input type="text" name="preco" class="form-control" placeholder="Preço"/></td>
                </tr>
                <tr>            
                    <td colspan="2"><button type="submit" id="insert" class="btn btn-primary">Cadastrar os Dados</button></td>
                </tr>
            </table>
  </div>
  {{ csrf_field() }}
  <div class="col-md-4">
  <table class="table table-striped">
            <th colspan="2">Atualização dos Dados</th>
            <tr>
                <td>Selecionar o número do Carro:</td>
                <td>
                    <select name="upid" id="upid">
                        @foreach($carro as $value)
                        <option value="{{ $value->id }}"> {{ $value->id }}</option>
                        @endforeach
                    </select>
                </td>
            <tr>
        
                <td><input type="text" class="form-control" name="upfabricante" placeholder="Fabricante" required/></td>
            </tr>
            <tr>
            
                <td><input type="text" class="form-control" name="upmodelo" placeholder="Modelo" required/></td>
            </tr>
            <tr>
            
                <td><input type="text" class="form-control" name="upano" placeholder="Ano" required/></td>
            </tr>
            <tr>
        
                <td><input type="text" class="form-control" name="uppreco" placeholder="Preço" required/></td>
            </tr>
            <tr>            
                <td colspan="2"><button type="submit" id="update" class="btn btn-primary">Atualizar Dados</button></td>
            </tr>
        </table>
  </div>
  <div class="col-md-4">
  <table class="table table-striped">
        <th colspan="2">Deletar os Dados</th>
        <tr>
            <td>Selecionar o número do Carro:</td>
            <td>
                <select name="upid" id="delid">
                    @foreach($carro as $value)
                    <option value="{{ $value->id }}"> {{ $value->id }}</option>
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2"><button type="submit" id="delete" class="btn btn-primary"> Deletar os Dados </button></td>
        </tr>
    </table>
  </div>
</div>

    <!-- Ajax -->

    <script type="text/javascript">

        $('#insert').click(function(){
            $.ajax({
                type:'post',
                url: 'insertdata',
                data:{
                    '_token':$('input[name=_token').val(),
                    'fabricante':$('input[name=fabricante').val(),
                    'modelo':$('input[name=modelo').val(),
                    'ano':$('input[name=ano').val(),
                    'preco':$('input[name=preco').val(),
                },
                success:function(data){
                    window.location.reload();
                },
            });
        });

        $('#update').click(function(){
            $.ajax({
                type:'post',
                url: 'updatedata',
                data:{
                    '_token':$('input[name=_token').val(),
                    'id':$('#upid').val(),
                    'fabricante':$('input[name=upfabricante').val(),
                    'modelo':$('input[name=upmodelo').val(),
                    'ano':$('input[name=upano').val(),
                    'preco':$('input[name=uppreco').val(),                     
                },
                success:function(data){
                    window.location.reload();
                },
            });
        });


        $('#delete').click(function(){
            $.ajax({
                type:'post',
                url: 'deletedata',
                data:{
                    '_token':$('input[name=_token').val(),
                    'id':$('#delid').val(),                    
                },
                success:function(data){
                    window.location.reload();
                },
            });
        });


    </script>

@endsection