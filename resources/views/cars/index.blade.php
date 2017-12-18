@extends('layouts.app')
@section('content')
<div class="container">
    <div id= 'datagrid_form_search'></div>
    <div class="col-md-8 col-md-offset-2">
        <div class="row">
                <div class="panel panel-default">
                    <div class="row margin-top-20px margin-bottom-20px">
                        <div class="col-lg-12">
                             <h2>Stand de Carros</h2>
                        </div>
                    </div>
                    <div class="panel-body">
                       <div  id='area-datagrid-cars'></div>
                    </div>
                </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        chargeDataGrid();
        chargeFormDataGrid();
    })

    chargeDataGrid = function(){
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
    
    chargeFormDataGrid = function(){
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

</script>

@endsection
