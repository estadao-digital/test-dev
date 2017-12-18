{!! Form::open([ 'id' => 'form_new_cars' , 'class' => 'form-control' ]) !!}
<div class="container">
  <div class="form-group row padding-top-20px ">
        {{ Form::label('name_new', 'Nome:', ['class' => 'col-sm-2 col-form-label']) }}
        {!! Form::text( 'name' , $car->name , [ 'class' => 'form-control' ,'id' => 'name_new' , 'placeholder' => 'Civic' ]) !!}
        {{ Form::label('model_new', 'Modelo:', ['class' => 'col-sm-2 col-form-label']) }}
        {!! Form::text( 'model' , $car->model , [ 'class' => 'form-control' ,'id' => 'model_new' , 'placeholder' => 'GTI' ]) !!}
        {{ Form::label('year_new', 'Ano:', ['class' => 'col-sm-2 col-form-label']) }}
        {!! Form::text( 'year' , $car->year , [ 'class' => 'form-control' ,'id' => 'year_new' , 'placeholder' => '2017' ]) !!}
        {!! Form::hidden( 'image_location' , $car->image_location , [ 'id' => 'image_location' ]) !!}
    </div>
    <div class='form-group row margin-top-20px'>
            {!! Form::label('form_manufacturer', 'Fabricante:' , [ 'class' => 'margin-top-10px col-sm-2 col-form-label' ] ) !!}
            {!! Form::select('manufacturer_id', $manufacturers , $car->manufacturer_id , [ 'id' => 'form_manufacturer' , 
                                                                          'class' => 'form-control custom-select', 
                                                                          'onchange'=> "getImageCar( $(this).val() )"] ) !!}
    </div>
</div>
<a href="javascript:sendForm()" class="btn btn-primary margin-top-20px bg-success">Enviar</a>
{!! Form::close() !!}

<script>
     function sendForm(){
        $.ajax({
                type: "PUT",
                url: "{{ url('services/v1/carros/') }}/{{$car->id}}",
                data: $('#form_new_cars').serialize(),
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
    
    

</script>