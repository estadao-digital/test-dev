 <div class="row">
    <div class="col s6 m4 item item-37">
                @forelse ( $cars as $car )
                <div class="card bg-secondary mb-3 max-width-20rem">
                    <div class="card-header ">{{ $car->manufacturer_name }} - {{ $car->car_name }} - {{ $car->car_model }} / {{ $car->car_year }}</div>
                    <div class="card-body">
                        <p class="card-text" >
                            <img src = '{{ $car->car_image }}' alt="{{ $car->car_name }} - {{ $car->car_model }}" class='car-photo' />
                        </p>
                        <div class="list-group">
                        <a href="#" class="list-group-item list-group-item-action bg-success color-white-definitive">
                            Editar</a>
                        <a href="#" class="list-group-item list-group-item-action bg-danger color-white-definitive">Excluir</a>
                        </div>
                    </div>
                </div>
                @empty
                    <p>Nenhum Veículo encontrado</p>
                @endforelse
    </div>
</div>
