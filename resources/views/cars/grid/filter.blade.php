{!! Form::open([ 'id' => 'form_datagrid_cars' , 'class' => 'form-inline display-none' ]) !!}
<div class="container">
  <div class="form-group row padding-top-20px ">
        {{ Form::label('name_datagrid', 'Nome:', ['class' => 'col-sm-2 col-form-label']) }}
        {!! Form::text( 'name' , null , [ 'class' => 'form-control' ,'id' => 'name_datagrid' , 'placeholder' => 'Civic' ]) !!}
        {{ Form::label('year_datagrid', 'Ano:', ['class' => 'col-sm-2 col-form-label']) }}
        {!! Form::text( 'year' , null , [ 'class' => 'form-control' ,'id' => 'year_datagrid' , 'placeholder' => '2017' ]) !!}
    </div>
    <div class='form-group row margin-top-20px'>
            {!! Form::label('form_manufacturer', 'Fabricante:' , [ 'class' => 'margin-top-10px col-sm-2 col-form-label' ] ) !!}
            {!! Form::select('manufacturer', $manufacturers , null , [ 'id' => 'form_manufacturer' , 'class' => 'form-control custom-select' ] ) !!}
    </div>
</div>
<a href="javascript:sendFormDataGrid()" class="btn btn-primary margin-top-20px bg-success">Enviar</a>
{!! Form::close() !!}
<a href="javascript:toggleFormDataGrid()" class="btn btn-primary btn-xs" name="Filtros" style="margin:0 40%">< > Filtros</a>

