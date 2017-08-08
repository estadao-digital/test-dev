   	<!-- jQuery -->
    <script src="{{ url('js/jquery.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('js/bootstrap.min.js') }}"></script>

   	<!-- Ajax customizado -->
    <script src="{{ url('js/ajax.js') }}"></script>


    <script type="text/javascript">
       

         $('#btn-add-carro').on('click',function () {

            $.get('/marcas/', function (marcas) {
                 $('#marcas').empty();
                $.each(marcas, function (key, marca) {
                        $('#marcas').append('<option value=' + marca.id + '>' + marca.marca + '</option>');

                });
            });
        });

         $('#btn-add-modelo').on('click',function () {

            $.get('/marcas/', function (marcas) {
                 $('#marca_modelo').empty();
                $.each(marcas, function (key, marca) {
                        $('#marca_modelo').append('<option value=' + marca.id + '>' + marca.marca + '</option>');
                        
                });
            });
        });
    
    	 $('#marcas').on('change',function () {

            var idMarca = $(this).val();
            $.get('/modelos/' + idMarca, function (modelos) {
                 $('#modelos').empty();
            var i =0;
      
                $.each(modelos, function (key, modelo) {
                    
                    var size = modelo.length;
                    while(i < size){
                        $('#modelos').append('<option value=' + modelo[i].id + '>' + modelo[i].modelo + '</option>');
                        i++;
                    }          
                   
                });
            });
        });

    </script>