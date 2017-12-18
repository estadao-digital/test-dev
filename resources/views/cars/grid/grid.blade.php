 <div class="row">
    {{--  <div class="col s6 m4 item item-37">  --}}
                @forelse ( $cars as $car )
                <div class="card bg-secondary mb-3 max-width-20rem" style="margin-right:5px;width:250px;">
                    <div class="card-header ">{{ $car->manufacturer_name }} - {{ $car->car_name }} - {{ $car->car_model }} / {{ $car->car_year }}</div>
                    <div class="card-body">
                        <p class="card-text" >
                            <img src = '{{ $car->car_image }}' alt="{{ $car->car_name }} - {{ $car->car_model }}" class='car-photo' />
                        </p>
                        <div class="list-group">
                        <a href="javascript:editItem({{ $car->car_id }},'Editar Veículo {{ $car->car_name }} - {{ $car->car_model }}')" class="list-group-item list-group-item-action bg-success color-white-definitive">
                            Editar</a>
                        <a href="javascript:confirmationDialog('400','250','Deseja Excluir o Veículo: {{$car->car_name}} / {{$car->car_model}}?','exclude({{$car->car_id}})')" class="list-group-item list-group-item-action bg-danger color-white-definitive">Excluir</a>
                        </div>
                    </div>
                </div>
                @empty
                    <p>Nenhum Veículo encontrado</p>
                @endforelse
    {{--  </div>  --}}
</div>
