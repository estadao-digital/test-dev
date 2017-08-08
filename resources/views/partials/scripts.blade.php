   	<!-- jQuery -->
    <script src="{{ url('js/jquery.js') }}"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ url('js/bootstrap.min.js') }}"></script>

   	<!-- Ajax customizado -->
    <script src="{{ url('js/ajax.js') }}"></script>


    <script type="text/javascript">
    
    	 $('#marca').on('change',function () {

            var idMarca = $(this).val();
            $.get('/modelos/' + idMarca, function (modelos) {
                 $('#modelo').empty();
            var i =0;
      
                $.each(modelos, function (key, modelo) {
                    
                    var size = modelo.length;
                    while(i < size){
                        $('#modelo').append('<option value=' + modelo[i].id + '>' + modelo[i].modelo + '</option>');
                        i++;
                    }          
                   
                });
            });
        });

    </script>