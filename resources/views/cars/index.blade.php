@extends('layouts.app')
@section('content')
<div class="container">
    <div id= 'datagrid_form_search'></div>
        <div class="row">
                <div class="panel panel-default">
                    <div class="row margin-top-20px margin-bottom-20px">
                        <div class="col-lg-12">
                             <h2>Stand de Carros</h2>
                        </div>
                         <a href="javascript:newItem()" class="btn btn-primary">ADICIONAR VEÍCULO</a>
                    </div>
                    <div class="panel-body">
                       <div  id='area-datagrid-cars'></div>
                    </div>
                </div>
        </div>
</div>

<script>
    $(document).ready(function(){
        chargeDataGrid();
        chargeFormDataGrid();
    })

    chargeDataGrid = function()
    {
        $.ajax({
                type: "GET",
                url: "{{ route('grid-view') }}",
                data: $('#form_datagrid_cars').serialize(),
                dataType: "html",
                success: function(response)
                {
                    $('#area-datagrid-cars').html( response );
                },
                error: function(jqXHR, textStatus, errorThrown){
                   $('#area-datagrid-cars').html( 'Erro ao Carregar Grid' );  
                }
        });
    }
    
    chargeFormDataGrid = function()
    {
        $.ajax({
                type: "GET",
                url: "{{ route('form-grid-view') }}",
                data: null,
                dataType: "html",
                success: function(response)
                {
                    $('#datagrid_form_search').html( response );
                },
                error: function(jqXHR, textStatus, errorThrown){
                   $('#datagrid_form_search').html( 'Erro ao Carregar Form Grid' );  
                }
        });
    }

    sendFormDataGrid = function(){
        chargeDataGrid();
        toggleFormDataGrid();
    }

    toggleFormDataGrid = function(){
        $( "#form_datagrid_cars" ).toggle( 'hide' );
    }

   
    newItem = function()
    {
        $.ajax({
                type: "GET",
                url: "{{ url('car/create') }}",
                data: {},
                success: function(response)
                {
                    openModalWindow( 700 , 650 , 'Adicionar Novo Veículo' , response )
                },
                error: function(jqXHR, textStatus, errorThrown){
                   returnErr = JSON.parse(jqXHR.responseText)
                   messageError = str_replace_recursive( "\n",'<br />',returnErr.message)
                   errorDialog( 410 , 300 , messageError )
                }
        });
    }

    editItem = function( idParam , titleParam )
    {
        $.ajax({
                type: "GET",
                url: "{{ url('car/edit/') }}/"+idParam,
                data: {},
                success: function(response)
                {
                    openModalWindow( 750 , 670 , titleParam , response )
                },
                error: function(jqXHR, textStatus, errorThrown){
                   returnErr = JSON.parse(jqXHR.responseText)
                   messageError = str_replace_recursive( "\n",'<br />',returnErr.message)
                   errorDialog( 410 , 300 , messageError )
                }
        });
    }

    getImageCar = function( identify )
    {
        $.ajax({
                type: "GET",
                url: "{{ url('services/v1/fabricante/') }}/"+identify,
                data: null,
                dataType: "json",
                success: function(response)
                {
                    $('#image_location').val("{{getenv('IMAGES_CARS_LOCATION','')}}"+response.slug+'-car.jpg')
                },
                error: function(jqXHR, textStatus, errorThrown){
                   errorDialog( 410 , 300 , messageError )
                }
        });
    }

    exclude = function( idParam ){
        $.ajax({
                type: "DELETE",
                url: "{{ url('services/v1/carros/') }}/"+idParam,
                data: {
                       id: idParam,
                       _token: _token
                       },
                dataType: "json",
                success: function(response)
                {
                    successDialog( 300 , 220 , response.message , 'closeModalAndChargeFilter()' )
                },
                error: function(jqXHR, textStatus, errorThrown){
                   returnErr = JSON.parse(jqXHR.responseText)
                   messageError = str_replace_recursive( "\n",'<br />',returnErr.message)
                   errorDialog( 410 , 300 , messageError )
                }
        });
    }


    closeModalAndChargeFilter = function()
    {
        chargeDataGrid()
        closeModalPage()
        closeBlockPage()
        closeBlockPageModal()
    }


</script>

@endsection
